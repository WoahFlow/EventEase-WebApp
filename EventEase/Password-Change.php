<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
   <meta charset="utf-8">
   <title>Password Change</title>
   <link rel="stylesheet" href="CSS/Password-Change.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
      /* Modal styles */
      .modal {
         display: none;
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(0, 0, 0, 0.5);
         justify-content: center;
         align-items: center;
         z-index: 1000;
      }
      .modal-content {
         background: white;
         padding: 20px;
         border-radius: 10px;
         text-align: center;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }
      .modal-content p {
         margin: 20px 0;
         font-size: 18px;
      }
      .modal-content button {
         padding: 10px 20px;
         background: #7b7c7c;
         color: white;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         font-size: 16px;
      }

      .modal-content button:hover{
         background-color: #404242;
         transition: ease 0.4s;
      }
   </style>
</head>
<body>
   <div class="wrapper">
      <div class="title-text">
         <div class="title signup">
            Change Password
         </div>
      </div>
      <div class="form-container">
         <div class="form-inner">
            <form action="#" class="login" id="passwordChangeForm">
               <div class="field">
                  <input type="password" id="newPassword" placeholder="Enter new password" required>
               </div>
               <div class="field">
                  <input type="password" id="confirmPassword" placeholder="Confirm new password" required>
               </div>
               <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Set new password">
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- Modal -->
   <div class="modal" id="successModal">
      <div class="modal-content">
         <p>Password changed!</p>
         <button id="okButton">OK</button>
      </div>
   </div>

   <script>
      const form = document.getElementById('passwordChangeForm');
      const modal = document.getElementById('successModal');
      const okButton = document.getElementById('okButton');

      form.addEventListener('submit', function(event) {
         event.preventDefault();

         const newPassword = document.getElementById('newPassword').value;
         const confirmPassword = document.getElementById('confirmPassword').value;

         if (newPassword === confirmPassword) {
            modal.style.display = 'flex';
         } else {
            alert('Passwords do not match!');
         }
      });

      okButton.addEventListener('click', function() {
         modal.style.display = 'none';
         window.location.href = '/EventEase/Login-Signup.html'; // Replace with your desired URL
      });
   </script>
</body>
</html>
