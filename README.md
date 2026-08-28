```markdown
# Souq Marketplace : Multi-Vendor E-Commerce Platform

## 📌 Project Overview
**Souq** is an enterprise-grade multi-vendor e-commerce platform built with Laravel[cite: 1, 5]. It implements a multi-tenant marketplace architecture where independent sellers manage catalogs and order fulfillments, while buyers experience a unified shopping cart and secure Stripe checkout[cite: 5]. The system is built with robust security boundaries (RBAC, IDOR protection, HMAC webhook verification), ACID database transactions, dynamic variant pricing, and reactive frontends[cite: 5].

---

## 🚀 Key Features & Architectural Highlights

### 1. Multi-Vendor System Design & MVC Architecture
- **Model-View-Controller Separation:** Distinct domain layers across models (`User`, `Product`, `ProductOption`, `Order`, `OrderItem`, `Cart`), controllers (`ShopController`, `SellerProductController`, `AdminController`), and role-based Blade views[cite: 5].
- **Multi-Tenant Logical Partitioning:** Independent seller portals with partitioned sales analytics and multi-vendor order-item splitting upon unified customer checkout[cite: 5].
- **RESTful Resource Routing:** Standardized HTTP verbs (`GET`, `POST`, `PUT`, `DELETE`), route groups, and named route conventions[cite: 5].

### 2. Security & Access Control (AuthN & AuthZ)
- **Role-Based Access Control (RBAC):** Granular authorization for `admin`, `seller`, and `user` roles powered by `Spatie/laravel-permission` with route middleware protection (`role:seller`, `role:admin`)[cite: 5].
- **IDOR Prevention:** Strict resource ownership validation (e.g., verifying `$product->seller_id === Auth::id()`) returning `403 Forbidden` for unauthorized modifications[cite: 5].
- **Authentication & CSRF Defense:** Session persistence, credential hashing (`bcrypt`/`argon2id`) via Laravel Breeze, standard CSRF token verification, and explicit webhook route exemptions in bootstrap configuration[cite: 5].
- **HMAC-SHA256 Webhook Verification:** Cryptographic signature verification (`Stripe-Signature`) in `StripeWebhookController` protecting against replay and spoofing attacks[cite: 5].

### 3. Database Engineering & ACID Transactions
- **Atomic Checkout Engine:** Checkout flows wrapped in `DB::transaction()` guaranteeing atomic execution across order creation, order-item splitting, cart purging, and Stripe session generation[cite: 5].
- **N+1 Query Optimization:** Eager loading (`Product::with(['seller', 'options'])`) to eliminate N+1 database bottlenecks[cite: 5].
- **Relational Integrity & Schema Management:** Version-controlled database migrations with foreign keys, cascading delete rules, and normalized table structures[cite: 5].

### 4. Payments, Webhooks & State Machines
- **Stripe Hosted Checkout:** Secure payment session redirection eliminating PCI compliance overhead[cite: 5].
- **Event-Driven Webhook Handling:** Decoupled asynchronous order updates triggered by `checkout.session.completed` webhooks[cite: 5].
- **Dynamic Pricing Engine:** Fallback pricing logic where variant-specific pricing overrides base product prices via Eloquent model accessors (`effective_price`)[cite: 5].
- **Fulfillment Lifecycle State Machine:** Multi-state progression (`pending` → `processing` → `received` → `completed`) dynamically updating seller inbox feeds[cite: 5].

### 5. Frontend Reactivity & Asset Tooling
- **Alpine.js:** Declarative client-side reactivity for dynamic product variant creation and interactive UI states without full-page reloads[cite: 5].
- **Tailwind CSS:** Utility-first responsive design, interactive micro-states, and custom design tokens[cite: 5].
- **Vite:** Asset compilation with Hot Module Replacement (HMR) and production minification[cite: 5].

---

## 🛠 Tech Stack
- **Backend:** PHP 8.x, Laravel Framework[cite: 5]
- **Frontend:** Tailwind CSS, Alpine.js, Blade Views, Vite[cite: 5]
- **Database:** MySQL (ACID Transactions, Foreign Keys, Eloquent ORM)[cite: 5]
- **Payment Processing:** Stripe Hosted Checkout API, Stripe Webhooks[cite: 5]
- **Access Control:** Spatie Laravel-Permission[cite: 5]
- **Testing:** PHPUnit, Laravel TestBench, Mocked Webhooks[cite: 5]

---

## 📂 Project Structure Highlights
```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php[cite: 5]
│   │   ├── Auth/[cite: 5]
│   │   ├── SellerProductController.php[cite: 5]
│   │   ├── ShopController.php[cite: 5]
│   │   └── StripeWebhookController.php[cite: 5]
│   └── Middleware/[cite: 5]
├── Models/
│   ├── Cart.php[cite: 5]
│   ├── Order.php[cite: 5]
│   ├── OrderItem.php[cite: 5]
│   ├── Product.php[cite: 5]
│   ├── ProductOption.php[cite: 5]
│   └── User.php[cite: 5]
database/
└── migrations/[cite: 5]
resources/
└── views/[cite: 5]
tests/
└── Feature/
    └── StripePaymentTest.php[cite: 5]

```

---

## ⚙️ Installation & Setup

1. **Clone the repository:**
```bash
git clone [https://github.com/your-username/souq-marketplace.git](https://github.com/your-username/souq-marketplace.git)
cd souq-marketplace

```


2. **Install PHP and JavaScript dependencies:**
```bash
composer install
npm install && npm run build

```


3. **Configure environment:**
```bash
cp .env.example .env
php artisan key:generate

```


*Configure your MySQL credentials and Stripe keys in `.env`:*
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=souq_db
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=pk_test_your_key
STRIPE_SECRET=sk_test_your_key
STRIPE_WEBHOOK_SECRET=whsec_your_key

```


4. **Run migrations and seed roles:**
```bash
php artisan migrate --seed

```


5. **Start development server:**
```bash
php artisan serve

```


Access the application at `http://127.0.0.1:8000`.
6. **Listen for Stripe webhooks locally (optional):**
```bash
stripe listen --forward-to localhost:8000/stripe/webhook

```



---

## 🧪 Testing

Run the automated feature tests with database refresh and mocked webhook assertions:

```bash
php artisan test --filter StripePaymentTest


```
