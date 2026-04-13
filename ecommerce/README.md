# MIDA — Tunisian Culinary Heritage Platform

MIDA is a bilingual (French/English) Laravel platform combining editorial culture content, e-learning, workshops, and a marketplace.

## Tech compatibility
- PHP **8.0.30** compatible code style
- Laravel-style MVC compatible with Laravel 9 conventions
- MySQL 8
- Blade + TailwindCSS + Alpine.js
- Eloquent ORM, Form Requests, Policies/Gates, Seeders/Factories

## Architecture overview
### Areas
- **Public area**: home, about, content, courses, workshops, marketplace, contact.
- **User area**: account dashboard, my courses, booking history, order history.
- **Vendor area**: vendor dashboard, product management with search/pagination.
- **Admin area**: KPI dashboard + module management screens.

### Role model
- `user`
- `vendor`
- `admin`

Role checks use Gates + middleware (`can:vendor-area`, `can:admin-area`, `role:*`).

### Localization
- Language files in `resources/lang/fr/messages.php` and `resources/lang/en/messages.php`
- Middleware `SetLocale` loads locale from session
- Header switcher exposes `FR` / `EN`

## Database schema (core tables)
- Users: role + locale
- Vendor: `vendor_profiles`
- Editorial: `contents`, `categories`, `tags`, `content_tag`
- E-learning: `courses`, `lessons`, `enrollments`, `lesson_progress`
- Workshops: `workshops`, `workshop_bookings`, `workshop_subscriptions`
- Marketplace: `products`, `cart_items`, `orders`, `order_items`
- Contact: `contact_inquiries`
- Favorites: `favorites` (polymorphic)

## Setup steps
1. Install dependencies:
   ```bash
   composer install
   npm install
   ```
2. Configure env:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Configure database in `.env` (MySQL 8).
4. Run migrations + seeds:
   ```bash
   php artisan migrate --seed
   ```
5. Start app:
   ```bash
   php artisan serve
   ```

## Demo accounts
After seeding:
- Admin: `admin@mida.tn` / `password`
- Vendor: `vendor@mida.tn` / `password`

## Marketplace flow
- Authenticated users can add marketplace products to cart, update quantities, remove items, and checkout.
- Checkout captures billing/shipping details and places an order in a DB transaction.
- Order items are persisted and product stock is decremented on successful placement.
- Users can review order confirmation and full order history from dashboard.


## Workshop email subscriptions
- Workshop pages now include a public subscription form (name, email, phone, seats).
- Each successful subscription sends a confirmation email using Laravel Mail.
- For Gmail SMTP, use these `.env` values:
  - `MAIL_MAILER=smtp`
  - `MAIL_HOST=smtp.gmail.com`
  - `MAIL_PORT=587`
  - `MAIL_ENCRYPTION=tls`
  - `MAIL_USERNAME=<your-gmail-address>`
  - `MAIL_PASSWORD=<your-google-app-password>`

## Notes for Laravel 9
If upgrading base dependencies to Laravel 9, this code structure remains compatible (no PHP 8.1-only syntax used).
