@extends('layouts.app')

@section('title','Dashboard - Categorie')

@section('content')
<div class="content-wrapper">

  {{-- Notifications --}}
  {{-- @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif


  <div class="row">
    <div class="col-sm-12 col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Catégories</div>
          <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addRow">
            <i class="bi bi-plus-circle text-black"></i>
          </button>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table truncate v-middle m-0" id="searchable-table">
              <thead>
                <tr>
                  <th></th>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Status</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($categories as $cat)
                <tr>
                  <td>
                    <div class="media-box">
                      <img src="{{ asset('assets/images/cat.jpg') }}" class="media-avatar" alt="Catégorie">
                      <div class="media-box-body"></div>
                    </div>
                  </td>
                  <td>{{ $cat->id }}</td>
                  <td>{{ $cat->name }}</td>
                  <td>
                    <span class="badge bg-{{ $cat->isActive ? 'success' : 'secondary' }}">
                      {{ $cat->isActive ? 'Actif' : 'Inactif' }}
                    </span>
                  </td>
                  <td>{{ $cat->description }}</td>
                  <td>
                    <div class="actions">
                      <!-- Edit -->
                      <a href="#" data-bs-toggle="modal" data-bs-target="#editModal-{{ $cat->id }}">
                        <i class="bi bi-list text-green"></i>
                      </a>
                      <!-- Delete -->
                      <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $cat->id }}">
                        <i class="bi bi-trash text-red"></i>
                      </a>
                    </div>
                  </td>
                </tr>

                {{-- Modal: Edit Category --}}
                <div class="modal fade" id="editModal-{{ $cat->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $cat->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <form action="{{ route('categories.update', $cat->slug) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Modifier Catégorie</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="name" value="{{ $cat->name }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description">{{ $cat->description }}</textarea>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="isActive" value="1" {{ $cat->isActive ? 'checked' : '' }}>
                            <label class="form-check-label">Actif</label>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Modifier</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                {{-- Modal: Delete Category --}}
                <div class="modal fade" id="deleteModal-{{ $cat->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $cat->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <form action="{{ route('categories.destroy', $cat->slug) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Confirmation de suppression</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                          Êtes-vous sûr de vouloir supprimer la catégorie <strong>{{ $cat->name }}</strong> ?
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-danger">Supprimer</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal: Add Category --}}
<div class="modal fade" id="addRow" tabindex="-1" aria-labelledby="addRowLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('categories.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajouter une catégorie</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description"></textarea>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="isActive" value="1" checked>
            <label class="form-check-label">Actif</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Ajouter</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
