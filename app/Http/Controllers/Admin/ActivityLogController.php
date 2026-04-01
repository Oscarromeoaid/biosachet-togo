<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query()->with('user')->latest();

        if ($request->filled('section')) {
            $query->where('section', $request->string('section'));
        }

        return view('admin.activity-logs.index', [
            'logs' => $query->paginate(20)->withQueryString(),
            'sections' => ActivityLog::query()->select('section')->distinct()->orderBy('section')->pluck('section'),
        ]);
    }
}
