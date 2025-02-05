{{-- <script src="https://cdn.tailwindcss.com"></script>


<x-app-layout>
    <x-slot name="header">
        @auth
            @if(auth()->user()->id_role == 2)
                <!-- Menu Tampil Artikel -->
                <a href="{{ route('tampil-artikel') }}" 
                wire:navigate
                class="{{ request()->routeIs('tampil-artikel') ? 'text-blue-500 font-bold' : 'text-gray-700' }} hover:text-blue-500 mr-5">
                    Tampil Artikel
                </a>

                <!-- Menu Tinjau Artikel -->
                <a href="{{ route('tinjau-artikel') }}"
                wire:navigate 
                class="{{ request()->routeIs('tinjau-artikel') ? 'text-blue-500 font-bold' : 'text-gray-700' }} hover:text-blue-500">
                    Tinjau Artikel
                </a>
            @endif
        @endauth
    </x-slot>
    <div class="py-8">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Daftar Artikel Disetujui</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                <a href="{{ route('detail-artikel', $article->id) }}" class="block">
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">{{ $article->title }}</h2>
                            <p class="text-sm text-gray-500">{{ $article->created_at->format('d M Y') }}</p>
                        </div>

                        @if($article->image)
                        <img 
                            src="{{ asset('storage/' . $article->image) }}" 
                            alt="{{ $article->title }}" 
                            class="w-full h-48 object-cover"
                        >
                        @endif

                        <div class="p-6">
                            <div class="text-gray-700 text-sm leading-relaxed line-clamp-3">
                                {!! Str::limit(strip_tags($article->content), 200, '...') !!}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout> --}}
