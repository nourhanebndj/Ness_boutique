<x-guest-layout>
    <div class="mb-4 text-sm text-[#111010]">
        Il s'agit d'une zone sécurisée de l’application. Veuillez confirmer votre mot de passe avant de continuer.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Mot de passe -->
        <div>
            <x-input-label for="password" :value="'Mot de passe'" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Bouton -->
        <div class="flex justify-end mt-4">
            <x-primary-button class="bg-[#9C773A] hover:bg-[#CCAD7A] text-white">
                Confirmer
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
