<?php

namespace App\Services\Impl;

use App\Models\Category;
use App\Models\Outil;
use App\Services\Contracts\OutilService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class OutilServiceImpl implements OutilService
{
    public function create(array $data): Outil
    {
        // return DB::transaction(function () use ($data) {

        //     $data['stock_actuel'] = $data['stock_initial']; // Assigner automatiquement

        //     $outil = Outil::create($data);

        //      // Puis on génère la référence avec l'ID maintenant disponible
        //     $outil->reference = $this->generateRef($outil);
        //     $outil->save();

        //     return $outil;
        // });
        return DB::transaction(function () use ($data) {
            // 1) Assigner stock_actuel à stock_initial
            $data['stock_actuel'] = $data['stock_initial'];
    
            // 2) Calcul automatique du seuil d’alerte
            //    si stock_initial entre 1 et 59 → seuil = 14
            //    si stock_initial ≥ 60       → seuil = 25
            $initial = (int) $data['stock_initial'];
            $data['seuil_alerte'] = $initial >= 60 ? 25 : 14;
    
            // 3) Création de l’outil
            $outil = Outil::create($data);
    
            // 4) Génération de la référence (avec l’ID maintenant dispo)
            $outil->reference = $this->generateRef($outil);
            $outil->save();
    
            return $outil;
        });


    }

    public function generateRef(Outil $outil): string
    {
        $prefix = 'OUT-';
        
        // Récupère la catégorie liée (si existe)
        $category = $outil->category;
        $categorieCode = strtoupper(substr($category->name ?? 'XX', 0, 4));

        $id = $outil->id;

        return "{$prefix}-{$categorieCode}-{$id}";
    }

    // public function generateRef(Outil $outil): string
    // {
    //     $cat = Category::all();
    //     $prefix = 'OUT-' . now()->format('Ymd');
    //     $categorie = strtoupper(substr($cat->categorie ?? 'XX', 0, 2)); // Défaut si pas de catégorie
    //     $id = $outil->id;
    
    //     return "{$prefix}-{$categorie}-{$id}";
    // }

    public function update(Outil $outil, array $data): Outil
    {
        return DB::transaction(function () use ($outil, $data) {
            $outil->update($data);
            return $outil;
        });
    }

    public function delete(Outil $outil): bool
    {
        return DB::transaction(function () use ($outil) {
            return $outil->delete();
        });
    }

    public function findById(int $id): ?Outil
    {
        return Outil::find($id);
    }

    public function findAll(): Collection
    {
        return Outil::all();
    }

    public function updateStock(Outil $outil, int $quantity): Outil
    {
        return DB::transaction(function () use ($outil, $quantity) {
            $outil->stock_actuel = $quantity;
            // $outil->est_epuise = $quantity <= 0;
            $outil->isActive = $quantity > 0;
            $outil->save();

            return $outil;
        });
    }
}
