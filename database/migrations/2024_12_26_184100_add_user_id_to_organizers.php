<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizers', function (Blueprint $table) {
            // Ajouter la colonne user_id si elle n'existe pas déjà
            if (!Schema::hasColumn('organizers', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('organizers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
