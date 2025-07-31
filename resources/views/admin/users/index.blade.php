@extends('layouts.admin')

@section('content')
    {{-- Pindahkan semua isi <x-slot name="header"> dan kontennya ke sini --}}

    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
        <a href="{{ route('admin.users.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah User
        </a>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
                        <div class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-64">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau email..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="min-w-32">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <select name="role"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua Role</option>
                                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User
                                    </option>
                                </select>
                            </div>

                            <div class="min-w-32">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                                <select name="sort"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>
                                        Tanggal Dibuat</option>
                                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama
                                    </option>
                                    <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email
                                    </option>
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                                <a href="{{ route('admin.users.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Bulk Actions Form -->
                    <form id="bulkForm" method="POST" action="{{ route('admin.users.bulk-action') }}">
                        @csrf
                        <input type="hidden" name="action" id="bulkAction">

                        <!-- Bulk Actions Toolbar -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="selectAll"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">Pilih Semua</span>
                            </div>

                            <div class="flex gap-2">
                                <button type="button" onclick="bulkAction('delete')"
                                    class="bg-red-500 hover:bg-red-700 text-white text-sm font-bold py-1 px-3 rounded disabled:opacity-50"
                                    id="bulkDeleteBtn" disabled>
                                    Hapus Terpilih
                                </button>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Foto
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="hover:text-gray-700">
                                                Nama
                                                @if (request('sort') === 'name')
                                                    <span
                                                        class="ml-1">{{ request('order') === 'asc' ? '↑' : '↓' }}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="hover:text-gray-700">
                                                Email
                                                @if (request('sort') === 'email')
                                                    <span
                                                        class="ml-1">{{ request('order') === 'asc' ? '↑' : '↓' }}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                                class="hover:text-gray-700">
                                                Tanggal Dibuat
                                                @if (request('sort') === 'created_at')
                                                    <span
                                                        class="ml-1">{{ request('order') === 'asc' ? '↑' : '↓' }}</span>
                                                @endif
                                            </a>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($users as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                                    class="user-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <img src="{{ $user->profile_photo }}" alt="{{ $user->name }}"
                                                    class="h-10 w-10 rounded-full object-cover">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('admin.users.show', $user) }}"
                                                        class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="text-yellow-600 hover:text-yellow-900">Edit</a>

                                                    @if ($user->id !== auth()->id())
                                                        <form method="POST"
                                                            action="{{ route('admin.users.destroy', $user) }}"
                                                            class="inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-red-600 hover:text-red-900">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                Tidak ada user ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for bulk actions -->
    <script>
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkButtons();
        });

        // Individual checkbox functionality
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.user-checkbox');
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');

                selectAll.checked = checkboxes.length === checkedBoxes.length;
                selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < checkboxes
                    .length;

                toggleBulkButtons();
            });
        });

        function toggleBulkButtons() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

            bulkDeleteBtn.disabled = checkedBoxes.length === 0;
        }

        function bulkAction(action) {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');

            if (checkedBoxes.length === 0) {
                alert('Pilih setidaknya satu user untuk melakukan aksi bulk.');
                return;
            }

            let confirmMessage = '';
            switch (action) {
                case 'delete':
                    confirmMessage = `Yakin ingin menghapus ${checkedBoxes.length} user yang dipilih?`;
                    break;
            }

            if (confirm(confirmMessage)) {
                document.getElementById('bulkAction').value = action;
                document.getElementById('bulkForm').submit();
            }
        }
    </script>
@endsection
