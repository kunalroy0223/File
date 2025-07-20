$(document).ready(function(){
    $(".menu-item").click(function(e){
        e.preventDefault();
        var page = $(this).data("page");

        // Load the content dynamically
        $("#main-content").load("./content/" + page + ".php");
    });
});