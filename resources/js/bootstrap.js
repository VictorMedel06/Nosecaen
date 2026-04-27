import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');
const baseUrlMeta = document.head.querySelector('meta[name="base-url"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

if (baseUrlMeta?.content) {
    window.axios.defaults.baseURL = baseUrlMeta.content.replace(/\/+$/, '');
}
