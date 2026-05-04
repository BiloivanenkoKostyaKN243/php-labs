<?php
$selectedSystemId = (string) ($selectedSystem['id'] ?? '');
?>
<div class="game-page" id="game-app" data-selected-system="<?= htmlspecialchars($selectedSystemId) ?>">
    <section class="game-hero">
        <h1>Навігаційний радар</h1>
        <p>Тут працює легкий canvas-режим для ПК і смартфонів. Перемикайте системи кнопками або торканням і запускайте дослідження обраної цілі.</p>
        <div class="game-badges">
            <span class="game-badge">Аркадний режим</span>
            <span class="game-badge">Canvas 2D</span>
            <span class="game-badge">Desktop + Mobile</span>
        </div>
    </section>

    <?php if (empty($systems)): ?>
        <div class="alert alert--error">Список зоряних систем порожній.</div>
    <?php else: ?>
        <section class="game-layout">
            <div class="game-canvas-wrap">
                <canvas id="game-canvas" class="game-canvas" width="900" height="520"></canvas>
            </div>

            <aside class="game-panel">
                <div class="game-panel__section">
                    <h2 id="game-system-name"><?= htmlspecialchars((string) ($selectedSystem['name'] ?? 'Невідома система')) ?></h2>
                    <p class="game-hint" id="game-system-description">Оберіть систему для швидкого перегляду планет і запуску дослідження.</p>
                </div>

                <div class="game-panel__section game-meta" id="game-meta">
                    <div class="game-meta__row"><span>Тип зорі</span><span id="game-star-type"><?= htmlspecialchars((string) ($selectedSystem['starType'] ?? 'Невідомо')) ?></span></div>
                    <div class="game-meta__row"><span>Відстань</span><span id="game-distance"><?= htmlspecialchars(number_format((float) ($selectedSystem['distance'] ?? 0), 2, '.', ' ')) ?> св. років</span></div>
                    <div class="game-meta__row"><span>Планет</span><span id="game-planet-count"><?= count($selectedSystem['planets'] ?? []) ?></span></div>
                    <div class="game-meta__row"><span>Небезпека</span><span id="game-danger"><?= (int) ($selectedSystem['danger'] ?? 0) ?>/5</span></div>
                </div>

                <div class="game-panel__section">
                    <h3>Доступні системи</h3>
                    <div class="game-system-list" id="game-system-list"></div>
                </div>

                <div class="game-panel__actions">
                    <button type="button" class="btn btn--secondary" id="game-prev-button">Попередня</button>
                    <button type="button" class="btn btn--secondary" id="game-next-button">Наступна</button>
                    <a href="index.php?route=game/result&amp;system=<?= urlencode($selectedSystemId) ?>" class="btn" id="game-explore-button">Дослідити</a>
                </div>
            </aside>
        </section>
    <?php endif; ?>
</div>
<?php if (!empty($systems)): ?>
    <script type="application/json" id="game-systems-data"><?= json_encode($systems, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
    <script src="js/game.js"></script>
<?php endif; ?>

