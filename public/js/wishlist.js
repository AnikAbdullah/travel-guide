// Remove wishlist item.
function removeWishlistItem(postId) {
    var xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "../../api/wishlist_remove.php",
        true
    );

    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {

            try {

                var response = JSON.parse(xhr.responseText);

                if (response.success) {

                    var row = document.getElementById(
                        "wishlist-row-" + postId
                    );

                    if (row) {
                        row.remove();
                    }

                    alert(response.message);

                } else {
                    alert(response.message);
                }

            } catch (e) {
                alert("Something went wrong.");
            }
        }
    };

    xhr.send(
        "post_id=" + encodeURIComponent(postId) +
        "&csrf_token=" + encodeURIComponent(window.CSRF_TOKEN)
    );
}