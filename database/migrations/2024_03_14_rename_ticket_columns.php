<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Renommer evenement_id en event_id
            if (Schema::hasColumn('tickets', 'evenement_id')) {
                $table->renameColumn('evenement_id', 'event_id');
            }

            // Renommer quantité en quantite
            if (Schema::hasColumn('tickets', 'quantité')) {
                $table->renameColumn('quantité', 'quantite');
            }
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'event_id')) {
                $table->renameColumn('event_id', 'evenement_id');
            }

            if (Schema::hasColumn('tickets', 'quantite')) {
                $table->renameColumn('quantite', 'quantité');
            }
        });
    }
};
