function markStepCompleted(step) {
  localStorage.setItem(`step${step}Completed`, "true");
}

function handleContinue() {
  // Save personal info
  const data = {
    nationalId: document.querySelector('[name="national_id"]').value,
    fullName: document.querySelector('[name="full_name"]').value,
    sex: document.querySelector('[name="sex"]').value,
    dateBirthday: document.querySelector('[name="dob"]').value,
    address: document.querySelector('[name="address"]').value, 
    phone: document.querySelector('[name="phone"]').value
  };

  localStorage.setItem("personalInfo", JSON.stringify(data));

  // Mark Step 1 as completed
  markStepCompleted(1);

  // Redirect to the next step
  window.location.href = "application1.html";
}
