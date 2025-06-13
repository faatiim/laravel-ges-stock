@extends('layouts.app')

@section('title', 'Erreur serveur')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-8 text-center">
    <div class="card p-4 shadow-lg border-0">
      <div class="card-body">
        <h1 class="display-1 text-danger">500</h1>
        <h3 class="mb-3">Erreur interne du serveur</h3>
        <p class="mb-4 text-muted">
          Une erreur inattendue est survenue.<br>
          Veuillez réessayer plus tard ou contacter l’administrateur.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
          <i class="bi bi-arrow-clockwise me-1"></i> Réessayer
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
