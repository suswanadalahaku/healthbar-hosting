<div class="min-h-screen bg-gray-100 flex" wire:poll>
    <div class="bg-white shadow-lg rounded-lg p-6 w-full space-y-6">
        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-800">Tambah Artikel</h2>

        <!-- Form -->
        <form wire:submit.prevent="saveContent" class="space-y-6">
            <!-- Title -->
            <input 
                type="text" 
                wire:model="title" 
                placeholder="Masukan Judul" 
                class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
            />

            <!-- File Upload -->
            <div class="w-fit h-fit border-2 border-dashed border-gray-300 rounded-lg flex justify-center items-center relative bg-gray-50" 
                wire:ignore.self>
                @if($hasImage && $image)
                    <!-- Pratinjau Gambar -->
                    <img src="{{ $image->temporaryUrl() }}" alt="Uploaded Image" class="w-fit h-fit object-cover rounded-lg">
                @else
                    <!-- Area Unggah Gambar -->
                    <input 
                        type="file" 
                        wire:model="image" 
                        accept="image/*" 
                        class="absolute inset-0 opacity-0 cursor-pointer" 
                    />
                    <div class="text-gray-400 m-4 text-sm flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm2 2a1 1 0 112 0 1 1 0 01-2 0zm-1 5a1 1 0 011.707-.707l1.586 1.586 2.586-2.586A1 1 0 0112.707 9.707l-3 3a1 1 0 01-1.414 0L5 10.414A1 1 0 015 10z" />
                        </svg>
                        <span>Klik Disini Untuk Mengupload Gambar</span>
                    </div>
                @endif
            </div>


            <!-- Editor -->
            <div wire:ignore>
                <textarea id="editor" class="w-full h-40 border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button 
                type="button" 
                class="w-full bg-green-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                onclick="openConfirmationModal()">
                Selesai
            </button>
        </form>
        <!-- Submit Button -->
    </div>
    <!-- Modal Konfirmasi -->
    <dialog id="confirmation_modal" class="modal" wire:ignore>
        <div class="modal-box bg-white">
            <h3 class="text-lg font-bold">Konfirmasi Tambah Artikel</h3>
            <p>Apakah Anda yakin ingin menambahkan artikel ini?</p>
            <div class="modal-action">
                <button type="button" 
                        class="btn bg-green-500 text-white hover:bg-green-600" 
                        onclick="confirmSaveContent()">Yes</button>
                <button type="button" 
                        class="btn bg-gray-300 text-gray-700 hover:bg-gray-400" 
                        onclick="closeConfirmationModal()">No</button>
            </div>
        </div>
    </dialog>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                // Sinkronisasi data ke Livewire
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                });

                // Reset editor saat ada event dari Livewire
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
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
