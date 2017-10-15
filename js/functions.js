
function validateWord() {
    var u_word = $("#users_word").val();
    
    $.ajax({
        type: "GET",
        url: "http://bardzilla/action.php?u_word="+u_word,
        success: function(html){
            if(html == '1') {
                $("#res").html('');
                $("#sub_button").show();
            }
            else $("#res").html(html);
        }


    });

}
