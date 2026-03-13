<?php

namespace App\Http\Controllers\FrontendUser;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Pincode;
use App\Models\ProductAttr;
use App\Models\Role;
use App\Models\TempUser;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCouponCart;
use App\Models\UserOrder;
use App\Models\UserOrderDetail;
use App\PaymentGateways\GatewayFactory;
use Validator;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoriesWithProduct = Category::with(['products.productAttr'])->get();
        $homeBanners = HomeBanner::get();
        $brands = Brand::get();
        $productWithAttr = Product::with('productAttr')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'categoriesWithProducts' => $categoriesWithProduct,
                'homeBanners' => $homeBanners,
                'brands' => $brands,
                'productWithAttr' => $productWithAttr
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function navBarCategory()
    {
        $categories = Category::get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }


    // getting user data 
    public function getUserData(Request $request)
    {
        $token = $request->token;
        $checkUser = TempUser::where('token', $token)->first();

        if (isset($checkUser->id)) {
            // token exist in DB 
            $data['user_type'] = $checkUser->user_type;
            $data['token'] = $checkUser->token;

            if (checkTokenExpiryInMinutes($checkUser->updated_at, 60)) {
                // token has expire
                $token = generateRandomString();
                $checkUser->token = $token;
                $checkUser->updated_at = date('Y-m-d h:i:s a', time());
                $checkUser->save();

                $data['token'] = $token;
                $data['tempUser'] = $checkUser;
            } else {
                // token not expire
            }
        } else {
            // token not exist in DB

            $user_id = rand(11111, 99999);
            $token = generateRandomString();
            $time = date('Y-m-d h:i:s a', time());
            $tempUser = TempUser::create([
                'user_id' => $user_id,
                'token' => $token,
                'created_at' => $time,
                'updated_at' => $time
            ]);

            $data['user_type'] = 2;
            $data['token'] = $token;
        }
        if (isset($tempUser)) {
            $data['tempUser'] = $tempUser;
        } else {
            $data['tempUser'] = $checkUser;
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * Get Cart Data
     */
    public function getCartData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $userToken = TempUser::where('token', $request->token)->first();
            $data = Cart::where('user_id', $userToken->user_id)->with('products')->get();
            return $this->success(['data' => $data], 'Successfully data fetched');
        }
    }





    /**
     * add to card data 
     */
    public function addToCart(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
            'product_id' => 'required|exists:products,id',
            'product_attr_id' => 'required|exists:product_attrs,id',
            'qty' => 'required|integer|min:1',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400);
        }

        $tempUser = TempUser::where('token', $request->token)->first();


        // Find existing item or create new instance
        $cart = Cart::firstOrNew([
            'user_id'         => $tempUser->user_id,
            'product_id'      => $request->product_id,
            'product_attr_id' => $request->product_attr_id
        ]);

        // Increment quantity instead of overwriting
        $cart->qty += $request->qty;
        $cart->user_type = $tempUser->user_type;
        $cart->save();
        return $this->success(['data' => ''], 'Add To Cart Success');
    }



    public function removeCartData(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
            'product_id' => 'required|exists:products,id',
            'product_attr_id' => 'required|exists:product_attrs,id',
            'qty'            => 'required|numeric|min:0|not_in:0',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = TempUser::where('token', $request->token)->first();
            $cart = Cart::where([
                'user_id' => $user->user_id,
                'product_id' => $request->product_id,
                'product_attr_id' => $request->product_attr_id
            ])->first();

            if (isset($cart->id)) {
                $qty = $request->qty;
                if ($cart->qty == $qty) {
                    $cart->delete();
                } elseif ($cart->qty > $qty) {
                    $cart->qty -= $qty;
                    $cart->save();
                } else {
                    $cart->delete();
                }
            }
            return $this->success(['data' => ''], 'Cart Data Removed Successfully');
        }
    }

    // get product data
    public function getProductData($id = '')
    {
        $product = Product::where('id', $id)->first();
        if (isset($product->id)) {
            $data = Product::where('id', $id)->with('productAttr.images')->first();
            $data['other_products'] = Product::where('category_id', $data->category_id)->where('id', '!=', $data->id)->with('productAttr.images')->get();

            return $this->success(['data' => $data], 'Successfully Product data fetched');
        } else {
            return $this->error('Product Not Found', 400, []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function addCoupon(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'couponName' => 'required|exists:coupons,name',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $coupon = Coupon::where('name', $request->couponName)->first();
            $user = TempUser::where('token', $request->token)->first();

            if ($coupon->minValue <= $request->cartTotal) {
                $couponValue = $coupon->value;
                if ($coupon->type == 1) {
                    // coupon id of value type
                    $cartTotal = $request->cartTotal - $couponValue;
                } else {
                    // coupon is of percentage type
                    $couponValue = $couponValue / 100;
                    $couponValue = $request->cartTotal * $couponValue;
                    $cartTotal = $request->cartTotal - $couponValue;
                }

                UserCouponCart::updateOrCreate(['user_id' => $user->user_id], [
                    'user_id' => $user->user_id,
                    'coupon_id' => $coupon->id
                ]);
                return $this->success(['data' => $cartTotal], 'Successfully coupon cart total fetched');
            } else {
                return $this->error('Coupon Not Found', 400, []);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeCoupon(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = TempUser::where('token', $request->token)->first();
            $couponUser = UserCouponCart::where('user_id', $user->user_id)->delete();
        }
        return $this->success([], 'Successfully data fetched');
    }

    public function getUserCoupon(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
        ]);
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = TempUser::where('token', $request->token)->first();
            $couponUser = UserCouponCart::where('user_id', $user->user_id)->first();
            $couponName = '';
            if (isset($couponUser->id)) {
                // User have coupon
                $coupon = Coupon::where('id', $couponUser->coupon_id)->first();
                $couponName = $coupon->name;
                if ($coupon->minValue <= $request->cartTotal) {
                    $couponValue = $coupon->value;
                    if ($coupon->type == 1) {
                        // coupon id of value type
                        $cartTotal = $request->cartTotal - $couponValue;
                    } else {
                        // coupon is of percentage type
                        $couponValue = $couponValue / 100;
                        $couponValue = $request->cartTotal * $couponValue;
                        $cartTotal = $request->cartTotal - $couponValue;
                    }
                } else {
                    $cartTotal = $request->cartTotal;
                }
            } else {
                // User don't have coupon
                $cartTotal = $request->cartTotal;
            }
            return $this->success(['cartTotal' => $cartTotal == 0 ? $cartTotal = $request->cartTotal : $cartTotal, 'couponName' => $couponName != '' ? $couponName : ''], 'Successfully data fetched');
        }
    }

    public function getPinCodeDetails(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
            'pinCode' => 'required|exists:pincodes,Pincode',
        ]);
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $data = Pincode::where('Pincode', $request->pinCode)->first();
            return $this->success(['data' => $data], 'Successfully data fetched');
        }
    }

    public function placeOrder(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
            'pinCode' => 'required|exists:pincodes,Pincode',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'required|numeric',
        ]);
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $tempUser = TempUser::where('token', $request->token)->first();
            $checkTempUserCart = Cart::where('user_id', $tempUser->user_id)->first();
            if (!$checkTempUserCart) {
                return $this->error('Cart is empty', 400, []);
            }

            //create user
            $user = $this->createUser($request->all());
            //save address
            $address_id = $this->saveAddress($request->all(), $user['id']);
            
            
            //save order
            $order = $this->saveOrder($request->all(), $user['id'], $address_id);
           
            $newData['order_id'] = $order['id'];
            $newData['token'] = $user['token'];
            $newData['paymentMethod'] = $request->paymentMethod ;
            if ($order['orderExist']) {
                $newData['order_id'] = $order['id'];
                $newData['token'] = $user['token'];

                // $newData['payment_type'] = $payment_type;
                // $newData['redirect_url'] = route('jazzcash.page', $order->id);
                return $this->success(['data' => $newData], 'Your order is already placed!');
            }
            if ($request->paymentMethod == 'cod') {

                $order->order_status = 'cod';
                $order->save();
                $checkTempUserCart->delete() ;
           } else if ($request->paymentMethod == 'online') {

                $gateway = GatewayFactory::make('online');

                $redirectUrl = $gateway->pay($order);

                $newData['redirect_url'] = $redirectUrl;
            }
            
            // $newData['payment_type'] = $payment_type;
            // $newData['redirect_url'] = route('payment.page', $order->id);
            return $this->success(['data' => $newData], 'Order is successfully Placed!');
        }
    }

    public function createUser($data)
    {

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['firstName'] . ' ' . $data['lastName'],
                'password' => Hash::make('' . $data['firstName'] . '@123'),
                'email' => $data['email']
            ]
        );

        $customer = Role::where('slug', 'customer')->first();
        $user['token'] = $user->createToken('API Token')->plainTextToken;
        $user->roles()->syncWithoutDetaching([$customer->id]);
        return $user;
    }

    public function saveAddress($data, $user_id)
    {
        $pinCode = Pincode::where('Pincode', $data['pinCode'])->first();

        $userAddress = UserAddress::UpdateOrCreate(
            [
                'user_id' => $user_id,
                'pincode' => $pinCode->Pincode,
                'city' =>  $pinCode->City,
                'state' => $pinCode->State,
            ],
            [
                'user_id' => $user_id,
                'pincode' => $pinCode->Pincode,
                'city' => $pinCode->City,
                'state' => $pinCode->State,
                'address' => $data['address'],
                'country' => $data['country'],
            ]
        );
        return $userAddress->id;
    }

    public function saveOrder($data, $user_id, $address_id)
    {
        $cart = $this->getOrderTotalValue($data);
        $existingOrder = UserOrder::where('user_id', $user_id)
            ->where('order_status', 'processing')
            ->where('total_value', $cart['cartTotal'])->first();
        if (isset($existingOrder)) {
            $order['orderExist'] = true;
            $order['id'] = $existingOrder->id;
            return $order;
        }
        $order = UserOrder::UpdateOrCreate([
            'user_id' => $user_id,
            'order_status' => 'pending',
        ], [
            'user_id' => $user_id,
            'address_id' => $address_id,
            'total_value' => $cart['cartTotal'],
            'coupon_value' => $cart['couponName'],
            'shipping_service' => 'Standard',
            'payment_method' => $data['paymentMethod'],
            'payment_status' => 'pending',
        ]);
        if ($data['paymentMethod'] == 'cod') {
            $order->update(['order_status' => 'processing']);
        }
        $orderDetails = $this->saveOrderDetails($data, $user_id, $order->id);
        return $order;
    }

    public function saveOrderDetails($data, $user_id, $order_id)
    {
        $user = TempUser::where('token', $data['token'])->first();
        $cart = Cart::where('user_id', $user->user_id)->get();
        $totalPrice = 0;
        foreach ($cart as $list) {
            $productAttr = ProductAttr::find($list->product_attr_id);
            $price = $productAttr->price * $list->qty;
            $totalPrice += $price;

            $orderDetails = UserOrderDetail::UpdateOrCreate(
                [
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'product_attr_id' => $list->product_attr_id,
                    'total_value' => $totalPrice,
                    'qty' => $list->qty
                ],
                [
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'product_attr_id' => $list->product_attr_id,
                    'total_value' => $totalPrice,
                    'qty' => $list->qty
                ]
            );
        }
        return;
    }

    public function getOrderTotalValue($data)
    {
        $couponName = '';
        $user = TempUser::where('token', $data['token'])->first();
        $couponUser = UserCouponCart::where('user_id', $user->user_id)->first();
        $totalCartValue = $this->totalCartValue($data);
        if (isset($couponUser->id)) {
            $coupon = Coupon::where('id', $couponUser->coupon_id)->first();
            $couponName = $coupon->name;
            if ($coupon->minValue <= $totalCartValue) {
                $couponValue = $coupon->value;
                if ($coupon->type == 1) {
                    // coupon id of value type
                    $cartTotal = $totalCartValue - $couponValue;
                } else {
                    // coupon is of percentage type
                    $couponValue = $couponValue / 100;
                    $couponValue = $totalCartValue * $couponValue;
                    $cartTotal = $totalCartValue - $couponValue;
                }
            } else {
                $cartTotal = $totalCartValue;
            }
        } else {
            // User don't have coupon
            $cartTotal = $totalCartValue;
        }
        $data['cartTotal'] = $cartTotal;
        $data['couponName'] = $couponName;
        return $data;
    }

    public function totalCartValue($data)
    {
        $user = TempUser::where('token', $data['token'])->first();
        $cart = Cart::where('user_id', $user->user_id)->get();
        $totalPrice = 0;
        foreach ($cart as $list) {
            $productAttr = ProductAttr::where('id', $list->product_attr_id)->first();
            $price = $productAttr->price * $list->qty;
            $totalPrice += $price;
        }
        return $totalPrice;
    }
}
