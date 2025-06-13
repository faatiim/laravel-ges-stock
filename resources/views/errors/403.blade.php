@extends('layouts.app')

@section('title', 'Accès refusé')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-8 text-center">
    <div class="card p-4 shadow-lg border-0">
      <div class="card-body">
        <h1 class="display-1 text-danger">403</h1>
        <h3 class="mb-3">Accès refusé</h3>
        <p class="mb-4 text-muted">
          Vous n'avez pas la permission d'accéder à cette page.<br>
          Ce contenu est réservé aux utilisateurs avec le rôle <strong>admin</strong>.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
          <i class="bi bi-arrow-left-circle me-1"></i> Retour au tableau de bord
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
