<x-guest-layout>
    <div class="mb-4 text-sm text-[#111010]">
        Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse e-mail
        en cliquant sur le lien que nous venons de vous envoyer.  
        Si vous n’avez pas reçu l’e-mail, nous vous en renverrons un avec plaisir.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Un nouveau lien de vérification a été envoyé à l’adresse e-mail que vous avez fournie lors de l’inscription.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <!-- Renvoi de l'email -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-primary-button class="bg-[#9C773A] hover:bg-[#CCAD7A] text-white">
                    Renvoyer l’e-mail de vérification
                </x-primary-button>
            </div>
        </form>

        <!-- Déconnexion -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="underline text-sm text-[#111010] hover:text-[#9C773A] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9C773A]">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
