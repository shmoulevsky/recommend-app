import CarsIndex from './components/Cars/Index.vue'
import CarsDetail from './components/Cars/Detail.vue'
import {createRouter, createWebHistory} from "vue-router";

const routes = [
    { path: '/', component: CarsIndex },
    { path: '/cars', component: CarsIndex },
    { path: '/cars/:id', component: CarsDetail },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
