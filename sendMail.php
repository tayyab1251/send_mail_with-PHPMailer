<?php

session_start();

# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

# Load Composer's autoloader
require 'vendor/autoload.php';
# Load .env
require 'loadenv.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Initialize variables to avoid undefined variable notices
    $senderName = $senderEmail = $senderSubject = $senderMessage = '';
    $nameError = $emailError = $subjectError = $messageError = '';
    $formErrors = false;

    // Validate and sanitize the name field
    if (isset($_POST['name'])) {
        $senderName = htmlspecialchars(trim($_POST['name']));
        if (empty($senderName)) {
            $nameError = 'Name is required.';
            $formErrors = true;
        } elseif (strlen($senderName) > 100) {
            $nameError = 'Name is too long (max 100 characters).';
            $formErrors = true;
        }
    }

    // Validate and sanitize the email field
    if (isset($_POST['email'])) {
        $senderEmail = htmlspecialchars(trim($_POST['email']));
        if (empty($senderEmail)) {
            $emailError = 'Email is required.';
            $formErrors = true;
        } elseif (!filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Invalid email format.';
            $formErrors = true;
        }
    }

    // Validate and sanitize the subject field
    if (isset($_POST['subject'])) {
        $senderSubject = htmlspecialchars(trim($_POST['subject']));
        if (empty($senderSubject)) {
            $subjectError = 'Subject is required.';
            $formErrors = true;
        } elseif (strlen($senderSubject) > 200) {
            $subjectError = 'Subject is too long (max 200 characters).';
            $formErrors = true;
        }
    }

    // Validate and sanitize the message field
    if (isset($_POST['message'])) {
        $senderMessage = htmlspecialchars(trim($_POST['message']));
        if (empty($senderMessage)) {
            $messageError = 'Message is required.';
            $formErrors = true;
        } elseif (strlen($senderMessage) > 1000) {
            $messageError = 'Message is too long (max 1000 characters).';
            $formErrors = true;
        }
    }

    // If no validation errors, send the email
    if (!$formErrors) {

        if (isset($_POST['sendMessage'])) {
            # Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                # Server settings
                # $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->SMTPDebug  = 0;
                $mail->isSMTP();                                            //Send using SMTP
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Host       = $_ENV['HOST'];                     //Set the SMTP server to send through
                $mail->Username   = $_ENV['USERNAME'];                     //SMTP username
                $mail->Password   = $_ENV['PASSWORD'];                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                # Recipients
                $mail->setFrom($senderEmail, $senderName);        //Senders email address and sender (name is optional)
                $mail->addAddress($_ENV['USERNAME']);     //Add a recipient

                # Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $senderSubject;
                #  HTML template body
                $emailBody = "
                <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                color: #333;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                width: 100%;
                                max-width: 600px;
                                margin: 20px auto;
                                background-color: #ffffff;
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }
                            h1 {
                                font-size: 24px;
                                color: #333;
                            }
                            p {
                                font-size: 16px;
                                line-height: 1.6;
                                color: #555;
                            }
                            .info {
                                background-color: #f9f9f9;
                                padding: 15px;
                                border-radius: 5px;
                                margin-bottom: 15px;
                            }
                            .info b {
                                color: #333;
                            }
                            .footer {
                                text-align: center;
                                font-size: 12px;
                                color: #aaa;
                                margin-top: 20px;
                            }
                            .footer a {
                                color: #aaa;
                                text-decoration: none;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>New Contact Form Submission</h1>
                            <p><b>Subject:</b> $senderSubject</p>
                            <div class='info'>
                                <p><b>From:</b> $senderName</p>
                                <p><b>Email:</b> <a href='mailto:$senderEmail'>$senderEmail</a></p>
                            </div>
                            <p><b>Message:</b></p>
                            <p>$senderMessage</p>
                            <div class='footer'>
                                <p>Thank you for your inquiry. We'll get back to you as soon as possible.</p>
                                <p>Powered by Your Portfolio Website</p>
                            </div>
                        </div>
                    </body>
                </html>
            ";
                $mail->Body = $emailBody;

                if ($mail->send()) {
                    $_SESSION['email'] = 'Email has been sent!';
                    header('Location: index.php'); 
                    exit(); 
                }
            } catch (Exception $e) {
                $_SESSION['email'] = 'Email not sent! Error: ' . $mail->ErrorInfo;
                header('Location: index.php'); 
                exit(); 
            }
        }
    }
}
