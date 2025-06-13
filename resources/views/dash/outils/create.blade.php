@extends('layouts.app')

@section('title','Dashboard - Ajouter un Outil')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-sm-12 col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Informations sur l'Outil</div>
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
          <form action="{{ route('outil.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <!-- Colonne gauche : Infos générales -->
              <div class="col-sm-6 col-12">
                <div class="card-border">
                  <div class="card-border-title">Informations Générales</div>
                  <div class="card-border-body">

                    <div class="mb-3">
                      <label class="form-label">Désignation <span class="text-red">*</span></label>
                      <input type="text" name="title" class="form-control" placeholder="Désignation de l'outil" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Etat <span class="text-red">*</span></label>
                      <select name="etat" class="form-control" required>
                        <option value="neuf">Neuf</option>
                        <option value="utilise">Utilisé</option>
                        <option value="endommagé">Endommagé</option>
                        <option value="autre">Autre</option>
                      </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Unité <span class="text-red">*</span></label>
                        <select name="unite" class="form-control"  required>
                          <option value=""> Choisir l'unité de mesure</option>
                          <option value="métre">métre</option>
                          <option value="kg">Kg</option>
                          <option value="tonne">Tonnes</option>
                          <option value="piece">Piéces</option>
                          <option value="boite">boites</option>
                          <option value="autre">Autre</option>
                        </select>
                      </div>

                    {{-- <div class="mb-3">
                      <label class="form-label">Unité <span class="text-red">*</span></label>
                      <input type="text" name="unite" class="form-control" placeholder="Ex: pièce, kg, mètre..." required>
                    </div> --}}

                    {{-- <div class="mb-3">
                      <label class="form-label">Description <!--span class="text-red">*</span></label-->
                      <textarea name="description" rows="4" class="form-control" placeholder="Description complète" ></textarea>
                    </div> --}}

                    <div class="mb-3">
                      <label class="form-label">Catégorie <span class="text-red">*</span></label>
                      <select name="category_id" class="form-control" required>
                        <option value="">-- Sélectionner une catégorie --</option>
                        @foreach($categories as $id => $name)
                          <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                    </div>
{{-- 
                    <div class="mb-3 form-check">
                      <input type="checkbox" name="isSharable" class="form-check-input" id="sharableCheck" value="1">
                      <label class="form-check-label" for="sharableCheck">Cet outil est partageable</label>
                    </div> --}}

                  </div>
                </div>
              </div>

              <!-- Colonne droite : Stock & Prix -->
              <div class="col-sm-6 col-12">
                <div class="card-border">
                  <div class="card-border-title">Stock & Options</div>
                  <div class="card-border-body">

                    <div class="mb-3">
                      <label class="form-label">Prix unitaire (FCFA) <span class="text-red">*</span></label>
                      <input type="number" step="0.01" name="prix_unitaire" class="form-control" placeholder="0.00" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Prix d'achat <span class="text-red">*</span></label>
                      <div class="input-group">
                        <input type="number" name="prix_achat" class="form-control" placeholder="0.00" required>
                        <span class="input-group-text">FCFA</span>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Prix Vente <span class="text-red">*</span></label>
                      <div class="input-group">
                        <input type="number" name="prix_gros" class="form-control" placeholder="0.00" required>
                        <span class="input-group-text">FCFA</span>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Quantité en stock initiale <span class="text-red">*</span></label>
                      <input type="number" name="stock_initial" class="form-control" placeholder="Ex: 10" required>
                    </div>

                    {{-- <div class="mb-3">
                      <label class="form-label">Seuil d'alerte <span class="text-red">*</span></label>
                      <input type="number" name="seuil_alerte" class="form-control" placeholder="Ex: 5" required>
                    </div> --}}

                  </div>
                </div>
              </div>

              <!-- Boutons -->
              <div class="col-sm-12 col-12 mt-3">
                <div class="custom-btn-group flex-end">
                  <a href="{{ route('outil.index') }}" class="btn btn-light">Annuler</a>
                  <button type="submit" class="btn btn-success">Ajouter l'outil</button>
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







{{-- @extends('layouts.app')

@section('title','Dashboard - Ajouter un Outil')

@section('content')

<div class="content-wrapper">
  <!-- Row start -->
  <div class="row">
    <div class="col-sm-12 col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Informations sur l'Outil</div>
        </div>

        <div class="card-body">
          <form action="{{ route('outil.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <!-- Colonne gauche : Infos générales -->
              <div class="col-sm-6 col-12">
                <div class="card-border">
                  <div class="card-border-title">Informations Générales</div>
                  <div class="card-border-body">

                    <div class="mb-3">
                      <label class="form-label">Désignation <span class="text-red">*</span></label>
                      <input type="text" name="title" class="form-control" placeholder="Désignation de l'outil" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Etat <span class="text-red">*</span></label>
                        <select name="etat" class="form-control" required>
                          <option value="">-- Sélectionner une  --</option>
                            <option value="neuf">Neuf</option>
                            <option value="neuf">Utilisé</option>
                            <option value="neuf">Endommagé</option>
                            <option value="neuf">...</option>
                        </select>
                      </div>
  

                    <div class="mb-3">
                      <label class="form-label">Description <span class="text-red">*</span></label>
                      <textarea name="description" rows="4" class="form-control" placeholder="Description complète" required></textarea>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Catégorie <span class="text-red">*</span></label>
                     
                      <select name="category_id" class="form-control" required>
                        <option value="">-- Sélectionner une catégorie --</option>
                        @foreach($categories as $id => $name)
                          <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                    </div>

                  </div>
                </div>
              </div>

              <!-- Colonne droite : Métadonnées -->
              <div class="col-sm-6 col-12">
                <div class="card-border">
                  <div class="card-border-title">Stock & Options</div>
                  <div class="card-border-body">

                    <div class="mb-3">
                      <label class="form-label">Prix unitaire (FCFA) <span class="text-red">*</span></label>
                      <input type="number" step="0.01" name="prix_unitaire" class="form-control" placeholder="0.00" required>
                    </div>
        
                      <div class="mb-3">
                        <label class="form-label">Prix d'achat <span class="text-red">*</span></label>
                            <div class="input-group">
                              <input type="number" name="prix_achat" class="form-control" placeholder="0.00" required>
                              <span class="input-group-text form-label">F cfa</span>
                            </div>
                      </div>

                    <div class="mb-3">
                      <label class="form-label">Quantité en stock <span class="text-red">*</span></label>
                      <input type="number" name="stock_initial" class="form-control" placeholder="Ex: 10" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Seuil d'alerte<span class="text-red">*</span></label>
                        <input type="number" name="seuil_alerte" class="form-control" placeholder="Ex: 10" required>
                    </div>

                  

                  </div>
                </div>
              </div>

        

              <!-- Boutons -->
              <div class="col-sm-12 col-12 mt-3">
                <div class="custom-btn-group flex-end">
                  <a href="{{ route('outil.index') }}" class="btn btn-light">Annuler</a>
                  <button type="submit" class="btn btn-success">Ajouter l'outil</button>
                </div>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- Row end -->
</div>

@endsection



 --}}
