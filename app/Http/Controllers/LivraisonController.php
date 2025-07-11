<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaposteService;

class LaposteController extends Controller
{
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'code_postal' => 'required|string',
            'pays' => 'required|string',
        ]);

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => config('services.laposte.api_key'),
                'Accept' => 'application/json',
            ])->post('https://api.laposte.fr/simtao/v1/calculate', [
                'postal_code' => $request->code_postal,
                'country' => $request->pays,
                'weight' => 1.0,
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'frais_livraison' => $response->json()['shipping_cost'] ?? 0,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Réponse non valide de La Poste.',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage(),
            ], 500);
        }
    }
}
