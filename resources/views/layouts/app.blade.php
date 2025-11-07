<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sales Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
        }
        .navbar {
            background-color: #1e1e1e !important;
        }
        .navbar-brand, .nav-link {
            color: #f1f1f1 !important;
        }
        .nav-link.active {
            color: #00c3ff !important;
        }
        .card {
            background-color: #1e1e1e;
            border: 1px solid #333;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{ route('sales.analytics') }}">📊 Sales Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}" href="{{ route('sales.index') }}">📦 Sales Data</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('sales.analytics') ? 'active' : '' }}" href="{{ route('sales.analytics') }}">📈 Analytics</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">⬇️ Export</a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="{{ route('sales.exportExcel') }}">Excel</a></li>
            <li><a class="dropdown-item" href="{{ route('sales.exportCSV') }}">CSV</a></li>
            <li><a class="dropdown-item" href="{{ route('sales.exportPDF') }}">PDF</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mb-5">
  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
