# Online-Keyboard-Shop

**JK Keyboard** is an e-commerce website for selling keyboard-related products including mechanical keyboards, keyboard kits, switches, and keycaps. The platform provides a smooth online shopping experience for tech enthusiasts, gamers, and office workers alike.

---

## 🔐 Admin Login Credentials

- **Username**: `admin`  
- **Password**: `User123456789`

> The admin panel allows managing products, viewing and updating order statuses, and approving or canceling orders.

---

## 🌟 Key Features

### Users
- Product search with keywords
- Category browsing (Kit, Prebuild, Keycap, Switch)
- Sort products by name or price
- View related products
- Shopping cart management
- Place and cancel orders
- Online payment support
- User registration and login
- Forgot password reset using OTP
- Persistent login (7 days)
- Store contact and policy information

### Admin
- Add, edit, or remove products
- View and manage orders
- Update order status

---

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Development Tools**: Visual Studio Code, XAMPP, Git

---

## 🧪 Testing

- **Functional Testing**: Shopping, cart, checkout, login/logout, order tracking
- **Security Testing**: Passwords are hashed before storing in the database
- **Interface Testing**: Fully responsive on desktops, tablets, and smartphones

---

## 🗃️ Database Structure

- `users`: Stores customer information
- `products`: Product details
- `product_variants`: Product options (e.g. color, quantity)
- `cart_products`: Items in shopping cart
- `orders`, `order_products`: Order and order details
- `user_tokens`, `password_reset_tokens`: Persistent login and OTP for password resets

---

## 💻 How to Run the Website Locally

1. **Download and install [XAMPP](https://www.apachefriends.org/index.html)**

2. **Start Apache and MySQL** from the XAMPP Control Panel

3. **Create a new folder** inside the `htdocs` directory (default path: `C:\xampp\htdocs`), for example:

    ```
    C:\xampp\htdocs\keyboardshop
    ```

4. **Copy all project files** into the new folder (`keyboardshop`)

5. **Import the database**:
    - Open your browser and go to: `http://localhost/phpmyadmin`
    - Create a new database (e.g., `keyboardshop`)
    - Import the file named `keyboardshop.sql` (included in the project folder)

6. **Run the website** by visiting:

    ```
    http://localhost/keyboardshop/index.php
    ```

---

## 🔄 Maintenance and Future Plans

- Regularly update product listings and stock
- Fix reported bugs
- Add chatbot for customer support
- Implement features like product recommendations and loyalty programs
- Migrate to cloud hosting for scalability

---

## 📌 Notes

This project was developed by **Nguyễn Lê Duy Khang** following the **Software Development Life Cycle (SDLC)** methodology to ensure systematic and maintainable development.

---

Thank you for visiting JK Keyboard!
