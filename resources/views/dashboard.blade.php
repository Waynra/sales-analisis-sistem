<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">📊 Sales Analytics Dashboard</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h5 class="text-muted mb-3">Total Sales This Month:</h5>
        <h2 class="fw-bold text-success">Rp {{ number_format($monthTotal, 0, ',', '.') }}</h2>
    </div>

    <div class="card shadow-sm p-4">
        <canvas id="salesChart" height="120"></canvas>
    </div>
</div>

<script>
    const ctx = document.getElementById('salesChart');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [{
                label: 'Total Sales',
                data: {!! json_encode($totals) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(75,192,192,0.1)',
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
