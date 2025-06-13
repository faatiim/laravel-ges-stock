<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'total',
        'facture_numero',
        'moyen_paiement',
        'date_paiement',
    ];

    
     /**
     * Relation avec les lignes de vente.
     */
                    // utiliser dans Store de vente lignesVentes
                    public function ligneVentes()
                    {
                        return $this->hasMany(LignesDeVentes::class);
                    }
                
                     /**
                     * Relation avec l'utilisateur qui a effectué la vente.
                     */
                    public function user()
                    {
                        return $this->belongsTo(User::class);
                    }

}
