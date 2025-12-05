<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;


class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Log::join('users', 'logs.user_id', '=', 'users.user_id')
            ->select(
                'logs.log_id',
                'logs.action',
                'logs.date_time',
                'users.full_name',
                'users.role',
                'users.profile_image'
            )
            ->when($search, function ($query, $search) {
                $query->where('logs.action', 'like', "%{$search}%")
                      ->orWhere('users.full_name', 'like', "%{$search}%");
            })
            ->latest('logs.date_time'); 


        $logs = $query->paginate(15);


        return view('logs.index', compact('logs'));
    }
}