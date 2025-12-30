<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Use Eloquent relationships instead of raw join for better security
        $logs = Log::with('user')
            ->when($search, function ($query, $search) {
                $query->where('action', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('full_name', 'like', "%{$search}%");
                      });
            })
            ->latest('date_time')
            ->paginate(15);

        return view('logs.index', compact('logs'));
    }
}