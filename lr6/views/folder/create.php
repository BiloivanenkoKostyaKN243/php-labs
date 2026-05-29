<?php
$message = $message ?? ''; $error = $error ?? ''; $folders = $folders ?? []; ?>

<div class="page-header">
    <h1>Папки користувачів</h1>
    <p class="page-subtitle">Створіть особисту директорію для зберігання файлів. Буде створено структуру папок video, music, photo в <code>data/users/{ідентифікатор}/</code>.</p>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="panel">
    <h2>Створити директорію</h2>
    <form method="POST" action="index.php?route=folder/create" class="form">
        <div class="form__row">
            <div class="form__group">
                <label for="folder_login" class="form__label">Ідентифікатор користувача <span class="required">*</span></label>
                <input type="text" id="folder_login" name="login" class="form__input"
                       value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                       placeholder="Латинські літери, цифри, _">
            </div>
            <div class="form__group">
                <label for="folder_password" class="form__label">Код доступу <span class="required">*</span></label>
                <input type="password" id="folder_password" name="password" class="form__input"
                       placeholder="Для підтвердження при видаленні">
            </div>
        </div>
        <div class="form__actions">
            <button type="submit" class="btn">Створити папку</button>
            <a href="index.php?route=folder/delete" class="btn btn--danger">Видалити папку</a>
        </div>
    </form>
</div>

<?php if (!empty($folders)): ?>
<div class="panel" style="margin-top:24px">
    <h2>Створені директорії (<?= count($folders) ?>)</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Користувач</th>
                <th>Підпапки</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($folders as $folder): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($folder['name']) ?></strong></td>
                    <td>
                        <?php foreach ($folder['subfolders'] as $sub): ?>
                            <code><?= htmlspecialchars($sub['name']) ?></code> (<?= $sub['files'] ?> файлів)<?= $sub !== end($folder['subfolders']) ? ', ' : '' ?>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
