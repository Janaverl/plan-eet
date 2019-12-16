$(document).ready(function () {
    // ---------------------------------------------
    // my functions
    function filterthis(filterBy, filterThis) {
        filterThis.filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filterBy) > -1)
        });
    }
    // start searching in the list of rayons as soon as the user starts typing in the inputfield
    $("#searchForRayons").on("keyup", function (e) {
        filterthis($(this).val().toLowerCase(), $("li"));
    });

    // --------------------------------------------
    // when the user clicks on confirmation
    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let rayon = {};
        e.preventDefault();

        // confirmation and saving te values
        if (!$('input#name').val()) {
            errors.push("geen naam ingevuld")
        } else {
            rayon["name"] = $('input#name').val();
        };

        // fetch the data or display errors
        if (errors.length == 0) {
            console.log("all set to push");
            console.log(rayon);

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(rayon);
            console.log(raw);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch('https://127.0.0.1:8000/fetch/add/rayon', requestOptions)
                .then(response => response.json())
                .then(result => {
                    $(".success").append(`<li>${JSON.parse(JSON.stringify(result.rayon))} werd succesvol toegevoegd</li>`);
                    $('input[type="text"]').val('');
                    $('select').val("default");
                    return result;
                })
                .catch(error => console.log('error :::', error));

        } else {
            errors.forEach(error =>
                $(".errors").append(`<li>${error}</li>`)
            );
        }
    });
});