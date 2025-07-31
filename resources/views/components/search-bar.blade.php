<form action="{{ route('search') }}" method="GET" class="w-full max-w-xl mx-auto mb-6">
    <label for="search" class="sr-only">Search</label>
    <div class="relative">
        <input type="text" name="query" id="search"
            class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none"
            placeholder="Cari novel favoritmu...">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0 0013.15 6.15z" />
            </svg>
        </div>
    </div>
</form>
