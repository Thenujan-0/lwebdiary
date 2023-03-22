

let menuPopup = {
    elem:$("#menuPopup"),
    show(x,y){
        this.elem.css({
            "display":"block",
            "top":y,
            "right":$(window).width()-x
            })
    },
    hide(){
        this.elem.css('display','none')
    }
}

$("#menuPopup > .btn.logout").click(function(){
    window.location.href="/logout"
})

export {menuPopup}