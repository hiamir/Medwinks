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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->string('name',45);
            $table->unsignedBigInteger('timezone_id');
            $table->timestamps();

//            FOREIGN KEYS
            $table->foreign('country_id','regions_fk0')->on('countries')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('timezone_id','regions_fk1')->on('timezones')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign('regions_fk0');
            $table->dropForeign('regions_fk1');
        });
        Schema::dropIfExists('regions');
    }
};
