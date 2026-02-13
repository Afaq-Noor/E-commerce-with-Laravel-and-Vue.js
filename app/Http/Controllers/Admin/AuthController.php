<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public function createCustomer()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('1234');
        if (User::where('email', 'admin@gmail.com')->exists()) {
            return response()->json(['message' => 'Admin user already exists']);
        }

        $user->save();

        $admin = Role::where('slug', 'admin')->first();
        $user->roles()->attach($admin);
    }


    public function destroy(string $id, string $table)
    {
        try {
            $allowedTables = ['users', 'roles', 'products', 'categories'];

            if (!in_array($table, $allowedTables)) {
                return $this->error('Invalid table name.', 400, []);
            }

            if (!Schema::hasTable($table)) {
                return $this->error('Invalid table name.', 400, []);
            }

            $deleted = DB::table($table)->where('id', $id)->delete();

            if ($deleted) {
                return $this->success(['reload' => true], 'Record deleted successfully.');
            } else {
                return $this->error('Record not found or already deleted.', 404, []);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500, []);
        }
    }
}
