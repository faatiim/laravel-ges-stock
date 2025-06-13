@extends('layouts.app')

@section('title','Dashboard - Modifier un Outil')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-sm-12 col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Modifier l’Outil</div>
        </div>

        @if(session('success') || session('succes'))
          <div class="alert alert-success">
            {{ session('success') ?? session('succes') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="card-body">
          <form action="{{ route('outil.update', $outil) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
              <!-- Colonne gauche -->
              <div class="col-sm-6 col-12">
                <div class="card-border">
                  <div class="card-border-title">Informations Générales</div>
                  <div class="card-border-body">

                    <div class="mb-3">
                      <label class="form-label">Désignation <span class="text-red">*</span></label>
                      <input type="text" name="title" class="form-control" value="{{ old('title', $outil->title) }}" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">État <span class="text-red">*</span></label>
                      <select name="etat" class="form-control" required>
                        @foreach(['neuf', 'utilise', 'endommagé', 'autre'] as $etat)
                          <option value="{{ $etat }}" @selected(old('etat', $outil->etat) === $etat)>
                            {{ ucfirst($etat) }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    

                    <div class="mb-3">
                      <label class="form-label">Unité <span class="text-red">*</span></label>
                      <select name="unite" class="form-control" required>
                        @foreach(['métre', 'kg', 'tonne', 'piece', 'boite', 'autre'] as $unite)
                          <option value="{{ $unite }}" @selected(old('unite', $outil->unite) === $unite)>
                            {{ ucfirst($unite) }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    {{-- <div class="mb-3">
                      <label class="form-label">Description</label>
                      <textarea name="description" rows="4" class="form-control">{{ old('description', $outil->description) }}</textarea>
                    </div> --}}

                    <div class="mb-3">
                      <label class="form-label">Catégorie <span class="text-red">*</span></label>
                      <select name="category_id" class="form-control" required>
                        <option value="">-- Sélectionner une catégorie --</option>
                        @foreach($categories as $id => $name)
                          <option value="{{ $id }}" @selected(old('category_id', $outil->category_id) == $id)>
                            {{ $name }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    {{-- <div class="mb-3 form-check">
                      <input type="checkbox" name="isSharable" class="form-check-input" id="sharableCheck" value="1"
                             {{ old('isSharable', $outil->isSharable) ? 'checked' : '' }}>
                      <label class="form-check-label" for="sharableCheck">Cet outil est partageable</label>
                    </div> --}}

                  </div>
                </div>
              </div>

              <!-- Colonne droite -->
              <div class="col-sm-6 col-12">
                <div class="card-border">
                  <div class="card-border-title">Stock & Options</div>
                  <div class="card-border-body">

                   
                    <div class="mb-3">
                      <label class="form-label">Prix unitaire (FCFA) <span class="text-red">*</span></label>
                      <input type="number" step="0.01" name="prix_unitaire" class="form-control"
                             value="{{ old('prix_unitaire', $outil->prix_unitaire) }}" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Prix d'achat <span class="text-red">*</span></label>
                      <div class="input-group">
                        <input type="number" name="prix_achat" class="form-control"
                               value="{{ old('prix_achat', $outil->prix_achat) }}" required>
                        <span class="input-group-text">FCFA</span>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Quantité en stock initiale <span class="text-red">*</span></label>
                      <input type="number" name="stock_initial" class="form-control"
                             value="{{ old('stock_initial', $outil->stock_initial) }}" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Quantité en stock actuel <span class="text-red">*</span></label>
                      <input type="number" name="stock_actuell" class="form-control"
                             value="{{ old('stock_actuel', $outil->stock_actuel) }}" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Seuil d'alerte <span class="text-red">*</span></label>
                      <input type="number" name="seuil_alerte" class="form-control"
                             value="{{ old('seuil_alerte', $outil->seuil_alerte) }}" required>
                    </div>

                  </div>
                </div>
              </div>

              <!-- Boutons -->
              <div class="col-sm-12 col-12 mt-3">
                <div class="custom-btn-group flex-end">
                  <a href="{{ route('outil.index') }}" class="btn btn-light">Annuler</a>
                  <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
