<x-guest-layout>
    <div class="w-full max-w-md mx-auto mt-12 p-6 bg-white shadow-lg rounded-xl">
        <!-- Logo App -->
        <div class="flex justify-center mb-6">
            {!! file_get_contents(public_path('images/novelytics-logo.svg')) !!}
        </div>

        <!-- Login with Google -->
        <div class="flex justify-center mb-4">
            <a href="{{ route('google.login') }}"
                class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-100">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                    <path fill="#EA4335"
                        d="M24 9.5c3.8 0 7.2 1.3 9.8 3.8l7.3-7.3C36.9 1.7 30.9 0 24 0 14.6 0 6.6 5.8 2.7 14.1l8.5 6.6C13.1 13.5 18.1 9.5 24 9.5z" />
                    <path fill="#4285F4"
                        d="M46.5 24.5c0-1.5-.1-3-.4-4.5H24v9h12.6c-.6 3-2.4 5.5-4.9 7.2l7.6 5.9c4.5-4.2 7.2-10.5 7.2-17.6z" />
                    <path fill="#FBBC05" d="M11.2 28.6c-1-3-1-6.2 0-9.2L2.7 14c-2.6 5.1-2.6 11.1 0 16.2l8.5-6.6z" />
                    <path fill="#34A853"
                        d="M24 48c6.5 0 12.1-2.1 16.1-5.8l-7.6-5.9c-2.2 1.5-5 2.4-8.5 2.4-5.9 0-10.9-4-12.8-9.4l-8.5 6.6C6.6 42.2 14.6 48 24 48z" />
                </svg>
                Continue with Google
            </a>
        </div>

        <!-- Divider -->
        <div class="flex items-center justify-center my-6">
            <span class="border-t w-1/5"></span>
            <span class="mx-4 text-sm text-gray-500">Or Login With</span>
            <span class="border-t w-1/5"></span>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Submit + Forgot -->
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button>
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Create Account -->
        <div class="mt-6 text-center text-sm text-gray-600">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('register') }}">
                {{ __('Dont have an account?') }}
            </a>
        </div>
    </div>
</x-guest-layout>
