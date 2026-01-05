<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saree_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saree_id');
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('saree_id')->references('id')->on('sarees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saree_images');
    }
};