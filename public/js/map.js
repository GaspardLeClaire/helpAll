//import { createApp, ref } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
var myAPIKey = "d248321452d9497c8b4cc40e76a44477";


$(document).ready(function () {
    var center = {
        // Angers
        lat: 47.4696544590685,
        lon: -0.5549797245440351
    }

    var map = new maplibregl.Map({
        center: [center.lon, center.lat],
        zoom: 12,
        container: 'my-map',
        style: `https://maps.geoapify.com/v1/styles/osm-carto/style.json?apiKey=${myAPIKey}`,
    });
    map.addControl(new maplibregl.NavigationControl());

    var services = JSON.parse($('#test').text());

    services.forEach((service) => {

        let rue = ""
        for (let i = 0; i < service.RUE.split(' ').length; i++) {
            rue += service.RUE.split(' ')[i] + '%20'
        }

        $.ajax({
            url: `https://api.geoapify.com/v1/geocode/search?housenumber=${service.NUMERO}&street=${rue}&postcode=${service.CODEPOSTAL}&city=${service.VILLE}&format=json&apiKey=${myAPIKey}`,
            success(data) {

                console.log(data.results)
                let marker = data.results[0];


                let colorC = "#FF00FF";
                if (service.ESTDEMANDE) {
                    
                    colorC = "#0000FF"

                }

                if (marker.country_code === 'fr') {
                    var adressPopup = new maplibregl.Popup({
                        anchor: 'bottom',
                        offset: [0, -50]
                    }).setLngLat([marker.lon, marker.lat])
                        .setHTML(`<div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="/detailAnnonce/${service.IDSERVICE}/${service.IDUTILISATEUR}">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">${service.LIBELLE}</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">${service.DESCRIPTION}</p>
                <a href="/detailAnnonce/${service.IDSERVICE}/${service.IDUTILISATEUR}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Read more
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>`
                        );

                    var adress = new maplibregl.Marker({
                        color: colorC,
                        draggable: true
                    }).setLngLat([marker.lon, marker.lat]).setPopup(adressPopup).addTo(map);
                }
            }
        })


    })

})


