<?php
$bgColor = $_SESSION['bg_color'] ?? '#F5F5DC'; $greetingName = is_string($_COOKIE['greeting_name'] ?? '') ? ($_COOKIE['greeting_name'] ?? '') : ''; $greetingGender = is_string($_COOKIE['greeting_gender'] ?? '') ? ($_COOKIE['greeting_gender'] ?? '') : ''; $greetingText = ''; if ($greetingName !== '') { $title = $greetingGender === 'female' ? 'пані' : 'пане'; $greetingText = "Вітаємо Вас, {$title} " . htmlspecialchars($greetingName) . "!"; } $currentRoute = $_GET['route'] ?? 'index/main'; $navItems = [ 'index/main' => 'Головна', 'guestbook/index' => 'Журнал зв\'язку', 'upload/index' => 'Галерея знімків', 'folder/create' => 'Папки користувачів', 'book/list' => 'Технічна бібліотека', 'settings/color' => 'Колір візора', 'settings/greeting' => 'Привітання', 'space/intro' => 'Симулятор', ]; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(($pageTitle ?? '') !== '' ? $pageTitle : 'Space Engine HUD') ?> — Space Engine Explorer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color: <?= htmlspecialchars($bgColor) ?>">
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php" class="header__logo">
                    SPACE ENGINE
                </a>
                
                <div class="header__user-status" style="display: flex; align-items: center; gap: 15px;">
                    <?php if ($greetingText !== ''): ?>
                        <span class="header__greeting"><?= $greetingText ?></span>
                    <?php endif; ?>
                    
                    <div class="auth-status" style="font-size: 0.9rem;">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <span style="color: var(--primary);">[<?= htmlspecialchars($_SESSION['user_login']) ?> / <?= htmlspecialchars($_SESSION['user_role'] ?? 'pilot') ?>]</span>
                            <a href="index.php?route=auth/profile" style="margin-left: 10px; color: #fff; text-decoration: underline;">Профіль</a>
                            <a href="index.php?route=auth/logout" style="margin-left: 10px; color: var(--secondary);">Вихід</a>
                        <?php else: ?>
                            <a href="index.php?route=auth/login" style="color: var(--primary);">Вхід</a>
                            <span style="color: rgba(255,255,255,0.2);">|</span>
                            <a href="index.php?route=auth/register" style="color: #fff;">Реєстрація</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <nav class="nav">
                <ul class="nav__list">
                    <?php foreach ($navItems as $route => $label): ?>
                        <li class="nav__item">
                            <a href="index.php?route=<?= $route ?>"
                               class="nav__link<?= $currentRoute === $route ? ' nav__link--active' : '' ?>">
                                <?= htmlspecialchars($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main">
        <div class="container">
            
            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert alert--success">
                    <?= htmlspecialchars($_SESSION['flash_success']) ?>
                    <?php unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>
