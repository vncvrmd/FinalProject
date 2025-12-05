<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    {{-- Use the same CSS compilation as your main app --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Fallback CDN if Vite isn't running --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden">
        
        {{-- Header Section --}}
        <div class="bg-blue-900 px-6 py-4">
            <h2 class="text-2xl font-bold text-white text-center">System Login</h2>
            <p class="text-blue-200 text-center text-sm">Inventory & Sales Management</p>
        </div>

        <div class="p-8">
            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Global Error Message (if any) --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    {{ $errors->first() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Username Field --}}
                <div class="mb-6">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="{{ old('username') }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" 
                           placeholder="Enter your username"
                           required 
                           autofocus>
                </div>

                {{-- Password Field --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" 
                           placeholder="Enter your password"
                           required>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Sign In
                </button>

            </form>
        </div>
        
        {{-- Footer Section --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <p class="text-xs text-center text-gray-500">
                &copy; {{ date('Y') }} Company Name. All rights reserved.
            </p>
        </div>
    </div>

</body>
</html>