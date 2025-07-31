<!-- Tombol Kembali -->
<div class="mb-6">
    <a href="{{ route('admin.novels.index') }}"
        class="inline-block px-4 py-2 text-sm font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
        ← Kembali ke Daftar Novel
    </a>
</div>

<form method="POST" action="{{ isset($novel->id) ? route('admin.novels.update', $novel) : route('admin.novels.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if (isset($novel->id))
        @method('PUT')
    @endif

    <!-- Title -->
    <div class="mb-4">
        <x-input-label for="title" :value="'Title'" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $novel->title ?? '')" required
            autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <!-- Author -->
    <div class="mb-4">
        <x-input-label for="author" :value="'Author'" />
        <x-text-input id="author" name="author" type="text" class="mt-1 block w-full" :value="old('author', $novel->author ?? '')"
            required />
        <x-input-error :messages="$errors->get('author')" class="mt-2" />
    </div>

    <!-- Genre -->
    <div class="mb-4">
        <x-input-label for="genre" :value="'Genre'" />

        <select id="genre" name="genre"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            required>
            <option value="">-- Pilih Genre --</option>
            @foreach (['Fantasi', 'Romansa', 'Petualangan', 'Horor', 'Misteri', 'Fiksi Ilmiah', 'Thriller', 'Drama', 'Komedi', 'Sejarah', 'Aksi', 'Slice of Life', 'Dewasa', 'Anak-anak'] as $genreOption)
                <option value="{{ $genreOption }}"
                    {{ old('genre', $novel->genre ?? '') === $genreOption ? 'selected' : '' }}>
                    {{ $genreOption }}
                </option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('genre')" class="mt-2" />
    </div>


    <!-- Year -->
    <div class="mb-4">
        <x-input-label for="year" :value="'Year'" />
        <x-text-input id="year" name="year" type="number" min="1000" max="9999"
            class="mt-1 block w-full" :value="old('year', $novel->year ?? '')" required />
        <x-input-error :messages="$errors->get('year')" class="mt-2" />
    </div>

    <!-- Pages -->
    <div class="mb-4">
        <x-input-label for="pages" :value="'Pages'" />
        <x-text-input id="pages" name="pages" type="number" class="mt-1 block w-full" :value="old('pages', $novel->pages ?? '')"
            required />
        <x-input-error :messages="$errors->get('pages')" class="mt-2" />
    </div>

    <!-- Synopsis -->
    <div class="mb-4">
        <x-input-label for="synopsis" :value="'Synopsis'" />
        <textarea id="synopsis" name="synopsis" rows="5"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('synopsis', $novel->synopsis ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('synopsis')" class="mt-2" />
    </div>

    <!-- Photo -->
    <div class="mb-6">
        <x-input-label for="photo" :value="'Photo'" />
        <input type="file" id="photo" name="photo" accept="image/*"
            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0 file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            onchange="previewImage(event)" />

        <!-- Preview Section -->
        <div class="mt-4">
            <img id="preview" src="{{ $novel->photo_url ?? '' }}" alt="Preview"
                class="h-32 rounded shadow border {{ isset($novel->photo_url) ? '' : 'hidden' }}">
        </div>

        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
    </div>

    <!-- Submit -->
    <div class="mt-6">
        <x-primary-button>
            {{ isset($novel->id) ? 'Update Novel' : 'Create Novel' }}
        </x-primary-button>
    </div>
</form>

<!-- JavaScript Preview -->
@push('scripts')
    <script>
        function previewImage(event) {
            const fileInput = event.target;
            const preview = document.getElementById('preview');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
@endpush
