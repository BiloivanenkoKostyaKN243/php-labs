<?php
$user = $user ?? []; ?>

<div class="page-header">
    <h1>Профіль користувача: <?= htmlspecialchars($user['login'] ?? '') ?></h1>
    <p class="page-subtitle">Особисті дані користувача в базі даних.</p>
</div>

<div class="panel">
    <div class="profile-details" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
        <div class="profile-avatar-box" style="text-align: center; border-right: 1px solid rgba(255, 255, 255, 0.1); padding-right: 30px;">
            <div class="avatar-placeholder" style="width: 120px; height: 120px; border-radius: 50%; background: #202024; margin: 0 auto 20px; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #fff;">
                U
            </div>
            <h3><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h3>
            <p class="text-muted" style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; color: var(--primary); margin-top: 5px;">
                <?= ($user['gender'] ?? '') === 'female' ? 'Жіноча стать' : 'Чоловіча стать' ?>
            </p>
        </div>

        <div class="profile-info-box">
            <table class="table table--details" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%; font-weight: bold; color: var(--primary);">E-mail:</td>
                        <td><?= htmlspecialchars($user['email'] ?? 'не вказано') ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; color: var(--primary);">Телефон:</td>
                        <td><?= htmlspecialchars($user['phone'] ?? 'не вказано') ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; color: var(--primary);">Місто:</td>
                        <td><?= htmlspecialchars($user['city'] ?? 'не вказано') ?></td>
                    </tr>

                    <tr>
                        <td style="font-weight: bold; color: var(--primary);">Роль:</td>
                        <td><?= htmlspecialchars($user['role'] ?? 'pilot') ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; color: var(--primary);">Дата реєстрації:</td>
                        <td><?= htmlspecialchars($user['created_at'] ?? 'невідомо') ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; color: var(--primary); vertical-align: top;">Про себе:</td>
                        <td style="white-space: pre-wrap;"><?= htmlspecialchars($user['about'] ?? 'Інформація відсутня.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form__actions" style="margin-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 20px; display: flex; gap: 15px;">
        <a href="index.php?route=auth/edit" class="btn">Редагувати профіль</a>
        <a href="index.php?route=auth/logout" class="btn btn--secondary">Вихід з акаунту</a>
        <a href="index.php?route=auth/delete" class="btn btn--danger" style="margin-left: auto;">Видалити акаунт</a>
    </div>
</div>
