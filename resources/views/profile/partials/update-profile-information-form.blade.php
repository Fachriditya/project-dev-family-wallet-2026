<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form method="post" action="{{ route(Auth::user()->role === 1 ? 'admin.profile.update' : 'user.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Current Photo --}}
        @if($user->photo)
        <div class="text-center">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil Saat Ini</label>
            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->nama }}" class="h-32 w-32 mx-auto object-cover rounded-full border-2 border-gray-200">
        </div>
        @endif

        {{-- Nama --}}
        <div>
            <x-input-label for="nama" :value="__('Nama Lengkap')" />
            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $user->nama)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
        </div>

        {{-- Username --}}
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
            <p class="mt-1 text-xs text-gray-500">Username digunakan untuk login</p>
        </div>

        {{-- Photo Upload --}}
        <div>
            <x-input-label for="photo" :value="__('Ganti Foto Profil (Opsional)')" />
            <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/jpg" 
                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            
            {{-- Preview --}}
            <div id="photo-preview" class="mt-3 hidden">
                <img src="" alt="Preview" class="h-32 w-32 object-cover rounded-full border-2 border-gray-200">
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

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
</section>