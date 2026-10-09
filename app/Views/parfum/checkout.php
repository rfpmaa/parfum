<?= $this->include('parfum/partials/header', ['pageTitle' => 'Checkout']) ?>

<section class="page-heading">
    <div class="container">
        <div class="breadcrumbs"><a href="<?= base_url('parfum') ?>">Beranda</a> &nbsp;/&nbsp; <a href="<?= base_url('parfum/keranjang') ?>">Keranjang</a> &nbsp;/&nbsp; Checkout</div>
        <span class="eyebrow">Selesaikan pemesanan</span>
        <h1>Checkout</h1>
        <p>Isi informasi pengiriman Anda untuk melanjutkan ke pembayaran.</p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="checkout-layout">
            <div>
                <div class="step-list" aria-label="Langkah checkout">
                    <div class="step active">1. Keranjang</div>
                    <div class="step active">2. Checkout</div>
                    <div class="step">3. Pembayaran</div>
                </div>

                <form action="<?= base_url('parfum/checkout') ?>" method="post" class="form-card">
                    <?= csrf_field() ?>

                    <?php if (isset($errors) && $errors !== []): ?>
                        <div class="form-errors">
                            <strong>Kesalahan saat mengisi form:</strong>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <h2>Informasi pengiriman</h2>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nama lengkap</label>
                            <input class="field" id="name" type="text" name="customer_name" maxlength="100" required value="<?= old('customer_name') ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor telepon</label>
                            <input class="field" id="phone" type="tel" name="phone" maxlength="20" required value="<?= old('phone') ?>">
                        </div>
                    </div>

                    <div class="form-group full">
                        <label for="address">Alamat lengkap</label>
                        <textarea class="field" id="address" name="address" maxlength="500" required><?= old('address') ?></textarea>
                        <p class="note">Sertakan jalan, RT/RW, kelurahan, dan kota.</p>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <a class="button outline" href="<?= base_url('parfum/keranjang') ?>">← Kembali</a>
                        <button class="button" type="submit">Lanjut ke pembayaran →</button>
                    </div>
                </form>
                <p class="secure-note">🔒 Informasi Anda dilindungi dan hanya digunakan untuk pengiriman.</p>
            </div>

            <aside class="summary-card">
                <h2>Ringkasan pesanan</h2>
                <div style="max-height: 300px; overflow-y: auto; margin-bottom: 15px;">
                    <?php foreach ($items as $item): ?>
                        <div class="summary-line" style="font-size: 13px;">
                            <span><?= esc($item['name']) ?> × <?= (int) $item['quantity'] ?></span>
                            <strong>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="summary-line"><span>Subtotal</span><strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></div>
                <div class="summary-line"><span>Pengiriman</span><span class="muted">Gratis*</span></div>
                <div class="summary-total"><span>Total</span><span>Rp<?= number_format($total, 0, ',', '.') ?></span></div>
                <p class="note">*Gratis ongkir untuk pembelian minimal Rp150.000. Versi demo tidak memproses pembayaran.</p>
            </aside>
        </div>
    </div>
</section>

<?= $this->include('parfum/partials/footer') ?>
