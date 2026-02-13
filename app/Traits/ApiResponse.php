<?php
 
namespace App\Traits;
 
use Carbon\Carbon;
 
/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/
 
trait ApiResponse
{

    protected function success($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'data' => $data ,
            'message' => $message,
            'status' => 'success',
        ], $code);
    }
 
  
    protected function error( string $message = null , int $code, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
 
}
