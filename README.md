# CabsOnline Taxi Booking System 🚖

## Overview

CabsOnline is a web-based taxi booking system designed to facilitate easy taxi booking for passengers using any internet-connected computing devices. Developed with embedded PHP and MySQL, the system features customer registration/login 🛂, online booking 📅, and administration functionalities 🛠.

### Version Information

- **Author:** Dollar Karan Preet Singh
- **Student ID:** 104086732
- **Version:** 1.0
- **Date:** 10 March 2024

## Features

- **🔐 Customer Registration/Login:** Securely register and log in users.
- **🚕 Online Booking:** Allow users to book taxi services easily.
- **👨‍💼 Administration:** Manage bookings and user accounts through an admin panel.

## Installation

### Prerequisites

Ensure you have PHP and MySQL installed on your server. This system is developed to work in a LAMP (Linux, Apache, MySQL, PHP) environment but should be compatible with other environments that support PHP and MySQL.

### Database Configuration 🔌

- **`dbconnect.php`**: Set up this file with your MySQL database username and password to establish a connection.

### Database Setup 🗄

- **`mysql.sql`**: Run this SQL script to create the necessary database tables for the application.

## Usage

### User Registration ✍️

- **`register.php`**: Handles new user registrations, ensuring data validity and checking for existing email addresses. Redirects to the login page upon successful registration.

### User Login 🔑

- **`login.php`**: Manages user login by verifying credentials against the database. Successful authentication forwards the user to the booking page.

### Password Management

- 📧 **`resetpwd.php`**: Initiates the password reset process by matching the input email against the database and sending an activation link.
- 🔓 **`activate.php`**: Confirms the activation link's validity before prompting for a new password.
- 🆕 **`newpwd.php`**: Saves the newly confirmed password and redirects to the login page.

### Booking 🕒📧

- **`booking.php`**: Processes booking requests, validating input and saving to the database if the booking time is at least 1 hour in the future. A confirmation email is sent to the user.

### Administration 👨‍💼🔧

- **`admin.php`**: Provides admin login and dashboard for managing the system, including viewing and assigning unbooked requests.

### Logout 🚪🔐

- **`logout.php`**: Clears the session and redirects to the login page, ensuring user data privacy.

## Support 🤝

For support or further information, please contact the developer or system administrator at dollargill.au@gmail.com
