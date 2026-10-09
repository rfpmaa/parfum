<?= $this->include('parfum/partials/header', ['pageTitle' => 'Keranjang belanja']) ?>

<section class="page-heading">
    <div class="container">
        <div class="breadcrumbs"><a href="<?= base_url('parfum') ?>">Beranda</a> &nbsp;/&nbsp; Keranjang</div>
        <span class="eyebrow">Pilihan Anda</span>
        <h1>Keranjang belanja</h1>
        <p>Periksa kembali parfum pilihan Anda sebelum checkout.</p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <?php if ($items === []): ?>
            <div class="empty-state">
                <h2>Keranjang Anda masih kosong</h2>
                <p>Temukan aroma favorit dan tambahkan ke keranjang untuk melanjutkan.</p>
                <a class="button" href="<?= base_url('parfum#koleksi') ?>">Lihat koleksi parfum</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <div>
                    <div class="cart-list">
                        <?php foreach ($items as $item): ?>
                            <article class="cart-item">
                                <img src="<?= base_url('parfum/produk/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>">
                                <div>
                                    <span class="product-brand"><?= esc($item['brand']) ?> · <?= esc($item['category']) ?></span>
                                    <h3><?= esc($item['name']) ?></h3>
                                    <p><?= esc($item['notes']) ?></p>
                                    <span class="price">Rp<?= number_format($item['price'], 0, ',', '.') ?></span>
                                </div>
                                <div class="item-actions">
                                    <form action="<?= base_url('parfum/keranjang/perbarui') ?>" method="post" class="item-actions">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="quantity[<?= esc($item['id']) ?>]" value="0">
                                        <label class="sr-only" for="quantity-<?= esc($item['id']) ?>">Jumlah <?= esc($item['name']) ?></label>
                                        <input class="quantity-input" id="quantity-<?= esc($item['id']) ?>" type="number" name="quantity[<?= esc($item['id']) ?>]" min="0" max="10" value="<?= (int) $item['quantity'] ?>">
                                        <button class="button light small" type="submit">Perbarui</button>
                                    </form>
                                    <form action="<?= base_url('parfum/keranjang/hapus/' . $item['id']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button class="remove-link" type="submit">Hapus</button>
                                    </form>
                                </div>
                                <strong class="price">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                            </article>
                        <?php endforeach ?>
                    </div>
                    <div style="display:flex; justify-content:space-between; gap:12px; margin-top:16px">
                        <a class="button outline small" href="<?= base_url('parfum#koleksi') ?>">← Lanjut belanja</a>
                        <form action="<?= base_url('parfum/keranjang/kosongkan') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button danger small" type="submit">Kosongkan keranjang</button>
                        </form>
                    </div>
                </div>

                <aside class="summary-card">
                    <h2>Ringkasan pesanan</h2>
                    <div class="summary-line"><span>Jumlah item</span><strong><?= (int) array_sum(array_column($items, 'quantity')) ?></strong></div>
                    <div class="summary-line"><span>Subtotal</span><strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></div>
                    <div class="summary-line"><span>Pengiriman</span><span><?= $total >= 150000 ? 'Gratis' : 'Dihitung saat checkout' ?></span></div>
                    <div class="summary-line summary-total"><span>Total sementara</span><span>Rp<?= number_format($total, 0, ',', '.') ?></span></div>
                    <a class="button block" href="<?= base_url('parfum/checkout') ?>">Lanjut ke checkout</a>
                    <p class="note">Biaya pengiriman belum dihitung pada versi demo ini.</p>
                </aside>
            </div>
        <?php endif ?>
    </div>
</section>

<?= $this->include('parfum/partials/footer') ?>
