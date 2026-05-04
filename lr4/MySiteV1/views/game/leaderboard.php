<div class="game-page">
    <section class="game-hero">
        <h1>Таблиця результатів</h1>
        <p>Тут відображаються результати досліджених систем у межах поточної сесії браузера.</p>
        <div class="game-hero__actions">
            <a href="index.php?route=game/play" class="btn">До гри</a>
            <a href="index.php?route=game/menu" class="btn btn--secondary">Меню модуля</a>
        </div>
    </section>

    <section class="game-leaderboard">
        <?php if (empty($records)): ?>
            <p class="game-empty">Ще немає результатів. Запустіть дослідження хоча б однієї системи.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Система</th>
                        <th>Тип зорі</th>
                        <th>Планет</th>
                        <th>Рахунок</th>
                        <th>Час</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $index => $record): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars((string) ($record['systemName'] ?? '')) ?></td>
                            <td><?= htmlspecialchars((string) ($record['starType'] ?? '')) ?></td>
                            <td><?= (int) ($record['planetCount'] ?? 0) ?></td>
                            <td><strong><?= (int) ($record['score'] ?? 0) ?></strong></td>
                            <td><?= htmlspecialchars((string) ($record['exploredAt'] ?? '')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>

