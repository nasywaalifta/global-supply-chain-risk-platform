<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RiskScoreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $riskScores = RiskScore::with('country')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('country', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->join('countries', 'risk_scores.country_id', '=', 'countries.id')
            ->orderBy('countries.name', 'asc')
            ->select('risk_scores.*')
            ->paginate(20);

        $high = RiskScore::where('risk_level', 'High')->count();
        $medium = RiskScore::where('risk_level', 'Medium')->count();
        $low = RiskScore::where('risk_level', 'Low')->count();

        return view('risk-score.index', compact(
            'riskScores',
            'high',
            'medium',
            'low',
            'search'
        ));
    }

   public function update()
{
    try {

        Artisan::call('risk:calculate');

        return redirect()
            ->route('risk-score.index')
            ->with('success', 'Risk Score berhasil dihitung ulang.');

    } catch (\Exception $e) {

        return redirect()
            ->route('risk-score.index')
            ->with('error', $e->getMessage());

    }
}
}