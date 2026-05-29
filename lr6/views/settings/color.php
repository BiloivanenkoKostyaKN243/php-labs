<?php
$colors = $colors ?? []; $currentColor = $currentColor ?? '#F5F5DC'; $message = $message ?? ''; $messageType = $messageType ?? 'success'; ?>

<div class="page-header">
    <h1>Колір візора / світлофільтр</h1>
    <p class="page-subtitle">Виберіть колір світлофільтра. Налаштування зберігається в сесії.</p>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert--<?= $messageType === 'error' ? 'error' : 'success' ?>"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="panel">
    <form method="POST" action="index.php?route=settings/color" class="form">
        <div class="color-picker" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
            <?php foreach ($colors as $hex => $name): ?>
                <label class="color-swatch<?= $hex === $currentColor ? ' color-swatch--active' : '' ?>" style="display: flex; align-items: center; gap: 10px; padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; background: rgba(255,255,255,0.02); transition: all 0.2s ease;">
                    <input type="radio" name="bg_color" value="<?= htmlspecialchars($hex) ?>"
                           <?= $hex === $currentColor ? 'checked' : '' ?> style="cursor: pointer;">
                    <span class="color-swatch__preview" style="background-color: <?= htmlspecialchars($hex) ?>; width: 30px; height: 30px; border-radius: 4px; display: inline-block; border: 1px solid rgba(255,255,255,0.2);"></span>
                    <span class="color-swatch__name" style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($name) ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn">Застосувати колір</button>
    </form>
</div>
