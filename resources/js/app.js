require('./bootstrap');
require('tailwind-scrollbar');
require("flatpickr/dist/themes/dark.css");
const Chart = require('chart.js');

// const flatpickr = require("flatpickr");
const feather = require('feather-icons');
feather.replace()


// import Chart from 'chart.js/auto';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'

import Dropzone from "dropzone";
import moment from 'moment';
import collapse from '@alpinejs/collapse'
import mask from '@alpinejs/mask'
import flatpickr from "flatpickr";



Alpine.plugin(mask)

Alpine.plugin(collapse)

Alpine.plugin(persist)

window.Alpine = Alpine;

Alpine.start();

import Main from './components/main.js';
import Timer from './components/timer.js';
import Verification from './components/verificationCode.js';
import Form from './components/form.js';
import Passport from './components/passport.js';
import Requirement from './components/requirement.js';
import Document from './components/document.js';
import Client from './components/client.js';
import Application from './components/application.js';
import Dashboard from './components/dashboard.js';


