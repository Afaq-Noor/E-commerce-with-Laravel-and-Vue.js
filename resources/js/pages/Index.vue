<template>
<Layout>
    <template v-slot:content>

        <!-- slider-area -->
        <section class="slider-area position-relative">
            <div class="third-slider-active">
                <div v-for="homeBr in homeBanners" :key="homeBr.id" class="third-slider-item third-slider-bg" data-background="front_end/img/slider/third_slider_bg.jpg">
                    <div class="container custom-container-two">
                        <div class="third-slider-wrap">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="slider-content">
                                        <h3 class="sub-title" data-animation-in="fadeInUp" data-delay-in=".2" data-duration-in="1.5">best offer !</h3>
                                        <h2 class="title" data-animation-in="fadeInUp" data-delay-in=".4" data-duration-in="1.5">Gym sports shoes</h2>
                                        <p data-animation-in="fadeInUp" data-delay-in=".6" data-duration-in="1.5">Get up to 50% off Today Only</p>
                                        <a href="shop-sidebar.html" class="btn" data-animation-in="fadeInUp" data-delay-in=".8" data-duration-in="1.5">Shop now</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="third-slider-img">
                                        <div class="img-shape" background="/front_end/img/slider/third_slide_shape.jpg" data-animation-in="zoomIn" data-delay-in="1" data-duration-in="1.5"></div>
                                        <img :src="`/${homeBr.image}`" style="width:100%;height:85%;border-radius:50%;" alt="" class="main-img" data-animation-in="slideInRight2" data-delay-in="1" data-duration-in="1.5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- slider-area-end -->

        <!-- shoes-category-area -->
        <div class="shoes-category-area pt-80 pb-30">
            <div class="container custom-container-two">
                <div class="row justify-content-center">

                    <div class="col-lg-4 col-md-6 col-sm-9" v-for="catPr in categoriesWithProducts" :key="catPr.id">
                        <div class="shoes-cat-item mb-50">

                            <div class="thumb mb-30">
                                <a :href="`/shop/${catPr.slug}`">
                                    <div style="width:100%; aspect-ratio:4/3; overflow:hidden;">
                                        <a :href="`/${catPr.slug}`">
                                            <img :src="catPr.image ? `/${catPr.image}` : '/front_end/img/no_image.jpg'" :alt="catPr.name" style="
                                           width:100%;  height:80%; object-fit:cover; display:block;" />
                                        </a>
                                    </div>

                                </a>
                            </div>

                            <div class="content">
                                <ul>
                                    <li>
                                        <a :href="`/shop/${catPr.slug}`">
                                            {{ catPr.name }}
                                        </a>
                                    </li>
                                    <li>
                                        <span>{{ catPr.slug }}</span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- shoes-category-area-end -->

        <!-- trending-product-area -->
        <section class="trending-product-area trending-product-two gray-bg pt-95 pb-100">
            <div class="container custom-container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6">
                        <div class="section-title title-style-two text-center mb-50">
                            <h3 class="title">Trending Products</h3>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters trending-product-grid">
                    <div class="col-2">
                        <div class="trending-products-list">
                            <h5>Categories</h5>
                            <ul class="nav nav-tabs" id="trendingTab" role="tablist">
                                <li class="nav-item" v-for="(catTrend, index) in categoriesWithProducts" :key="catTrend.id" role="presentation">
                                    <a class="nav-link" :class="{ active: index === 0 }" :id="`tab-${catTrend.id}`" data-toggle="tab" :href="`#cat-${catTrend.id}`">{{ catTrend.name }}</a>
                                </li>

                            </ul>
                            <p class="offer"><a href="#">Limited-Time Offer!</a></p>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="tab-content tp-tab-content">
                            <div class="tab-pane fade" :class="{ show: index === 0, active: index === 0}" v-for="(catProducts, index) in categoriesWithProducts" :key="catProducts.id" :id="`cat-${catProducts.id}`">

                                <div class="trending-products-banner banner-animation  ratio ratio-16x9" style="width:100%; aspect-ratio:4/3; overflow:hidden;">
                                    <a href="#" class="d-block w-100 h-100">
                                        <img :src="`/${catProducts.image}`" style="
                                           width:100%;  height:80%; 
                                             display:block;" :alt="catProducts.name" class="img-fluid w-100 h-100 object-fit-cover"></a>
                                </div>
                                <div class="trending-product-active">
                                    <div class="col swiper-slide d-flex" v-for="trendProduct in catProducts.products" :key="trendProduct.id">
                                        <div class="features-product-item  d-flex flex-column w-100">
                                            <div class="features-product-thumb  ratio ratio-1x1" style="width:100%; aspect-ratio:4/3; overflow:hidden;">
                                                <div class="discount-tag">-20%</div>
                                                <a href="shop-details.html" class="d-block w-100 h-100">
                                                    <img :src="trendProduct.image ? `/${trendProduct.image}` : '/front_end/img/no_image.jpg'" :alt="trendProduct.name" style="width:100%;  height:100%; 
                                                    object-fit: cover;
                                                   object-position: center top; display:block;" class="img-fluid w-100 h-100 object-fit-cover">
                                                </a>
                                                <div class="product-overlay-action">
                                                    <ul>
                                                        <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                                        <li><a href="shop-details.html"><i class="far fa-eye"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="features-product-content">
                                                <div class="rating">
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <h5><a href="shop-details.html">{{ trendProduct.name }}</a></h5>
                                                <p class="price">{{ trendProduct.product_attr[0]?.price }}</p>
                                                <div class="features-product-bottom">
                                                    <ul>
                                                        <li class="color-option">
                                                            <span class="gray"></span>
                                                            <span class="cyan"></span>
                                                            <span class="orange"></span>
                                                        </li>
                                                        <li class="limited-time"><a href="#">Limited-Time Offer!</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="features-product-cart"><a href="cart.html">add to cart</a></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- trending-product-area-end -->

        <!-- new-arrival-area -->
        <section class="new-arrival-area pt-95 pb-45">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6">
                        <div class="section-title title-style-two text-center mb-45">
                            <h3 class="title">New Arrival Collection</h3>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="new-arrival-nav mb-35">
                            <!-- Categories -->
                            <button v-for="cat in categoriesWithProducts" :data-filter="'.cat-' + cat.id" :key="cat.id" @click="activeCategoryId = cat.id" :class="{ 'text-danger': activeCategoryId === cat.id }">
                                {{ cat.name }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row new-arrival-active">

                    <div v-for="product in productWithAttr.slice(0,8)" :key="product.id" class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer" :class="'cat-' + product.category_id">

                        <div class="new-arrival-item text-center mb-50">
                            <div class="thumb mb-25" style="width:100%; aspect-ratio:4/3; overflow:hidden;">
                                <a :href="`/product/${product.slug}`">
                                    <img :src="product.image ? `/${product.image}` : '/front_end/img/no_image.jpg'" :alt="product.name" style="width:100%;  height:100%;  display:block;">
                                </a>

                                <div class="product-overlay-action">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="far fa-heart"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a :href="`/product/${product.slug}`">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="content">
                                <h5>
                                    <a :href="`/product/${product.slug}`">
                                        {{ product.name }}
                                    </a>
                                </h5>

                                <span class="price">
                                    Rs {{ product.product_attr[0]?.price }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- new-arrival-area-end -->

        <!-- shoes-banner-area -->
        <section class="shoes-banner-area">
            <div class="container">
                <div class="shoes-banner-active">
                    <div class="shoes-banner-bg" data-background="/front_end/img/bg/shoes-banner_bg.jpg">
                        <div class="row">
                            <div class="col-12">
                                <div class="shoes-banner-content">
                                    <h6>Athletes Shoes</h6>
                                    <h2>9 Best <span>Shoes for</span> Standing All Day Review 2020</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="shoes-banner-bg" data-background="/front_end/img/bg/shoes-banner_bg.jpg">
                        <div class="row">
                            <div class="col-12">
                                <div class="shoes-banner-content">
                                    <h6>Athletes Shoes</h6>
                                    <h2>3 Best <span>Shoes for</span> Standing All Day Review 2021</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="shoes-banner-bg" data-background="/front_end/img/bg/shoes-banner_bg.jpg">
                        <div class="row">
                            <div class="col-12">
                                <div class="shoes-banner-content">
                                    <h6>Athletes Shoes</h6>
                                    <h2>8 Best <span>Shoes for</span> Standing All Day Review 2021</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- shoes-banner-area-end -->

        <!-- promo-services -->
        <section class="promo-services pt-70 pb-25">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-6 col-sm-8">
                        <div class="promo-services-item mb-40">
                            <div class="icon"><img src="../assets/img/icon/promo_icon01.png" alt=""></div>
                            <div class="content">
                                <h6>payment & delivery</h6>
                                <p>Delivered, when you receive arrives</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-8">
                        <div class="promo-services-item mb-40">
                            <div class="icon"><img src="../assets/img/icon/promo_icon02.png" alt=""></div>
                            <div class="content">
                                <h6>Return Product</h6>
                                <p>Retail, a Product Return Process</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-8">
                        <div class="promo-services-item mb-40">
                            <div class="icon"><img src="../assets/img/icon/promo_icon03.png" alt=""></div>
                            <div class="content">
                                <h6>money back guarantee</h6>
                                <p>Options Including 24/7</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-8">
                        <div class="promo-services-item mb-40">
                            <div class="icon"><img src="../assets/img/icon/promo_icon04.png" alt=""></div>
                            <div class="content">
                                <h6>Quality support</h6>
                                <p>Support Options Including 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- promo-services-end -->

        <!-- instagram-post-area -->
        <div class="instagram-post-area">
            <div class="container-fluid p-0 fix">
                <div class="row no-gutters insta-active">
                    <div class="col" v-for="brand in brands" :key="brand.id">
                        <div class="insta-post-item" style="width:100%; ">
                            <a href="#">
                                <i class="fab fa-instagram"></i>
                                <img :src="brand.image ? `/${brand.image}` : '/front_end/img/no_image.jpg'" :alt="brand.name" 
                                style="width: 300px; height: 250px;">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- instagram-post-area-end -->

    </template>

</Layout>
</template>

<script>
import Layout from './Layout.vue'
import axios from 'axios'

export default {
    name: 'Index',
    components: {
        Layout
    },
    data() {
        return {
            categoriesWithProducts: [],
            homeBanners: [],
            activeCategoryId: null,
            productWithAttr: [],
            brands: [], 
            
        }
    },
    mounted() {
        this.getHomeData();
    },
    methods: {

       async getHomeData() {
            const response = await axios.get('/api/front-home-data')
               
                    console.log(response)
                    this.categoriesWithProducts = response.data.data.categoriesWithProducts;
                    this.productWithAttr = response.data.data.productWithAttr;
                    this.homeBanners = response.data.data.homeBanners;
                    this.brands = response.data.data.brands;
                    // ✅ DEFAULT FIRST CATEGORY
                    // if (this.categoriesWithProducts.length) {
                    //     this.activeCategoryId = this.categoriesWithProducts[0].id
                    // }
               
        }

    }
}
</script>
