<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:opsz,wght@12..72,400..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400..700&display=swap" rel="stylesheet">
    <title>Nesse Boutique</title>
    <link rel="stylesheet" href="{{ asset('mainassets/css/style.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <div class="container">
        <header class="tracking-header">
            <div class="header-content">
                <div class="header-left-group">
                    <h1 class="logo-large">
                        <img src="{{ asset('mainassets/images/nesse_boutique_logo.png') }}" alt="Logo Nesse Boutique" style="height:auto; width:300px">
                    </h1>

                    <button class="return-btn" onclick="window.location.href='{{ url('/order-tracking') }}'">Suivi de la commande</button>
                </div>
            </div>
        </header>

        <div class="main-content">
            <form class="order-form" id="orderForm" method="POST" action="{{ route('order.store') }}">
                @csrf

                <section class="section">
                    <h2 class="section-title">Montant total</h2>
                    <div class="form-group">
                        <input type="text" class="form-input" name="montant" placeholder="Montant" id="montant" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="reference" placeholder="Référence de la commande" id="reference" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="pseudo" placeholder="Pseudo TikTok" id="pseudo" />
                    </div>
                </section>

                <section class="section">
                    <h2 class="section-title">Adresse de livraison</h2>
                    <div class="form-group">
                        <input type="email" class="form-input" name="email" placeholder="E-mail" id="email" required />
                    </div>
                    <div class="form-row">
                        <div class="form-group half">
                            <input type="text" class="form-input" name="prenom" placeholder="Prénom" id="prenom" required />
                        </div>
                        <div class="form-group half">
                            <input type="text" class="form-input" name="nom" placeholder="Nom" id="nom" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="adresse" placeholder="Adresse" id="adresse" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="ville" placeholder="Ville" id="ville" required />
                    </div>
                    <div class="form-group">
                        <select class="form-input" name="pays" id="pays" required>
                            <option value="">Choisissez un pays</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="code_postal" placeholder="Code postal" id="code_postal" required />
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-input" name="telephone" placeholder="Numéro de téléphone" id="telephone" />
                    </div>
                </section>

                <section class="section">
                    <h2 class="section-title">Frais de livraison</h2>
                    <div>
                        <span id="shippingCost">Calcul en cours...</span>
                    </div>
                </section>

               <section class="section">
                <h2 class="section-title text-xl font-semibold mb-4">Méthode de paiement</h2>
                <div class="payment-methods grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Apple Pay -->
                    <label class="payment-method flex items-center p-3 border rounded-lg cursor-pointer hover:shadow-md transition">
                        <input type="radio" name="payment_method" value="apple_pay" class="hidden" required>
                        <img src="/mainassets/images/apple-pay.png" alt="Apple Pay" class="w-12 h-12 mr-3">
                        <span class="payment-name text-gray-800 font-medium">Apple Pay</span>
                    </label>

                    <!-- PayPal -->
                    <label class="payment-method flex items-center p-3 border rounded-lg cursor-pointer hover:shadow-md transition">
                        <input type="radio" name="payment_method" value="paypal" class="hidden" required>
                        <img src="/mainassets/images/paypal.png" alt="PayPal" class="w-12 h-12 mr-3">
                        <span class="payment-name text-gray-800 font-medium">PayPal</span>
                    </label>

                    <!-- Visa -->
                    <label class="payment-method flex items-center p-3 border rounded-lg cursor-pointer hover:shadow-md transition">
                        <input type="radio" name="payment_method" value="visa" class="hidden" required>
                        <img src="/mainassets/images/visa_logo.webp" alt="Visa" class="w-12 h-12 mr-3">
                        <span class="payment-name text-gray-800 font-medium">Carte Visa</span>
                    </label>
                </div>
            </section>




                <button type="submit" class="confirm-button">Confirmer la commande</button>
            </form>

            <aside class="order-summary">
                <h3 class="summary-title">Résumé de la commande</h3>
                <div class="summary-content">
                    <div class="summary-line">
                        <span class="summary-label">Montant de la commande</span>
                        <span class="summary-value" id="orderAmount">0,00 €</span>
                    </div>
                    <div class="summary-line">
                        <span class="summary-label">Frais de livraison</span>
                        <span class="summary-value" id="shippingCostSummary">Calcul en cours...</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-line total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="totalAmount">0,00 €</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    @if ($errors->any())
        <div style="color:red; padding: 10px; background-color:#ffe6e6; margin-bottom:15px;">
            <strong>Erreur(s) :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div style="color:green; padding: 10px; background-color:#e6ffe6; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const montantInput = document.getElementById('montant');
            const codePostalInput = document.getElementById('code_postal');
            const paysInput = document.getElementById('pays');

            const shippingCostElement = document.getElementById('shippingCost');
            const shippingCostSummary = document.getElementById('shippingCostSummary');
            const orderAmountElement = document.getElementById('orderAmount');
            const totalAmountElement = document.getElementById('totalAmount');

            function formatCurrency(amount) {
                return amount.toFixed(2).replace('.', ',') + ' €';
            }

            function parseAmount(str) {
                if (!str) return 0;
                const val = str.replace(',', '.').replace(/[^\d.]/g, '');
                return parseFloat(val) || 0;
            }

            let currentShippingCost = 0;

            function updateSummary() {
                const orderAmount = parseAmount(montantInput.value);
                const total = orderAmount + currentShippingCost;
                orderAmountElement.textContent = formatCurrency(orderAmount);
                shippingCostElement.textContent = formatCurrency(currentShippingCost);
                shippingCostSummary.textContent = formatCurrency(currentShippingCost);
                totalAmountElement.textContent = formatCurrency(total);
            }

            function fetchShippingCost() {
                const code_postal = codePostalInput.value.trim();
                const pays = paysInput.value.trim();

                if (!code_postal || !pays) {
                    shippingCostElement.textContent = 'Veuillez saisir code postal et pays';
                    shippingCostSummary.textContent = 'Veuillez saisir code postal et pays';
                    currentShippingCost = 0;
                    updateSummary();
                    return;
                }

                shippingCostElement.textContent = 'Calcul en cours...';
                shippingCostSummary.textContent = 'Calcul en cours...';

                fetch('{{ url('/api/frais-livraison') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ code_postal, pays }),
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            currentShippingCost = parseFloat(data.frais_livraison) || 0;
                            shippingCostElement.textContent = formatCurrency(currentShippingCost);
                            shippingCostSummary.textContent = formatCurrency(currentShippingCost);
                        } else {
                            currentShippingCost = 0;
                            shippingCostElement.textContent = 'Erreur: ' + (data.message || 'Impossible de calculer');
                            shippingCostSummary.textContent = 'Erreur: ' + (data.message || 'Impossible de calculer');
                        }
                        updateSummary();
                    })
                    .catch(() => {
                        currentShippingCost = 0;
                        shippingCostElement.textContent = 'Erreur serveur';
                        shippingCostSummary.textContent = 'Erreur serveur';
                        updateSummary();
                    });
            }

            codePostalInput.addEventListener('input', fetchShippingCost);
            paysInput.addEventListener('input', fetchShippingCost);
            montantInput.addEventListener('input', updateSummary);

            // Initial
            fetchShippingCost();
            updateSummary();
        });
    </script>
</body>
</html>
