<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AlertService;

class AlertController extends Controller
{
    public function __construct(private readonly AlertService $alerts)
    {
    }

    public function index()
    {
        return view('admin.alerts.index', [
            'alerts' => $this->alerts->all(),
        ]);
    }
}
