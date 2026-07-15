<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    /**
     * Show the form for editing the user profile.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the user profile in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            // User rules
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            
            // Profile rules
            'nim' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:255'],
            'semester' => ['nullable', 'integer', 'min:1', 'max:14'],
            'gender' => ['nullable', 'in:L,P,R'],
        ]);

        // Update User Model
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Update UserProfile Model
        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);
        $profile->nim = $validated['nim'];
        $profile->major = $validated['major'];
        $profile->semester = $validated['semester'];
        $profile->gender = $validated['gender'];
        $profile->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
