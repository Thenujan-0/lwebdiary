$(document).ready(function(){

    let form =$("#formCreateDiary")
    form.ajaxForm({

        complete:function(response){
            console.log(response)
            // window.location.reload()
            if (response.responseText!=""){
                form.find(".btnCancel").click()
            }
            
        }
    })

    //Add create diary button callback
    $(".btnCreateDiary").click(function(){
        let overlay=$("#darkOverlay")
        let form =$("#formCreateDiary")
        form.css("display","flex")
        overlay.css("display","block")
    })

    function removeForm(){
        
        let overlay=$("#darkOverlay")
        overlay.css("display","none")
        form.css("display","none")
    }

    //Add btnCancel callback
    form.find(".btnCancel").click(removeForm)
})