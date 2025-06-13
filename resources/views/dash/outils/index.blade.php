@extends('layouts.app')

@section('title','Dashboard - Outils')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title">Liste des Outils</h5>
          <a href="{{ route('outil.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Ajouter
          </a>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="searchable-table">
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Prix Unitaire</th>
                  <th>Prix d'Achat</th>
                  <th>Prix Vente</th>
                  <th>Stock</th>
                  <th>Catégorie</th>
                  <th>Créer par</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($outils as $out)
                <tr>
                    <td>{{ $out->title }}</td>
                    <td>{{ number_format($out->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($out->prix_achat, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($out->prix_gros, 0, ',', ' ') }} FCFA</td>
                    <td>
                        <span class="badge {{ $out->isActive ? 'bg-success' : 'bg-danger' }}">
                        {{ $out->stock_actuel }} {{ $out->unite }}
                        </span>
                    </td>
                    <td>{{ $out->category?->name ?? '—' }} </td>
                    {{-- php artisan storage:link --}}
                    {{-- <td>
                        <p>Image: {{ $out->author->image }}</p>
                        <p>URL: {{ $out->author->image_url }}</p>
                        <img src="{{ $out->author->image_url }}" width="60">
                    </td> --}}
                    <td>
                        @if ($out->author && $out->author->image)
                            <img
                                src="{{ $out->author->image_url }}"
                                class="media-avatar rounded-circle"
                                alt="{{ $out->author->name }}"
                                style="width: 40px; height: 40px; object-fit: cover;"
                            >
                        @else
                            <div style="width: 40px; height: 40px; background: #ddd; border-radius: 50%;"></div>
                        @endif
                    </td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('outil.show', $out->slug) }}" class="showRow">
                                <i class="bi bi-eye text-primary"></i>
                            </a>
                        <!-- Bouton Edit -->
                        <a href="{{ route('outil.edit', $out->slug) }}" class="editRow">
                            <i class="bi bi-pencil text-green"></i>
                        </a>
                        <a href="#" class="deleteRow" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $out->id }}">
                            <i class="bi bi-trash text-red"></i>
                        </a>
                        </div>
                        <div class="modal fade" id="confirmDeleteModal{{ $out->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $out->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header bg-white text-secondary">
                                    <h5 class="modal-title" id="modalLabel{{ $out->id }}">Confirmer la suppression</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer <strong>{{ $out->title }}</strong> ?
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('outil.destroy', $out->slug) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> <!-- table-responsive -->
        </div> <!-- card-body -->
      </div> <!-- card -->
    </div>
  </div>
</div>
@endsection