<div class="min-h-screen bg-gray-100 justify-center p-6">
    <!-- Fullscreen Form -->
    <div class="bg-white shadow-lg rounded-lg p-6 w-full space-y-6">
        <!-- Header -->
        <h2 class="text-2xl font-semibold text-gray-800">Tambah Artikel</h2>

        <!-- Form -->
        <form id="articleForm" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    placeholder="Masukkan Judul" 
                    class="w-full border border-gray-300 rounded-lg p-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" 
                />
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- File Upload with Preview -->
            <div class="w-full bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center relative p-6">
                <!-- Preview Area -->
                <div id="imagePreview" class="relative overflow-hidden hidden">
                    <img id="previewImg" src="#" alt="Preview Image" class="object-cover h-full w-full" />
                </div>

                <!-- File Input -->
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/*" 
                    onchange="previewImage(event)" 
                    class="absolute inset-0 opacity-0 cursor-pointer" 
                />
                <div class="text-gray-400 text-lg flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm2 2a1 1 0 112 0 1 1 0 01-2 0zm-1 5a1 1 0 011.707-.707l1.586 1.586 2.586-2.586A1 1 0 0112.707 9.707l-3 3a1 1 0 01-1.414 0L5 10.414A1 1 0 015 10z" />
                    </svg>
                    <span>Klik atau seret file untuk mengupload gambar</span>
                    <span>Max 2MB</span>
                </div>
            </div>
            @error('image')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Content -->
            <div>
                <textarea 
                    id="editor" 
                    name="content" 
                    class="w-full h-64 border border-gray-300 rounded-lg p-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"></textarea>
            </div>
            @error('content')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Submit Button -->
            <button 
                type="button" 
                onclick="openConfirmationModal()" 
                class="w-full bg-green-500 text-white font-medium py-3 px-4 rounded-lg text-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                Submit
            </button>
        </form>
    </div>

    <!-- Modal Konfirmasi -->
    <dialog id="confirmation_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Konfirmasi Tambah Artikel</h3>
            <p>Apakah Anda yakin ingin menambahkan artikel ini?</p>
            <div class="modal-action">
                <button
                        type="submit" 
                        form="articleForm" 
                        class="btn bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded-lg">
                    Yes
                </button>
                <button type="button" 
                        class="btn bg-gray-300 text-gray-700 hover:bg-gray-400 px-4 py-2 rounded-lg" 
                        onclick="closeConfirmationModal()">No</button>
            </div>
        </div>
    </dialog>
</div>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => console.error('CKEditor error:', error));
    });

    function openConfirmationModal() {
        const modal = document.getElementById('confirmation_modal');
        modal.showModal();
    }

    function closeConfirmationModal() {
        const modal = document.getElementById('confirmation_modal');
        modal.close();
    }

    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        } else {
            alert('Harap pilih gambar yang valid!');
            imagePreview.classList.add('hidden');
        }
    }
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
