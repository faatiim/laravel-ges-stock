<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Affiche la liste des catégories.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return view('dash.category.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des catégories : " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l’affichage des catégories.');
        }
    }

    /**
     * Affiche le formulaire de création d'une nouvelle catégorie.
     */
    public function create()
    {
        return view('dash.category.create');
    }

    /**
     * Enregistre une nouvelle catégorie.
     */
    // public function store(StoreCategoryRequest $request)
    // {
    //     try {
    //         Category::create($request->validated());
    //         return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès.');
    //     } catch (\Exception $e) {
    //         // Log::error("Erreur lors de la création de la catégorie : " . $e->getMessage());
    //         // return back()->withInput()->with('error', 'Une erreur est survenue lors de l’ajout de la catégorie.');
    //         return back()
    //             ->withErrors(['error' => $e->getMessage()])
    //             ->withInput(); 
    //     }
    // }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['isActive'] = $request->has('isActive') ? 1 : 0;

            Category::create($data);
            return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput(); 
        }
    }


    /**
     * Affiche le formulaire d'édition d'une catégorie.
     */
    public function edit(Category $category)
    {
        try {
            $categories = Category::all(); // pour affichage dans le tableau aussi
            return view('dash.category.index', compact('category', 'categories'));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'édition de la catégorie : " . $e->getMessage());
            return redirect()->route('categories.index')->with('error', 'Impossible de charger le formulaire d’édition.');
        }
    }

    /**
     * Met à jour une catégorie existante.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->name = $request->name;
            $category->description = $request->description;
            $category->isActive = $request->has('isActive') ? 1 : 0;
    
            if ($category->save()) {
                return to_route('categories.index')->with('success', 'Catégorie "' . $category->name . '" modifiée avec succès.');
            } else {
                return to_route('categories.index')->with('error', 'La catégorie n’a pas pu être mise à jour. Veuillez réessayer.');
            }
    
        } catch (\Exception $e) {
            // Log détaillé
            Log::error('Erreur lors de la mise à jour de la catégorie (ID: ' . $category->id . ') : ' . $e->getMessage(), [
                'request' => $request->all(),
                'category' => $category->toArray()
            ]);
    
            return to_route('categories.index')->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
    
    

    /**
     * Supprime une catégorie.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès.');
        } catch (\Exception $e) {
            Log::error("Erreur lors de la suppression de la catégorie : " . $e->getMessage());
            return redirect()->route('categories.index')->with('error', 'Impossible de supprimer la catégorie.');
        }
    }
}
