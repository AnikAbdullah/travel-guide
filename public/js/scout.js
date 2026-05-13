// Show error.
function showError(field, message) {
  document.getElementById(field + "_error").innerHTML = message;
}

// Check form.
function validateScoutForm() {
  var valid = true;
  var form = document.forms["postForm"];
  var required = {
    title: "Title is required.",
    short_history: "Short history is required.",
    country_representation: "Country representation is required.",
    genre: "Select a valid genre.",
    cost_level: "Select a valid cost level.",
    travel_medium_info: "Travel medium information is required."
  };

  for (var field in required) {
    if (form[field].value.trim() === "") {
      showError(field, required[field]);
      valid = false;
    } else {
      showError(field, "");
    }
  }

  if (form["title"].value.trim().length > 150) {
    showError("title", "Title must be 150 characters or less.");
    valid = false;
  }

  var image = form["post_image"];
  if (image.files.length > 0) {
    var file = image.files[0];
    var extension = file.name.split(".").pop().toLowerCase();
    var allowed = ["jpg", "jpeg", "png", "webp"];

    if (allowed.indexOf(extension) === -1) {
      showError("post_image", "Only JPG, PNG, or WebP images are allowed.");
      valid = false;
    } else if (file.size > 2 * 1024 * 1024) {
      showError("post_image", "Image size must be 2MB or less.");
      valid = false;
    } else {
      showError("post_image", "");
    }
  } else {
    showError("post_image", "");
  }

  return valid;
}
