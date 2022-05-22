<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('passport_number');
            $table->string('given_name');
            $table->string('sur_name');
            $table->date('date_of_birth');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->unsignedBigInteger('countries_id')->unsigned();
            $table->unsignedBigInteger('regions_id')->unsigned();
            $table->boolean('active')->default(false);
            $table->string('file');
            $table->boolean('accepted')->default(false);
            $table->boolean('rejected')->default(false);
            $table->boolean('revision')->default(false);
            $table->boolean('seen')->default(false);

            //FOREIGN KEYS
            $table->foreign('user_id','passports_fk0')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('countries_id','passports_fk1')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('regions_id','passports_fk2')->references('id')->on('regions')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passports', function (Blueprint $table) {
            $table->dropForeign('passports_fk0');
            $table->dropForeign('passports_fk1');
            $table->dropForeign('passports_fk2');
        });
        Schema::dropIfExists('passports');
    }
}
