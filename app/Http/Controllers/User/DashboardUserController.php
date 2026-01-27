<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $totalSaldo = DB::table('v_total_saldo')->first();

        $user = DB::table('v_kontribusi_user')
                        ->where('id', Auth::id())
                        ->first();

        $leaderboard = DB::table('v_leaderboard')
                        ->get();

        if (!$user) {
            $authUser = Auth::user();
            $user = (object) [
                'id' => $userId,
                'nama' => $authUser->nama,
                'username' => $authUser->username,
                'photo' => $authUser->photo,
                'total_masuk' => 0,
                'total_keluar' => 0,
                'saldo' => 0,
                'jumlah_nabung' => 0,
                'jumlah_tarik' => 0,
                'total_transaksi' => 0,
                'ranking' => null,
                'persentase_kontribusi' => 0,
            ];
        }

        return view('user.dashboard', compact('totalSaldo', 'user', 'leaderboard'));
    }
}