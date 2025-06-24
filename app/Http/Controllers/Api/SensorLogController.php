<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class SensorLogController extends Controller
{
    // [POST] IoT store log
    public function storeFromIot(Request $request)
    {
        $validated = $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric',
            'kecepatan_angin' => 'required|numeric',
            'debit_air' => 'required|numeric',
            'ketinggian_air' => 'required|numeric',
            // 'total_pengunjung' => 'nullable|integer',
            // 'pengunjung_now' => 'nullable|integer',
        ]);

        $log = SensorLog::create([
            ...$validated,
            'logged_at' => now(),
            'source' => 'iot',
        ]);

        return response()->json([
            'message' => 'Log created from IoT',
            'data' => $log
        ]);
    }

    // [GET] Get latest log (for polling)
    public function latest()
    {
        $log = SensorLog::orderBy('logged_at', 'desc')->first();

        return response()->json($log);
    }

    // [GET] Get logs per day
    public function byDate(Request $request)
    {
        $date = $request->query('date', now()->toDateString());

        $logs = SensorLog::whereDate('logged_at', $date)
            ->orderBy('logged_at')
            ->get();

        return response()->json($logs);
    }

    // [GET] Get data grouped per hour (for chart)
    public function groupedByHour(Request $request)
    {
        $date = $request->query('date', now()->toDateString());

        $logs = SensorLog::selectRaw('HOUR(logged_at) as hour,
                AVG(suhu) as suhu,
                AVG(kelembapan) as kelembapan,
                AVG(kecepatan_angin) as kecepatan_angin,
                AVG(debit_air) as debit_air,
                AVG(ketinggian_air) as ketinggian_air'
                )
            ->whereDate('logged_at', $date)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return response()->json($logs);
    }
}
