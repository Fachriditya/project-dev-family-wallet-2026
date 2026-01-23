<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Current Photo --}}
                        @if($user->photo)
                            <div class="mb-4 text-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->nama }}" class="h-32 w-32 mx-auto object-cover rounded-full border-2 border-gray-200">
                            </div>
                        @endif

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-500 @enderror">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('username') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Username harus unik dan akan digunakan untuk login</p>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Password --}}
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Password tidak akan diubah. Gunakan tombol "Reset Password" di halaman user jika ingin mereset password ke default (123456).
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Photo --}}
                        <div class="mb-6">
                            <label for="photo" class="block text-sm font-medium text-gray-700">
                                Ganti Foto Profil (Opsional)
                            </label>
                            <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/jpg" 
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('photo') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            {{-- Preview --}}
                            <div id="photo-preview" class="mt-3 hidden">
                                <img src="" alt="Preview" class="h-32 w-32 object-cover rounded-full border-2 border-gray-200">
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update User
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Preview Photo Script --}}
    @push('scripts')
    <script>
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photo-preview');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush
</x-app-layout>