$(document).ready(function () {
    // --------------------------------------------
    // when the user clicks on confirmation
    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let value = {};
        e.preventDefault();

        // confirmation and saving te values
        if (!$('input#name').val()) {
            errors.push("geen naam ingevuld")
        } else {
            value["name"] = $('input#name').val();
            value["type"] = slug;
        };

        // fetch the data or display errors
        if (errors.length == 0) {
            // console.log("all set to push");
            // console.log(rayon);

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(value);
            console.log(raw);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch(route, requestOptions)
                .then(response => response.json())
                .then(result => {
                    if (result.statuscode == 201) {
                        $(".success").append(`<li>${value["name"]} werd succesvol toegevoegd.</li>`);
                    };
                    if (result.statuscode == 422) {
                        $(".errors").append(`<li>${value["name"]} bestaat reeds.</li>`);
                    } else {
                        $(".errors").append(`<li>Er liep iets mis. Probeer opnieuw.</li>`);
                    };

                    $('input[type="text"]').val('');
                    $('select').val("default");

                    return result;
                })
                .catch(error => {
                    console.log('error :::', error);
                });

        } else {
            errors.forEach(error =>
                $(".errors").append(`<li> ${error}</li> `)
            );
        }
    });
});