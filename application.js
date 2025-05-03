function savePersonalInfo() {
    const data = {
      nationalId: document.querySelector('[placeholder="National ID"]').value,
      firstName: document.querySelector('[placeholder="First Name"]').value,
      middleName: document.querySelector('[placeholder="Middle Name"]').value,
      lastName: document.querySelector('[placeholder="Last Name"]').value,
      address: document.querySelector('[placeholder="Address"]').value,
      phone: document.querySelector('[placeholder="Phone Number"]').value
    };
    localStorage.setItem("personalInfo", JSON.stringify(data));
    window.location.href = "application2.html";
  }