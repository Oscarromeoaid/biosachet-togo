<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductionTypesExport implements FromView, ShouldAutoSize
{
    public function __construct(
        private readonly Collection $productions,
    ) {
    }

    public function view(): View
    {
        return view('exports.production-types', [
            'productions' => $this->productions,
            'totals' => [
                'kg_manioc_utilise' => round((float) $this->productions->sum('kg_manioc_utilise'), 2),
                'sachets_petit_transparent' => (int) $this->productions->sum('sachets_petit_transparent'),
                'sachets_moyen_souple' => (int) $this->productions->sum('sachets_moyen_souple'),
                'sachets_grand_solide' => (int) $this->productions->sum('sachets_grand_solide'),
                'film_biodegradable_m2' => round((float) $this->productions->sum('film_biodegradable_m2'), 2),
            ],
        ]);
    }
}
