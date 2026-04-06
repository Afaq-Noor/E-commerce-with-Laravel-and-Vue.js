<template>
<Layout>
    <template v-slot:content="slotProps">
        <!-- main-area -->
        <main>
            <!-- breadcrumb-area -->
            <section class="breadcrumb-area breadcrumb-bg" data-background="/front_end/img/bg/breadcrumb_bg03.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="breadcrumb-content">
                                <h2>My Order Page</h2>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Order</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb-area-end -->

            <!-- cart-area -->
            <div class="cart-area pt-100 pb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="cart-wrapper">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">Picture</th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">QUANTITY</th>
                                                <th class="product-subtotal">SUBTOTAL</th>
                                                <th class="product-delete"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in userOrdersProducts" :key="item.id">
                                               <td class="product-thumbnail"><a href="shop-details.html"><img :src="'/'+item?.image" alt=""></a></td>
                                                <td class="product-name">
                                                    <h4>
                                                        <router-link :to="'/product/'">{{ item.product_name }}</router-link>
                                                    </h4>
                                                </td>
                                                <td class="product-price">{{ item.price }}</td>
                                                <td class="product-price">{{ item.qty }}</td>
                                                <td class="product-price">{{ item.price * item.qty }}</td>
                                               
                                               
                                                
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="cart-total pt-95">
                                <h3 class="title">Orders Total</h3>
                                <div class="shop-cart-widget">
                                    <form action="#">
                                        <ul>
                                            <li class="title"><span>Rs: {{ ordersTotalPrice }}</span> </li>
                                         </ul>   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- cart-area-end -->

        </main>
        <!-- main-area-end -->
    </template>
</Layout>
</template>

<script>
import Layout from './Layout.vue'
import axios from 'axios'
import {
    useRoute
} from 'vue-router';
export default {
    name: 'MyOrder',
    // props: ['cartTotal'],
    components: {
        Layout
    },
    data() {
        return {
            loading: false,
            token: false,
            user_info: {
                'user_id': '',
                'auth': false
            },
            userOrders: [],
            userOrdersDetails: [],
            userOrdersProducts: [],
            ordersTotalPrice: 0 ,
        }
    },
    mounted() {
        this.getUser();
        this.getMyOrders();
    },
    methods: {
        async getMyOrders() {
            try {
                const rawToken = localStorage.getItem('auth_token');

                // Use JSON.parse to remove the extra quotes added by JSON.stringify
                const token = rawToken ? JSON.parse(rawToken) : null;
                let response = await axios.get('/api/my-orders', {

                    headers: {
                        Authorization: `Bearer ${token}`
                    }

                });
                if (response.status == 200) {
                    console.log(response.data.orders);
                    this.userOrders = response.data.orders;
                    this.userOrdersDetails = [];
                    this.userOrdersProducts = [];

                    this.userOrders.forEach(order => {
                        order.order_details.forEach(detail => {
                            this.userOrdersDetails.push({
                                id: detail.id ,
                                qty: detail.qty,
                                total_value: detail.total_value , 
                                order_id: detail.order_id
                            }) ;
                            this.ordersTotalPrice += detail.product_attr.price * detail.qty;
                            if(detail.product_attr) {
                                this.userOrdersProducts.push({
                                    id: detail.product_attr.id ,
                                    price: detail.product_attr.price ,
                                    product_name: detail.product_attr.product.name ,
                                    image: detail.product_attr.product.image ,
                                    qty: detail.qty ,
                                }) ;
                            }
                        }) ;
                    });

                    console.log(this.userOrdersDetails);
                    console.log(this.userOrdersProducts);

                } else {

                }
            } catch (error) {
                console.log(error)
            }

        },
        async getUser() {
            if (localStorage.getItem('user_info')) {
                var user = localStorage.getItem('user_info');
                var testUser = JSON.parse(user);
                // console.log(testUser.user_id)
                this.user_info.user_id = testUser.user_id;
                this.getUserData();
            } else {
                // user not set to localStorage
                this.getUserData();
            }
        },
        async getUserData() {
            try {
                let response = await axios.post('/api/getUserData', {
                    'token': this.user_info.user_id,
                });
                if (response.status == 200) {
                    if (response.data.data.user_type == 1) {
                        // Auth user
                        this.user_info.auth = true;
                        this.user_info.user_id = response.data.data.token;
                        // this.checkingUserHasCart = response.data.data.id ;
                        localStorage.setItem('user_info', JSON.stringify(this.user_info));
                    } else {
                        // Not Auth User    
                        this.user_info.auth = false;
                        this.user_info.user_id = response.data.data.token;
                        this.checkingUserHasCart = response.data.data.tempUser.user_id;
                        console.log(this.checkingUserHasCart)
                        localStorage.setItem('user_info', JSON.stringify(this.user_info));
                    }
                } else {
                    console.log('Data Not Found');
                }
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>
