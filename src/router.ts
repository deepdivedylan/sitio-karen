import { createRouter, createWebHistory } from 'vue-router';
import Contact from './components/pages/Contact.vue';
import Home from './components/pages/Home.vue';
import Location from './components/pages/Location.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/contact', component: Contact },
    { path: '/location', component: Location },
    { path: '/:pathMatch(.*)*', redirect: '/' }
];
const history = createWebHistory();

export default createRouter({
    history,
    routes
});