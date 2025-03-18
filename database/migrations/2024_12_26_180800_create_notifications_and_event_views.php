<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Créer la table pour le traçage des vues d'événements
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

        // 2. Migrer les données de views_count si la colonne existe
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

            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('views_count');
            });
        }

        // 3. Créer la table notifications
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
        // 1. Restaurer views_count dans events
        if (!Schema::hasColumn('events', 'views_count')) {
            Schema::table('events', function (Blueprint $table) {
                $table->integer('views_count')->default(0);
            });

            // Migrer les données de event_views vers views_count
            if (Schema::hasTable('event_views')) {
                $events = DB::table('events')->get();
                foreach ($events as $event) {
                    $viewCount = DB::table('event_views')->where('event_id', $event->id)->count();
                    DB::table('events')
                        ->where('id', $event->id)
                        ->update(['views_count' => $viewCount]);
                }
            }
        }

        // 2. Supprimer les nouvelles tables
        Schema::dropIfExists('event_views');
        Schema::dropIfExists('notifications');
    }
};
