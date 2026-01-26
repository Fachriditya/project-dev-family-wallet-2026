<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-800">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- CARD 1: STATISTIK --}}
            <div class="mb-6">
                {{-- Total Saldo (Tengah Atas) --}}
                <div class="bg-gradient-to-br from-primary-500 to-primary-700 overflow-hidden shadow-xl sm:rounded-2xl mb-6 transform hover:scale-[1.01] transition-all duration-300">
                    <div class="p-8 text-center text-white">
                        <div class="inline-block p-3 bg-white/20 rounded-xl mb-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium uppercase tracking-wider mb-3 text-white/80">Total Saldo Keluarga</h3>
                        <p class="text-5xl font-bold mb-6">
                            Rp {{ number_format($totalSaldo->saldo ?? 0, 0, ',', '.') }}
                        </p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                <div class="flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 mr-2 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                    <p class="text-sm text-white/80">Total Masuk</p>
                                </div>
                                <p class="text-2xl font-bold text-green-300">
                                    Rp {{ number_format($totalSaldo->total_masuk ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                <div class="flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 mr-2 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                    </svg>
                                    <p class="text-sm text-white/80">Total Keluar</p>
                                </div>
                                <p class="text-2xl font-bold text-red-300">
                                    Rp {{ number_format($totalSaldo->total_keluar ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total User & Total Transaksi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Total User --}}
                    <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-2xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-600">Total User</h3>
                                    </div>
                                    <p class="text-4xl font-bold text-gray-900 mb-2">{{ $totalUser }}</p>
                                    <p class="text-sm text-gray-500">User aktif terdaftar</p>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Transaksi --}}
                    <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-2xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-green-100 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-600">Total Transaksi</h3>
                                    </div>
                                    <p class="text-4xl font-bold text-gray-900 mb-2">{{ $totalSaldo->total_transaksi ?? 0 }}</p>
                                    <p class="text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-1">
                                            {{ $totalSaldo->jumlah_transaksi_masuk ?? 0 }} masuk
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            {{ $totalSaldo->jumlah_transaksi_keluar ?? 0 }} keluar
                                        </span>
                                    </p>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 2: LEADERBOARD --}}
            <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-2xl transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl mr-3 shadow-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Leaderboard Top User</h3>
                    </div>

                    @if($leaderboard->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gradient-to-r from-primary-50 to-purple-50">
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Ranking</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Nama</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Saldo</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Kontribusi</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($leaderboard as $user)
                                    <tr class="hover:bg-purple-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($user->ranking == 1)
                                                    <span class="text-3xl">🥇</span>
                                                @elseif($user->ranking == 2)
                                                    <span class="text-3xl">🥈</span>
                                                @elseif($user->ranking == 3)
                                                    <span class="text-3xl">🥉</span>
                                                @else
                                                    <span class="text-lg font-bold text-gray-700">#{{ $user->ranking }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    @if($user->photo)
                                                        <img class="h-12 w-12 rounded-full ring-2 ring-primary-500" src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->nama }}">
                                                    @else
                                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center ring-2 ring-primary-300">
                                                            <span class="font-bold text-white text-lg">{{ substr($user->nama, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $user->nama }}</div>
                                                    <div class="text-sm text-gray-500">{{ $user->username }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <span class="text-green-600 font-medium">+{{ number_format($user->total_masuk, 0, ',', '.') }}</span> 
                                                <span class="text-red-600 font-medium">-{{ number_format($user->total_keluar, 0, ',', '.') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2.5 mr-3 overflow-hidden">
                                                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $user->persentase_kontribusi }}%"></div>
                                                </div>
                                                <span class="text-sm font-bold text-primary-600">{{ number_format($user->persentase_kontribusi, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                                {{ $user->total_transaksi }} transaksi
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-gray-900">Belum ada data user</h3>
                            <p class="mt-1 text-sm text-gray-500">Tambahkan user pertama untuk melihat leaderboard</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
