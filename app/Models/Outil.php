<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Category;
use App\Models\User;



class Outil extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'etat',
        'reference',
        'description',
        'isActive', // sera géré automatiquement // pour désactiver en cas d'épuisement du stock 
        'isSharable', // pour partager l'outil optionnel
        'prix_unitaire',
        'prix_gros',
        'stock_initial',
        'stock_actuel',
        'seuil_alerte',
        // 'est_epuise',
        'unite',
        'contenu_par_unite',
        'prix_achat',
        'category_id',
        'author_id',
    ];


    public function lignesDeVente()
    {
        return $this->hasMany(LignesDeVentes::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    /** Laravel, si tu as à la fois :une colonne physique stock_actuel dans la base et une méthode d’accessor getStockActuelAttribute(), Laravel prendra la valeur de la base, pas celle calculée dynamiquement*/
    // public function getStockActuelAttribute(): int
    // {
    //     $vendu = $this->lignesDeVente()->sum('quantite');
    //     return $this->stock_initial - $vendu;
    // }

    
    public function getStockCalculerAttribute(): int
    {
        return $this->stock_initial - $this->lignesDeVente()->sum('quantite');
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('title')
        ->saveSlugsTo('slug');
    }

        
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Ajout d'un accessor dynamique dans le modèle :

    // Retourne true si stock = 0
    public function getEstEpuiseAttribute(): bool
    {
        return $this->stock_actuel === 0;
    }

    // Retourne true si stock est inférieur au seuil d’alerte
    public function getStockCritiqueAttribute(): bool
    {
        return $this->stock_actuel < $this->seuil_alerte;
    }

    // Ajout d'un hook creating :


    protected static function booted(): void
    {
        static::creating(function (Outil $outil) {
            $outil->reference = 'OUT-' . strtoupper(uniqid());
        });
    }

    public function getContenuParUniteAttribute($value)
    {
        return $value > 0 ? $value : 1; // fallback de sécurité
    }

    
    protected $casts = [
        'stock_initial' => 'float',
        'stock_actuel'  => 'float',
        'contenu_par_unite' => 'float',
    ];

            
}
