@extends('partials.layout_pdf')

@section('title', 'Facture - Vente N°' . $vente->numero_facture)

@section('pdf')
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }
    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }
    .left {
        float: left;
        width: 50%;
    }
    .right {
        float: right;
        width: 50%;
        text-align: right;
    }
    .mt-4 { margin-top: 1.5rem; }
    .mt-5 { margin-top: 3rem; }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 6px;
        text-align: left;
    }
    
</style>

<div class="clearfix">
    {{-- <div class="left">
        <img src="{{ public_path('assets/images/stock.jpg') }}" alt="Logo" style="max-height: 60px;">
    </div> --}}
    <div class="sidebar-bran">
      <a class="loogoo">
        <img src="{{ public_path('assets/images/stock.jpg') }}" alt="logo" style="max-height: 60px;">
      </a>
    </div>
    <div class="right">
        <p>
            Quincaillerie, Rue Exemple 123<br>
            Dakar, Sénégal<br>
            Téléphone: +221 77 000 00 00
        </p>
    </div>
</div>

<div class="clearfix mt-4">
    <div class="left">
        {{-- <h4>Client :</h4> --}}
        <p>
            {{ $vente->user->full_name }}<br>
            Email: {{ $vente->user->email ?? '-' }}
        </p>
    </div>
    <div class="right">
        <p><strong>Facture N° :</strong> {{ $vente->facture_numero }}</p>
        <p><strong>Date :</strong> {{ $vente->created_at->format('d/m/Y') }}</p>
    </div>
</div>

<!-- Tableau des produits -->
<table>
    <thead>
        <tr>
            <th>Outil</th>
            <th>Quantité</th>
            <th>Prix Unitaire</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vente->ligneVentes as $ligneVente)
            <tr>
                <td>{{ $ligneVente->outil->title ?? '-' }}</td>
                <td>{{ $ligneVente->quantite }}</td>
                <td>{{ number_format($ligneVente->prix_unitaire, 0, ',', ' ') }} F CFA</td>
                <td>{{ number_format($ligneVente->total, 0, ',', ' ') }} F CFA</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"></td>
            <td><strong>Total Général :</strong></td>
            <td><strong>{{ number_format($vente->total, 0, ',', ' ') }} F CFA</strong></td>
        </tr>
    </tbody>
</table>

<!-- Bas de page -->
<div class="mt-5">
    <p class="text-muted" style="font-size: 11px; color: #666;">
        Merci pour votre confiance. Cette facture a été générée automatiquement par notre système.
    </p>
</div>
@endsection



{{-- @extends('partials.layout_pdf')

@section('title', 'Facture - Vente N°' . $vente->numero_facture)

@section('pdf')
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
    }
</style>


  <!-- Row starts -->
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">

          <!-- Header: Logo + Adresse -->
          <div class="row gx-3 align-items-center">
            <div class="col-sm-2 col-12">
              <img src="{{ public_path('assets/images/logo.svg') }}" alt="Logo" class="img-fluid" style="max-height: 80px;">
            </div>
            <div class="col-sm-10 col-12">
              <p class="text-end m-0">
                Votre Société, Rue Exemple 123<br>
                Dakar, Sénégal<br>
                Téléphone: +221 77 000 00 00
              </p>
            </div>
          </div>

          <!-- Infos Client et Facture -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="d-flex justify-content-between">
                <div>
                  <h6 class="mb-1">Client :</h6>
                  <p class="m-0">
                    {{ $vente->user->full_name }}<br>
                    Email: {{ $vente->user->email ?? '-' }}
                  </p>
                </div>
                <div>
                  <p class="m-0"><strong>Facture N°:</strong> {{ $vente->facture_numero }}</p>
                  <p class="m-0"><strong>Date:</strong> {{ $vente->created_at->format('d/m/Y') }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Table Produits -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="table-light">
                    <tr>
                      <th>Outil</th>
                      <th>Quantité</th>
                      <th>Prix Unitaire</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($vente->ligneVentes as $ligneVente)
                      <tr>
                        <td>{{ $ligneVente->outil->title ?? '-' }}</td>
                        <td>{{ $ligneVente->quantite }}</td>
                        <td>{{ number_format($ligneVente->prix_unitaire, 0, ',', ' ') }} F CFA</td>
                        <td>{{ number_format($ligneVente->total, 0, ',', ' ') }} F CFA</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="2"></td>
                      <td><strong>Total Général :</strong></td>
                      <td><strong>{{ number_format($vente->total, 0, ',', ' ') }} F CFA</strong></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Note de bas de page -->
          <div class="row mt-5">
            <div class="col-12">
              <p class="text-muted small">
                Merci pour votre confiance. Cette facture a été générée automatiquement par notre système.
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>


@endsection
 --}}
