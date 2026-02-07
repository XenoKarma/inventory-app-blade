<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register — Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

<div class="w-full max-w-md">

    {{-- Card --}}
    <div class="bg-white shadow-xl rounded-2xl p-8">

        {{-- Title --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">📦 Inventory</h1>
            <p class="text-gray-500 text-sm mt-2">
                Buat akun baru
            </p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Nama Lengkap
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Password
                </label>
                <input type="password"
                       name="password"
                       required
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Konfirmasi Password
                </label>
                <input type="password"
                       name="password_confirmation"
                       required
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            {{-- Button --}}
            <button type="submit"
                class="w-full bg-gray-900 text-white py-2.5 rounded-lg
                       hover:bg-gray-700 transition font-semibold">
                Register
            </button>

        </form>

        {{-- Link login --}}
        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}"
               class="font-semibold hover:underline">
                Login disini
            </a>
        </p>

    </div>

    {{-- Footer --}}
    <p class="text-center text-xs text-gray-500 mt-6">
        © {{ date('Y') }} Inventory System
    </p>

</div>

</body>
</html>
