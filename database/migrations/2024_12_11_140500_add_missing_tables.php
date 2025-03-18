<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table blog_tag si elle n'existe pas
        if (!Schema::hasTable('blog_tag')) {
            Schema::create('blog_tag', function (Blueprint $table) {
                $table->foreignId('blog_id')->constrained()->cascadeOnDelete();
                $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
                $table->primary(['blog_id', 'tag_id']);
            });
        }

        // Table views si elle n'existe pas
        if (!Schema::hasTable('views')) {
            Schema::create('views', function (Blueprint $table) {
                $table->id();
                $table->morphs('viewable');
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }

        // Table error_logs si elle n'existe pas
        if (!Schema::hasTable('error_logs')) {
            Schema::create('error_logs', function (Blueprint $table) {
                $table->id();
                $table->string('level');
                $table->string('message');
                $table->text('context')->nullable();
                $table->text('stack_trace')->nullable();
                $table->string('file')->nullable();
                $table->integer('line')->nullable();
                $table->timestamps();
            });
        }

        // Table statistics si elle n'existe pas
        if (!Schema::hasTable('statistics')) {
            Schema::create('statistics', function (Blueprint $table) {
                $table->id();
                $table->string('key');
                $table->string('value');
                $table->timestamp('date');
                $table->timestamps();
            });
        }

        // Table payment_logs si elle n'existe pas
        if (!Schema::hasTable('payment_logs')) {
            Schema::create('payment_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->string('transaction_id');
                $table->decimal('amount', 10, 2);
                $table->string('currency', 3);
                $table->string('payment_method');
                $table->string('status');
                $table->json('response_data')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('payment_logs');
        Schema::dropIfExists('statistics');
        Schema::dropIfExists('error_logs');
        Schema::dropIfExists('views');
        Schema::dropIfExists('blog_tag');
    }
};
