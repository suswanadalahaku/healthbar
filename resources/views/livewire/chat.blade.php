<div class="h-screen flex flex-col scroll-smooth" style="background-color: #F4F2E0;" wire:poll>
    <!-- Header -->
    <div class="card rounded-box text-xl font-semibold text-gray-900 divider divider-neutral mx-12">Chat with {{ $this->getChatWithUserName() }}</div>

    <!-- Notifikasi Chat Berakhir -->
    @if ($isEnded)
        <div role="alert" class="mb-6 relative flex w-full p-4 text-sm text-white bg-red-600 rounded-lg shadow-lg">
            <span class="font-semibold">Sesi Chat Telah Berakhir. Tekan Tombol Untuk Kembali Ke Beranda</span>
        </div>
        <div class="text-center my-4">
            <a href="{{ route('dashboard') }}" 
                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-3 shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                Kembali Ke Beranda
            </a>
        </div>
    @else
        <!-- Chat Box -->
        <div 
            class="overflow-y-scroll scroll-smooth mx-12 py-4" 
            style="background-color: #F4F2E0; height: 72vh;" 
            id="chatBox">
            @foreach ($messages as $message)
                <div class="chat 
                    @if($message->fromUser->id == Auth()->id()) chat-end  
                    @else chat-start 
                    @endif">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt="User Avatar" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                        </div>
                    </div>
                    <div class="chat-header px-2">
                        {{ $message->fromUser->name ?? 'Unknown User' }}
                    </div>
                    <div class="chat-bubble">{{ $message->message }}</div>
                    <div class="chat-footer opacity-50 
                    @if ($message->fromUser->id != Auth()->id())hidden
                    @endif">{{ $message->is_read == 1 ? 'Read' : 'Unread' }}</div>
                    <time class="text-xs opacity-50">{{ $message->created_at->diffForHumans() }}</time>
                </div>
            @endforeach
        </div>

        <!-- Input Form -->
        <div class="py-4 flex items-center gap-2" style="background-color : #FDC786;">
            <!-- Textarea -->
            <textarea 
                class="textarea text-gray-900 textarea-success bg-white flex-1 ml-12 h-12 resize-none" 
                wire:model="message"
                wire:keydown.enter.prevent="sendMessage"  
                placeholder="Write your message..."
                required>
            </textarea>

            <!-- Buttons Container -->
            <div class="flex items-center gap-2 mr-12">
                <!-- Send Button -->
                <button 
                    type="button" 
                    wire:click="sendMessage" 
                    class="btn btn-primary h-12 text-white">
                    Send
                </button>

                <!-- End Chat Button -->
                @if (auth()->user()->id_role == 2 && !$isEnded)
                    <button 
                        type="button" 
                        onclick="openEndChatModal()" 
                        class="btn bg-red-500 hover:bg-red-600 h-12 text-white">
                        End Chat
                    </button>
                @endif
            </div>
        </div>
    @endif

    <!-- Modal -->
    <dialog id="endChatModal" class="modal" wire:ignore>
        <div class="modal-box">
            <h3 class="text-lg font-bold">Are you sure you want to end this chat?</h3>
            <p class="py-4">This action cannot be undone.</p>
            <div class="modal-action">
                <button type="button" class="btn close" onclick="closeEndChatModal()">No</button>
                <button type="button" class="btn next" onclick="endChat()">Yes</button>
            </div>
        </div>
    </dialog>
</div>

<script>
    // Mendengarkan event 'scroll-bottom' dan scroll ke bawah
    window.addEventListener('scroll-bottom', () => {
        requestAnimationFrame(() => {
            const chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    });

    function openEndChatModal() {
        document.getElementById('endChatModal').showModal();
    }

    // Close the modal without taking any action
    function closeEndChatModal() {
        document.getElementById('endChatModal').close();
    }

    // End the chat by triggering the Livewire method
    function endChat() {
        @this.endChat(); // Call the Livewire method to end the chat
        closeEndChatModal(); // Close the modal
    }
</script>
