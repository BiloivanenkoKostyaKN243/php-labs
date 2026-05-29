<?php
$comments = $comments ?? []; $message = $message ?? ''; $errors = $errors ?? []; ?>

<div class="page-header">
    <h1>Журнал зв'язку</h1>
    <p class="page-subtitle">Залиште ваше повідомлення. Дані зберігаються у файлі <code>data/comments.txt</code>.</p>
</div>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="panel">
    <h2>Надіслати повідомлення</h2>
    <form method="POST" action="index.php?route=guestbook/index" class="form">
        <div class="form__group <?= isset($errors['name']) ? 'form__group--error' : '' ?>">
            <label for="gb_name" class="form__label">Ім'я / Позивний <span class="required">*</span></label>
            <input type="text" id="gb_name" name="name" class="form__input"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                   placeholder="Введіть ваше ім'я або позивний">
            <?php if (isset($errors['name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['comment']) ? 'form__group--error' : '' ?>">
            <label for="gb_comment" class="form__label">Текст повідомлення <span class="required">*</span></label>
            <textarea id="gb_comment" name="comment" class="form__textarea"
                       rows="4" placeholder="Ваше повідомлення..."><?= htmlspecialchars($_POST['comment'] ?? '') ?></textarea>
            <?php if (isset($errors['comment'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['comment']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__actions">
            <button type="submit" class="btn">Надіслати повідомлення</button>
        </div>
    </form>
</div>

<div class="panel" style="margin-top:24px">
    <h2>Список повідомлень (<?= count($comments) ?>)</h2>

    <?php if (empty($comments)): ?>
        <p class="text-muted">Журнал порожній. Немає жодного повідомлення.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Дата / Час</th>
                    <th>Ім'я / Позивний</th>
                    <th>Повідомлення</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['date']) ?></td>
                        <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                        <td><?= htmlspecialchars($c['comment']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
