let deleteButtons = document.querySelectorAll(".delete-btn");

deleteButtons.forEach(button => {

    button.addEventListener("click", function(event){

        let deleteType = "item";

        
        if(this.href.includes("delete_user.php")){
            deleteType = "user";
        }

        else if(this.href.includes("delete_post.php")){
            deleteType = "post";
        }

        else if(this.href.includes("delete_comment.php")){
            deleteType = "comment";
        }

        else if(this.href.includes("reject_request.php")){
            deleteType = "request";
        }

        
        let confirmDelete = confirm(
            "Are you sure you want to delete this " + deleteType + "?"
        );

        
        if(confirmDelete == false){
            event.preventDefault();
        }

    });

});