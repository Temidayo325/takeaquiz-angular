import './bootstrap';

import Alpine from 'alpinejs';

import 'flowbite';

// import Toastify from 'toastify-js';
// window.Toastify


window.Alpine = Alpine;

Alpine.store('place', {
    details: {
        address: '',
        lat: '',
        long: '',
        id: ''
    }
})

Alpine.store('universal', {
    toast(text, background)
    {
        Toastify({
            text: text, 
            style: {
            background: background,
            color: '#fff'
            }
        }).showToast();
    },
})
Alpine.start();
