<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900">Login to KDKMP</h1>
            <p class="mt-2 text-sm text-gray-600">Masuk untuk mengakses dashboard dan fitur barter.</p>
        </div>
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-3xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                <p class="mt-2 text-xs text-red-600">@error('email'){{ $message }}@enderror</p>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-2 w-full rounded-3xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                <p class="mt-2 text-xs text-red-600">@error('password'){{ $message }}@enderror</p>
            </div>
            <div class="flex items-center justify-between text-sm text-gray-600">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500" />
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-semibold text-red-600 hover:text-red-700">Forgot password?</a>
                @endif
            </div>
            <button type="submit" class="w-full rounded-3xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-red-500/20 hover:bg-red-700">Log in</button>
        </form>
        <p class="text-center text-sm text-gray-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-red-600 hover:text-red-700">Register sekarang</a></p>
    </div>
</x-guest-layout>
