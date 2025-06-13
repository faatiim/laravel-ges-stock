<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LignesDeVentes extends Model
{
    use HasFactory;

    protected $fillable = [
        'vente_id',
        'outil_id',
        'quantite',
        'mode_vente',
        'prix_unitaire',
        'total',
    ];

        /**
     * Définir la relation avec le modèle Vente.
     */
    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    /**
     * Définir la relation avec le modèle Outil.
     */
    public function outil()
    {
        return $this->belongsTo(Outil::class);
    }

    protected $casts = [
        'quantite' => 'float',
        'prix_unitaire' => 'float',
        'total' => 'float',
    ];


}
