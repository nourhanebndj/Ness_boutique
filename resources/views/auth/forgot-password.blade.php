<x-guest-layout>
    <div class="mb-4 text-sm text-[#111010]">
        Vous avez oublié votre mot de passe ? Pas de souci. Indiquez simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation pour en créer un nouveau.
    </div>

    <!-- Statut de session -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Adresse e-mail -->
        <div>
            <x-input-label for="email" :value="'Adresse e-mail'" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Bouton -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="bg-[#9C773A] hover:bg-[#CCAD7A] text-white">
                Envoyer le lien de réinitialisation
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
