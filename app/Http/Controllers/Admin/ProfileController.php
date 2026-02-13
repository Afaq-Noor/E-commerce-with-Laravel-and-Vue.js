<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator ;
use App\Traits\ApiResponse;
class ProfileController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.profile') ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255' , 
            'email' => 'required|string|email|unique:users,email,' .  Auth::User()->id ,
            // 'password' => 'required|string|min:4|confirmed' , 
            'image' => 'mimes:jpeg,png,jpg,gif|max:5120' , 
            'address' => 'required|string|max:255' ,
            'twitter_link' => 'string|max:255' ,
            'fb_link' => 'string|max:255' ,
            'insta_link' => 'string|max:255' ,
            'phone' => 'string' ,
       ]) ;

       if($validate->fails()) {
          return $this->error($validate->errors()->first(),400,[]) ;
       } else {
           if($request->hasFile('image')) {
             // Get the current user's image path
           $oldImage = auth()->user()->image;

           // 🧹 Delete old image if it exists and file is found
           if (file_exists(public_path($oldImage))) {
             unlink(public_path($oldImage));
           }
               $image_name = 'image/' . $request->name.time() . '.' . $request->image->extension() ;
               $request->image->move(public_path('image/'), $image_name) ;
           } else {
            $image_name = auth()->user()->image ;
           }
           $user = User::updateOrCreate(
            [ 'id' => auth()->user()->id ] , 
            [ 
                'name' => $request->name ,
                'email' => $request->email ,
                'address' => $request->address ,
                'twitter_link' => $request->twitter_link ,
                'fb_link' => $request->fb_link ,
                'insta_link' => $request->insta_link ,
                'image' => $image_name ,
                'phone' => $request->phone ,
             ]
            );
            // return response()->json([ 'status' => 200 , 'message' => 'Successfully updated']) ;
            return $this->success([], 'Successfully updated') ;
            
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
