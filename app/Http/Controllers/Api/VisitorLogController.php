<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class VisitorLogController extends Controller
{
    public function index(){
        $visitorLogs = VisitorLog::all();

        if($visitorLogs->count() == 0) {
            return response()->json(['message' => 'Visitor Logs Not Found']);
        }
        return response()->json($visitorLogs);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'ticker_number' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'check_in_time' => 'required',
        ]);

        $visitorLogs = VisitorLog::create($validated);

        return response()->json(['message' => 'Visitor Created', 'data' => $visitorLogs]);
    }

    public function update(Request $request, VisitorLog $visitorLog){
        $visitorLog->update($request->all());
        return response()->json(['message' => 'Visitor Updated', 'data' => $visitorLog]);
    }

    public function checkoutTime(Request $request, VisitorLog $visitorLog){
        $visitorLog->update(['checkout_time' => now()]);
        return response()->json(['message' => 'Visitor Updated', 'data' => $visitorLog]);
    }

}
