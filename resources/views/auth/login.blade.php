<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login — Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

<div class="w-full max-w-md">

    {{-- Card --}}
    <div class="bg-white shadow-xl rounded-2xl p-8">

        {{-- Logo / Title --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">📦 Inventory</h1>
            <p class="text-gray-500 text-sm mt-2">
                Login ke sistem
            </p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
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

            {{-- Remember --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded">
                    Remember me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-gray-600 hover:text-black">
                        Lupa password?
                    </a>
                @endif
            </div>

            {{-- Button --}}
            <button type="submit"
                class="w-full bg-gray-900 text-white py-2.5 rounded-lg
                       hover:bg-gray-700 transition font-semibold">
                Login
            </button>

        </form>

    </div>

    {{-- Footer --}}
    <p class="text-center text-xs text-gray-500 mt-6">
        © {{ date('Y') }} Inventory System
    </p>

</div>

</body>
</html>
