function searchPosts() {

    let keyword = document.getElementById("search").value;

    let xhttp = new XMLHttpRequest();

    xhttp.open(
        "POST",
        "../../views/posts/search.php",
        true
    );

    xhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhttp.send("keyword=" + keyword);

    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("postsArea").innerHTML =
                this.responseText;
        }
    };
}