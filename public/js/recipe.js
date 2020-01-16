$(document).ready(function () {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    // start searching in the list of ingredients as soon as the user starts typing in the inputfield
    $("#searchForIngredients").on("keyup", function (e) {
        filterList($(this).val().toLowerCase(), $(".oneIngredient"));
    });
    $("#searchForHerbs").on("keyup", function (e) {
        filterList($(this).val().toLowerCase(), $(".oneHerb"));
    });

    // show only the selected ingredients/herbs when the user turned on the switch. Show all the ingredients/herbs when the user turns the switch off
    $(".switch.ingredients input").change(function (e) {
        switchselector(this, ".oneIngredient", "ingredients");
    });
    $(".switch.herbs input").change(function (e) {
        switchselector(this, ".oneHerb", "herbs");
    });

    // enable the input value for the ingredient-unit when the ingredient is selected. Disable when it's not selected
    enableChildInputfields("ingredients", "unit");

    // -----------------------------------------------
    // validation of all the values

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let recipe = {};
        e.preventDefault();

        // confirmation and saving te values
        if (mode == "update") {
            recipe["name"] = slug;
        } else {
            confirmationRequiredInputField(recipe, errors, "name", "geen naam ingevuld");
        }
        confirmationOptionalInputField(recipe, "suggestion");
        confirmationRequiredSelect(recipe, errors, category, "category", "geen categorie geselecteerd");
        confirmationRequiredSelect(recipe, errors, type, "type", "geen type geselecteerd");
        confirmationRequiredInputField(recipe, errors, "numberOfEaters", "geen aantal eters ingevuld");
        confirmationOneIngredient(recipe, errors);
        confirmationOptionalCheckboxes(recipe, herbs, "oneHerb");
        confirmationRequiredTextarea(recipe, errors, "instructions", "geen bereidingswijze ingevuld");


        // fetch or display errors
        if (errors.length == 0) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(recipe);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            if (mode == "add") {
                fetch('/fetch/add/recipe', requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        if (result.statuscode == 201) {
                            $(".success").append(`<li>${recipe["name"]} werd succesvol toegevoegd.</li>`);
                        } else if (result.statuscode == 422) {
                            $(".errors").append(`<li>${recipe["name"]} bestaat reeds.</li>`);
                        } else {
                            $(".errors").append(`<li>Er liep iets mis. Probeer opnieuw.</li>`);
                        };

                        $('.w3-check').prop('checked', false);
                        $('input').val('');
                        $('textarea').val('');
                        $('select').val("default");
                        $('.unit').attr('disabled', true);

                        return result;
                    })
                    .catch(error => console.log('error :::', error));
            } else if (mode == "update") {
                fetch('/fetch/update/recipe', requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        console.log("result :: " + result)
                        if (result.statuscode == 201) {
                            $(".success").append(`<li>${recipe["name"]} werd succesvol aangepast.</li>`);
                        } else {
                            $(".errors").append(`<li>Er liep iets mis. Probeer opnieuw.</li>`);
                        };

                        return result;
                    })
                    .catch(error => console.log('error :::', error));
            } else {
                $(".errors").append(`<li>Er liep iets mis. Probeer opnieuw.</li>`);
            }

        } else {
            errors.forEach(error =>
                $(".errors").append(`<li>${error}</li>`)
            );
        }
    });

});