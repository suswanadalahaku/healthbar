<div class="py-12" wire:poll>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="p-6 bg-[#9BD6AE] text-white">
                <h1 class="text-2xl font-bold">Dashboard Admin</h1>
                <p class="text-sm mt-1">Kelola pengguna dan artikel dengan mudah.</p>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-6">
                <!-- List Pengguna -->
                {{-- <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">List Pengguna</h2>
                    <ul class="space-y-2">
                        @foreach ($users as $user)
                            <li class="list-none">
                                <x-dropdown-link :href="route('chat', $user)" wire:navigate>
                                    <div class="flex items-center gap-2 text-blue-600 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm2 2a1 1 0 112 0 1 1 0 01-2 0zm-1 5a1 1 0 011.707-.707l1.586 1.586 2.586-2.586A1 1 0 0112.707 9.707l-3 3a1 1 0 01-1.414 0L5 10.414A1 1 0 015 10z" />
                                        </svg>
                                        {{ $user->name }}
                                    </div>
                                </x-dropdown-link>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}

                <!-- List Artikel -->
                {{-- <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">List Artikel</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($articles as $article)
                            <div class="bg-gray-100 border border-gray-300 rounded-lg shadow-sm overflow-hidden">
                                <img 
                                    src="{{ $article->image ? Storage::url($article->image) : 'https://via.placeholder.com/150' }}" 
                                    alt="{{ $article->title }}" 
                                    class="w-full h-40 object-cover"
                                >
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-800 truncate">{{ $article->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1 truncate">
                                        {{ Str::limit(strip_tags($article->content), 80) }}
                                    </p>
                                    <div class="mt-4">
                                        <a href="{{ route('edit-artikel', $article->id) }}" 
                                            class="inline-block bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600"
                                        >
                                            Edit Artikel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}

                {{-- Artikel Ditolak --}}
                <div class="p-12">
                    <h1 class="text-2xl text-gray-800 font-bold mb-6">Daftar Artikel yang Ditolak</h1>
                    
                    <div class="overflow-x-auto">
                        <table class="table w-full bg-[#F4F2E0] shadow-lg rounded-lg">
                            <thead class="bg-[#FF5E5E] text-white">
                                <tr>
                                    <th class="py-3 px-4">Judul</th>
                                    <th class="py-3 px-4">Pesan Penolakan</th>
                                    <th class="py-3 px-4">Tanggal Ditolak</th>
                                    <th class="py-3 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rejectedArticles as $validateArticle)
                                <tr class="hover:bg-[#FDC786]">
                                    <td class="text-gray-800 py-3 px-4">{{ $validateArticle->article->title }}</td>
                                    <td class="text-gray-800 py-3 px-4">{{ $validateArticle->message }}</td>
                                    <td class="text-gray-800 py-3 px-4">{{ $validateArticle->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-3 px-4">
                                        @if ($validateArticle->status == 'pending')
                                            <span class="cursor-default text-red-400 px-2 py-1 rounded-lg">Pending</span>
                                        @else
                                            <a href="{{ route('edit-artikel', $validateArticle->article->id) }}" 
                                                class="btn bg-[#9BD6AE] text-gray-800 hover:bg-green-400 btn-sm">
                                                Revisi
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                
                
            </div>
        </div>
    </div>
</div>
