@extends('layouts.app')

@section('title','Gérer les permissions')

@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
  </div>
@endif

<!-- Formulaire d'ajout -->

<!-- Row start -->
<div class="row">
  <!-- Col gauche : Formulaire d'ajout -->
  <div class="col-sm-6 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Ajouter une permission</div>
      </div>
      <div class="card-body">
        <form action="{{ route('permissions.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Nom de la permission</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="ex: edit_user" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-actions-footer">
            <button type="reset" class="btn btn-light">Effacer</button>
            <button type="submit" class="btn btn-success">Créer</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Col droite : Accordéon des permissions -->
  <div class="col-sm-6 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Liste des permissions</div>
      </div>
      <div class="card-body">
        <div class="accordion" id="accordionPermissions">
          @foreach($permissions as $perm)
            <div class="accordion-item mb-2">
              <h2 class="accordion-header" id="heading{{ $perm->id }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $perm->id }}" aria-expanded="false"
                        aria-controls="collapse{{ $perm->id }}">
                  {{ $perm->name }}
                </button>
              </h2>
              <div id="collapse{{ $perm->id }}" class="accordion-collapse collapse"
                   aria-labelledby="heading{{ $perm->id }}" data-bs-parent="#accordionPermissions">
                <div class="accordion-body">
                  <!-- Formulaire de mise à jour -->
                  <form action="{{ route('permissions.update', $perm->id) }}" method="POST" class="row g-2">
                    @csrf
                    @method('PUT')
                    <div class="col-9">
                      <input type="text" name="name" class="form-control" value="{{ $perm->name }}" required>
                    </div>
                    <div class="col-3 text-end">
                      <button type="submit" class="btn btn-success btn-sm w-60">
                        <i class="bi bi-check2"></i>
                      </button>
                    </div>
                  </form>
                  <!-- Bouton pour ouvrir le modal de suppression -->
                  <div class="text-end mt-2">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePermissionModal{{ $perm->id }}">
                      <i class="bi bi-trash"></i> 
                    </button>
                  </div>


                  {{-- <!-- Formulaire de suppression -->
                  <form action="{{ route('permissions.destroy', $perm->id) }}" method="POST"
                        class="text-end mt-2" onsubmit="return confirm('Confirmer la suppression ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                      <i class="bi bi-trash"></i> Supprimer
                    </button>
                  </form> --}}
                 
                  
                  <!-- Modal de confirmation de suppression -->
                  <div class="modal fade" id="deletePermissionModal{{ $perm->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $perm->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content border-danger">
                        <div class="modal-header bg-white text-red">
                          <h5 class="modal-title bi bi-trash " id="deleteModalLabel{{ $perm->id }}">Confirmer la suppression</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                          Êtes-vous sûr de vouloir supprimer la permission <strong>"{{ $perm->name }}"</strong> ?
                        </div>
                        <div class="modal-footer">
                          <form action="{{ route('permissions.destroy', $perm->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                            {{-- <button type="submit" class="btn btn-danger">Supprimer</button> --}}
                          </form>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
          {{ $permissions->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Row end -->



@endsection
