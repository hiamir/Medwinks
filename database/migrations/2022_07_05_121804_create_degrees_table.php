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
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qualification_id');
            $table->string('name',45);
            $table->string('acronym')->nullable();
            $table->integer('position');
            $table->timestamps();

//         FOREIGN KEYS
            $table->foreign('qualification_id','degrees_fk0')->on('qualifications')->references('id')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('degrees', function (Blueprint $table) {
            $table->dropForeign('degrees_fk0');
        });
        Schema::dropIfExists('degrees');
    }
};
