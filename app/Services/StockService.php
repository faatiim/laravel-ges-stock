<?php
namespace App\Services;

use App\Models\Outil;

class StockService
{
    public function majStockActuel(Outil $outil): void
    {
        $vendu = $outil->lignesDeVente()->sum('quantite');
        $outil->stock_actuel = $outil->stock_initial - $vendu;
        $outil->save();
    }

//     public function decrementStock(Outil $outil, float $quantiteVendue): Outil
// {
//     return DB::transaction(function () use ($outil, $quantiteVendue) {
//         // Si c’est un produit conditionné (ex: rouleau de 4m)
//         if ($outil->contenu_par_unite && $outil->contenu_par_unite > 0) {
//             $quantiteEnUnite = $quantiteVendue / $outil->contenu_par_unite;
//         } else {
//             $quantiteEnUnite = $quantiteVendue;
//         }

//         // Mise à jour du stock
//         $outil->stock_actuel -= $quantiteEnUnite;
//         $outil->stock_actuel = max(0, $outil->stock_actuel); // pas de stock négatif
//         $outil->isActive = $outil->stock_actuel > 0;
//         $outil->save();

//         return $outil;
//     });
// }

}