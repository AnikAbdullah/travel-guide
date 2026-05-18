function deleteComment(commentId) {

    if (!confirm("Delete this comment?")) {
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.open(
        "POST",
        "../../views/posts/delete_comment.php",
        true
    );

    xhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhttp.send(
        "comment_id=" + commentId
    );

    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            let data = JSON.parse(this.responseText);

            if (data.success) {

                document.getElementById(
                    "comment-" + commentId
                ).remove();

            } else {

                alert("Could not delete comment.");
            }
        }
    };
}