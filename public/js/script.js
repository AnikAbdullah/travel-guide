let deleteButtons = document.querySelectorAll(".delete-btn");

deleteButtons.forEach(button => {

    button.addEventListener("click", function(event){

        let confirmDelete = confirm("Are you sure you want to delete this user?");

        if(confirmDelete == false){
            event.preventDefault();
        }

    });

});