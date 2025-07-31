@extends('layouts.admin')

@section('content')

    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail User: ') . $user->name }}
        </h2>
    </div>


    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- User Profile Section -->
                    <div class="mb-8">
                        <div class="flex gap-2">
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="shrink-0">
                                <img src="{{ $user->profile_photo }}" alt="{{ $user->name }}"
                                    class="h-32 w-32 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                            </div>
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                                <p class="text-xl text-gray-600 mb-2">{{ $user->email }}</p>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Email Terverifikasi
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                            Email Belum Terverifikasi
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Information Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                        <!-- Account Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Informasi Akun
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">ID User:</span>
                                    <span class="font-medium">{{ $user->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Role:</span>
                                    <span class="font-medium">{{ ucfirst($user->role) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status Email:</span>
                                    <span
                                        class="font-medium {{ $user->email_verified_at ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Riwayat Waktu
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Dibuat:</span>
                                    <span class="font-medium">{{ $user->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Diupdate:</span>
                                    <span class="font-medium">{{ $user->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                                @if ($user->email_verified_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email Diverifikasi:</span>
                                        <span
                                            class="font-medium">{{ $user->email_verified_at->format('d M Y, H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Profile Photo Information -->
                    @if ($user->profile_photo_url)
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Foto Profil
                            </h3>
                            <div class="flex items-center gap-4">
                                <img src="{{ $user->profile_photo }}" alt="{{ $user->name }}"
                                    class="h-16 w-16 rounded-lg object-cover border border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-600">
                                        @if (filter_var($user->profile_photo_url, FILTER_VALIDATE_URL))
                                            <span class="text-blue-600">Foto dari Google OAuth</span>
                                        @else
                                            <span class="text-green-600">Foto diupload manual</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        URL: {{ $user->profile_photo_url }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center border-t pt-6">
                        <div class="flex gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit User
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                ← Kembali
                            </a>

                            @if ($user->profile_photo_url)
                                <form method="POST" action="{{ route('admin.users.delete-photo', $user) }}"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-flex items-center"
                                        onclick="return confirm('Yakin ingin menghapus foto profil user ini?')">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Hapus Foto
                                    </button>
                                </form>
                            @endif
                        </div>

                        @if ($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center"
                                    onclick="return confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan!')">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3a1 1 0 11-2 0V6a1 1 0 011-1zm0 5a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v11a2 2 0 002 2h6a2 2 0 002-2V5h-1a1 1 0 110-2h1a2 2 0 012 2v11a4 4 0 01-4 4H7a4 4 0 01-4-4V5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Hapus User
                                </button>
                            </form>
                        @else
                            <div class="text-sm text-gray-500 italic">
                                Anda tidak dapat menghapus akun sendiri
                            </div>
                        @endif
                    </div>

                    <!-- Additional Statistics (Optional) -->
                    <div class="mt-8 bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                            </svg>
                            Statistik
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">
                                    {{ $user->created_at->diffInDays(now()) }}
                                </div>
                                <div class="text-sm text-gray-600">Hari Bergabung</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">
                                    {{ $user->updated_at->diffInDays($user->created_at) }}
                                </div>
                                <div class="text-sm text-gray-600">Hari Sejak Update Terakhir</div>
                            </div>
                            <div class="text-center">
                                <div
                                    class="text-2xl font-bold {{ $user->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $user->email_verified_at ? 'Ya' : 'Tidak' }}
                                </div>
                                <div class="text-sm text-gray-600">Email Terverifikasi</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
