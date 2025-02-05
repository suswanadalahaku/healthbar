<div wire:poll.5 class="p-6 bg-gray-100 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
        <img src="{{ asset('storage/assets/users.svg') }}" class="w-6 h-6 text-blue-600 mr-2">

        List Pasien
    </h1>

    @php
        $adaPesanBaru = false;
    @endphp

    <ul class="space-y-4">
        @foreach ($users as $user)
            @php
                $pesanTerakhir = $user->messages()->latest()->first();
                $adaPesan = $pesanTerakhir !== null;
                if ($adaPesan) {
                    $adaPesanBaru = true;
                }
            @endphp

            @if ($adaPesan)
                <li class="bg-white p-4 rounded-lg shadow flex items-center justify-between border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <x-dropdown-link :href="route('chat', $user)" wire:navigate class="flex items-center w-full">
                        <!-- Avatar -->
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-blue-500">
                                <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" alt="User Avatar" class="w-full h-full object-cover">
                            </div>
                            @if ($user->unreadMessages->count() > 0)
                                <span class="absolute bottom-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ $user->unreadMessages->count() }}
                                </span>
                            @endif
                        </div>

                        <!-- Name & Last Message -->
                        <div class="ml-4 flex-grow">
                            <p class="text-gray-800 font-semibold text-lg">{{ $user->name }}</p>
                            <p class="text-gray-500 text-sm flex items-center justify-between">
                                <span class="flex items-center">
                                    <img src="{{ asset('storage/assets/message.svg') }}" class="w-4 h-4 mr-2">
                                    {{ Str::limit($pesanTerakhir->message, 40) }}
                                </span>
                                <span class="ml-auto">{{ $pesanTerakhir->created_at->diffForHumans() }}</span>
                            </p>
                        </div>
                        
                    </x-dropdown-link>
                </li>
            @endif
        @endforeach
    </ul>

    @if (!$adaPesanBaru)
        <div class="text-gray-500 text-center mt-6">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v2m0 4h.01m-6.938-2a7.938 7.938 0 1115.876 0M12 10v4"></path>
            </svg>
            <p class="text-lg">Belum ada pesan dari masyarakat.</p>
        </div>
    @endif
</div>
