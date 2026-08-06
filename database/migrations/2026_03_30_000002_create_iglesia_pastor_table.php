<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iglesia_pastor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iglesia_id')->constrained('iglesias')->cascadeOnDelete();
            $table->foreignId('pastor_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['iglesia_id', 'pastor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iglesia_pastor');
    }
};

