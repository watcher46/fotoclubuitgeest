//require jQuery
const $ = require('jquery');

//require bootstrap
require("bootstrap/dist/js/npm");

//require the image slider
require('nivo-slider/jquery.nivo.slider.pack');
$('#slider').show().nivoSlider({
    effect: 'fade',
    animSpeed: 500,
    pauseTime: 5000,
    directionNav: false,
    controlNav: false
});


//require the gallery viewer
let lightbox = require('lightbox2/dist/js/lightbox.min');
//set lightbox options
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
});