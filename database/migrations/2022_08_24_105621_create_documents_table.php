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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('service_requirement_id')->unsigned();
            $table->text('notes');
            $table->string('file');
            $table->boolean('accepted')->default(false);
            $table->boolean('rejected')->default(false);
            $table->boolean('revision')->default(false);
            $table->boolean('seen')->default(false);
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('user_id','documents_fk0')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_requirement_id','documents_fk1')->references('id')->on('service_requirements')->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign('documents_fk0');
            $table->dropForeign('documents_fk1');
        });
        Schema::dropIfExists('documents');
    }
};
