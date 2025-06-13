@extends('Layouts.app')

@section('title', 'Alertes de Stock')

@section('content')
<div class="content-wrapper">
  <div class="page-header d-flex justify-content-between align-items-center">
    <h3 class="page-title text-danger">⚠️ Gestion des alertes de stock</h3>
    <a href="{{ route('outil.create') }}" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Réapprovisionner
    </a>
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Liste des produits à faible stock</h4>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Nom de l’outil</th>
                <th>Stock actuel</th>
                <th>Seuil d’alerte</th>
                <th>Statut</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($stockAlert as $outil)
                <tr>
                  <td>{{ $outil->title }}</td>
                  <td>{{ $outil->stock_actuel }}</td>
                  <td>{{ $outil->seuil_alerte }}</td>
                  <td>
                    <span class="badge bg-{{ $outil->stock_actuel == 0 ? 'danger' : 'warning' }}">
                      {{ $outil->stock_actuel == 0 ? 'Épuisé' : 'Stock Faible' }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('outil.edit', $outil->slug) }}" class="btn btn-sm btn-primary">
                      <i class="bi bi-pencil-square"></i> Réapprovisionner
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted">🎉 Aucun stock critique actuellement</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
