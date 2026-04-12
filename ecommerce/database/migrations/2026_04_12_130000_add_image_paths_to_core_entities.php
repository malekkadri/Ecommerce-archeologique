<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagePathsToCoreEntities extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
        });

        Schema::table('workshops', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('type');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
}
