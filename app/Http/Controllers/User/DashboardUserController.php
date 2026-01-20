<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardUserController extends Controller
{
    public function index()
    {
        $total = DB::table('v_total_saldo')->first();
        $leaderboard = DB::table('v_leaderboard')->get();

        return view('user.dashboard', [
            'total' => $total,
            'leaderboard' => $leaderboard,
        ]);
    }
}
