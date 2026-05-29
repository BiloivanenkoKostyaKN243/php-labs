<?php
$images = $images ?? []; $message = $message ?? ''; $error = $error ?? ''; ?>

<div class="page-header">
    <h1>Галерея знімків</h1>
    <p class="page-subtitle">Завантажуйте ваші знімки та зображення. Підтримувані формати: JPEG, PNG, GIF, WebP (до 5 МБ). Файли зберігаються у <code>data/uploads/</code>.</p>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="panel">
    <h2>Завантажити новий знімок</h2>
    <form method="POST" action="index.php?route=upload/index" enctype="multipart/form-data" class="form">
        <div class="form__group">
            <label for="upload_image" class="form__label">Оберіть файл зображення <span class="required">*</span></label>
            <input type="file" id="upload_image" name="image" class="form__input" accept="image/*">
        </div>
        <div class="form__actions">
            <button type="submit" class="btn">Завантажити знімок</button>
        </div>
    </form>
</div>

<div class="panel" style="margin-top:24px">
    <h2>Архів знімків (<?= count($images) ?>)</h2>

    <?php if (empty($images)): ?>
        <p class="text-muted">Архів порожній. Завантажте перший знімок.</p>
    <?php else: ?>
        <div class="gallery">
            <?php foreach ($images as $img): ?>
                <div class="gallery__item">
                    <img src="<?= htmlspecialchars($img['url']) ?>" alt="<?= htmlspecialchars($img['name']) ?>" class="gallery__img">
                    <div class="gallery__info">
                        <span class="gallery__name"><?= htmlspecialchars($img['name']) ?></span>
                        <span class="gallery__meta"><?= htmlspecialchars($img['date']) ?> &middot; <?= round($img['size'] / 1024) ?> КБ</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
