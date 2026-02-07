<section class="space-y-6 bg-white p-6 rounded-xl shadow border border-red-200">

    {{-- Header --}}
    <header class="space-y-2">
        <h2 class="text-lg font-semibold text-red-700">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-sm text-gray-600 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    {{-- Warning Box --}}
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-4 rounded-lg">
        ⚠️ This action cannot be undone.
    </div>

    {{-- Trigger Button --}}
    <button 
        class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition"
        onclick="document.getElementById('deleteModal').classList.remove('hidden')">
        {{ __('Delete Account') }}
    </button>

    {{-- Modal --}}
    <div id="deleteModal" 
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
        
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">

            {{-- Close Button --}}
            <button onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                &times;
            </button>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-5">
                @csrf
                @method('delete')

                <h2 class="text-lg font-semibold text-gray-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                {{-- Password --}}
                <div>
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" 
                           placeholder="{{ __('Password') }}"
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-red-500" required>
                    @error('password')
                        <div class="text-red-600 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" 
                            class="bg-gray-200 px-3 py-1.5 rounded hover:bg-gray-300 transition"
                            onclick="document.getElementById('deleteModal').classList.add('hidden')">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" 
                            class="bg-red-600 text-white px-3 py-1.5 rounded hover:bg-red-700 transition">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>

        </div>
    </div>

</section>
