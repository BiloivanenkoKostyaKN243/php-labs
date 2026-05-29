<?php $cats=['Apparel','Accessories','Collectible','Desk Gear','Digital Bonus']; ?>
<div class="panel">
    <h1><?= $mode==='create'?__('create'):__('edit') ?> <?= __('products') ?></h1>
    <form method="post" enctype="multipart/form-data">
        <label><?= __('name') ?><input name="name" value="<?= htmlspecialchars($item['name']??'') ?>"></label>
        <div class="error"><?= $errors['name']??'' ?></div>

        <label><?= __('category') ?>
            <select name="category">
                <?php foreach($cats as $c): ?>
                    <option value="<?= $c ?>" <?= ($item['category']??'')===$c?'selected':'' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <div class="error"><?= $errors['category']??'' ?></div>

        <label><?= __('price') ?><input type="number" step="0.01" name="price" value="<?= htmlspecialchars($item['price']??'0') ?>"></label>
        <div class="error"><?= $errors['price']??'' ?></div>

        <label><?= __('description') ?><textarea name="description"><?= htmlspecialchars($item['description']??'') ?></textarea></label>
        <label><?= __('image') ?> <small>min 100×100; для футболки/кепки можна додати фото з логотипом гри</small><input type="file" name="image" accept="image/*"></label>
        <div class="error"><?= $errors['image']??'' ?></div>
        <?php if(!empty($item['image'])): ?><img src="<?= htmlspecialchars($item['image']) ?>" style="max-width:160px"><?php endif; ?>
        <p><button class="btn"><?= __('save') ?></button> <a class="btn btn--secondary" href="index.php?route=product/list"><?= __('back') ?></a></p>
    </form>
</div>
