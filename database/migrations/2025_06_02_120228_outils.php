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
        Schema::create('outils', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('etat')->default('neuf');
            $table->string('reference')->unique();
            $table->text('description')->nullable();
            $table->boolean('isActive')->default(true);
            // $table->boolean('isSharable')->default(false);
            $table->decimal('prix_unitaire', 10, 2)->default(0);
            $table->decimal('prix_achat', 10, 2)->nullable();
            $table->decimal('prix_gros', 10, 2)->default(0)->after('prix_unitaire');
            $table->decimal('stock_initial', 10, 2)->default(0);
            $table->decimal('stock_actuel', 10, 2)->default(0);
            $table->decimal('seuil_alerte', 10, 2)->default(5);
            // $table->boolean('est_epuise')->default(false);
            $table->string('unite')->default('pièce');
            // Il sert à indiquer la quantité contenue par unité de conditionnement.
            $table->float('contenu_par_unite')->nullable()->after('stock_actuel'); // ex: 4 (mètres par rouleau), 6 m/rouleau, ou 5 L/bidon
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
           // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outils');
    }
};
