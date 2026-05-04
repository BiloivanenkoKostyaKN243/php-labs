<?php
$system = is_array($system ?? null) ? $system : null;
$result = is_array($result ?? null) ? $result : null;
?>
<div class="game-page">
    <section class="game-hero">
        <h1>Результат дослідження</h1>
        <p>Після вибору системи ви отримуєте підсумок експедиції, короткий аналіз планет і умовний рейтинг для поточної сесії.</p>
    </section>

    <?php if ($system === null || $result === null): ?>
        <div class="alert alert--error">Немає даних для відображення результату.</div>
    <?php else: ?>
        <section class="game-result">
            <div class="game-result__score">
                <span>Поточний рахунок</span>
                <strong><?= (int) ($result['score'] ?? 0) ?></strong>
            </div>

            <div class="game-columns">
                <div class="game-info">
                    <h2><?= htmlspecialchars((string) ($result['systemName'] ?? '')) ?></h2>
                    <div class="game-meta">
                        <div class="game-meta__row"><span>Тип зорі</span><span><?= htmlspecialchars((string) ($result['starType'] ?? '')) ?></span></div>
                        <div class="game-meta__row"><span>Відстань</span><span><?= htmlspecialchars(number_format((float) ($result['distance'] ?? 0), 2, '.', ' ')) ?> св. років</span></div>
                        <div class="game-meta__row"><span>Кількість планет</span><span><?= (int) ($result['planetCount'] ?? 0) ?></span></div>
                        <div class="game-meta__row"><span>Найкраща планета</span><span><?= htmlspecialchars((string) ($result['bestPlanet'] ?? '')) ?></span></div>
                        <div class="game-meta__row"><span>Середня придатність</span><span><?= (int) ($result['averageHabitability'] ?? 0) ?>%</span></div>
                        <div class="game-meta__row"><span>Час дослідження</span><span><?= htmlspecialchars((string) ($result['exploredAt'] ?? '')) ?></span></div>
                    </div>
                </div>

                <div class="game-info">
                    <h3>Планети системи</h3>
                    <ul class="game-list">
                        <?php foreach (($system['planets'] ?? []) as $planet): ?>
                            <li>
                                <strong><?= htmlspecialchars((string) ($planet['name'] ?? '')) ?></strong><br>
                                Тип: <?= htmlspecialchars((string) ($planet['type'] ?? '')) ?><br>
                                Придатність: <?= (int) ($planet['habitability'] ?? 0) ?>%<br>
                                Орбіта: <?= htmlspecialchars(number_format((float) ($planet['orbit'] ?? 0), 2, '.', ' ')) ?> AU
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="game-actions">
                <a href="index.php?route=game/play&amp;system=<?= urlencode((string) ($system['id'] ?? '')) ?>" class="btn">Повернутися до радара</a>
                <a href="index.php?route=game/leaderboard" class="btn btn--secondary">Переглянути рейтинг</a>
            </div>
        </section>
    <?php endif; ?>
</div>

