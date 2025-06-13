<?php

namespace App\Http\Controllers;

use App\Models\Outil;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function alerts()
{
    $stockAlert = Outil::whereColumn('stock_actuel', '<=', 'seuil_alerte')
        ->orderBy('stock_actuel', 'asc')
        ->get();

    return view('dash.ventes.alerte', compact('stockAlert'));
}
}
