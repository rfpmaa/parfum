<?= $this->include('parfum/partials/header', ['pageTitle' => 'Parfum pilihan']) ?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <span class="eyebrow">Your scent, your story</span>
            <h1>Aroma yang tinggal lebih lama.</h1>
            <p>Kurasi parfum pilihan dengan karakter unik untuk menemani hari dan momen istimewa Anda.</p>
            <a class="button" href="#koleksi">Jelajahi koleksi <span aria-hidden="true">→</span></a>
        </div>
        <?php if (isset($products['velvet-athena'])): ?>
            <img class="hero-product" src="<?= base_url('parfum/produk/' . $products['velvet-athena']['image']) ?>" alt="Parfum Velvet Athena">
        <?php endif ?>
    </div>
</section>

<section class="benefits">
    <div class="container benefit-row">
        <div class="benefit"><span class="benefit-icon">✦</span><span>Aroma pilihan yang dikurasi</span></div>
        <div class="benefit"><span class="benefit-icon">◇</span><span>Kemasan aman dan rapi</span></div>
        <div class="benefit"><span class="benefit-icon">♡</span><span>Temukan aroma khas Anda</span></div>
    </div>
</section>

<section class="section" id="koleksi">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Discover your signature</span>
                <h2>Koleksi parfum</h2>
                <p>Pilih aroma yang paling sesuai dengan suasana hati Anda.</p>
            </div>
        </div>

        <div class="catalog-tools">
            <div class="category-links" aria-label="Filter kategori">
                <a class="category-chip <?= $category === '' ? 'active' : '' ?>" href="<?= base_url('parfum') ?>#koleksi">Semua aroma</a>
                <?php foreach (['Floral', 'Woody', 'Fresh'] as $categoryOption): ?>
                    <a class="category-chip <?= $category === $categoryOption ? 'active' : '' ?>" href="<?= base_url('parfum') ?>?kategori=<?= rawurlencode($categoryOption) ?>#koleksi"><?= esc($categoryOption) ?></a>
                <?php endforeach ?>
            </div>
            <form class="search-form" action="<?= base_url('parfum') ?>" method="get">
                <label class="sr-only" for="product-search">Cari parfum</label>
                <input class="field" id="product-search" type="search" name="q" value="<?= esc($search) ?>" placeholder="Cari nama atau aroma...">
                <button class="button small" type="submit">Cari</button>
            </form>
        </div>

        <?php if ($products === []): ?>
            <div class="empty-state">Parfum tidak ditemukan. Coba kata kunci atau kategori lain.</div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <span class="product-badge"><?= esc($product['badge']) ?></span>
                            <img src="<?= base_url('parfum/produk/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>" loading="lazy">
                        </div>
                        <div class="product-info">
                            <span class="product-brand"><?= esc($product['brand']) ?> · <?= esc($product['category']) ?></span>
                            <h3 class="product-name"><?= esc($product['name']) ?></h3>
                            <p class="product-notes"><?= esc($product['notes']) ?></p>
                            <div class="product-bottom">
                                <span class="price">Rp<?= number_format($product['price'], 0, ',', '.') ?></span>
                                <form action="<?= base_url('parfum/keranjang/tambah') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="button small" type="submit">Tambah ke keranjang</button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>

<?= $this->include('parfum/partials/footer') ?>
