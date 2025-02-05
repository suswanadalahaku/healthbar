<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
     public function login(): void
    {
        // Validasi data input
        $this->validate();

        // Autentikasi pengguna
        $this->form->authenticate();

        // Regenerasi sesi
        Session::regenerate();

        $this->redirectIntended(route('dashboard'), navigate: true);

        // Panggil fungsi pengalihan berdasarkan role
        // $this->redirectBasedOnRole();
    }

    public function redirectBasedOnRole(): void
    {
        // Dapatkan pengguna yang sedang login
        $user = auth()->user();

        // Redirect berdasarkan role
        switch ($user->id_role) {
            case 1: // Role 1: Admin
                $this->redirectIntended(route('dashboard-admin'), navigate: true);
                break;
            case 2: // Role 2: Owner
                $this->redirectIntended(route('dashboard-dokter'), navigate: true);
                break;
            case 3: // Role 3: Masyarakat
                $this->redirectIntended(route('dashboard-masyarakat'), navigate: true);
                break;
            default:
                // Redirect ke halaman default jika role tidak dikenali
                $this->redirectIntended(route('welcome'), navigate: true);
                break;
        }
    }


}; ?>


<div class="">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4" wire:loading.remove>
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
            <br>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4" wire:loading.remove>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}" wire:navigate>
                {{ __("Don't Have An Account Yet? Register!") }}
            </a>


            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <div class="mt-4 text-center"> 
            <span wire:loading.delay class="loading loading-bars loading-md"></span>
        </div>
    </form>
</div>
