<div class="page-home">
    <div class="page-header text-center" style="margin-bottom: 40px;">
        <h1 style="font-size: 2.5rem; margin-bottom: 10px; letter-spacing: 1px;">SPACE ENGINE DASHBOARD</h1>
        <p class="page-subtitle" style="font-size: 1.1rem; color: var(--primary);">
            <?= __('admin_panel') ?>: CRUD Users, Products, Invoices, DataTables, i18n та тестова пошта.
        </p>
    </div>

    <!-- Main Game Launcher -->
    <div class="panel text-center" style="border-color: var(--border-color); padding: 30px; margin-bottom: 40px;">
        <h2 style="color: #fff; margin-bottom: 12px; font-size: 1.5rem;">3D SPACE FLIGHT SIMULATOR</h2>
        <p class="text-muted" style="margin-bottom: 20px; max-width: 650px; margin-left: auto; margin-right: auto; font-size: 1rem;">
            Інтерактивний тривимірний симулятор польоту в реальному часі на базі Three.js.
        </p>
        <a href="index.php?route=space/intro" class="btn" style="padding: 12px 30px; font-size: 1rem; border-radius: 4px;">Запустити симулятор</a>
    </div>

    <h2 style="font-size: 1.3rem; margin-bottom: 20px; color: var(--primary); text-transform: uppercase; letter-spacing: 0.5px;">Бортові системи</h2>

    <div class="card-grid">
        <!-- Guestbook / Transmission Log -->
        <div class="card">
            <h3 class="card__title">Журнал зв'язку</h3>
            <p class="card__text">
                Перегляд та надсилання повідомлень екіпажу. Робота з файловим сховищем <code>data/comments.txt</code>.
            </p>
            <a href="index.php?route=guestbook/index" class="btn btn--small">Відкрити журнал</a>
        </div>

        <!-- File Upload / Telemetry -->
        <div class="card">
            <h3 class="card__title">Астрономічні знімки</h3>
            <p class="card__text">
                Завантаження та аналіз телеметричних знімків. Валідація MIME-типів та розмірів (до 5 МБ).
            </p>
            <a href="index.php?route=upload/index" class="btn btn--small">Перейти до галереї</a>
        </div>

        <!-- Directories / Folders -->
        <div class="card">
            <h3 class="card__title">Папки користувачів</h3>
            <p class="card__text">
                Створення ізольованих сховищ для пілотів з автоматичною структурою папок (video, music, photo) та захистом.
            </p>
            <a href="index.php?route=folder/create" class="btn btn--small">Керувати папками</a>
        </div>

        <!-- Database CRUD / Technical Library -->
        <div class="card">
            <h3 class="card__title">Технічна бібліотека</h3>
            <p class="card__text">
                База даних специфікацій космічних систем. Повна підтримка CRUD-операцій через PDO та prepared statements.
            </p>
            <a href="index.php?route=book/list" class="btn btn--small">Переглянути бібліотеку</a>
        </div>

        <!-- Authentication Terminal -->
        <div class="card">
            <h3 class="card__title">Реєстр пілотів</h3>
            <p class="card__text">
                Реєстрація пілотів, авторизація, ведення особових справ, редагування профілю та видалення облікових записів.
            </p>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?route=auth/profile" class="btn btn--small">Мій профіль</a>
            <?php else: ?>
                <a href="index.php?route=auth/login" class="btn btn--small">Увійти в систему</a>
            <?php endif; ?>
        </div>

        <!-- Visor & HUD Settings -->
        <div class="card">
            <h3 class="card__title">Налаштування інтерфейсу</h3>
            <p class="card__text">
                Оберіть колір світлофільтра візора (сесії) та налаштуйте протокол персонального привітання (куки).
            </p>
            <div style="display: flex; gap: 10px;">
                <a href="index.php?route=settings/color" class="btn btn--small btn--secondary">Колір візора</a>
                <a href="index.php?route=settings/greeting" class="btn btn--small btn--secondary">Привітання</a>
            </div>
        </div>
    </div>

    <!-- Legacy / Test sections -->
    <div class="panel" style="margin-top: 40px;">
        <h2 style="font-size: 1.1rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">Тестування та діагностика</h2>
        <p class="text-muted" style="margin-bottom: 16px; font-size: 0.9rem;">
            Форми та аналізатори з попередніх версій системи:
        </p>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="index.php?route=regform/form" class="btn btn--small btn--secondary">Реєстраційна анкета (ЛР3)</a>
            <a href="index.php?route=reqview/showrequest" class="btn btn--small btn--secondary">Аналізатор запиту HTTP</a>
        </div>
    </div>
</div>