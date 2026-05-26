import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// We do not manually register Alpine or its plugins here
// because Livewire 3 and Flux handle Alpine's lifecycle automatically.
// Redefining $persist was causing a JavaScript error that broke all interactivity.
