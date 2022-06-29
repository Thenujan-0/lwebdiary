/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/index.js ***!
  \*******************************/
$(document).ready(function () {
  var main = $(".main"); //Add btnWriteEntry callback

  $("#btnWriteEntry").click();

  function hideWriteInline() {
    $(".btnWriteInline").css("display", "none");
  }

  function unHideWriteInline() {
    $(".btnWriteInline").css("display", "inline");
  }

  function setDiaryData() {
    var selectedDiary_ = $(".btnDiary.selected").html();
    console.log("selectedDiary", selectedDiary_);
    var data = {
      action: "getDiaryData",
      date: $(".btnDate.selected").html(),
      selectedDiary: selectedDiary_
    };
    $.get("diaryEntry/show", data, function (response) {
      console.log(response, "resp");

      if (response != "") {
        $(".diaryData").html(response);
      } else {
        $(".diaryData").html("Nothing written here :( <button class='btn btnWriteInline'>Write</button>");
        addBtnWriteInlineListener();
      }
    });
  } //sets the diary data for last date 


  setDiaryData(); //Add btnDate callback

  function btnDateCallback() {
    var date = $(this).html();
    console.log(date); // $("#selectedDate").val(date)
    //Remove selected from date (technically there should only be one)

    $(".btnDate.selected").removeClass("selected");
    $(this).addClass("selected");
    setDiaryData();
    disableEditMode();
  }

  $(".btnDate").click(btnDateCallback);

  function enableEditMode() {
    $("p.diaryData").attr("contentEditable", "true");
    $("p.diaryData").focus();
    $(".btnEdit").html("Save");
    hideWriteInline();
  }

  function disableEditMode() {
    if ($("p.diaryData").attr("contentEditable") != "true") {
      return;
    }

    var selectedDiary_ = $(".btnDiary.selected").html();
    var textData = $("p.diaryData").text(); //check if it is empty by checking 
    //If it has an inline write button,

    if ($(".btnWriteInline").length) {
      //We have to do some processing to remove the inline write button from the text
      textData = textData.substr(0, textData.length - 5);
      console.log(textData);
      var data = {
        action: "writeDiaries",
        selectedDiaries: [selectedDiary_],
        data: textData,
        date: $(".btnDate.selected").html()
      };
      console.log(selectedDiary_, textData, data); //todo

      $.post("diaryEntry/update", data, function (response) {
        console.log(response);
        setDiaryData();
      });
    } else {
      console.log(textData);
      var _data = {
        action: "editDiaryData",
        selectedDiary: selectedDiary_,
        data: textData,
        date: $(".btnDate.selected").html()
      };
      console.log(selectedDiary_, textData, _data);
      $.post("libs/ajax.inc.php", _data, function (response) {
        console.log(response);
        setDiaryData();
      });
    }

    $("p.diaryData").attr("contentEditable", "false");
    $(".btnEdit").html("Edit");
    unHideWriteInline();
  } //Add btnEdit callback


  $(".btnEdit").click(function () {
    if ($(this).html() == "Edit") {
      enableEditMode();
    } else {
      disableEditMode();
    }
  }); // Add delete callback

  main.find(".btnDel").click(function () {
    var date_ = $(".btnDate.selected").html();
    $.ajax({
      url: "diaryEntry/destroy",
      type: "DELETE",
      data: {
        date: date_,
        _token: token
      },
      complete: function complete(response) {
        console.log(response);
        window.location.reload();
        console.log("reloaded");
      }
    });
  }); //Add create diary button callback

  $(".btnCreateDiary").click(function () {
    var overlay = $("#darkOverlay");
    var form = $("#formCreateDiary");
    form.css("display", "flex");
    overlay.css("display", "block");
  }); //Add btnDiary callback

  main.find(".btnDiary").click(function () {
    if (!$(this).hasClass("selected")) {
      $(".btnDiary.selected").removeClass("selected");
      $(this).addClass("selected");
      setDiaryData();
    }
  });

  function addBtnWriteInlineListener() {
    //Add btnWriteInline callback
    $(".btnWriteInline").click(function () {
      enableEditMode();
    });
  } //Add btnWrite callback


  $(".btnWrite").click(function () {
    var form = $("#formWriteDiary");
    var darkOverlay = $("#darkOverlay");

    if (form.css("display") == "none") {
      form.css("display", "flex");
      darkOverlay.css("display", "block");
    } else {
      form.css("display", "none");
      darkOverlay.css("display", "none");
    }
  });
});
/******/ })()
;