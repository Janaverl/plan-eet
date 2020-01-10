$(document).ready(function () {
    console.log("updateRecipe.js");
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    // // ---------------------------------------------
    // // requestoptions for GET
    // var requestOptions = {
    //     method: 'GET',
    //     headers: myHeaders,
    //     redirect: 'follow'
    // };

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
    $('input:checkbox[name="ingredients"]').change(function (e) {
        const value = $(this).val();
        if (!$('input[name="unit-' + value + '"]').attr('disabled')) {
            return $('input[name="unit-' + value + '"]').attr('disabled', true);
        } else {
            return $('input[name="unit-' + value + '"]').attr('disabled', false);
        }
    });


    // -----------------------------------------------
    // validation of all the values

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let recipe = {};
        e.preventDefault();

        // confirmation and saving te values
        // if (!$('input#name').val()) {
        //     errors.push("geen naam ingevuld")
        // } else {
        //     recipe["name"] = $('input#name').val();
        // };
        recipe["name"] = slug;
        if ($('input#suggestion').val()) {
            recipe["suggestion"] = $('input#suggestion').val();
        }
        if (category.value == "default") {
            errors.push("geen categorie geselecteerd");
        } else {
            recipe["category"] = category.value;
        };
        if (type.value == "default") {
            errors.push("geen type geselecteerd");
        } else {
            recipe["type"] = type.value;
        };
        if (!$("#numberOfEaters").val()) {
            errors.push("geen aantal eters ingevuld");
        } else {
            recipe["numberOfEaters"] = $("#numberOfEaters").val();
        };
        if ($(".oneIngredient input:checkbox:checked").length == 0) {
            errors.push("geen ingredient geselecteerd");
        } else {
            let ingr = {};
            let i = 0;
            $(".oneIngredient input:checkbox:checked").each(function () {
                if (!$(this).siblings().children('input').val()) {
                    errors.push(`geen hoeveelheid ingevuld voor ${$(this).siblings().eq(1).text()}`);
                } else {
                    const oneIngredient = {};
                    oneIngredient["quantity"] = $(this).siblings().children('input').val();
                    // oneIngredient["unit"] = $(this).siblings().first().text();
                    oneIngredient["name"] = $(this).siblings().eq(1).text();
                    ingr[i] = oneIngredient;
                    i++;
                }
            });
            recipe["ingredients"] = ingr
        };
        if ($(".oneHerb input:checkbox:checked").length != 0) {
            let herbs = {};
            let i = 0;
            $(".oneHerb input:checkbox:checked").each(function () {
                const oneHerb = $(this).siblings().eq(0).text();
                herbs[i] = oneHerb;
                i++;
            });
            recipe["herbs"] = herbs
        };
        if (!$('textarea').val()) {
            errors.push("geen bereidingswijze ingevuld");
        } else {
            recipe["instructions"] = $("textarea").val();
        };

        // fetch or display errors
        if (errors.length == 0) {
            console.log("all set to push");
            console.log(recipe);

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(recipe);
            console.log("raw :: " + raw);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch('/fetch/update/recipe', requestOptions)
                .then(response => response.json())
                .then(result => {
                    console.log("result :: " + result)
                    if (result.statuscode == 201) {
                        $(".success").append(`<li>${recipe["name"]} werd succesvol aangepast.</li>`);
                    } else {
                        $(".errors").append(`<li>Er liep iets mis. Probeer opnieuw.</li>`);
                    };

                    $('.w3-check').prop('checked', false);
                    $('input').val('');
                    $('textarea').val('');
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