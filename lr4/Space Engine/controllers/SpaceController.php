<?php

class SpaceController extends PageController
{
    // Сторінка-хаб перед запуском (використовує стандартний layout блогу)
    public function action_intro(): void
    {
        $this->view->setTitle('Space Engine - Запуск');
        $this->view->render('space/intro');
    }

    // Головне вікно симулятора (повністю свій HTML, без layout блогу)
    public function action_main(): void
    {
        // Виводимо views/space/main.php напряму, без header/footer
        require VIEWS_DIR . '/space/main.php';
        exit;
    }

    // API: Загальні параметри всесвіту
    public function action_api_universe(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'seed' => mt_rand(1000, 9999),
            'scale' => 1000,
            'ambientLight' => 0x050510,
            'maxSpeed' => 500,
            'starCount' => 20000
        ]);
        exit;
    }

    // API: Об'єкти (Зірка та планети)
    public function action_api_objects(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $star = [
            'type' => 'star',
            'name' => 'Solaris Alpha',
            'color' => '#fff4e8',
            'size' => 50,
            'position' => [0, 0, 0],
            'intensity' => 2.5
        ];

        $planets = [];
        $numPlanets = mt_rand(3, 6);
        $colors = ['#3498db', '#e74c3c', '#95a5a6', '#f1c40f', '#2ecc71', '#8e44ad'];

        for ($i = 0; $i < $numPlanets; $i++) {
            $distance = mt_rand(200, 1500);
            $planets[] = [
                'id' => $i,
                'name' => 'Planet-' . ($i + 1),
                'size' => mt_rand(5, 15),
                'orbitRadius' => (float)$distance,
                'orbitSpeed' => mt_rand(1, 5) / 1000,
                'baseColor' => $colors[array_rand($colors)],
                'hasAtmosphere' => mt_rand(0, 1) === 1,
                'hasWater' => mt_rand(0, 1) === 1,
                'noiseScale' => mt_rand(10, 50) / 10
            ];
        }

        echo json_encode([
            'star' => $star,
            'planets' => $planets
        ]);
        exit;
    }

    // API: Стан гравця
    public function action_api_player(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'startPosition' => [0, 100, 800],
            'startRotation' => [0, 0, 0],
            'fuel' => 100,
            'shipType' => 'Explorer Class'
        ]);
        exit;
    }
}
