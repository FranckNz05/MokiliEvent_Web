<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Corriger le problème de double stockage des images de profil
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
        });

        // 2. Créer une table pour le traçage des vues d'événements
        if (!Schema::hasTable('event_views')) {
            Schema::create('event_views', function (Blueprint $table) {
                $table->id();
                $table->foreignId('event_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();

                // Index pour optimiser les requêtes
                $table->index(['event_id', 'user_id', 'ip_address']);
                $table->index('created_at');
            });
        }

        // Migrer les données de views_count vers la nouvelle table si la colonne existe
        if (Schema::hasColumn('events', 'views_count')) {
            $events = DB::table('events')->whereNotNull('views_count')->get();
            foreach ($events as $event) {
                for ($i = 0; $i < $event->views_count; $i++) {
                    DB::table('event_views')->insert([
                        'event_id' => $event->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Supprimer la colonne views_count
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('views_count');
            });
        }

        // 3. Renommer buyer_id en user_id dans la table billets si la colonne existe
        if (Schema::hasColumn('billets', 'buyer_id')) {
            Schema::table('billets', function (Blueprint $table) {
                $table->renameColumn('buyer_id', 'user_id');
            });
        }

        // 4. Créer la table notifications si elle n'existe pas
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // 1. Restaurer avatar dans users s'il n'existe pas
        if (!Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar')->nullable();
            });
        }

        // 2. Restaurer views_count dans events s'il n'existe pas
        if (!Schema::hasColumn('events', 'views_count')) {
            Schema::table('events', function (Blueprint $table) {
                $table->integer('views_count')->default(0);
            });

            // Migrer les données de event_views vers views_count
            $events = DB::table('events')->get();
            foreach ($events as $event) {
                $viewCount = DB::table('event_views')->where('event_id', $event->id)->count();
                DB::table('events')
                    ->where('id', $event->id)
                    ->update(['views_count' => $viewCount]);
            }
        }

        // Supprimer la table event_views si elle existe
        Schema::dropIfExists('event_views');

        // 3. Renommer user_id en buyer_id dans la table billets si la colonne existe
        if (Schema::hasColumn('billets', 'user_id')) {
            Schema::table('billets', function (Blueprint $table) {
                $table->renameColumn('user_id', 'buyer_id');
            });
        }

        // 4. Supprimer la table notifications
        Schema::dropIfExists('notifications');
    }
};
