<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'prenom')) {
                $table->string('prenom')->after('id')->nullable();
            }
            if (!Schema::hasColumn('users', 'nom')) {
                $table->string('nom')->after('prenom')->nullable();
            }
        });

        // Copier les données de name vers prenom s'il existe
        if (Schema::hasColumn('users', 'name')) {
            DB::statement('UPDATE users SET prenom = name WHERE prenom IS NULL');
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        // Rendre les champs obligatoires
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->nullable(false)->change();
            $table->string('nom')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id')->nullable();
            DB::statement('UPDATE users SET name = prenom');
            
            $table->dropColumn(['prenom', 'nom']);
            
            $table->string('name')->nullable(false)->change();
        });
    }
};
