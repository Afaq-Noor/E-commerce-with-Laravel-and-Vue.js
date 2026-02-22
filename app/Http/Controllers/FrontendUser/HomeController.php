<?php

namespace App\Http\Controllers\FrontendUser;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\TempUser;
use Validator;
use App\Traits\ApiResponse;

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

                $data['token'] = $token ;
            } else {
                // token not expire
            }
        } else {
            // token not exist in DB

            $user_id = rand( 11111 , 99999 ) ;
            $token = generateRandomString() ;
            $time = date('Y-m-d h:i:s a', time()) ;
            TempUser::create([
                'user_id' => $user_id , 
                'token' => $token, 
                'created_at' => $time , 
                'updated_at' => $time ]) ;
            
            $data['user_type'] = 2 ;
            $data['token'] = $token ;
        }

         return response()->json([
            'success' => true,
             'status' => 200 ,
            'data' => $data 
        ]);
    }

    /**
     * Get Cart Data
     */
    public function getCartData(Request $request)
    {
          $validation = Validator::make($request->all(), [
             'token' => 'required|exists:temp_users,token' ,
          ]) ;

          if($validation->fails())
          {
             return $this->error($validation->errors()->first(), 400, []) ;
          } else {  
            $userToken = TempUser::where('token' , $request->token)->first() ;
            $data = Cart::where('user_id' , $userToken->user_id )->with('products')->get() ;
            return $this->success(['data' => $data] , 'Successfully data fetched') ;
          }
    }





    /**
     * add to card data 
     */
      public function addToCart(Request $request)
    {

          $validation = Validator::make($request->all(), [
             'token' => 'required|exists:temp_users,token' ,
             'product_id' => 'required|exists:products,id' ,
             'product_attr_id' => 'required|exists:product_attrs,id' ,
             'qty'            => 'required|numeric|min:0|not_in:0' ,
          ]) ;

          if($validation->fails())
          {
             return $this->error($validation->errors()->first(), 400, []) ;
          } else {
            $user = TempUser::where('token' , $request->token)->first() ;
            Cart::updateOrCreate(['user_id' => $user->user_id, 'product_id' => $request->product_id, 
            'product_attr_id'=>$request->product_attr_id] , ['user_id' => $user->user_id, 
            'product_id' => $request->product_id, 
            'product_attr_id'=>$request->product_attr_id , 'qty'=>$request->qty,
            'user_type'=> $user->user_type]) ;
            return $this->success(['data' => ''] , 'Add To Cart Success') ;
          }
    }



      public function removeCartData(Request $request)
    {

          $validation = Validator::make($request->all(), [
             'token' => 'required|exists:temp_users,token' ,
             'product_id' => 'required|exists:products,id' ,
             'product_attr_id' => 'required|exists:product_attrs,id' ,
             'qty'            => 'required|numeric|min:0|not_in:0' ,
          ]) ;

          if($validation->fails())
          {
             return $this->error($validation->errors()->first(), 400, []) ;
          } else {
            $user = TempUser::where('token' , $request->token)->first() ;
            $cart = Cart::where(['user_id' => $user->user_id, 'product_id' => $request->product_id, 
            'product_attr_id'=>$request->product_attr_id])->first() ;

            if(isset($cart->id)) {
                $qty = $request->qty ;
                if($cart->qty == $qty) {
                    $cart->delete() ;
                } elseif($cart->qty > $qty) {
                    $cart->qty -= $qty ;
                    $cart->save() ;
                } else {
                    $cart->delete() ;
                }
            }
            return $this->success(['data' => ''] , 'Cart Data Removed Successfully') ;
          }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
