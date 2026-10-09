<?= $this->include('parfum/partials/header', ['pageTitle' => parfum_text('payment_title')]) ?>

<section class="page-heading">
    <div class="container">
        <div class="breadcrumbs"><a href="<?= base_url('parfum') ?>"><?= parfum_text('home') ?></a> &nbsp;/&nbsp; <a href="<?= base_url('parfum/keranjang') ?>"><?= parfum_text('cart') ?></a> &nbsp;/&nbsp; <a href="<?= base_url('parfum/checkout') ?>"><?= parfum_text('checkout_title') ?></a> &nbsp;/&nbsp; <?= parfum_text('payment_title') ?></div>
        <span class="eyebrow"><?= parfum_text('step_payment') ?></span>
        <h1><?= parfum_text('payment_title') ?></h1>
        <p><?= parfum_text('payment_description') ?></p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="checkout-layout">
            <div>
                <div class="step-list" aria-label="Langkah checkout">
                    <div class="step active"><?= parfum_text('step_cart') ?></div>
                    <div class="step active"><?= parfum_text('step_checkout') ?></div>
                    <div class="step active"><?= parfum_text('step_payment') ?></div>
                </div>

                <div class="payment-card">
                    <span class="demo-label"><?= parfum_text('demo_payment') ?></span>
                    <h2 style="margin-top: 18px; margin-bottom: 0;"><?= parfum_text('order_number') ?> <span class="order-number"><?= esc($order['number']) ?></span></h2>
                    <p style="margin: 2px 0 18px; color: var(--muted); font-size: 13px;"><?= parfum_text('waiting_payment') ?></p>

                    <div class="payment-qr">
                        <img src="<?= base_url('images/qris-demo.svg') ?>" alt="<?= esc(parfum_text('demo_payment')) ?>">
                    </div>
                    <p class="note"><?= parfum_text('demo_notice') ?></p>

                    <h3 style="font: 500 24px 'Playfair Display', serif; margin: 24px 0 12px; text-align: center;"><?= parfum_text('payment_total') ?></h3>
                    <div style="font-size: 28px; font-weight: 800; text-align: center; color: var(--plum); margin-bottom: 28px;">Rp<?= number_format($order['total'], 0, ',', '.') ?></div>

                    <div style="background: #f9f5f0; border: 1px solid var(--line); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                        <p style="font-size: 13px; color: #625a60; margin: 0;">
                            <?= parfum_text('demo_payment_warning') ?>
                        </p>
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: center;">
                        <form action="<?= base_url('parfum/pembayaran/batal') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button outline" type="submit"><?= parfum_text('back_checkout') ?></button>
                        </form>
                        <form action="<?= base_url('parfum/pembayaran/konfirmasi') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="button" type="submit"><?= parfum_text('simulate_payment') ?> →</button>
                        </form>
                    </div>
                </div>
            </div>

            <aside class="summary-card">
                <h2><?= parfum_text('order_details') ?></h2>
                <div style="max-height: 340px; overflow-y: auto; margin-bottom: 15px;">
                    <div style="margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px solid var(--line);">
                        <p style="font-size: 12px; color: var(--muted); margin: 0 0 4px;"><strong><?= parfum_text('customer') ?>:</strong></p>
                        <p style="font-size: 13px; margin: 0; line-height: 1.6;">
                            <strong><?= esc($order['customer_name']) ?></strong><br>
                            <span style="color: var(--muted);"><?= esc($order['phone']) ?></span><br>
                        </p>
                    </div>
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="summary-line" style="font-size: 13px; margin-bottom: 10px;">
                            <span><?= esc($item['name']) ?> · <?= (int) $item['sprays'] ?> <?= parfum_text('spray') ?> × <?= (int) $item['quantity'] ?></span>
                            <strong>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="summary-total"><span><?= parfum_text('total') ?></span><span>Rp<?= number_format($order['total'], 0, ',', '.') ?></span></div>
            </aside>
        </div>
    </div>
</section>
