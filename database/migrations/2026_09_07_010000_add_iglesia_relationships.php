<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('iglesia_id')
                ->nullable()
                ->after('rol')
                ->constrained('iglesias')
                ->nullOnDelete();
        });

        Schema::table('iglesias', function (Blueprint $table) {
            $table->foreignId('pastor_id')
                ->nullable()
                ->after('responsable')
                ->constrained('users')
                ->nullOnDelete();
        });

        DB::table('iglesias')->orderBy('id')->each(function (object $iglesia): void {
            $pastorId = DB::table('iglesia_pastor')
                ->join('users', 'users.id', '=', 'iglesia_pastor.pastor_id')
                ->where('iglesia_pastor.iglesia_id', $iglesia->id)
                ->where('users.rol', 'pastor')
                ->value('users.id');

            if ($pastorId) {
                DB::table('iglesias')
                    ->where('id', $iglesia->id)
                    ->update(['pastor_id' => $pastorId]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pastor_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('iglesia_id');
        });
    }
};