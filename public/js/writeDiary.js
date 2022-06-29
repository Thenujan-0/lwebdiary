/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/writeDiary.js ***!
  \************************************/
$(document).ready(function () {
  var form = $("#formWriteDiary");

  var showErrorDate = function showErrorDate() {
    var errorMsg = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
    console.log(errorMsg);

    if (errorMsg != "") {
      form.find("div.date p.errorMsg").html(errorMsg);
      form.find("div.date > .error").css("visibility", "visible");
    } else {
      form.find("div.date > .error").css("visibility", "hidden");
    }
  };

  var showErrorDiaries = function showErrorDiaries() {
    var errorMsg = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";

    if (errorMsg != "") {
      form.find("div.selectedDiaries  p.errorMsg").html(errorMsg);
      form.find("div.selectedDiaries > div.error").css("visibility", "visible");
    } else {
      form.find("div.selectedDiaries > div.error").css("visibility", "hidden");
    }
  };

  var showErrorDiaryText = function showErrorDiaryText() {
    var errorMsg = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";

    if (errorMsg != "") {
      form.find("div.diaryText p.errorMsg").html(errorMsg);
      form.find("div.diaryText > div.error").css("visibility", "visible");
    } else {
      form.find("div.diaryText > div.error").css("visibility", "hidden");
    }
  };

  function checkDateExists() {
    var date_ = form.find("#date").val();
    var data = {
      action: 'dateExists',
      date: date_
    };
    console.log("checking dateexists");
    $.post("libs/ajax.inc.php", data, function (response) {
      console.log("");

      if (response === "true") {
        showErrorDate("Date already exists");
        valid = false;
      } else {
        showErrorDate();
      }
    });
  } //btnBackWriteDiary callback


  form.find("#btnBackWriteDiary").click(function () {
    console.log("btnBack callback");
    form.css("display", "none");
    $("#darkOverlay").css("display", "none"); //Remove all the error messages

    showErrorDate();
    showErrorDiaries();
    showErrorDiaryText(); // window.location.reload()
  }); //Check if valid date when the user types diary

  var typeTimeout = null;
  form.find("textarea#diaryText").on("input", function () {
    if (typeTimeout == null) {
      console.log("changed");
      typeTimeout = setTimeout(function () {
        typeTimeout = null;
      }, 1000);
      checkDateExists();
    }
  }); //Check if valid date when date is changed

  form.find("input#date").change(function () {
    checkDateExists();
  });
  form.ajaxForm({
    beforeSubmit: function beforeSubmit() {
      console.log("before submit started");
      var valid = true; //Check if at leaset one diary is selected

      if (form.find("#selectedDiaries").val() === "") {
        showErrorDiaries("Please select at least one diary");
        valid = false;
      } else {
        showErrorDiaries();
      } //Check if something is written in diary


      if (form.find("#diaryText").val() === "") {
        showErrorDiaryText("Please write something in the diary");
        valid = false;
      } else {
        showErrorDiaryText();
      }

      return valid;
    },
    complete: function complete(xhr) {
      console.log(xhr.responseText);

      if (xhr.responseText === "true") {
        console.log("clicked back button");
        form.find("#btnBackWriteDiary").click();
      } else {
        console.log(xhr.status);
      }
    }
  }); //Page reloads value is empty

  form.find("#selectedDiaries").val(""); //Insert check mark on diary button click

  diaryBtn = form.find('.diaryBtn');
  form.find(".btnDiary").click(function () {
    //Used in php hardcoded 
    var spacer = "$$$$$";
    console.log(form.find("#selectedDiaries").val());

    if ($(this).hasClass("selected")) {
      $(this).removeClass("selected");
      $(this).children("i").remove();
      var value = $(this).children("p").html(); //Remove diary from hidden input

      form.find("#selectedDiaries").val(form.find("#selectedDiaries").val().replace(spacer + value, ""));
    } else {
      $(this).addClass("selected");
      $(this).children("p").before('<i class="fa fa-check"></i>');

      var _value = $(this).children("p").html(); //Add diary to hidden input


      form.find("#selectedDiaries").val(form.find("#selectedDiaries").val() + spacer + _value);
    }
  }); //Automatically set the date

  var today = new Date();
  form.find("#date").val(today.toISOString().substring(0, 10)); //Increase the size of textarea depending on the text inside

  form.find("textarea").keypress(function (e) {
    var tArea = form.find("textArea")[0];
    tArea.style.height = "5px";
    tArea.style.height = tArea.scrollHeight + 10 + "px";
  });
});
/******/ })()
;