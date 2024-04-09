$('.boutonConversation').on('click', function () {
  $('.messages').empty();

  $('#choose-offre').empty();

  var idUtilisateur = $(this).data('utilisateur-id');
  var idService = $(this).data('service-id');
  var idUtilisateur_1 = $(this).data('utilisateur_1-id');
  var authUtilisateur = $(this).data('auth-id');
  var url = $(this).data('url');
  console.log(url);
  console.log(`${idService} et ${idUtilisateur} et ${idUtilisateur_1} et ${authUtilisateur}`);

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
      });

      let formulaire = document.getElementById('form-new-message');
      if (formulaire != null) {
        if (authUtilisateur === idUtilisateur_1) {
          formulaire.action = `/message/${idUtilisateur_1}/${idService}/${idUtilisateur}`
        }
        else {
          formulaire.action = `/message/${idUtilisateur_1}/${idService}/${idUtilisateur_1}`
        }

      }

      /*$('#choose-offre').append(`<button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
      Accepter l'Offre
      </button>
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
      Refuser l'Offre
      </button>`)
      console.log($('choose-offre'));*/



    },
    error: function (xhr, status, error) {
      // Gestion des erreurs
      console.error("Erreur: " + error);
    }
  });
});