<?php
require 'db.php'; // Include the database connection

$email = $_GET['email']; // Get the email from URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputCode = $_POST['verification-code'];

    // Fetch the user's verification code from the database
    $stmt = $pdo->prepare("SELECT verification_code FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['verification_code'] === $inputCode) {
        // Code is valid, update the database and show the additional information form
        $stmt = $pdo->prepare("UPDATE users SET verified = TRUE WHERE email = ?");
        $stmt->execute([$email]);
        $verificationSuccess = true;
    } else {
        $verificationError = "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <link rel="stylesheet" href="CSS/verification.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verification</h1>
        </div>
        <div class="verification-section">
            <p>Email: <span id="email-display"><?php echo htmlspecialchars($email); ?></span></p>
            <div class="verification-code">
                <form action="Verification-Code.php?email=<?php echo htmlspecialchars($email); ?>" method="POST">
                    <label for="verification-code">Enter Verification Code:</label>
                    <input type="text" id="verification-code" name="verification-code" placeholder="Enter code here" required>
                    <button type="submit" id="verify-button">Verify</button>
                </form>
                <?php if (isset($verificationError)) { echo "<p class='error'>$verificationError</p>"; } ?>
                <?php if (isset($verificationSuccess)) { ?>
                    <div id="checkmark-container">
                        <img src="checkmark.png" alt="Verified" class="checkmark-logo">
                        <p class="verified-text">Code Verified!</p>
                    </div>
                    <div id="additional-details">
                        <h2>Complete Your Details</h2>
                        <form action="signup-process.php" method="POST">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Enter your name" required>
                            </div>
                            <div class="form-group">
                                <label for="contact-number">Contact Number:</label>
                                <input type="tel" id="contact-number" name="contact-number" placeholder="Enter your contact number" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" placeholder="Enter password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Confirm Password:</label>
                                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm password" required>
                            </div>
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
