
function validateWord() {
    var u_word = $("#users_word").val();
    
    $.ajax({
        type: "GET",
        url: "http://servyz.xyz:8099/action.php?u_word="+u_word,
        success: function(html){
            if(html == '1') {
                $("#res").html(html);
                $("#sub_button").show();
            }
            else $("#res").html(html);
        }
        
    });

}

function editWord(id) {

    $.ajax({
        type: "GET",
        url: "http://servyz.xyz:8099/action.php?edit_w="+id,
        success: function(html){
            alert(id);
            $("#edit_"+id).html(html);
            
        }

    });
}

function deleteWord(id) {

    $.ajax({
        type: "GET",
        url: "http://servyz.xyz:8099/action.php?delete_w="+id,
        success: function(html){
            alert(id);
            $("#delete_"+id).html(html);
        }

    });
}

