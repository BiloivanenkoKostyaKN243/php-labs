<?php
const ST_002 = 'ST-002';
require_once __DIR__ . '/layout.php';

class Student
{
    public string $name;
    public string $studentId;
    public float $grade;
}

$student1 = new Student();
$student1->name = 'Іван Петренко';
$student1->studentId = 'ST-001';
$student1->grade = 4.5;

$student2 = new Student();
$student2->name = 'Олена Коваленко';
$student2->studentId = ST_002;
$student2->grade = 3.8;

$student3 = new Student();
$student3->name = 'Богдан Ткаченко';
$student3->studentId = 'ST-003';
$student3->grade = 4.2;

$students = [
        ['obj' => $student1, 'avatar' => 'avatar-indigo', 'initial' => 'І'],
        ['obj' => $student2, 'avatar' => 'avatar-green',  'initial' => 'О'],
        ['obj' => $student3, 'avatar' => 'avatar-amber',  'initial' => 'Б'],
];

ob_start();
?>

    <div class="task-header">
        <h1>Створення об'єктів</h1>
        <p>Клас <code>Student</code> з властивостями: name, studentId, grade</p>
    </div>

    <div class="code-block"><span class="code-comment">// Створюємо об'єкт та задаємо властивості</span>
        <span class="code-variable">$student1</span> = <span class="code-keyword">new</span> <span class="code-class">Student</span>();
        <span class="code-variable">$student1</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">'Іван Петренко'</span>;
        <span class="code-variable">$student1</span><span class="code-arrow">-></span><span class="code-method">studentId</span> = <span class="code-string">'ST-001'</span>;
        <span class="code-variable">$student1</span><span class="code-arrow">-></span><span class="code-method">grade</span> = <span class="code-string">4.5</span>;</div>

    <div class="section-divider">
        <span class="section-divider-text">3 об'єкти</span>
    </div>

    <div class="users-grid">
        <?php foreach ($students as $i => $data): ?>
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
                    <div>
                        <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                        <div class="user-card-label">Об'єкт #<?= $i + 1 ?></div>
                    </div>
                </div>
                <div class="user-card-body">
                    <div class="user-card-field">
                        <span class="user-card-field-label">name</span>
                        <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->name) ?></span>
                    </div>
                    <div class="user-card-field">
                        <span class="user-card-field-label">studentId</span>
                        <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->studentId) ?></span>
                    </div>
                    <div class="user-card-field">
                        <span class="user-card-field-label">grade</span>
                        <span class="user-card-field-value"><?= $data['obj']->grade ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 1', 'task1-body');