<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- Preview foto profil --}}
    <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <img id="profile-preview" class="h-20 w-20 rounded-full object-cover border-2 border-gray-200 shadow-sm"
                    src="{{ $user->profile_photo }}" alt="Foto Profil {{ $user->name }}">

                {{-- Badge untuk default avatar --}}
                @if (!$user->profile_photo_url || filter_var($user->profile_photo_url ?? '', FILTER_VALIDATE_URL))
                    <div class="absolute -bottom-1 -right-1 bg-gray-500 text-white text-xs px-1.5 py-0.5 rounded-full">
                        Default
                    </div>
                @endif
            </div>

            <div class="flex-1">
                <p class="text-sm text-gray-600">
                    Upload foto profil baru atau gunakan avatar default yang dibuat dari nama Anda.
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                </p>
            </div>
        </div>
    </div>

    {{-- Form kirim ulang verifikasi email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Form update profil --}}
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Upload foto --}}
        <div>
            <x-input-label for="photo" :value="__('Upload Foto Profil Baru')" />
            <div class="mt-1">
                <input id="photo" name="photo" type="file" accept="image/*" onchange="previewImage(this)"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-md" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />

            {{-- Reset foto button --}}
            @if (isset($user->profile_photo_url) &&
                    $user->profile_photo_url &&
                    !filter_var($user->profile_photo_url, FILTER_VALIDATE_URL))
                <x-primary-button type="button" onclick="resetToDefault()"
                    class="mt-2 text-sm text-red-600 hover:text-red-800 underline">
                    Hapus foto dan gunakan avatar default
                </x-primary-button>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium">{{ __('Profil berhasil diperbarui!') }}</p>
            @endif

            @if (session('error'))
                <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
            @endif
        </div>
    </form>

    {{-- JavaScript untuk preview image --}}
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetToDefault() {
            // Reset preview ke default avatar
            const defaultAvatar = "{{ asset('images/default-avatar.png') }}";
            document.getElementById('profile-preview').src = defaultAvatar;

            // Clear file input
            document.getElementById('photo').value = '';

            // Anda bisa menambahkan AJAX call untuk delete foto dari server jika diperlukan
        }
    </script>
</section>
