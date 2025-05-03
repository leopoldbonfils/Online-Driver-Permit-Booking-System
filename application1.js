function savePlaceInfo() {
    const data = {
      language: document.querySelector('select:nth-of-type(1)').value,
      district: document.querySelector('select:nth-of-type(2)').value,
      date: document.querySelector('input[type="date"]').value,
      time: document.querySelector('select:nth-of-type(3)').value,
      place: document.querySelector('[placeholder="Registration Place"]').value
    };
    localStorage.setItem("placeInfo", JSON.stringify(data));
    window.location.href = "application3.html";
  }