<?php
$user = $user ?? []; $errors = $errors ?? []; ?>

<div class="page-header">
    <h1>Редагувати профіль</h1>
    <p class="page-subtitle">Оновлення особистих даних користувача.</p>
</div>

<div class="panel">
    <?php if (isset($errors['db'])): ?>
        <div class="alert alert--danger"><?= htmlspecialchars($errors['db']) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?route=auth/edit" class="form">
        <div class="form__grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <div class="form__group">
                <label for="login" class="form__label">Логін</label>
                <input type="text" id="login" class="form__input" value="<?= htmlspecialchars($user['login'] ?? '') ?>" readonly style="background: rgba(255,255,255,0.05); color: #888; cursor: not-allowed;">
            </div>

            <div class="form__group">
                <label for="email" class="form__label">E-mail *</label>
                <input type="email" name="email" id="email" class="form__input <?= isset($errors['email']) ? 'form__input--error' : '' ?>" 
                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['email']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="first_name" class="form__label">Ім'я *</label>
                <input type="text" name="first_name" id="first_name" class="form__input <?= isset($errors['first_name']) ? 'form__input--error' : '' ?>" 
                       value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
                <?php if (isset($errors['first_name'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['first_name']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="last_name" class="form__label">Прізвище *</label>
                <input type="text" name="last_name" id="last_name" class="form__input <?= isset($errors['last_name']) ? 'form__input--error' : '' ?>" 
                       value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required>
                <?php if (isset($errors['last_name'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['last_name']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label for="phone" class="form__label">Телефон</label>
                <input type="text" name="phone" id="phone" class="form__input" 
                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>

            <div class="form__group">
                <label for="city" class="form__label">Місто</label>
                <input type="text" name="city" id="city" class="form__input" 
                       value="<?= htmlspecialchars($user['city'] ?? '') ?>">
            </div>

            <div class="form__group" style="grid-column: span 2;">
                <label class="form__label">Стать</label>
                <div class="form__radios" style="display: flex; gap: 20px; margin-top: 10px;">
                    <label>
                        <input type="radio" name="gender" value="male" <?= ($user['gender'] ?? '') === 'male' ? 'checked' : '' ?>>
                        Чоловіча (Male)
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" <?= ($user['gender'] ?? '') === 'female' ? 'checked' : '' ?>>
                        Жіноча (Female)
                    </label>
                </div>
            </div>

            <div class="form__group" style="grid-column: span 2;">
                <label for="about" class="form__label">Про себе</label>
                <textarea name="about" id="about" class="form__input" rows="4"><?= htmlspecialchars($user['about'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="form__actions" style="margin-top: 20px;">
            <button type="submit" class="btn">Зберегти зміни</button>
            <a href="index.php?route=auth/profile" class="btn btn--secondary">Скасувати</a>
        </div>
    </form>
</div>
