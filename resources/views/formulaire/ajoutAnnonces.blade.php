<x-app-layout>
    <div class="flex flex-col items-center justify-center px-10 py-12 mx-auto md:h-screen lg:py-0">

        <form method="POST" action="{{ route('formulaire.store') }}" class="grid grid-cols-2 gap-4" autocomplete="off">
            @csrf
            <!-- Colonne 1 -->
            <div class="col-span-1">
                <!-- Libelle Address -->
                <label for="demande" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                <select id="demande" name="demande" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a type</option>
                    <option value="1">Demande</option>
                    <option value="0">Offre</option>
                </select>

                <div class="mt-4">
                    <x-input-label for="libelle" :value="__('Titre')" />
                    <x-text-input id="libelle" class="block mt-1 w-full" name="libelle" :value="old('libelle')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('libelle')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="description" required rows="4" name="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ecrivez la description de l'annonce..."></textarea>
                </div>
                <div class="mt-4">
                    <x-input-label for="prix" :value="__('Prix')" />
                    <input type="number" required name="prix" id="prix" min=0 max=10000 class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                </div>

                <div class="relative max-w-sm mt-4">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input datetimepicker type="text" name="dateDebut" id="datetime" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date and time">
                </div>


                <div class="mt-4">
                    <x-input-label for="numero" :value="__('Numero')" />
                    <input type="number" name="numero" required id="numero" min=0 max=10000 class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm search">
                </div>

                <div class="mt-4">
                    <x-input-label for="rue" :value="__('Rue')" />
                    <x-text-input id="rue" class="block mt-1 w-full search" name="rue" :value="old('rue')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('rue')" class="mt-2" />
                    <div class="block mt-1 w-full proposition"></div>
                </div>

                <div class="mt-4">
                    <x-input-label for="codePostal" :value="__('CodePostal')" />
                    <input type="number" required name="codePostal" id="codePostal" min=0 max=100000 class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm search">
                </div>

                <div class="mt-4">
                    <x-input-label for="ville" :value="__('Ville')" />
                    <x-text-input id="ville" class="block mt-1 w-full search" name="ville" :value="old('ville')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('ville')" class="mt-2" />
                </div>
            </div>

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