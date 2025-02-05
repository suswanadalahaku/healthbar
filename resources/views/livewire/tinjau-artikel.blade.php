{{-- <x-slot name="header">
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
</x-slot> --}}

<div class="py-12">
    <div class="container mx-auto px-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($articles as $article)
            <a href="{{ route('detail-artikel', $article->id) }}" class="block">
                <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                    
                    @if($article->image)
                    <img 
                        src="{{ asset('storage/' . $article->image) }}" 
                        alt="{{ $article->title }}" 
                        class="w-full h-52 object-cover skeleton !rounded-none"
                    >
                    @endif

                    <div class="p-5 flex flex-col flex-grow">
                        <h2 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $article->title }}</h2>

                        <p class="text-xs text-gray-500 mt-2">{{ $article->created_at->format('d M Y') }}</p>
                        
                        <div class="mt-3 text-gray-700 text-sm line-clamp-2 flex-grow">
                            {!! Str::limit(strip_tags($article->content), 120, '...') !!}
                        </div>
                    </div>

                    <div class="border-t border-gray-200 p-4 bg-gray-50 text-center">
                        <span class="hover:font-bold text-green-500">Baca Selengkapnya &rarr;</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
