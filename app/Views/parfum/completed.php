<?= $this->include('parfum/partials/header', ['pageTitle' => 'Pesanan selesai']) ?>

<section class="content-section" style="text-align: center;">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">✓</div>
            <h1>Pesanan berhasil</h1>
            <p style="color: var(--muted); margin: 8px 0 24px;">Terima kasih telah bertransaksi dengan Scentus Parfum.</p>

            <div class="order-details">
                <div class="summary-line">
                    <span>Nomor Pesanan</span>
                    <strong><span class="order-number"><?= esc($order['number']) ?></span></strong>
                </div>
                <div class="summary-line">
                    <span>Total Pembayaran</span>
                    <strong>Rp<?= number_format($order['total'], 0, ',', '.') ?></strong>
                </div>
                <div class="summary-line">
                    <span>Waktu Pesanan</span>
                    <strong><?= $order['paid_at'] ?></strong>
                </div>
                <div class="summary-line">
                    <span>Penerima</span>
                    <strong><?= esc($order['customer_name']) ?></strong>
                </div>
                <div class="summary-line">
                    <span>Alamat Pengiriman</span>
                    <strong><?= esc($order['address']) ?></strong>
                </div>
            </div>

            <div style="background: #f0faf3; border: 1px solid #c9e4d2; border-radius: 8px; padding: 16px; margin: 24px 0;">
                <p style="font-size: 13px; color: var(--success); margin: 0;">
                    <strong>✓ Versi Demo:</strong> Ini adalah simulasi. Pesanan Anda tidak benar-benar diproses dan tidak ada kiriman nyata. 
                    Gunakan halaman ini untuk menguji alur pembelian lengkap.
                </p>
            </div>

            <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 28px;">
                <a class="button outline" href="<?= base_url('parfum#koleksi') ?>">← Lanjut belanja</a>
                <a class="button" href="<?= base_url('parfum') ?>">Kembali ke beranda →</a>
            </div>
        </div>
    </div>
</section>

<?= $this->include('parfum/partials/footer') ?>
