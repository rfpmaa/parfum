<?= $this->include('parfum/partials/header', ['pageTitle' => 'Pembayaran']) ?>

<section class="page-heading">
    <div class="container">
        <div class="breadcrumbs"><a href="<?= base_url('parfum') ?>">Beranda</a> &nbsp;/&nbsp; <a href="<?= base_url('parfum/keranjang') ?>">Keranjang</a> &nbsp;/&nbsp; <a href="<?= base_url('parfum/checkout') ?>">Checkout</a> &nbsp;/&nbsp; Pembayaran</div>
        <span class="eyebrow">Tahap akhir</span>
        <h1>Konfirmasi pembayaran</h1>
        <p>Pesan Anda siap diproses. Pilih metode pembayaran untuk melanjutkan.</p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="checkout-layout">
            <div>
                <div class="step-list" aria-label="Langkah checkout">
                    <div class="step active">1. Keranjang</div>
                    <div class="step active">2. Checkout</div>
                    <div class="step active">3. Pembayaran</div>
                </div>

                <div class="payment-card">
                    <span class="demo-label">SIMULASI PEMBAYARAN</span>
                    <h2 style="margin-top: 18px; margin-bottom: 0;">No. Pesanan <span class="order-number"><?= esc($order['number']) ?></span></h2>
                    <p style="margin: 2px 0 18px; color: var(--muted); font-size: 13px;"><?= $order['paid_at'] ?? 'Menunggu konfirmasi' ?></p>

                    <div class="payment-logo">
                        <span>QRIS</span>
                    </div>

                    <h3 style="font: 500 24px 'Playfair Display', serif; margin: 24px 0 12px; text-align: center;">Total pembayaran</h3>
                    <div style="font-size: 28px; font-weight: 800; text-align: center; color: var(--plum); margin-bottom: 28px;">Rp<?= number_format($order['total'], 0, ',', '.') ?></div>

                    <div style="background: #f9f5f0; border: 1px solid var(--line); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                        <p style="font-size: 13px; color: #625a60; margin: 0;">
                            Ini adalah simulasi demo dari aplikasi parfum toko vending mesin Scentus. 
                            <br><br>
                            <strong>Versi ini tidak terhubung dengan payment gateway atau sistem pembayaran nyata.</strong> Data pesanan dan informasi pengiriman Anda disimpan dalam sesi untuk keperluan demo saja.
                        </p>
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: center;">
                        <form action="<?= base_url('parfum/pembayaran/batal') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button outline" type="submit">← Kembali ke checkout</button>
                        </form>
                        <form action="<?= base_url('parfum/pembayaran/konfirmasi') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button" type="submit">Simulasikan pembayaran →</button>
                        </form>
                    </div>
                </div>
            </div>

            <aside class="summary-card">
                <h2>Detail pesanan</h2>
                <div style="max-height: 340px; overflow-y: auto; margin-bottom: 15px;">
                    <div style="margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px solid var(--line);">
                        <p style="font-size: 12px; color: var(--muted); margin: 0 0 4px;"><strong>Dikirm ke:</strong></p>
                        <p style="font-size: 13px; margin: 0; line-height: 1.6;">
                            <strong><?= esc($order['customer_name']) ?></strong><br>
                            <span style="color: var(--muted);"><?= esc($order['phone']) ?></span><br>
                            <span style="color: var(--muted);"><?= esc($order['address']) ?></span>
                        </p>
                    </div>
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="summary-line" style="font-size: 13px; margin-bottom: 10px;">
                            <span><?= esc($item['name']) ?> × <?= (int) $item['quantity'] ?></span>
                            <strong>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="summary-line"><span>Subtotal</span><strong>Rp<?= number_format($order['total'], 0, ',', '.') ?></strong></div>
                <div class="summary-line"><span>Pengiriman</span><span class="muted">Gratis</span></div>
                <div class="summary-total"><span>Total</span><span>Rp<?= number_format($order['total'], 0, ',', '.') ?></span></div>
                <p class="note">Versi demo ini tidak memproses pembayaran nyata atau mengirim email konfirmasi.</p>
            </aside>
        </div>
    </div>
</section>

<?= $this->include('parfum/partials/footer') ?>
