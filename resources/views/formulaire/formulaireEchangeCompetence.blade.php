<x-app-layout>
    <div class="flex flex-col items-center justify-center ">

        

        <form method="POST" action="{{ route('formulaire.store.competence', [$service->IDSERVICE,$service->IDUTILISATEUR]) }}" autocomplete="off">
            @csrf
            <div class="mt-4">
                <x-input-label for="nomCompetence" :value="__('Nom des compétences associées au service')" />
                <input name="nomCompetence" required id="nomCompetence" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm search">
            </div>
            <br>
            <!-- Bouton de soumission -->
            <div class="col-span-2 md:col-span-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Valider</button>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <!-- Inclure MapLibre-GL avant le script -->
    <script src="{{ asset('js/maplibre-gl.js') }}"></script>
    <!-- Inclure votre fichier JavaScript après MapLibre-GL -->
    <script src="{{ asset('js/form-adress.js') }}"></script>
</x-app-layout>