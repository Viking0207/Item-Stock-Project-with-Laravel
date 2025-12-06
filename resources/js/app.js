import './bootstrap';

import * as bootstrap from 'bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'bootstrap/dist/css/bootstrap.min.css';
// import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'

import Swal from 'sweetalert2';
if (!window.Swal) {
    window.Swal = Swal;
}


import AOS from 'aos';
import "aos/dist/aos.css";



AOS.init({ once: false, duration: 800 });