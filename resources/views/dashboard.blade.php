<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="bg-red-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                {{ session('success') }}
            </div>
            @endif


            <br>
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
                <br>
                <a href="{{route('service.delete', [$service->IDSERVICE,$service->IDUTILISATEUR]) }}" class="text-red-500 hover:text-red-700">Supprimer</a>
            </div>
            <br>
            @endforeach

        </div>
    </div>
</x-app-layout>