# SCENTUS Parfum Kiosk

A CodeIgniter 4 demo ordering flow for a parfum spray kiosk monitor. It has no delivery flow, address collection, published-store footer, database persistence, or real payment gateway.

## Features

- A kiosk selection screen with three fragrance cards, spray counters, a running total, Reset, and Pay.
- Each click on Add selects one spray at **Rp4.000**; the plus/minus controls adjust the number selected.
- Session-based cart, checkout with customer name and phone only, payment screen, and order confirmation.
- Indonesian and English language toggle in the header.
- Customer service opens WhatsApp at the temporary number `6281234567890`; replace it with the business number later.
- A local QRIS-style placeholder image on the payment page. It is **not scannable** and must not be used for payment.

## Run locally

From the project folder:

```powershell
php spark serve --host 127.0.0.1 --port 8080
```

Open `http://127.0.0.1:8080/parfum`.

## Main files

- `app/Controllers/Parfum.php` — catalog, cart variants, checkout, and order session flow.
- `app/Helpers/parfum_helper.php` — Indonesian/English labels and language-switch URLs.
- `app/Views/parfum/` — separate catalog, cart, checkout, payment, and confirmation pages.
- `public/parfum.css` and `public/parfum.js` — kiosk UI styling and spray/quantity controls.
- `public/images/qris-demo.svg` — non-functional payment placeholder.

All cart and order state is kept in the PHP session for this demo. Use a real QRIS/payment provider and persistent order storage before accepting payments.
