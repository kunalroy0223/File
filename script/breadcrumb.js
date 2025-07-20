
$(document).ready(function(){
    $(document).on("click", ".breadcrumb-link", function(e){
        e.preventDefault();
        var page = $(this).data("page");
    
        // Reload academics section
        $("#academic-content").html("");
        $("#breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="academics.php">Academics</a></li>
        `);
    });
    
});