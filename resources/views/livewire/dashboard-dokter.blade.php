<div wire:poll>
    <h1 class="text2xl font-bold">List pasien</h1>
    @php
        $adaPenggunaAktif = false;
    @endphp

    @foreach ($users as $user)
        @php
            $statusAktif = false;
        @endphp
        @foreach ($sessions as $session)
            @if ($user->id == $session->isEnded->from_user_id && $session->isEnded->is_ended != 1)
                @php
                    $statusAktif = true;
                    $adaPenggunaAktif = true;
                @endphp
                @break
            @endif
        @endforeach

        @if ($statusAktif)
            <li class="list-none" >
                <x-dropdown-link :href="route('chat', $user)" wire:navigate>
                    <div class="flex items-center space-x-4">
                        <!-- Avatar -->
                        <div class="avatar 
                        @if ($user->unreadMessages->count() > 0) online
                        @endif">
                            <div class="w-10 rounded-full">
                                <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" alt="User Avatar" />
                            </div>
                        </div>
                        <!-- Name -->
                        <span class="text-gray-800 font-medium">
                            <!-- Menampilkan nama pengguna -->
                            {{ $user->name }}
                            <!-- Menampilkan status sesi -->
                            <div class="grid place badge end">{{ $user->unreadMessages->count() }} new message</div> 
                        </span>
                    </div>
                </x-dropdown-link>
            </li>
        @endif
    @endforeach

    @if (!$adaPenggunaAktif)
        <div class="text-gray-500 text-center mt-4">
            Tidak ada masyarakat dengan sesi chat aktif.
        </div>
    @endif
</div>
