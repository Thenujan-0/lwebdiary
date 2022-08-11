/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/diaryNamesbar.js ***!
  \***************************************/
bar = $("#diaryNamesBar");
console.log(bar.width());
console.log(bar.prop("scrollWidth"));
console.log("why is this not working?");
console.log("So this is working?");
console.log("for real through?");

if (bar.width() < bar.prop("scrollWidth")) {
  // bar.css("overflow-x","scroll")
  console.log("yes");
  scrollButtons = $("#diaryNamesBar > i");
  console.log(scrollButtons);
  scrollButtons.each(function (elem) {
    return elem.css("display", "inline");
  });
} else {
  console.log("Nah bro");
}
/******/ })()
;