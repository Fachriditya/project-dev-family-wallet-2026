<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Transaksi Baru') }}
            </h2>
            <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Error Messages --}}
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">Ada beberapa kesalahan:</span>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.transactions.store') }}" id="transaction-form">
                        @csrf

                        {{-- User --}}
                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">
                                Pilih User <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id" id="user_id" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('user_id') border-red-500 @enderror">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->username }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Transaksi --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Transaksi <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                {{-- Masuk --}}
                                <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm hover:border-indigo-500 transition @error('jenis_transaksi') border-red-500 @else border-gray-300 @enderror">
                                    <input type="radio" name="jenis_transaksi" value="M" class="mt-1" {{ old('jenis_transaksi') == 'M' ? 'checked' : '' }} required>
                                    <span class="flex flex-col ml-3">
                                        <span class="flex items-center">
                                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                            <span class="block text-sm font-medium text-gray-900">Masuk (Nabung)</span>
                                        </span>
                                        <span class="mt-1 text-sm text-gray-500">Uang masuk ke saldo</span>
                                    </span>
                                </label>

                                {{-- Keluar --}}
                                <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm hover:border-indigo-500 transition @error('jenis_transaksi') border-red-500 @else border-gray-300 @enderror">
                                    <input type="radio" name="jenis_transaksi" value="K" class="mt-1" {{ old('jenis_transaksi') == 'K' ? 'checked' : '' }} required>
                                    <span class="flex flex-col ml-3">
                                        <span class="flex items-center">
                                            <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            </svg>
                                            <span class="block text-sm font-medium text-gray-900">Keluar (Tarik)</span>
                                        </span>
                                        <span class="mt-1 text-sm text-gray-500">Tarik uang dari saldo</span>
                                    </span>
                                </label>
                            </div>
                            @error('jenis_transaksi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-4">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">
                                Jumlah <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required min="1"
                                    class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jumlah') border-red-500 @enderror"
                                    placeholder="0">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Masukkan jumlah dalam Rupiah (minimal Rp 1)</p>
                            @error('jumlah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Note --}}
                        <div class="mb-6">
                            <label for="note" class="block text-sm font-medium text-gray-700">
                                Catatan (Opsional)
                            </label>
                            <textarea name="note" id="note" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('note') border-red-500 @enderror"
                                      placeholder="Contoh: Gaji bulan Januari, Bayar listrik, dll">{{ old('note') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
                            @error('note')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preview Summary --}}
                        <div id="summary" class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-md hidden">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Ringkasan Transaksi</h4>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">User:</span>
                                    <span id="summary-user" class="font-medium text-gray-900">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jenis:</span>
                                    <span id="summary-jenis" class="font-medium">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jumlah:</span>
                                    <span id="summary-jumlah" class="font-medium text-gray-900">-</span>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                            <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Transaksi
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const radioInputs = document.querySelectorAll('input[type="radio"][name="jenis_transaksi"]');
                    
                    // Add border highlight on change
                    radioInputs.forEach(radio => {
                        radio.addEventListener('change', function() {
                            // Remove highlight from all
                            radioInputs.forEach(r => {
                                r.closest('label').classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500');
                            });
                            // Add highlight to selected
                            if (this.checked) {
                                this.closest('label').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
                            }
                            updateSummary();
                        });
                    });
                    
                    // Update summary preview
                    function updateSummary() {
                        const user = document.getElementById('user_id');
                        const jenis = document.querySelector('input[name="jenis_transaksi"]:checked');
                        const jumlah = document.getElementById('jumlah');
                        
                        if (user.value && jenis && jumlah.value) {
                            document.getElementById('summary').classList.remove('hidden');
                            document.getElementById('summary-user').textContent = user.options[user.selectedIndex].text;
                            
                            const jenisText = jenis.value === 'M' ? 'Masuk (Nabung)' : 'Keluar (Tarik)';
                            const jenisColor = jenis.value === 'M' ? 'text-green-600' : 'text-red-600';
                            const jenisEl = document.getElementById('summary-jenis');
                            jenisEl.textContent = jenisText;
                            jenisEl.className = `font-medium ${jenisColor}`;
                            
                            const formattedJumlah = 'Rp ' + parseInt(jumlah.value).toLocaleString('id-ID');
                            document.getElementById('summary-jumlah').textContent = formattedJumlah;
                        } else {
                            document.getElementById('summary').classList.add('hidden');
                        }
                    }

                    document.getElementById('user_id').addEventListener('change', updateSummary);
                    document.getElementById('jumlah').addEventListener('input', updateSummary);

                    // Format number input
                    document.getElementById('jumlah').addEventListener('blur', function() {
                        if (this.value) {
                            this.value = Math.round(this.value);
                        }
                    });
                });
            </script>
            @endpush
</x-app-layout>