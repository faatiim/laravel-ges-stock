@extends('layouts.app')

@section('title','Dashboard - ventes')
    
@section('content')

<div class="content-wrapper">

      <!-- Row start -->
    <div class="row">
        <div class="col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                        <div class="container py-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1 class="h3">Liste des Ventes</h1>
                                <a href="{{ route('ventes.create') }}" class="btn btn-primary">
                                    Nouvelle Vente
                                </a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($ventes->count())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle" id="searchable-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Numéro Facture</th>
                                                <th>Effectué par</th>
                                                <th>Moyen de Paiement</th>
                                                <th>Total</th>
                                                <th>Date Vente</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ventes as $vente)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $vente->facture_numero }}</td>
                                                    <td>{{ $vente->user?->name ?? 'Utilisateur inconnu' }}</td>
                                                    {{-- <td>{{ $vente->user?->first_name ? $vente->user->name : 'Utilisateur inconnu' }}</td> --}}
                                                    <td>{{ ucfirst($vente->moyen_paiement) }}</td>
                                                    <td>{{ number_format($vente->total, 0, ',', ' ') }} FCFA</td>
                                                    <td>{{ $vente->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>                    

                                                        <a href="{{ route('ventes.show', $vente) }}" class="btn btn-outline-info btn-rounded">

                                                        {{-- <a href="" class="btn btn-info btn-sm"> --}}
                                                                Voir Facture
                                                        </a>
                                                        {{-- <form action="{{ route('vente.destroy', $vente) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette vente ?')"> --}}

                                                        <form action="" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette vente ?')">
                                                                @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-rounded">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Pagination --}}
                                <div class="mt-4">
                                    {{ $ventes->links() }}
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Aucune vente enregistrée pour le moment.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection