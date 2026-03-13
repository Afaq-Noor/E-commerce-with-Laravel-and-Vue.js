import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue' 
import Layout from '../pages/Layout.vue'
import Index from '../pages/Index.vue'
import Category from '../pages/Category.vue'
import Product from '../pages/Product.vue'
import ShoppingCart from '../pages/ShoppingCart.vue'
import Checkout from '../pages/Checkout.vue'
const routes = [
  {
    path: '/',
    component: Index
  } , 
  {
    name : 'Category' ,
    path: '/category/:slug?' ,
    component: Category
  } , 
  {
    name : 'Product' ,
    path: '/product/:slug?' ,
    component: Product
  } ,
  {
    name : 'ShoppingCart' ,
    path: '/ShoppingCart' ,
    component: ShoppingCart
  } ,
   {
    name : 'Checkout' ,
    path: '/Checkout' ,
    component: Checkout
  }
  
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
