/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/createDiary.js ***!
  \*************************************/
$(document).ready(function () {
  var form = $("#formCreateDiary");
  form.ajaxForm({
    complete: function complete(response) {
      console.log(response.reponseText);
      window.location.reload();
    }
  });

  function removeForm() {
    var overlay = $("#darkOverlay");
    overlay.css("display", "none");
    form.css("display", "none");
  } //Add btnCancel callback


  form.find(".btnCancel").click(removeForm);
  form.find("input[type=submit]").click(removeForm);
});
/******/ })()
;