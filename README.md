<p align="center">
  <img src="https://cdn.worldvectorlogo.com/logos/laravel-2.svg" alt="Laravel Logo" height="100">
</p>

<div align="center">
  <img src="https://img.shields.io/badge/Laravel-10.0-ff2d20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Badge">
</div>


# **Inventory Management System**

#### **📋Table of Contents**

- 🔍 Project Overview
- ⚙️ Core Functionalities
- 📊 Database Structure
- 🖼️ User Interface Screenshots
- 🚀 Running the Project
- 🤝 Contribution Guidelines
- 👥 Team Members & Contact Info

## **🔍Project Overview**

The Inventory Management System is a web-based application built with PHP Laravel to manage stock, orders, and customer payments 💼. The system helps businesses track inventory in real-time with intuitive forms 📑 and robust reporting 📈.

## **⚙️Core Functionalities**

- 🛒 **Product Management:** Add, update, and manage product stock and categories.
- 📝 **Order Processing:** Handle customer orders, manage payments (💵 HandCash, 🧾 Cheque, 🕐 Due), and track order statuses.
- 👥 **Customer Management:** Store and update customer details.
- 📊 **Reports:** Generate stock, transaction, and payment status reports.

## **📊 Database Structure**

Below is a visual representation of the core tables used within the system:

**Tables Schema:**

![Screenshot](https://github.com/7amo10/Inventory-Management-System/blob/main/Documentation%20%26%20Presentation/Tables-Schema.png)

#### Tables Overview📄

main Tables:

- Products (`id`, `name`, `category_id`, `quantity`, `price`, `created_at`, `updated_at`)

- Orders (`id`, `customer_id`, `total_amount`, `payment_type`, `status`, `created_at`, `updated_at`)

- Customers (`id`, `name`, `email`, `phone_number`, `address`, `created_at`, `updated_at`)


## **🖼️User Interface Preview**

- Order Management Form

    - ![Screenshot](https://github.com/7amo10/Inventory-Management-System/blob/main/Documentation%20%26%20Presentation/asests/Orders.png)


- Purchase Management Dashboard

    - ![Screenshot](https://github.com/7amo10/Inventory-Management-System/blob/main/Documentation%20%26%20Presentation/asests/Purchases.png)


## **🚀Running the Project**

**Prerequisites**

- 🐘PHP >= 8.0
- 🧩 Composer
- 🗄️MySQL or other supported databases

## **Steps to Run Locally🔧:**

- 1.Clone the repository: 

    ```bash
    git clone https://github.com/7amo10/Inventory-Management-System.git

    ```
- 2.Navigate to the project folder:
    
    ```bash
    cd Inventory-Management-System
    ```

- 3.Install dependencies:

    ```bash
    composer install
    ```

- 4.Create a `.env` file from the example:
    
    ```bash
    cp .env.example .env
    ```
- 5.Configure your .env file with the appropriate database settings.

- 6.Run the database migrations:

    ```bash
    php artisan migrate
    ```

- 7.Seed the database (optional):

    ```bash
    php artisan db:seed
    ```

- 8.Start the Laravel development server:🌐
    ```bash
    php artisan serve
    ```

## **🤝Contribution Guidelines**

We welcome contributions from the community. Please adhere to the following steps for contributions:

- 1.Fork the project and create a new branch.  🍴

- 2.Make your changes and commit them with clear messages. 🚧
- 3.Submit a pull request, explaining the purpose and details of your changes.✏️
- 4.Ensure your code is properly tested. 🔍


## **👥Team Members & Contact Info**

Project Contributers: 

- [Ahmed Ashour](https://www.linkedin.com/in/ahmed-ashour-45b65b263/) 

- [Ahmed Shreif](https://www.linkedin.com/in/ahmed-shreif-5b3741270/)

- [Shimaa Essam](https://www.linkedin.com/in/shimaa-essam-732406245/)

- [Nada Osama](https://www.linkedin.com/in/nada-sholak-5700012a4/)

- [Fatma Emad]()

For any inquiries, feel free to reach out to the project maintainers.✉️

