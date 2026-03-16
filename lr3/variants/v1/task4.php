<?php
require_once __DIR__ . '/layout.php';

class Student
{
    public string $name;
    public string $studentId;
    public float $grade;

    public function __construct(string $name, string $studentId, float $grade)
    {
        $this->name = $name;
        $this->studentId = $studentId;
        $this->grade = $grade;
    }

    public function getInfo(): string
    {
        return "Студент: {$this->name}, ID: {$this->studentId}, Середній бал: {$this->grade}";
    }

    public function __clone(): void
    {
        $this->name = 'Студент';
        $this->studentId = '';
        $this->grade = 0.0;
    }
}

$student3 = new Student('Богдан Ткаченко', 'ST-003', 4.2);
$student4 = clone $student3;

ob_start();
?>

<div class="task-header">
    <h1>Клонування</h1>
    <p>Метод <code>__clone()</code> задає значення за замовчанням при копіюванні об'єкта</p>
</div>

<div class="code-block"><span class="code-keyword">public function</span> <span class="code-method">__clone</span>(): <span class="code-class">void</span>
{
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">'Студент'</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">studentId</span> = <span class="code-string">''</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">grade</span> = <span class="code-string">0.0</span>;
}

<span class="code-variable">$student4</span> = <span class="code-keyword">clone</span> <span class="code-variable">$student3</span>;</div>

<div class="section-divider">
    <span class="section-divider-text">Оригінал vs Клон</span>
</div>

<div class="comparison-wrapper">
    <div class="users-grid">
        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-amber">Б</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($student3->name) ?></div>
                    <div class="user-card-label">$student3 <span class="user-card-badge badge-constructor">original</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($student3->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">studentId</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($student3->studentId) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">grade</span>
                    <span class="user-card-field-value"><?= $student3->grade ?></span>
                </div>
            </div>
        </div>

        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-rose">С</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($student4->name) ?></div>
                    <div class="user-card-label">$student4 <span class="user-card-badge badge-clone">clone</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($student4->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">studentId</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($student4->studentId) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">grade</span>
                    <span class="user-card-field-value"><?= $student4->grade ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-divider">
    <span class="section-divider-text">getInfo() порівняння</span>
</div>

<div class="info-output">
    <div class="info-output-header">Результат getInfo() для оригіналу та клону</div>
    <div class="info-output-body">
        <div class="info-output-row">
            <span class="info-output-label">$student3</span>
            <span class="info-output-text"><?= htmlspecialchars($student3->getInfo()) ?></span>
        </div>
        <div class="info-output-row">
            <span class="info-output-label">$student4</span>
            <span class="info-output-text"><?= htmlspecialchars($student4->getInfo()) ?></span>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 4', 'task4-body');
