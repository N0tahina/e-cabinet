<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;

class DentisteController extends Controller
{
    public function dashboard()
    {
        $dentisteId = auth()->guard('dentiste')->id(); // si tu as un guard "dentiste"

        $rendezvous = RendezVous::where('dentiste_id', $dentisteId)
            ->with('user') // pour récupérer le nom du patient
            ->orderBy('date_heure', 'asc')
            ->get();

        return view('dentiste.dashboard', compact('rendezvous'));
    }

}
