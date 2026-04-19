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
        $user = $request->user()->load('profile');

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'birthdate' => ['nullable', 'date'],
            'ubicacion_usuario' => ['nullable', 'string', 'max:255'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'birthdate' => $validated['birthdate'] ?? null,
                'ubicacion_usuario' => $validated['ubicacion_usuario'] ?? null,
            ]
        );

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
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

    public function deactivate(Request $request): RedirectResponse
{
    $request->validate([
        'password' => ['required', 'current_password'],
    ], [
        'password.current_password' => 'La contraseña ingresada no es correcta.',
    ]);

    $user = $request->user();
    $user->status = 'inactive';
    $user->save();

    \Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')->with('status', 'account-deactivated');
}
}
