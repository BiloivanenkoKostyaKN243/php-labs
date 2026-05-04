<?php

class GameController extends PageController
{
    private string $systemsFile = ROOT_DIR . '/data/star-systems.json';

    public function action_menu(): void
    {
        $systems = $this->loadSystems();
        $stats = $this->buildStats($systems);
        $lastResult = $_SESSION['game_last_result'] ?? null;

        $this->render('game/menu', [
            'systems' => $systems,
            'stats' => $stats,
            'lastResult' => $lastResult,
        ], 'Space Explorer');
    }

    public function action_play(): void
    {
        $systems = $this->loadSystems();
        $selectedId = (string) $this->request->get('system', '');
        $selectedSystem = $this->findSystem($systems, $selectedId);

        if ($selectedSystem === null && !empty($systems)) {
            $selectedSystem = $systems[0];
        }

        $this->render('game/play', [
            'systems' => $systems,
            'selectedSystem' => $selectedSystem,
        ], 'Space Explorer — Політ');
    }

    public function action_result(): void
    {
        $systems = $this->loadSystems();

        if (empty($systems)) {
            $this->render('game/result', [
                'system' => null,
                'result' => null,
            ], 'Space Explorer — Результат');
            return;
        }

        $systemId = (string) $this->request->get('system', '');
        $system = $this->findSystem($systems, $systemId);

        if ($system === null) {
            $system = $systems[0];
        }

        $result = $this->buildResult($system);
        $history = $_SESSION['game_history'] ?? [];
        $history[$system['id']] = $result;

        uasort($history, static function (array $left, array $right): int {
            return ($right['score'] ?? 0) <=> ($left['score'] ?? 0);
        });

        $_SESSION['game_history'] = $history;
        $_SESSION['game_last_result'] = $result;

        $this->render('game/result', [
            'system' => $system,
            'result' => $result,
        ], 'Space Explorer — Результат');
    }

    public function action_leaderboard(): void
    {
        $records = array_values($_SESSION['game_history'] ?? []);

        usort($records, static function (array $left, array $right): int {
            return ($right['score'] ?? 0) <=> ($left['score'] ?? 0);
        });

        $this->render('game/leaderboard', [
            'records' => $records,
        ], 'Space Explorer — Таблиця результатів');
    }

    private function loadSystems(): array
    {
        if (!file_exists($this->systemsFile)) {
            return [];
        }

        $content = file_get_contents($this->systemsFile);

        if ($content === false) {
            return [];
        }

        $systems = json_decode($content, true);

        return is_array($systems) ? $systems : [];
    }

    private function findSystem(array $systems, string $systemId): ?array
    {
        foreach ($systems as $system) {
            if (($system['id'] ?? '') === $systemId) {
                return $system;
            }
        }

        return null;
    }

    private function buildStats(array $systems): array
    {
        $planetCount = 0;
        $maxDistance = 0.0;
        $bestHabitability = 0;

        foreach ($systems as $system) {
            $planetCount += count($system['planets'] ?? []);
            $maxDistance = max($maxDistance, (float) ($system['distance'] ?? 0));

            foreach ($system['planets'] ?? [] as $planet) {
                $bestHabitability = max($bestHabitability, (int) ($planet['habitability'] ?? 0));
            }
        }

        return [
            'systems' => count($systems),
            'planets' => $planetCount,
            'maxDistance' => $maxDistance,
            'bestHabitability' => $bestHabitability,
        ];
    }

    private function buildResult(array $system): array
    {
        $planets = $system['planets'] ?? [];
        $planetCount = count($planets);
        $habitabilitySum = 0;
        $bestPlanet = 'Невідомо';
        $bestHabitability = -1;

        foreach ($planets as $planet) {
            $habitability = (int) ($planet['habitability'] ?? 0);
            $habitabilitySum += $habitability;

            if ($habitability > $bestHabitability) {
                $bestHabitability = $habitability;
                $bestPlanet = (string) ($planet['name'] ?? 'Невідомо');
            }
        }

        $averageHabitability = $planetCount > 0 ? (int) round($habitabilitySum / $planetCount) : 0;
        $distance = (float) ($system['distance'] ?? 0);
        $difficulty = (int) ($system['danger'] ?? 1);
        $score = (int) round(120 + ($planetCount * 40) + $averageHabitability - ($difficulty * 15) - min(40, $distance / 5));
        $score = max(100, min(999, $score));

        return [
            'systemId' => (string) ($system['id'] ?? ''),
            'systemName' => (string) ($system['name'] ?? 'Невідома система'),
            'starType' => (string) ($system['starType'] ?? 'Невідомо'),
            'distance' => $distance,
            'planetCount' => $planetCount,
            'bestPlanet' => $bestPlanet,
            'averageHabitability' => $averageHabitability,
            'score' => $score,
            'exploredAt' => date('d.m.Y H:i:s'),
        ];
    }
}

