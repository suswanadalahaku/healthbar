<x-slot name="header">
    <span class="flex">
        <a href="{{ route('profile') }}" class="font-semibold text-xl text-gray-800 leading-tight mr-5" wire:navigate>
            {{ __('Profile') }}
        </a>
        @if (Auth::user()->id_role === 3)
            <a href="{{  route('chat-history')}}" class="font-semibold text-xl text-gray-800 leading-tight" wire:navigate>
                {{ __('Histori Konsultasi') }}
            </a>
        @endif
    </span>
</x-slot>

<div class="py-12" style="background-color: #F4F2E0;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-6 bg-gray-50 rounded-lg shadow-md" wire:poll>
            <h2 class="text-xl font-semibold mb-6 text-gray-800">RIWAYAT KONSULTASI</h2>
        
            @forelse ($sessions as $session)
                <div class="cursor-pointer mb-6 p-4 bg-white rounded-lg shadow-sm border border-gray-200" wire:click="selectDate('{{ $session->created_at->toDateString() }}')">
                    <div class="flex justify-between items-center" >
                        <!-- Tanggal chat, di sebelah kiri -->
                        <h3 class="font-medium text-lg">
                            <!-- Tampilkan hanya tanggal chat dan gunakan wire:click untuk toggle -->
                            <p class="text-blue-600"> {{ $session->created_at->format('d M Y') }} </p>
                            <p class="text-gray-900 text-sm font-medium">
                                <strong>{{ $session->messages->last()->fromUser->name }} : </strong> 
                                 {{ $session->messages->last()->message }} ---
                                 {{ $session->messages->last()->created_at->diffForHumans() }}
                            </p>
                        </h3>
        
                        <!-- Tanggal chat di sebelah kanan -->
                        <span class="text-sm text-gray-500">
                            {{ $session->messages->last()->created_at->format('d M Y H:i') }}
                        </span>
                    </div>
        
                    <!-- Menampilkan pesan terakhir -->
                    @if ($selectedDate && $session->created_at->toDateString() == $selectedDate)
                        <div class="mt-2">
                            <!-- Menampilkan seluruh pesan -->
                            @foreach ($session->messages as $message)
                                <div class="border-b py-2">
                                    <strong>{{ $message->fromUser->name }}:</strong>
                                    <p class="text-gray-800">{{ $message->message }}</p>
                                    <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500">You have no chat history.</p>
            @endforelse
        </div>
    </div>
</div>