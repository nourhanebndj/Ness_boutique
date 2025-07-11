<x-app-layout>
    @section('head')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@500;700&family=Montserrat:wght@400;500&display=swap');

            body {
                background-color: #FDF8F8;
                font-family: 'Montserrat', sans-serif;
                color: #111010;
            }

            h1, h2, th {
                font-family: 'Hanken Grotesk', sans-serif;
            }

            .header-icon {
                color: #9C773A;
            }

            .card {
                background-color: white;
                border: 1px solid #eee;
                box-shadow: 0 2px 4px rgba(0,0,0,0.03);
                border-radius: 12px;
            }

            thead {
                background: #ffffff;
                color: #111010;
            }

            .status-paid {
                background-color: #e6f4ea;
                color: #27833b;
                border: 1px solid #c6e6d1;
            }

            .status-unpaid {
                background-color: #fcebea;
                color: #bb2d3b;
                border: 1px solid #f5c6cb;
            }

            .tag {
                background-color: #FFEDCF;
                border: 1px solid #CCAD7A;
                color: #111010;
                font-weight: 500;
            }

            .pagination-text {
                font-size: 0.875rem;
                color: #111010;
            }
        </style>
    @endsection

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <!-- Titre -->
                <div class="flex flex-col md:flex-row md:justify-between mb-6 gap-4">
                    <h1 class="text-2xl font-bold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 header-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Liste des Commandes
                    </h1>
                </div>

                <!-- Tableau -->
                <div class="relative overflow-x-auto rounded-lg">
                    <table class="w-full text-sm text-left text-[#111010] bg-[#CCAD7A]">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 font-medium">ID</th>
                                <th class="px-6 py-3 font-medium">Client</th>
                                <th class="px-6 py-3 font-medium">Adresse</th>
                                <th class="px-6 py-3 font-medium">Montant</th>
                                <th class="px-6 py-3 font-medium">Livraison</th>
                                <th class="px-6 py-3 font-medium">Paiement</th>
                                <th class="px-6 py-3 font-medium">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr class="bg-white border-b hover:bg-[#FFEDCF]/40 transition">
                                <td class="px-6 py-4 font-medium whitespace-nowrap">
                                    <span class="tag px-2 py-1 rounded text-xs font-mono">#{{ $order->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $order->prenom }} {{ $order->nom }}</div>
                                    <div class="text-xs text-[#555]">{{ $order->ip_address }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">{{ Str::limit($order->adresse, 20) }}</div>
                                    <div class="text-xs text-[#555]">{{ $order->code_postal }} {{ $order->ville }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium">
                                        {{ number_format($order->montant + $order->shipping_cost, 2, ',', ' ') }} €
                                    </div>
                                    <div class="text-xs text-[#555]">
                                        +{{ number_format($order->shipping_cost, 2, ',', ' ') }} € livr.
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="tag px-2 py-1 text-xs rounded">
                                        {{ ucfirst($order->shipping_method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="tag px-2 py-1 text-xs rounded">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($order->payment_status === 'paid')
                                        <span class="status-paid px-2 py-1 text-xs rounded-full flex items-center">
                                            ✅ Payé
                                        </span>
                                    @else
                                        <span class="status-unpaid px-2 py-1 text-xs rounded-full flex items-center">
                                            ❌ Non payé
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-[#777]">Aucune commande trouvée</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex items-center justify-between">
                    <div class="pagination-text">
                        Affichage de {{ $orders->firstItem() }} à {{ $orders->lastItem() }} sur {{ $orders->total() }} commandes
                    </div>
                    <div>
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
