<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tapes.index') }}">
            <i class="bi bi-cassette-fill text-warning me-2"></i>SK04 · Arsip Restorasi Pita Analog
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tapes.index') ? 'active' : '' }}" href="{{ route('tapes.index') }}">
                        Daftar Koleksi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tapes.create') ? 'active' : '' }}" href="{{ route('tapes.create') }}">
                        + Tambah Koleksi
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
