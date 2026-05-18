(function () {
  "use strict";

  // Use the base URL injected by PHP via a meta tag, or fall back to empty string.
  var basePath = (document.querySelector('meta[name="base-url"]') || {}).content || "";

  function showAlert(message, type) {
    var alertBox = document.getElementById("wishlistAlert");
    if (!alertBox) {
      window.alert(message);
      return;
    }
    alertBox.textContent = message;
    alertBox.className = "alert alert-" + type;
    alertBox.classList.remove("hidden");
    // Auto-hide after 4 seconds
    setTimeout(function () {
      alertBox.classList.add("hidden");
    }, 4000);
  }

  function requestJson(url, method, postId) {
    var body = new URLSearchParams();
    body.append("post_id", String(postId));

    return fetch(url, {
      method: "POST", // always POST; DELETE is simulated via POST for broad server support
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest"
      },
      body: body.toString()
    }).then(function (response) {
      return response.json().then(function (data) {
        return { ok: response.ok, status: response.status, data: data };
      });
    });
  }

  // ── Add to wishlist ──────────────────────────────────────────────────────────
  document.querySelectorAll(".wishlist-add-btn").forEach(function (button) {
    button.addEventListener("click", function () {
      var postId = button.getAttribute("data-post-id");
      if (!postId) return;
      button.disabled = true;

      requestJson(basePath + "/api/wishlist/add", "POST", postId)
        .then(function (result) {
          if (result.ok) {
            button.textContent = "✓ Added";
            button.classList.add("btn-added");
            showAlert(result.data.message || "Added to wishlist.", "success");
          } else {
            button.disabled = false;
            showAlert(result.data.message || "Could not add to wishlist.", "error");
          }
        })
        .catch(function () {
          button.disabled = false;
          showAlert("Network error. Please try again.", "error");
        });
    });
  });

  // ── Remove from wishlist ─────────────────────────────────────────────────────
  document.querySelectorAll(".wishlist-remove-btn").forEach(function (button) {
    button.addEventListener("click", function () {
      if (!window.confirm("Remove this destination from your wishlist?")) {
        return;
      }

      var postId = button.getAttribute("data-post-id");
      if (!postId) return;
      button.disabled = true;

      requestJson(basePath + "/api/wishlist/remove", "POST", postId)
        .then(function (result) {
          if (result.ok) {
            var row = button.closest("tr");
            if (row) {
              row.style.transition = "opacity 0.3s";
              row.style.opacity = "0";
              setTimeout(function () {
                row.remove();
                var tbody = document.getElementById("wishlistBody");
                if (tbody && tbody.children.length === 0) {
                  var section = document.querySelector(".wishlist-section");
                  if (section) {
                    var empty = document.createElement("p");
                    empty.className = "empty-state";
                    empty.textContent = "Your wishlist is empty.";
                    section.appendChild(empty);
                  }
                }
              }, 300);
            }
            showAlert(result.data.message || "Removed from wishlist.", "success");
          } else {
            button.disabled = false;
            showAlert(result.data.message || "Could not remove item.", "error");
          }
        })
        .catch(function () {
          button.disabled = false;
          showAlert("Network error. Please try again.", "error");
        });
    });
  });
})();
