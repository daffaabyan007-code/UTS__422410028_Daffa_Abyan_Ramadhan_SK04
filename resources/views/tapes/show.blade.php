@extends('layouts.app')

@section('title', 'Detail Koleksi ' . $tape->code)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('tapes.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
    <a href="{{ route('tapes.edit', $tape) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit Koleksi</a>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white fw-bold">Informasi Koleksi Pita</div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="40%">Kode Koleksi</th>
                        <td class="fw-bold text-primary">{{ $tape->code }}</td>
                    </tr>
                    <tr>
                        <th>Nama Koleksi</th>
                        <td>{{ $tape->name }}</td>
                    </tr>
                    <tr>
                        <th>Format Media</th>
                        <td><span class="badge bg-secondary">{{ $tape->media_format }}</span></td>
                    </tr>
                    <tr>
                        <th>Tahun Rekam</th>
                        <td>{{ $tape->recording_year ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white fw-bold">Detail Kondisi Awal (One-to-One)</div>
            <div class="card-body">
                @if($tape->condition)
                    <p class="mb-2"><strong>Kondisi Fisik:</strong><br>{{ $tape->condition->physical_condition }}</p>
                    <p class="mb-2"><strong>Degradasi Magnetik:</strong><br>{{ $tape->condition->magnetic_degradation }}</p>
                    <p class="mb-2"><strong>Kondisi Cangkang / Reel:</strong><br>{{ $tape->condition->housing_status }}</p>
                    <p class="mb-0"><strong>Catatan Teknis:</strong><br>{{ $tape->condition->notes ?? 'Tidak ada catatan.' }}</p>
                @else
                    <p class="text-muted mb-0">Data kondisi awal belum diisi.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-bold">Daftar Rencana Tindakan Restorasi (One-to-Many)</div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tindakan Restorasi</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tape->actions as $index => $action)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $action->action_name }}</td>
                                <td>
                                    @php
                                        $badge = match($action->priority) {
                                            'Tinggi' => 'bg-danger',
                                            'Sedang' => 'bg-warning text-dark',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $action->priority }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusBadge = match($action->status) {
                                            'Selesai' => 'bg-success',
                                            'Berjalan' => 'bg-primary',
                                            default => 'bg-light text-dark border'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }}">{{ $action->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
