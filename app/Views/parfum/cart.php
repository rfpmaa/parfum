<?= $this->include('parfum/partials/header', ['pageTitle' => parfum_text('cart_title')]) ?>

<section class="page-heading">
    <div class="container">
        <div class="breadcrumbs"><a href="<?= base_url('parfum') ?>"><?= parfum_text('home') ?></a> &nbsp;/&nbsp; <?= parfum_text('cart') ?></div>
        <span class="eyebrow"><?= parfum_text('your_selection') ?></span>
        <h1><?= parfum_text('cart_title') ?></h1>
        <p><?= parfum_text('cart_description') ?></p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <?php if ($items === []): ?>
            <div class="empty-state">
                <h2><?= parfum_text('cart_empty') ?></h2>
                <p><?= parfum_text('cart_empty_description') ?></p>
                <a class="button" href="<?= base_url('parfum#koleksi') ?>"><?= parfum_text('view_collection') ?></a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <div>
                    <div class="cart-list">
                        <?php foreach ($items as $item): ?>
                            <article class="cart-item">
                                <img src="<?= base_url('parfum/produk/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>">
                                <div>
                                    <span class="product-brand"><?= esc($item['brand']) ?> · <?= parfum_text(strtolower($item['category'])) ?></span>
                                    <h3><?= esc($item['name']) ?></h3>
                                    <p><?= (int) $item['sprays'] ?> <?= parfum_text('sprays_each') ?> · <?= esc($item['notes']) ?></p>
                                    <span class="price"><?= parfum_text('unit_price') ?>: Rp<?= number_format($item['unitTotal'], 0, ',', '.') ?></span>
                                </div>
                                <div class="item-actions">
                                    <form action="<?= base_url('parfum/keranjang/perbarui') ?>" method="post" class="item-actions">
                                        <?= csrf_field() ?>
                                        <label class="sr-only" for="quantity-<?= esc($item['lineKey']) ?>"><?= parfum_text('quantity') ?> <?= esc($item['name']) ?></label>
                                        <div class="quantity-control" data-quantity-control>
                                            <button type="button" data-quantity-step="-1" aria-label="−">−</button>
                                            <input id="quantity-<?= esc($item['lineKey']) ?>" type="number" name="quantity[<?= esc($item['lineKey']) ?>]" min="0" max="10" value="<?= (int) $item['quantity'] ?>">
                                            <button type="button" data-quantity-step="1" aria-label="+">+</button>
                                        </div>
                                        <button class="button light small" type="submit"><?= parfum_text('update') ?></button>
                                    </form>
                                    <form action="<?= base_url('parfum/keranjang/hapus/' . $item['id'] . '/' . $item['sprays']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button class="remove-link" type="submit"><?= parfum_text('remove') ?></button>
                                    </form>
                                </div>
                                <strong class="price">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                            </article>
                        <?php endforeach ?>
                    </div>
                    <div style="display:flex; justify-content:space-between; gap:12px; margin-top:16px">
                        <a class="button outline small" href="<?= base_url('parfum#koleksi') ?>"><?= parfum_text('continue_shopping') ?></a>
                        <form action="<?= base_url('parfum/keranjang/kosongkan') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button danger small" type="submit"><?= parfum_text('clear_cart') ?></button>
                        </form>
                    </div>
                </div>

                <aside class="summary-card">
                    <h2><?= parfum_text('order_summary') ?></h2>
                    <div class="summary-line"><span><?= parfum_text('item_count') ?></span><strong><?= (int) array_sum(array_column($items, 'quantity')) ?></strong></div>
                    <div class="summary-line summary-total"><span><?= parfum_text('total') ?></span><span>Rp<?= number_format($total, 0, ',', '.') ?></span></div>
                    <a class="button block" href="<?= base_url('parfum/checkout') ?>"><?= parfum_text('checkout') ?></a>
                </aside>
            </div>
        <?php endif ?>
    </div>
</section>
