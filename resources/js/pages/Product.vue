<template>
<Layout>
    <template v-slot:content="slotProps">
        <!-- main-area -->
        <main>

            <!-- breadcrumb-area -->
            <div class="breadcrumb-area breadcrumb-style-two" data-background="../assets/img/bg/s_breadcrumb_bg01.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 d-none d-lg-block">
                            <div class="previous-product">
                                <a href="shop-details.html"><i class="fas fa-angle-left"></i> previous product</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="breadcrumb-content">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                        <li class="breadcrumb-item"><a href="shop.html">Winter 20</a></li>
                                        <li class="breadcrumb-item"><a href="shop.html">Women</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Tracker Jacket</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-lg-3 d-none d-lg-block">
                            <div class="next-product">
                                <a href="shop-details.html">Next product <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- breadcrumb-area-end -->

            <!-- shop-details-area -->
            <section class="shop-details-area pt-100 pb-95">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="shop-details-flex-wrap">
                                <div class="shop-details-nav-wrap">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li v-for="(item,index) in images" :key="item.id" class="nav-item" role="presentation">
                                            <a :class="'nav-link '+showActiveClass(1,index)" :id="'item-'+item.id" @click.prevent="activeIndex = index, this.color.product_attr_id = item.product_attr_id" :href="'#item-'+item.id" role="tab" aria-controls="item-one" aria-selected="true">
                                                <img :src="'/storage/'+item.image" alt=""></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="item-two-tab" data-toggle="tab" href="#item-two" role="tab" aria-controls="item-two" aria-selected="false"><img src="../assets/img/product/sd_nav_img02.jpg" alt=""></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="item-three-tab" data-toggle="tab" href="#item-three" role="tab" aria-controls="item-three" aria-selected="false"><img src="../assets/img/product/sd_nav_img03.jpg" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="shop-details-img-wrap">
                                    <div class="tab-content" id="myTabContent">
                                        <div v-for="(item,index) in images" :key="item.id" :class="'tab-pane fade '+showActiveClass(2,index)" :id="'item-'+item.id" role="tabpanel" :aria-labelledby="'item-'+item.id+'-tab'">
                                            <div class="shop-details-img">
                                                <img :src="'/storage/' + images[activeIndex].image" alt="">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="shop-details-content">
                                <!-- <a href="#" class="product-cat">Tracker Jacket</a> -->
                                <h3 class="title">{{ product.name }}</h3>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="style-name">Slug - | {{ product.slug }} |</p>
                                <div class="price"> {{ product.product_attr[0].price }}</div>
                                <div class="product-details-info">
                                    <span>Size <a href="#">Guide</a></span>
                                    <div class="sidebar-product-size mb-30">
                                        <h4 class="widget-title">Product Size</h4>
                                        <div class="shop-size-list">
                                            <ul>
                                                <li v-for="item in uniqueSizes"><a v-on:click="showColor(item),this.size = item" 
                                                :class="this.size == item ? sizeColor : ''" href="javascript:void(0)">
                                                 {{item }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="sidebar-product-color">
                                        <h4 class="widget-title">Color</h4>
                                        <div class="shop-color-list">
                                            <ul>
                                                <li v-for="item in uniqueColors" :style="{backgroundColor:item.value}"
                                                 v-on:click="this.color.id=item.id, this.color.text = item.text , 
                                                 this.color.product_attr_id = item.product_attr_id" 
                                                  :class="this.color.id == item.id ? colorColor : ''"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="perched-info">
                                    <div class="cart-plus-minus">
                                        <form action="#" class="num-block">
                                            <input type="text" class="" value="{{qty}}" v-model="qty" readonly="">
                                            <div class="qtybutton-box">
                                                <span class="plus" v-on:click="qty++">
                                                <img src="../assets/img/icon/plus.png" alt=""  
                                                style="display: block; margin-left: auto; margin-right: auto; width: 50%;"></span>
                                                <span class="minus dis" v-on:click="qty--">
                                                <img src="../assets/img/icon/minus.png"  style="display: block; margin-left: auto; margin-right: auto; width: 50%;" 
                                                alt=""></span>
                                            </div>
                                        </form>
                                    </div>
                                    <a href="javascript:void(0)"  
                                    v-on:click="slotProps.addToCart( this.product.id, this.color.product_attr_id, this.qty)" 
                                    class="btn">add to cart</a>
                                    <div class="wishlist-compare">
                                        <ul>
                                            <li><a href="javascript:void(0)" >
                                            <i class="far fa-heart"></i> Add to Cart</a></li>
                                            <li><a href="#"><i class="fas fa-retweet"></i> Add to Compare List</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-details-share">
                                    <ul>
                                        <li>Share :</li>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product-desc-wrap">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description Guide</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                        <div class="product-desc-title mb-30">
                                            <h4 class="title">Additional information :</h4>
                                        </div>
                                        <p><span v-html="product.description"> </span></p>
                                        <div class="color-size-info">
                                            <ul>
                                                <li><span>COLOR :</span> Black, Gray</li>
                                                <li><span>SIZE :</span> XS, S, M, L</li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                        <div class="product-desc-title mb-30">
                                            <h4 class="title">Reviews (0) :</h4>
                                        </div>
                                        <p>Your email address will not be published. Required fields are marked</p>
                                        <p class="adara-review-title">Be the first to review “Adara”</p>
                                        <div class="review-rating">
                                            <span>Your rating *</span>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <form action="#" class="comment-form review-form">
                                            <span>Your review *</span>
                                            <textarea name="message" id="comment-message" placeholder="Your Comment"></textarea>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Your Name*">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" placeholder="Your Email*">
                                                </div>
                                            </div>
                                            <div class="comment-check-box">
                                                <input type="checkbox" id="comment-check">
                                                <label for="comment-check">Save my name and email in this browser for the next time I comment.</label>
                                            </div>
                                            <button class="btn">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="related-product-wrap">
                        <div class="row">
                            <div class="col-12">
                                <div class="related-product-title">
                                    <h4 class="title">You May Also Like...</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row related-product-active">
                            <div class="col-xl-3" v-for="item in other_products" :key="item.id">
                                <div class="new-arrival-item text-center">
                                    <div class="thumb mb-25">
                                        <a href="shop-details.html"><img :src="'/'+item.image" alt="" 
                                        style="width: 100%; height: 250px; object-fit: cover;" ></a>
                                        <div class="product-overlay-action">    
                                            <ul>
                                                <li><a href="javascript:void(0)"> <i class="fa fa-shopping-cart" @click="slotProps.addToCart(item.id,item.product_attr[0]?.id,1)"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="far fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h5><a href="shop-details.html">{{ item.name }}</a></h5>
                                        <span class="price"> Rs  {{ item.product_attr?.length ? item.product_attr[0].price : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </section>
            <!-- shop-details-area-end -->

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
    name: 'Product',
    components: {
        Layout
    },
    data() {
        return {
            slug: '',
            product: {
                product_attr: [
                    price => ''
                ]
            },
            images: [],
            colors: [],
            sizes: [],
            uniqueColors: [],
            uniqueSizes: [],
            size: '',
            color: {
                id: '',
                text: '',
                product_attr_id: ''
            },
            activeIndex: 0 ,
            sizeColor: 'sizeColor',
            colorColor: 'colorColor',
            qty: 1 , 
            
            other_products: [],
            other_products_attr: [],
        }
    },
    watch: {
        '$route'() {
            this.getProducts();
        } , 
        qty(val){
            if(val == 0 || val < 1) {
                this.qty = 1;
            }
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        showColor(size){
            this.uniqueColors = [] ;
            this.color.id = '' ;
            this.color.text = '' ;
            this.color.product_attr_id = '' ;

            for(var item in this.colors) {

                if(this.colors[item].size == size ){
                     this.uniqueColors.push(this.colors[item]) ;
                     this.size = size ;
                }
            }
        }
        ,
        showActiveClass(type, index) {
            if (index == 0) {
                return type == 1 ? 'active' : 'show active';
            }
            return '';
        },
        async getProducts() {
            try {
                this.slug = this.$route.params.slug;
                // const route = useRoute() ;

                if (this.slug == '' || this.slug == undefined || this.slug == null) {
                    this.$router.push({
                        name: 'Index'
                    });
                } else {
                    const response = await axios.get('/api/getProductData/' + this.slug);

                    if (response.status == 200) {
                        console.log(response.data.data.id);
                        this.product = response.data.data.data;
                        this.other_products = response.data.data.data.other_products;
                        this.other_products_attr = [];
                        //extract product_attr from each other_products
                        this.other_products.forEach(product => {
                              if(product.product_attr) {
                                this.other_products_attr.push(...product.product_attr) ;
                              }
                        }) ;
                        console.log(this.other_products_attr);
                        this.images = [];
                        


                        for (var item in this.product.product_attr) {
                            for (var subItem in this.product.product_attr[item].images) {
                                this.images.push(this.product.product_attr[item].images[subItem]);
                            }
                            this.colors.push({
                                id: this.product.product_attr[item].colors.id,
                                value: this.product.product_attr[item].colors.value,
                                product_attr_id: this.product.product_attr[item].id,
                                size: this.product.product_attr[item].sizes.text,
                            });

                            this.sizes.push({
                                id: this.product.product_attr[item].sizes.id,
                                text: this.product.product_attr[item].sizes.text,
                                product_attr_id: this.product.product_attr[item].id,
                            });
                        }
                        this.uniqueSizes = [...new Set(this.sizes.map(item => item.text))] ;
                        this.uniqueColors = this.colors ;
                        // console.log(this.other_products)
                        // this.activeIndex = 0;

                    }
                }

            } catch (errors) {
                console.log("Error".errors)
            }
        }
    }
}
</script>


<style>
.brandColor::before {
    background-color: #ff5400
}

.sizeColor {
    background-color: #ff5400 ;
    color: #ffff ;
}
.colorColor::before {
    content: '\2713' ;
    display: inline-block;
    color: #f00 ;
    padding: 0 6px 0 0 ;
}
</style>