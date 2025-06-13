@extends('layouts.app')

@section('title', 'Détail de l’utilisateur')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Détail de l’utilisateur</h5>
        {{-- <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
          <i class="bi bi-arrow-left"></i> Retour
        </a> --}}
            <div class="text-end">
              <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Retour à la liste</a>
            </div>
      </div>

      <div class="card-body">
        <div class="row align-items-center">
          {{-- Infos à gauche --}}
          <div class="col-md-9">
            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Nom complet :</div>
              <div class="col-sm-8">{{ $user->first_name }} {{ $user->last_name ?? '—'}} </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Rôle :</div>
              <div class="col-sm-8">{{ $user->roles->first()?->name ?? '—' }}</div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Nom d’utilisateur :</div>
              <div class="col-sm-8">{{ $user->username ?? '—'}}</div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Email :</div>
              <div class="col-sm-8">{{ $user->email ?? '—'}}</div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Téléphone :</div>
              <div class="col-sm-8">{{ $user->phone ?? '—'}}</div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Adresse :</div>
              <div class="col-sm-8">{{ $user->address ?? '—' }}</div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Statut :</div>
              <div class="col-sm-8">
                  {{-- @php
                  $isOnline = $user->last_login_at && \Carbon\Carbon::parse($user->last_login_at)->gt(now()->subMinutes(1));
                @endphp --}}
{{-- 
            
                <span class="badge min-70 {{ $user->is_online ? 'shade-green' : 'shade-red' }}">
                  {{ $user->is_online ? 'En ligne' : 'Hors ligne' }}
                </span> --}}

                    @if($user->isOnline())
                        <span class="badge bg-success">En ligne</span>
                    @else
                        <span class="badge bg-secondary">Hors ligne</span>
                    @endif


              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Dernière connexion :</div>
              <div class="col-sm-8">
                @if($user->last_login_at)
                  {{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}
                @else
                  <span class="text-muted">Pas encore connecté</span>
                @endif
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4 fw-bold">Ajouté le :</div>
              <div class="col-sm-8">
                @if($user->created_at)
                  {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}
                @else
                  <span class="text-muted">--</span>
                @endif
              </div>
            </div>

            
          </div>

          {{-- Photo à droite --}}
          <div class="col-md-3 text-center">
            <img src="{{ $user->image_url }}"
                 alt="{{ $user->first_name }}"
                 class="rounded-circle mb-3"
                 style="width: 150px; height: 150px; object-fit: cover;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


{{-- @extends('layouts.app')

@section('title', 'Détail de l’utilisateur')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Détail de l’utilisateur</h5>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
          <i class="bi bi-arrow-left"></i> Retour
        </a>
      </div>
      <div class="card-body">
        <div class="text-center mb-4">
          {{-- <img src="{{ asset('storage/avatars/' . $user->image) }}" --
          <img src="{{ $user->image_url }}"
               alt="{{ $user->first_name }}"
               class="rounded-circle"
               style="width: 120px; height: 120px; object-fit: cover;">
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Nom complet :</strong></div>
          <div class="col-md-6">{{ $user->first_name }} {{ $user->last_name }}</div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Rôle :</strong></div>
          <div class="col-md-6">{{ $user->roles->first()?->name ?? '—' }} </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Nom d’utilisateur :</strong></div>
          <div class="col-md-6">{{ $user->username }}</div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Email :</strong></div>
          <div class="col-md-6">{{ $user->email }}</div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Téléphone :</strong></div>
          <div class="col-md-6">{{ $user->phone }}</div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Adresse :</strong></div>
          <div class="col-md-6">{{ $user->address ?? '—' }}</div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Status :</strong></div>
          <div class="col-md-6">
            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
              {{ $user->is_active ? 'En ligne' : 'Hors ligne' }}
            </span>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6"><strong>Dernière connexion :</strong></div>
          <div class="col-md-6">
            @if($user->last_login_at)
              {{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}
            @else
              <span class="text-muted">Pas encore connecté</span>
            @endif
          </div>
        </div>

        <div class="text-end">
          <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Retour à la liste</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}
