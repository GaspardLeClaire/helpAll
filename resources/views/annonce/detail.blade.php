<x-app-layout>
    <br>

    <div class="flex justify-center items-center h-full">
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$service->LIBELLE}}</h5>
            </div>

            <div class="text-gray-500 text-sm">
                Publié le {{ $service->DATEPOSTER->format('d/m/Y') }} par {{ $service->etudiant->NOM }} {{ $service->etudiant->PRENOM }}
            </div>
            <div>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$service->DESCRIPTION}}</p>
            </div>
            <div>

                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">L'addresse de l'annonce est <b>{{$service->NUMERO}}</b> <b>{{$service->RUE}}</b>
                    , <b>{{$service->CODEPOSTAL}}</b> <b>{{$service->VILLE}}</b>.

                </p>

            </div>

            @if($service->TYPE === "Echanges_competences")

            <div>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><B>Compétence : </B> {{$service->echange_competence->COMPETENCE}}</p>
            </div>
            @endif
            @if($service->TYPE === "Covoiturage")
            <div>

                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">L'annonce concerne un covoiturage en direction du <b>{{$service->covoiturage()->first()->NUMEROARRIVEE}}</b> <b>{{$service->covoiturage()->first()->RUEARRIVEE}}</b>
                    , <b>{{$service->covoiturage()->first()->CODEPOSTALARRIVEE}}</b> <b>{{$service->covoiturage()->first()->VILLEARRIVEE}}</b>, qui sera effectué

                    @if($service->covoiturage()->first()->VOITUREPERSONNEL)
                    <b>avec mon véhicule personnel.</b>
                    @else
                    <b>sans mon véhicule personnel.</b>
                    @endif
                    le <b>{{date("d F Y à H:i", strtotime($service->covoiturage()->first()->DATEDEPART))}}</b>

                </p>

            </div>
            @endif
            <div class="flex justify-between">
                @if ($offreAccepter === false)
                <div>
                    <a href="{{ route('service.accepter', [$service->IDSERVICE,$service->IDUTILISATEUR]) }}" id="boutonValider" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Accepter L'annonce
                    </a>
                </div>
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

                    <label style="display: none;" for="number-input" id="prix-label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Renseignez le prix de l'offre:</label>
                    <input style="display: none;" type="number" name="prix" id="prix-input" aria-describedby="helper-text-explanation" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{$service->COUT}}" required />
                    <button style="display: none;" type="submit" id="prix-submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Valider</button>
                </form>
                @endif
            </div>
            @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                {{ session('success') }}
            </div>
            @endif




        </div>
    </div>
    <br>

</x-app-layout>
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

<script src="{{ asset('js/detail.js') }}"></script>