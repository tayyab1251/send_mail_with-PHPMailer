# Contact Form with PHPMailer

A simple and secure **contact form** built with **PHP**, **PHPMailer**, and **SMTP** for sending inquiries. This form includes client-side and server-side validation, along with email templates to display user-submitted data.

## Introduction

This project provides a **contact form** that allows users to send their messages to a specified email address. It uses **PHPMailer** for secure email sending through **SMTP**. The form validates user input both on the client side (browser) and server side (PHP) to ensure data is correctly formatted before sending. Users receive an email confirmation with the form data, and success/error messages are shown upon submission.

## Features

- **SMTP Email Sending**: Sends emails securely using **PHPMailer** and **SMTP** authentication.
- **Client-Side Validation**: Basic validation for name, email, subject, and message fields using HTML5 attributes.
- **Server-Side Validation**: Ensures that inputs are properly validated and sanitized before sending the email.
- **HTML Email Templates**: Emails sent to the recipient include a styled HTML template for a clean and professional look.
- **Session-Based Success/Error Messages**: Users are shown messages indicating the success or failure of the email submission.
- **Environment Variables**: SMTP credentials (host, username, password) are managed securely using a `.env` file.
- **Redirection After Submission**: After form submission, users are redirected back to the form page (`index.php`) with the result of the submission.

## Requirements

- **PHP 7.4 or higher**: Ensure you have PHP installed on your server.
- **Composer**: A dependency manager for PHP (to install PHPMailer).
- **SMTP Server Credentials**: You'll need an SMTP provider, such as Gmail, SendGrid, or any custom SMTP server, to send emails securely.
- **.env File**: Stores sensitive information such as SMTP credentials (host, username, password).

## Installation

### 1. Clone the Repository

composer install

Create a .env file in the root directory of your project (if it doesn’t already exist), and add your SMTP credentials:

HOST=smtp.your-email-provider.com
USERNAME=your-email@example.com
PASSWORD=your-smtp-password



Example of the Email Sent
When the email is successfully sent, the recipient will receive an email containing the following:

<html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
            .container { width: 100%; max-width: 600px; margin: 20px auto; background-color: white; padding: 20px; }
            h1 { color: #333; }
            .footer { text-align: center; font-size: 12px; color: #aaa; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>New Contact Form Submission</h1>
            <p><b>Subject:</b> Inquiry about your service</p>
            <p><b>From:</b> John Doe</p>
            <p><b>Email:</b> john.doe@example.com</p>
            <p><b>Message:</b> I would like to know more about your services.</p>
            <div class="footer">
                <p>Thank you for your inquiry. We'll get back to you soon.</p>
            </div>
        </div>
    </body>
</html> 

Clone the repository to your local machine using Git. Open your terminal and run:

```bash
git clone https://github.com/tayyab1251/send_mail_with-PHPMailer.git
cd send_mail_with-PHPMailer
