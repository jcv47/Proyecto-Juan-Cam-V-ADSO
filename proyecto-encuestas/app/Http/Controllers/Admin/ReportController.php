<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // filtros (querystring)
        $sentiment = $request->query('sentiment'); // positivo|neutral|negativo|null
        $severity  = $request->query('severity');  // bueno|regular|critico|null

        $reports = AiReport::query()
            ->with([
                'submission' => function ($q) {
                    $q->with(['survey', 'user']);
                }
            ])
            ->when($sentiment, fn($q) => $q->where('sentiment', $sentiment))
            ->when($severity,  fn($q) => $q->where('severity', $severity))
            ->latest()
            ->paginate(15)
            ->withQueryString(); // conserva filtros al paginar

        return view('admin.reports.index', compact('reports', 'sentiment', 'severity'));
    }
}