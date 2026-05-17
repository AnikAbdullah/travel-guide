// Show error.
function showError(field, message) {
  var el = document.getElementById(field + "_error");
  if (el) el.innerHTML = message;
}

// Validate form.
function validateScoutForm() {
  var valid = true;
  var form = document.forms["postForm"];
  var required = {
    title: "Title is required.",
    short_history: "Short history is required.",
    country_representation: "Country representation is required.",
    genre: "Select a valid genre.",
    cost_level: "Select a valid cost level.",
    travel_medium_info: "Travel medium information is required.",
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
  if (image && image.files.length > 0) {
    var file = image.files[0];
    var ext = file.name.split(".").pop().toLowerCase();
    if (["jpg", "jpeg", "png", "webp"].indexOf(ext) === -1) {
      showError("post_image", "Only JPG, PNG, or WebP images are allowed.");
      valid = false;
    } else if (file.size > 2 * 1024 * 1024) {
      showError("post_image", "Image size must be 2MB or less.");
      valid = false;
    } else {
      showError("post_image", "");
    }
  } else if (image) {
    showError("post_image", "");
  }

  return valid;
}

// AJAX delete functionality.
function confirmDelete(requestId) {
  if (
    !confirm(
      "Are you sure you want to delete this request? This cannot be undone.",
    )
  ) {
    return;
  }

  var xhttp = new XMLHttpRequest();
  xhttp.open("post", "delete_request.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(
    "request_id=" + requestId +
    "&csrf_token=" + encodeURIComponent(window.CSRF_TOKEN || ""),
  );

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      if (data.success) {
        alert(data.message);
        location.reload();
      } else {
        alert(data.message || "Could not delete request.");
      }
    }
  };
}
