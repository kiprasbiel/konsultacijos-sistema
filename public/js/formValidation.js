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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/formValidation.js":
/*!****************************************!*\
  !*** ./resources/js/formValidation.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// //Tikrina imones ikurimo data ir pagal tai palieka
// //tik leistinus konsultacijos tipus
//Jei imonei daugiau nei 5 metai, tai pasalina VKT is dropdown
jQuery(document).ready(function ($) {
  $("#company_reg_date").change(function () {
    var ivestaData = new Date($("#company_reg_date").val());
    var esamaData = new Date();
    var skirtumas = (esamaData - ivestaData) / 1000 / 60 / 60 / 24 / 365;

    if (skirtumas >= 5) {
      $('#con_type option[value="VKT"]').css("display", "none");
    }
  });
});
jQuery(document).ready(function ($) {
  $('.select2').select2();
});
jQuery(document).ready(function ($) {
  $('#company_id').select2({
    placeholder: "Veskite pavadinimą...",
    minimumInputLength: 3,
    ajax: {
      delay: 500,
      url: '/search',
      dataType: 'json',
      data: function data(params) {
        return {
          q: $.trim(params.term)
        };
      },
      processResults: function processResults(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
  $('#company_id').change(function () {
    $("#theme").html('');
    var klientas = $(this).select2('data');

    if (klientas != null) {
      var ivestaData = new Date(klientas[0].company_reg_date);
      var esamaData = new Date();
      var skirtumas = (esamaData - ivestaData) / 1000 / 60 / 60 / 24 / 365;
      $('#contacts').val(klientas[0].contacts);
      $.ajax({
        type: 'get',
        url: '/themesearch',
        data: {
          'theme': klientas[0].con_type,
          'how_old': skirtumas
        },
        success: function success(data) {
          var visa_info = [];
          data.forEach(funkcija);

          function funkcija(item, index) {
            visa_info.push({
              id: item.id,
              text: item.theme_number + '. ' + item.name
            });
          }

          ;
          $("#theme").select2({
            data: visa_info
          });
        }
      });
    }
  });
});

/***/ }),

/***/ 1:
/*!**********************************************!*\
  !*** multi ./resources/js/formValidation.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\konsultacijos\resources\js\formValidation.js */"./resources/js/formValidation.js");


/***/ })

/******/ });