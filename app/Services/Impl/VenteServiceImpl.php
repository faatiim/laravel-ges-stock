<?php

namespace App\Services\Impl;

use App\Models\Vente;
use App\Models\LignesDeVentes;
use App\Models\Outil;
use App\Services\VenteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class VenteServiceImpl implements VenteService
{
    // public function create(array $data): Vente
    // {
    //     return DB::transaction(function () use ($data) {
    //         // Génération d’un numéro de facture unique
    //         // $factureNum = 'FAC-' . now()->format('Ymd-His') . '-' . Str::random(5);
    //         $data['facture_numero'] = $this->generateInvoiceNumber();


    //         // Création de la vente principale
    //         $vente = Vente::create([
    //             'user_id'       => Auth::id(),
    //             'total'         => 0, // mis à jour après les lignes
    //             //'facture_numero'=> $factureNum,
    //             'facture_numero' => $data['facture_numero'],
    //             'moyen_paiement'=> $data['moyen_paiement'] ?? 'inconnu',
    //             'date_paiement' => $data['date_paiement'] ?? now(),
    //         ]);

    //         $totalGeneral = 0;

    //         foreach ($data['lignes'] as $ligne) {
    //             $outil = Outil::findOrFail($ligne['outil_id']);
            
    //             $mode = $ligne['mode_vente'];
    //             $contenu = $outil->contenu_par_unite ?? 1;
            
    //             // calcul de la quantité à retirer du stock
    //             if ($mode === 'physique') {
    //                 $quantitePhysique = $ligne['quantite'];
    //             } else {
    //                 // si logique, on convertit en unité : ex 15 kg / (50 kg/rouleau) = 0.3 rouleau
    //                 $quantitePhysique = $ligne['quantite'] / $contenu;
    //             }
            
    //             if ($outil->stock_actuel < $quantitePhysique) {
    //                 throw new \Exception("Stock insuffisant pour l'outil: {$outil->title}");
    //             }
            
    //             $prixUnitaire = $outil->prix_unitaire;
    //             $totalLigne = $prixUnitaire * $ligne['quantite'];
            
    //             // crée la ligne puis décrémente :
    //             LignesDeVentes::create([
    //                 'vente_id'      => $vente->id,
    //                 'outil_id'      => $outil->id,
    //                 'quantite'      => $ligne['quantite'], // toujours exprimée dans l’unité choisie
    //                 'mode_vente'    => $mode,
    //                 'prix_unitaire' => $prixUnitaire,
    //                 'total'         => $totalLigne,
    //             ]);
            
    //             $outil->stock_actuel -= $quantitePhysique;
    //             $outil->save();
            
    //             $totalGeneral += $totalLigne;
    //         }
            
    //         // foreach ($data['lignes'] as $ligne) {
    //         //     $outil = Outil::findOrFail($ligne['outil_id']);

    //         //     // Vérification stock
    //         //     if ($outil->stock_actuel < $ligne['quantite']) {
    //         //         throw new \Exception("Stock insuffisant pour l'outil: {$outil->title}");
    //         //     }

    //         //     $prixUnitaire = $outil->prix_unitaire;
    //         //     $totalLigne = $prixUnitaire * $ligne['quantite'];

    //         //     // Création ligne de vente
    //         //     LignesDeVentes::create([
    //         //         'vente_id'      => $vente->id,
    //         //         'outil_id'      => $outil->id,
    //         //         'quantite'      => $ligne['quantite'],
    //         //         'prix_unitaire' => $prixUnitaire,
    //         //         'total'         => $totalLigne,
    //         //     ]);

    //         //     // Mise à jour du stock
    //         //     $outil->stock_actuel -= $ligne['quantite'];
    //         //     $outil->save();

    //         //     $totalGeneral += $totalLigne;
    //         // }

    //         // Mise à jour du total de la vente
    //         $vente->update([
    //             'total' => $totalGeneral,
    //         ]);

    //         return $vente;
    //     });
    // }
    public function create(array $data): Vente
    {
        return DB::transaction(function () use ($data) {
            // 1) création de la vente
            $data['facture_numero'] = $this->generateInvoiceNumber();
            $vente = Vente::create([
                'user_id'        => Auth::id(),
                'total'          => 0,
                'facture_numero' => $data['facture_numero'],
                'moyen_paiement' => $data['moyen_paiement'] ?? 'inconnu',
                'date_paiement'  => $data['date_paiement']  ?? now(),
            ]);

            $totalGeneral = 0;

            // 2) traitement de chaque ligne
            foreach ($data['lignes'] as $ligne) {
                $outil         = Outil::findOrFail($ligne['outil_id']);
                $mode          = $ligne['mode_vente'];              // "physique" ou "logique"
                $contenuUnite  = $outil->contenu_par_unite ?: 1;

                // calcul de la quantité à retirer en stock "unités"
                $toRemove = $mode === 'physique'
                    ? $ligne['quantite']
                    : $ligne['quantite'] / $contenuUnite;

                if ($outil->stock_actuel < $toRemove) {
                    throw new \Exception("Stock insuffisant pour {$outil->title} (reste {$outil->stock_actuel})");
                }

                $prixUnitaire = $outil->prix_unitaire;
                $totalLigne   = $prixUnitaire * $ligne['quantite'];

                // 3) création de la ligne de vente
                LignesDeVentes::create([
                    'vente_id'      => $vente->id,
                    'outil_id'      => $outil->id,
                    'quantite'      => $ligne['quantite'],    // toujours dans l’unité choisie
                    'mode_vente'    => $mode,
                    'prix_unitaire' => $prixUnitaire,
                    'total'         => $totalLigne,
                ]);

                // 4) décrément du stock en "unités"
                $outil->decrement('stock_actuel', $toRemove);

                $totalGeneral += $totalLigne;
            }

            // 5) mise à jour du total de la vente
            $vente->update(['total' => $totalGeneral]);

            return $vente;
        });
    }

    public function generateRef(Vente $vente): string
    {
        $prefix = 'VEN-'. now()->format('Ymd');
        $id = $vente->id;

        return "{$prefix}-{$id}";
    }

    public function generateInvoiceNumber(): string
    {
        $prefix = 'FAC-' . now()->format('Ymd');
        $last = Vente::where('facture_numero', 'like', "$prefix%")->count() + 1;
        return $prefix . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    // VentesServiceImpl.php (partie update + PDF facture)

    public function update(Vente $vente, array $data): Vente
    {
        return DB::transaction(function () use ($vente, $data) {
            // Annuler les anciennes lignes + stock
            foreach ($vente->ligneVentes as $ligne) {
                $outil = $ligne->outil;
                $outil->stock_actuel += $ligne->quantite;
                $outil->save();

                $ligne->delete();
            }

            $totalGeneral = 0;

            foreach ($data['lignes'] as $ligneData) {
                $outil = Outil::findOrFail($ligneData['outil_id']);

                if ($outil->stock_actuel < $ligneData['quantite']) {
                    throw new \Exception("Stock insuffisant pour l'outil: {$outil->title}");
                }

                $prixUnitaire = $outil->prix_unitaire;
                $totalLigne = $prixUnitaire * $ligneData['quantite'];

                LignesDeVentes::create([
                    'vente_id'      => $vente->id,
                    'outil_id'      => $outil->id,
                    'quantite'      => $ligneData['quantite'],
                    'prix_unitaire' => $prixUnitaire,
                    'total'         => $totalLigne,
                ]);

                $outil->stock_actuel -= $ligneData['quantite'];
                $outil->save();

                $totalGeneral += $totalLigne;
            }

            $vente->update([
                'moyen_paiement' => $data['moyen_paiement'] ?? $vente->moyen_paiement,
                'date_paiement'  => $data['date_paiement'] ?? $vente->date_paiement,
                'total'          => $totalGeneral,
            ]);

            return $vente;
        });
    }

    public function genererOuTelechargerFacture(Vente $vente)
    {
        $vente->load('ligneVentes.outil', 'user');
        $filename = 'facture_' . $vente->facture_numero . '.pdf';
        $path = 'private/factures/' . $filename;

        // Créer le dossier s'il n'existe pas
        if (!Storage::disk('local')->exists('private/factures')) {
            Storage::disk('local')->makeDirectory('private/factures');
        }

        // Si déjà stockée, on la télécharge directement
        if (Storage::disk('local')->exists($path)) {
            return response()->download(storage_path('app/' . $path));
        }

        // Sinon, on la génère et on la stocke
        $pdf = Pdf::loadView('dash.pdf.facture', compact('vente'));
        Storage::disk('local')->put($path, $pdf->output());

        return response()->download(storage_path('app/' . $path));
    }

}
