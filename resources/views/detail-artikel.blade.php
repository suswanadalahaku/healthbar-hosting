<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout style="background-color: #F4F2E0;">
    <div class="p-12">
        <div class="bg-gray-100 py-8 px-24">
            <div class="container mx-auto p-4">
                <!-- Tombol Back -->
                <div class="mb-6">
                    <a href="{{ url()->previous() }}" 
                       class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                        ← Back
                    </a>
                </div>

                <!-- Konten Artikel -->
                <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $article->title }}</h1>
                <p class="text-sm text-gray-500 mb-6">{{ $article->created_at->format('d M Y') }}</p>
        
                @if($article->image)
                <img 
                    src="{{ asset('storage/' . $article->image) }}" 
                    alt="{{ $article->title }}" 
                    class="w-full h-auto mb-6 rounded-lg shadow-md"
                >
                @endif
        
                <div class="prose max-w-none text-gray-700">
                    {!! $article->content !!}
                </div>

                <!-- Tombol Approve/Reject -->
                @if(auth()->user()->id_role == 2 && $article->is_approved === 0)
                    <div class="mt-8">
                        <!-- Tombol Approve -->
                        <button type="button" 
                                class="px-4 py-2 bg-green-500 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-green-600 transition duration-200" 
                                onclick="openModal('approve', '{{ route('approve-artikel', $article->id) }}')">
                            Approve
                        </button>
                    
                        <!-- Tombol Reject -->
                        <button type="button" 
                                class="px-4 py-2 bg-red-500 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-red-600 transition duration-200 ml-2" 
                                onclick="openRejectModal('{{ route('reject-artikel', $article->id) }}')">
                            Reject
                        </button>
                    </div>
                @endif

                @if(auth()->user()->id_role == 1)
                    <div class="mt-8 text-center">
                        <button type="button" 
                                class="px-4 py-2 bg-red-500 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-red-600 transition duration-200" 
                                onclick="openDeleteModal('{{ route('delete-artikel', $article->id) }}')">
                            Hapus Artikel
                        </button>
                    </div>
                @endif
            </div>
            
            <!-- PopUp Notification -->
            <!-- Modal Form Reject -->
            <dialog id="reject_modal" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Tolak Artikel</h3>
                    <form id="reject-form" method="POST" action="">
                        @csrf
                        <textarea 
                            name="message" 
                            rows="4" 
                            class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" 
                            placeholder="Masukkan alasan kenapa artikel ini ditolak"
                            required></textarea>
                        <div class="modal-action">
                            <button type="button" class="btn close" onclick="closeRejectModal()">Batal</button>
                            <button type="submit" class="btn bg-red-500 text-white hover:bg-red-600">Kirim Penolakan</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- Modal Form Approve -->
            <dialog id="approve_modal" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Setujui Artikel</h3>
                    <p>Apakah Anda yakin ingin memvalidasi dan merilis artikel ini?</p>
                    <form id="approve-form" method="POST" action="">
                        @csrf
                        <div class="modal-action">
                            <button type="button" class="btn close" onclick="closeApproveModal()">Batal</button>
                            <button type="submit" class="btn bg-green-500 text-white hover:bg-green-600">Setujui</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- Modal Form Delete -->
            <dialog id="delete_modal" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Hapus Artikel</h3>
                    <p>Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <form id="delete-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="modal-action">
                            <button type="button" class="btn close" onclick="closeDeleteModal()">Batal</button>
                            <button type="submit" class="btn bg-red-500 text-white hover:bg-red-600">Hapus</button>
                        </div>
                    </form>
                </div>
            </dialog>

        </div>

        


    </div>

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
