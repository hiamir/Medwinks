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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('passports_id')->unsigned();
            $table->unsignedBigInteger('universities_id')->unsigned();
            $table->unsignedBigInteger('degrees_id')->unsigned();
            $table->unsignedBigInteger('services_id')->unsigned();
            $table->unsignedBigInteger('users_id')->unsigned();
            $table->boolean('accepted')->default(false);
            $table->boolean('rejected')->default(false);
            $table->boolean('revision')->default(false);
            $table->boolean('seen')->default(false);
            $table->timestamps();

            //FK
            $table->foreign('passports_id','applications_fk0')->references('id')->on('passports')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('universities_id','applications_fk1')->references('id')->on('universities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('degrees_id','applications_fk2')->references('id')->on('degrees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('services_id','applications_fk3')->references('id')->on('services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('users_id','applications_fk4')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->dropForeign('applications_fk0');
            $table->dropForeign('applications_fk1');
            $table->dropForeign('applications_fk2');
            $table->dropForeign('applications_fk3');
            $table->dropForeign('applications_fk4');
        });
        Schema::dropIfExists('applications');
    }
};


