<?php
$errors = $errors ?? []; $old = $old ?? []; ?>

<div class="page-header">
    <h1>Реєстрація нового користувача</h1>
    <p class="page-subtitle">Створення облікового запису в системі.</p>
</div>

<div class="panel">
    <?php if (isset($errors['db'])): ?>
        <div class="alert alert--danger"><?= htmlspecialchars($errors['db']) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?route=auth/register" class="form">
        <div class="form__grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <div class="form__group">
                <label for="login" class="form__label">Логін *</label>
                <input type="text" name="login" id="login" class="form__input <?= isset($errors['login']) ? 'form__input--error' : '' ?>" 
                       value="<?= htmlspecialchars($old['login'] ?? '') ?>" required placeholder="Логін">
                <?php if (isset($errors['login'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['login']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="email" class="form__label">E-mail *</label>
                <input type="email" name="email" id="email" class="form__input <?= isset($errors['email']) ? 'form__input--error' : '' ?>" 
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>" required placeholder="user@example.com">
                <?php if (isset($errors['email'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['email']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="password" class="form__label">Пароль *</label>
                <input type="password" name="password" id="password" class="form__input <?= isset($errors['password']) ? 'form__input--error' : '' ?>" required placeholder="не менше 6 символів">
                <?php if (isset($errors['password'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['password']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="password_confirm" class="form__label">Підтвердження паролю *</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form__input <?= isset($errors['password_confirm']) ? 'form__input--error' : '' ?>" required placeholder="повторіть пароль">
                <?php if (isset($errors['password_confirm'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['password_confirm']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="first_name" class="form__label">Ім'я *</label>
                <input type="text" name="first_name" id="first_name" class="form__input <?= isset($errors['first_name']) ? 'form__input--error' : '' ?>" 
                       value="<?= htmlspecialchars($old['first_name'] ?? '') ?>" required placeholder="Ім'я">
                <?php if (isset($errors['first_name'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['first_name']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="last_name" class="form__label">Прізвище *</label>
                <input type="text" name="last_name" id="last_name" class="form__input <?= isset($errors['last_name']) ? 'form__input--error' : '' ?>" 
                       value="<?= htmlspecialchars($old['last_name'] ?? '') ?>" required placeholder="Прізвище">
                <?php if (isset($errors['last_name'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['last_name']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="phone" class="form__label">Телефон</label>
                <input type="text" name="phone" id="phone" class="form__input" 
                       value="<?= htmlspecialchars($old['phone'] ?? '') ?>" placeholder="+380...">
            </div>

            <div class="form__group">
                <label for="city" class="form__label">Місто</label>
                <input type="text" name="city" id="city" class="form__input" 
                       value="<?= htmlspecialchars($old['city'] ?? '') ?>" placeholder="Київ, Одеса тощо">
            </div>

            <div class="form__group" style="grid-column: span 2;">
                <label class="form__label">Стать</label>
                <div class="form__radios" style="display: flex; gap: 20px; margin-top: 10px;">
                    <label>
                        <input type="radio" name="gender" value="male" <?= ($old['gender'] ?? 'male') === 'male' ? 'checked' : '' ?>>
                        Чоловіча (Male)
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" <?= ($old['gender'] ?? '') === 'female' ? 'checked' : '' ?>>
                        Жіноча (Female)
                    </label>
                </div>
            </div>

            <div class="form__group" style="grid-column: span 2;">
                <label for="about" class="form__label">Про себе</label>
                <textarea name="about" id="about" class="form__input" rows="4" placeholder="Розкажіть про себе..."><?= htmlspecialchars($old['about'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="form__actions" style="margin-top: 20px;">
            <button type="submit" class="btn">Зареєструватися</button>
            <a href="index.php?route=auth/login" class="btn btn--secondary">Вже є аккаунт</a>
        </div>
    </form>
</div>
