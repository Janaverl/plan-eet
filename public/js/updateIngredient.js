$(document).ready(function () {

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let ingredient = {};
        e.preventDefault();

        ingredient["name"] = slug;

        if ($('input#suggestion').val()) {
            ingredient["suggestion"] = $('input#suggestion').val();
        }
        if (unit.value == "default") {
            errors.push("geen maateenheid geselecteerd");
        } else {
            ingredient["unit"] = unit.value;
        };
        if (rayon.value == "default") {
            errors.push("geen rayon geselecteerd");
        } else {
            ingredient["rayon"] = rayon.value;
        };

        // fetch the data or display errors
        if (errors.length == 0) {
            console.log("all set to push");
            console.log(ingredient);

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(ingredient);
            console.log(raw);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch('/fetch/update/ingredient', requestOptions)
                .then(response => response.json())
                .then(result => {
                    if (result.statuscode == 201) {
                        $(".success").append(`<li>${ingredient["name"]} werd succesvol aangepast.</li>`);
                    } else if (result.statuscode == 422) {
                        $(".errors").append(`<li>${ingredient["name"]} bestaat reeds.</li>`);
                    } else {
                        $(".errors").append(`<li>Er liep iets mis. Probeer opnieuw.</li>`);
                    };

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