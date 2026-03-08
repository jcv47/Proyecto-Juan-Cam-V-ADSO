<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Agrega columna nullable (SIN unique todavía)
        Schema::table('submissions', function (Blueprint $table) {
            $table->uuid('public_id')->nullable()->after('id');
        });

        // 2) Backfill a registros existentes
        DB::table('submissions')
            ->whereNull('public_id')
            ->orWhere('public_id', '')
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('submissions')
                        ->where('id', $row->id)
                        ->update(['public_id' => (string) Str::uuid()]);
                }
            });

        // 3) Ahora sí: unique + not null
        Schema::table('submissions', function (Blueprint $table) {
            $table->uuid('public_id')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropUnique(['public_id']);
            $table->dropColumn('public_id');
        });
    }
};