var myAPIKey = "d248321452d9497c8b4cc40e76a44477";

$(document).ready(function () {

    // Empêcher le comportement par défaut pour tous les boutons sauf le bouton de soumission
    $(document).on('click', 'button:not([type="submit"])', function (event) {
        event.preventDefault();
    });

    // Gérer la recherche d'adresse lorsque les champs de recherche changent
    $('.search').on('change', function () {
        researchAdress();
    });


    $('input[datetimepicker]').each(function() {
        var picker = new Pikaday({
            field: this,
            format: 'DD/MM/YYYY HH:mm', // Format for date and time
            showTime: true, // Enable time selection
            showMinutes: true, // Enable minute selection
            use24hour: true, // Use 24-hour format
            onSelect: function(date) {
                // Optional: perform an action when the user selects a date
                console.log('Selected date: ', date);
            }
        });
    });
    // Attacher un écouteur d'événements à tous les boutons d'adresse ajoutés dynamiquement
    $(document).on('click', '.boutonAdress', function () {
        // Récupérer les données de l'adresse à partir des attributs de données
        console.log('test')
        
        let housenumber = $(this).find('input').data('adress-housenumber');
        let street = $(this).find('input').data('adress-street');
        let postcode = $(this).find('input').data('adress-postcode');
        let city = $(this).find('input').data('adress-city');

        // Utiliser les données de l'adresse comme vous le souhaitez, par exemple, remplir les champs du formulaire
        $('#numero').val(housenumber);
        $('#rue').val(street);
        $('#codePostal').val(postcode);
        $('#ville').val(city);

        // Supprimer les suggestions d'adresse une fois que l'utilisateur a choisi une adresse
        $('.proposition').empty();
    });

    $('#typeService').on('change',function(){
        console.log( $('#typeService').val().toUpperCase())
        if($('#typeService').val().toUpperCase() === "COVOITURAGE"){
            $('.form-type').append(`<p>Test</p>`)
        }
    })

});

function researchAdress() {
    let text = "";

    if ($('#numero').val().length > 0) {
        text += $('#numero').val() + '%20';
    }

    let rue = "";
    if ($('#rue').val().length > 0) {
        for (let i = 0; i < $('#rue').val().split(' ').length; i++) {
            rue += $('#rue').val().split(' ')[i] + '%20';
        }
        text += rue;
    }

    if ($('#codePostal').val().length > 0) {
        text += $('#codePostal').val() + '%20';
    }
    if ($('#ville').val().length > 0) {
        text += $('#ville').val();
    }

    $.ajax({
        url: `https://api.geoapify.com/v1/geocode/autocomplete?text=${text}&format=json&apiKey=${myAPIKey}`,
        success(data) {
            $('.boutonAdress').empty();
            data.results.forEach(proposition => {
                console.log(proposition)
                let adress = `${proposition.address_line1}, ${proposition.address_line2}`;

                let button = $(`<button type="button" class="boutonAdress">
                                    <input type="text" name="proposition" data-adress-housenumber='${proposition.housenumber}' data-adress-street='${proposition.street}' data-adress-postcode='${proposition.postcode}' data-adress-city='${proposition.city}' value='${adress}' class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm adress">
                                </button>`);
                $('.proposition').append(button); // Append button to DOM
            });
        }
    });
}



