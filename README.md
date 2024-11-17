# Laravel Project Installation and Usage Guide

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Environment Setup](#environment-setup)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)


## Requirements

Before you start, make sure your system meets the following requirements:

- PHP >= 8.0
- Composer
- MySQL or any other supported database
- Laravel 10.x

## Installation

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/your-repo/your-project.git
    cd your-project
    ```

2. **Install PHP Dependencies:**

    Run the following command to install Laravel and its dependencies:

    ```bash
    composer install
    ```



## Environment Setup

1. **Create `.env` File:**

    Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

2. **Generate Application Key:**

    Run the following command to generate the application key:

    ```bash
    php artisan key:generate
    ```

3. **Configure Environment Variables:**

    Open the `.env` file and update the following fields:

    ```dotenv
    APP_NAME="Your Project Name"
    APP_ENV=local
    APP_KEY=base64:generated-key
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

    ```


## Running the Application

1. **Start the Development Server:**

    Run the following command to start the Laravel development server:

    ```bash
    php artisan serve
    ```


