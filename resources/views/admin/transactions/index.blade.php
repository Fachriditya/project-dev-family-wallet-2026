<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transaction Management') }}
            </h2>
            <a href="{{ route('admin.transactions.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Jenis
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Jumlah
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Catatan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                        Aksi
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $trx)
                                    <tr class="hover:bg-gray-50">

                                        {{-- User --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $trx->user_nama }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $trx->username }}
                                            </div>
                                        </td>

                                        {{-- Jenis --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($trx->jenis_transaksi === 'M')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                             bg-green-100 text-green-800">
                                                    Masuk
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                             bg-red-100 text-red-800">
                                                    Keluar
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Jumlah --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                        </td>

                                        {{-- Catatan --}}
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ $trx->note ?? '-' }}
                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}
                                            </div>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.transactions.destroy', $trx->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                                 a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                                 M1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12 text-gray-500">
                            Belum ada transaksi.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
