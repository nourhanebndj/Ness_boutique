document.addEventListener('DOMContentLoaded', function () {
    const montantInput = document.getElementById('montant');
    const codePostalInput = document.getElementById('code_postal');
    const paysInput = document.getElementById('pays');

    const shippingCostElement = document.getElementById('shippingCost');
    const orderAmountElement = document.getElementById('orderAmount');
    const totalAmountElement = document.getElementById('totalAmount');

   
    function formatCurrency(amount) {
        return amount.toFixed(2).replace('.', ',') + ' €';
    }

    
    function parseAmount(str) {
        if (!str) return 0;
        return parseFloat(str.replace(',', '.')) || 0;
    }

    let currentShippingCost = 0;

    // Met à jour résumé commande avec frais livraison actuels
    function updateSummary() {
        const orderAmount = parseAmount(montantInput.value);
        const total = orderAmount + currentShippingCost;
        orderAmountElement.textContent = formatCurrency(orderAmount);
        shippingCostElement.textContent = formatCurrency(currentShippingCost);
        totalAmountElement.textContent = formatCurrency(total);
    }

    // Fonction pour récupérer frais livraison depuis backend
    function fetchShippingCost() {
        const code_postal = codePostalInput.value.trim();
        const pays = paysInput.value.trim();

        if (!code_postal || !pays) {
            shippingCostElement.textContent = 'Veuillez saisir code postal et pays';
            currentShippingCost = 0;
            updateSummary();
            return;
        }

        shippingCostElement.textContent = 'Calcul en cours...';

        fetch('/api/frais-livraison', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ code_postal, pays })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                currentShippingCost = parseFloat(data.frais_livraison) || 0;
                shippingCostElement.textContent = formatCurrency(currentShippingCost);
            } else {
                currentShippingCost = 0;
                shippingCostElement.textContent = 'Erreur: ' + (data.message || 'Impossible de calculer');
            }
            updateSummary();
        })
        .catch(() => {
            currentShippingCost = 0;
            shippingCostElement.textContent = 'Erreur serveur';
            updateSummary();
        });
    }

    // Appelle à chaque modification du code postal ou pays
    codePostalInput.addEventListener('change', fetchShippingCost);
    paysInput.addEventListener('change', fetchShippingCost);
    montantInput.addEventListener('input', updateSummary);

    // Au chargement
    fetchShippingCost();
    updateSummary();
});


document.getElementById('orderForm').addEventListener('submit', function (e) {
    const paymentSelected = document.querySelector('input[name="moyen_paiement"]:checked');
    if (!paymentSelected) {
        e.preventDefault();
        alert('Veuillez sélectionner un moyen de paiement avant de confirmer la commande.');
    }
});

//pays
  const paysUrl = "{{ url('/api/pays') }}";

document.addEventListener('DOMContentLoaded', function () {
    const paysInput = document.getElementById('pays');

    fetch(paysUrl)
        .then(res => res.json())
        .then(data => {
            if (data.pays && Array.isArray(data.pays)) {
                data.pays.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p;
                    option.textContent = p;
                    paysInput.appendChild(option);
                });
            } else {
                paysInput.innerHTML = '<option value="">Erreur de chargement</option>';
            }
        })
        .catch(() => {
            paysInput.innerHTML = '<option value="">Erreur serveur</option>';
        });
});
