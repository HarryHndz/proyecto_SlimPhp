/**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */
let map;
let marker;
let geocoder;
let responseDiv;
let response;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
    zoom: 8,
    center: { lat: -34.397, lng: 150.644 },
    mapTypeControl: false,
    });
    geocoder = new google.maps.Geocoder();

    response = document.createElement("pre");
    response.id = "response";
    response.innerText = "";

    marker = new google.maps.Marker({
        map,
    });
    map.addListener("click", (e) => {
        geocode({ location: e.latLng });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var texto = document.getElementById("direccion").innerText;
        console.log(texto)
        geocode({ address: texto})
    });
    
}

function geocode(request) {

    geocoder
    .geocode(request)
    .then((result) => {
        const { results } = result;
        if (results.length > 0) {
            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
            marker.setMap(map);
            response.innerText = JSON.stringify(result, null, 2);
            return results;
        } else {
            alert("No se encontraron resultados para la dirección proporcionada.");
        }
    })
    .catch((e) => {
        alert("Geocode was not successful for the following reason: " + e);
    });
}

window.initMap = initMap;
