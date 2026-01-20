<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg">Total Saldo</h3>
                    <p>Saldo: Rp {{ number_format($total->saldo ?? 0, 0, ',', '.') }}</p>
                    <p>Total Masuk: Rp {{ number_format($total->total_masuk ?? 0, 0, ',', '.') }}</p>
                    <p>Total Keluar: Rp {{ number_format($total->total_keluar ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
