<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('parfum', 'Parfum::index');
$routes->get('parfum/bahasa/(:segment)', 'Parfum::setLanguage/$1');
$routes->get('parfum/produk/(:segment)', 'Parfum::productImage/$1');
$routes->get('parfum/keranjang', 'Parfum::cart');
$routes->post('parfum/keranjang/tambah', 'Parfum::addToCart');
$routes->post('parfum/checkout/mulai', 'Parfum::beginCheckout');
$routes->post('parfum/keranjang/perbarui', 'Parfum::updateCart');
$routes->post('parfum/keranjang/hapus/(:segment)/(:num)', 'Parfum::removeFromCart/$1/$2');
$routes->post('parfum/keranjang/kosongkan', 'Parfum::clearCart');
$routes->get('parfum/checkout', 'Parfum::checkout');
$routes->post('parfum/checkout', 'Parfum::placeOrder');
$routes->get('parfum/pembayaran', 'Parfum::payment');
$routes->post('parfum/pembayaran/konfirmasi', 'Parfum::confirmPayment');
$routes->post('parfum/pembayaran/batal', 'Parfum::cancelPayment');
$routes->get('parfum/pesanan-selesai', 'Parfum::completed');
