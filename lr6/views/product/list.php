<div class="panel merch-panel">
    <div class="merch-hero">
        <div>
            <p class="eyebrow"><?= __('space_store') ?></p>
            <h1><?= __('products') ?></h1>
            <p class="merch-lead"><?= __('merch_lead') ?></p>
        </div>
        <a class="btn" href="index.php?route=product/create"><?= __('create') ?></a>
    </div>

    <div class="merch-grid">
        <?php foreach($products as $p): ?>
            <article class="merch-card">
                <div class="merch-card__image">
                    <?php if(!empty($p['image'])): ?>
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                    <?php else: ?>
                        <div class="merch-card__placeholder">
                            <span>SE</span>
                            <small><?= __('image_soon') ?></small>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="merch-card__body">
                    <div class="merch-card__top">
                        <span class="merch-badge"><?= htmlspecialchars($p['category']) ?></span>
                        <strong class="merch-price"><?= number_format((float)$p['price'], 2) ?> ₴</strong>
                    </div>
                    <h2><?= htmlspecialchars($p['name']) ?></h2>
                    <p><?= htmlspecialchars($p['description'] ?: __('default_merch_description')) ?></p>
                    <div class="merch-card__actions">
                        <a href="index.php?route=product/show&id=<?= $p['id'] ?>"><?= __('show') ?></a>
                        <a href="index.php?route=product/edit&id=<?= $p['id'] ?>"><?= __('edit') ?></a>
                        <form method="post" action="index.php?route=product/delete" onsubmit="return confirm('<?= __('confirm_delete') ?>')">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button class="link-button"><?= __('delete') ?></button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <details class="merch-table-wrap">
        <summary><?= __('table_mode') ?></summary>
        <table id="products-table" class="data-table">
            <thead><tr><th>ID</th><th><?= __('image') ?></th><th><?= __('name') ?></th><th><?= __('category') ?></th><th><?= __('price') ?></th><th><?= __('actions') ?></th></tr></thead>
            <tbody>
            <?php foreach($products as $p): ?>
                <tr>
                    <td><?= (int)$p['id'] ?></td>
                    <td><?php if($p['image']): ?><img src="<?= htmlspecialchars($p['image']) ?>" style="width:70px;height:70px;object-fit:cover"><?php endif; ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['category']) ?></td>
                    <td><?= number_format((float)$p['price'],2) ?></td>
                    <td><a href="index.php?route=product/show&id=<?= $p['id'] ?>"><?= __('show') ?></a> | <a href="index.php?route=product/edit&id=<?= $p['id'] ?>"><?= __('edit') ?></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </details>
    <?php require VIEWS_DIR.'/_pagination.php'; ?>
</div>
