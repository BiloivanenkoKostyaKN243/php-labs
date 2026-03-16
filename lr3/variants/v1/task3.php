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
}

$student1 = new Student('Іван Петренко', 'ST-001', 4.5);
$student2 = new Student('Олена Коваленко', 'ST-002', 3.8);
$student3 = new Student('Богдан Ткаченко', 'ST-003', 4.2);

$students = [
    ['obj' => $student1, 'avatar' => 'avatar-indigo', 'initial' => 'І', 'var' => '$student1'],
    ['obj' => $student2, 'avatar' => 'avatar-green', 'initial' => 'О', 'var' => '$student2'],
    ['obj' => $student3, 'avatar' => 'avatar-amber', 'initial' => 'Б', 'var' => '$student3'],
];

ob_start();
?>

<div class="task-header">
    <h1>Конструктор</h1>
    <p>Початкові значення задаються одразу при створенні об'єкта</p>
</div>

<div class="code-block"><span class="code-keyword">public function</span> <span class="code-method">__construct</span>(<span class="code-class">string</span> <span class="code-variable">$name</span>, <span class="code-class">string</span> <span class="code-variable">$studentId</span>, <span class="code-class">float</span> <span class="code-variable">$grade</span>)
{
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-variable">$name</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">studentId</span> = <span class="code-variable">$studentId</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">grade</span> = <span class="code-variable">$grade</span>;
}

<span class="code-variable">$student1</span> = <span class="code-keyword">new</span> <span class="code-class">Student</span>(<span class="code-string">'Іван Петренко'</span>, <span class="code-string">'ST-001'</span>, <span class="code-string">4.5</span>);
<span class="code-variable">$student2</span> = <span class="code-keyword">new</span> <span class="code-class">Student</span>(<span class="code-string">'Олена Коваленко'</span>, <span class="code-string">'ST-002'</span>, <span class="code-string">3.8</span>);
<span class="code-variable">$student3</span> = <span class="code-keyword">new</span> <span class="code-class">Student</span>(<span class="code-string">'Богдан Ткаченко'</span>, <span class="code-string">'ST-003'</span>, <span class="code-string">4.2</span>);</div>

<div class="section-divider">
    <span class="section-divider-text">Об'єкти створені через конструктор</span>
</div>

<div class="users-grid">
    <?php foreach ($students as $data): ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                <div class="user-card-label"><?= $data['var'] ?> <span class="user-card-badge badge-constructor">constructor</span></div>
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

<div class="section-divider">
    <span class="section-divider-text">getInfo() для кожного</span>
</div>

<div class="info-output">
    <div class="info-output-header">Виклик getInfo() для об'єктів, створених через конструктор</div>
    <div class="info-output-body">
        <?php foreach ($students as $data): ?>
        <div class="info-output-row">
            <span class="info-output-label"><?= $data['var'] ?></span>
            <span class="info-output-text"><?= htmlspecialchars($data['obj']->getInfo()) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 3', 'task3-body');
