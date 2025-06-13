@extends('layouts.app')

@section('title', 'Dashboard - Déclaration de vente')

@section('content')   
<!-- Content wrapper start -->
<div class="content-wrapper">

    <!-- Row start -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Créer une Vente</h5>
                </div>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Erreur !</strong> Veuillez corriger les champs suivants :
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                

                <!-- Ton formulaire START -->
                <form action="{{ route('ventes.store') }}" method="POST">
                    @csrf

                    <div class="create-invoice-wrapper">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <!-- Row start -->
                                <div class="row">
                                    <div class="col-sm-6 col-12">
                                        <!-- Form group start -->
                                        <div class="mb-2">
                                            <label for="moyen_paiement" class="form-label">Moyen de Paiement</label>
                                            <select name="moyen_paiement" id="moyen_paiement" class="form-select">
                                                <option value="cash">Espèces</option>
                                                <option value="wave">Wave</option>
                                                <option value="orangeMoney">Orange Money</option>
                                                <option value="card">Carte Bancaire</option>
                                                <option value="bank">Virement Bancaire</option>
                                                <option value="">--Autre mode de paiement --</option>
                                            </select>
                                        </div>
                                        <!-- Form group end -->
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                            <div class="col-sm-6 col-12">
                                <!-- Row start -->
                                <div class="row">
                                    <div class="col-sm-6 col-12">
                                        <!-- Form group date de vente -->
                                        <div class="mb-2">
                                            <label for="date_paiement" class="form-label">Date de la Vente</label>
                                            <input type="date" name="date_paiement" id="date_paiement" class="form-control" value="{{ now()->format('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- Row end -->
                    </div>

                    <!-- Row start -->
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table truncate table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="7" class="pt-3 pb-3">
                                                Outils
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Type de Vente</th>
                                            <th>Outil vendu</th>
                                            <th>Quantité</th>
                                            <th>Prix Unitaire</th>
                                            <th>Montant (Net)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody id="ligne_ventes">
                                        <tr>
                                            <td>
                                                <select name="lignes[0][mode_vente]" class="form-select mode-vente-select" required>
                                                  <option value="physique">Unité (sac, carton...)</option>
                                                  <option value="logique">Détail (kg, L...)</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="lignes[0][outil_id]" class="form-select outil-select" required>
                                                    <option value="">-- Sélectionner un outil --</option>
                                                    @foreach ($outils as $outil)
                                                        <option value="{{ $outil->id }}" data-prix="{{ $outil->prix_unitaire }}">{{ $outil->title }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                                                    {{-- C’est pourquoi la validation échoue silencieusement et bloque le submit. ➡️ Il faut que tes name respectent bien la structure lignes[0][outil_id], lignes[0][quantite], etc. --}}
                                            <td>                    <!-- a cause de request on change name="quantite[]" par ça-->
                                                <input type="number" step="any" name="lignes[0][quantite]" class="form-control quantite-input" min="1" value="1" required>
                                            </td>
                                    
                                            <td>
                                                <input type="text" class="form-control prix-unitaire-input" readonly>
                                                <input type="hidden" name="lignes[0][prix_unitaire]" class="prix-unitaire-hidden">
                                            </td>
                                    
                                            <td>
                                                <input type="text" class="form-control prix-total-input" readonly>
                                                <input type="hidden" name="lignes[0][prix_total]" class="prix-total-hidden">
                                            </td>
                                    
                                            <td>
                                                <button type="button" class="btn btn-outline-danger supprimer-ligne">
                                                    <i class="bi bi-trash m-0"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-secondary" id="ajouter-ligne">
                                    Ajouter une ligne
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->

                    <!-- Footer start -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Créer la Vente</button>
                            </div>
                        </div>
                    </div>
                    <!-- Footer end -->
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->

</div>

<!-- Content wrapper end -->


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lignes = document.getElementById('ligne_ventes');
        const boutonAjouter = document.getElementById('ajouter-ligne');

        function recalculerMontant(tr) {
            const quantiteInput = tr.querySelector('.quantite-input');
            const prixUnitaireInput = tr.querySelector('.prix-unitaire-input');
            const prixTotalInput = tr.querySelector('.prix-total-input');
            const hiddenPrixUnitaire = tr.querySelector('.prix-unitaire-hidden');
            const hiddenPrixTotal = tr.querySelector('.prix-total-hidden');

            const quantite = parseFloat( tr.querySelector('.quantite-input').value ) || 0;
            const prix     = parseFloat( tr.querySelector('.prix-unitaire-input').value ) || 0;
            const total    = prix * quantite;

            // On affiche avec 2 décimales
            tr.querySelector('.prix-total-input').value     = total.toFixed(2);
            tr.querySelector('.prix-unitaire-hidden').value = prix.toFixed(2);
            tr.querySelector('.prix-total-hidden').value    = total.toFixed(2);
            // const prix = parseFloat(prixUnitaireInput.value) || 0;
            // const quantite = parseInt(quantiteInput.value) || 0;
            // const total = prix * quantite;

            // prixTotalInput.value = total.toFixed(0);
            // hiddenPrixUnitaire.value = prix.toFixed(0);
            // hiddenPrixTotal.value = total.toFixed(0);
        }

        function reindexerLignes() {
            const rows = lignes.querySelectorAll('tr');
            rows.forEach((tr, index) => {
                const quantiteInput = tr.querySelector('.quantite-input');
                const outilSelect = tr.querySelector('.outil-select');
                const modeVenteSelect = tr.querySelector('.mode-vente-select');
                if (quantiteInput) quantiteInput.setAttribute('name', `lignes[${index}][quantite]`);
                if (outilSelect) outilSelect.setAttribute('name', `lignes[${index}][outil_id]`);
                if (modeVenteSelect) modeVenteSelect.setAttribute('name', `lignes[${index}][mode_vente]`);
            });
        }

        function mettreAJourOptionsOutils() {
            const allSelects = document.querySelectorAll('.outil-select');

            // Collecter les outils déjà utilisés avec leurs modes
            const utilisations = {}; // { outil_id: Set(modes) }

            allSelects.forEach(select => {
                const tr = select.closest('tr');
                const outilId = select.value;
                const mode = tr.querySelector('.mode-vente-select')?.value;

                if (outilId && mode) {
                    if (!utilisations[outilId]) {
                        utilisations[outilId] = new Set();
                    }
                    utilisations[outilId].add(mode);
                }
            });

            // Parcourir à nouveau chaque <select> pour cacher les options invalides
            allSelects.forEach(select => {
                const tr = select.closest('tr');
                const currentOutil = select.value;
                const currentMode = tr.querySelector('.mode-vente-select')?.value;

                Array.from(select.options).forEach(option => {
                    const outilId = option.value;
                    if (!outilId) return;

                    const modesUtilises = utilisations[outilId] || new Set();
                    const isSameLine = currentOutil === outilId;

                    // On cache si l’outil est déjà sélectionné dans 2 modes OU déjà dans ce mode (hors ligne courante)
                    const doitCacher = !isSameLine && (
                        (modesUtilises.has("physique") && modesUtilises.has("logique")) ||
                        (currentMode && modesUtilises.has(currentMode))
                    );

                    option.hidden = doitCacher;
                });
            });
        }

        // Lorsqu’on change un outil
        lignes.addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('outil-select')) {
                const tr = e.target.closest('tr');
                const selectedOption = e.target.options[e.target.selectedIndex];
                const prix = selectedOption.getAttribute('data-prix') || 0;

                const prixUnitaireInput = tr.querySelector('.prix-unitaire-input');
                prixUnitaireInput.value = prix;

                recalculerMontant(tr);
                mettreAJourOptionsOutils();
            }

            if (e.target && e.target.classList.contains('mode-vente-select')) {
                mettreAJourOptionsOutils();
            }
        });

        // Lorsqu’on modifie une quantité
        lignes.addEventListener('input', function (e) {
            if (e.target && e.target.classList.contains('quantite-input')) {
                const tr = e.target.closest('tr');
                recalculerMontant(tr);
            }
        });

        // Suppression de ligne
        lignes.addEventListener('click', function (e) {
            if (e.target.closest('.supprimer-ligne')) {
                e.target.closest('tr').remove();
                reindexerLignes();
                mettreAJourOptionsOutils();
            }
        });

        // Ajouter une nouvelle ligne
        boutonAjouter.addEventListener('click', function () {
            const premiereLigne = lignes.querySelector('tr');
            const nouvelleLigne = premiereLigne.cloneNode(true);

            // Réinitialiser les champs
            nouvelleLigne.querySelector('.outil-select').value = '';
            nouvelleLigne.querySelector('.mode-vente-select').value = '';
            nouvelleLigne.querySelector('.quantite-input').value = 1;
            nouvelleLigne.querySelector('.prix-unitaire-input').value = '';
            nouvelleLigne.querySelector('.prix-total-input').value = '';
            nouvelleLigne.querySelector('.prix-unitaire-hidden').value = '';
            nouvelleLigne.querySelector('.prix-total-hidden').value = '';

            lignes.appendChild(nouvelleLigne);
            reindexerLignes();
            mettreAJourOptionsOutils();
        });

        mettreAJourOptionsOutils(); // init
    });
