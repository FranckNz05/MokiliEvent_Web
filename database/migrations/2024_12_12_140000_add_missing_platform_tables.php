<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table blog_tag
        if (!Schema::hasTable('blog_tag')) {
            Schema::create('blog_tag', function (Blueprint $table) {
                $table->foreignId('blog_id')->constrained()->cascadeOnDelete();
                $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
                $table->primary(['blog_id', 'tag_id']);
            });
        }

        // Table tags
        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Table blogs
        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('content');
                $table->string('image')->nullable();
                $table->foreignId('user_id')->constrained();
                $table->foreignId('category_id')->nullable()->constrained();
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Table views
        if (!Schema::hasTable('views')) {
            Schema::create('views', function (Blueprint $table) {
                $table->id();
                $table->morphs('viewable');
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }

        // Table likes
        if (!Schema::hasTable('likes')) {
            Schema::create('likes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->morphs('likeable');
                $table->timestamps();
                $table->unique(['user_id', 'likeable_id', 'likeable_type']);
            });
        }

        // Table comments
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->morphs('commentable');
                $table->text('content');
                $table->boolean('is_approved')->default(false);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Table payment_logs
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

        // Table error_logs
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

        // Table statistics
        if (!Schema::hasTable('statistics')) {
            Schema::create('statistics', function (Blueprint $table) {
                $table->id();
                $table->string('key');
                $table->string('value');
                $table->timestamp('date');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('statistics');
        Schema::dropIfExists('error_logs');
        Schema::dropIfExists('payment_logs');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('views');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_tag');
        Schema::dropIfExists('tags');
    }
};
