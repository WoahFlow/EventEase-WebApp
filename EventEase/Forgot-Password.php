<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>
   <link rel="stylesheet" href="CSS/forgot-password.css">
</head>
<body>
   <div class="wrapper">
      <div class="title">Forgot Password</div>
      <form id="forgotPasswordForm" class="form">
         <div class="field">
            <input type="text" placeholder="Enter your registered email" required>
         </div>
         <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" value="Send Verification Code">
         </div>
      </form>
   </div>

   <!-- Email Verification Modal -->
   <div id="emailVerificationModal" class="modal">
      <div class="modal-content">
         <span class="close">&times;</span>
         <h2>Email Verification</h2>
         <p>Please enter the verification code sent to your email:</p>
         <input type="text" placeholder="Enter verification code" class="verification-input" required>
         <div class="modal-buttons">
            <button id="verifyCodeButton">Verify</button>
         </div>
      </div>
   </div>

   <script src="JS/forgot-password.js"></script>
</body>
</html>
