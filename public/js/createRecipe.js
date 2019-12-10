$(document).ready(function () {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    // ---------------------------------------------
    // my functions
    function filterthis(filterBy, filterThis) {
        filterThis.filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filterBy) > -1)
        });
    }

    // ---------------------------------------------
    // requestoptions for GET
    var requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    // ---------------------------------------------
    // fetch for the categories
    fetch('http://localhost:9000/api/getCategories.php', requestOptions)
        .then(response => response.json())
        .then(result => {
            let labels = "";
            result.forEach(function (category) {
                labels += `<option value="${category.name}">${category.name}</option>`
            });
            return $(".selectCategorie").after(labels);
        })
        .catch(error => console.log('error', error));

    // ---------------------------------------------
    // fetch for the types
    fetch('http://localhost:9000/api/getTypes.php', requestOptions)
        .then(response => response.json())
        .then(result => {
            let labels = "";
            result.forEach(function (type) {
                labels += `<option value="${type.name}">${type.name}</option>`
            });
            return $(".selectType").after(labels);
        })
        .catch(error => console.log('error', error));

    // ---------------------------------------------
    // fetch for all the ingredients
    fetch('http://localhost:9000/api/getIngredients.php', requestOptions)
        .then(response => response.json())
        .then(result => {
            let checkboxes = "";
            result.forEach(function (ingredient) {
                checkboxes += `<div class="oneIngredient ingredient${ingredient.ingredientID}">`;
                checkboxes += `<input class="w3-check ingredienten" type="checkbox" name="ingredienten" value="ingredient${ingredient.ingredientID}" />`;
                checkboxes += `<label for="unitingredient${ingredient.ingredientID}">`;
                checkboxes += `<input type="number" step="0.01" name="unitingredient${ingredient.ingredientID}" disabled />`;
                checkboxes += `${ingredient.eenheid}</label>`;
                checkboxes += `<label for="ingredient${ingredient.ingredientID}"> ${ingredient.naamIngredient}</label>`
                checkboxes += `</div>`
            });
            return $(".chooseIngredients").append(checkboxes);
        })
        .catch(error => console.log('error', error));

    // start searching in the list of ingresients as soon as the user starts typing in the inputfield
    $("#searchForIngredients").on("keyup", function (e) {
        filterthis($(this).val().toLowerCase(), $(".oneIngredient"));
    });

    // show only the selected ingredients when the user turned on the switch. Show all the ingredients when the user turns the switch off
    $(".switch input").change(function (e) {
        if (this.checked) {
            $('.oneIngredient').css('display', 'none');
            $('input:checkbox[name="ingredienten"]:checked').each(function () {
                console.log('.oneIngredient .' + $(this).val());
                $('.oneIngredient.' + $(this).val()).css('display', 'block');
            });
        } else {
            $('.oneIngredient').css('display', 'block');
        }
    });

    // enable the input value for the ingredient-unit when the ingredient is selected. Disable when it's unselected
    $(window).load(function () {
        function enableUnits() {
            $('.oneIngredient input[type="checkbox"]').on("change", function () {
                console.log("I asked the radio-buttons, and it told me you've made a change");
                const value = $(this).val();
                if (!$('input[name="unit' + value + '"]').attr('disabled')) {
                    return $('input[name="unit' + value + '"]').attr('disabled', true);
                } else {
                    return $('input[name="unit' + value + '"]').attr('disabled', false);
                }
            });
        };
        window.setTimeout(enableUnits, 1000); // 5 seconds
    })


    // -----------------------------------------------
    // validation of all the values

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let recipe = {};
        e.preventDefault();

        // confirmation and saving te values
        if (!$('input#naam').val()) {
            errors.push("geen naam ingevuld")
        } else {
            recipe["name"] = $('input#naam').val();
        };
        if ($('input#receptTip').val()) {
            recipe["receptTip"] = $('input#receptTip').val();
        }
        if (categorie.value == "default") {
            errors.push("geen categorie geselecteerd");
        } else {
            recipe["categorie"] = categorie.value;
        };
        if (type.value == "default") {
            errors.push("geen type geselecteerd");
        } else {
            recipe["type"] = type.value;
        };
        if (!$("#numberOfEaters").val()) {
            errors.push("geen aantal eters ingevuld");
        } else {
            recipe["nrOfEaters"] = $("#numberOfEaters").val();
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
                    oneIngredient["ingredientID"] = $(this).val();
                    oneIngredient["quantity"] = $(this).siblings().children('input').val();
                    oneIngredient["unit"] = $(this).siblings().first().text();
                    oneIngredient["ingr"] = $(this).siblings().eq(1).text();
                    ingr[i] = oneIngredient;
                    i++;
                }
            });
            recipe["ingredients"] = ingr
        };
        if (!$('textarea').val()) {
            errors.push("geen recept ingevuld");
        } else {
            recipe["recipe"] = $("textarea").val();
        };

        // fetch or display errors
        if (errors.length == 0) {
            console.log("all set to push");
            console.log(recipe);

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(recipe);
            console.log(raw);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch('http://localhost:9000/api/setRecipe.php', requestOptions)
                .then(response => response.text())
                .then(result => console.log(JSON.stringify(result)))
                .catch(error => console.log('error :::', error));

        } else {
            errors.forEach(error =>
                $(".errors").append(`<li>${error}</li>`)
            );
        }
    });

});