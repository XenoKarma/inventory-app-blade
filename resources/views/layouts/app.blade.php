<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inventory')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')

    {{-- Alpine (cukup sekali) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">

{{-- Overlay mobile --}}
<div id="overlay"
     onclick="toggleSidebar()"
     class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Right Area --}}
    <div class="flex-1 flex flex-col lg:ml-64">

        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Page Content --}}
        <main class="p-6 min-h-[calc(100vh-120px)]">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('partials.footer')

    </div>
</div>

{{-- =========================
   SCRIPT AREA
========================= --}}

<script>
/* Sidebar Toggle */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}

/* Profile Dropdown Toggle */
function toggleProfileMenu(e) {
    e.stopPropagation();
    document.getElementById('profileMenu')
        .classList.toggle('hidden');
}

/* Klik luar → tutup dropdown */
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('profileWrapper');
    const menu = document.getElementById('profileMenu');

    if (wrapper && !wrapper.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
</script>

</body>
</html>
