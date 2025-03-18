<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('email_verified_at');
            }
            if (!Schema::hasColumn('users', 'profil_image')) {
                $table->string('profil_image')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'is_profile_complete')) {
                $table->boolean('is_profile_complete')->default(false)->after('profil_image');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio', 'profil_image', 'is_profile_complete']);
        });
    }
};
