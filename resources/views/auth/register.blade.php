<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900">Register KDKMP</h1>
            <p class="mt-2 text-sm text-gray-600">Daftar akun untuk menggunakan fitur keuangan dan barter.</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-2 w-full rounded-3xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                <p class="mt-2 text-xs text-red-600">@error('name'){{ $message }}@enderror</p>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-3xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                <p class="mt-2 text-xs text-red-600">@error('email'){{ $message }}@enderror</p>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-2 w-full rounded-3xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                <p class="mt-2 text-xs text-red-600">@error('password'){{ $message }}@enderror</p>
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-2 w-full rounded-3xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                <p class="mt-2 text-xs text-red-600">@error('password_confirmation'){{ $message }}@enderror</p>
            </div>
            <button type="submit" class="w-full rounded-3xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-red-500/20 hover:bg-red-700">Register</button>
            <p class="text-center text-sm text-gray-500">Sudah terdaftar? <a href="{{ route('login') }}" class="font-semibold text-red-600 hover:text-red-700">Log in</a></p>
        </form>
    </div>
</x-guest-layout>
