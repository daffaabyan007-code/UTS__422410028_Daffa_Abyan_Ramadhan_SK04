<?php

namespace App\Services;

use App\Models\AnalogTape;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AnalogTapeService
{
    public function getFilteredTapes(array $filters): LengthAwarePaginator
    {
        $query = AnalogTape::with(['condition', 'actions'])->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['media_format'])) {
            $query->where('media_format', $filters['media_format']);
        }

        if (!empty($filters['physical_condition'])) {
            $query->whereHas('condition', function ($q) use ($filters) {
                $q->where('physical_condition', 'like', "%{$filters['physical_condition']}%");
            });
        }

        return $query->paginate(8)->withQueryString();
    }

    public function createTape(array $data): AnalogTape
    {
        return DB::transaction(function () use ($data) {
            $tape = AnalogTape::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'media_format' => $data['media_format'],
                'recording_year' => $data['recording_year'] ?? null,
            ]);

            $tape->condition()->create([
                'physical_condition' => $data['physical_condition'],
                'magnetic_degradation' => $data['magnetic_degradation'],
                'housing_status' => $data['housing_status'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['actions'] as $action) {
                $tape->actions()->create([
                    'action_name' => $action['action_name'],
                    'priority' => $action['priority'],
                    'status' => $action['status'],
                ]);
            }

            return $tape;
        });
    }

    public function updateTape(AnalogTape $tape, array $data): AnalogTape
    {
        return DB::transaction(function () use ($tape, $data) {
            $tape->update([
                'code' => $data['code'],
                'name' => $data['name'],
                'media_format' => $data['media_format'],
                'recording_year' => $data['recording_year'] ?? null,
            ]);

            $tape->condition()->updateOrCreate(
                ['analog_tape_id' => $tape->id],
                [
                    'physical_condition' => $data['physical_condition'],
                    'magnetic_degradation' => $data['magnetic_degradation'],
                    'housing_status' => $data['housing_status'],
                    'notes' => $data['notes'] ?? null,
                ]
            );

            $tape->actions()->delete();
            foreach ($data['actions'] as $action) {
                $tape->actions()->create([
                    'action_name' => $action['action_name'],
                    'priority' => $action['priority'],
                    'status' => $action['status'],
                ]);
            }

            return $tape->fresh(['condition', 'actions']);
        });
    }

    public function deleteTape(AnalogTape $tape): void
    {
        DB::transaction(function () use ($tape) {
            $tape->delete();
        });
    }
}
