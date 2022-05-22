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
        Schema::create('admins', function (Blueprint $table) {
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
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('gender_id','admins_fk0')->on('genders')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('default_profile_photo_id','admins_fk1')->on('default_profile_photos')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign('admins_fk0');
            $table->dropForeign('admins_fk1');
        });
        Schema::dropIfExists('admins');
    }
};
