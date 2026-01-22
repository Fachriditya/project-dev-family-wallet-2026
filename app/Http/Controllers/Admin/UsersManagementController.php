<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersManagementController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::where('role', 2)
                    ->whereNull('deleted_at')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
        }

        User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'photo' => $photoPath,
            'role' => 2, // User biasa
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing user
     */
    public function edit($id)
    {
        $user = User::where('role', 2)
                    ->whereNull('deleted_at')
                    ->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 2)
                    ->whereNull('deleted_at')
                    ->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
                \Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Soft delete user
     */
    public function destroy($id)
    {
        $user = User::where('role', 2)
                    ->whereNull('deleted_at')
                    ->findOrFail($id);

        $user->update(['deleted_at' => now()]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Reset password user ke default (123456)
     */
    public function resetPassword($id)
    {
        try {
            DB::statement('CALL sp_reset_password(?)', [$id]);

            return redirect()->route('admin.users.index')
                            ->with('success', 'Password berhasil direset ke 123456!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Gagal reset password: ' . $e->getMessage());
        }
    }
}