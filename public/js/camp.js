$(document).ready(function () {

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let camp = {};
        e.preventDefault();

        // confirmation and saving te values
        confirmationRequiredInputField(camp, errors, "name", "geen naam ingevuld");
        confirmationRequiredInputField(camp, errors, "nrOfParticipants", "geen aantal deelnemers ingevuld");
        confirmationRequiredInputField(camp, errors, "startdate", "geen begindatum ingevuld");
        confirmationRequiredInputField(camp, errors, "starthour", "geen beginuur ingevuld");
        confirmationRequiredInputField(camp, errors, "startmin", "geen beginminuten ingevuld");
        confirmationRequiredInputField(camp, errors, "enddate", "geen einddatum ingevuld");
        confirmationRequiredInputField(camp, errors, "endhour", "geen einduur ingevuld");
        confirmationRequiredInputField(camp, errors, "endmin", "geen eindminuten ingevuld");

        // fetch the data or display errors
        if (errors.length == 0) {
            console.log("all set to push");
            console.log(camp);

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(camp);
            console.log(raw);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };
            fetch('/fetch/add/camp', requestOptions)
                .then(response => response.json())
                .then(result => {
                    if (result.statuscode == 201) {
                        $(".success").append(`<li>${camp["name"]} werd succesvol toegevoegd.</li>`);
                    } else {
                        $(".errors").append(`<li>Er liep iets mis. Probeer opnieuw.</li>`);
                    };

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