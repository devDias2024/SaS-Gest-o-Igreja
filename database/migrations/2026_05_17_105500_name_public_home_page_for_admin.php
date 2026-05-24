<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_pages')
            ->where('slug', 'home')
            ->update([
                'title' => 'Pagina inicial do site',
            ]);
    }

    public function down(): void
    {
        //
    }
};
