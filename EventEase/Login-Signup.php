<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'db.php'; // Include database connection
session_start();

# SINGLE SIGN-ON using Google Account

// Replace with your credentials
$clientID = '363070854123-d5kc5j3p6hg7gemt1lt8mv74dd6f3i3k.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/eventease/EventEase/Login-Signup.php';

// Create Google Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Handle OAuth response
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get user profile info
    $googleService = new Google_Service_Oauth2($client);
    $userInfo = $googleService->userinfo->get();

    // Check if user exists in the database
    $stmt = $db->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$userInfo->email]);
    $user = $stmt->fetch();

    if (!$user) {
        // Save new user to the database
        $stmt = $db->prepare("INSERT INTO admins (name, email, username, password) VALUES (?, ?, ?, ?)");
        $defaultPassword = password_hash('GoogleLoginDefault', PASSWORD_BCRYPT);
        $stmt->execute([$userInfo->name, $userInfo->email, $userInfo->email, $defaultPassword]);
    }

    // Store user info in session
    $_SESSION['user'] = [
        'id' => $user['id'] ?? $db->lastInsertId(), // Use existing ID or last inserted ID
        'name' => $userInfo->name,
        'email' => $userInfo->email,
        'picture' => $userInfo->picture,
    ];

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit();
}

# Handle Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup-name'])) {
    $name = $_POST['signup-name'];
    $username = $_POST['signup-username'];
    $email = $_POST['signup-email'];
    $password = password_hash($_POST['signup-password'], PASSWORD_BCRYPT);

    try {
        // Check if email already exists
        $stmt = $db->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo "<script>alert('Email already exists. Please log in instead.');</script>";
        } else {
            // Insert new user into database
            $stmt = $db->prepare("INSERT INTO admins (name, username, email, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $username, $email, $password])) {
                echo "<script>alert('Signup successful! You can now log in.');</script>";
            } else {
                echo "<script>alert('Signup failed. Please try again.');</script>";
            }
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

# Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-email'])) {
    $emailOrUsername = $_POST['login-email'];
    $password = $_POST['login-password'];

    $stmt = $db->prepare("SELECT * FROM admins WHERE email = ? OR username = ?");
    $stmt->execute([$emailOrUsername, $emailOrUsername]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "<script>alert('Invalid login credentials.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>EventEase | Admin</title>
    <link rel="stylesheet" href="CSS/Login-Signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="wrapper">
      <div class="title-text">
        <div class="title login">Admin Login</div>
        <div class="title signup">Admin Signup</div>
      </div>
      <div class="form-container">
        <div class="slide-controls">
          <input type="radio" name="slide" id="login" checked>
          <input type="radio" name="slide" id="signup">
          <label for="login" class="slide login">Login</label>
          <label for="signup" class="slide signup">Signup</label>
          <div class="slider-tab"></div>
        </div>
        <div class="form-inner">
          <form action="Login-Signup.php" method="POST" class="login">
            <div class="field">
              <input type="text" name="login-email" placeholder="Email Address/Username" required>
            </div>
            <div class="field">
              <input type="password" name="login-password" placeholder="Password" required>
              <span class="toggle-password">Show</span>
            </div>
            <br>
            <div class="pass-link">
              <a href="Forgot-Password.html">Forgot password?</a>
            </div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Login">
            </div>
            <div class="or-text"><span>OR</span></div>
            <div class="google-login">
              <a href="<?php echo $client->createAuthUrl(); ?>" class="google-btn">
                <img src="images/Google__G__logo.svg.webp" alt="Google Logo" class="google-logo">
                Login with Google
              </a>
            </div>
            <div class="signup-link">
              Not a member? <a href="">Signup now</a>
            </div>
          </form>
          <form action="Login-Signup.php" method="POST" class="signup">
            <div class="field">
              <input type="text" name="signup-name" placeholder="Fullname" required>
            </div>
            <div class="field">
              <input type="text" name="signup-username" placeholder="Username" required>
            </div>
            <div class="field">
              <input type="email" name="signup-email" placeholder="Email Address" required>
            </div>
            <div class="field">
              <input type="password" name="signup-password" placeholder="Password" required>
              <span class="toggle-password">Show</span>
            </div>
            <div class="field">
              <input type="password" name="signup-confirm-password" placeholder="Confirm your password" required>
              <span class="toggle-password">Show</span>
            </div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Sign Up">
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
      const togglePassword = document.querySelectorAll('.toggle-password');
      togglePassword.forEach(toggle => {
        toggle.addEventListener('click', function() {
          const input = this.previousElementSibling;
          if (input.type === 'password') {
            input.type = 'text';
            this.textContent = 'Hide';
          } else {
            input.type = 'password';
            this.textContent = 'Show';
          }
        });
      });

      const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = () => {
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
      };
      loginBtn.onclick = () => {
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
      };
      signupLink.onclick = () => {
        signupBtn.click();
        return false;
      };

      
    </script>
  </body>
</html>
