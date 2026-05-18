function addWishlist(postId){

    fetch('../../api/wishlist_add.php',{

        method:'POST',

        headers:{
            'Content-Type':
            'application/x-www-form-urlencoded'
        },

        body:'post_id='+postId
    })
    .then(response => response.text())
    .then(data => {

        alert(data);
    });
}

function removeWishlist(postId){

    fetch('../../api/wishlist_remove.php',{

        method:'POST',

        headers:{
            'Content-Type':
            'application/x-www-form-urlencoded'
        },

        body:'post_id='+postId
    })
    .then(response => response.text())
    .then(data => {

        alert(data);

        location.reload();
    });
}
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
