# SubMate Pro

**Live Demo**: [https://submate-pro.arhamnatiq.com](https://submate-pro.arhamnatiq.com)  
**Demo Login**:  
📧 Email: `test@gmail.com`  
🔒 Password: `password`

SubMate Pro is a subscription-based SaaS starter kit built with **Laravel** and **Vue.js**, designed for managing user subscriptions, team-based billing, and payment processing via **Stripe**. It features secure double authentication using **JWT** and **Laravel Sentinel**, and is ideal for developers looking to quickly launch or prototype subscription-driven web applications.

---

## 🔧 Features

- 🛡️ **Double Authentication System**  
  Combines JWT and Laravel Sentinel for enhanced security.

- 💳 **Stripe Payment Integration**  
  Uses Stripe Elements to securely process payments.

- 📅 **Subscription Plans**  
  Supports Basic and Premium plans, each with monthly and yearly billing options.

- 🧑‍💼 **Team Member Management**  
  Registered users can add and pay for team members under their account.

- 💰 **Transaction History**  
  Complete history of payments and actions in a dedicated transaction table.

- 🔁 **Refund System**  
  Integrated refund mechanism using Stripe's refund API.

- ⚙️ **Plans & Features CRUD**  
  Fully customizable plans and features via CRUD operations.

- 👥 **User Overview**  
  Admin view of all users who have subscribed to plans.

---

## 📦 Tech Stack

- **Backend**: Laravel 10+, Laravel Sentinel, JWT Auth
- **Frontend**: Vue.js 3
- **Payments**: Stripe Elements & API
- **Database**: MySQL

---

## 🚀 Getting Started

1. Clone the repo:
   ```bash
   git clone https://github.com/arham-natiq25/SubMate-Pro.git
   cd SubMate-Pro
2. Install dependencies:

composer install
npm install && npm run dev

3.Set up .env file:

    Configure database, mail, and Stripe keys.

4.Run migrations:

php artisan migrate --seed

5.Serve the application:

php artisan serve
