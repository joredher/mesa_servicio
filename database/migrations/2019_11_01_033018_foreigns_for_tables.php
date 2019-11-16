<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignsForTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `tickets` 
                    CHANGE COLUMN `user_id` `user_id` INT(10) UNSIGNED NOT NULL ,
                    CHANGE COLUMN `priorite_id` `priorite_id` INT(10) UNSIGNED NOT NULL ,
                    CHANGE COLUMN `categorie_id` `categorie_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
                    ADD INDEX `fk_tickets_user_id_foreign_idx` (`user_id` ASC),
                    ADD INDEX `fk_tickets_priorite_id_foreign_idx` (`priorite_id` ASC),
                    ADD INDEX `fk_tickets_categorie_id_foreign_idx` (`categorie_id` ASC)");

        DB::statement("ALTER TABLE `tickets` 
                        ADD CONSTRAINT `fk_tickets_user_id_foreign`
                          FOREIGN KEY (`user_id`)
                          REFERENCES `users` (`id`)
                          ON DELETE RESTRICT
                          ON UPDATE NO ACTION,
                        ADD CONSTRAINT `fk_tickets_priorite_id_foreign`
                          FOREIGN KEY (`priorite_id`)
                          REFERENCES `priorites` (`id`)
                          ON DELETE RESTRICT
                          ON UPDATE NO ACTION,
                        ADD CONSTRAINT `fk_tickets_categorie_id_foreign`
                          FOREIGN KEY (`categorie_id`)
                          REFERENCES `categories` (`id`)
                          ON DELETE RESTRICT
                          ON UPDATE NO ACTION");

        // Trait
        DB::statement("ALTER TABLE `traitements` 
                    CHANGE COLUMN `ticket_id` `ticket_id` INT(10) UNSIGNED NOT NULL ,
                    CHANGE COLUMN `user_id` `user_id` INT(10) UNSIGNED NOT NULL ,
                    ADD INDEX `fk_traitements_user_id_foreign_idx` (`user_id` ASC),
                    ADD INDEX `fk_traitements_ticket_id_foreign_idx` (`ticket_id` ASC)");
        DB::statement("ALTER TABLE `traitements` 
                        ADD CONSTRAINT `fk_traitements_user_id_foreign`
                          FOREIGN KEY (`user_id`)
                          REFERENCES `users` (`id`)
                          ON DELETE RESTRICT
                          ON UPDATE NO ACTION,
                        ADD CONSTRAINT `fk_traitements_ticket_id_foreign`
                          FOREIGN KEY (`ticket_id`)
                          REFERENCES `tickets` (`id`)
                          ON DELETE RESTRICT
                          ON UPDATE NO ACTION");
    }
}
