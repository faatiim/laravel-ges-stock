@extends('layouts.app')

@section('title', 'Dashboard - Facture')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">

          {{-- En-tête entreprise --}}
          <div class="row gx-3 align-items-center">
            <div class="col-sm-2 col-12">
              <a href="{{ route('dashboard') }}" class="loogoo">
                <img src="{{ asset('assets/images/stockin.jpg') }}" alt="Admin Dashboards">
              </a>
            </div>
            <div class="col-sm-10 col-12 text-end">
              <p class="m-0">Ta Quincaillerie, 5678 Rue du Commerce<br>Dakar, Sénégal</p>
            </div>
          </div>

          {{-- Infos client / facture --}}
          <div class="row mt-4">
            <div class="col-12 d-flex justify-content-between">
              <div>
                <p class="m-0">{{ $vente->user->name }},</p>
                <p class="m-0">Matricule : {{ $vente->user->reference }}</p>
              </div>

              <div>
                <p class="m-0">Facture - #{{ $vente->facture_numero }}</p>
                <p class="m-0">{{ $vente->created_at->format('d M Y') }}</p>
                <span class="badge bg-success">Payée</span>
              </div>
            </div>
          </div>

          {{-- Tableau des détails --}}
          <div class="row mt-4">
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-bordered truncate">
                  <thead>
                    <tr>
                      <th>Désignation</th>
                      <th>Référence</th>
                      <th>Quantité</th>
                      <th>Mode Paiement</th>
                      <th>Prix Unitaire</th>
                      <th>Montant</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($vente->ligneVentes as $ligneVente)
                    <tr>
                      <td><h5 class="mb-1">{{ $ligneVente->outil->title }}</h5></td>
                      <td>#{{ $ligneVente->outil->reference }}</td>
                      <td>{{ $ligneVente->quantite }}</td>
                      <td>
                        {{ $ligneVente->quantite }}
                        @if($ligneVente->mode_vente === 'physique')
                          {{ $ligneVente->outil->unite }}
                        @else
                            
                          <small class="text-muted d-block">({{ number_format($ligneVente->quantite / $ligneVente->outil->contenu_par_unite, 2) }} {{ $ligneVente->outil->unite }})</small>
                        @endif
                      </td>
                      
                      <td>{{ number_format($ligneVente->prix_unitaire, 0, ',', ' ') }} F CFA</td>
                      <td>{{ number_format($ligneVente->total, 0, ',', ' ') }} F CFA</td>
                      {{-- <td>{{ $ligneVente->quantite }} {{ $ligneVente->mode_vente === 'physique' ? $ligneVente->outil->unite : 'kg' }}</td> --}}
                    </tr>
                    @endforeach
                    <tr>
                      <td colspan="4">&nbsp;</td>
                      <td><strong>Total</strong></td>
                      <td><strong>{{ number_format($vente->total, 0, ',', ' ') }} F CFA</strong></td>
                    </tr>
                    <tr>
                      <td colspan="5">
                        <h6 class="text-danger">NOTES</h6>
                        <small>Merci pour votre achat. Pour toute information complémentaire, contactez-nous.</small>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          {{-- Boutons actions --}}
          <div class="row mt-4">
            <div class="col-12 text-end">
              {{-- <a href="{{ route('ventes.facture', $vente) }}" class="btn btn-dark">Télécharger PDF</a> --}}

              <a href="{{ route('ventes.facture', $vente) }}" class="btn btn-light">Télécharger PDF</a>
              <button onclick="window.print()" class="btn btn-outline-secondary"><i class="bi bi-printer"></i>Imprimer</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection




