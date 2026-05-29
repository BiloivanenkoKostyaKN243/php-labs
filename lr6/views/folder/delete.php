<?php
$message = $message ?? ''; $error = $error ?? ''; ?>

<div class="page-header">
    <h1>Видалення директорії користувача</h1>
    <p class="page-subtitle">Введіть ідентифікатор та код доступу. Папка <code>data/users/{ідентифікатор}/</code> буде повністю видалена разом із усім вмістом.</p>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="panel">
    <h2>Підтвердити видалення</h2>
    <form method="POST" action="index.php?route=folder/delete" class="form">
        <div class="form__row">
            <div class="form__group">
                <label for="del_login" class="form__label">Ідентифікатор користувача <span class="required">*</span></label>
                <input type="text" id="del_login" name="login" class="form__input"
                       value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                       placeholder="Ідентифікатор для видалення">
            </div>
            <div class="form__group">
                <label for="del_password" class="form__label">Код доступу <span class="required">*</span></label>
                <input type="password" id="del_password" name="password" class="form__input"
                       placeholder="Код, вказаний при створенні">
            </div>
        </div>
        <div class="form__actions">
            <button type="submit" class="btn btn--danger" onclick="return confirm('Підтвердити видалення папки? Дія незворотна!')">Видалити папку</button>
            <a href="index.php?route=folder/create" class="btn btn--secondary">← Повернутись</a>
        </div>
    </form>
</div>
