<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;

class TransactionsManagementController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index()
    {
        $transactions = DB::table('transactions')
                        ->join('users', 'transactions.user_id', '=', 'users.id')
                        ->select('transactions.*', 'users.nama as user_nama', 'users.username')
                        ->whereNull('transactions.deleted_at')
                        ->whereNull('users.deleted_at')
                        ->orderBy('transactions.created_at', 'desc')
                        ->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction
     */
    public function create()
    {
        $users = User::where('role', 2)
                    ->whereNull('deleted_at')
                    ->orderBy('nama')
                    ->get();

        return view('admin.transactions.create', compact('users'));
    }

    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_transaksi' => 'required|in:M,K',
            'jumlah' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:500',
        ], [
            'user_id.required' => 'User harus dipilih',
            'user_id.exists' => 'User tidak ditemukan',
            'jenis_transaksi.required' => 'Jenis transaksi harus dipilih',
            'jenis_transaksi.in' => 'Jenis transaksi harus M (Masuk) atau K (Keluar)',
            'jumlah.required' => 'Jumlah harus diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'note.max' => 'Catatan maksimal 500 karakter',
        ]);

        try {
            DB::statement('CALL sp_tambah_transaksi(?, ?, ?, ?)', [
                $validated['user_id'],
                $validated['jenis_transaksi'],
                $validated['jumlah'],
                $validated['note']
            ]);

            return redirect()->route('admin.transactions.index')
                            ->with('success', 'Transaksi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menambah transaksi: ' . $e->getMessage())
                            ->withInput();
        }
    }
}