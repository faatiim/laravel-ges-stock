<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vente\StoreVenteRequest;
use App\Http\Requests\Vente\UpdateVenteRequest;
use App\Models\Outil;
use App\Models\User;
use App\Models\Vente;
use App\Models\Ventes;
use App\Services\VenteService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VenteController extends Controller
{
    private VenteService $venteService;

    public function __construct(VenteService $venteService)
    {
        $this->venteService = $venteService;
    }

    public function index()
    {
        $users = User::all();
        $ventes = Vente::with('ligneVentes.outil', 'user')->latest()->paginate(10); // On charge les lignes et outils pour optimiser

        return view('dash.ventes.index', compact('ventes','users'));
    }

    /**
     * Affiche le formulaire de création d'une vente.
     */
    public function create()
    {
         $outils = Outil::all(); // récupère tous les outils

        return view('dash.ventes.create', compact('outils'));
    }
    

    public function store(StoreVenteRequest $request)
    {
        try {
            $vente = $this->venteService->create($request->validated());

            return redirect()->route('ventes.show', $vente->id)
                             ->with('success', 'Vente enregistrée avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la création de la vente : ' . $e->getMessage());

            // return back()->withErrors(['error' => 'Une erreur est survenue lors de la vente. Veuillez réessayer.']);
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();  // pour conserver les valeurs déjà saisies

        }
    }


    public function show($id)
    {
        // Pour la facture après-vente
        $vente = \App\Models\Vente::with('ligneVentes.outil', 'user')->findOrFail($id);
        return view('dash.ventes.show', compact('vente'));
    }


    public function update(UpdateVenteRequest $request, Vente $vente)
    {
        try {
            $this->venteService->update($vente, $request->validated());

            return redirect()->route('ventes.show', $vente->id)
                            ->with('success', 'Vente mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur update vente : ' . $e->getMessage());

            return back()->withErrors(['error' => 'Erreur lors de la mise à jour de la vente.']);
        }
    }

  

    public function downloadFacture(Vente $vente)
    {
        $vente->load('ligneVentes.outil', 'user');

        $filename = 'facture_' . $vente->facture_numero . '.pdf';
        $dir = storage_path('app/factures');
        $outputPath = $dir . '/' . $filename;

        // ✅ Créer le dossier s’il n’existe pas
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        // ✅ Générer le PDF
        $pdf = Pdf::loadView('dash.pdf.facture', compact('vente'));
        file_put_contents($outputPath, $pdf->output());

        // ✅ Vérification
        if (!file_exists($outputPath)) {
            abort(500, 'Erreur : fichier PDF non trouvé après création.');
        }

        return response()->download($outputPath);
    }
  
}
