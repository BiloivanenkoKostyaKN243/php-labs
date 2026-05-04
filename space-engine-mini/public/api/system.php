<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$seed = isset($_GET['seed']) ? intval($_GET['seed']) : 123;
mt_srand($seed);

// Генерация звезды
$starTypes = ['Red Dwarf', 'Yellow Dwarf', 'Blue Giant', 'White Dwarf'];
$starColors = ['#ff4500', '#ffff00', '#0000ff', '#ffffff'];
$starIndex = mt_rand(0, 3);
$star = [
    'name' => 'Star ' . $seed,
    'type' => $starTypes[$starIndex],
    'color' => $starColors[$starIndex],
    'size' => mt_rand(5, 15)
];

// Генерация планет
$planetCount = mt_rand(2, 5);
$planets = [];
$planetNames = ['Planet A', 'Planet B', 'Planet C', 'Planet D', 'Planet E'];
$planetColors = ['#8B4513', '#228B22', '#4169E1', '#FFD700', '#FF6347'];

for ($i = 0; $i < $planetCount; $i++) {
    $planets[] = [
        'name' => $planetNames[$i],
        'distance' => mt_rand(20, 100) + $i * 20,
        'size' => mt_rand(1, 5),
        'color' => $planetColors[mt_rand(0, 4)],
        'orbitSpeed' => mt_rand(1, 5) / 100.0
    ];
}

echo json_encode([
    'star' => $star,
    'planets' => $planets
]);
?>
