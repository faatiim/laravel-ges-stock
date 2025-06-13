@extends('layouts.app')

@section('title','Gérer les utilisateurs')

@section('content')

<!-- Row start -->
<div class="row">
  <div class="col-sm-12 col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Utilisateurs</h5>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table truncate v-middle m-0" id="searchable-table">
            <thead>
              <tr>
                <th></th>
                <th>Réf.</th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Status</th>
                <th>Dernière connexion</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)   
              <tr>
                <td>
                  <div class="media-box">
                     <img src="{{ $user->image_url }}"
                      class="media-avatar rounded-circle"
                      alt="{{ $user->full_name ?? $user->username }}"
                      style="width: 60px; height: 60px; object-fit: cover;"> 
                      
                  </div>
                </td>
                <td>#{{ $user->user_ref  ?? '—'}}</td>
                <td>{{ $user->first_name  ?? '—'}} {{ $user->last_name }}</td>
                <td>{{ $user->email ?? '—' }}</td>
                <td>
                  @if($user->isOnline())
                      <span class="badge bg-success">En ligne</span>
                  @else
                      <span class="badge bg-secondary">Hors ligne</span>
                  @endif          
                </td>
                <td>
                  @if($user->last_login_at)
                    {{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}
                  @else
                    <span class="text-muted">Pas encore connecté</span>
                  @endif
                </td>
                <td>
                  <div class="actions">
                    <a href="#" class="editRow" data-bs-toggle="modal" data-bs-target="#addRow">
                      <i class="bi bi-pencil text-green"></i>
                    </a>
                    <a href="{{ route('users.show', $user->id) }}" class="editRow" >
                        <i class="bi bi-eye text-info"></i>
                    </a>
                     <a href="#" class="deleteRow" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                      <i class="bi bi-trash text-red"></i>
                    </a>
                    {{-- <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}"> 
                      <i class="fa fa-trash"></i> Supprimer
                    </button>--}}
                    
                    <!-- Modal -->
                    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">Confirmer la suppression</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                          </div>
                          <div class="modal-body">
                            Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                          </div>
                          <div class="modal-footer">
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
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
        </div>
      </div>

    </div>
  </div>
</div>
<!-- Row end -->

@endsection
