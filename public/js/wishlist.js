(function () {
  "use strict";

  var basePath = window.location.pathname.replace(/\/[^/]*$/, "");
  if (basePath.endsWith("/public")) {
    basePath = basePath;
  }

  function showAlert(message, type) {
    var alertBox = document.getElementById("wishlistAlert");
    if (!alertBox) {
      window.alert(message);
      return;
    }
    alertBox.textContent = message;
    alertBox.className = "alert alert-" + type;
    alertBox.classList.remove("hidden");
  }

  function requestJson(url, method, postId) {
    var options = {
      method: method,
      headers: {
        "X-Requested-With": "XMLHttpRequest"
      }
    };

    if (method === "POST") {
      var body = new URLSearchParams();
      body.append("post_id", String(postId));
      options.headers["Content-Type"] = "application/x-www-form-urlencoded";
      options.body = body.toString();
    } else if (method === "DELETE") {
      url += "?post_id=" + encodeURIComponent(String(postId));
    }

    return fetch(url, options).then(function (response) {
      return response.json().then(function (data) {
        return { ok: response.ok, status: response.status, data: data };
      });
    });
  }

  document.querySelectorAll(".wishlist-add-btn").forEach(function (button) {
    button.addEventListener("click", function () {
      var postId = button.getAttribute("data-post-id");
      button.disabled = true;

      requestJson(basePath + "/api/wishlist/add", "POST", postId)
        .then(function (result) {
          if (result.ok) {
            button.textContent = "Added";
            showAlert(result.data.message, "success");
          } else {
            button.disabled = false;
            showAlert(result.data.message || "Could not add to wishlist.", "error");
          }
        })
        .catch(function () {
          button.disabled = false;
          showAlert("Network error while adding to wishlist.", "error");
        });
    });
  });

  document.querySelectorAll(".wishlist-remove-btn").forEach(function (button) {
    button.addEventListener("click", function () {
      if (!window.confirm("Remove this post from your wishlist?")) {
        return;
      }

      var postId = button.getAttribute("data-post-id");
      button.disabled = true;

      requestJson(basePath + "/api/wishlist/remove", "DELETE", postId)
        .then(function (result) {
          if (result.ok) {
            var row = button.closest("tr");
            if (row) {
              row.remove();
            }
            showAlert(result.data.message, "success");

            var tbody = document.getElementById("wishlistBody");
            if (tbody && tbody.children.length === 0) {
              window.location.reload();
            }
          } else {
            button.disabled = false;
            showAlert(result.data.message || "Could not remove item.", "error");
          }
        })
        .catch(function () {
          button.disabled = false;
          showAlert("Network error while removing from wishlist.", "error");
        });
    });
  });
})();
