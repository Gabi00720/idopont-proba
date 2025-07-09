<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->json('license_plates');
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->json('people');
            $table->string('location');
            $table->enum('status', ['Elutasítva', 'Feldolgozás', 'Elfogadva'])->default('Feldolgozás');

            $table->text('comment')->nullable();
            $table->string('document_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
