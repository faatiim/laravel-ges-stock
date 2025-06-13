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
        Schema::create('lignes_de_ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vente_id')->constrained('ventes')->onDelete('cascade');
            $table->foreignId('outil_id')->constrained('outils')->onDelete('cascade');
            //php artisan make:migration alter_quantite_to_decimal_in_lignes_de_ventes --table=lignes_de_ventes
            $table->decimal('quantite', 10, 2);
            // $table->enum('mode_vente', ['physique', 'logique'])->default('physique');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('total', 10, 2);
                        $table->enum('mode_vente', ['physique','logique'])
                ->default('physique')
                ->after('quantite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lignes_de_ventes');
    }
};
