<nav x-data="{ open: false }" class="bg-gradient-to-r from-primary-600 to-primary-700 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 1 ? route('admin.dashboard') : route('user.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white hidden md:block">Family Wallet</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    @if(Auth::user()->role === 1)
                        {{-- Admin Navigation --}}
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Users
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Transactions
                        </a>
                        <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.profile.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                    @else
                        {{-- User Navigation --}}
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('user.transactions.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('user.transactions.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Transactions
                        </a>
                        <a href="{{ route('user.profile.edit') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('user.profile.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Side (User Info & Logout) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- User Info -->
                <div class="flex items-center space-x-3 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-lg">
                    <div class="text-right">
                        <div class="text-sm font-semibold text-white">{{ Auth::user()->nama }}</div>
                        <div class="text-xs text-white/70">{{ Auth::user()->username }}</div>
                    </div>
                    <div class="w-10 h-10">
                        @if(Auth::user()->photo)
                            <img class="w-10 h-10 rounded-full ring-2 ring-white/50" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->nama }}">
                        @else
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center ring-2 ring-white/50">
                                <span class="text-white font-bold text-sm">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium rounded-lg transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white/80 hover:text-white hover:bg-white/10 focus:outline-none focus:bg-white/20 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/20">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 1)
                {{-- Admin Mobile Navigation --}}
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-200">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-200">
                    Users
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('admin.transactions.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-200">
                    Transactions
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('admin.profile.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-200">
                    Profile
                </a>
            @else
                {{-- User Mobile Navigation --}}
                <a href="{{ route('user.dashboard') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('user.dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-200">
                    Dashboard
                </a>
                <a href="{{ route('user.transactions.index') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('user.transactions.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-200">
                    Transactions
                </a>
                <a href="{{ route('user.profile.edit') }}" class="block px-4 py-3 text-base font-medium {{ request()->routeIs('user.profile.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-200">
                    Profile
                </a>
            @endif
        </div>

        <!-- Responsive User Info & Logout -->
        <div class="pt-4 pb-3 border-t border-white/20">
            <div class="px-4 mb-3">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12">
                        @if(Auth::user()->photo)
                            <img class="w-12 h-12 rounded-full ring-2 ring-white/50" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->nama }}">
                        @else
                            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center ring-2 ring-white/50">
                                <span class="text-white font-bold">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="text-base font-semibold text-white">{{ Auth::user()->nama }}</div>
                        <div class="text-sm text-white/70">{{ Auth::user()->username }}</div>
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 text-base font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>