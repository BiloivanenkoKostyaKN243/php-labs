<?php
class AuthController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->ensureRoleColumn();
        $this->ensureDemoUsers();
    }

    public function action_register(): void
    {
        if ($this->isLoggedIn()) { $this->redirect('auth/profile'); return; }
        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validateRegister($old);

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare('INSERT INTO users (login, password, email, first_name, last_name, phone, city, gender, about, role) VALUES (:login, :password, :email, :first_name, :last_name, :phone, :city, :gender, :about, :role)');
                    $stmt->execute([
                        ':login' => trim($old['login']),
                        ':password' => password_hash($old['password'], PASSWORD_DEFAULT),
                        ':email' => trim($old['email']),
                        ':first_name' => trim($old['first_name']),
                        ':last_name' => trim($old['last_name']),
                        ':phone' => trim($old['phone'] ?? ''),
                        ':city' => trim($old['city'] ?? ''),
                        ':gender' => $old['gender'] ?? '',
                        ':about' => trim($old['about'] ?? ''),
                        ':role' => 'pilot',
                    ]);
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $this->db->lastInsertId();
                    $_SESSION['user_login'] = trim($old['login']);
                    $_SESSION['user_role'] = 'pilot';
                    $_SESSION['flash_success'] = 'Реєстрація пілота завершена! Доступ до систем відкрито.';
                    $this->redirect('auth/profile');
                    return;
                } catch (PDOException $e) {
                    $errors['db'] = 'Помилка бази даних: ' . $e->getMessage();
                }
            }
        }
        $this->render('auth/register', ['errors' => $errors, 'old' => $old], 'Реєстрація пілота');
    }

    public function action_login(): void
    {
        if ($this->isLoggedIn()) { $this->redirect('auth/profile'); return; }
        $error = '';

        if ($this->request->isPost()) {
            $login = trim($this->request->post('login', ''));
            $password = $this->request->post('password', '');

            if ($login === '' || $password === '') {
                $error = 'Введіть позивний (логін) та пароль доступу.';
            } else {
                try {
                    $stmt = $this->db->prepare('SELECT * FROM users WHERE login = :login');
                    $stmt->execute([':login' => $login]);
                    $user = $stmt->fetch();
                    if ($user && password_verify($password, $user['password'])) {
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_login'] = $user['login'];
                        $_SESSION['user_role'] = $user['role'] ?? 'pilot';
                        $_SESSION['flash_success'] = 'Авторизація успішна. Вітаємо на містку!';
                        $this->redirect('auth/profile');
                        return;
                    }
                    $error = 'Невірний позивний або пароль доступу.';
                } catch (PDOException $e) {
                    $error = 'Помилка бази даних: ' . $e->getMessage();
                }
            }
        }
        $this->render('auth/login', ['error' => $error], 'Авторизація');
    }

    public function action_profile(): void
    {
        if (!$this->isLoggedIn()) { $this->redirect('auth/login'); return; }
        try {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute([':id' => $_SESSION['user_id']]);
            $user = $stmt->fetch();
        } catch (PDOException $e) { $user = null; }
        if (!$user) { $this->action_logout(); return; }
        $_SESSION['user_role'] = $user['role'] ?? 'pilot';
        $this->render('auth/profile', ['user' => $user], 'Особова справа пілота');
    }

    public function action_edit(): void
    {
        if (!$this->isLoggedIn()) { $this->redirect('auth/login'); return; }
        try {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute([':id' => $_SESSION['user_id']]);
            $user = $stmt->fetch();
        } catch (PDOException $e) { $user = null; }
        if (!$user) { $this->action_logout(); return; }
        $errors = [];
        if ($this->request->isPost()) {
            $data = $this->request->allPost();
            $errors = $this->validateEdit($data, $user);
            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare('UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, phone = :phone, city = :city, gender = :gender, about = :about WHERE id = :id');
                    $stmt->execute([
                        ':email' => trim($data['email']), ':first_name' => trim($data['first_name']), ':last_name' => trim($data['last_name']),
                        ':phone' => trim($data['phone'] ?? ''), ':city' => trim($data['city'] ?? ''), ':gender' => $data['gender'] ?? '',
                        ':about' => trim($data['about'] ?? ''), ':id' => $user['id'],
                    ]);
                    $_SESSION['flash_success'] = 'Дані пілота оновлено в бортовій мережі!';
                    $this->redirect('auth/profile');
                    return;
                } catch (PDOException $e) { $errors['db'] = 'Помилка оновлення БД: ' . $e->getMessage(); }
            }
            $user = array_merge($user, $data);
        }
        $this->render('auth/edit', ['user' => $user, 'errors' => $errors], 'Редагувати профіль пілота');
    }

    public function action_logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['user_login'], $_SESSION['user_role']);
        session_regenerate_id(true);
        $_SESSION['flash_success'] = 'Доступ заблоковано. Системи переведено в черговий режим.';
        $this->redirect('index/main');
    }

    public function action_delete(): void
    {
        if (!$this->isLoggedIn()) { $this->redirect('auth/login'); return; }
        if ($this->request->isPost()) {
            try {
                $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
                $stmt->execute([':id' => $_SESSION['user_id']]);
                unset($_SESSION['user_id'], $_SESSION['user_login'], $_SESSION['user_role']);
                session_regenerate_id(true);
                $_SESSION['flash_success'] = 'Запис пілота назавжди видалено з бортового реєстру.';
            } catch (PDOException $e) { $_SESSION['flash_success'] = 'Не вдалося видалити запис.'; }
            $this->redirect('index/main');
            return;
        }
        $this->render('auth/delete', [], 'Анулювання ліцензії');
    }

    private function isLoggedIn(): bool { return isset($_SESSION['user_id']); }

    private function ensureRoleColumn(): void
    {
        $columns = $this->db->query('PRAGMA table_info(users)')->fetchAll();
        foreach ($columns as $column) {
            if (($column['name'] ?? '') === 'role') { return; }
        }
        $this->db->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'pilot'");
    }

    private function ensureDemoUsers(): void
    {
        // Важливо: password_hash() навмисно повільний.
        // Раніше він виконувався при кожному відкритті профілю/редагування,
        // навіть коли демо-акаунти вже існували. Через це сторінки довго вантажились.
        $demoUsers = [
            'admin' => ['admin123', 'admin@space.engine', 'Admin', 'Commander', 'Orbital Station', 'male', 'Повний доступ до керування системою.', 'admin'],
            'pilot' => ['pilot123', 'pilot@space.engine', 'Pilot', 'Explorer', 'Mars Base', 'male', 'Звичайний користувач для роботи з модулями.', 'pilot'],
            'viewer' => ['viewer123', 'viewer@space.engine', 'Viewer', 'Observer', 'Lunar Outpost', 'female', 'Перегляд матеріалів без керування.', 'viewer'],
        ];

        $existingStmt = $this->db->query("SELECT login FROM users WHERE login IN ('admin', 'pilot', 'viewer')");
        $existing = $existingStmt ? $existingStmt->fetchAll(PDO::FETCH_COLUMN) : [];
        $existing = array_flip($existing);

        $stmt = $this->db->prepare('INSERT INTO users (login, password, email, first_name, last_name, city, gender, about, role) VALUES (:login, :password, :email, :first_name, :last_name, :city, :gender, :about, :role)');
        foreach ($demoUsers as $login => $user) {
            if (isset($existing[$login])) {
                continue;
            }
            $stmt->execute([
                ':login' => $login,
                ':password' => password_hash($user[0], PASSWORD_DEFAULT),
                ':email' => $user[1],
                ':first_name' => $user[2],
                ':last_name' => $user[3],
                ':city' => $user[4],
                ':gender' => $user[5],
                ':about' => $user[6],
                ':role' => $user[7],
            ]);
        }
    }

    private function validateRegister(array $data): array
    {
        $errors = [];
        $login = trim($data['login'] ?? '');
        if ($login === '') { $errors['login'] = 'Позивний пілота є обов\'язковим.'; }
        elseif (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $login)) { $errors['login'] = 'Позивний: від 3 до 30 символів (латиниця, цифри, підкреслення).'; }
        else {
            $stmt = $this->db->prepare('SELECT id FROM users WHERE login = :login');
            $stmt->execute([':login' => $login]);
            if ($stmt->fetch()) { $errors['login'] = 'Цей позивний вже зареєстрований у базі флоту.'; }
        }
        $password = $data['password'] ?? '';
        $len = function_exists('mb_strlen') ? mb_strlen($password) : strlen($password);
        if ($password === '') { $errors['password'] = 'Пароль доступу є обов\'язковим.'; }
        elseif ($len < 6) { $errors['password'] = 'Шифр доступу має містити не менше 6 символів.'; }
        if ($password !== ($data['password_confirm'] ?? '')) { $errors['password_confirm'] = 'Шифри підтвердження не збігаються.'; }
        $email = trim($data['email'] ?? '');
        if ($email === '') { $errors['email'] = 'Контактний E-mail є обов\'язковим.'; }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Некоректна адреса міжпланетного E-mail.'; }
        if (trim($data['first_name'] ?? '') === '') { $errors['first_name'] = "Ім'я є обов'язковим."; }
        if (trim($data['last_name'] ?? '') === '') { $errors['last_name'] = 'Прізвище є обов\'язковим.'; }
        return $errors;
    }

    private function validateEdit(array $data, array $currentUser): array
    {
        $errors = [];
        $email = trim($data['email'] ?? '');
        if ($email === '') { $errors['email'] = 'E-mail є обов\'язковим.'; }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Некоректний формат E-mail.'; }
        if (trim($data['first_name'] ?? '') === '') { $errors['first_name'] = "Ім'я є обов'язковим."; }
        if (trim($data['last_name'] ?? '') === '') { $errors['last_name'] = 'Прізвище є обов\'язковим.'; }
        return $errors;
    }
}
