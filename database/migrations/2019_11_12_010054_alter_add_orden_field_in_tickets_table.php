<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddOrdenFieldInTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `tickets` 
        ADD COLUMN `orden` INT(15) NOT NULL DEFAULT 1 AFTER `fecha_consulta`");
        DB::statement("ALTER TABLE `tickets` 
                ADD COLUMN `agent_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `fecha_consulta`,
                ADD INDEX `fk_tickets_agent_id_foreign_idx` (`agent_id` ASC) VISIBLE");
        DB::statement("ALTER TABLE `tickets` 
                    ADD CONSTRAINT `fk_tickets_agent_id_foreign`
                      FOREIGN KEY (`agent_id`)
                      REFERENCES `users` (`id`)
                      ON DELETE RESTRICT
                      ON UPDATE NO ACTION");
    }
}
