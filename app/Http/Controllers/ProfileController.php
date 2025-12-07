<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('editprofile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $user = auth()->user();

    // Validasi input
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'notelp'       => 'required|numeric',
        'institution' => 'nullable|string|max:255',
        'photo'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    // Upload foto jika ada
    if ($request->hasFile('photo')) {

        // Hapus foto lama
        if ($user->photo && file_exists(storage_path('app/public/profile/'.$user->photo))) {
            unlink(storage_path('app/public/profile/'.$user->photo));
        }

        $filename = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('public/profile', $filename);

        $validated['photo'] = $filename;
    }

    // Update user
    $user->update($validated);

    return redirect()->route('profile')->with('success', 'Profile updated successfully!');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function profile()
{
    $user = Auth::user();   // atau User::find(...)
    return view('profile', compact('user'));
}
}


