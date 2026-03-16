<?php
require_once __DIR__ . '/layout.php';

class Student
{
    public string $name;
    public string $studentId;
    public float $grade;

    public function getInfo(): string
    {
        return "Студент: {$this->name}, ID: {$this->studentId}, Середній бал: {$this->grade}";
    }
}

$student1 = new Student();
$student1->name = 'Іван Петренко';
$student1->studentId = 'ST-001';
$student1->grade = 4.5;

$student2 = new Student();
$student2->name = 'Олена Коваленко';
$student2->studentId = 'ST-002';
$student2->grade = 3.8;

$student3 = new Student();
$student3->name = 'Богдан Ткаченко';
$student3->studentId = 'ST-003';
$student3->grade = 4.2;

$students = [$student1, $student2, $student3];
$labels = ['$student1', '$student2', '$student3'];

ob_start();
?>

    <div class="task-header">
        <h1>Метод getInfo()</h1>
        <p>Виводить значення властивостей об'єкта</p>
    </div>

    <div class="code-block"><span class="code-comment">// Метод getInfo() повертає рядок з інформацією</span>
        <span class="code-keyword">public function</span> <span class="code-method">getInfo</span>(): <span class="code-class">string</span>
        {
        <span class="code-keyword">return</span> <span class="code-string">"Студент: {$this->name}, ID: {$this->studentId}, Середній бал: {$this->grade}"</span>;
        }

        <span class="code-comment">// Виклик для кожного об'єкта</span>
        <span class="code-variable">$student1</span><span class="code-arrow">-></span><span class="code-method">getInfo</span>();</div>

    <div class="section-divider">
        <span class="section-divider-text">Результат виклику</span>
    </div>

    <div class="info-output">
        <div class="info-output-header">getInfo() — вивід для кожного об'єкта</div>
        <div class="info-output-body">
            <?php foreach ($students as $i => $student): ?>
                <div class="info-output-row">
                    <span class="info-output-label"><?= $labels[$i] ?></span>
                    <span class="info-output-text"><?= htmlspecialchars($student->getInfo()) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="section-divider">
        <span class="section-divider-text">Картки студентів</span>
    </div>

    <div class="users-grid">
        <?php
        $avatars = ['avatar-indigo', 'avatar-green', 'avatar-amber'];
        $initials = ['І', 'О', 'Б'];
        foreach ($students as $i => $student):
            ?>
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-card-avatar <?= $avatars[$i] ?>"><?= $initials[$i] ?></div>
                    <div>
                        <div class="user-card-name"><?= htmlspecialchars($student->name) ?></div>
                        <div class="user-card-label"><?= $labels[$i] ?>->getInfo()</div>
                    </div>
                </div>
                <div class="user-card-body">
                    <div class="user-card-field">
                        <span class="user-card-field-label">name</span>
                        <span class="user-card-field-value"><?= htmlspecialchars($student->name) ?></span>
                    </div>
                    <div class="user-card-field">
                        <span class="user-card-field-label">studentId</span>
                        <span class="user-card-field-value"><?= htmlspecialchars($student->studentId) ?></span>
                    </div>
                    <div class="user-card-field">
                        <span class="user-card-field-label">grade</span>
                        <span class="user-card-field-value"><?= $student->grade ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 2', 'task2-body');