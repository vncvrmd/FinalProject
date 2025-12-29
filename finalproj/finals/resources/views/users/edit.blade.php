@extends('layouts.app')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Back Button --}}
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Users
        </a>

        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden">
            {{-- Header --}}
            <div class="px-8 py-6 border-b border-gray-100 dark:border-dark-border bg-gradient-to-r from-[#0f2744] via-[#0a1628] to-[#0e7490]">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 overflow-hidden">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" class="w-full h-full object-cover" alt="">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ strtoupper(substr($user->full_name, 0, 2)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $user->full_name }}</h2>
                        <p class="text-primary-100 text-sm">Update user information</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-red-700 dark:text-red-400">Please correct the errors below:</p>
                                <ul class="mt-2 text-sm text-red-600 dark:text-red-300 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('users.update', $user->user_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="full_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name) }}" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        </div>

                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Role</label>
                            <select id="role" name="role" 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                                <option value="employee" @selected(old('role', $user->role) == 'employee')>Employee</option>
                                <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                                <option value="customer" @selected(old('role', $user->role) == 'customer')>Customer</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">New Password</label>
                            <input type="password" name="password" id="password" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300"
                                   placeholder="Leave blank to keep current">
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300"
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="profile_image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Profile Image</label>
                        @if($user->profile_image)
                        <div class="mb-4 p-4 bg-gray-50 dark:bg-dark-bg rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Current Image:</p>
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Current Image" class="h-20 w-20 rounded-xl object-cover shadow-md">
                        </div>
                        @endif
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 dark:border-dark-border border-dashed rounded-xl hover:border-primary-400 dark:hover:border-primary-500 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="profile_image" class="relative cursor-pointer bg-white dark:bg-dark-card rounded-md font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 focus-within:outline-none">
                                        <span>Upload a new file</span>
                                        <input id="profile_image" name="profile_image" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-[#0f2744] to-[#0e7490] text-white font-semibold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection