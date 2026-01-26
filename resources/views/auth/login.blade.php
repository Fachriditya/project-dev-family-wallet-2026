<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    {{-- Header --}}
    <div class="mb-8 text-center">
        <div class="inline-block">
            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
            Family Wallet
        </h1>
        <p class="text-sm text-gray-600 mt-2">Sistem Tabungan Keluarga</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Username --}}
        <div>
            <x-input-label for="username" :value="__('Username')" class="text-gray-700 font-semibold" />
            <x-text-input
                id="username"
                class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                type="text"
                name="username"
                :value="old('username')"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan username Anda"
            />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input
                id="password"
                class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Masukkan password Anda"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 transition-all duration-200"
                name="remember"
            >
            <label for="remember_me" class="ml-2 text-sm text-gray-600 cursor-pointer">
                {{ __('Remember me') }}
            </label>
        </div>

        {{-- Login Button --}}
        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    {{-- Footer --}}
    <div class="mt-6 text-center text-xs text-gray-500">
        © {{ date('Y') }} Family Wallet. All rights reserved.
    </div>
</x-guest-layout>