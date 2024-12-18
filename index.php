<?php 
session_start();
// load .env 
require('loadenv.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            color: white;
        }
        .alert-success {
            background-color: #4CAF50;
        }
        .alert-error {
            background-color: #f44336;
        }
    </style>
</head>
<body>

    <div class="contact-form">
        <h2>Contact Us</h2>

        <!-- Display session message if exists -->
        <?php if (isset($_SESSION['email'])): ?>
            <div class="alert <?php echo (strpos($_SESSION['email'], 'not sent') === false) ? 'alert-success' : 'alert-error'; ?>">
                <?php echo $_SESSION['email']; ?>
            </div>
            <?php unset($_SESSION['email']); // Clear the session message after displaying it ?>
        <?php endif; ?>

        <form action="sendMail.php" method="POST">
            <!-- Name Input -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name"  value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            </div>
            
            <!-- Email Input -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email"  value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <!-- Subject Input -->
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Subject of your message"  value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>" required>
            </div>

            <!-- Message Input -->
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Write your message here" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="sendMessage">Send Message</button>
        </form>

        <div class="form-footer">
            <p>Powered by <a href="#">Your Website</a></p>
        </div>
    </div>

</body>
</html>
