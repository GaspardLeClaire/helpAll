<x-guest-layout>
    <aside id="default-sidebar" class="fixed top-0 left-0 z-50 w-65 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <form id="form-demande" action="{{ route('service.filtre') }}" method="post">
                @csrf
                <label for="demande" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Demande ou Offre</label>
                <select id="demande" name="demande" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Les deux sont sélectionnés</option>
                    <option value="1">Demande de Services</option>
                    <option value="0">Offre de services</option>
                </select>
                <br>
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisissez un type de service</label>
                <select id="typeService" name="typeService" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    
                    <option selected>Tous les types sont sélectionnés</option>
                    <option value="Cinema">Cinema</option>
                    <option value="Covoiturage">Covoiturage</option>
                    <option value="ECHANGES_COMPETENCES">Echange de Competence</option>
                    <option value="Evenementsportif">Evenements Sportifs</option>
                    <option value="Lecture">Lecture</option>
                    <option value="Loisir">Loisir</option>
                </select>
                <button type="submit" id="submit-demande" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Valider</button>
            </form>
            <br>
            <div>
                @foreach($services as $service)
                <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('service.detail', [$service->IDSERVICE,$service->IDUTILISATEUR]) }}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $service->LIBELLE }}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ substr($service->DESCRIPTION, 0, 50) }}...</p>
                    <a href="{{ route('service.detail', [$service->IDSERVICE,$service->IDUTILISATEUR]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Read more
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </aside>
</x-guest-layout>
<div id="my-map"></div>
<div id="test" hidden>{{ $servicesJson }}</div>
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

<script src="{{ asset('js/maplibre-gl.js') }}"></script>

<script src="{{ asset('js/map.js') }}"></script>