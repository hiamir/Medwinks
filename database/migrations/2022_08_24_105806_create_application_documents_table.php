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
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id')->unsigned();
            $table->unsignedBigInteger('document_id')->unsigned();

            //FK
            $table->foreign('application_id','application_documents_fk0')->references('id')->on('applications')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('document_id','application_documents_fk1')->references('id')->on('documents')->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign('application_documents_fk0');
            $table->dropForeign('application_documents_fk1');
        });
        Schema::dropIfExists('application_documents');
    }
};
