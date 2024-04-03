<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;

class AdminController extends Controller
{
    /**
     * Toon het dashboard voor de beheerder met de lijst van gebruikers en de huidige prijs per kilometer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Haal alle gebruikers op uit de database
        $users = User::all();
        
        // Haal de huidige prijs per kilometer op uit de instellingen
        $currentPrice = Setting::where('key', 'price_per_km')->value('value');
        
        // Geef het dashboard weer met gebruikersgegevens en de huidige prijs per kilometer
        return view('admin.dashboard', compact('users', 'currentPrice'));
    }
    
    /**
     * Werk de prijs per kilometer bij op basis van het verzoek van de beheerder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePricePerKilometer(Request $request)
    {
        // Valideer het invoerveld 'price_per_km'
        $request->validate([
            'price_per_km' => 'required|numeric',
        ]);
    
        // Update of maak de instelling 'price_per_km' aan in de database
        Setting::updateOrCreate(['key' => 'price_per_km'], ['value' => $request->price_per_km]);
    
        // Keer terug naar het vorige scherm met een succesmelding
        return back()->with('success', 'Prijs per KM is bijgewerkt.');
    }
}
