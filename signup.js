const toggleBtn = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");

toggleBtn.addEventListener("click", () => {
  const isVisible = passwordInput.type === "text";
  passwordInput.type = isVisible ? "password" : "text";
  toggleBtn.textContent = isVisible ? "Show" : "Hide";
});
