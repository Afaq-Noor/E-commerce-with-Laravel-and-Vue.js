import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue' 
import Layout from '../pages/Layout.vue'
import Index from '../pages/Index.vue'
import Category from '../pages/Category.vue'
import Product from '../pages/Product.vue'
import ShoppingCart from '../pages/ShoppingCart.vue'
import Checkout from '../pages/Checkout.vue'
import MyOrder from '../pages/MyOrder.vue'
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
  } , 
  {
    name : 'MyOrder' ,
    path: '/MyOrder' ,
    component: MyOrder
  }
  
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
