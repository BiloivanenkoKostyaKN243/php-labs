<?php
$books = $books ?? []; ?>

<div class="page-header">
    <h1>Технічна бібліотека</h1>
    <p class="page-subtitle">Каталог технічних документів та посібників. CRUD-операції через PDO із prepared statements.</p>
</div>

<div class="form__actions" style="margin-bottom:20px">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index.php?route=book/create" class="btn">Додати документ</a>
    <?php else: ?>
        <a href="index.php?route=auth/login" class="btn btn--secondary">Увійдіть, щоб додавати документи</a>
    <?php endif; ?>
</div>

<?php if (empty($books)): ?>
    <div class="panel">
        <p class="text-muted">Бібліотека порожня. Авторизуйтесь та додайте перший документ.</p>
    </div>
<?php else: ?>
    <div class="panel">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва документа</th>
                    <th>Автор / Організація</th>
                    <th>Розділ</th>
                    <th>Ціна (кред.)</th>
                    <th>Сторінок</th>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <th>Дії</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $b): ?>
                    <tr>
                        <td><?= (int)$b['id'] ?></td>
                        <td><strong><?= htmlspecialchars($b['title']) ?></strong></td>
                        <td><?= htmlspecialchars($b['author']) ?></td>
                        <td><?= htmlspecialchars($b['genre']) ?></td>
                        <td><?= number_format((float)$b['price'], 2) ?></td>
                        <td><?= (int)$b['pages'] ?></td>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <td class="table__actions">
                                <a href="index.php?route=book/edit&id=<?= (int)$b['id'] ?>" class="btn btn--small">Редагувати</a>
                                <form method="POST" action="index.php?route=book/delete" style="display:inline"
                                      onsubmit="return confirm('Видалити документ з бібліотеки?')">
                                    <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                                    <button type="submit" class="btn btn--small btn--danger">Видалити</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
