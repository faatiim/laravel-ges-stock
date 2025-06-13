@extends('layouts.app')

@section('title', 'Détail de l’Outil')

@section('content')
<div class="content-wrapper">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card shadow-sm border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="text-muted fw-semibold mb-0">Détail de l’Outil</h2>
          <a href="{{ route('outil.index') }}" class="btn btn-light border rounded-pill">
            ← Retour à la liste
          </a>
        </div>

        <div class="row g-4">
          <!-- Colonne principale -->
          <div class="col-md-9">
            <div class="row g-3">
              @php
                $infos = [
                  ['Nom', $outil->title],
                  ['Référence', $outil->reference],
                  // ['Slug', $outil->slug],
                  ['État', $outil->etat],
                  ['Unité', $outil->unite],
                  ['Prix unitaire', number_format($outil->prix_unitaire, 0, ',', ' ') . ' FCFA'],
                  ['Prix d\'achat', $outil->prix_achat ? number_format($outil->prix_achat, 0, ',', ' ') . ' FCFA' : '—'],
                  ['Stock initial', $outil->stock_initial],
                  ['Stock actuel', $outil->stock_actuel],
                  ['prix de vente', $outil->prix_gros ? number_format($outil->prix_gros, 0, ',', ' ') . ' FCFA' : '—'],
                  ['Seuil alerte', $outil->seuil_alerte],
                  ['Catégorie', $outil->category?->name ?? '—'],
                  ['Actif ?', $outil->isActive ? 'Oui' : 'Non'],
                  ['Partageable ?', $outil->isSharable ? 'Oui' : 'Non'],
                  ['Créé le', $outil->created_at->format('d/m/Y')],
                  ['Mis à jour', $outil->updated_at->format('d/m/Y')],
                ];
              @endphp

              @foreach(array_chunk($infos, 2) as $pair)
              <div class="col-md-6">
                @foreach($pair as [$label, $value])
                  <div class="mb-3">
                    <div class="text-muted small">{{ $label }}</div>
                    <div class="fw-medium fs-6 text-dark">{{ $value }}</div>
                  </div>
                @endforeach
              </div>
              @endforeach

              <div class="col-12 mt-2">
                <div class="text-muted small mb-1">Description</div>
                <div class="text-body fs-6">{{ $outil->description ?? '—' }}</div>
              </div>
            </div>
          </div>

          <!-- Colonne droite (auteur) -->
          <div class="col-md-3 text-center">
            <img
              src="{{ $outil->author?->image_url ?? asset('assets/images/placeholder.jpg') }}"
              class="rounded-circle shadow-sm mb-3"
              alt="Créateur"
              style="width: 100px; height: 100px; object-fit: cover;"
            >
            <div class="text-muted small">Créé par</div>
            <div class="fw-semibold text-dark fs-6">{{ $outil->author?->first_name ?? 'Utilisateur inconnu' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection





{{-- @extends('layouts.app')

@section('title', 'Détail de l’Outil')

@section('content')
<div class="content-wrapper">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card shadow-sm border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0 text-muted fw-semibold">Détail de l’Outil</h2>
          <a href="{{ route('outil.index') }}" class="btn btn-light border rounded-pill">
            ← Retour à la liste
          </a>
        </div>

        <div class="row">
          <div class="col-md-8">
            <h4 class="fw-bold text-dark mb-3">{{ $outil->title }}</h4>
            
            <p class="text-muted"><strong>Catégorie :</strong> {{ $outil->category?->name ?? '—' }}</p>
            <p class="text-muted"><strong>Description :</strong><br>{{ $outil->description ?? '—' }}</p>
            <p class="text-muted"><strong>État :</strong> {{ $outil->etat ?? 'Non spécifié' }}</p>
            <p class="text-muted"><strong>Prix unitaire :</strong> {{ number_format($outil->prix_unitaire, 0, ',', ' ') }} FCFA</p>
            <p class="text-muted"><strong>Stock initial :</strong> {{ $outil->stock_initial }} {{ $outil->unite }}</p>
            <p class="text-muted"><strong>Stock actuel :</strong> {{ $outil->stock_actuel }} {{ $outil->unite }}</p>
            <p class="text-muted"><strong>Seuil d'alerte :</strong> {{ $outil->seuil_alerte ?? '—' }}</p>
            <p class="text-muted"><strong>Partageable ?</strong> {{ $outil->isSharable ? 'Oui' : 'Non' }}</p>
            <p class="text-muted"><strong>Actif ?</strong> {{ $outil->isActive ? 'Oui' : 'Non' }}</p>
          </div>

          <div class="col-md-4 text-center">
            <div class="mb-3">
              <img
                src="{{ $outil->author?->image_url ?? asset('assets/images/placeholder.jpg') }}"
                class="rounded-circle shadow"
                alt="Créateur"
                style="width: 100px; height: 100px; object-fit: cover;"
              >
            </div>
            <p class="mb-0 text-muted">Créé par</p>
            <h6 class="fw-semibold">{{ $outil->author?->name ?? 'Utilisateur inconnu' }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}










{{-- @extends('layouts.app')

@section('title', 'Détails - ' . $outil->title)

@section('content')
<div class="content-wrapper">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-12">
      <div class="card shadow rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top-4">
          <h4 class="mb-0"><i class="bi bi-tools me-2"></i>Détails de l'Outil</h4>
          <a href="{{ route('outil.edit', $outil->slug) }}" class="btn btn-light btn-sm">
            <i class="bi bi-pencil me-1"></i> Modifier
          </a>
        </div>
        <div class="card-body">
          <div class="mb-4">
            <h5 class="fw-bold">Nom de l'outil</h5>
            <p class="text-muted">{{ $outil->title }}</p>
          </div>

          <div class="mb-4">
            <h5 class="fw-bold">Description</h5>
            <p class="text-muted">{{ $outil->description ?? 'Aucune description fournie.' }}</p>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <h6 class="fw-bold">Prix Unitaire</h6>
              <p>{{ number_format($outil->prix_unitaire, 0, ',', ' ') }} FCFA</p>
            </div>
            @if ($outil->prix_achat)
            <div class="col-md-6">
              <h6 class="fw-bold">Prix d'Achat</h6>
              <p>{{ number_format($outil->prix_achat, 0, ',', ' ') }} FCFA</p>
            </div>
            @endif

            <div class="col-md-4">
              <h6 class="fw-bold">Stock Initial</h6>
              <p>{{ $outil->stock_initial }} {{ $outil->unite }}</p>
            </div>
            <div class="col-md-4">
              <h6 class="fw-bold">Stock Actuel</h6>
              <span class="badge {{ $outil->isActive ? 'bg-success' : 'bg-danger' }}">
                {{ $outil->stock_actuel }} {{ $outil->unite }}
              </span>
            </div>
            <div class="col-md-4">
              <h6 class="fw-bold">Seuil d'Alerte</h6>
              <p>{{ $outil->seuil_alerte ?? '—' }}</p>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold">Catégorie</h6>
              <p>{{ $outil->category?->name ?? 'Non spécifiée' }}</p>
            </div>
            <div class="col-md-6">
              <h6 class="fw-bold">État</h6>
              <p>{{ $outil->etat ?? '—' }}</p>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold">Partageable</h6>
              <p>{{ $outil->isSharable ? 'Oui' : 'Non' }}</p>
            </div>

            <div class="col-md-6 d-flex align-items-center">
              <h6 class="fw-bold me-2">Statut :</h6>
              <span class="badge {{ $outil->isActive ? 'bg-success' : 'bg-danger' }}">
                {{ $outil->isActive ? 'Actif' : 'Inactif' }}
              </span>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex align-items-center">
            <div>
              <h6 class="fw-bold">Créé par</h6>
              <p class="mb-0">{{ $outil->author?->name ?? '—' }}</p>
            </div>
            @if ($outil->author && $outil->author->image_url)
              <img src="{{ $outil->author->image_url }}" class="ms-3 rounded-circle shadow" width="50" height="50" style="object-fit: cover;" alt="Auteur">
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}
