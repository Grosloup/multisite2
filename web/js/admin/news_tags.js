$(function(){

    if(catId != null){
        var select = $("#post_form_category");
        var opts = select.find("option");
        opts.each(function(i){
            if(parseInt($(this).val()) == catId){
                $(this).attr("selected", "selected");
            }
        });
    }



    var $tagsHolder = $("#tags"), $protoHolder = $("#post_form_tags"), $addTagBtn = $("<a href='' class='btn btn--primary'><i class='fa fa-plus'></i></a>");
    var proto = $protoHolder.data("prototype");
    var $newTagDiv = $("<div class='form__row'></div>").append($addTagBtn);
    var counter = $protoHolder.children().length;;
    var addTagForm = function(){
        var proto = $protoHolder.data("prototype");
        var newField = proto.replace(/<label class=\"required\">__name__label__<\/label>/g, "");
        var $newField = $(newField.replace(/__name__/g, counter++));
        $newField.find("label").hide();
        var ipt = $newField.find("input").addClass("form__field new-tag").attr("placeholder","Mot-clé");
        ipt.wrap($("<div class='has-btn'></div>")).after($("<a href='' class='field__btn fa fa-times delete-tag'></a>"));
        var parent = ipt.parent().parent().addClass("form__row");
        var id = parent.parent().attr("id");

        ipt.next(".delete-tag").data("target", id);

        $tagsHolder.append($newField);
        ipt.focus();
    };
    $tagsHolder.after($newTagDiv);

    if($protoHolder.children().length>0){
        $protoHolder.children().each(function(i){
            $(this).addClass("form__row");
            var label = $(this).find("label");
            label.remove();
            var ipt = $(this).find("input");
            ipt.addClass("form__field").attr("readonly","readonly");
            ipt.wrap($("<div class='has-btn'></div>")).after($("<a href='' class='field__btn fa fa-times delete-old-tag'></a>"));
            ipt.next(".delete-old-tag").data("target", $(this));
        });
    }

    $(document).delegate(".delete-tag","click", function(e){
        e.preventDefault();
        var target = $(this).data("target") || false;

        if(target){
            $("#" + target).remove();
        }
    });

    $(document).delegate(".delete-old-tag", "click", function(e){
        e.preventDefault();
        var target = $(this).data("target");
        if(target){
            target.remove();
        }
    });

    $(document).delegate(".new-tag", "blur", function(){
        console.log($(this).val() == "");
        if($(this).val() == ""){
            //$(this).remove();
            var del = $(this).next("a.delete-tag");
            del.click();
        }
    });

    $addTagBtn.on("click", function(e){
        e.preventDefault();
        addTagForm();
        return false;
    });
});
