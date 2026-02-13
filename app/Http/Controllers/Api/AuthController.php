<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors()->first(), 400, []);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Attach default role (customer)
        $customerRole = Role::where('slug', 'customer')->first();
        if ($customerRole) {
            $user->roles()->attach($customerRole->id);
        }

        // Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'user' => $user->load('roles'), // include role info in response
            'token' => $token,
        ], 'User Registered successfully');
    }

    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors()->first(), 400, []);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->error('Invalid credentials.', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success([
            'user' => $user,
            'token' => $token,
        ], 'User logged in successfully');
    }

    /**
     * Logout user (Revoke current token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'User logged out successfully.');
    }

    /**
     * Get current authenticated user
     */
    public function user(Request $request)
    {
        return $this->success($request->user(), 'User details fetched successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validate = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors()->first(), 400, []);
        }

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if($request->filled('password')) {
            $user->password = Hash::make($request->password) ;
           
        }
        
        $user->save() ;


        return $this->success($user, 'User updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user() ;

        $user->tokens()->delete() ;

        $user->delete() ;

        return $this->success(null, 'User account deleted successfully.');
    }


}
