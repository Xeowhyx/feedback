/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

$(document).ready(function () {
   $('.sidenav').sidenav();
});

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

document.addEventListener('DOMContentLoaded', function() {
   var elems = document.querySelectorAll('select');
   var instances = M.FormSelect.init(elems, options);
});

document.addEventListener('DOMContentLoaded', function() {
   var elements = document.querySelectorAll('.datepicker');
   var instancesd = M.Datepicker.init(elements, options);
});
document.addEventListener('DOMContentLoaded', function() {
   var elem = document.querySelectorAll('.materialboxed');
   var instance = M.Materialbox.init(elem, options);
});

document.addEventListener('DOMContentLoaded', function() {
   var elems = document.querySelectorAll('.carousel');
   var instancec = M.Carousel.init(elems, options);
});
document.addEventListener('DOMContentLoaded', function() {
   var elems = document.querySelectorAll('.parallax');
   var instancep = M.Parallax.init(elems, options);
});



