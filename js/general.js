$(document).ready(function(){
    
    if ($("#mysearch").val() == "") {
        $("#res_card").addClass("d-none")
    }

    //Search pop up snippet
    $("#mysearch").keyup(function(e){
        e.preventDefault()
        value = $("#mysearch").val()
        if (value != "") {
            $("#res_card").removeClass("d-none")
            $.ajax({
                type: 'POST',
                url: 'searchlogic.php',
                data: {search: value}
            }).done(function(val){
                // console.log(val)
                $(".list-group").html(val)                        
            }).fail(function(e){
                Swal.fire({
                    title: 'Error!',
                    text: "Error in connection",
                    icon: 'error',
                })
            })
        }
        else{
            $("#res_card").addClass("d-none")
        }
    })
    //End of search pop up snippet

    //snippet to subscribe to newsletter
$("#sub-btn").click(function(e) {
    e.preventDefault();
    var email = $("#sub-email").val()
    if (email == "") {
        Swal.fire({
            title: 'Error!',
            text: "Field is required",
            icon: 'error',
        })
    } 
    else{
        $.ajax({
            type: 'POST',
            url: 'addsub.php',
            data: { subemail: email }
        }).done(function(msg) {
            if (msg == "Subscription successful") {
                Swal.fire({
                title: 'Success!',
                text: msg,
                icon: 'success',
                })   
            }
            else{
                Swal.fire({
                title: 'Error!',
                text: msg,
                icon: 'error',
                })   
            }
        }).fail(function(msg){
            Swal.fire({
                title: 'Error!',
                text: "Error in connection",
                icon: 'error',
            })
        })
    }
})
//end of newsletter subscription snippet
})
