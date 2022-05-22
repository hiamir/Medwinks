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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name',45)->unique();
            $table->string('continent',45);
            $table->string('currency_code',45);
            $table->string('currency_name',45);
            $table->string('phone_prefix',45);
            $table->string('postal_code',45);
            $table->string('languages',45);
            $table->string('iso',45)->unique();
            $table->string('iso3',45)->unique();
            $table->string('fips',45);
            $table->string('geonameid',45)->unique();
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
        Schema::dropIfExists('countries');
    }
};
