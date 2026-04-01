<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FinancialSummaryExport implements FromView, ShouldAutoSize
{
    public function __construct(
        private readonly array $financial,
        private readonly Collection $commandes,
        private readonly Collection $stocks,
    ) {
    }

    public function view(): View
    {
        return view('exports.financial-summary', [
            'financial' => $this->financial,
            'commandes' => $this->commandes,
            'stocks' => $this->stocks,
        ]);
    }
}
