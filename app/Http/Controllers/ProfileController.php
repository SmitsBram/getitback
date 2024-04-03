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
     * Toon het formulier voor het bewerken van het gebruikersprofiel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Werk de gebruikersprofielinformatie bij.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Haal de geauthenticeerde gebruiker op
        $user = $request->user();
        
        // Vul de gebruikersgegevens met de gevalideerde invoer
        $user->fill($request->validated());

        // Reset de e-mailverificatietijd indien het e-mailadres is gewijzigd
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            // Optioneel: stuur de verificatie-e-mail opnieuw
            // $user->sendEmailVerificationNotification();
        }

        // Werk extra profielgegevens bij
        $user->bedrijfsnaam = $request->bedrijfsnaam;
        $user->straat_en_huisnummer = $request->straat_en_huisnummer;
        $user->postcode = $request->postcode;
        $user->plaats = $request->plaats;
        $user->land = $request->land;
        $user->kvknummer = $request->kvknummer;
        $user->telefoonnummer = $request->telefoonnummer;

        // Sla de gebruiker op
        $user->save();

        // Keer terug naar het bewerkingsformulier met een succesmelding
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Verwijder het gebruikersaccount.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Valideer het wachtwoord voor accountverwijdering
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Haal de geauthenticeerde gebruiker op
        $user = $request->user();

        // Log de gebruiker uit
        Auth::logout();

        // Verwijder het gebruikersaccount
        $user->delete();

        // Maak de sessie ongeldig en genereer een nieuwe token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Keer terug naar de hoofdpagina
        return Redirect::to('/');
    }
}
