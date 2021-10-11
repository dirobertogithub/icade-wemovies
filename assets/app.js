/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
//import { Tooltip, Toast, Popover } from 'bootstrap';
//require('bootstrap')
import 'bootstrap';
// start the Stimulus application
window.bootstrap = require("bootstrap")

//import jquery from 'jquery';

 //require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

require('./js/wemovies')

// fix video  playing after closing the modal in detail
$('#modal-details').on('hidden.bs.modal', function () {
    $('#modal-details .modal-body').empty();

});






