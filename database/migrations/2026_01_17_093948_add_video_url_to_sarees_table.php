<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sarees', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('featured_image');
        });
    }

    public function down()
    {
        Schema::table('sarees', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }
};