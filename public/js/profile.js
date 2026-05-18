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

  var profileForm = document.getElementById("profileForm");
  if (!profileForm) {
    return;
  }

  profileForm.addEventListener("submit", function (event) {
    clearErrors(profileForm);
    var valid = true;
    var name = profileForm.name.value.trim();
    var email = profileForm.email.value.trim();
    var currentPassword = profileForm.current_password.value;
    var newPassword = profileForm.new_password.value;
    var confirmPassword = profileForm.confirm_password.value;
    var fileInput = profileForm.profile_picture;
    var changingPassword = currentPassword || newPassword || confirmPassword;

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

    if (fileInput.files.length > 0) {
      var file = fileInput.files[0];
      var allowed = ["image/jpeg", "image/png", "image/webp"];
      if (allowed.indexOf(file.type) === -1) {
        showError("profile_picture", "Only JPG, PNG, and WEBP images are allowed.");
        valid = false;
      } else if (file.size > 2 * 1024 * 1024) {
        showError("profile_picture", "Profile picture must be 2MB or smaller.");
        valid = false;
      }
    }

    if (changingPassword) {
      if (!currentPassword) {
        showError("current_password", "Current password is required to change password.");
        valid = false;
      }
      if (!newPassword) {
        showError("new_password", "New password is required.");
        valid = false;
      } else if (newPassword.length < 8) {
        showError("new_password", "New password must be at least 8 characters.");
        valid = false;
      }
      if (!confirmPassword) {
        showError("confirm_password", "Please confirm your new password.");
        valid = false;
      } else if (newPassword !== confirmPassword) {
        showError("confirm_password", "New passwords do not match.");
        valid = false;
      }
    }

    if (!valid) {
      event.preventDefault();
    }
  });
})();
