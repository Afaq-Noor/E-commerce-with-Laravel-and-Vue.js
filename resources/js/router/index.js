import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue' 
import Layout from '../pages/Layout.vue'
import Index from '../pages/Index.vue'
import Category from '../pages/Category.vue'
const routes = [
  {
    path: '/front',
    component: Index
  } , 
  {
    path: '/category/:slug' ,
    name : 'category' ,
    component: Category
  }

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
