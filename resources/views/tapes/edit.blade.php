@extends('layouts.app')

@section('title', 'Edit Koleksi Pita Analog - SK04')

@section('content')
<div class="mb-3">
    <a href="{{ route('tapes.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
</div>

<form action="{{ route('tapes.update', $tape) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-bold">1. Identitas Utama Koleksi Pita</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Koleksi <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $tape->code) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama / Judul Koleksi <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $tape->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Format Media <span class="text-danger">*</span></label>
                        <select name="media_format" class="form-select" required>
                            @foreach($formats as $fmt)
                                <option value="{{ $fmt }}" {{ old('media_format', $tape->media_format) == $fmt ? 'selected' : '' }}>{{ $fmt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Perekaman</label>
                        <input type="number" name="recording_year" class="form-control" value="{{ old('recording_year', $tape->recording_year) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-bold">2. Detail Kondisi Awal (One-to-One)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Kondisi Fisik Pita <span class="text-danger">*</span></label>
                        <input type="text" name="physical_condition" class="form-control" value="{{ old('physical_condition', $tape->condition->physical_condition ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Degradasi Magnetik / Binder <span class="text-danger">*</span></label>
                        <input type="text" name="magnetic_degradation" class="form-control" value="{{ old('magnetic_degradation', $tape->condition->magnetic_degradation ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi Cangkang / Reel <span class="text-danger">*</span></label>
                        <input type="text" name="housing_status" class="form-control" value="{{ old('housing_status', $tape->condition->housing_status ?? 'Utuh') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Teknis Tambahan</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $tape->condition->notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">3. Rencana Tindakan Restorasi (One-to-Many)</span>
                    <button type="button" class="btn btn-sm btn-success" id="add-action-btn">
                        <i class="bi bi-plus-circle"></i> Tambah Tindakan
                    </button>
                </div>
                <div class="card-body">
                    <div id="actions-container">
                        @php
                            $existingActions = old('actions', $tape->actions->toArray());
                        @endphp
                        @foreach($existingActions as $idx => $act)
                            <div class="row g-2 mb-2 action-row align-items-center">
                                <div class="col-md-6">
                                    <input type="text" name="actions[{{ $idx }}][action_name]" class="form-control" value="{{ $act['action_name'] ?? '' }}" required>
                                </div>
                                <div class="col-md-2">
                                    <select name="actions[{{ $idx }}][priority]" class="form-select">
                                        <option value="Rendah" {{ ($act['priority'] ?? '') == 'Rendah' ? 'selected' : '' }}>Prioritas: Rendah</option>
                                        <option value="Sedang" {{ ($act['priority'] ?? '') == 'Sedang' ? 'selected' : '' }}>Prioritas: Sedang</option>
                                        <option value="Tinggi" {{ ($act['priority'] ?? '') == 'Tinggi' ? 'selected' : '' }}>Prioritas: Tinggi</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="actions[{{ $idx }}][status]" class="form-select">
                                        <option value="Direncanakan" {{ ($act['status'] ?? '') == 'Direncanakan' ? 'selected' : '' }}>Status: Direncanakan</option>
                                        <option value="Berjalan" {{ ($act['status'] ?? '') == 'Berjalan' ? 'selected' : '' }}>Status: Berjalan</option>
                                        <option value="Selesai" {{ ($act['status'] ?? '') == 'Selesai' ? 'selected' : '' }}>Status: Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-outline-danger remove-action-btn"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white text-end">
                    <button type="submit" class="btn btn-warning px-4"><i class="bi bi-save me-1"></i> Perbarui Data</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    let actionIndex = {{ count($existingActions) }};
    document.getElementById('add-action-btn').addEventListener('click', function () {
        const container = document.getElementById('actions-container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 action-row align-items-center';
        row.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="actions[${actionIndex}][action_name]" class="form-control" placeholder="Nama tindakan restorasi..." required>
            </div>
            <div class="col-md-2">
                <select name="actions[${actionIndex}][priority]" class="form-select">
                    <option value="Rendah">Prioritas: Rendah</option>
                    <option value="Sedang" selected>Prioritas: Sedang</option>
                    <option value="Tinggi">Prioritas: Tinggi</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="actions[${actionIndex}][status]" class="form-select">
                    <option value="Direncanakan" selected>Status: Direncanakan</option>
                    <option value="Berjalan">Status: Berjalan</option>
                    <option value="Selesai">Status: Selesai</option>
                </select>
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-outline-danger remove-action-btn"><i class="bi bi-x-lg"></i></button>
            </div>
        `;
        container.appendChild(row);
        actionIndex++;
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-action-btn');
        if (btn) {
            const rows = document.querySelectorAll('.action-row');
            if (rows.length > 1) {
                btn.closest('.action-row').remove();
            } else {
                alert('Minimal harus terdapat 1 rencana tindakan restorasi.');
            }
        }
    });
</script>
@endpush
