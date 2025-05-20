// Function to toggle between email and phone input fields
function toggleContactInput() {
  const method = document.getElementById('method').value;
  const emailGroup = document.getElementById('email-group');
  const phoneGroup = document.getElementById('phone-group');

  emailGroup.style.display = 'none';
  phoneGroup.style.display = 'none';

  if (method === 'email') {
    emailGroup.style.display = 'block';
  } else if (method === 'phone') {
    phoneGroup.style.display = 'block';
  }
}

// Wait for DOM to fully load before attaching listeners
document.addEventListener('DOMContentLoaded', function () {
  // Attach form validation
  document.querySelector('form').addEventListener('submit', function (e) {
    const method = document.getElementById('method').value;
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();

    let valid = true;
    let message = "";

    if (!method) {
      valid = false;
      message = "Please select how to receive the code.";
    } else if (method === 'email' && !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
      valid = false;
      message = "Please enter a valid email address.";
    } else if (method === 'phone' && !phone.match(/^\d{10,}$/)) {
      valid = false;
      message = "Please enter a valid phone number (at least 10 digits).";
    }

    if (!valid) {
      e.preventDefault();
      alert(message);
    }
  });

  // Attach change event to dropdown to show/hide input fields
  document.getElementById('method').addEventListener('change', toggleContactInput);

  // Call on load in case a value is pre-selected
  toggleContactInput();
});
