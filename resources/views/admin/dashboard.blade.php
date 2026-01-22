<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #1f2937;">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- CARD 1: STATISTIK (Total Saldo, Total User, Total Transaksi) --}}
            <div class="mb-6">
                {{-- Total Saldo (Tengah Atas) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-center" style="color: #1f2937;">
                        <h3 class="text-sm font-medium uppercase tracking-wider mb-2" style="color: #6b7280;">Total Saldo Keluarga</h3>
                        <p class="text-4xl font-bold" style="color: #1f2937;">
                            Rp {{ number_format($totalSaldo->saldo ?? 0, 0, ',', '.') }}
                        </p>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div class="text-center">
                                <p style="color: #6b7280;">Total Masuk</p>
                                <p class="text-green-600 font-semibold">
                                    Rp {{ number_format($totalSaldo->total_masuk ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-center">
                                <p style="color: #6b7280;">Total Keluar</p>
                                <p class="text-red-600 font-semibold">
                                    Rp {{ number_format($totalSaldo->total_keluar ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total User & Total Transaksi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Total User  --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium uppercase tracking-wider" style="color: #6b7280;">Total User</h3>
                                    <p class="text-3xl font-bold mt-2" style="color: #1f2937;">{{ $totalUser }}</p>
                                    <p class="text-xs mt-1" style="color: #6b7280;">User aktif terdaftar</p>
                                </div>
                                <div class="p-3 rounded-full" style="background-color: #DBEAFE;">
                                    <svg class="w-8 h-8" fill="none" stroke="#2563EB " viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Transaksi --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium uppercase tracking-wider" style="color: #6b7280;">Total Transaksi</h3>
                                    <p class="text-3xl font-bold mt-2" style="color: #1f2937;">{{ $totalSaldo->total_transaksi ?? 0 }}</p>
                                    <p class="text-xs mt-1" style="color: #6b7280;">
                                        <span class="text-green-600">{{ $totalSaldo->jumlah_transaksi_masuk ?? 0 }} masuk</span> • 
                                        <span class="text-red-600">{{ $totalSaldo->jumlah_transaksi_keluar ?? 0 }} keluar</span>
                                    </p>
                                </div>
                                <div class="p-3 rounded-full" style="background-color: #DCFCE7;">
                                    <svg class="w-8 h-8" fill="none" stroke="#16A34A" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 2: LEADERBOARD --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold" style="color: #1f2937;">🏆 Leaderboard Top User</h3>
                    </div>

                    @if($leaderboard->count() > 0)
                        <div id="leaderboard-full" class="overflow-x-auto">
                             <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Ranking</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Saldo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Kontribusi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($leaderboard as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($user->ranking == 1)
                                                    <span class="text-2xl">🥇</span>
                                                @elseif($user->ranking == 2)
                                                    <span class="text-2xl">🥈</span>
                                                @elseif($user->ranking == 3)
                                                    <span class="text-2xl">🥉</span>
                                                @else
                                                    <span class="text-sm font-semibold" style="color: #1f2937;">#{{ $user->ranking }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($user->photo)
                                                        <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->nama }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full flex items-center justify-center" style="background-color: rgba(31, 41, 55, 0.1);">
                                                            <span class="font-semibold text-sm" style="color: #1f2937;">{{ substr($user->nama, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium" style="color: #1f2937;">{{ $user->nama }}</div>
                                                    <div class="text-sm" style="color: #6b7280;">{{ $user->username }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold" style="color: #1f2937;">Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
                                            <div class="text-xs" style="color: #6b7280;">
                                                <span class="text-green-600">+{{ number_format($user->total_masuk, 0, ',', '.') }}</span> 
                                                <span class="text-red-600">-{{ number_format($user->total_keluar, 0, ',', '.') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="h-2 rounded-full" style="width: {{ $user->persentase_kontribusi }}%; background-color: #1f2937;"></div>
                                                </div>
                                                <span class="text-sm font-medium" style="color: #1f2937;">{{ number_format($user->persentase_kontribusi, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: #6b7280;">
                                            {{ $user->total_transaksi }} transaksi
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8" style="color: #6b7280;">
                            <svg class="mx-auto h-12 w-12" fill="none" stroke="#9ca3af" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="mt-2">Belum ada data user</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>