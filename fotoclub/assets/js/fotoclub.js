//require jQuery
const $ = require('jquery');

//require bootstrap
require("bootstrap/dist/js/npm");

//require the image slider
require('nivo-slider/jquery.nivo.slider.pack');

//require the gallery viewer
let lightbox = require('lightbox2/dist/js/lightbox.min');
//set lightbox options
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
});