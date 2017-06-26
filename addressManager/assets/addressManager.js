$('body').on('click', '#addresses-list .delete-link, #addresses-list .make-default-link', function () {
    var $this = $(this);
    $.ajax({
        type: "POST",
        url: $this.data('href'),
        success: function (data) {
            $("#addresses-list").html(data);
        }
    });
});

// Autocomplete of the Google Places API
var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    postal_code: 'short_name'
};
var componentFormId = {
    street_number: 'Address_street_number',
    route: 'Address_route',
    locality: 'Address_city',
    administrative_area_level_1: 'Address_state',
    postal_code: 'Address_zip'
};

function initAutocomplete() {
    // Create the autocomplete object
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
        document.getElementById(componentFormId[component]).value = '';
        document.getElementById(componentFormId[component]).disabled = false;
    }

    // Get each component of the address from the place details and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(componentFormId[addressType]).value = val;
        }
    }
}
// [END region_fillform]

// [START region_geolocation]
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}
// [END region_geolocation]

function resetForm() {
    for (var component in componentForm) {
        document.getElementById(componentFormId[component]).value = '';
        document.getElementById(componentFormId[component]).disabled = true;
    }
    document.getElementById('autocomplete').value = '';

    $('.form .row').removeClass('success');
}