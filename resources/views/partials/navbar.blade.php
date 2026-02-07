<nav class="bg-white border-b px-6 py-3 flex justify-between items-center shadow-sm">

    {{-- Left --}}
    <div class="flex items-center gap-3">

        {{-- Toggle Sidebar --}}
        <button onclick="toggleSidebar()"
                class="p-2 rounded-md hover:bg-gray-100 lg:hidden">
            ☰
        </button>

        <div>
            <div class="font-semibold leading-tight">
                Dashboard Inventory
            </div>
            <div class="text-xs text-gray-500">
                Sistem Manajemen Barang
            </div>
        </div>

    </div>

    {{-- Right --}}
    <div class="flex items-center gap-4">

        {{-- Profile Dropdown --}}
        <div class="relative" id="profileWrapper">

            {{-- Trigger --}}
            <button onclick="toggleProfileMenu(event)"
                    class="flex items-center gap-3 cursor-pointer">

                {{-- User --}}
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-semibold">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        Online
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}
                </div>

            </button>

            {{-- Dropdown --}}
            <div id="profileMenu"
                 class="absolute right-0 mt-3 w-44 bg-white border rounded-lg shadow-lg hidden z-50">

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm hover:bg-gray-100">
                    👤 Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                        🚪 Logout
                    </button>
                </form>

            </div>

        </div>

    </div>

</nav>
