/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/orderPooling.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
$(document).ready(function () {
  function createOrder(orderId, burgerCount, totalPrice, status) {
    var $div = $('<div>').addClass('flex items-center justify-around mb-4');
    var $link = $('<a>').attr('href', 'orders/' + orderId).addClass('text-blue-500 hover:underline').text(orderId + ': ' + burgerCount + ' Burgers');
    var $price = $('<span>').addClass('text-gray-500').text(totalPrice + " cents AED");
    var $status = $('<span>').addClass('text-gray-500').text(status);
    $div.append($link, $price, $status);
    return $div;
  }
  console.log('orderPooling.js loaded');
  Echo["private"]("order").listen('.order.update', function (e) {
    var container = $("#orders-container");
    container.empty();
    var BURGER_PRICE = 1000;
    e.orders.forEach(function (order) {
      var orderDiv = createOrder(order.id, order.total_price / BURGER_PRICE, order.total_price, order.status);
      container.append(orderDiv);
    });
  });
});
/******/ })()
;