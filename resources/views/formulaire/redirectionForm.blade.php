<x-app-layout>
    <div class="place-content-center">
        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Covoiturage</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Cliquez ici pour définir votre service de type covoiturage</p>
        </a>
    </div>
    <br>
    <div>
        <a href="{{ route('formulaire.index.competence', [$service->IDSERVICE,$service->IDUTILISATEUR]) }}" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Échange de  Competence</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Cliquez ici pour définir votre service de type échanges de compétence</p>
        </a>
    </div>
    <br>
    <div>
        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Cinema</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Cliquez ici pour définir votre service de type cinéma</p>
        </a>
    </div>
    <br>
    <div>
        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Lecture</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Cliquez ici pour définir votre service de type lecture</p>
        </a>
    </div>
    <br>
    <div>
        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Loisir</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Cliquez ici pour définir votre service de type loisir</p>
        </a>
    </div>
    <br>
    <div>
        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Événement sportif</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Cliquez ici pour définir votre service de type événement sportif</p>
        </a>
    </div>
    <br>

</x-app-layout>