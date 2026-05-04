<?php
$systems = is_array($systems ?? null) ? $systems : [];
$stats = is_array($stats ?? null) ? $stats : [];
$lastResult = is_array($lastResult ?? null) ? $lastResult : null;
?>
<div class="game-page">
    <section class="game-hero">
        <h1>Space Explorer</h1>
        <p>Легка аркадна космічна міні-гра для браузера. Обирайте зоряні системи, переглядайте планети та відкривайте найкращі світи у межах однієї сесії.</p>
        <div class="game-hero__actions">
            <a href="index.php?route=game/play" class="btn">Почати політ</a>
            <a href="index.php?route=game/leaderboard" class="btn btn--secondary">Таблиця результатів</a>
        </div>
    </section>

    <section class="game-stats">
        <article class="game-stat">
            <span class="game-stat__value"><?= (int) ($stats['systems'] ?? 0) ?></span>
            <span class="game-stat__label">доступних систем</span>
        </article>
        <article class="game-stat">
            <span class="game-stat__value"><?= (int) ($stats['planets'] ?? 0) ?></span>
            <span class="game-stat__label">планет для огляду</span>
        </article>
        <article class="game-stat">
            <span class="game-stat__value"><?= htmlspecialchars(number_format((float) ($stats['maxDistance'] ?? 0), 2, '.', ' ')) ?></span>
            <span class="game-stat__label">максимальна дистанція, св. років</span>
        </article>
        <article class="game-stat">
            <span class="game-stat__value"><?= (int) ($stats['bestHabitability'] ?? 0) ?>%</span>
            <span class="game-stat__label">найкраща придатність до життя</span>
        </article>
    </section>

    <?php if (!empty($lastResult)): ?>
        <div class="alert alert--success">
            Остання вдала експедиція: <strong><?= htmlspecialchars((string) ($lastResult['systemName'] ?? '')) ?></strong>,
            рахунок <strong><?= (int) ($lastResult['score'] ?? 0) ?></strong>.
        </div>
    <?php endif; ?>

    <section class="card-grid">
        <?php foreach ($systems as $system): ?>
            <article class="card">
                <h3 class="card__title"><?= htmlspecialchars((string) ($system['name'] ?? 'Невідома система')) ?></h3>
                <p class="card__text">
                    Тип зорі: <strong><?= htmlspecialchars((string) ($system['starType'] ?? 'Невідомо')) ?></strong><br>
                    Відстань: <strong><?= htmlspecialchars(number_format((float) ($system['distance'] ?? 0), 2, '.', ' ')) ?></strong> св. років<br>
                    Планет: <strong><?= count($system['planets'] ?? []) ?></strong>
                </p>
                <a href="index.php?route=game/play&amp;system=<?= urlencode((string) ($system['id'] ?? '')) ?>" class="btn btn--small">Вибрати систему</a>
            </article>
        <?php endforeach; ?>
    </section>
</div>

