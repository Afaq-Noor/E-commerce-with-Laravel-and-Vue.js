
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

createApp(App)
  .use(router)
  .mount('#app')
// Import SweetAlert2
import Swal from 'sweetalert2';

// Make Swal available globally so you can use window.Swal in your Blade/JS
window.Swal = Swal;
import './bootstrap';


