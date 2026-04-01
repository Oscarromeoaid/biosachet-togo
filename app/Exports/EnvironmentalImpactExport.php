<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EnvironmentalImpactExport implements FromView, ShouldAutoSize
{
    public function __construct(
        private readonly array $impact,
        private readonly Collection $productions,
    ) {
    }

    public function view(): View
    {
        return view('exports.environmental-impact', [
            'impact' => $this->impact,
            'productions' => $this->productions,
        ]);
    }
}
