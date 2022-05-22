require('./bootstrap');
require('tailwind-scrollbar');
const feather = require('feather-icons');
feather.replace()
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
