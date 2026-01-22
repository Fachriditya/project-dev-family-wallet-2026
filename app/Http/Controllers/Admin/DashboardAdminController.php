<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalSaldo = DB::table('v_total_saldo')->first();

        $totalUser = DB::table('users')
                        ->where('role', 2)
                        ->whereNull('deleted_at')
                        ->count();
                        
        $leaderboard = DB::table('v_leaderboard')
                        ->get();

        return view('admin.dashboard', compact('totalSaldo', 'totalUser', 'leaderboard'));
    }
}
