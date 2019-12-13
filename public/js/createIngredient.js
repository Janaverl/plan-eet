$(document).ready(function () {

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let ingredient = {};
        e.preventDefault();

        // confirmation and saving te values
        if (!$('input#name').val()) {
            errors.push("geen naam ingevuld")
        } else {
            ingredient["name"] = $('input#name').val();
        };
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

            fetch('http://localhost:8000/fetch/add/ingredient', requestOptions)
                .then(response => response.text())
                .then(result => {
                    console.log(JSON.stringify(result));
                    console.log(result);
                    console.log("gelukt!");
                })
                .catch(error => console.log('error :::', error));

        } else {
            errors.forEach(error =>
                $(".errors").append(`<li>${error}</li>`)
            );
        }
    });
});