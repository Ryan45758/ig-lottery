require('./bootstrap');

// 需要 Vue
window.Vue = require('vue').default; 

// 註冊 Vue 組件
Vue.component('example-component', require('./components/ExampleComponent.vue').default); 



// 註冊 Vue 組件
Vue.component('ig-lottery-form', require('./components/IgLotteryForm.vue').default); 
Vue.component('nav-bar', require('./components/Navbar.vue').default); 
Vue.component('comment-table', require('./components/CommentTable.vue').default); 
Vue.component('range-slider', require('./components/RangeSlider.vue').default); 
 Vue.component('sidebar-menu', require('./components/SideBarMenu.vue').default); 
import VueParticlesBg from "particles-bg-vue";
Vue.use(VueParticlesBg);


