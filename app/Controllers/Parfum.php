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
        helper('parfum');
    }

    private const PRODUCTS = [
        'velvet-athena' => [
            'id' => 'velvet-athena',
            'name' => 'Velvet Athena',
            'brand' => 'Scentus Signature',
            'category' => 'Floral',
            'notes' => 'Peony, rose, musk',
            'description' => 'Aroma floral lembut dengan sentuhan musk yang elegan untuk menemani aktivitas sehari-hari.',
            'price' => 4000,
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
            'price' => 4000,
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
            'price' => 4000,
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

    public function setLanguage($language)
    {
        if (!in_array($language, ['id', 'en'], true)) {
            return redirect()->to(base_url('parfum'));
        }

        $this->session->set('parfum_language', $language);
        $returnTo = (string) $this->request->getGet('return');
        $returnTo = preg_replace('#^index\.php/#', '', $returnTo);
        if (preg_match('#^parfum(?:/|$)#', $returnTo) && !str_contains($returnTo, '..')) {
            return redirect()->to(base_url($returnTo));
        }

        return redirect()->to(base_url('parfum'));
    }

    public function cart()
    {
        $cart = $this->cartDetails();

        return view('parfum/cart', $cart + ['cartCount' => array_sum($this->getCartData())]);
    }

    public function addToCart()
    {
        $productId = (string) $this->request->getPost('product_id');
        $sprays = filter_var($this->request->getPost('sprays'), FILTER_VALIDATE_INT);
        $quantity = filter_var($this->request->getPost('quantity') ?? 1, FILTER_VALIDATE_INT);

        if (!isset(self::PRODUCTS[$productId]) || $sprays === false || $sprays < 1 || $sprays > 5 || $quantity === false || $quantity < 1 || $quantity > 10) {
            return redirect()->to(base_url('parfum'))->with('error', parfum_text('error_invalid_product'));
        }

        $cart = $this->getCartData();
        $lineKey = $productId . ':' . $sprays;
        $cart[$lineKey] = min(10, ($cart[$lineKey] ?? 0) + $quantity);
        $this->session->set('parfum_cart', $cart);

        return redirect()->to(base_url('parfum/keranjang'))->with('success', parfum_text('success_added'));
    }

    public function beginCheckout()
    {
        $selections = $this->request->getPost('sprays');
        if (!is_array($selections)) {
            return redirect()->to(base_url('parfum'))->with('error', parfum_text('select_spray_first'));
        }

        $cart = [];
        foreach ($selections as $productId => $quantity) {
            if (!isset(self::PRODUCTS[$productId])) {
                continue;
            }

            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
            if ($quantity === false || $quantity < 0 || $quantity > 10) {
                return redirect()->to(base_url('parfum'))->with('error', parfum_text('error_quantity'));
            }

            if ($quantity > 0) {
                $cart[$productId . ':1'] = $quantity;
            }
        }

        if ($cart === []) {
            return redirect()->to(base_url('parfum'))->with('error', parfum_text('select_spray_first'));
        }

        $this->session->set('parfum_cart', $cart);

        return redirect()->to(base_url('parfum/checkout'));
    }

    public function updateCart()
    {
        $quantities = $this->request->getPost('quantity');
        if (!is_array($quantities)) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', parfum_text('error_invalid_cart'));
        }

        $cart = $this->getCartData();
        foreach ($quantities as $lineKey => $quantity) {
            if (!isset($cart[$lineKey])) {
                continue;
            }

            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
            if ($quantity === false || $quantity < 0 || $quantity > 10) {
                return redirect()->to(base_url('parfum/keranjang'))->with('error', parfum_text('error_quantity'));
            }

            if ($quantity === 0) {
                unset($cart[$lineKey]);
            } else {
                $cart[$lineKey] = $quantity;
            }
        }

        $this->session->set('parfum_cart', $cart);

        return redirect()->to(base_url('parfum/keranjang'))->with('success', parfum_text('success_updated'));
    }

    public function removeFromCart($productId, $sprays)
    {
        $cart = $this->getCartData();
        unset($cart[$productId . ':' . $sprays]);
        $this->session->set('parfum_cart', $cart);

        return redirect()->to(base_url('parfum/keranjang'))->with('success', parfum_text('success_removed'));
    }

    public function clearCart()
    {
        $this->session->remove('parfum_cart');

        return redirect()->to(base_url('parfum/keranjang'))->with('success', parfum_text('success_cleared'));
    }

    public function checkout()
    {
        $cart = $this->cartDetails();
        if ($cart['items'] === []) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', parfum_text('error_empty_checkout'));
        }

        return view('parfum/checkout', $cart + ['cartCount' => array_sum($this->getCartData())]);
    }

    public function placeOrder()
    {
        $cart = $this->cartDetails();
        if ($cart['items'] === []) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', parfum_text('error_empty_cart'));
        }

        $rules = [
            'customer_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|min_length[8]|max_length[20]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', [parfum_text('error_checkout_form')]);
        }

        $order = [
            'number' => 'SC' . date('ymd') . strtoupper(bin2hex(random_bytes(3))),
            'customer_name' => trim((string) $this->request->getPost('customer_name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'items' => $cart['items'],
            'total' => $cart['total'],
        ];

        $this->session->set('parfum_pending_order', $order);

        return redirect()->to(base_url('parfum/pembayaran'));
    }

    public function payment()
    {
        $order = $this->session->get('parfum_pending_order');
        if (!is_array($order)) {
            return redirect()->to(base_url('parfum/keranjang'))->with('error', parfum_text('error_payment_missing'));
        }

        return view('parfum/payment', [
            'order' => $order,
            'cartCount' => array_sum($this->getCartData()),
        ]);
    }

    public function confirmPayment()
    {
        $order = $this->session->get('parfum_pending_order');
        if (!is_array($order)) {
            return redirect()->to(base_url('parfum'))->with('error', parfum_text('error_order_missing'));
        }

        $order['paid_at'] = date('d M Y, H:i');
        $this->session->set('parfum_completed_order', $order);
        $this->session->remove(['parfum_pending_order', 'parfum_cart']);

        return redirect()->to(base_url('parfum/pesanan-selesai'));
    }

    public function cancelPayment()
    {
        $this->session->remove('parfum_pending_order');

        return redirect()->to(base_url('parfum/keranjang'))->with('success', parfum_text('success_payment_cancelled'));
    }

    public function completed()
    {
        $order = $this->session->get('parfum_completed_order');
        if (!is_array($order)) {
            return redirect()->to(base_url('parfum'))->with('error', parfum_text('error_no_completed_order'));
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
        $cart = $this->session->get('parfum_cart');
        if (!is_array($cart)) {
            return [];
        }

        $validCart = [];
        foreach ($cart as $lineKey => $quantity) {
            $parts = explode(':', (string) $lineKey);
            $productId = $parts[0];
            $sprays = isset($parts[1]) ? filter_var($parts[1], FILTER_VALIDATE_INT) : 1;
            if (
                isset(self::PRODUCTS[$productId])
                && $sprays !== false
                && $sprays >= 1
                && $sprays <= 5
                && is_int($quantity)
                && $quantity > 0
                && $quantity <= 10
            ) {
                $normalizedKey = $productId . ':' . $sprays;
                $validCart[$normalizedKey] = min(10, ($validCart[$normalizedKey] ?? 0) + $quantity);
            }
        }

        return $validCart;
    }

    private function cartDetails(): array
    {
        $items = [];
        $total = 0;

        foreach ($this->getCartData() as $lineKey => $quantity) {
            [$productId, $sprays] = explode(':', $lineKey);
            $product = self::PRODUCTS[$productId];
            $product['lineKey'] = $lineKey;
            $product['sprays'] = (int) $sprays;
            $product['quantity'] = $quantity;
            $product['unitTotal'] = $product['price'] * $product['sprays'];
            $product['subtotal'] = $product['unitTotal'] * $quantity;
            $items[] = $product;
            $total += $product['subtotal'];
        }

        return ['items' => $items, 'total' => $total];
    }
}
