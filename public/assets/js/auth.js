$(document).ready(function(){

})

function createNewUser() {

    let data = $("#registerForm").serializeArray();

    $.ajax({
        type: 'POST',
        url: '/register/newUser',
        data: data,
        dataType: 'JSON',
        success: function(data){
            alert(data);
        },
        error: function(data) {
        }
    })
}