<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function storeFromIot(Request $request)
    {
        $validated = $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric',
            'kecepatan_angin' => 'required|numeric',
            'debit_air' => 'required|numeric',
            'ketinggian_air' => 'required|numeric',
            'total_pengunjung' => 'nullable|integer',
            'pengunjung_now' => 'nullable|integer',
        ]);

        $validated['logged_at'] = now();
        $validated['source'] = 'iot';

        $log = SensorLog::create($validated);

        return response()->json(['message' => 'Logged', 'data' => $log]);
    }
}
