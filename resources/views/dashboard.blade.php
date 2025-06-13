@extends('Layouts.app')

@section('title', 'Dashboard - Accueil')
    
@section('content')
<div class="content-wrapper">

  <!-- Row 1 : Statistiques (2 colonnes à md, 4 à lg, égales en hauteur) -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-lg-3 d-flex">
      <div class="stats-tile flex-fill">
        <div class="sale-icon shade-red"><i class="bi bi-pie-chart"></i></div>
        <div class="sale-details">
          <h5 class="text-red">{{ count($ventes) }}</h5>
          <p>Ventes</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3 d-flex">
      <div class="stats-tile flex-fill">
        <div class="sale-icon shade-blue"><i class="bi bi-emoji-smile"></i></div>
        <div class="sale-details">
          <h5 class="text-blue">{{ count($users) }}</h5>
          <p>Utilisateurs</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3 d-flex">
      <div class="stats-tile flex-fill">
        <div class="sale-icon shade-yellow"><i class="bi bi-box-seam"></i></div>
        <div class="sale-details">
          <h5 class="text-yellow">{{ count($outils) }}</h5>
          <p>Outils</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3 d-flex">
      <div class="stats-tile flex-fill">
        @if($montantTotal > 0)
          <div class="sale-icon shade-green"><i class="bi bi-handbag"></i></div>
          <div class="sale-details">
            <h5 class="text-green">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</h5>
            <p class="mb-0" style="white-space: normal; word-break: break-word;">
              Chiffre d’affaires mensuel
            </p>
          </div>
        @else
          <div class="sale-icon shade-red"><i class="bi bi-handbag"></i></div>
          <div class="sale-details">
            <h3 class="text-red">0 FCFA</h3>
            <p>Aucune vente ce mois</p>
          </div>
        @endif
      </div>
    </div>
  </div>
  <!-- Row 1 end -->

{{-- debut outils --}}

<div class="row mb-4">
  <div class="col-12">
    <div class="card h-100">
      <div class="card-header">
        <div class="card-title">Stock actuel par outil</div>
      </div>
      <div class="card-body" style="position: relative; height: 350px;">
        <canvas id="stockGraph"></canvas>
      </div>
    </div>
  </div>
