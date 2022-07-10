
function onLoad(){
    let closeBtn= document.querySelector('.errorPopup > .btn');
    closeBtn.addEventListener('click', closeErrorPopup);
    function closeErrorPopup(){
        document.querySelector(".errorPopupContainer").style.display = "none";
    }
}
window.addEventListener('DOMContentLoaded', onLoad);

