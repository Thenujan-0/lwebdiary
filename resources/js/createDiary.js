$(document).ready(function(){

    let form =$("#formCreateDiary")
    form.ajaxForm({

        complete:function(response){
            console.log(response.reponseText)
            window.location.reload()
            
        }
    })

    function removeForm(){
        
        let overlay=$("#darkOverlay")
        overlay.css("display","none")
        form.css("display","none")
    }

    //Add btnCancel callback
    form.find(".btnCancel").click(removeForm)
    form.find("input[type=submit]").click(removeForm)
})