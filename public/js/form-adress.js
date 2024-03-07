var myAPIKey = "d248321452d9497c8b4cc40e76a44477";

function researchAdress() {

    let text = "";

    if ($('#numero').val().length > 0) {
        text += $('#numero').val() + '%20'
    }

    let rue = "";
    if ($('#rue').val().length > 0) {
        for (let i = 0; i < $('#rue').val().split(' ').length; i++) {
            rue += $('#rue').val().split(' ')[i] + '%20'
        }

        text += rue
    }

    if ($('#codePostal').val().length > 0) {
        text += $('#codePostal').val() + '%20'
    }
    if ($('#ville').val().length > 0) {
        text += $('#ville').val()
    }
    console.log(text)





    console.log(`https://api.geoapify.com/v1/geocode/autocomplete?text=${text}&format=json&apiKey=${myAPIKey}`)
    $.ajax({
        url: `https://api.geoapify.com/v1/geocode/autocomplete?text=${text}&format=json&apiKey=${myAPIKey}`,
        success(data) {
            console.log(data.results)
        }
    })
}

$('#rue').on('change', function () {
    researchAdress()
})

$('#codePostal').on('change', function () {
    researchAdress()
})

$('#ville').on('change', function () {
    researchAdress()
})
