$('.boutonConversation').on('click', function () {
    var idUtilisateur = $(this).data('utilisateur-id');
    var idService = $(this).data('service-id');
    var idUtilisateur_1 = $(this).data('utilisateur_1-id');
    var url = $('#ajax-url').data('url');
    console.log(`${idService} et ${idUtilisateur} et ${idUtilisateur_1}`);
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            idService: idService, // Remplacez 'valeur_idService' par la valeur réelle de idService
            idUtilisateur: idUtilisateur, // Remplacez 'valeur_idUtilisateur' par la valeur réelle de idUtilisateur
            idUtilisateur_1: idUtilisateur_1
        },
        success: function (data) {
            // Traitement de la réponse en cas de succès
            console.log(data);
            data.forEach(message => {
                console.log(message);
                $('.messages').empty();
                if (message.IDUTILISATEUR !== message.him.IDUTILISATEUR) {
                  console.log('gauche')
                    $('.messages').append(`<div class="col-start-1 col-end-8 p-3 rounded-lg">
                <div class="flex flex-row items-center">
                  <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                    ${message.otherStudent.NOM[0]}
                  </div>
                  <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                    <div>${message.CONTENU}</div>
                  </div>
                </div>
              </div>`)
                }
                else{
                    console.log("droite")
                    $('.messages').append(`<div class="col-start-6 col-end-13 p-3 rounded-lg">
                    <div class="flex items-center justify-start flex-row-reverse">
                      <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                      ${message.him.NOM[0]}
                      </div>
                      <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                        <div>${message.CONTENU}</div>
                      </div>
                    </div>
                  </div>`)
                }
            });
            
            /* AUTRE
            <div class="col-start-1 col-end-8 p-3 rounded-lg">
                    <div class="flex flex-row items-center">
                      <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                        A
                      </div>
                      <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                        <div>Hey How are you today?</div>
                      </div>
                    </div>
                  </div>
          */

            /* LUI 
            <div class="col-start-6 col-end-13 p-3 rounded-lg">
                      <div class="flex items-center justify-start flex-row-reverse">
                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                          A
                        </div>
                        <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                          <div>I'm ok what about you?</div>
                        </div>
                      </div>
                    </div>
            */


        },
        error: function (xhr, status, error) {
            // Gestion des erreurs
            console.error("Erreur: " + error);
        }
    });
});