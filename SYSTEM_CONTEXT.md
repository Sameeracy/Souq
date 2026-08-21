# Souq Marketplace — System Architecture & Context

**Application Name:** Souq  
**Framework:** Laravel (v11.x)  
**Authentication:** Laravel Breeze  
**Authorization / Role Management:** Spatie Laravel-Permission (`spatie/laravel-permission`)  
**Frontend Stack:** Blade, Tailwind CSS, Alpine.js, Vite  
**Currency:** Pakistani Rupee (`PKR` / `Rs.`)  

---

## 1. System Roles & Access Control

| Role | Access Scope & Permissions | Post-Login Landing Page |
| :--- | :--- | :--- |
| **`admin`** | Full platform authority: View gross platform sales grouped by seller, edit any product, delete any product, delete user/seller accounts. | `/admin/dashboard` |
| **`seller`** | Merchant portal: Create/edit/delete personal products, upload product images, configure dynamic variants (e.g. Size, Color), and receive live buyer delivery & contact notes in the dashboard inbox. | `/seller/dashboard` |
| **`user`** (Buyer) | Customer storefront: Search/browse products, view product details, choose variants, manage shopping cart, checkout with delivery address and contact details, view order history. | `/` (Storefront) or `/my-orders` |

---

## 2. Database Schema & Relationships

### `users`
- Standard Breeze credentials (`id`, `name`, `email`, `password`, `timestamps`).
- Assigned Spatie roles (`admin`, `seller`, `user`).
- **Relationships:**
  - `products()`: `hasMany(Product::class, 'seller_id')`
  - `sellerOrderItems()`: `hasMany(OrderItem::class, 'seller_id')` (Seller delivery inbox feed)
  - `orders()`: `hasMany(Order::class, 'user_id')` (Buyer purchase history)

### `products`
- **Fields:** `id`, `seller_id` (FK -> `users`), `title`, `description`, `price`, `image_path` (nullable), `timestamps`.
- **Relationships:**
  - `seller()`: `belongsTo(User::class, 'seller_id')`
  - `options()`: `hasMany(ProductOption::class)`

### `product_options` (Dynamic Variants & Pricing)
- **Fields:** `id`, `product_id` (FK -> `products`, cascade), `name` (e.g. "Size", "Color"), `value` (e.g. "Large", "Emerald Green"), `price` (decimal, nullable - custom variant price in PKR), `timestamps`.
- **Relationships:**
  - `product()`: `belongsTo(Product::class)`
- **Accessors:**
  - `effective_price`: Returns variant custom price if set, falling back to `$product->price`.

### `carts` (Shopping Cart)
- **Fields:** `id`, `user_id` (FK -> `users`), `product_id` (FK -> `products`), `product_option_id` (nullable FK -> `product_options`), `quantity`, `timestamps`.
- **Relationships:**
  - `product()`: `belongsTo(Product::class)`
  - `option()`: `belongsTo(ProductOption::class, 'product_option_id')`

### `orders` (Master Buyer Order)
- **Fields:** `id`, `user_id` (FK -> `users`), `delivery_address` (text), `contact_details` (string), `total_amount` (decimal), `status` (enum: `pending`, `processing`, `completed`, `cancelled`), `timestamps`.
- **Relationships:**
  - `user()`: `belongsTo(User::class)`
  - `items()`: `hasMany(OrderItem::class)`

### `order_items` (Seller Delivery Routing)
- **Fields:** `id`, `order_id` (FK -> `orders`), `seller_id` (FK -> `users`), `product_id` (FK -> `products`), `product_option_id` (nullable FK -> `product_options`), `quantity`, `price`, `timestamps`.
- **Relationships:**
  - `order()`: `belongsTo(Order::class)`
  - `seller()`: `belongsTo(User::class, 'seller_id')`
  - `product()`: `belongsTo(Product::class)`
  - `option()`: `belongsTo(ProductOption::class, 'product_option_id')`

---

## 3. Core Controllers & Routes

### `ShopController`
- `GET /` (`home`): Searchable storefront product catalog.
- `GET /product/{product}` (`product.show`): Product details with dynamic variant selector and "Add to Cart".
- `GET /cart` (`cart.index`): Cart summary with subtotal and checkout form.
- `POST /cart/{product}` (`cart.add`): Adds product with selected option to cart.
- `POST /cart/remove/{cart}` (`cart.remove`): Removes item from cart.
- `POST /checkout` (`checkout`): Atomic DB transaction creating master order + seller-partitioned order items, clearing cart.
- `GET /my-orders` (`orders.my`): Customer order history with fulfillment status.

### `SellerProductController` (Protected by `role:seller`)
- `GET /seller/dashboard` (`seller.dashboard`): Performance KPIs, listed products management (Add/Edit/Delete), and **Live Buyer Delivery & Contact Details side box**.
- `GET /seller/products/create` (`seller.products.create`): Product creation form with Alpine.js dynamic variant adder.
- `POST /seller/products` (`seller.products.store`): Saves product, handles image upload, and stores dynamic variants.
- `GET /seller/products/{product}/edit` (`seller.products.edit`): Edit product and manage variants.
- `PUT /seller/products/{product}` (`seller.products.update`): Updates product details and variants.
- `DELETE /seller/products/{product}` (`seller.products.destroy`): Removes seller's product.

### `SellerOrderController` (Protected by `role:seller`)
- `GET /seller/orders` (`seller.orders.index`): Dedicated full order delivery inbox showing buyer contact info and shipping destinations.

### `AdminController` (Protected by `role:admin`)
- `GET /admin/dashboard` (`admin.dashboard`): Gross platform stats, Seller sales analytics breakdown, full marketplace product catalog moderation, and user/seller account deletion.
- `GET /admin/products/{product}/edit` (`admin.products.edit`): Admin edit form for any product.
- `PUT /admin/products/{product}` (`admin.products.update`): Admin update for any product.
- `DELETE /admin/products/{product}` (`admin.products.destroy`): Admin delete for any product.
- `DELETE /admin/users/{user}` (`admin.users.destroy`): Admin delete user or seller (cascading deletes products/orders).

### `Auth` (`RegisteredUserController` & `AuthenticatedSessionController`)
- `RegisteredUserController`: Interactive role selector on registration (`user` vs `seller`).
- `AuthenticatedSessionController`: Smart redirect to role-specific dashboard (`admin.dashboard`, `seller.dashboard`, or `home`).
- `/dashboard` route: Acts as an intelligent role dispatcher for logged-in users.

---

## 4. Default Seeded Demo Accounts

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@souq.com` | `password` |
| **Seller** | `seller@souq.com` | `password` |
| **Buyer** | `buyer@souq.com` | `password` |

---

## 5. Key Design Conventions
- **Tailwind CSS Design System:** Warm slate canvas, indigo primary accents, emerald success indicators, and clean rounded card layouts (`rounded-2xl` / `rounded-3xl`).
- **Alpine.js Dynamic Variants:** Used on product create & edit views to enable seamless addition and removal of product option attributes (`options.push()`, `options.splice()`).
- **Seller Delivery Box:** Specifically built as a notification drawer (not a chat), ensuring sellers have clear, copyable access to buyer delivery addresses and contact information upon order placement.