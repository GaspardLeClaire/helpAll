<x-app-layout>
  <div class="flex h-screen antialiased text-gray-800">
    <div class="flex flex-row h-[calc(100%-64px)] w-full overflow-x-hidden">
      <div class="flex flex-col py-8 pl-6 pr-2 w-64 bg-white flex-shrink-0">
        <div class="flex flex-row items-center justify-center h-12 w-full">
          <div class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
          </div>
          <div class="ml-2 font-bold text-2xl">QuickChat</div>
        </div>

        <!-- LIST CONVERSATION -->

        <div class="flex flex-col mt-8">
          <div class="flex flex-row items-center justify-between text-xs">
            <span class="font-bold">Active Conversations</span>
            <span class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">{{ $offres->count(); }}</span>
          </div>
          <div>
            @foreach($offres as $offre)
            <div class="flex flex-col space-y-1 mt-4 -mx-2 overflow-y-auto">
              <button class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2 boutonConversation" data-utilisateur_1-id="{{$offre->IDUTILISATEUR_1}}" data-service-id="{{$offre->IDSERVICE}}" data-utilisateur-id="{{$offre->IDUTILISATEUR}}" data-auth-id="{{ Auth::user()->IDUTILISATEUR }}" data-url="http://192.168.113.21/api/messages?id_utilisateur={{$offre->IDUTILISATEUR}}&id_service={{$offre->IDSERVICE}}">
                <div class="flex items-center justify-center h-8 w-8 bg-gray-200 rounded-full">
                  {{ $offre->etudiant->NOM[0] }}
                </div>
                <div class="ml-2 text-sm font-semibold utilisateur">{{$offre->etudiant->NOM}} {{$offre->etudiant->PRENOM}} </div>
                <div class="ml-2 text-sm font-semibold service">id : {{$offre->IDSERVICE}} </div>
                <!-- <div class="flex items-center justify-center ml-auto text-xs text-white bg-red-500 h-4 w-4 rounded leading-none">
                  2
                </div> -->
              </button>
            </div>
            @endforeach
          </div>
        </div>
      </div>



      <!-- MESSAGE -->

      <div class="flex flex-col flex-auto h-11/12 p-6">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4">
          <div class="flex flex-col h-full overflow-x-auto mb-4">
            <div class="flex flex-col h-full">
              <div class="grid grid-cols-12 gap-y-2 messages">

              </div>

            </div>
          </div>
          <div class="flex flex-row items-center h-15 rounded-xl bg-white w-full px-4">
            <div>
              <button class="flex items-center justify-center text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                </svg>
              </button>
            </div>
            <div class="flex-grow ml-4">
              <div class="relative w-full">
                <form action="{{ route('message.store', [0,0,0]) }}" method="POST" id="form-new-message">
                  @CSRF
                  <input type="text" class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10" name="CONTENU" />
                  <button type="submit" class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </button>

              </div>
            </div>
            <div class="ml-4">
              <button type="submit" class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                <span>Send</span>
                <span class="ml-2">
                  <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                  </svg>
                </span>
              </button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
  <!-- Inclure MapLibre-GL avant le script -->
  <script src="{{ asset('js/maplibre-gl.js') }}"></script>
  <!-- Inclure votre fichier JavaScript après MapLibre-GL -->
  <script src="{{ asset('js/message.js') }}"></script>
</x-app-layout>