<section class="bg-white p-6 rounded-xl shadow border border-gray-200">

    {{-- Header --}}
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- Form untuk re-send verification email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Form update profile --}}
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
                {{ __('Name') }}
            </label>
            <input type="text" id="name" name="name"
                   class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name">
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                {{ __('Email') }}
            </label>
            <input type="email" id="email" name="email"
                   class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username">
            @error('email')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror

            {{-- Email verification --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification"
                            class="underline text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-green-600 text-sm">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
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
