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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('default_profile_photo_id')->nullable();
            $table->timestamp('blocked')->nullable();
            $table->integer('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('phone_number')->unique()->nullable();
            $table->unsignedBigInteger('countries_id')->unsigned();
            $table->unsignedBigInteger('regions_id')->unsigned();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('gender_id','users_fk0')->on('genders')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('default_profile_photo_id','users_fk1')->on('default_profile_photos')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('countries_id','users_fk2')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('regions_id','users_fk3')->references('id')->on('regions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_fk0');
            $table->dropForeign('users_fk1');
            $table->dropForeign('users_fk2');
            $table->dropForeign('users_fk3');
        });
        Schema::dropIfExists('users');
    }
};
