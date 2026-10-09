<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Parfum extends BaseController
{
    protected $helpers = ['form'];
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = session();
        $this->session->start();
    }

    private const PRODUCTS = [
        'velvet-athena' => [
            'id' => 'velvet-athena',
            'name' => 'Velvet Athena',
            'brand' => 'Scentus Signature',
            'category' => 'Floral',
            'notes' => 'Peony, rose, musk',
            'description' => 'Aroma floral lembut dengan sentuhan musk yang elegan untuk menemani aktivitas sehari-hari.',
            'price' => 89000,
            'image' => 'parfum1.png',
            'badge' => 'Best seller',
        ],
        'noble-hint' => [
            'id' => 'noble-hint',
            'name' => 'Noble Hint',
            'brand' => 'Scentus Signature',
            'category' => 'Woody',
            'notes' => 'Bergamot, cedarwood, amber',
            'description' => 'Karakter woody yang hangat dan berkelas, cocok untuk momen spesial maupun harian.',
            'price' => 105000,
            'image' => 'parfum2.jpg',
            'badge' => 'Favorit',
        ],
        'bright-crystal' => [
            'id' => 'bright-crystal',
            'name' => 'Bright Crystal',
            'brand' => 'Scentus Collection',
            'category' => 'Fresh',
            'notes' => 'Yuzu, lotus, amber',
            'description' => 'Perpaduan segar dan ringan untuk memberi kesan bersih sepanjang hari.',
            'price' => 79000,
            'image' => 'parfum3.jpg',
            'badge' => 'Fresh pick',
        ],
    ];

    public function index()
    {
        $search = trim((string) $this->request->getGet('q'));
        $category = trim((string) $this->request->getGet('kategori'));
        $products = array_filter(self::PRODUCTS, static function (array $product) use ($search, $category): bool {
            $matchesSearch = $search === ''
                || stripos($product['name'] . ' ' . $product['brand'] . ' ' . $product['notes'], $search) !== false;
            $matchesCategory = $category === '' || $product['category'] === $category;

            return $matchesSearch && $matchesCategory;
        });

        return view('parfum/index', [
            'products' => $products,
            'search' => $search,
            'category' => $category,
            'cartCount' => array_sum($this->getCartData()),
        ]);
    }

    public function cart()
    {
        $cart = $this->cartDetails();

        return view('parfum/cart', $cart + ['cartCount' => array_sum($this->getCartData())]);
    }

    public function addToCart()
    {
        $productId = (string) $this->request->getPost('product_id');
        $quantity = filter_var($this->request->getPost('quantity') ?? 1, FILTER_VALIDATE_INT);

        if (!isset(self::PRODUCTS[$productId]) || $quantity === false || $quantity < 1 || $quantity > 10) {
            return redirect()->to(base_url('parfum'))->with('error', 'Produk atau jumlah yang dipilih tidak valid.');
        }

        $cart = $this->getCartData();
        $cart[$productId] = min(10, ($cart[$productId] ?? 0) + $quantity);
        service('session')->set('parfum_cart', $cart);

        return redirect()->to(base_url('parfum/keranjang'))->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function updateCart()
    {
        $quantities = $this->request->getPost('quantity');
        if (!is_array($quantities)) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', 'Data keranjang tidak valid.');
        }

        $cart = $this->getCartData();
        foreach ($quantities as $productId => $quantity) {
            if (!isset(self::PRODUCTS[$productId])) {
                continue;
            }

            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
            if ($quantity === false || $quantity < 0 || $quantity > 10) {
                return redirect()->to(base_url('parfum/keranjang'))->with('error', 'Jumlah produk harus antara 0 dan 10.');
            }

            if ($quantity === 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId] = $quantity;
            }
        }

        service('session')->set('parfum_cart', $cart);

        return redirect()->to(base_url('parfum/keranjang'))->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function removeFromCart($productId)
    {
        $cart = $this->getCartData();
        unset($cart[$productId]);
        service('session')->set('parfum_cart', $cart);

        return redirect()->to(base_url('parfum/keranjang'))->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clearCart()
    {
        service('session')->remove('parfum_cart');

        return redirect()->to(base_url('parfum/keranjang'))->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout()
    {
        $cart = $this->cartDetails();
        if ($cart['items'] === []) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', 'Tambahkan produk sebelum melanjutkan checkout.');
        }

        return view('parfum/checkout', $cart + ['cartCount' => array_sum($this->getCartData())]);
    }

    public function placeOrder()
    {
        $cart = $this->cartDetails();
        if ($cart['items'] === []) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', 'Keranjang Anda kosong.');
        }

        $rules = [
            'customer_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|min_length[8]|max_length[20]',
            'address' => 'required|min_length[8]|max_length[500]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $order = [
            'number' => 'SC' . date('ymd') . strtoupper(bin2hex(random_bytes(3))),
            'customer_name' => trim((string) $this->request->getPost('customer_name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'address' => trim((string) $this->request->getPost('address')),
            'items' => $cart['items'],
            'total' => $cart['total'],
        ];

        service('session')->set('parfum_pending_order', $order);

        return redirect()->to(base_url('parfum/pembayaran'));
    }

    public function payment()
    {
        $order = service('session')->get('parfum_pending_order');
        if (!is_array($order)) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', 'Silakan lengkapi checkout terlebih dahulu.');
        }

        return view('parfum/payment', [
            'order' => $order,
            'cartCount' => array_sum($this->getCartData()),
        ]);
    }

    public function confirmPayment()
    {
        $order = service('session')->get('parfum_pending_order');
        if (!is_array($order)) {
            return redirect()->to(base_url('parfum'))->with('error', 'Pesanan tidak ditemukan. Silakan mulai kembali.');
        }

        $order['paid_at'] = date('d M Y, H:i');
        service('session')->set('parfum_completed_order', $order);
        service('session')->remove(['parfum_pending_order', 'parfum_cart']);

        return redirect()->to(base_url('parfum/pesanan-selesai'));
    }

    public function cancelPayment()
    {
        service('session')->remove('parfum_pending_order');

        return redirect()->to(base_url('parfum/keranjang'))->with('success', 'Pembayaran dibatalkan. Isi keranjang Anda tetap tersimpan.');
    }

    public function completed()
    {
        $order = service('session')->get('parfum_completed_order');
        if (!is_array($order)) {
            return redirect()->to(base_url('parfum'))->with('error', 'Belum ada pesanan yang selesai.');
        }

        return view('parfum/completed', [
            'order' => $order,
            'cartCount' => 0,
        ]);
    }

    public function productImage($filename)
    {
        $allowedImages = array_column(self::PRODUCTS, 'image');
        if (!in_array($filename, $allowedImages, true)) {
            return $this->response->setStatusCode(404);
        }

        $path = ROOTPATH . 'image' . DIRECTORY_SEPARATOR . $filename;
        if (!is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $image = file_get_contents($path);
        if ($image === false) {
            return $this->response->setStatusCode(500);
        }

        $mimeType = mime_content_type($path) ?: 'application/octet-stream';

        return $this->response->setHeader('Content-Type', $mimeType)->setBody($image);
    }

    private function getCartData(): array
    {
        $cart = service('session')->get('parfum_cart');
        if (!is_array($cart)) {
            return [];
        }

        $validCart = [];
        foreach ($cart as $productId => $quantity) {
            if (isset(self::PRODUCTS[$productId]) && is_int($quantity) && $quantity > 0 && $quantity <= 10) {
                $validCart[$productId] = $quantity;
            }
        }

        return $validCart;
    }

    private function cartDetails(): array
    {
        $items = [];
        $total = 0;

        foreach ($this->getCartData() as $productId => $quantity) {
            $product = self::PRODUCTS[$productId];
            $product['quantity'] = $quantity;
            $product['subtotal'] = $product['price'] * $quantity;
            $items[] = $product;
            $total += $product['subtotal'];
        }

        return ['items' => $items, 'total' => $total];
    }
}
