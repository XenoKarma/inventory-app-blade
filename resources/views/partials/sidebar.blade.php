<aside id="sidebar"
class="w-64 bg-gray-900 text-gray-100 min-h-screen p-6 space-y-2
       fixed lg:fixed z-40
       transform -translate-x-full lg:translate-x-0
       transition duration-200 ease-in-out
       overflow-y-auto">

    {{-- Logo --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-wide">
            📦 Inventory
        </h1>
        <p class="text-xs text-gray-400">
            Management System
        </p>
    </div>

    {{-- Menu --}}
    <nav class="space-y-1">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition
           {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">
            <span>🏠</span>
            Dashboard
        </a>

        {{-- Products Menu --}}
        <div x-data="{ open: {{ request()->routeIs('products.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="flex items-center justify-between w-full gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition
                    {{ request()->routeIs('products.*') ? 'bg-gray-800' : '' }}">
                <span>📦 Products</span>
                <span x-text="open ? '▾' : '▸'"></span>
            </button>
            <div x-show="open" x-transition class="pl-5 mt-1 space-y-1">
                <a href="{{ route('products.index') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-800 transition">
                    Dashboard
                </a>
                <a href="{{ route('products.create') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-800 transition">
                    + Create
                </a>
                <a href="{{ route('products.archived') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-800 transition">
                    Archived
                </a>
            </div>
        </div>

        {{-- Categories --}}
        <a href="{{ route('categories.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition
           {{ request()->routeIs('categories.*') ? 'bg-gray-800' : '' }}">
            <span>🗂️</span>
            Categories
        </a>

        {{-- Users Menu --}}
        <div x-data="{ open: {{ request()->routeIs('users.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="flex items-center justify-between w-full gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition
                    {{ request()->routeIs('users.*') ? 'bg-gray-800' : '' }}">
                <span>👥 Users</span>
                <span x-text="open ? '▾' : '▸'"></span>
            </button>
            <div x-show="open" x-transition class="pl-5 mt-1 space-y-1">
                <a href="{{ route('users.index') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-800 transition">
                    Dashboard
                </a>
                <a href="{{ route('users.create') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-800 transition">
                    + Create
                </a>
            </div>
        </div>

    </nav>

    {{-- Footer --}}
    <div class="pt-8 text-xs text-gray-500">
        © {{ date('Y') }}
    </div>

</aside>
