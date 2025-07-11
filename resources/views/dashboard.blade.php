<x-app-layout>
    @section('head')
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Tableau de Bord</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:opsz,wght@12..72,400..800&display=swap" rel="stylesheet">
             <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400..700&display=swap" rel="stylesheet">
            <style>
                :root {
                    --color-text: #111010;
                    --color-background: #FDF8F8;
                    --color-gradient-start: #9C773A;
                    --color-gradient-middle: #CCAD7A;
                    --color-gradient-end: #FFEDCF;
                }

                .stat-card {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    background:#fff;
                    border-radius: 12px;
                    border: 1px solid rgba(226, 232, 240, 0.5);
                    box-shadow: 0 4px 8px rgba(17, 16, 16, 0.05);
                }

                .stat-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 20px 25px -5px rgba(17, 16, 16, 0.15);
                    border-color: rgba(226, 232, 240, 0.8);
                }

                .stat-icon {
                    background: #FDF8F8;
                    border-radius: 10px;
                }

                .country-card {
                    transition: all 0.3s ease;
                    background: white;
                    border-radius: 10px;
                    border: 1px solid rgba(226, 232, 240, 0.8);
                }

                .country-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 15px -3px rgba(17, 16, 16, 0.15);
                    border-color: var(--color-gradient-start);
                }

                .progress-bar {
                    height: 6px;
                    background-color: #e2e8f0;
                    border-radius: 3px;
                    overflow: hidden;
                }

                .progress-value {
                    height: 100%;
                    background: linear-gradient(to right, var(--color-gradient-start), var(--color-gradient-end));
                    transition: width 0.6s ease;
                }

                .text-primary {
                    color: var(--color-text);
                }

                .text-highlight {
                    color: var(--color-gradient-start);
                }

                .section-title {
                    position: relative;
                    padding-left: 16px;
                }

                .section-title:before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 50%;
                    transform: translateY(-50%);
                    height: 60%;
                    width: 4px;
                    background: var(--color-gradient-start);
                    border-radius: 2px;
                }
            </style>
        </head>
    @show

    <div class="min-h-screen py-8" style="background:#FDF8F8;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <!-- Total Commandes -->
                <div class="stat-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-primary uppercase tracking-wider mb-1">Total Commandes</p>
                        <p class="text-3xl font-bold text-primary">{{ $totalOrders }}</p>
                    </div>
                    <div class="stat-icon p-3 text-highlight">
                        <i class="fas fa-shopping-bag text-2xl"></i>
                    </div>
                </div>

                <!-- Montant Total -->
                <div class="stat-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-primary uppercase tracking-wider mb-1">Montant Total</p>
                        <p class="text-3xl font-bold text-primary">{{ number_format($totalAmount, 2, ',', ' ') }} €</p>
                    </div>
                    <div class="stat-icon p-3 text-highlight">
                        <i class="fas fa-euro-sign text-2xl"></i>
                    </div>
                </div>

                <!-- Pays Différents -->
                <div class="stat-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-primary uppercase tracking-wider mb-1">Pays Différents</p>
                        <p class="text-3xl font-bold text-primary">{{ $totalCountries }}</p>
                        <div class="mt-2 flex items-center text-sm text-highlight">
                            <i class="fas fa-plus mr-1 text-xs"></i>
                            <span>
                                @if($newCountriesCount > 0)
                                    {{ $newCountriesCount }} nouveaux marchés
                                @else
                                    Aucun nouveau marché
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon p-3 text-highlight">
                        <i class="fas fa-globe-europe text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Section Répartition par Pays -->
            <div class="rounded-xl overflow-hidden mb-8 bg-white shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-primary section-title">
                        Répartition géographique
                    </h2>
                    <p class="text-sm text-primary mt-1">Distribution des commandes par pays</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($ordersByCountry as $country)
                            <div class="country-card p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="font-medium text-primary">{{ $country->pays }}</span>
                                    <span class="font-bold text-highlight">{{ $country->count }}</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-value" style="width: {{ ($country->count / $totalOrders) * 100 }}%"></div>
                                </div>
                                <div class="mt-2 text-xs text-primary flex justify-between items-center">
                                    <span>Part de marché</span>
                                    <span class="font-medium">{{ number_format(($country->count / $totalOrders) * 100, 1) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.stat-card, .country-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>
</x-app-layout>
