<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_profile_photos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');
            $table->unsignedBigInteger('gender_id');
            $table->timestamps();

            $table->foreign('gender_id','default_profile_photos_fk0')->on('genders')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('default_profile_photos', function (Blueprint $table) {
            $table->dropForeign('default_profile_photos_fk0');
        });
        Schema::dropIfExists('default_profile_photos');
    }
};
