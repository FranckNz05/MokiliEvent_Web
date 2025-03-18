<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convertir toutes les tables en InnoDB
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            DB::statement("ALTER TABLE `{$tableName}` ENGINE = InnoDB");
        }

        // Fonction helper pour supprimer une clé étrangère si elle existe
        $dropForeignIfExists = function ($table, $column) {
            if (!Schema::hasTable($table)) {
                return;
            }
            
            $foreignKey = "{$table}_{$column}_foreign";
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $sm->listTableForeignKeys($table);
            
            foreach ($foreignKeys as $key) {
                if ($key->getName() === $foreignKey) {
                    Schema::table($table, function (Blueprint $table) use ($column) {
                        $table->dropForeign([$column]);
                    });
                    break;
                }
            }
        };

        // Fonction helper pour ajouter une clé étrangère
        $addForeignKey = function ($table, $column, $references, $onDelete = 'cascade') {
            if (!Schema::hasTable($table)) {
                return;
            }
            
            Schema::table($table, function (Blueprint $table) use ($column, $references, $onDelete) {
                $table->foreign($column)->references('id')->on($references)->onDelete($onDelete);
            });
        };

        // Events
        if (Schema::hasTable('events')) {
            $dropForeignIfExists('events', 'user_id');
            $dropForeignIfExists('events', 'category_id');
            $addForeignKey('events', 'user_id', 'users');
            $addForeignKey('events', 'category_id', 'categories');
        }

        // Event Likes
        if (Schema::hasTable('event_likes')) {
            $dropForeignIfExists('event_likes', 'user_id');
            $dropForeignIfExists('event_likes', 'event_id');
            $addForeignKey('event_likes', 'user_id', 'users');
            $addForeignKey('event_likes', 'event_id', 'events');
        }

        // Event Comments
        if (Schema::hasTable('event_comments')) {
            $dropForeignIfExists('event_comments', 'user_id');
            $dropForeignIfExists('event_comments', 'event_id');
            $addForeignKey('event_comments', 'user_id', 'users');
            $addForeignKey('event_comments', 'event_id', 'events');
        }

        // Event Favorites
        if (Schema::hasTable('event_favorites')) {
            $dropForeignIfExists('event_favorites', 'user_id');
            $dropForeignIfExists('event_favorites', 'event_id');
            $addForeignKey('event_favorites', 'user_id', 'users');
            $addForeignKey('event_favorites', 'event_id', 'events');
        }

        // Billets
        if (Schema::hasTable('billets')) {
            $dropForeignIfExists('billets', 'user_id');
            $dropForeignIfExists('billets', 'event_id');
            $addForeignKey('billets', 'user_id', 'users');
            $addForeignKey('billets', 'event_id', 'events');
        }

        // Orders
        if (Schema::hasTable('orders')) {
            $dropForeignIfExists('orders', 'user_id');
            $dropForeignIfExists('orders', 'event_id');
            $addForeignKey('orders', 'user_id', 'users');
            $addForeignKey('orders', 'event_id', 'events');
        }

        // Order Items
        if (Schema::hasTable('order_items')) {
            $dropForeignIfExists('order_items', 'order_id');
            $dropForeignIfExists('order_items', 'ticket_id');
            $addForeignKey('order_items', 'order_id', 'orders');
            $addForeignKey('order_items', 'ticket_id', 'billets');
        }

        // Event Views
        if (Schema::hasTable('event_views')) {
            $dropForeignIfExists('event_views', 'event_id');
            $dropForeignIfExists('event_views', 'user_id');
            $addForeignKey('event_views', 'event_id', 'events');
            $addForeignKey('event_views', 'user_id', 'users', 'set null');
        }
    }

    public function down(): void
    {
        // Dans le down(), nous ne faisons rien car nous ne voulons pas revenir en arrière
        // avec les clés étrangères ou le moteur de base de données
    }
};
