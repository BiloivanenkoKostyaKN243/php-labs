<?php
$error = $error ?? ''; ?>

<div class="page-header">
    <h1>Авторизація</h1>
    <p class="page-subtitle">Введіть ваш логін та пароль для входу.</p>
</div>

<div class="panel" style="max-width: 500px; margin: 0 auto;">
    <?php if ($error !== ''): ?>
        <div class="alert alert--danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?route=auth/login" class="form">
        <div class="form__group">
            <label for="login" class="form__label">Логін</label>
            <input type="text" name="login" id="login" class="form__input" required autofocus>
        </div>

        <div class="form__group">
            <label for="password" class="form__label">Пароль</label>
            <input type="password" name="password" id="password" class="form__input" required>
        </div>

        <div class="form__actions">
            <button type="submit" class="btn">Увійти</button>
            <a href="index.php?route=auth/register" class="btn btn--secondary">Реєстрація</a>
        </div>
    </form>
</div>
