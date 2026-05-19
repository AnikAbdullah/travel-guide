// Show field error.
function showAuthError(field, message) {
  var el = document.getElementById(field + "_error");
  if (el) el.innerHTML = message;
}

// Validate login form.
function validateLoginForm() {
  var form = document.forms["loginForm"];
  var ok = true;

  if (form["email"].value.trim() === "") {
    showAuthError("email", "Email is required.");
    ok = false;
  } else {
    showAuthError("email", "");
  }

  if (form["password"].value === "" || form["password"].value.length < 8) {
    showAuthError("password", "Password must be at least 8 characters.");
    ok = false;
  } else {
    showAuthError("password", "");
  }

  return ok;
}

// Validate registration form.
function validateRegisterForm() {
  var form = document.forms["registerForm"];
  var ok = true;

  if (form["name"].value.trim() === "") {
    showAuthError("name", "Name is required.");
    ok = false;
  } else {
    showAuthError("name", "");
  }

  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(form["email"].value.trim())) {
    showAuthError("email", "A valid email is required.");
    ok = false;
  } else {
    showAuthError("email", "");
  }

  if (form["password"].value.length < 8) {
    showAuthError("password", "Password must be at least 8 characters.");
    ok = false;
  } else {
    showAuthError("password", "");
  }

  if (form["password"].value !== form["confirm_password"].value) {
    showAuthError("confirm_password", "Passwords do not match.");
    ok = false;
  } else {
    showAuthError("confirm_password", "");
  }

  return ok;
}
