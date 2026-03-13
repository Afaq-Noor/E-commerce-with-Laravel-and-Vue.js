<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('user_orders', function(Blueprint $table) {
             //COD or JAZZCASH
             $table->string('payment_method')->default('cod')->after('coupon_value') ;
             
             //pending | paid | failed 
             $table->string('payment_status')->default('pending')->after('payment_method') ;
             
             $table->string('order_status')->default('pending')->after('payment_status') ;
             
             $table->decimal('amount',10,2)->default('0')->after('order_status') ;
             //gateway transaction reference
             $table->string('transaction_id')->nullable()->after('amount') ;
         }) ;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_orders', function (Blueprint $table) {
            $table->dropColumn([
                'paymentMethod',
                'payment_status',
                'transaction_id',
                'order_status',
            ]);
        });
    }
};
