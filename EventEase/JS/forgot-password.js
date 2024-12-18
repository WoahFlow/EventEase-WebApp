document.addEventListener('DOMContentLoaded', () => {
  const forgotPasswordForm = document.getElementById('forgotPasswordForm');
  const modal = document.getElementById('emailVerificationModal');
  const closeModal = document.querySelector('.close');
  const verifyCodeButton = document.getElementById('verifyCodeButton');

  // Show modal on form submission
  forgotPasswordForm.addEventListener('submit', (e) => {
    e.preventDefault();
    modal.style.display = 'block';
  });

  // Close modal
  closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  // Close modal when clicking outside
  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });

  // Handle verification code submission
  verifyCodeButton.addEventListener('click', () => {
    alert('Verification successful! Proceed to reset password.');
    modal.style.display = 'none';
    window.location.href = "/EventEase/Password-Change.html";
  });
});
