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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('brand_id')->nullable();

            $table->double('old_price')->default(0);
            $table->double('price')->default(0);
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
            $table->string('additional_information')->nullable();
            $table->string('shipping_returns')->nullable();
            $table->tinyinteger('status')->default(0)->comment('0:active,1:inactive');
            $table->tinyinteger('is_delete')->default(0)->comment('0:not,1:deleted');
            $table->integer('created_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
