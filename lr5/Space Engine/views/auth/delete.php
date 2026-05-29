<div class="page-header">
    <h1>Видалення акаунту</h1>
    <p class="page-subtitle">Видалення вашого профілю з бази даних.</p>
</div>

<div class="panel panel--danger" style="max-width: 600px; margin: 0 auto; border: 1px solid #cf6679; background: rgba(207, 102, 121, 0.08);">
    <h2 style="color: #cf6679; margin-bottom: 15px;">Увага: незворотна операція!</h2>
    <p style="margin-bottom: 20px; line-height: 1.6;">
        Ви збираєтеся видалити обліковий запис <strong><?= htmlspecialchars($_SESSION['user_login'] ?? '') ?></strong>. 
        Усі дані, завантажені файли та доступи буде втрачено назавжди без можливості відновлення.
    </p>

    <form method="POST" action="index.php?route=auth/delete" class="form">
        <div class="form__actions" style="display: flex; gap: 15px;">
            <button type="submit" class="btn btn--danger">Так, видалити акаунт</button>
            <a href="index.php?route=auth/profile" class="btn btn--secondary">Скасувати</a>
        </div>
    </form>
</div>
