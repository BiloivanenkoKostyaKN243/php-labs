<?php

require_once dirname(__DIR__, 3) . '/shared/templates/task_cards.php';
require_once dirname(__DIR__, 3) . '/shared/helpers/paths.php';

$tasks = [
    'task2.php' => ['name' => 'Завдання 2'],
    'task3.php' => ['name' => 'Завдання 3'],
    'task4.php' => ['name' => 'Завдання 4'],
    'task5.php' => ['name' => 'Завдання 5'],
    'task6.php' => ['name' => 'Завдання 6'],
    'task7_table.php' => ['name' => 'Завдання 7.1'],
    'task7_squares.php' => ['name' => 'Завдання 7.2'],
];

$demoUrl = '/lr1/demo/index.php?from=v1';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Варіант 1 — ЛР1</title>
    <link rel="stylesheet" href="<?= webPath(dirname(__DIR__, 3) . '/shared/css/base.css') ?>">
    <link rel="stylesheet" href="<?= webPath(dirname(__DIR__, 2) . '/demo/demo.css') ?>">
</head>
<body class="index-page">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">
            Варіант 1
        </div>
    </header>

    <h1 class="index-title">
        Варіант 1
        <br><span class="index-subtitle">Лабораторна робота №1</span>
    </h1>

    <?= renderTaskCards($tasks, true, $demoUrl) ?>
</body>
</html>
