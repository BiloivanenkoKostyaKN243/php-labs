<?php
// Максимально спрощений генератор для швидкого захисту
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$seed = isset($_GET['seed']) ? (int)$_GET['seed'] : mt_rand(1000, 9999);
mt_srand($seed);

$system = [
    'star' => [
        'name' => 'Star-' . $seed,
        'color' => '#ffccaa',
        'size' => 10,
        'position' => [0, 0, 0]
    ],
    'planets' => []
];

// Генеруємо 2-5 планет
$numPlanets = mt_rand(2, 5);
for ($i = 0; $i < $numPlanets; $i++) {
    $system['planets'][] = [
        'name' => 'Planet-' . $i,
        'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
        'size' => mt_rand(2, 5),
        'orbitRadius' => mt_rand(20, 80),
        'orbitSpeed' => mt_rand(1, 5) / 100
    ];
}

// Повертаємо просту структуру JSON
echo json_encode(['systems' => [$system]]);
