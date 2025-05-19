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
