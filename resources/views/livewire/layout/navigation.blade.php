<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Tambahkan menu Artikel untuk semua user -->
                    @auth
                        <x-nav-link :href="route('tampil-artikel')" :active="request()->routeIs('tampil-artikel')" wire:navigate>
                            {{ __('Artikel') }}
                        </x-nav-link>

                        <!-- Tambahkan menu jika id_role == 1 -->
                        @if(auth()->user()->id_role == 1)
                            <x-nav-link :href="route('tambah-artikel')" :active="request()->routeIs('tambah-artikel')">
                                {{ __('Tambah Artikel') }}
                            </x-nav-link>
                        @endif

                        <!-- Tambahkan menu jika id_role == 2 -->
                        @if(auth()->user()->id_role == 2)
                            <x-nav-link :href="route('tinjau-artikel')" :active="request()->routeIs('tinjau-artikel')" wire:navigate>
                                {{ __('Tinjau Artikel') }}
                            </x-nav-link>
                        @endif

                        <!-- Tambahkan menu jika id_role == 3 -->
                        @if(auth()->user()->id_role == 3)
                            <x-nav-link :href="route('chat-history')" :active="request()->routeIs('chat-history')" wire:navigate>
                                {{ __('Histori') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                    <p class="cursor-default mx-1">{{ __('|') }}</p>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('tampil-artikel')" :active="request()->routeIs('tampil-artikel')" wire:navigate>
                    {{ __('Artikel') }}
                </x-responsive-nav-link>
                @if(auth()->user()->id_role == 1)
                    <x-responsive-nav-link :href="route('tambah-artikel')" :active="request()->routeIs('tambah-artikel')">
                        {{ __('Tambah Artikel') }}
                    </x-responsive-nav-link>
                @endif
                @if(auth()->user()->id_role == 2)
                    <x-responsive-nav-link :href="route('tinjau-artikel')" :active="request()->routeIs('tinjau-artikel')" wire:navigate>
                        {{ __('Tinjau Artikel') }}
                    </x-responsive-nav-link>
                @endif
                @if(auth()->user()->id_role == 3)
                    <x-responsive-nav-link :href="route('chat-history')" :active="request()->routeIs('chat-history')" wire:navigate>
                        {{ __('Histori') }}
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>
