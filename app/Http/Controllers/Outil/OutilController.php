<?php

namespace App\Http\Controllers\Outil;

use App\Models\Outil;
use App\Http\Controllers\Controller;
use App\Http\Requests\Outil\StoreOutilRequest;
use App\Http\Requests\Outil\UpdateOutilRequest;
use App\Models\Category;
use App\Models\User;
use App\Services\Contracts\OutilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutilController extends Controller
{
    protected OutilService $outilService;

    public function __construct(OutilService $outilService)
    {
        $this->outilService = $outilService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        /** @var Outil $outilService */
        // $outils =$this->outilService->findAll();
        $outils = Outil::with(['category', 'author'])->latest()->get();

        return view('dash.outils.index', compact('outils'), compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = Category::pluck('name', 'id')->with('isActice'==true); // pour select
        $categories = Category::where('isActive', true)->pluck('name', 'id');

        $users = User::all();

        return view('dash.outils.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutilRequest $request)
    {

        //✅ Correct:
        $data = $request->validated();

        // Ajouter automatiquement l'auteur
        $data['author_id'] = Auth::id();

        // Initialiser stock_actuel comme le stock_initial
        // $data['stock_actuel'] = $data['stock_initial'] ?? 0;

        $this->outilService->create($data);

        return redirect()->route('outil.index')->with('success', 'Outil ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Outil $outil)
    {
        return view('dash.outils.show', compact('outil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outil $outil)
    {
        $categories = Category::pluck('name', 'id'); // pour select
        return view('dash.outils.edit', compact('outil'), compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutilRequest $request, Outil $outil)
    {
        $this->outilService->update($outil, $request->validated());
        return redirect()->route('outil.index')->with('success', 'Outil mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outil $outil)
    {
        $this->outilService->delete($outil);
        return redirect()->route('outil.index')->with('success', 'Outil supprimé.');
    }
}
