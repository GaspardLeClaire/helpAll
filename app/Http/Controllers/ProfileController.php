<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Etudiant;
use App\Models\Service;
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
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function credit25(){
        $etudiant = Etudiant::find(Auth::user()->IDUTILISATEUR);
        $etudiant->CREDITS = Auth::user()->CREDITS + 25;
        $etudiant->update();
        return redirect()->route('dashboard');
    }

    public function credit50(){
        $etudiant = Etudiant::find(Auth::user()->IDUTILISATEUR);
        $etudiant->CREDITS = Auth::user()->CREDITS + 50;
        $etudiant->update();
        return redirect()->route('dashboard');
    }
    public function credit75(){
        $etudiant = Etudiant::find(Auth::user()->IDUTILISATEUR);
        $etudiant->CREDITS = Auth::user()->CREDITS + 75;
        $etudiant->update();
        return redirect()->route('dashboard');
    }

    public function dashboard(){
        $service = Service::where('IDUTILISATEUR',Auth::user()->IDUTILISATEUR)->get();
        return view('dashboard',['services'=>$service]);
    }
}
