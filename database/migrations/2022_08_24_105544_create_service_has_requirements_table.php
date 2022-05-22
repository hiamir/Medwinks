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
        Schema::create('service_has_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->unsigned();
            $table->unsignedBigInteger('service_requirement_id')->unsigned();

            //FK
            $table->foreign('service_id','service_has_requirements_fk0')->references('id')->on('services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_requirement_id','service_has_requirements_fk1')->references('id')->on('service_requirements')->onUpdate('cascade')->onDelete('cascade');


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
            $table->dropForeign('service_has_requirements_fk0');
            $table->dropForeign('service_has_requirements_fk1');
        });

        Schema::dropIfExists('service_has_requirements');
    }
};
