<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panel_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->json('permissions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('panel_role_id')->nullable()->after('password')->constrained('panel_roles')->nullOnDelete();
            $table->boolean('is_super_admin')->default(false)->after('panel_role_id');
            $table->boolean('can_access_panel')->default(true)->after('is_super_admin');
        });

        DB::table('users')->update(['is_super_admin' => true, 'can_access_panel' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('panel_role_id');
            $table->dropColumn(['is_super_admin', 'can_access_panel']);
        });

        Schema::dropIfExists('panel_roles');
    }
};
