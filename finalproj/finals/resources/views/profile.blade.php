@extends('layouts.app')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Success Alert --}}
        @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-emerald-700 dark:text-emerald-300 font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-red-700 dark:text-red-400">Please correct the errors below:</p>
                        <ul class="mt-1 text-sm text-red-600 dark:text-red-300 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border overflow-hidden">
            {{-- Profile Header --}}
            <div class="relative">
                <div class="h-28 bg-gradient-to-r from-[#0f2744] via-[#0a1628] to-[#0e7490]"></div>
                <div class="absolute -bottom-10 left-6">
                    <div class="relative">
                        @if($user->profile_image)
                            <img class="h-20 w-20 object-cover rounded-xl border-4 border-white dark:border-dark-card shadow-lg" 
                                 src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile photo" />
                        @else
                            <div class="h-20 w-20 rounded-xl border-4 border-white dark:border-dark-card shadow-lg bg-gradient-to-br from-[#0f2744] to-[#0e7490] flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                            </div>
                        @endif
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-400 border-2 border-white dark:border-dark-card rounded-full"></span>
                    </div>
                </div>
            </div>

            <div class="pt-14 px-6 pb-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $user->full_name }}</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">{{ ucfirst($user->role) }}</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Profile Image Upload --}}
                    <div class="space-y-2" x-data="{ fileName: '', preview: null }">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Profile Photo</label>
                        <div class="flex items-center gap-4">
                            {{-- Preview --}}
                            <div class="relative">
                                <template x-if="preview">
                                    <img :src="preview" class="h-16 w-16 object-cover rounded-lg border-2 border-slate-200 dark:border-dark-border" alt="Preview">
                                </template>
                                <template x-if="!preview">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="h-16 w-16 object-cover rounded-lg border-2 border-slate-200 dark:border-dark-border" alt="Current photo">
                                    @else
                                        <div class="h-16 w-16 rounded-lg border-2 border-dashed border-slate-300 dark:border-dark-border flex items-center justify-center bg-slate-50 dark:bg-dark-bg">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </template>
                            </div>
                            
                            <div class="flex-1">
                                <label class="inline-flex items-center px-4 py-2 rounded-lg bg-slate-100 dark:bg-dark-bg text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer transition-colors text-sm border border-slate-200 dark:border-dark-border">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <span class="font-medium" x-text="fileName || 'Choose Photo'">Choose Photo</span>
                                    <input type="file" 
                                           name="profile_image" 
                                           accept="image/jpeg,image/png,image/gif,image/webp"
                                           class="hidden"
                                           @change="
                                               fileName = $event.target.files[0]?.name || '';
                                               if ($event.target.files[0]) {
                                                   const reader = new FileReader();
                                                   reader.onload = (e) => { preview = e.target.result; };
                                                   reader.readAsDataURL($event.target.files[0]);
                                               }
                                           ">
                                </label>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">JPG, PNG, GIF or WebP. Max 10MB</p>
                                <p x-show="fileName" x-text="fileName" class="mt-1 text-xs text-primary-600 dark:text-primary-400 font-medium truncate max-w-xs"></p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="full_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name) }}" required 
                                   class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-sm">
                        </div>
                        
                        <div class="space-y-1.5">
                            <label for="username" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required 
                                   class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-sm">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-sm">
                        </div>
                    </div>

                    {{-- Password Section --}}
                    <div class="pt-5 border-t border-slate-200 dark:border-dark-border">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-1">Change Password</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Leave blank to keep your current password</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">New Password</label>
                                <input type="password" name="password" id="password" 
                                       class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-sm"
                                       placeholder="••••••••">
                            </div>

                            <div class="space-y-1.5">
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="w-full px-3 py-2.5 rounded-lg border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-sm"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-2.5 px-4 rounded-lg bg-primary-600 hover:bg-primary-700 text-white font-medium text-sm transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection