<?php
$bgColor = $_SESSION['bg_color'] ?? '#f9fafb';
$greetingName = $_COOKIE['greeting_name'] ?? '';
$greetingGender = $_COOKIE['greeting_gender'] ?? '';

$greetingText = '';
if ($greetingName !== '') {
    $title = $greetingGender === 'female' ? 'пані' : 'пане';
    $greetingText = "Вітаємо Вас, {$title} " . htmlspecialchars($greetingName) . "!";
}

$currentRoute = $_GET['route'] ?? 'index/main';

$navItems = [
    'index/main' => 'Головна',
    'game/menu' => 'Space Explorer',
    'space' => 'Space Engine',
    'regform/form' => 'Реєстрація',
    'reqview/showrequest' => 'Параметри запиту',
    'settings/color' => 'Колір фону',
    'settings/greeting' => 'Привітання',
];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'MVC Додаток') ?> — PHP MVC Demo</title>
    <link rel="stylesheet" href="css/style.css">
    <?php if ($currentRoute === 'space'): ?>
        <link rel="stylesheet" href="css/space.css">
    <?php endif; ?>
</head>
<body style="background-color: <?php if ($currentRoute !== 'space') { echo htmlspecialchars($bgColor); } else { echo '#000'; } ?>">
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php" class="header__logo">PHP MVC Demo</a>
                <?php if ($greetingText !== ''): ?>
                    <span class="header__greeting"><?= $greetingText ?></span>
                <?php endif; ?>
            </div>
            <nav class="nav">
                <ul class="nav__list">
                    <?php foreach ($navItems as $route => $label): ?>
                        <?php 
                        $href = ($route === 'space') ? 'space.php' : "index.php?route={$route}";
                        $isActive = $currentRoute === $route || 
                                    ($route === 'game/menu' && strpos($currentRoute, 'game/') === 0) ||
                                    ($route === 'space' && strpos($currentRoute, 'space/') === 0);
                        ?>
                        <li class="nav__item">
                            <a href="<?= $href ?>"
                               class="nav__link<?= $isActive ? ' nav__link--active' : '' ?>">
                                <?= htmlspecialchars($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main<?php if ($currentRoute === 'space') { echo ' main--space'; } ?>">
        <?php if ($currentRoute !== 'space'): ?>
        <div class="container">
        <?php endif; ?>
