try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass')
} catch (e) {
}

let token = document.head.querySelector('meta[name="csrf-token"]');
