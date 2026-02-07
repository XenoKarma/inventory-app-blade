<section class="bg-white p-6 rounded-xl shadow border border-gray-200">

    {{-- Header --}}
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    {{-- Form --}}
    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">
                {{ __('Current Password') }}
            </label>
            <input type="password" id="current_password" name="current_password"
                   class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                   autocomplete="current-password" required>
            @error('current_password')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- New Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                {{ __('New Password') }}
            </label>
            <input type="password" id="password" name="password"
                   class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                   autocomplete="new-password" required>
            @error('password')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                {{ __('Confirm Password') }}
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                   autocomplete="new-password" required>
            @error('password_confirmation')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                {{ __('Save') }}
            </button>

            {{-- Status --}}
            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

</section>
