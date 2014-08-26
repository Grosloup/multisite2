$(function(){
    $(".delete-alert").on("click", function(e){
        e.preventDefault();
        var name = "'" + $(this).data("name") + "'" || "un élément";
        var goto = $(this).attr("href");
        var msg = "Vous êtes sur le point de supprimer __name__. Cette action est irréversible. Confirmez-vous votre choix ?";
        msg = msg.replace(/__name__/, name);
        if(window.confirm(msg)){
            window.location = goto;
        }
        return false;
    })
});
