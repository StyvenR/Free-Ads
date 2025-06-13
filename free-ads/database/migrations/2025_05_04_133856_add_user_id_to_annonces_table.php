<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            // Autoriser NULL temporairement
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Assigner un utilisateur par défaut à toutes les annonces existantes
        // Par exemple, l'ID du premier utilisateur
        if (DB::table('users')->count() > 0) {
            $defaultUserId = DB::table('users')->first()->id;
            DB::table('annonces')->whereNull('user_id')->update(['user_id' => $defaultUserId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
