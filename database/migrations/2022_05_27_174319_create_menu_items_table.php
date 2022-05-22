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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('svg')->nullable();
            $table->string('guard');
            $table->string('route')->unique();
            $table->integer('sort');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('permissions_id');
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('menu_id','menu_items_fk0')->on('menus')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('permissions_id','menu_items_fk1')->on('permissions')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign('menu_links_fk0');
            $table->dropForeign('menu_links_fk1');
        });
        Schema::dropIfExists('menu_items');
    }
};
