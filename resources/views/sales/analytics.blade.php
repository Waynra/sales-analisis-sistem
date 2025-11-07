@extends('layouts.app')

@section('title', 'Sales Analytics Dashboard')

@section('content')
<div class="container">
  <h2 class="fw-bold text-center mb-4 text-info">📊 Sales Analytics Dashboard</h2>

  <!-- FILTER -->
  <form id="filterForm" class="row mb-4 g-3 align-items-end">
    <div class="col-md-3">
      <label>Start Date</label>
      <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label>End Date</label>
      <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label>Platform</label>
      <select name="platform" class="form-select">
        <option value="">All Platforms</option>
        @foreach($topPlatforms as $p)
          <option value="{{ $p->platform }}" {{ $platform == $p->platform ? 'selected' : '' }}>
            {{ $p->platform }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-info w-100">🔍 Apply Filter</button>
    </div>
  </form>

  <!-- SUMMARY CARDS -->
  <div class="row mb-4" id="summaryCards">
    <div class="col-md-3">
      <div class="card text-center p-3">
        <h6>Total Sales</h6>
        <h4 id="totalSales">Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}</h4>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3">
        <h6>Total Ads Cost</h6>
        <h4 id="totalAds">Rp {{ number_format($summary['total_ads'], 0, ',', '.') }}</h4>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3">
        <h6>Affiliate Fee</h6>
        <h4 id="totalAffiliate">Rp {{ number_format($summary['total_affiliate'], 0, ',', '.') }}</h4>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3">
        <h6>Total Transactions</h6>
        <h4 id="totalTransactions">{{ $summary['total_transactions'] }}</h4>
      </div>
    </div>
  </div>

  <!-- CHART -->
  <div class="card p-4 mb-4">
    <h5 class="text-info">📈 Sales Trend</h5>
    <canvas id="salesChart" height="100"></canvas>
  </div>

  <!-- TOP PRODUCTS -->
  <div class="card p-4">
    <h5 class="text-info">🔥 Top 5 Products</h5>
    <ul id="topProductsList">
      @foreach($topProducts as $product)
        <li>{{ $product->product_name }} — {{ $product->qty }} sold</li>
      @endforeach
    </ul>
  </div>
</div>
@endsection

@section('scripts')
<script>
let chart;
const ctx = document.getElementById('salesChart');

function renderChart(labels, data) {
  if (chart) chart.destroy();
  chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Sales (Rp)',
        data: data,
        borderColor: '#00c3ff',
        backgroundColor: 'rgba(0, 195, 255, 0.2)',
        tension: 0.3
      }]
    },
    options: {
      plugins: {
        legend: { labels: { color: '#fff' } }
      },
      scales: {
        x: { ticks: { color: '#aaa' } },
        y: { ticks: { color: '#aaa' } }
      }
    }
  });
}

renderChart(
  {!! json_encode($salesTrend->pluck('date')) !!},
  {!! json_encode($salesTrend->pluck('total_sales')) !!}
);

$('#filterForm').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    url: "{{ route('sales.analytics') }}",
    data: $(this).serialize(),
    success: function(res) {
      $('#totalSales').text('Rp ' + new Intl.NumberFormat('id-ID').format(res.summary.total_sales));
      $('#totalAds').text('Rp ' + new Intl.NumberFormat('id-ID').format(res.summary.total_ads));
      $('#totalAffiliate').text('Rp ' + new Intl.NumberFormat('id-ID').format(res.summary.total_affiliate));
      $('#totalTransactions').text(res.summary.total_transactions);
      renderChart(res.salesTrend.map(d => d.date), res.salesTrend.map(d => d.total_sales));
      $('#topProductsList').html('');
      res.topProducts.forEach(p => {
        $('#topProductsList').append(`<li>${p.product_name} — ${p.qty} sold</li>`);
      });
    }
  });
});
</script>
@endsection
