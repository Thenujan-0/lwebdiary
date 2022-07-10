/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/errorPopup.js ***!
  \************************************/
function onLoad() {
  var closeBtn = document.querySelector('.errorPopup > .btn');
  closeBtn.addEventListener('click', closeErrorPopup);

  function closeErrorPopup() {
    document.querySelector(".errorPopupContainer").style.display = "none";
  }
}

window.addEventListener('DOMContentLoaded', onLoad);
/******/ })()
;