<!DOCTYPE html>
<html lang="<?= session()->get('parfum_language') === 'en' ? 'en' : 'id' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#382b37">
    <title><?= esc($pageTitle ?? 'Scentus Parfum') ?> | Scentus</title>
    <link rel="stylesheet" href="<?= base_url('parfum.css') ?>?v=5">
    <script src="<?= base_url('parfum.js') ?>?v=5" defer></script>
</head>
<body>
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="<?= base_url('parfum') ?>">SCENTUS</a>
            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="<?= base_url('parfum') ?>"><?= parfum_text('home') ?></a>
                <a href="<?= base_url('parfum#koleksi') ?>"><?= parfum_text('collection') ?></a>
            </nav>
            <div class="nav-actions">
                <div class="language-switch" aria-label="Language">
                    <a class="<?= session()->get('parfum_language') !== 'en' ? 'active' : '' ?>" href="<?= esc(parfum_language_url('id')) ?>">ID</a>
                    <a class="<?= session()->get('parfum_language') === 'en' ? 'active' : '' ?>" href="<?= esc(parfum_language_url('en')) ?>">EN</a>
                </div>
                <a class="customer-service-link" href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer">
                    <span aria-hidden="true">☎</span><?= parfum_text('customer_service') ?>
                </a>
                <a class="nav-cart" href="<?= base_url('parfum/keranjang') ?>" aria-label="<?= esc(parfum_text('cart')) ?>">
                    <span><?= parfum_text('cart') ?></span><span class="cart-count"><?= (int) ($cartCount ?? 0) ?></span>
                </a>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="flash success" role="status"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="flash error" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif ?>
        </div>
