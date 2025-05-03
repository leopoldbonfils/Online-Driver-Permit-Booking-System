if (localStorage.getItem("step3Completed") === "true") {
  const step3 = document.getElementById("step3");
  step3.classList.add("completed");
  step3.classList.remove("active");
  step3.querySelector(".step-number").innerHTML = '<i class="fas fa-check"></i>';
}

function markStepCompleted(step) {
  localStorage.setItem(`step${step}Completed`, "true");
}


function toggleContactInput() {
    const method = document.getElementById('method').value;
    document.getElementById('email-group').style.display = method === 'email' ? 'block' : 'none';
    document.getElementById('phone-group').style.display = method === 'phone' ? 'block' : 'none';
  }

  let generatedCode = '';

  function sendCode() {
    const method = document.getElementById('method').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    if ((method === 'email' && !email) || (method === 'phone' && !phone)) {
      alert('Please enter a valid email or phone number.');
      return;
    }

    // Simulate sending a code
    generatedCode = Math.floor(100000 + Math.random() * 900000).toString();
    alert(`Your payment code is: ${generatedCode} (sent via ${method})`);
  }

  function submitPayment() {
    const codeInput = document.getElementById('code');
    const enteredCode = codeInput.value.trim();

    if (!enteredCode || enteredCode !== generatedCode) {
      codeInput.classList.add('shake');
      setTimeout(() => codeInput.classList.remove('shake'), 300);
      alert('Invalid or missing code. Please try again.');
      return;
    }

    alert('✅ Payment successful! Application submitted.');
    localStorage.clear();
  }