<div class="min-h-screen bg-gray-100 flex">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full space-y-6">
        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-800">Edit Artikel</h2>

        <!-- Form -->
        <form id="editForm" method="POST" action="{{ route('update-article', $articleId) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $title) }}" 
                    placeholder="Edit Judul" 
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- File Upload -->
            <div class="w-fit h-fit border-2 border-dashed border-gray-300 rounded-lg flex justify-center items-center relative bg-gray-50">
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/*" 
                    class="absolute inset-0 opacity-0 cursor-pointer"
                    onchange="previewImage(event)"
                />
                <div id="imagePreview" class="w-full h-full object-cover rounded-lg">
                    @if ($existingImage)
                        <img src="{{ Storage::url($existingImage) }}" alt="Existing Image" id="previewImg" />
                    @endif
                </div>
            </div>
            @error('image')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Content -->
            <div wire:ignore>
                <textarea 
                    id="editor" 
                    name="content" 
                    class="w-full h-40 border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $content) }}</textarea>
                @error('content')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button 
                type="button" 
                class="w-full bg-blue-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                onclick="openConfirmationModal()">
                    Simpan Perubahan
            </button>
        </form>

        <!-- Modal Konfirmasi -->
        <dialog id="confirmation_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Konfirmasi Perubahan Artikel</h3>
                <p>Apakah Anda yakin ingin menyimpan perubahan ini?</p>
                <div class="modal-action">
                    <button 
                        type="submit" 
                        form="editForm" 
                        class="btn bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded-lg">
                        Yes
                    </button>
                    <button 
                        type="button" 
                        class="btn bg-gray-300 text-gray-700 hover:bg-gray-400 px-4 py-2 rounded-lg" 
                        onclick="closeConfirmationModal()">No</button>
                </div>
            </div>
        </dialog>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.setData(@json($content)); // Load content ke editor
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                });

                Livewire.on('reset-editor', () => {
                    editor.setData('');
                });
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });
    });

    function openConfirmationModal() {
        document.getElementById('confirmation_modal').showModal();
    }

    function closeConfirmationModal() {
        document.getElementById('confirmation_modal').close();
    }

    function confirmSaveContent() {
        closeConfirmationModal();
        Livewire.dispatch('confirmSave'); // Emit event ke Livewire untuk menyimpan artikel
    }

    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
