
function validateWord() {
    var u_word = $("#users_word").val();
    
    $.ajax({
        type: "GET",
        url: "http://servyz.xyz:8099/action.php?u_word="+u_word,
        success: function(html){
            if(html == '1') {
                $("#res").hide();
                $("#sub_button").show();
            }
            else {
                $("#res").show();
                $("#res").html(html);
                $("#sub_button").hide();
            }
        }
        
    });

}

function editWord(id) {

    var e_word = $("#word_"+id).html();
    //alert(e_word);

    $.ajax({
        type: "GET",
        url: "http://servyz.xyz:8099/action.php?id="+id+"&e_word="+e_word,
        success: function(html){

            $("#edit_"+id).html(html);
            
        }

    });
}

function deleteWord(id) {
    alert('Вы уверены в себе?');

    $.ajax({
        type: "GET",
        url: "http://servyz.xyz:8099/action.php?delete_w="+id,
        success: function(html){

            $("#delete_"+id).html(html);
        }

    });
}

