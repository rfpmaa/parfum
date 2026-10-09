<?= $this->include('parfum/partials/header', ['pageTitle' => parfum_text('checkout_title')]) ?>

<section class="page-heading">
    <div class="container">
        <div class="breadcrumbs"><a href="<?= base_url('parfum') ?>"><?= parfum_text('home') ?></a> &nbsp;/&nbsp; <a href="<?= base_url('parfum/keranjang') ?>"><?= parfum_text('cart') ?></a> &nbsp;/&nbsp; <?= parfum_text('checkout_title') ?></div>
        <span class="eyebrow"><?= parfum_text('step_checkout') ?></span>
        <h1><?= parfum_text('checkout_title') ?></h1>
        <p><?= parfum_text('checkout_description') ?></p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="checkout-layout">
            <div>
                <div class="step-list" aria-label="Langkah checkout">
                    <div class="step active"><?= parfum_text('step_cart') ?></div>
                    <div class="step active"><?= parfum_text('step_checkout') ?></div>
                    <div class="step"><?= parfum_text('step_payment') ?></div>
                </div>

                <form action="<?= base_url('parfum/checkout') ?>" method="post" class="form-card">
                    <?= csrf_field() ?>
                    <?php $errors = session()->getFlashdata('errors') ?? []; ?>

                    <?php if (isset($errors) && $errors !== []): ?>
                        <div class="form-errors">
                            <strong><?= parfum_text('form_error_heading') ?></strong>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <h2><?= parfum_text('customer_details') ?></h2>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name"><?= parfum_text('name') ?></label>
                            <input class="field" id="name" type="text" name="customer_name" maxlength="100" required value="<?= old('customer_name') ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone"><?= parfum_text('phone') ?></label>
                            <input class="field" id="phone" type="tel" name="phone" maxlength="20" required value="<?= old('phone') ?>">
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <a class="button outline" href="<?= base_url('parfum/keranjang') ?>"><?= parfum_text('back') ?></a>
                        <button class="button" type="submit"><?= parfum_text('continue_payment') ?></button>
                    </div>
                </form>
                <p class="secure-note"><?= parfum_text('help_at_kiosk') ?></p>
            </div>

            <aside class="summary-card">
                <h2><?= parfum_text('order_summary') ?></h2>
                <div style="max-height: 300px; overflow-y: auto; margin-bottom: 15px;">
                    <?php foreach ($items as $item): ?>
                        <div class="summary-line" style="font-size: 13px;">
                            <span><?= esc($item['name']) ?> · <?= (int) $item['sprays'] ?> <?= parfum_text('spray') ?> × <?= (int) $item['quantity'] ?></span>
                            <strong>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="summary-total"><span><?= parfum_text('total') ?></span><span>Rp<?= number_format($total, 0, ',', '.') ?></span></div>
            </aside>
        </div>
    </div>
</section>
