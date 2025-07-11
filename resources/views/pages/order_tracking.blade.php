<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Nesse Boutique - Suivi des commandes</title>
    <link rel="stylesheet" href="{{ asset('mainassets/css/style.css') }}" />
</head>
<body>
    <div class="container">
        <header class="tracking-header">
            <div class="header-content">
                <div class="header-left-group">
                    <h1 class="logo-large">
                        <img src="{{ asset('mainassets/images/nesse_boutique_logo.png') }}" alt="Logo Nesse Boutique" style="height:auto; width:300px">
                    </h1>

                    <button class="return-btn" onclick="window.location.href='{{ url('/') }}'">Retour</button>
                </div>
            </div>
        </header>

        <main class="tracking-main">
            <section class="order-tracking">
                <h2>VOTRE COMMANDE</h2>
                <p class="tracking-note">* Seules les commandes passées à partir de votre appareil actuel sont affichées ici.</p>

                <div class="orders-table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Date</th>
                                <th>Prix total</th>
                                <th>Transporteur</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($order->total, 2, ',', ' ') }} €</td>
                                    <td>{{ ucfirst($order->shipping_method) }}</td>
                                    <td>{{ $order->payment_status ?? 'Non défini' }}</td>
                                </tr>
                            @empty
                                <tr class="no-orders">
                                    <td colspan="5">Aucune commande trouvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
