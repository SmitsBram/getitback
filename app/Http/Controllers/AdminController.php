<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;

class AdminController extends Controller
{
    public function index() {
        $users = User::all();
        $currentPrice = Setting::where('key', 'price_per_km')->value('value');
        return view('admin.dashboard', compact('users', 'currentPrice'));
    }
    
    public function updatePricePerKilometer(Request $request)
    {
        $request->validate([
            'price_per_km' => 'required|numeric',
        ]);
    
        Setting::updateOrCreate(['key' => 'price_per_km'], ['value' => $request->price_per_km]);
    
        return back()->with('success', 'Prijs per KM is bijgewerkt.');
    }
}