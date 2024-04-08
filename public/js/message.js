$('.boutonConversation').on('click', function () {




  var idUtilisateur = $(this).data('utilisateur-id');
  var idService = $(this).data('service-id');
  var idUtilisateur_1 = $(this).data('utilisateur_1-id');
  var authUtilisateur = $(this).data('auth-id');
  var url = $('#ajax-url').data('url');
  console.log(url);
  console.log(`${idService} et ${idUtilisateur} et ${idUtilisateur_1} et ${authUtilisateur}`);

  var divChooseOffre = document.getElementById("choose-offre");
  if (idUtilisateur_1 == authUtilisateur) {
    divChooseOffre.append(`              <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
      <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
    </svg>
    Accepter L'offre
  </button>
  <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    Refuser l'offre
    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
    </svg>
  </button>`)
  }




  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      idService: idService,
      idUtilisateur: idUtilisateur,
      idUtilisateur_1: idUtilisateur_1
    },
    success: function (data) {
      // Traitement de la réponse en cas de succès
      console.log(data);
      $('.messages').empty();
      data.forEach(message => {
        console.log(message);
        if (message.IDUTILISATEUR !== authUtilisateur) {
          console.log('gauche')
          $('.messages').append(`<div class="col-start-1 col-end-8 p-3 rounded-lg">
                <div class="flex flex-row items-center">
                  <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                    ${"A"}
                  </div>
                  <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                    <div>${message.CONTENU}</div>
                  </div>
                </div>
              </div>`)
          // modifié l'action du formulaire 
          let formulaire = document.getElementById('form-new-message');
          if (formulaire != null) {
            formulaire.action = `/message/${idUtilisateur_1}/${idService}/${authUtilisateur}`
          }
        }
        else {
          console.log("droite")
          $('.messages').append(`<div class="col-start-6 col-end-13 p-3 rounded-lg">
                    <div class="flex items-center justify-start flex-row-reverse">
                      <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                      ${"B"}
                      </div>
                      <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                        <div>${message.CONTENU}</div>
                      </div>
                    </div>
                  </div>`)
        }
        let formulaire = document.getElementById('form-new-message');
        if (formulaire != null) {
          formulaire.action = `/message/${idUtilisateur_1}/${idService}/${idUtilisateur_1}`
        }
      });

    },
    error: function (xhr, status, error) {
      // Gestion des erreurs
      console.error("Erreur: " + error);
    }
  });
});