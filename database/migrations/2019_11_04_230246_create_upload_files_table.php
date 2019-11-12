<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_file');
            $table->string('path');
            $table->unsignedInteger('ticket_id')->nullable();
            $table->unsignedInteger('traitement_id')->nullable();
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('restrict');
            $table->foreign('traitement_id')->references('id')->on('traitements')->onDelete('restrict');
        });

        DB::statement("ALTER TABLE `tickets` 
                        ADD COLUMN `fecha_consulta` DATETIME NULL DEFAULT NULL AFTER `categorie_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_files');
    }
}
