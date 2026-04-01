<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardStatsResource;
use App\Services\DashboardMetricsService;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardMetricsService $metrics)
    {
    }

    public function __invoke()
    {
        return new DashboardStatsResource($this->metrics->get());
    }
}