</div>


 {{-- fin barre outils --}}



  <!-- Row 2 : Historique des ventes & Outil le plus/vendu -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
      <div class="card h-100">
        <div class="card-header"><div class="card-title">Historique des ventes</div></div>
        <div class="card-body">
          <div class="scroll370">
            <div class="transactions-container">
              @forelse ($ventesHistoriques as $vente)
                <div class="transaction-block">
                  <div class="transaction-icon shade-blue"><i class="bi bi-receipt"></i></div>
                  <div class="transaction-details">
                    <h4>Facture #{{ $vente->facture_numero }}</h4>
                    <p class="text-truncate">{{ $vente->created_at->format('d/m/Y H:i') }}</p>
                  </div>
                  <div class="transaction-amount text-green">{{ number_format($vente->total, 0, ',', ' ') }} FCFA</div>
                </div>
              @empty
                <div class="text-muted p-3">Aucune vente enregistrée pour le moment.</div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="card h-100">
        <div class="card-header text-center"><div class="card-title">Outil le plus vendu & moins vendu</div></div>
        <div class="card-body">
          <canvas id="outilChart" style="width:100%; max-height:250px;"></canvas>
          <ul class="task-list-container d-flex justify-content-between mt-4">
            <li class="task-list-item text-start flex-fill">
              <div class="task-icon shade-green"><i class="bi bi-arrow-up-circle"></i></div>
              <div class="task-info">
                <h5 class="task-title">Le plus vendu</h5>
                <p class="amount-spend">{{ $outilTop?->title ?? '—' }} ({{ $outilTop?->ventes_total ?? 0 }})</p>
              </div>
            </li>
            <li class="task-list-item text-end flex-fill">
              <div class="task-icon shade-red"><i class="bi bi-arrow-down-circle"></i></div>
              <div class="task-info">
                <h5 class="task-title">Le moins vendu</h5>
                <p class="amount-spend">{{ $outilBas?->title ?? '—' }} ({{ $outilBas?->ventes_total ?? 0 }})</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Row 2 end -->

  <!-- Row 3 : Notifications Stock & Activités utilisateurs -->
  <div class="row g-3">
    <div class="col-12 col-md-6">
      <div class="card h-100">
        <div class="card-header"><div class="card-title">⚠️ Notifications Stock</div></div>
        <div class="card-body">
          <div class="scroll370">
            <ul class="user-messages">
              @forelse($stockAlert as $outil)
                <li>
                  <div class="customer {{ $outil->stock_actuel == 0 ? 'shade-red' : 'shade-orange' }}">
                    {{ strtoupper(substr($outil->title, 0, 2)) }}
                  </div>
                  <div class="delivery-details">
                    <span class="badge {{ $outil->stock_actuel == 0 ? 'shade-red' : 'shade-orange' }}">
                      {{ $outil->stock_actuel == 0 ? 'Épuisé' : 'Seuil Alerte' }}
                    </span>
                    <h5>{{ $outil->title }}</h5>
                    <p>
                      @if($outil->stock_actuel == 0)
                        Ce produit est épuisé. Veuillez réapprovisionner rapidement.
                      @else
                        Stock faible : {{ $outil->stock_actuel }} unité{{ $outil->stock_actuel > 1 ? 's' : '' }}
                      @endif
                    </p>
                  </div>
                </li>
              @empty
                <div class="text-muted p-3">Stock pas alarmant pour le moment.</div>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="card h-100">
        <div class="card-header"><div class="card-title">Activités des utilisateurs</div></div>
        <div class="card-body">
          <div class="scroll370">
            <div class="activity-container">
              @forelse($activites as $act)
                <div class="activity-block">
                  <div class="activity-user">
                    <span class="avatar">
                      <img
                        src="{{ $act->user->image_url }}"
                        alt="Utilisateur"
                        style="width:48px; height:48px; object-fit:cover; border-radius:50%;"
                      >
                    </span>
                  </div>
                  <div class="activity-details">
                    <h4>{{ $act->user->name ?? 'Utilisateur inconnu' }}</h4>
                    <h5>{{ $act->created_at->diffForHumans() }}</h5>
                    <p>A réalisé une vente (facture ref. #{{ $act->facture_numero }})</p>
                    <span class="badge shade-green">Vente</span>
                  </div>
                </div>
              @empty
                <div class="text-muted p-3">Aucune activité récente</div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Row 3 end -->

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('outilChart').getContext('2d');
    const labels = @json(array_keys($ventesParNomOutil));
    const data = @json(array_values($ventesParNomOutil));

    new Chart(ctx, {
      type: 'bar',
      data: { labels, datasets: [{ label: 'Nombre de ventes', data, borderRadius: 4 }] },
      options: {
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
        plugins: { legend: { display: false } },
        responsive: true,
        maintainAspectRatio: false
      }
    });
  });
</script>
{{-- 
<script>
document.addEventListener('DOMContentLoaded', () => {
  const labels = @json($stockParOutil->keys());
  const data = @json($stockParOutil->values());
  const maxVal = Math.max(...data, 1);  // éviter division par 0
  const step = maxVal > 5 ? Math.ceil(maxVal / 5) : 1;

  const ctx = document.getElementById('stockGraph').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Stock actuel',
        data,
        backgroundColor: labels.map((_, i) => `hsl(${(i * 360 / labels.length)}, 70%, 50%)`),
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: step },
        },
        x: {
          ticks: {
            autoSkip: false,
            maxRotation: 45,
            minRotation: 0
          }
        }
      },
      plugins: {
        legend: { display: false }
      }
    }
  });
});
</script> --}}


<script>
document.addEventListener('DOMContentLoaded', () => {
  const labels = @json($stockParOutil->keys());
  const data = @json($stockParOutil->values());

  const colors = data.map(value => {
    return value < 5 ? 'rgba(255, 99, 132, 0.7)' : 'rgba(100, 149, 237, 0.5)';
  });

  const ctx = document.getElementById('stockGraph').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Stock actuel',
        data,
        backgroundColor: colors,
        borderRadius: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      indexAxis: 'x',
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0,
            stepSize: 1,
          }
        },
        x: {
          ticks: {
            maxRotation: 45,
            autoSkip: false,
          }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => `${ctx.parsed.y} en stock`
          }
        }
      }
    }
  });
});
</script>


@endsection
