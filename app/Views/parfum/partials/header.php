<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#382b37">
    <title><?= esc($pageTitle ?? 'Scentus Parfum') ?> | Scentus</title>
    <link rel="stylesheet" href="<?= base_url('parfum.css') ?>">
</head>
<body>
    <div class="announcement">Gratis ongkir untuk pembelian minimal Rp150.000</div>
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="<?= base_url('parfum') ?>">SCENTUS</a>
            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="<?= base_url('parfum') ?>">Beranda</a>
                <a href="<?= base_url('parfum#koleksi') ?>">Koleksi</a>
                <a href="#contact">Bantuan</a>
            </nav>
            <a class="nav-cart" href="<?= base_url('parfum/keranjang') ?>" aria-label="Keranjang belanja">
                <span>Keranjang</span><span class="cart-count"><?= (int) ($cartCount ?? 0) ?></span>
            </a>
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
