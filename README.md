# Event Registration System

A simple PHP and MySQL web application that allows users to browse upcoming events, register for events, and view their registration confirmation. Administrators can manage event registrations through an admin dashboard.

## Features

### User
- View upcoming events.
- Register for an event.
- Validate registration details.
- Receive registration confirmation.

### Admin
- Admin login and logout.
- View all event registrations.
- View individual registration details.
- Delete registrations.

## Technologies Used

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- PDO (PHP Data Objects)

## Project Structure

```text
event_project/
├── admin/
├── assets/
│   └── css/
├── config/
├── includes/
│   ├── header.php
│   └── footer.php
├── index.php
├── register.php
├── process-registration.php
├── success.php
├── database.sql
└── README.md
```

## Installation and Setup

### Requirements
- XAMPP or another PHP development environment.
- PHP 8.0 or later.
- MySQL.
- Web browser.

### 1. Clone the repository

```bash
git clone https://github.com/kanavilboy/event_project
```

Move the project folder into the XAMPP `htdocs` directory.

### 2. Create the database

1. Start Apache and MySQL in XAMPP.
2. Open phpMyAdmin.
3. Create a database named `event_system`.
4. Import the `database.sql` file.

### 3. Configure database connection

Open `config/database.php` and update the database credentials according to your local environment.

### 4. Run the application

Open:

```text
http://localhost/event_project/
```

## Admin Login

Use the following demo credentials to access the admin dashboard:

| Field | Credentials |
|---|---|
| Username | `admin` |
| Password | `admin123` |

**Admin Login URL:**

```text
http://localhost/event_project/admin/login.php
```

These credentials are provided for assessment and local demonstration purposes only.

## Database Tables

- `events` – Stores event information.
- `registrations` – Stores user registration details.
- `admins` – Stores administrator login credentials.

## Author

Developed as a PHP Developer practical assessment project.