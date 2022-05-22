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
        Schema::create('application_has_additional_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id')->unsigned();
            $table->unsignedBigInteger('service_requirement_id')->unsigned();

            //FK
            $table->foreign('application_id','application_has_additional_requirements_fk0')->references('id')->on('applications')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_requirement_id','application_has_additional_requirements_fk1')->references('id')->on('service_requirements')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('application_has_additional_requirements', function (Blueprint $table) {
            $table->dropForeign('application_has_additional_requirements_fk0');
            $table->dropForeign('application_has_additional_requirements_fk1');
        });
        Schema::dropIfExists('application_has_additional_requirements');
    }
};
