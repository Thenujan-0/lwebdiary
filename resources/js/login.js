
function focus(){
    let email = document.getElementById("email")
    if (email.value===""){
        email.focus()
    }else{
        document.getElementById("password").focus()
    }
}


document.addEventListener("DOMContentLoaded",focus)