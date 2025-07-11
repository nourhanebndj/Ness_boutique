<?php

namespace App\Services\Payments;

use App\Models\Order;
use Mypos\IPC\Config;
use Mypos\IPC\Purchase;

class PaypalService
{
    public function process(Order $order): array
    {
        try {
            // Créer la configuration
            $config = new Config();

            $config->setPrivateKeyPath(storage_path('mypos/private.key'))
                ->setAPIPublicKeyPath(storage_path('mypos/public.cert'))
                ->setKeyIndex(1)
                ->setSid(config('services.mypos.sid'))             // SID fourni par myPOS
                ->setWallet(config('services.mypos.wallet'))       // wallet ID
                ->setLang(app()->getLocale())
                ->setDeveloperKey(config('services.mypos.developer_key'));

            // Créer l'objet de paiement
            $purchase = new Purchase($config);

            $purchase->setCurrency('EUR')
                ->setAmount($order->total)
                ->setOrderID('ORDER-' . $order->id)
                ->setURLNotify(route('mypos.notify'))
                ->setURLReturn(route('mypos.success', ['order' => $order->id]))
                ->setURLCancel(route('mypos.cancel', ['order' => $order->id]))
                ->setCustomerEmail($order->email)
                ->setCustomerPhone($order->telephone)
                ->setBillingFirstName($order->prenom)
                ->setBillingLastName($order->nom)
                ->setBillingAddress($order->adresse)
                ->setBillingZip($order->code_postal)
                ->setBillingCity($order->ville)
                ->setBillingCountry($order->pays);

            // Rediriger vers la page myPOS
            $redirectUrl = $purchase->process();

            return [
                'success' => true,
                'redirect_url' => $redirectUrl,
                'message' => 'Redirection vers le paiement sécurisée.',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur myPOS : ' . $e->getMessage(),
            ];
        }
    }
}
