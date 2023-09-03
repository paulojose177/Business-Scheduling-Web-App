# Business-Scheduling-Web-App
The PJ Business Scheduling Web Application is a comprehensive platform designed to streamline the management of appointments, customers, and employees. Built using PHP, HTML, CSS, and JavaScript, this application integrates a variety of features to facilitate administrative tasks, user account management, and scheduling.


## Features

### Admin Module
- **Add Event**: Create new events (`add-event.php`).
- **Manage Appointments**: View and modify appointments (`appointment.php`).
- **Customer Management**: View customer details (`customer.php`).
- **Employee Management**: Add, edit, and delete employees (`employees.php`, `add-new.php`, `delete-employee.php`, `edit-emp.php`).
- **Schedule**: View and manage the schedule (`schedule.php`)

### Employee Module
- **Manage Appointments**: View and modify appointments (`appointment.php`).
- **Customer Details**: Access customer information (`customer.php`).
- **Schedule**: View and manage the schedule (`schedule.php`).
- **Settings**: Manage account settings (`settings.php`).

### Customer Module
- **Booking**: Schedule new appointments (`booking.php`).
- **Booking Confirmation**: Confirm booking details (`booking-complete.php`).
- **User Settings**: Manage account settings (`settings.php`).
- **Delete Account**: Remove user account (`delete-account.php`).
- **Edit User**: Edit user details (`edit-user.php`).


### Connection Module
- **Database Connection**: Connect to the database (`database-con.php`).
- **User Functions**: General user functions (`function-con.php`).
- **Login**: Handle user login (`login-con.php`).
- **Logout**: Handle user logout (`logout-con.php`).
- **Password Creation**: Create a new password (`newpwcreation-con.php`).
- **Registration**: Handle user registration (`register-con.php`).
- **Password Reset**: Reset user password (`resetrequest-con.php`).

## Tech Stack
- PHP
- HTML
- CSS
- JavaScript
- MySQL
- PHPmyAdmin
- XAMPP

## Dependencies
- **PHPMailer**: For sending emails. Located in the `PHPMailer/` directory.

## Setup Instructions
1. Install [XAMPP](https://www.apachefriends.org/index.html) to manage Apache and MySQL services.
2. Open XAMPP Control Panel and start the Apache and MySQL services.
3. Open phpMyAdmin in your browser.
4. Create a new database and run the SQL scripts to set up the tables.
5. Clone the repository.
6. Navigate to the project directory.
7. Update `database-con.php` with your database credentials.
8. Place the project folder in the `htdocs` directory of your XAMPP installation.
9. Open `index.php` in your browser to access the application.

## Contribution Guidelines
Feel free to contribute to this project by submitting pull requests or opening issues.

