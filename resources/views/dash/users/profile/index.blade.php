@extends('layouts.app')

@section('title', 'Dashboard - Profile')

@section('dash-header')

@endsection

@section('content')
<div class="profile-header">
    <div class="row">
        <div class="col-sm-12 col-12">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status')}}</div>
            @endif
            <div class="profile-header">
                <h1>Welcome, {{\Illuminate\Support\Facades\Auth::user()->first_name}}</h1>
                <div class="profile-header-content">
                <div class="profile-header-tiles">
                    <div class="row">
                    <div class="col-sm-4 col-12">
                        <div class="profile-tile">
                        <span class="icon">
                            <i class="bi bi-pentagon"></i>
                        </span>
                        <h6>Name - <span>{{\Illuminate\Support\Facades\Auth::user()->first_name}}</span></h6>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="profile-tile">
                        <span class="icon">
                            <i class="bi bi-pin-angle"></i>
                        </span>
                        <h6>Location - <span>Sénégal</span></h6>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="profile-tile">
                        <span class="icon">
                            <i class="bi bi-telephone"></i>
                        </span>
                        <h6>Phone - <span>{{\Illuminate\Support\Facades\Auth::user()->phone}}</span></h6>
                        </div>
                    </div>
                    </div>
                    {{-- <button class="bi bi-pencil-square" type="button" data-bs-toggle="modal" data-bs-target="#editModal" ></button> --}}
                </div>
                <div class="profile-avatar-tile">
                    {{-- <img src="{{ asset('assets/profile/'.\Illuminate\Support\Facades\Auth::user()->image)}}" class="img-fluid" alt="Bootstrap Gallery" /> --}}
                    <img src="{{ Auth::user()->image_url }}" class="img-fluid" alt="Image de profil">
                    {{-- <img src="assets/images/user.png" class="img-fluid" alt="Bootstrap Gallery" /> --}}
                </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    {{-- Colonne gauche : Activité --}}
    <div class="col-lg-8 col-sm-12 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="card-title">Activité</div>
            </div>
            <div class="card-body">
                <div class="scroll300">
                    <div class="timeline-activity">
                        @forelse($ventesDuMois as $vente)
                            <div class="activity-log">
                                <p class="log-name">
                                    Vente de {{ $vente->outil->nom ?? 'Outil inconnu' }}
                                    <small class="log-time">- {{ $vente->created_at->diffForHumans() }}</small>
                                </p>
                                <div class="log-details">
                                    Montant : {{ number_format($vente->montant, 0, ',', ' ') }} FCFA
                                    @if($vente->statut)
                                        <span class="text-success ml-1">#{{ ucfirst($vente->statut) }}</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="activity-log">
                                <p class="log-name">Aucune vente ce mois</p>
                                <div class="log-details">Aucune activité de vente enregistrée pour cet utilisateur.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Colonne droite : Stats + Formulaire (stretch height) --}}
    <div class="col-lg-4 col-sm-12 mb-4 d-flex flex-column justify-content-between">
        <div class="row g-3">
            {{-- Cartes stats --}}
            <div class="col-sm-6 col-12">
                <div class="award-tile shade-green">
                    <div class="award-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <h3>{{ $totalVentes }}</h3>
                    <h4>Total ventes</h4>
                </div>
            </div>

            <div class="col-sm-6 col-12">
                <div class="award-tile shade-blue">
                    <div class="award-icon">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h3>{{ number_format($montantTotal, 0, ',', ' ') }} </h3>
                    <p>FCFA</p>
                    <h4>Montant total</h4>
                </div>
            </div>

            {{-- Formulaire changement de mot de passe --}}
            <div class="col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">Changer le mot de passe</div>
                    </div>
                    <div class="card-body">
                        {{-- Erreurs --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulaire --}}
                        <form action="{{ route('user.password.update') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="currentPwd" class="form-label">Mot de passe actuel <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" id="currentPwd" class="form-control" required placeholder="Mot de passe actuel">
                            </div>

                            <div class="mb-3">
                                <label for="newPwd" class="form-label">Nouveau mot de passe <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="newPwd" class="form-control" required placeholder="Nouveau mot de passe">
                                <div class="form-text">Doit contenir au moins 8 caractères.</div>
                            </div>

                            <div class="mb-3">
                                <label for="confirmPwd" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="confirmPwd" class="form-control" required placeholder="Confirmation">
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-shield-lock me-1"></i> Modifier le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Fin .row -->


</div>


@endsection