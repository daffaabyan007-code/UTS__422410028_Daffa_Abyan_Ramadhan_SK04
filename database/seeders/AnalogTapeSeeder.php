<?php

namespace Database\Seeders;

use App\Models\AnalogTape;
use Illuminate\Database\Seeder;

class AnalogTapeSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'code' => 'ARC-R2R-001',
                'name' => 'Rekaman Pidato Kemerdekaan 1965 (Master Reel)',
                'media_format' => 'Reel-to-Reel 1/4 Inch',
                'recording_year' => 1965,
                'condition' => [
                    'physical_condition' => 'Jamur Ringan & Debu',
                    'magnetic_degradation' => 'Sticky-Shed Syndrome (Sedang)',
                    'housing_status' => 'Reel Logam Sedikit Penyok',
                    'notes' => 'Perlu pemanggangan termal sebelum diputar pada mesin Studer A80.',
                ],
                'actions' => [
                    ['action_name' => 'Pembersihan Kering (Dry Cleaning)', 'priority' => 'Tinggi', 'status' => 'Selesai'],
                    ['action_name' => 'Thermal Baking (54°C selama 4 jam)', 'priority' => 'Tinggi', 'status' => 'Berjalan'],
                    ['action_name' => 'Transfer Digital 96kHz/24-bit', 'priority' => 'Sedang', 'status' => 'Direncanakan'],
                ],
            ],
            [
                'code' => 'ARC-CAS-014',
                'name' => 'Wawancara Seniman Tradisional Betawi',
                'media_format' => 'Compact Cassette (Type II CrO2)',
                'recording_year' => 1988,
                'condition' => [
                    'physical_condition' => 'Pita Kusut di Ujung Awal',
                    'magnetic_degradation' => 'Degradasi Minimal',
                    'housing_status' => 'Cangkang Retak',
                    'notes' => 'Bantalan pressure pad terlepas, perlu penggantian cangkang baru.',
                ],
                'actions' => [
                    ['action_name' => 'Pemindahan Pita ke Cangkang Baru', 'priority' => 'Tinggi', 'status' => 'Direncanakan'],
                    ['action_name' => 'Penyambungan Ujung Pita (Splicing)', 'priority' => 'Sedang', 'status' => 'Direncanakan'],
                ],
            ],
            [
                'code' => 'ARC-U34-007',
                'name' => 'Dokumentasi Festival Musik Nusantara TVRI',
                'media_format' => 'U-Matic 3/4 Inch',
                'recording_year' => 1982,
                'condition' => [
                    'physical_condition' => 'Jamur Berat di Tepi Pita',
                    'magnetic_degradation' => 'Binder Hydrolysis Tinggi',
                    'housing_status' => 'Utuh',
                    'notes' => 'Wajib melalui ruang pembersihan jamur khusus sebelum proses baking.',
                ],
                'actions' => [
                    ['action_name' => 'Dekontaminasi Jamur Vakum', 'priority' => 'Tinggi', 'status' => 'Direncanakan'],
                    ['action_name' => 'Thermal Baking', 'priority' => 'Tinggi', 'status' => 'Direncanakan'],
                    ['action_name' => 'Kalibrasi Head & Transfer SDI', 'priority' => 'Sedang', 'status' => 'Direncanakan'],
                ],
            ],
        ];

        foreach ($samples as $item) {
            $tape = AnalogTape::create([
                'code' => $item['code'],
                'name' => $item['name'],
                'media_format' => $item['media_format'],
                'recording_year' => $item['recording_year'],
            ]);

            $tape->condition()->create($item['condition']);

            foreach ($item['actions'] as $action) {
                $tape->actions()->create($action);
            }
        }
    }
}
