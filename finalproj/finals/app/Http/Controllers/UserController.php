<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('full_name', 'like', "%{$search}%")
                             ->orWhere('username', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest() 
            ->paginate(10); 

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => 'required|string|in:admin,employee,customer',
            'profile_image' => [
                'nullable',
                File::image()->max(1024 * 2) 
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.mixed' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one special character.',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $newUser = User::create([
            'full_name' => $validated['full_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'profile_image' => $imagePath,
        ]);

        // Log user creation
        Log::create([
            'user_id' => Auth::id(),
            'action' => "Created user: {$newUser->username} (Role: {$newUser->role})",
            'date_time' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $oldRole = $user->role;
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore($user->user_id, 'user_id') 
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->user_id, 'user_id') 
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => 'required|string|in:admin,employee,customer',
            'profile_image' => [
                'nullable',
                File::image()->max(1024 * 2)
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.mixed' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one special character.',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); 
        }

        $user->update($validated);

        // Log role changes
        if ($oldRole !== $user->role) {
            Log::create([
                'user_id' => Auth::id(),
                'action' => "Changed {$user->username} role from {$oldRole} to {$user->role}",
                'date_time' => now(),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Security: Prevent users from deleting themselves
        if ($user->user_id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Store info before deletion for logging
        $deletedUsername = $user->username;
        $deletedRole = $user->role;

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        // Log user deletion
        Log::create([
            'user_id' => Auth::id(),
            'action' => "Deleted user: {$deletedUsername} (Role: {$deletedRole})",
            'date_time' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    // -- NEW METHODS FOR PROFILE PAGE --

    public function showProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // Changed to Auth::user() for better IDE support
        
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore($user->user_id, 'user_id')
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->user_id, 'user_id')
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'profile_image' => [
                'nullable',
                File::image()->max(1024 * 10) // 10MB max
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.mixed' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one special character.',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $passwordChanged = false;
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
            $passwordChanged = true;
        } else {
            unset($validated['password']);
        }

        // Use the model explicitly to ensure update works on the instance found by ID
        User::find($user->user_id)->update($validated);

        // Security: Regenerate session and log password change
        if ($passwordChanged) {
            $request->session()->regenerate();
            
            Log::create([
                'user_id' => $user->user_id,
                'action' => 'Changed own password',
                'date_time' => now(),
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}