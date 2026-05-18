function filterPosts() {

    let genre = document.getElementById("genreFilter").value;

    let cost = document.getElementById("costFilter").value;

    let xhttp = new XMLHttpRequest();

    xhttp.open(
        "POST",
        "../../views/posts/filter.php",
        true
    );

    xhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhttp.send(
        "genre=" + genre + "&cost=" + cost
    );

    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("postsArea").innerHTML =
                this.responseText;
        }
    };
}