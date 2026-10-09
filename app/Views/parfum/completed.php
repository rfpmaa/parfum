<?= $this->include('parfum/partials/header', ['pageTitle' => parfum_text('success_title')]) ?>

<section class="content-section" style="text-align: center;">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">✓</div>
            <h1><?= parfum_text('success_title') ?></h1>
            <p style="color: var(--muted); margin: 8px 0 24px;"><?= parfum_text('success_description') ?></p>

            <div class="order-details">
                <div class="summary-line">
                    <span><?= parfum_text('order_number') ?></span>
                    <strong><span class="order-number"><?= esc($order['number']) ?></span></strong>
                </div>
                <div class="summary-line">
                    <span><?= parfum_text('payment_total') ?></span>
                    <strong>Rp<?= number_format($order['total'], 0, ',', '.') ?></strong>
                </div>
                <div class="summary-line">
                    <span><?= parfum_text('order_time') ?></span>
                    <strong><?= $order['paid_at'] ?></strong>
                </div>
                <div class="summary-line">
                    <span><?= parfum_text('customer') ?></span>
                    <strong><?= esc($order['customer_name']) ?></strong>
                </div>
            </div>

            <div style="background: #f0faf3; border: 1px solid #c9e4d2; border-radius: 8px; padding: 16px; margin: 24px 0;">
                <p style="font-size: 13px; color: var(--success); margin: 0;">
                    <?= parfum_text('demo_completed') ?>
                </p>
            </div>

            <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 28px;">
                <a class="button outline" href="<?= base_url('parfum') ?>"><?= parfum_text('new_order') ?></a>
            </div>
        </div>
    </div>
</section>
