<?php

if (!function_exists('parfum_text')) {
    function parfum_text(string $key): string
    {
        $translations = [
            'home' => ['Beranda', 'Home'],
            'collection' => ['Koleksi', 'Collection'],
            'floral' => ['Floral', 'Floral'],
            'woody' => ['Woody', 'Woody'],
            'fresh' => ['Fresh', 'Fresh'],
            'customer_service' => ['Layanan pelanggan', 'Customer service'],
            'add_one_spray' => ['Tambah', 'Add'],
            'selected_sprays' => ['semprot dipilih', 'sprays selected'],
            'total_price' => ['Total Harga:', 'Total price:'],
            'reset' => ['Reset', 'Reset'],
            'pay' => ['Bayar', 'Pay'],
            'select_spray_first' => ['Pilih parfum terlebih dahulu.', 'Please select a fragrance first.'],
            'spray_suffix' => ['/ Semprot', '/ Spray'],
            'category_description' => ['Unisex, Moderat, Daily Wear', 'Unisex, Moderate, Daily Wear'],
            'cart' => ['Keranjang', 'Cart'],
            'hero_eyebrow' => ['Aroma favorit, sekali semprot', 'Your favorite scent, one spray at a time'],
            'hero_title' => ['Aroma pilihan, tinggal semprot.', 'Your favorite fragrance, one spray away.'],
            'hero_description' => ['Pilih parfum dan jumlah semprot yang Anda inginkan. Praktis untuk menikmati aroma favorit kapan saja.', 'Choose a fragrance and the number of sprays you want. An easy way to enjoy your favorite scent anytime.'],
            'browse_collection' => ['Pilih parfum', 'Choose a fragrance'],
            'benefit_curated' => ['Aroma pilihan', 'Curated fragrances'],
            'benefit_safe' => ['Praktis untuk setiap hari', 'Convenient for every day'],
            'benefit_signature' => ['Bayar sesuai jumlah semprot', 'Pay for each spray'],
            'collection_eyebrow' => ['Pilih aroma Anda', 'Find your fragrance'],
            'collection_title' => ['Pilih parfum', 'Choose a fragrance'],
            'collection_description' => ['Pilih jumlah semprot. Harga Rp4.000 untuk setiap 1 semprot.', 'Choose how many sprays you want. Each spray costs Rp4,000.'],
            'all_fragrances' => ['Semua aroma', 'All scents'],
            'search_placeholder' => ['Cari nama atau aroma...', 'Search name or scent...'],
            'search' => ['Cari', 'Search'],
            'no_products' => ['Parfum tidak ditemukan. Coba kata kunci atau kategori lain.', 'No fragrances found. Try another search or category.'],
            'spray_options' => ['Pilih jumlah semprot', 'Choose number of sprays'],
            'spray' => ['Semprot', 'Spray'],
            'per_spray' => ['Rp4.000 / semprot', 'Rp4,000 / spray'],
            'quantity' => ['Jumlah', 'Quantity'],
            'add_to_cart' => ['Tambah ke keranjang', 'Add to cart'],
            'badge_best_seller' => ['Terlaris', 'Best seller'],
            'badge_favorite' => ['Favorit', 'Favorite'],
            'badge_fresh_pick' => ['Aroma segar', 'Fresh pick'],
            'selected_total' => ['Total pilihan', 'Selected total'],
            'unit' => ['per item', 'per item'],
            'cart_title' => ['Keranjang belanja', 'Shopping cart'],
            'your_selection' => ['Pilihan Anda', 'Your selection'],
            'cart_description' => ['Periksa pilihan parfum dan jumlah semprot Anda.', 'Review your fragrances and spray counts.'],
            'cart_empty' => ['Keranjang Anda masih kosong', 'Your cart is empty'],
            'cart_empty_description' => ['Pilih parfum dan jumlah semprot untuk melanjutkan.', 'Choose a fragrance and number of sprays to continue.'],
            'view_collection' => ['Lihat koleksi parfum', 'Browse fragrances'],
            'sprays_each' => ['semprot per item', 'sprays per item'],
            'unit_price' => ['Harga per item', 'Price per item'],
            'update' => ['Perbarui', 'Update'],
            'remove' => ['Hapus', 'Remove'],
            'continue_shopping' => ['← Pilih parfum lain', '← Choose another fragrance'],
            'clear_cart' => ['Kosongkan keranjang', 'Clear cart'],
            'order_summary' => ['Ringkasan pesanan', 'Order summary'],
            'item_count' => ['Jumlah item', 'Items'],
            'total' => ['Total', 'Total'],
            'checkout' => ['Lanjut ke checkout', 'Continue to checkout'],
            'checkout_title' => ['Checkout', 'Checkout'],
            'checkout_description' => ['Masukkan nama dan nomor telepon untuk melanjutkan ke pembayaran.', 'Enter your name and phone number to continue to payment.'],
            'step_cart' => ['1. Keranjang', '1. Cart'],
            'step_checkout' => ['2. Checkout', '2. Checkout'],
            'step_payment' => ['3. Pembayaran', '3. Payment'],
            'customer_details' => ['Informasi pelanggan', 'Customer details'],
            'name' => ['Nama', 'Name'],
            'phone' => ['Nomor telepon', 'Phone number'],
            'back' => ['← Kembali', '← Back'],
            'continue_payment' => ['Lanjut ke pembayaran →', 'Continue to payment →'],
            'payment_title' => ['Pembayaran QRIS', 'QRIS payment'],
            'payment_description' => ['Pindai kode QR untuk menyelesaikan pembayaran.', 'Scan the QR code to complete your payment.'],
            'demo_payment' => ['QRIS DEMO', 'QRIS DEMO'],
            'demo_notice' => ['Gambar QR ini hanya contoh dan tidak dapat digunakan untuk pembayaran.', 'This QR image is a placeholder and cannot be used for payment.'],
            'demo_payment_warning' => ['Mode demo: pembayaran tidak diproses dan tidak ada transaksi nyata.', 'Demo mode: no payment is processed and no real transaction takes place.'],
            'order_number' => ['No. Pesanan', 'Order number'],
            'waiting_payment' => ['Menunggu pembayaran', 'Awaiting payment'],
            'payment_total' => ['Total pembayaran', 'Payment total'],
            'back_checkout' => ['← Kembali ke checkout', '← Back to checkout'],
            'simulate_payment' => ['Simulasikan pembayaran', 'Simulate payment'],
            'order_details' => ['Detail pesanan', 'Order details'],
            'customer' => ['Pelanggan', 'Customer'],
            'success_title' => ['Pembayaran berhasil', 'Payment successful'],
            'success_description' => ['Terima kasih. Silakan nikmati aroma pilihan Anda.', 'Thank you. Enjoy your chosen fragrance.'],
            'order_time' => ['Waktu pesanan', 'Order time'],
            'demo_completed' => ['Ini adalah simulasi. Pembayaran tidak diproses dan kode QR tidak dapat dipindai.', 'This is a simulation. No payment was processed and the QR code cannot be scanned.'],
            'new_order' => ['Pesanan baru', 'New order'],
            'help_at_kiosk' => ['Butuh bantuan? Silakan hubungi petugas di lokasi.', 'Need help? Please ask the on-site staff.'],
            'error_invalid_product' => ['Produk atau pilihan jumlah semprot tidak valid.', 'The product or spray selection is invalid.'],
            'success_added' => ['Pilihan berhasil ditambahkan ke keranjang.', 'Your selection was added to the cart.'],
            'error_invalid_cart' => ['Data keranjang tidak valid.', 'The cart data is invalid.'],
            'error_quantity' => ['Jumlah harus antara 0 dan 10.', 'Quantity must be between 0 and 10.'],
            'success_updated' => ['Keranjang berhasil diperbarui.', 'Cart updated.'],
            'success_removed' => ['Pilihan dihapus dari keranjang.', 'Selection removed from cart.'],
            'success_cleared' => ['Keranjang berhasil dikosongkan.', 'Cart cleared.'],
            'error_empty_checkout' => ['Tambahkan parfum sebelum melanjutkan checkout.', 'Add a fragrance before continuing to checkout.'],
            'error_empty_cart' => ['Keranjang Anda kosong.', 'Your cart is empty.'],
            'error_payment_missing' => ['Silakan lengkapi checkout terlebih dahulu.', 'Please complete checkout first.'],
            'error_order_missing' => ['Pesanan tidak ditemukan. Silakan mulai kembali.', 'Order not found. Please start again.'],
            'success_payment_cancelled' => ['Pembayaran dibatalkan. Keranjang Anda tetap tersimpan.', 'Payment cancelled. Your cart is still saved.'],
            'error_no_completed_order' => ['Belum ada pesanan yang selesai.', 'There is no completed order yet.'],
            'error_checkout_form' => ['Mohon periksa kembali nama dan nomor telepon.', 'Please check your name and phone number.'],
            'form_error_heading' => ['Periksa kembali data berikut:', 'Please review the following details:'],
        ];

        $language = session()->get('parfum_language') === 'en' ? 1 : 0;

        return $translations[$key][$language] ?? $key;
    }
}

if (!function_exists('parfum_language_url')) {
    function parfum_language_url(string $language): string
    {
        $uri = service('request')->getUri();
        $returnTo = trim($uri->getPath(), '/');
        $query = $uri->getQuery();
        if ($query !== '') {
            $returnTo .= '?' . $query;
        }

        return base_url('parfum/bahasa/' . $language) . '?return=' . rawurlencode($returnTo);
    }
}
