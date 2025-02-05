<script src="https://cdn.tailwindcss.com"></script>
<x-app-layout style="background-color: #F4F2E0;">
    <div class="flex justify-center py-12 px-6">
        <div class="bg-white shadow-lg rounded-xl max-w-5xl w-full p-8">
            
            <!-- Tombol Back -->
            <div class="mb-6">
                <a href="{{ url()->previous() }}" 
                   class="btn btn-outline btn-primary">← Kembali</a>
            </div>
            
            <!-- Judul Artikel -->
            <h1 class="text-3xl font-bold text-gray-800">{{ $article->title }}</h1>
            <p class="text-sm text-gray-500 mb-6">{{ $article->created_at->format('d M Y') }}</p>

            <!-- Gambar Artikel -->
            @if($article->image)
            <img 
                src="{{ asset('storage/' . $article->image) }}" 
                alt="{{ $article->title }}" 
                class="w-full h-auto mb-6 rounded-lg shadow-md">
            @endif
            
            <!-- Isi Artikel -->
            <div class="prose max-w-none text-gray-700">
                {!! $article->content !!}
            </div>
            
            <!-- Tombol Aksi (Admin/Editor) -->
            @if(auth()->user()->id_role == 2 && $article->is_approved === 0)
                <div class="mt-8 flex gap-4">
                    <button type="button" 
                            class="btn btn-success" 
                            onclick="openModal('approve', '{{ route('approve-artikel', $article->id) }}')">
                        Approve
                    </button>
                    <button type="button" 
                            class="btn btn-error" 
                            onclick="openRejectModal('{{ route('reject-artikel', $article->id) }}')">
                        Reject
                    </button>
                </div>
            @endif

            @if(auth()->user()->id_role == 1)
                <div class="mt-8 text-center">
                    <button type="button" 
                            class="btn btn-error" 
                            onclick="openDeleteModal('{{ route('delete-artikel', $article->id) }}')">
                        Hapus Artikel
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Reject -->
    <dialog id="reject_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Tolak Artikel</h3>
            <form id="reject-form" method="POST" action="">
                @csrf
                <textarea name="message" rows="4" class="textarea textarea-bordered w-full mt-2" placeholder="Alasan penolakan" required></textarea>
                <div class="modal-action">
                    <button type="button" class="btn" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn btn-error">Tolak</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal Approve -->
    <dialog id="approve_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Setujui Artikel</h3>
            <p>Apakah Anda yakin ingin menyetujui artikel ini?</p>
            <form id="approve-form" method="POST" action="">
                @csrf
                <div class="modal-action">
                    <button type="button" class="btn" onclick="closeApproveModal()">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal Hapus -->
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Hapus Artikel</h3>
            <p>Apakah Anda yakin ingin menghapus artikel ini?</p>
            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-action">
                    <button type="button" class="btn" onclick="closeDeleteModal()">Batal</button>
                    <button type="submit" class="btn btn-error">Hapus</button>
                </div>
            </form>
        </div>
    </dialog>
    
    <script>
    function openRejectModal(url) {
        document.getElementById('reject-form').action = url;
        document.getElementById('reject_modal').showModal();
    }

    function closeRejectModal() {
        document.getElementById('reject_modal').close();
    }

    function openModal(type, url) {
        if (type === 'approve') {
            document.getElementById('approve-form').action = url;
            document.getElementById('approve_modal').showModal();
        }
    }

    function closeApproveModal() {
        document.getElementById('approve_modal').close();
    }

    function openDeleteModal(url) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete_modal').showModal();
    }

    function closeDeleteModal() {
        document.getElementById('delete_modal').close();
    }
    </script>
</x-app-layout>