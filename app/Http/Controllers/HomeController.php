<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LignesDeVentes;
use App\Models\Outil;
use App\Models\User;
use App\Models\Vente;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use function Laravel\Prompts\outro;

class HomeController extends Controller
{
    public function home(): View
    {
       
        $users = User::all();
        $outils = Outil::all();
        $ventes = Vente::all();

        // debut le plus et le moins
        // Outil le plus vendu
        $outilLePlusVendu = DB::table('lignes_de_ventes')
        ->select('outil_id', DB::raw('count(*) as total'))
        ->groupBy('outil_id')
        ->orderByDesc('total')
        ->first();

         // Outil le moins vendu
        $outilLeMoinsVendu = DB::table('lignes_de_ventes')
        ->select('outil_id', DB::raw('count(*) as total'))
        ->groupBy('outil_id')
        ->orderBy('total')
        ->first();
         
        $outilTop = null;
        $outilBas = null;

        if ($outilLePlusVendu) {
            $outilTop = Outil::find($outilLePlusVendu->outil_id);
            $outilTop->ventes_total = $outilLePlusVendu->total;
        }
     
        if ($outilLeMoinsVendu) {
            $outilBas = Outil::find($outilLeMoinsVendu->outil_id);
            $outilBas->ventes_total = $outilLeMoinsVendu->total;
        }
        //fin le plus et le moins 

        
        // DEBUT DIAGRAMME BARRE Récupérer le nombre de ventes par outil (outil_id + total)
        $ventesParOutil = DB::table('lignes_de_ventes')
        ->select('outil_id', DB::raw('count(*) as total'))
        ->groupBy('outil_id')
        ->get();

        // On prépare un tableau associatif pour la vue : nom outil => total ventes
        $ventesParNomOutil = [];

        foreach ($ventesParOutil as $vente) {
            $outil = Outil::find($vente->outil_id);
            if ($outil) {
                $ventesParNomOutil[$outil->title] = $vente->total;
            }
        }
        // FIN DIAGRAMME BARRE

        // DEB HISTORIQUE

        $ventesHistoriques = \App\Models\Vente::withCount('ligneVentes') // tjr s'assurer que la relation existe dans Vente
                    ->orderByDesc('created_at')
                    ->take(10)
                    ->get();


        // FIN HISTORIQUE

        //activity
        
        $activites = \App\Models\Vente::with('user') // Assure que la relation `user` existe
        ->latest()
        ->take(10)
        ->get();
        
        //fin activity


        // alert RELAYER A AppProviderService // fin alert

        //montant total 

          $mois = Carbon::now()->month;
            $annee = Carbon::now()->year;

            // Tous les outils créés par cet utilisateur
            $outils = Outil::with(['lignesDeVente' => function ($query) use ($mois, $annee) {
                    $query->whereMonth('created_at', $mois)
                        ->whereYear('created_at', $annee);
                }])
                //->where('author_id', $user->id)
                ->get();

            // On collecte toutes les lignes de vente depuis les outils
            $ventesDuMois = $outils->pluck('lignesDeVente')->flatten();

            $totalVentes = $ventesDuMois->count();
            $montantTotal = $ventesDuMois->sum('total');

            // fin montant total

            
        //vente pr outil
        
           // Récupère le nombre de ventes par outil ce mois-ci
 
 
           // $ventesParOutil = LignesDeVentes::select('outils.title', DB::raw('COUNT(*) as total'))
            //     ->join('outils', 'outils.id', '=', 'lignes_de_ventes.outil_id')
            //     ->whereMonth('lignes_de_ventes.created_at', $mois)
            //     ->whereYear('lignes_de_ventes.created_at', $annee)
            //     ->groupBy('outils.title')
            //     ->orderByDesc('total')
            //     ->limit(5)             // <-- top 5
            //     ->pluck('total', 'title');

            // // Somme totale de ces 5 outils
            // $totalTop5 = $ventesParOutil->sum();

            // // Variation % vs mois précédent (optionnel)
            // $prevCount = LignesDeVentes::whereMonth('created_at', Carbon::now()->subMonth()->month)
            //     ->whereYear('created_at', Carbon::now()->subMonth()->year)
            //     ->count();
            // $percentChange = $prevCount
            //     ? round((($totalTop5 - $prevCount) / $prevCount) * 100, 1)
            //     : 100;


        //vente pr outil

          // Top 5 des outils par stock actuel
    $stockParOutil = Outil::orderByDesc('stock_actuel')
        ->limit(10)
        ->pluck('stock_actuel', 'title');

        // ou
        // $stockParOutil = Outil::withSum('stocks', 'quantite')
        //     ->get()
        //     ->sortBy('stocks_sum_quantite') // ordre croissant
        //     ->take(10) // les 10 plus faibles
        //     ->mapWithKeys(fn($outil) => [$outil->title => $outil->stocks_sum_quantite ?? 0]);)

    // Somme du stock de ces 5 outils
    $totalStock = $stockParOutil->sum();

        return view('dashboard', compact('users','outils','ventes', 'outilTop', 'outilBas', 'ventesParNomOutil', 'ventesHistoriques', 'activites','montantTotal', 'ventesDuMois', 'ventesParOutil', 'stockParOutil','totalStock',));// ,'stockAlert', 'notificationsCount'

    }
 

}
