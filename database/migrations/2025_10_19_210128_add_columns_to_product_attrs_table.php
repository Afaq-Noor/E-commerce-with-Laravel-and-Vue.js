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
        Schema::table('product_attrs', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_value_id')->nullable()->after('size_id');
            $table->string('status')->default('1')->after('attribute_value_id');

            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_attrs', function (Blueprint $table) {
            //
            // First drop the foreign key before dropping the column
            $table->dropForeign(['attribute_value_id']);
            $table->dropColumn(['attribute_value_id', 'status']);
        });
    }
};
