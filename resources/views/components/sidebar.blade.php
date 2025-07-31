<!-- resources/views/components/sidebar.blade.php -->
<aside class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg border-r border-gray-200 z-50">
    {{-- Header --}}
    <div class="flex items-center justify-center h-16 px-6 bg-gradient-to-r from-blue-600 to-blue-700 border-b">
        <span class="text-xl font-bold text-white">Admin Panel</span>
    </div>

    {{-- Navigation --}}
    <nav class="mt-6 px-4 space-y-2">
        <!-- Dashboard -->
        <a href="{{ url('/admin/dashboard') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->is('admin/dashboard') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }}"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7m-9 14v-6h4v6m5-10l2 2m-2-2v6a2 2 0 01-2 2h-4m-4 0H5a2 2 0 01-2-2v-6m2-2l2 2" />
            </svg>
            Dashboard
        </a>

        <!-- Manajemen Pengguna -->
        <a href="{{ route('admin.users.index') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('admin/users*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->is('admin/users*') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }}"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
            Manajemen Pengguna
        </a>

        <!-- Manajemen Komentar -->
        <a href="{{ route('admin.comments.index') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('admin/comments*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.986 9.986 0 01-4.78-1.222L3 21l1.222-4.781A8.963 8.963 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            Manajemen Komentar
        </a>

        <!-- Manajemen Novel -->
        <a href="{{ route('admin.novels.index') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('admin/novels*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25A8.966 8.966 0 0118 3.75c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            Manajemen Novel
        </a>

        <!-- Divider -->
        <div class="pt-4 mt-6 border-t border-gray-200">
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="group flex items-center w-full px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-red-600" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </nav>
</aside>