</script>



{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const lignes = document.getElementById('ligne_ventes');
        const boutonAjouter = document.getElementById('ajouter-ligne');
    
        function recalculerMontant(tr) {
            const quantiteInput = tr.querySelector('.quantite-input');
            const prixUnitaireInput = tr.querySelector('.prix-unitaire-input');
            const prixTotalInput = tr.querySelector('.prix-total-input');
            const hiddenPrixUnitaire = tr.querySelector('.prix-unitaire-hidden');
            const hiddenPrixTotal = tr.querySelector('.prix-total-hidden');
    
            const prix = parseFloat(prixUnitaireInput.value) || 0;
            const quantite = parseInt(quantiteInput.value) || 0;
            const total = prix * quantite;
    
            prixTotalInput.value = total.toFixed(0);
            hiddenPrixUnitaire.value = prix.toFixed(0);
            hiddenPrixTotal.value = total.toFixed(0);
        }
    
        function reindexerLignes() {
            const rows = lignes.querySelectorAll('tr');
            rows.forEach((tr, index) => {
                const quantiteInput = tr.querySelector('.quantite-input');
                const outilSelect = tr.querySelector('.outil-select');
                if (quantiteInput) quantiteInput.setAttribute('name', `lignes[${index}][quantite]`);
                if (outilSelect) outilSelect.setAttribute('name', `lignes[${index}][outil_id]`);
            });
        }
    
        function mettreAJourOptionsOutils() {
            const allSelects = document.querySelectorAll('.outil-select');
            const outilsUtilises = new Set();
    
            // 1. Collecter tous les outils déjà choisis
            allSelects.forEach(select => {
                const val = select.value;
                if (val) {
                    outilsUtilises.add(val);
                }
            });
    
            // 2. Parcourir les <select> pour cacher ceux déjà sélectionnés ailleurs
            allSelects.forEach(select => {
                const currentValue = select.value;
    
                Array.from(select.options).forEach(option => {
                    if (!option.value) return;
                    option.hidden = (option.value !== currentValue && outilsUtilises.has(option.value));
                });
            });
        }
    
        // Lorsqu’on change un outil
        lignes.addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('outil-select')) {
                const tr = e.target.closest('tr');
                const selectedOption = e.target.options[e.target.selectedIndex];
                const prix = selectedOption.getAttribute('data-prix') || 0;
    
                const prixUnitaireInput = tr.querySelector('.prix-unitaire-input');
                prixUnitaireInput.value = prix;
    
                recalculerMontant(tr);
                mettreAJourOptionsOutils(); // mettre à jour les autres selects
            }
        });
    
        // Lorsqu’on modifie une quantité
        lignes.addEventListener('input', function (e) {
            if (e.target && e.target.classList.contains('quantite-input')) {
                const tr = e.target.closest('tr');
                recalculerMontant(tr);
            }
        });
    
        // Suppression de ligne
        lignes.addEventListener('click', function (e) {
            if (e.target.closest('.supprimer-ligne')) {
                e.target.closest('tr').remove();
                reindexerLignes();
                mettreAJourOptionsOutils();
            }
        });
    
        // Ajouter une nouvelle ligne
        boutonAjouter.addEventListener('click', function () {
            const premiereLigne = lignes.querySelector('tr');
            const nouvelleLigne = premiereLigne.cloneNode(true);
    
            // Réinitialiser les champs
            nouvelleLigne.querySelector('.outil-select').value = '';
            nouvelleLigne.querySelector('.quantite-input').value = 1;
            nouvelleLigne.querySelector('.prix-unitaire-input').value = '';
            nouvelleLigne.querySelector('.prix-total-input').value = '';
            nouvelleLigne.querySelector('.prix-unitaire-hidden').value = '';
            nouvelleLigne.querySelector('.prix-total-hidden').value = '';
    
            lignes.appendChild(nouvelleLigne);
            reindexerLignes();
            mettreAJourOptionsOutils();
        });
    
        // Appeler ça au début pour bien filtrer dès la 1re ligne (utile si formulaire réaffiché avec erreurs)
        mettreAJourOptionsOutils();
    });
</script> --}}
    


@endsection


