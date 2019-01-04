/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/build/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./assets/js/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/css/app.scss":
/*!*****************************!*\
  !*** ./assets/css/app.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../css/app.scss */ "./assets/css/app.scss");

var addTicketBtn = document.querySelector("#addTicket");
addTicketBtn.addEventListener('click', function (e) {
  e.preventDefault();
  var list = document.querySelector(addTicketBtn.dataset.template);
  var counter = list.dataset.counter | list.children.length;
  var newTicket = list.dataset.prototype;
  newTicket = newTicket.replace(/__name__/g, counter);
  counter++;
  list.dataset.counter = counter;
  var ticketElement = document.createElement(list.dataset.widgetTags);
  ticketElement.innerHTML = newTicket; // Création du bouton de suppression d'un ticket

  var deleteElement = document.createElement('INPUT');
  deleteElement.setAttribute("type", "button");
  deleteElement.id = "suppr";
  deleteElement.className = "btn btn-danger";
  var enUrl = /en\/museum\/buy$/;
  var urlComplet = document.location.href;

  if (enUrl.test(urlComplet)) {
    deleteElement.setAttribute("value", "Delete");
  } else {
    deleteElement.setAttribute("value", "Supprimer");
  }

  ticketElement.appendChild(deleteElement);
  list.appendChild(ticketElement); // Evènement au clic du bouton

  deleteElement.addEventListener('click', function (e) {
    var current = e.target;
    current.parentNode.remove();
  }); // Création du message d'information quand la checkbox "Reduction" est cochée

  var newNode = document.createElement('div');
  newNode.innerHTML = "test"; // Fonction d'affichage de l'élément crée lors du clic sur la checkbox

  ticketElement.querySelector('.form-check-input').addEventListener('click', function (e) {
    var current = e.target; // = checkbox

    if (ticketElement.querySelector('.form-check-input').checked === true) {
      current.parentNode.insertBefore(newNode, current);
    } else {
      current.parentNode.removeChild(newNode);
    }
  });
});
/*$(document).ready(function() {
  // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
   var $container = $('div#command_tickets_list');
   // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
  var index = $container.find(':input').length;
   // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
  $('#addTicket').click(function(e) {
    addTicket($container);
     e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    return false;
  });
   // On ajoute un premier billet automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
  if (index == 0) {
    addTicket($container);
  } else {
    // S'il existe déjà un billet, on ajoute un lien de suppression pour chacune d'entre elles
    $container.children('div').each(function() {
      addDeleteLink($(this));
    });
  }
   //Ajout d'un formulaire TicketType
  function addTicket($container) {
    // Dans le contenu de l'attribut « data-prototype », on remplace :
    // - le texte "__name__label__" qu'il contient par le label du champ
    // - le texte "__name__" qu'il contient par le numéro du champ
    var template = $container.attr('data-prototype')
      .replace(/__name__label__/g, 'Billet n°' + (index+1))
      .replace(/__name__/g,        index)
    ;
     // On crée un objet jquery qui contient ce template
    var $prototype = $(template);
     // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
    addDeleteLink($prototype);
     // On ajoute le prototype modifié à la fin de la balise <div>
    $container.append($prototype);
     /*$('.form-check-input').click(function(){
      $("<div><strong>Test</strong></div>").append($('.form-check-input'));
    });*/

/*ticketElement.querySelector('.form-check-input').addEventListener('click', (e)*/

/*$('<strong>test</strong><br />').insertBefore($('.form-check-input'));*/
// Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro

