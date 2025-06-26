<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitorLogController extends Controller
{
    public function index()
    {
        $visitorLogs = VisitorLog::all();

        if ($visitorLogs->count() == 0) {
            return response()->json(['message' => 'Visitor Logs Not Found']);
        }
        return response()->json($visitorLogs);
    }

    public function hourly(Request $request)
    {
        $today = now()->format('Y-m-d');

        // Query sekali saja untuk semua data hari ini
        $checkIns = VisitorLog::whereDate('check_in_time', $today)
            ->selectRaw('HOUR(check_in_time) as hour, SUM(amount) as total')
            ->groupBy('hour')
            ->pluck('total', 'hour');

        $checkOuts = VisitorLog::whereDate('check_out_time', $today)
            ->selectRaw('HOUR(check_out_time) as hour, SUM(amount) as total')
            ->groupBy('hour')
            ->pluck('total', 'hour');

        $data = collect(range(8, 16))->map(function ($hour) use ($checkIns, $checkOuts) {
            return [
                'hour' => str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00',
                'masuk' => (int) ($checkIns->get($hour, 0)),
                'keluar' => (int) ($checkOuts->get($hour, 0)),
            ];
        });

        return response()->json([
            'message' => 'Visitor Logs',
            'data' => $data,
        ]);
    }

    public function dailyIn(Request $request)
    {
        $today = now()->format('Y-m-d');
        $visitorLogs = VisitorLog::whereDate('check_in_time', $today)->get();
        return $this->successResponse($visitorLogs, 'Visitor Logs');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticker_number' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'check_in_time' => 'required',
        ]);

        $visitorLogs = VisitorLog::create($validated);

        return response()->json(['message' => 'Visitor Created', 'data' => $visitorLogs]);
    }

    public function update(Request $request, VisitorLog $visitorLog)
    {
        $visitorLog->update($request->all());
        return response()->json(['message' => 'Visitor Updated', 'data' => $visitorLog]);
    }

    public function checkoutTime(Request $request, VisitorLog $visitorLog)
    {
        $visitorLog->update(['check_out_time' => now()]);
        return response()->json(['message' => 'Visitor Updated', 'data' => $visitorLog]);
    }
}
