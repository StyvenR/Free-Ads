<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrer les images existantes
        $annonces = DB::table('annonces')->whereNotNull('image')->get();
        
        foreach ($annonces as $annonce) {
            DB::table('annonce_images')->insert([
                'annonce_id' => $annonce->id,
                'path' => $annonce->image,
                'is_primary' => true,
                'position' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};