/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/createDiary.js ***!
  \*************************************/
$(document).ready(function () {
  var form = $("#formCreateDiary");
  form.ajaxForm({
    complete: function complete(response) {
      console.log(response, "response of create diary"); // window.location.reload()

      if (response.responseText != "") {
        form.find(".btnCancel").click();
      } // window.location.reload()
      //! CHANGE

    }
  }); //Add create diary button callback

  $(".btnCreateDiary").click(function () {
    var overlay = $("#darkOverlay");
    var form = $("#formCreateDiary");
    form.css("display", "flex");
    overlay.css("display", "block");
  });

  function removeForm() {
    var overlay = $("#darkOverlay");
    overlay.css("display", "none");
    form.css("display", "none");
  } //Add btnCancel callback


  form.find(".btnCancel").click(removeForm);
});
/******/ })()
;