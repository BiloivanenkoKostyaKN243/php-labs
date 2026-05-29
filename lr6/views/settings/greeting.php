<?php
$message = $message ?? ''; $messageType = $messageType ?? 'success'; $currentName = $currentName ?? ''; $currentGender = $currentGender ?? ''; ?>

<div class="page-header">
    <h1>Налаштування привітання</h1>
    <p class="page-subtitle">Введіть ваше ім'я/позивний та стать. Ця інформація збережеться в Cookie на 30 днів для персонального привітання.</p>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert--<?= $messageType === 'error' ? 'error' : 'success' ?>"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($currentName !== ''): ?>
    <?php
 $titleText = $currentGender === 'female' ? 'пані' : 'пане'; ?>
    <div class="alert alert--info">
        Поточне привітання: <strong>Вітаємо Вас, <?= $titleText ?> <?= htmlspecialchars($currentName) ?>!</strong>
    </div>
<?php endif; ?>

<div class="panel">
    <form method="POST" action="index.php?route=settings/greeting" class="form">
        <div class="form__group">
            <label for="greeting_name" class="form__label">Ім'я / Прізвище / Позивний</label>
            <input type="text" id="greeting_name" name="greeting_name"
                   class="form__input"
                   value="<?= htmlspecialchars($currentName) ?>"
                   placeholder="Введіть ім'я..." required>
        </div>

        <div class="form__group">
            <label class="form__label">Стать</label>
            <div class="form__radios" style="display: flex; gap: 20px; margin-top: 10px;">
                <label>
                    <input type="radio" name="greeting_gender" value="male"
                           <?= $currentGender === 'male' || $currentGender === '' ? 'checked' : '' ?>>
                    Чоловік (Male)
                </label>
                <label>
                    <input type="radio" name="greeting_gender" value="female"
                           <?= $currentGender === 'female' ? 'checked' : '' ?>>
                    Жінка (Female)
                </label>
            </div>
        </div>

        <button type="submit" class="btn">Зберегти налаштування</button>
    </form>
</div>
