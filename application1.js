function savePlaceInfo() {
  // Validate date first (you may already have this part)
  const selectedDate = document.querySelector('input[type="date"]').value;
  const today = new Date().toISOString().split('T')[0];
  if (selectedDate < today) {
    alert("You cannot select a date before today.");
    return;
  }

  // Save data to localStorage
  const data = {
    language: document.querySelector('select:nth-of-type(1)').value,
    district: document.querySelector('select:nth-of-type(2)').value,
    date: selectedDate,
    time: document.querySelector('select:nth-of-type(3)').value,
    place: document.querySelector('[placeholder="Registration Place"]').value
  };
  localStorage.setItem("placeInfo", JSON.stringify(data));

  // Attach back button listener BEFORE redirect
  document.getElementById("backBtn").addEventListener("click", function () {
    window.location.href = "application.html";
  });

  // Now redirect
  window.location.href = "summary.php";
}
