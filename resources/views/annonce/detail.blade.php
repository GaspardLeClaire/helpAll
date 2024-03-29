<x-app-layout>
    <div class="flex center">
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$service->LIBELLE}}</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$service->DESCRIPTION}}</p>
            @if($service->TYPE === "echange_competences")
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$service->echange_competence->COMPETENCE}}</p>
            @endif
            @if($service->TYPE === "covoiturage")
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$service->covoiturage()->first()->NUMEROARRIVEE}}</p>
            @endif
            @if ($offreExiste === false)
            <form action="{{ route('service.offre', [$service->IDSERVICE,$service->IDUTILISATEUR]) }}" method="post">
                @csrf
                
                <a id="boutonOffre" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Faire une Offre
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
                
                <label style="display: none;" for="number-input" id="prix-label"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Renseignez le prix de l'offre:</label>
                <input style="display: none;" type="number" name="prix" id="prix-input"  aria-describedby="helper-text-explanation" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{$service->COUT}}" required />
                <button style="display: none;" type="submit" id="prix-submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Valider</button>
            </form>
            @endif

        </div>
    </div>

</x-app-layout>
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

<script src="{{ asset('js/detail.js') }}"></script>