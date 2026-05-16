function searchPosts()
{
    let text =
        document.getElementById("searchText").value;

    let xhttp = new XMLHttpRequest();

    xhttp.open(
        "POST",
        "../../index.php?action=search",
        true
    );

    xhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhttp.send("text=" + text);

    xhttp.onreadystatechange = function ()
    {
        if (
            this.readyState == 4 &&
            this.status == 200
        ) {
            document.getElementById("postData")
                    .innerHTML = this.responseText;
        }
    }
}