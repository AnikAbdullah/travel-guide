(function () {
  "use strict";

  function showError(fieldName, message) {
    var el = document.querySelector('[data-error-for="' + fieldName + '"]');
    if (el) {
      el.textContent = message;
    }
  }

  function clearErrors(form) {
    form.querySelectorAll("[data-error-for]").forEach(function (el) {
      el.textContent = "";
    });
  }

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  var registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
      clearErrors(registerForm);
      var valid = true;
      var name = registerForm.name.value.trim();
      var email = registerForm.email.value.trim();
      var password = registerForm.password.value;
      var confirmPassword = registerForm.confirm_password.value;

      if (!name) {
        showError("name", "Name is required.");
        valid = false;
      }

      if (!email) {
        showError("email", "Email is required.");
        valid = false;
      } else if (!isValidEmail(email)) {
        showError("email", "Enter a valid email address.");
        valid = false;
      }

      if (!password) {
        showError("password", "Password is required.");
        valid = false;
      } else if (password.length < 8) {
        showError("password", "Password must be at least 8 characters.");
        valid = false;
      }

      if (!confirmPassword) {
        showError("confirm_password", "Please confirm your password.");
        valid = false;
      } else if (password !== confirmPassword) {
        showError("confirm_password", "Passwords do not match.");
        valid = false;
      }

      if (!valid) {
        event.preventDefault();
      }
    });
  }

  var loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      clearErrors(loginForm);
      var valid = true;
      var email = loginForm.email.value.trim();
      var password = loginForm.password.value;

      if (!email) {
        showError("email", "Email is required.");
        valid = false;
      } else if (!isValidEmail(email)) {
        showError("email", "Enter a valid email address.");
        valid = false;
      }

      if (!password) {
        showError("password", "Password is required.");
        valid = false;
      }

      if (!valid) {
        event.preventDefault();
      }
    });
  }
})();
