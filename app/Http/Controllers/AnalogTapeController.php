<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalogTapeRequest;
use App\Http\Requests\UpdateAnalogTapeRequest;
use App\Models\AnalogTape;
use App\Services\AnalogTapeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalogTapeController extends Controller
{
    public function __construct(
        protected AnalogTapeService $tapeService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'media_format', 'physical_condition']);
        $tapes = $this->tapeService->getFilteredTapes($filters);

        $formats = [
            'Reel-to-Reel 1/4 Inch',
            'Compact Cassette (Type I Ferric)',
            'Compact Cassette (Type II CrO2)',
            'U-Matic 3/4 Inch',
            'Betacam SP',
            'VHS / S-VHS',
            'DAT (Digital Audio Tape)',
        ];

        return view('tapes.index', compact('tapes', 'formats', 'filters'));
    }

    public function create(): View
    {
        $formats = [
            'Reel-to-Reel 1/4 Inch',
            'Compact Cassette (Type I Ferric)',
            'Compact Cassette (Type II CrO2)',
            'U-Matic 3/4 Inch',
            'Betacam SP',
            'VHS / S-VHS',
            'DAT (Digital Audio Tape)',
        ];

        return view('tapes.create', compact('formats'));
    }

    public function store(StoreAnalogTapeRequest $request): RedirectResponse
    {
        $this->tapeService->createTape($request->validated());

        return redirect()
            ->route('tapes.index')
            ->with('success', 'Koleksi pita analog dan rencana restorasi berhasil disimpan.');
    }

    public function show(AnalogTape $tape): View
    {
        $tape->load(['condition', 'actions']);
        return view('tapes.show', compact('tape'));
    }

    public function edit(AnalogTape $tape): View
    {
        $tape->load(['condition', 'actions']);
        $formats = [
            'Reel-to-Reel 1/4 Inch',
            'Compact Cassette (Type I Ferric)',
            'Compact Cassette (Type II CrO2)',
            'U-Matic 3/4 Inch',
            'Betacam SP',
            'VHS / S-VHS',
            'DAT (Digital Audio Tape)',
        ];

        return view('tapes.edit', compact('tape', 'formats'));
    }

    public function update(UpdateAnalogTapeRequest $request, AnalogTape $tape): RedirectResponse
    {
        $this->tapeService->updateTape($tape, $request->validated());

        return redirect()
            ->route('tapes.index')
            ->with('success', 'Data koleksi pita analog berhasil diperbarui.');
    }

    public function destroy(AnalogTape $tape): RedirectResponse
    {
        $this->tapeService->deleteTape($tape);

        return redirect()
            ->route('tapes.index')
            ->with('success', 'Koleksi pita analog berhasil dihapus.');
    }
}
