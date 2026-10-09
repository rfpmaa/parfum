<?= $this->include('parfum/partials/header', ['pageTitle' => parfum_text('collection_title')]) ?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <span class="eyebrow"><?= parfum_text('hero_eyebrow') ?></span>
            <h1><?= parfum_text('hero_title') ?></h1>
            <p><?= parfum_text('hero_description') ?></p>
            <a class="button" href="#koleksi"><?= parfum_text('browse_collection') ?> <span aria-hidden="true">→</span></a>
        </div>
        <?php if (isset($products['velvet-athena'])): ?>
            <img class="hero-product" src="<?= base_url('parfum/produk/' . $products['velvet-athena']['image']) ?>" alt="Parfum Velvet Athena">
        <?php endif ?>
    </div>
</section>

<section class="benefits">
    <div class="container benefit-row">
        <div class="benefit"><span class="benefit-icon">✦</span><span><?= parfum_text('benefit_curated') ?></span></div>
        <div class="benefit"><span class="benefit-icon">◇</span><span><?= parfum_text('benefit_safe') ?></span></div>
        <div class="benefit"><span class="benefit-icon">♡</span><span><?= parfum_text('benefit_signature') ?></span></div>
    </div>
</section>

<section class="section" id="koleksi">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="eyebrow"><?= parfum_text('collection_eyebrow') ?></span>
                <h2><?= parfum_text('collection_title') ?></h2>
                <p><?= parfum_text('collection_description') ?></p>
            </div>
        </div>

        <div class="catalog-tools">
            <div class="category-links" aria-label="<?= esc(parfum_text('collection')) ?>">
                <a class="category-chip <?= $category === '' ? 'active' : '' ?>" href="<?= base_url('parfum') ?>#koleksi"><?= parfum_text('all_fragrances') ?></a>
                <?php foreach (['Floral', 'Woody', 'Fresh'] as $categoryOption): ?>
                    <a class="category-chip <?= $category === $categoryOption ? 'active' : '' ?>" href="<?= base_url('parfum') ?>?kategori=<?= rawurlencode($categoryOption) ?>#koleksi"><?= parfum_text(strtolower($categoryOption)) ?></a>
                <?php endforeach ?>
            </div>
            <form class="search-form" action="<?= base_url('parfum') ?>" method="get">
                <label class="sr-only" for="product-search"><?= parfum_text('search') ?></label>
                <input class="field" id="product-search" type="search" name="q" value="<?= esc($search) ?>" placeholder="<?= esc(parfum_text('search_placeholder')) ?>">
                <button class="button small" type="submit"><?= parfum_text('search') ?></button>
            </form>
        </div>

        <?php if ($products === []): ?>
            <div class="empty-state"><?= parfum_text('no_products') ?></div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <?php
                            $badgeKey = match ($product['id']) {
                                'velvet-athena' => 'badge_best_seller',
                                'noble-hint' => 'badge_favorite',
                                default => 'badge_fresh_pick',
                            };
                            ?>
                            <span class="product-badge"><?= parfum_text($badgeKey) ?></span>
                            <img src="<?= base_url('parfum/produk/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>" loading="lazy">
                        </div>
                        <div class="product-info">
                            <span class="product-brand"><?= esc($product['brand']) ?> · <?= parfum_text(strtolower($product['category'])) ?></span>
                            <h3 class="product-name"><?= esc($product['name']) ?></h3>
                            <p class="product-notes"><?= esc($product['notes']) ?></p>
                            <form class="spray-form" action="<?= base_url('parfum/keranjang/tambah') ?>" method="post" data-spray-form data-price-per-spray="<?= (int) $product['price'] ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                                <button class="button small add-button" type="button" data-show-spray-details><?= parfum_text('add_one_spray') ?></button>
                                <div class="spray-details" data-spray-details hidden>
                                    <fieldset class="spray-options">
                                        <legend><?= parfum_text('spray_options') ?></legend>
                                        <?php for ($sprays = 1; $sprays <= 5; $sprays++): ?>
                                            <label class="spray-option <?= $sprays === 1 ? 'selected' : '' ?>">
                                                <input type="radio" name="sprays" value="<?= $sprays ?>" <?= $sprays === 1 ? 'checked' : '' ?>>
                                                <span><?= $sprays ?> <?= parfum_text('spray') ?></span>
                                                <small>Rp<?= number_format($product['price'] * $sprays, 0, ',', '.') ?></small>
                                            </label>
                                        <?php endfor ?>
                                    </fieldset>
                                    <div class="product-order-row">
                                        <div class="quantity-control" data-quantity-control>
                                            <span class="sr-only"><?= parfum_text('quantity') ?></span>
                                            <button type="button" data-quantity-step="-1" aria-label="−">−</button>
                                            <input type="number" name="quantity" min="1" max="10" value="1" aria-label="<?= esc(parfum_text('quantity')) ?>">
                                            <button type="button" data-quantity-step="1" aria-label="+">+</button>
                                        </div>
                                        <span class="selected-price" data-selected-price aria-live="polite">Rp<?= number_format($product['price'], 0, ',', '.') ?></span>
                                    </div>
                                    <button class="button small add-button" type="submit"><?= parfum_text('add_to_cart') ?></button>
                                </div>
                            </form>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>
