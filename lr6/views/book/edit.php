<?php
$errors = $errors ?? []; $book = $book ?? []; ?>

<div class="page-header">
    <h1>Редагувати документ №<?= (int)($book['id'] ?? 0) ?></h1>
    <p class="page-subtitle">Оновлення відомостей про посібник чи документ.</p>
</div>

<div class="panel">
    <form method="POST" action="index.php?route=book/edit&id=<?= (int)($book['id'] ?? 0) ?>" class="form">
        
        <div class="form__group">
            <label for="title" class="form__label">Назва документа *</label>
            <input type="text" name="title" id="title" class="form__input <?= isset($errors['title']) ? 'form__input--error' : '' ?>" 
                   value="<?= htmlspecialchars($book['title'] ?? '') ?>" required>
            <?php if (isset($errors['title'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['title']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="author" class="form__label">Автор / Організація *</label>
            <input type="text" name="author" id="author" class="form__input <?= isset($errors['author']) ? 'form__input--error' : '' ?>" 
                   value="<?= htmlspecialchars($book['author'] ?? '') ?>" required>
            <?php if (isset($errors['author'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['author']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="genre" class="form__label">Розділ</label>
            <input type="text" name="genre" id="genre" class="form__input" 
                   value="<?= htmlspecialchars($book['genre'] ?? '') ?>">
        </div>

        <div class="form__group">
            <label for="price" class="form__label">Вартість (кредити)</label>
            <input type="number" step="0.01" name="price" id="price" class="form__input <?= isset($errors['price']) ? 'form__input--error' : '' ?>" 
                   value="<?= htmlspecialchars($book['price'] ?? '') ?>">
            <?php if (isset($errors['price'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['price']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="pages" class="form__label">Кількість сторінок</label>
            <input type="number" name="pages" id="pages" class="form__input <?= isset($errors['pages']) ? 'form__input--error' : '' ?>" 
                   value="<?= htmlspecialchars($book['pages'] ?? '') ?>">
            <?php if (isset($errors['pages'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['pages']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__actions">
            <button type="submit" class="btn">Зберегти зміни</button>
            <a href="index.php?route=book/list" class="btn btn--secondary">Скасувати</a>
        </div>
    </form>
</div>
