<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class DistanceController extends Controller
{
    /**
     * Toon het formulier voor het boeken van een rit.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('rit-boeken');
    }

    /**
     * Bereken de afstand en prijs voor de opgegeven locaties.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function calculate(Request $request)
    {
        // Haal de start- en eindlocaties op uit het verzoek
        $start = $request->start;
        $end = $request->end;
        
        // API-sleutel voor afstandsberekening
        $apiKey = env('DISTANCE_MATRIX_API_KEY');

        // Maak een verzoek naar de afstandsmatrix API
        $response = Http::get("https://api.distancematrix.ai/v2/matrix", [
            'origins' => $start,
            'destinations' => $end,
            'units' => 'metric',
            'language' => 'nl',
            'key' => $apiKey,
        ]);

        // Controleer of het verzoek succesvol is
        if ($response->successful()) {
            // Verwerk de JSON-gegevens van het antwoord
            $data = $response->json();
            $element = $data['rows'][0]['elements'][0];
            
            // Controleer of een geldige route is gevonden
            if ($element['status'] == 'ZERO_RESULTS' || $element['status'] == 'NOT_FOUND') {
                return back()->withErrors('Er kon geen route worden gevonden tussen de opgegeven locaties. Voer geldige locaties in.');
            }
            
            // Bereken afstand, tijdsduur en totale prijs
            $distanceValue = $element['distance']['value'] / 1000; // Afstand in kilometers
            $duration = $element['duration']['text']; // Tijdsduur van de reis
            $pricePerKm = Setting::where('key', 'price_per_km')->value('value'); // Prijs per kilometer uit instellingen
            $totalPrice = $distanceValue * $pricePerKm; // Totale prijs voor de reis
            
            // Geef het resultaat terug naar het vorige scherm
            return back()->with('result', "Afstand: $distanceValue km, Tijdsduur: $duration, Prijs: €$totalPrice");
        } else {
            // Toon foutmelding als het verzoek mislukt
            return back()->withErrors('Er is iets fout gegaan bij het berekenen van de afstand. Probeer het later opnieuw.');
        }
    }
}
