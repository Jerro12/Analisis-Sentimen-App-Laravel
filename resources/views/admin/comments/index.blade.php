@extends('layouts.admin')

@section('content')
    {{-- Alert jika ada pesan sukses --}}
    @if (session('success'))
        <x-alert>{{ session('success') }}</x-alert>
    @endif

    <x-table-wrapper>
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">User</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Novel</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Komentar</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Sentimen</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($comments as $comment)
                    <tr>
                        <td class="px-4 py-2 flex items-center gap-3">
                            @php
                                $photoUrl = !empty($comment->user->profile_photo_url)
                                    ? asset('storage/' . $comment->user->profile_photo_url)
                                    : asset('images/default-avatar.png');
                            @endphp

                            <img src="{{ $comment->user->profile_photo }}" alt="Foto {{ $comment->user->name }}"
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border shadow-sm">
                        </td>
                        <td class="px-4 py-2">
                            {{ $comment->novel->title ?? '-' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $comment->content }}
                        </td>
                        <td class="px-4 py-2">
                            @php
                                $sentimentClass = match ($comment->sentiment) {
                                    'positive' => 'bg-green-100 text-green-700',
                                    'neutral' => 'bg-yellow-100 text-yellow-700',
                                    'negative' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-200 text-gray-600',
                                };
                            @endphp

                            <span class="inline-block px-2 py-1 rounded text-xs {{ $sentimentClass }}">
                                {{ ucfirst($comment->sentiment ?? '-') }}
                                @if ($comment->score)
                                    ({{ number_format($comment->score, 2) }})
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus komentar ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>Hapus</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                            Belum ada komentar yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-table-wrapper>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $comments->links() }}
    </div>
@endsection
