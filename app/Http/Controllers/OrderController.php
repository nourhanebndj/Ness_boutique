<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\Payments\ApplePayService;
use App\Services\Payments\PayPalService;
use App\Services\Payments\VisaService;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string',
            'montant' => 'required|numeric',
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'email' => 'required|email',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'code_postal' => 'required|string',
            'pays' => 'required|string',
            'payment_method' => 'required|in:apple_pay,paypal,visa',
        ]);

        $shippingCost = 5.00;
        $total = $validated['montant'] + $shippingCost;

        $order = Order::create(array_merge($validated, [
            'shipping_method' => 'standard',
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'ip_address' => $request->ip(),
        ]));

        switch ($validated['payment_method']) {
            case 'apple_pay':
                $result = (new ApplePayService())->process($order);
                break;
            case 'visa':
                $result = (new VisaService())->process($order);
                break;
            case 'paypal':
                $result = (new PayPalService())->process($order);
                break;
            default:
                return redirect()->back()->with('error', 'Méthode de paiement invalide.');
        }

        if ($result['success']) {
            return redirect()->away($result['redirect_url']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    public function success(Request $request)
    {
        return redirect()->route('home')->with('success', 'Paiement réussi.');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('home')->with('error', 'Paiement annulé.');
    }
        public function tracking(Request $request)
{
    $ip = $request->ip();

    $orders = Order::where('ip_address', $ip)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pages.order_tracking', compact('orders'));
}
}