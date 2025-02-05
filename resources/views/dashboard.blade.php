<x-app-layout>
    <div class="min-h-screen bg-gray-100">

        <!-- Hero Section -->
        <div class="container mx-auto px-8 py-12 flex flex-col lg:flex-row items-center gap-8" style="background-color: #F4F2E0;">
            <div class="lg:w-1/2 ml-28">
                <h1 class="text-4xl font-bold text-gray-900">Welcome To Healthbar</h1>
                <p class="mt-4 text-lg text-gray-700">Baca dan Konsultasi!</p>
                <p class="mt-2 text-gray-600">Website yang menyediakan layanan konsultasi dengan dokter psikologi profesional dan menyajikan berbagai artikel mengenai kesehatan mental.</p>
                <div class="mt-4 flex space-x-4">
                    @guest
                        <!-- Jika belum login, tampilkan tombol Konsultasi -->
                        <x-secondary-button :href="route('start-chat', ['receiverId' => 2])" wire:navigate class="bg-white text-gray-800">
                            {{ __('Konsultasi') }}
                        </x-secondary-button>
                    @endguest
                    @auth
                        @if (auth()->user()->id_role == 3)
                            <x-secondary-button :href="route('start-chat', ['receiverId' => 2])" wire:navigate class="bg-white text-gray-800">
                                {{ __('Konsultasi') }}
                            </x-secondary-button>
                            <x-secondary-button>
                                {{ __('History') }}    
                            </x-secondary-button>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="lg:w-1/2">
                <img src="{{ asset('storage/assets/dashboard_bg.png') }}" alt="dashboard_bg" class="w-full max-w-md mx-auto">
            </div>
        </div>

        <!-- Artikel Section -->
        <div class="bg-gray-50 py-12">
            <div class="container mx-auto px-8">
                
                @auth
                    <!-- Konten untuk pengguna yang sudah login -->
                    @if (auth()->user()->id_role == 1)
                        @livewire('dashboard-admin')
                    @elseif(auth()->user()->id_role == 2)
                        @livewire('dashboard-dokter')
                    {{-- @elseif(auth()->user()->id_role == 3)
                        <x-dropdown-link :href="route('start-chat', ['receiverId' => 3])" wire:navigate>
                            {{ __('Chat') }}
                        </x-dropdown-link> --}}
                    @endif
                    @else
                        <!-- Konten untuk guest -->
                        <p class="mt-4 text-gray-700">Silakan <span class="font-bold text-center">Login</span> untuk fitur lebih lengkap.</p>
                @endauth
                <h2 class="text-2xl font-bold text-gray-900 mt-10">Tambah Pengetahuanmu!</h2>
                @livewire('tampil-artikel')
            </div>
        </div>
    </div>
</x-app-layout>
