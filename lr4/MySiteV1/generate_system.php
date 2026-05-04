<?php
// Генератор вселенной с множественными звездными системами
// Абсолютно независимый файл - может быть вызван напрямую

ob_end_clean();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-cache, no-store, must-revalidate');

$seed = isset($_GET['seed']) ? (int)$_GET['seed'] : mt_rand(1000, 99999);
mt_srand($seed);

$numSystems = mt_rand(5, 10);
$systems = array();
$starDistances = array(1000, 1500, 2000, 2500, 3000);

$resourceTypes = ['Titanium', 'Helium-3', 'Platinum', 'Dark Matter', 'Water Ice', 'Silicates'];
$atmoTypes = ['None', 'Thin CO2', 'Dense Toxic', 'Nitrogen-Oxygen', 'Hydrogen-Helium'];

for ($s = 0; $s < $numSystems; $s++) {
    $angle = ($s * 2 * M_PI / $numSystems) + mt_rand(-30, 30) * M_PI / 180;
    $distance = $starDistances[$s % count($starDistances)] + mt_rand(-200, 200);
    $x = $distance * cos($angle);
    $z = $distance * sin($angle);
    $y = mt_rand(-100, 100); 
    
    // Star Generation
    $starColorList = ['#ffffff', '#ffccaa', '#aaccff', '#ffdd99', '#ff9966', '#99bbff'];
    $starType = mt_rand(0, count($starColorList)-1);
    
    $star = array(
        'type' => 'star',
        'name' => 'Star-' . $seed . '-' . ($s + 1),
        'position' => array((float)$x, (float)$y, (float)$z),
        'size' => mt_rand(6, 15),
        'color' => $starColorList[$starType],
        'temperature' => mt_rand(3000, 20000)
    );
    
    $planets = array();
    $numPlanets = mt_rand(1, 6); 
    
    for ($i = 0; $i < $numPlanets; $i++) {
        $planetDistance = mt_rand(20, 80);
        $planetAngle = (mt_rand(0, 360) * M_PI / 180);
        $px = $x + $planetDistance * cos($planetAngle);
        $pz = $z + $planetDistance * sin($planetAngle);
        $py = $y + mt_rand(-10, 10); 
        
        // Game Mechanics Data
        $isHabitable = mt_rand(1, 100) > 85; 
        $habitability = $isHabitable ? mt_rand(60, 99) : mt_rand(0, 30);
        
        $pResources = [];
        $numRes = mt_rand(1, 3);
        $resPool = $resourceTypes;
        shuffle($resPool);
        for($r=0; $r<$numRes; $r++) {
            $pResources[] = $resPool[$r];
        }

        $baseColor = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        if ($isHabitable) $baseColor = '#4a90e2'; // Earth-like blue/greenish

        $planets[] = array(
            'type' => 'planet',
            'name' => 'Planet-' . $seed . '-' . ($s + 1) . '-' . ($i + 1),
            'position' => array((float)$px, (float)$py, (float)$pz),
            'size' => mt_rand(10, 35) / 10,
            'color' => $baseColor,
            'orbitRadius' => (float)$planetDistance,
            'orbitSpeed' => (mt_rand(2, 10) / 1000.0),
            'starPosition' => array((float)$x, (float)$y, (float)$z),
            // Game Stats
            'habitability' => $habitability,
            'atmosphere' => $atmoTypes[mt_rand(0, count($atmoTypes)-1)],
            'resources' => implode(", ", $pResources),
            'scanDifficulty' => mt_rand(1, 5)
        );
    }
    
    $systems[] = array(
        'star' => $star,
        'planets' => $planets
    );
}

$response = array(
    'systems' => $systems,
    'seed' => $seed,
    'totalSystems' => $numSystems
);

echo json_encode($response);
exit;

