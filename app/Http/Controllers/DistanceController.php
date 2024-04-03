<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class DistanceController extends Controller
{
    public function index()
    {
        return view('rit-boeken');
    }

    public function calculate(Request $request)
{
    $start = $request->start;
    $end = $request->end;
    $apiKey = env('lfQjG68PRLiLTaWZVxwqDViJKe4WiaUc3ypG9dKdhWuBLDkx7Pl6VSafS46XH0r0'); 

    $response = Http::get("https://api.distancematrix.ai/v2/matrix", [
        'origins' => $start,
        'destinations' => $end,
        'units' => 'metric', 
        'language' => 'nl', 
        'key' => $apiKey,
    ]);
    
 
    
        if ($response->successful()) {
            $data = $response->json();
            $element = $data['rows'][0]['elements'][0];
            if ($element['status'] == 'ZERO_RESULTS' || $element['status'] == 'NOT_FOUND') {
                return back()->withErrors('Er kon geen route worden gevonden tussen de opgegeven locaties. Voer geldige locaties in.');
            }
    
            $distanceValue = $element['distance']['value'] / 1000;
            $duration = $element['duration']['text'];
            $pricePerKm = Setting::where('key', 'price_per_km')->value('value');
            $totalPrice = $distanceValue * $pricePerKm;
    
            return back()->with('result', "Afstand: $distanceValue km, Tijdsduur: $duration, Prijs: €$totalPrice");
        } else {
            return back()->withErrors('Er is iets fout gegaan bij het berekenen van de afstand. Probeer het later opnieuw.');
        }
    }
      
}
