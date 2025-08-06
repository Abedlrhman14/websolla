#  Laravel Simple E-Commerce Store

This is a basic e-commerce application built with **Laravel**. It allows users to browse products, add them to a cart, proceed to checkout without logging in, and for admins to manage products and view orders.

---

##  Features

- Public product listing
- Add to cart (AJAX)
- Cart and checkout form (name, phone, address)
- Order saving with cart details
- Authentication for admin
- Admin dashboard to:
- Manage products (CRUD)
- View all customer orders

---

## Technologies Used

- Laravel 11+
- Blade (templating)
- Bootstrap 5
- jQuery (for AJAX requests)
- MySQL

---

## Screens Included

- Home Page (Products)
- Cart Page
- Dashboard (with cards to manage products and view orders)
- Orders Table inside dashboard

---

##  Installation Steps

1. **Clone the repo**
   ```bash
   git clone https://github.com/Abedlrhman14/websolla.git
   cd your-project

2. **Install dependencies**
composer install
npm install && npm run dev

3. **Setup enviroment**
cp .env.example .env
php artisan key:generate

4. Configure .env

Setup DB credentials (MySQL)

Optional: mail setting

5. **Run migrations**
php artisan migrate

6. **Serve the project**
php artisan serve


Notes: 

Cart is saved in session and does not require user authentication.

Admin login is required to manage products and view orders.

Orders are stored with customer name, phone, address, and cart items in JSON format.

