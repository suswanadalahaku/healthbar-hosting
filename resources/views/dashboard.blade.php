<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" wire:poll>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold">Dashboard</h1>
                    @auth
                        <!-- Konten untuk pengguna yang sudah login -->
                        @if (auth()->user()->id_role == 1)
                            @livewire('dashboard-admin')
                        @elseif(auth()->user()->id_role == 2)
                            @livewire('dashboard-dokter')
                        @elseif(auth()->user()->id_role == 3)
                            <x-dropdown-link :href="route('start-chat', ['receiverId' => 3])" wire:navigate>
                                {{ __('Chat') }}
                            </x-dropdown-link>
                        @endif
                    @else
                        <!-- Konten untuk guest -->
                        <p>Selamat datang di aplikasi kami. Silakan login untuk fitur lebih lengkap.</p>
                    @endauth
                    @livewire('tampil-artikel')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
