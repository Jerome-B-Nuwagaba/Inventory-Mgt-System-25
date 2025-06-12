<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ASCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1350&q=80');">
    <div class="bg-white bg-opacity-90 shadow-2xl rounded-2xl max-w-lg w-full p-8 relative">
        <div class="flex flex-col items-center mb-6">
            <svg class="w-16 h-16 text-indigo-600 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75h19.5M2.25 18.75v-2.25A2.25 2.25 0 0 1 4.5 14.25h15a2.25 2.25 0 0 1 2.25 2.25v2.25M2.25 18.75l1.5-6A2.25 2.25 0 0 1 5.955 10.5h12.09a2.25 2.25 0 0 1 2.205 2.25l1.5 6M6.75 10.5V7.875a4.125 4.125 0 1 1 8.25 0V10.5"/></svg>
            <h1 class="text-3xl font-extrabold text-gray-900">Create Your Account</h1>
            <p class="text-gray-600 mt-1">Join the Automotive Supply Chain Network</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-gray-700 font-semibold">Name</label>
                <input id="name" name="name" type="text" required autofocus autocomplete="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input id="email" name="email" type="email" required autocomplete="username" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="block text-gray-700 font-semibold">Phone Number</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="address" class="block text-gray-700 font-semibold">Address</label>
                <input id="address" name="address" type="text" value="{{ old('address') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="role" class="block text-gray-700 font-semibold">I am a</label>
                <select id="role" name="role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select your role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
                @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-semibold">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('password_confirmation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Already registered?</a>
                <button type="submit" class="ml-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md shadow transition">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
