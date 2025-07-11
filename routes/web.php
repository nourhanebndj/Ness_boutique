<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\LaposteController;
use App\Http\Controllers\LivraisonController;
use Mypos\IPC\Config;
use Illuminate\Support\Facades\Http;

Route::get('/test-mypos', function () {
    dd(new Config());
});
Route::get('/', function () {
    return view('index');
})->name('home');


Route::get('/api/pays', function () {
    $response = Http::get('https://restcountries.com/v3.1/all');

    if ($response->successful()) {
        $countries = collect($response->json())
            ->pluck('name.common')
            ->sort()
            ->values();

        return response()->json(['pays' => $countries]);
    }

    return response()->json(['pays' => []], 500);
});

Route::get('/test-laposte', function () {
    $response = Http::withHeaders([
        'X-Api-Key' => config('services.laposte.api_key'),
    ])->get('https://api.laposte.fr/geolocalisation/v1/recherche?codePostal=75001');

    return $response->body(); // ou ->json() si tu veux décoder
});
Route::post('/frais-livraison', [LivraisonController::class, 'calculerFrais']);
Route::post('/api/frais-livraison', [LaposteController::class, 'getShippingCost'])->name('shipping.cost');
Route::post('/api/suivi-colis', [LaposteController::class, 'track'])->name('tracking.track');
Route::get('/api/geolocalisation', [LaposteController::class, 'geolocate']);
Route::get('/api/geolocalisation-inversee', [LaposteController::class, 'reverseGeolocate']);

Route::get('/order-tracking', [OrderController::class, 'tracking'])->name('order.tracking');

Route::post('/commande/store', action: [OrderController::class, 'store'])->name('order.store');


Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/mypos/success', [OrderController::class, 'success'])->name('mypos.success');
Route::get('/mypos/cancel', [OrderController::class, 'cancel'])->name('mypos.cancel');


// Dashboard (statistiques)
Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Liste des commandes
Route::get('/admin/orders', [AdminOrderController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.orders.index');

    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';