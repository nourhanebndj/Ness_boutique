<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
        public function dashboard()
        {
            $totalOrders = Order::count();

            $totalAmount = Order::sum('montant') + Order::sum('shipping_cost');

            $totalCountries = Order::distinct('pays')->count('pays');

            // Croissance total commandes : mois courant vs mois précédent
            $ordersThisMonth = Order::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->count();

            $ordersLastMonth = Order::whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ])->count();

            $ordersGrowthPercent = 0;
            if ($ordersLastMonth > 0) {
                $ordersGrowthPercent = (($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100;
            }

            // Croissance montant total : mois courant vs mois précédent
            $amountThisMonth = Order::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->sum('montant') + Order::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->sum('shipping_cost');

            $amountLastMonth = Order::whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ])->sum('montant') + Order::whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ])->sum('shipping_cost');

            $amountGrowthPercent = 0;
            if ($amountLastMonth > 0) {
                $amountGrowthPercent = (($amountThisMonth - $amountLastMonth) / $amountLastMonth) * 100;
            }

            // Nouveaux pays ce mois vs mois précédent
            $countriesThisMonth = Order::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->distinct('pays')->pluck('pays')->toArray();

            $countriesLastMonth = Order::whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ])->distinct('pays')->pluck('pays')->toArray();

            $newCountriesCount = count(array_diff($countriesThisMonth, $countriesLastMonth));

            // Répartition des commandes par pays
            $ordersByCountry = Order::selectRaw('pays, COUNT(*) as count')
                                    ->groupBy('pays')
                                    ->orderBy('count', 'desc')
                                    ->get();

            return view('dashboard', compact(
                'totalOrders',
                'totalAmount',
                'totalCountries',
                'ordersByCountry',
                'ordersGrowthPercent',
                'amountGrowthPercent',
                'newCountriesCount'
            ));
        }


        /**
         * Affiche la liste des commandes (Admin Orders)
         */
        public function index(Request $request)
        {
            $query = Order::query();

            // 🔍 Filtres recherche
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%");
                });
            }

            // 📅 Filtres par date
            if ($request->has('start_date')) {
                $query->where('created_at', '>=', $request->input('start_date'));
            }
            if ($request->has('end_date')) {
                $query->where('created_at', '<=', $request->input('end_date') . ' 23:59:59');
            }

            $orders = $query->orderBy('created_at', 'desc')->paginate(15);

            return view('admin.orders.index', compact('orders'));
        }
}