/*index++;
}
// La fonction qui ajoute un lien de suppression d'une catégorie
function addDeleteLink($prototype) {
// Vérification de l'url pour déterminer la langue du bouton
var enUrl = /en\/museum\/buy$/
var urlComplet = document.location.href;
// Création du lien sous forme de bouton
if(enUrl.test(urlComplet))
{
  var $deleteLink = $('<a href="#" class="btn btn-danger">Delete</a>');
}
else
{
  var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a><br />');
}
 // Ajout du lien
$prototype.append($deleteLink);
 // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
$deleteLink.click(function(e) {
  $prototype.remove();
   e.preventDefault(); // évite qu'un # apparaisse dans l'URL
  return false;
});
}
});*/

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2Nzcy9hcHAuc2Nzcz82NjVhIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9hcHAuanMiXSwibmFtZXMiOlsicmVxdWlyZSIsImFkZFRpY2tldEJ0biIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImFkZEV2ZW50TGlzdGVuZXIiLCJlIiwicHJldmVudERlZmF1bHQiLCJsaXN0IiwiZGF0YXNldCIsInRlbXBsYXRlIiwiY291bnRlciIsImNoaWxkcmVuIiwibGVuZ3RoIiwibmV3VGlja2V0IiwicHJvdG90eXBlIiwicmVwbGFjZSIsInRpY2tldEVsZW1lbnQiLCJjcmVhdGVFbGVtZW50Iiwid2lkZ2V0VGFncyIsImlubmVySFRNTCIsImRlbGV0ZUVsZW1lbnQiLCJzZXRBdHRyaWJ1dGUiLCJpZCIsImNsYXNzTmFtZSIsImVuVXJsIiwidXJsQ29tcGxldCIsImxvY2F0aW9uIiwiaHJlZiIsInRlc3QiLCJhcHBlbmRDaGlsZCIsImN1cnJlbnQiLCJ0YXJnZXQiLCJwYXJlbnROb2RlIiwicmVtb3ZlIiwibmV3Tm9kZSIsImNoZWNrZWQiLCJpbnNlcnRCZWZvcmUiLCJyZW1vdmVDaGlsZCJdLCJtYXBwaW5ncyI6IjtBQUFBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOzs7QUFHQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0Esa0RBQTBDLGdDQUFnQztBQUMxRTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGdFQUF3RCxrQkFBa0I7QUFDMUU7QUFDQSx5REFBaUQsY0FBYztBQUMvRDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsaURBQXlD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QXFFO0FBQ25FTCxhQUFPLENBQUNFLFVBQVIsQ0FBbUJJLFlBQW5CLENBQWdDRixPQUFoQyxFQUF5Q0osT0FBekM7QUFDRCxLQUZELE1BR0s7QUFDSEEsYUFBTyxDQUFDRSxVQUFSLENBQW1CSyxXQUFuQixDQUErQkgsT0FBL0I7QUFDRDtBQUNGLEdBUkQ7QUFTSCxDQXhERDtBQTBETjs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBaURJOztBQUVBO0FBRUE7O0FBQ0EiLCJmaWxlIjoiYXBwLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCIvYnVpbGQvXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vYXNzZXRzL2pzL2FwcC5qc1wiKTtcbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsInJlcXVpcmUoJy4uL2Nzcy9hcHAuc2NzcycpO1xuXG4gICAgICAgIGNvbnN0IGFkZFRpY2tldEJ0biA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoXCIjYWRkVGlja2V0XCIpXG5cbiAgICAgICAgYWRkVGlja2V0QnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICAgICAgICBjb25zdCBsaXN0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihhZGRUaWNrZXRCdG4uZGF0YXNldC50ZW1wbGF0ZSlcbiAgICAgICAgICAgIGxldCBjb3VudGVyID0gbGlzdC5kYXRhc2V0LmNvdW50ZXIgfCBsaXN0LmNoaWxkcmVuLmxlbmd0aFxuXG4gICAgICAgICAgICBsZXQgbmV3VGlja2V0ID0gbGlzdC5kYXRhc2V0LnByb3RvdHlwZVxuICAgICAgICAgICAgbmV3VGlja2V0ID0gbmV3VGlja2V0LnJlcGxhY2UoL19fbmFtZV9fL2csIGNvdW50ZXIpXG4gICAgICAgICAgICBjb3VudGVyKytcblxuICAgICAgICAgICAgbGlzdC5kYXRhc2V0LmNvdW50ZXIgPSBjb3VudGVyXG5cbiAgICAgICAgICAgIGNvbnN0IHRpY2tldEVsZW1lbnQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KGxpc3QuZGF0YXNldC53aWRnZXRUYWdzKVxuXG4gICAgICAgICAgICB0aWNrZXRFbGVtZW50LmlubmVySFRNTCA9IG5ld1RpY2tldFxuICAgICAgICAgICAgLy8gQ3LDqWF0aW9uIGR1IGJvdXRvbiBkZSBzdXBwcmVzc2lvbiBkJ3VuIHRpY2tldFxuICAgICAgICAgICAgY29uc3QgZGVsZXRlRWxlbWVudCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ0lOUFVUJylcbiAgICAgICAgICAgIGRlbGV0ZUVsZW1lbnQuc2V0QXR0cmlidXRlKFwidHlwZVwiLCBcImJ1dHRvblwiKVxuICAgICAgICAgICAgZGVsZXRlRWxlbWVudC5pZCA9IFwic3VwcHJcIlxuICAgICAgICAgICAgZGVsZXRlRWxlbWVudC5jbGFzc05hbWUgPSBcImJ0biBidG4tZGFuZ2VyXCJcblxuICAgICAgICAgICAgdmFyIGVuVXJsID0gL2VuXFwvbXVzZXVtXFwvYnV5JC9cbiAgICAgICAgICAgIHZhciB1cmxDb21wbGV0ID0gZG9jdW1lbnQubG9jYXRpb24uaHJlZjtcblxuICAgICAgICAgICAgaWYoZW5VcmwudGVzdCh1cmxDb21wbGV0KSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgZGVsZXRlRWxlbWVudC5zZXRBdHRyaWJ1dGUoXCJ2YWx1ZVwiLCBcIkRlbGV0ZVwiKVxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICBkZWxldGVFbGVtZW50LnNldEF0dHJpYnV0ZShcInZhbHVlXCIsIFwiU3VwcHJpbWVyXCIpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIHRpY2tldEVsZW1lbnQuYXBwZW5kQ2hpbGQoZGVsZXRlRWxlbWVudClcblxuICAgICAgICAgICAgbGlzdC5hcHBlbmRDaGlsZCh0aWNrZXRFbGVtZW50KVxuICAgICAgICAgICAgLy8gRXbDqG5lbWVudCBhdSBjbGljIGR1IGJvdXRvblxuICAgICAgICAgICAgZGVsZXRlRWxlbWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgICAgICAgICAgIGNvbnN0IGN1cnJlbnQgPSBlLnRhcmdldFxuICAgICAgICAgICAgICBjdXJyZW50LnBhcmVudE5vZGUucmVtb3ZlKClcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgXG4gICAgICAgICAgICAvLyBDcsOpYXRpb24gZHUgbWVzc2FnZSBkJ2luZm9ybWF0aW9uIHF1YW5kIGxhIGNoZWNrYm94IFwiUmVkdWN0aW9uXCIgZXN0IGNvY2jDqWVcbiAgICAgICAgICAgIGNvbnN0IG5ld05vZGUgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKVxuICAgICAgICAgICAgbmV3Tm9kZS5pbm5lckhUTUwgPSBcInRlc3RcIlxuXG4gICAgICAgICAgICAvLyBGb25jdGlvbiBkJ2FmZmljaGFnZSBkZSBsJ8OpbMOpbWVudCBjcsOpZSBsb3JzIGR1IGNsaWMgc3VyIGxhIGNoZWNrYm94XG4gICAgICAgICAgICB0aWNrZXRFbGVtZW50LnF1ZXJ5U2VsZWN0b3IoJy5mb3JtLWNoZWNrLWlucHV0JykuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IGN1cnJlbnQgPSBlLnRhcmdldCAvLyA9IGNoZWNrYm94XG4gICAgICAgICAgICAgIGlmKHRpY2tldEVsZW1lbnQucXVlcnlTZWxlY3RvcignLmZvcm0tY2hlY2staW5wdXQnKS5jaGVja2VkID09PSB0cnVlKXtcbiAgICAgICAgICAgICAgICBjdXJyZW50LnBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKG5ld05vZGUsIGN1cnJlbnQpO1xuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIGN1cnJlbnQucGFyZW50Tm9kZS5yZW1vdmVDaGlsZChuZXdOb2RlKTtcbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuXG4gIC8qJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgLy8gT24gcsOpY3Vww6hyZSBsYSBiYWxpc2UgPGRpdj4gZW4gcXVlc3Rpb24gcXVpIGNvbnRpZW50IGwnYXR0cmlidXQgwqsgZGF0YS1wcm90b3R5cGUgwrsgcXVpIG5vdXMgaW50w6lyZXNzZS5cblxuICAgIHZhciAkY29udGFpbmVyID0gJCgnZGl2I2NvbW1hbmRfdGlja2V0c19saXN0Jyk7XG5cbiAgICAvLyBPbiBkw6lmaW5pdCB1biBjb21wdGV1ciB1bmlxdWUgcG91ciBub21tZXIgbGVzIGNoYW1wcyBxdSdvbiB2YSBham91dGVyIGR5bmFtaXF1ZW1lbnRcbiAgICB2YXIgaW5kZXggPSAkY29udGFpbmVyLmZpbmQoJzppbnB1dCcpLmxlbmd0aDtcblxuICAgIC8vIE9uIGFqb3V0ZSB1biBub3V2ZWF1IGNoYW1wIMOgIGNoYXF1ZSBjbGljIHN1ciBsZSBsaWVuIGQnYWpvdXQuXG4gICAgJCgnI2FkZFRpY2tldCcpLmNsaWNrKGZ1bmN0aW9uKGUpIHtcbiAgICAgIGFkZFRpY2tldCgkY29udGFpbmVyKTtcblxuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpOyAvLyDDqXZpdGUgcXUndW4gIyBhcHBhcmFpc3NlIGRhbnMgbCdVUkxcbiAgICAgIHJldHVybiBmYWxzZTtcbiAgICB9KTtcblxuICAgIC8vIE9uIGFqb3V0ZSB1biBwcmVtaWVyIGJpbGxldCBhdXRvbWF0aXF1ZW1lbnQgcydpbCBuJ2VuIGV4aXN0ZSBwYXMgZMOpasOgIHVuIChjYXMgZCd1bmUgbm91dmVsbGUgYW5ub25jZSBwYXIgZXhlbXBsZSkuXG4gICAgaWYgKGluZGV4ID09IDApIHtcbiAgICAgIGFkZFRpY2tldCgkY29udGFpbmVyKTtcbiAgICB9IGVsc2Uge1xuICAgICAgLy8gUydpbCBleGlzdGUgZMOpasOgIHVuIGJpbGxldCwgb24gYWpvdXRlIHVuIGxpZW4gZGUgc3VwcHJlc3Npb24gcG91ciBjaGFjdW5lIGQnZW50cmUgZWxsZXNcbiAgICAgICRjb250YWluZXIuY2hpbGRyZW4oJ2RpdicpLmVhY2goZnVuY3Rpb24oKSB7XG4gICAgICAgIGFkZERlbGV0ZUxpbmsoJCh0aGlzKSk7XG4gICAgICB9KTtcbiAgICB9XG5cbiAgICAvL0Fqb3V0IGQndW4gZm9ybXVsYWlyZSBUaWNrZXRUeXBlXG4gICAgZnVuY3Rpb24gYWRkVGlja2V0KCRjb250YWluZXIpIHtcbiAgICAgIC8vIERhbnMgbGUgY29udGVudSBkZSBsJ2F0dHJpYnV0IMKrIGRhdGEtcHJvdG90eXBlIMK7LCBvbiByZW1wbGFjZSA6XG4gICAgICAvLyAtIGxlIHRleHRlIFwiX19uYW1lX19sYWJlbF9fXCIgcXUnaWwgY29udGllbnQgcGFyIGxlIGxhYmVsIGR1IGNoYW1wXG4gICAgICAvLyAtIGxlIHRleHRlIFwiX19uYW1lX19cIiBxdSdpbCBjb250aWVudCBwYXIgbGUgbnVtw6lybyBkdSBjaGFtcFxuICAgICAgdmFyIHRlbXBsYXRlID0gJGNvbnRhaW5lci5hdHRyKCdkYXRhLXByb3RvdHlwZScpXG4gICAgICAgIC5yZXBsYWNlKC9fX25hbWVfX2xhYmVsX18vZywgJ0JpbGxldCBuwrAnICsgKGluZGV4KzEpKVxuICAgICAgICAucmVwbGFjZSgvX19uYW1lX18vZywgICAgICAgIGluZGV4KVxuICAgICAgO1xuXG4gICAgICAvLyBPbiBjcsOpZSB1biBvYmpldCBqcXVlcnkgcXVpIGNvbnRpZW50IGNlIHRlbXBsYXRlXG4gICAgICB2YXIgJHByb3RvdHlwZSA9ICQodGVtcGxhdGUpO1xuXG4gICAgICAvLyBPbiBham91dGUgYXUgcHJvdG90eXBlIHVuIGxpZW4gcG91ciBwb3V2b2lyIHN1cHByaW1lciBsYSBjYXTDqWdvcmllXG4gICAgICBhZGREZWxldGVMaW5rKCRwcm90b3R5cGUpO1xuXG4gICAgICAvLyBPbiBham91dGUgbGUgcHJvdG90eXBlIG1vZGlmacOpIMOgIGxhIGZpbiBkZSBsYSBiYWxpc2UgPGRpdj5cbiAgICAgICRjb250YWluZXIuYXBwZW5kKCRwcm90b3R5cGUpO1xuXG4gICAgICAvKiQoJy5mb3JtLWNoZWNrLWlucHV0JykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICAgJChcIjxkaXY+PHN0cm9uZz5UZXN0PC9zdHJvbmc+PC9kaXY+XCIpLmFwcGVuZCgkKCcuZm9ybS1jaGVjay1pbnB1dCcpKTtcbiAgICAgIH0pOyovXG5cbiAgICAgIC8qdGlja2V0RWxlbWVudC5xdWVyeVNlbGVjdG9yKCcuZm9ybS1jaGVjay1pbnB1dCcpLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpKi9cblxuICAgICAgLyokKCc8c3Ryb25nPnRlc3Q8L3N0cm9uZz48YnIgLz4nKS5pbnNlcnRCZWZvcmUoJCgnLmZvcm0tY2hlY2staW5wdXQnKSk7Ki9cblxuICAgICAgLy8gRW5maW4sIG9uIGluY3LDqW1lbnRlIGxlIGNvbXB0ZXVyIHBvdXIgcXVlIGxlIHByb2NoYWluIGFqb3V0IHNlIGZhc3NlIGF2ZWMgdW4gYXV0cmUgbnVtw6lyb1xuICAgICAgLyppbmRleCsrO1xuICAgIH1cblxuICAgIC8vIExhIGZvbmN0aW9uIHF1aSBham91dGUgdW4gbGllbiBkZSBzdXBwcmVzc2lvbiBkJ3VuZSBjYXTDqWdvcmllXG4gICAgZnVuY3Rpb24gYWRkRGVsZXRlTGluaygkcHJvdG90eXBlKSB7XG4gICAgICAvLyBWw6lyaWZpY2F0aW9uIGRlIGwndXJsIHBvdXIgZMOpdGVybWluZXIgbGEgbGFuZ3VlIGR1IGJvdXRvblxuICAgICAgdmFyIGVuVXJsID0gL2VuXFwvbXVzZXVtXFwvYnV5JC9cbiAgICAgIHZhciB1cmxDb21wbGV0ID0gZG9jdW1lbnQubG9jYXRpb24uaHJlZjtcbiAgICAgIC8vIENyw6lhdGlvbiBkdSBsaWVuIHNvdXMgZm9ybWUgZGUgYm91dG9uXG4gICAgICBpZihlblVybC50ZXN0KHVybENvbXBsZXQpKVxuICAgICAge1xuICAgICAgICB2YXIgJGRlbGV0ZUxpbmsgPSAkKCc8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuIGJ0bi1kYW5nZXJcIj5EZWxldGU8L2E+Jyk7XG4gICAgICB9XG4gICAgICBlbHNlXG4gICAgICB7XG4gICAgICAgIHZhciAkZGVsZXRlTGluayA9ICQoJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLWRhbmdlclwiPlN1cHByaW1lcjwvYT48YnIgLz4nKTtcbiAgICAgIH1cblxuICAgICAgLy8gQWpvdXQgZHUgbGllblxuICAgICAgJHByb3RvdHlwZS5hcHBlbmQoJGRlbGV0ZUxpbmspO1xuXG4gICAgICAvLyBBam91dCBkdSBsaXN0ZW5lciBzdXIgbGUgY2xpYyBkdSBsaWVuIHBvdXIgZWZmZWN0aXZlbWVudCBzdXBwcmltZXIgbGEgY2F0w6lnb3JpZVxuICAgICAgJGRlbGV0ZUxpbmsuY2xpY2soZnVuY3Rpb24oZSkge1xuICAgICAgICAkcHJvdG90eXBlLnJlbW92ZSgpO1xuXG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTsgLy8gw6l2aXRlIHF1J3VuICMgYXBwYXJhaXNzZSBkYW5zIGwnVVJMXG4gICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgIH0pO1xuICAgIH1cbiAgfSk7Ki8iXSwic291cmNlUm9vdCI6IiJ9