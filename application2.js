const personal = JSON.parse(localStorage.getItem("personalInfo"));
    const place = JSON.parse(localStorage.getItem("placeInfo"));

    document.getElementById("id").textContent = personal.nationalId;
    document.getElementById("first").textContent = personal.firstName;
    document.getElementById("middle").textContent = personal.middleName;
    document.getElementById("last").textContent = personal.lastName;
    document.getElementById("address").textContent = personal.address;
    document.getElementById("phone").textContent = personal.phone;

    document.getElementById("lang").textContent = place.language;
    document.getElementById("district").textContent = place.district;
    document.getElementById("date").textContent = place.date;
    document.getElementById("time").textContent = place.time;
    document.getElementById("place").textContent = place.place;

    function goToPayment() {
      window.location.href = "application3.html";
    }

    if (localStorage.getItem("step2Completed") === "true") {
      const step2 = document.getElementById("step2");
      step2.classList.add("completed");
      step2.classList.remove("active");
      step2.querySelector(".step-number").innerHTML = '<i class="fas fa-check"></i>';
    }

    function markStepCompleted(step) {
      localStorage.setItem(`step${step}Completed`, "true");
    }