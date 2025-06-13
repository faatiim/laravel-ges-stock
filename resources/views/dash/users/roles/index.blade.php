@extends('layouts.app')

@section('title','Gérer les rôles')

@section('content')
<div class="row">
  <!-- Formulaire d'ajout/modification -->
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header">
        <h5 class="card-title"> {{ isset($editRole) ? 'Modifier le rôle' : 'Créer un nouveau rôle' }}</h5>
      </div>
      <div class="card-body">
        {{-- erreur pour tout le form --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="roleForm" action=" {{ isset($editRole) ? route('roles.update', $editRole->id) : route('roles.store') }}" method="POST">
           @csrf
           @if(isset($editRole))
             @method('PUT')
           @endif

          <div class="mb-3">
            <label for="name" class="form-label">Nom du rôle</label>
            <input type="text" name="name" id="name" class="form-control  error('name') is-invalid  enderror" placeholder="Ex: administrateur" value=" {{ old('name', $editRole->name ?? '') }}" required>
             @error('name')
              <div class="invalid-feedback"> {{ $message }}</div>
             @enderror
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-success"> {{ isset($editRole) ? 'Mettre à jour' : 'Créer' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Sélection des permissions -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Permissions assignées</h5>
      </div>
      <div class="card-body">
        <div class="row">
          {{-- erreur si permission vide --}}
          {{--faire ou request dans le controller
           @if(!empty($permissions))
            @foreach($permissions as $perm)

            @endforeach
          @else
            <p class="text-muted">Aucune permission disponible.</p>
          @endif --}}

           @foreach($permissions as $perm)
            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="permissions[]" value=" {{ $perm->id }}" id="perm_ {{ $perm->id }}"
                   @if(isset($editRole) && $editRole->permissions->contains($perm->id)) checked  @endif form="roleForm">
                <label class="form-check-label" for="perm_ {{ $perm->id }}"> {{ $perm->name }}</label>
              </div>
            </div>
           @endforeach
        </div>
        
        {{-- @error('permissions')
        <div class="text-danger mt-2">{{ $message }}</div>
        @enderror --}}
      </div>
    </div>
  </div>
</div>

<!-- Liste des rôles -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Liste des rôles</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Roles</th>
                <th>Créé le</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
               @foreach ($roles as $role)
              <tr>
                <td> {{ $role->id }}</td>
                <td> {{ $role->name }}</td>
                {{-- <td> {{ $role->permissions?->name ?? '—' }} </td> --}}
                {{-- utiliser pluck()->implode() ou une boucle @foreach pour afficher des relations many-to-many (comme les permissions d’un role) est une manière propre et professionnelle de le faire en Laravel Blade. --}}
                <td>  @if ($role->permissions->isNotEmpty())
                        @foreach ($role->permissions as $permission)
                            <span class="badge bg-secondary">{{ $permission->name }}</span>
                        @endforeach
                    @else
                        —
                    @endif
                </td>
                <td> {{ $role->created_at->format('d/m/Y') }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <a href=" {{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal{{ $role->id }}">
                      <i class="bi bi-trash"></i>
                    </button>
                    
                    <!-- Modal de suppression -->
                    <div class="modal fade" id="deleteRoleModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteRoleModalLabel{{ $role->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteRoleModalLabel{{ $role->id }}">Confirmer la suppression</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            Supprimer le rôle <strong>{{ $role->name }}</strong> ?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    

                  </div>
                </td>
              </tr>
               @endforeach
            </tbody>
          </table>

          <div class="mt-3">
             {{ $roles->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


 @endsection

