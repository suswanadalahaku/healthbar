<x-app-layout>
    <x-slot name="header">
        <span class="flex">
            <a href="{{ route('profile') }}" class="font-semibold text-xl text-gray-800 leading-tight mr-5" wire:navigate>
                {{ __('Profile') }}
            </a>
            @if (Auth::user()->id_role === 3)
                <a href="{{  route('chat-history')}}" class="font-semibold text-xl text-gray-800 leading-tight" wire:navigate>
                    {{ __('Histori Konsultasi') }}
                </a>
            @endif
        </span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
