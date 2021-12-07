$(document).ready(function(){
    //Autosave javascript request logic 
    setInterval(()=>{
        var content = $("#pbody").val()
        var post_id = $("#post_id").attr("data-postid")
        $.ajax({
            data: {content: content, post_id: post_id},
            type: "post",
            url: "autosave.php"
        }).done(function(msg){
            if(msg == "success"){
                Swal.fire({
                    toast: 'true',
                    position: 'top-end',
                    title: 'saved successfully!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                })
            }
            else{
                console.log(msg)
            }
        }).fail(function(msg){
            console.log(msg)
        })
}, 60000)
})