<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sarees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            
            // Saree Specific Details
            $table->string('fabric');
            $table->decimal('length', 8, 2)->default(6.3);
            $table->decimal('blouse_length', 8, 2)->default(0.8);
            $table->string('work_type')->nullable();
            $table->string('occasion')->nullable();
            $table->string('pattern')->nullable();
            $table->boolean('blouse_included')->default(false);
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Collection
            $table->unsignedBigInteger('collection_id')->nullable();
            
            // Images
            $table->string('featured_image')->nullable();
            
            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_active')->default(true);
            
            // Meta
            $table->json('colors')->nullable();
            $table->json('care_instructions')->nullable();
            $table->integer('views')->default(0);
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            
            $table->timestamps();
            
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sarees');
    }
};