<?php
// Полностью независимый API - не использует MVC Router
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Генерируем систему на основе seed
$seed = (int)($_GET['seed'] ?? 123);
mt_srand($seed);

$star = [
    'type' => 'star',
    'name' => 'Star-' . $seed,
    'position' => [0, 0, 0],
    'size' => mt_rand(5, 10),
    'color' => '#' . str_pad(dechex(mt_rand(0xFFFFFF)), 6, '0', STR_PAD_LEFT),
];

$planets = [];
$numPlanets = mt_rand(2, 5);

for ($i = 0; $i < $numPlanets; $i++) {
    $distance = mt_rand(20, 100);
    $angle = (mt_rand(0, 360) * M_PI / 180);
    $x = $distance * cos($angle);
    $z = $distance * sin($angle);
    
    $planets[] = [
        'type' => 'planet',
        'name' => 'Planet-' . $seed . '-' . ($i + 1),
        'position' => [(float)$x, 0, (float)$z],
        'size' => mt_rand(1, 3),
        'color' => '#' . str_pad(dechex(mt_rand(0xFFFFFF)), 6, '0', STR_PAD_LEFT),
        'orbitRadius' => (float)$distance,
        'orbitSpeed' => mt_rand(1, 5) / 100.0,
    ];
}

$response = [
    'star' => $star,
    'planets' => $planets,
    'seed' => $seed,
];

echo json_encode($response);
exit;

