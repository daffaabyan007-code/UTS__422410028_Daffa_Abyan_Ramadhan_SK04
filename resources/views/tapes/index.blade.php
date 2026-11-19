@extends('layouts.app')

@section('title', 'Daftar Koleksi Pita Analog - SK04')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1 fw-bold">Koleksi Pita Rekaman Analog</h3>
        <p class="text-muted mb-0">Manajemen inventaris media analog, diagnostik kondisi awal, dan rencana restorasi.</p>
    </div>
    <a href="{{ route('tapes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Registrasi Pita Baru
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('tapes.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted">Pencarian Kode / Judul</label>
                <input type="text" name="search" class="form-control" placeholder="Contoh: ARC-R2R-001 atau Pidato..." value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">Filter Format Media</label>
                <select name="media_format" class="form-select">
                    <option value="">-- Semua Format Media --</option>
                    @foreach($formats as $fmt)
                        <option value="{{ $fmt }}" {{ ($filters['media_format'] ?? '') == $fmt ? 'selected' : '' }}>
                            {{ $fmt }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Kondisi Fisik</label>
                <input type="text" name="physical_condition" class="form-control" placeholder="Jamur / Kusut..." value="{{ $filters['physical_condition'] ?? '' }}">
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-dark w-100"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('tapes.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Koleksi</th>
                    <th>Format Media</th>
                    <th>Kondisi Awal (Detail)</th>
                    <th>Rencana Tindakan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tapes as $tape)
                    <tr>
                        <td class="fw-bold text-primary">{{ $tape->code }}</td>
                        <td>
                            <div class="fw-semibold">{{ $tape->name }}</div>
                            @if($tape->recording_year)
                                <small class="text-muted">Tahun Rekam: {{ $tape->recording_year }}</small>
                            @endif
                        </td>
                        <td><span class="badge badge-format px-2 py-1">{{ $tape->media_format }}</span></td>
                        <td>
                            @if($tape->condition)
                                <div class="small"><strong>Fisik:</strong> {{ $tape->condition->physical_condition }}</div>
                                <div class="small text-muted"><strong>Degradasi:</strong> {{ $tape->condition->magnetic_degradation }}</div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $tape->actions->count() }} Tindakan</span>
                            <ul class="list-unstyled mb-0 mt-1 small">
                                @foreach($tape->actions->take(2) as $act)
                                    <li>&bull; {{ $act->action_name }} ({{ $act->status }})</li>
                                @endforeach
                                @if($tape->actions->count() > 2)
                                    <li class="text-muted fst-italic">+{{ $tape->actions->count() - 2 }} lainnya...</li>
                                @endif
                            </ul>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('tapes.show', $tape) }}" class="btn btn-outline-info" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('tapes.edit', $tape) }}" class="btn btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('tapes.destroy', $tape) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus koleksi {{ $tape->code }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data koleksi pita analog yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tapes->hasPages())
        <div class="card-footer bg-white">
            {{ $tapes->links() }}
        </div>
    @endif
</div>
@endsection
