import datafetch from "./utils/datafetch.js";
import confirmation from "./utils/confirmation.js";

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
        switchselector(this, "div", ".oneIngredient", "ingredients");
    });
    $(".switch.herbs input").change(function (e) {
        switchselector(this, "div", ".oneHerb", "herbs");
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
            confirmation.requiredInputField(recipe, errors, "name", "geen naam ingevuld");
        }
        confirmation.optionalInputField(recipe, "suggestion");
        confirmation.requiredSelect(recipe, errors, category, "category", "geen categorie geselecteerd");
        confirmation.requiredSelect(recipe, errors, type, "type", "geen type geselecteerd");
        confirmation.requiredInputField(recipe, errors, "numberOfEaters", "geen aantal eters ingevuld");
        confirmation.oneIngredient(recipe, errors);
        confirmation.optionalCheckboxes(recipe, "herbs", "oneHerb");
        confirmation.requiredTextarea(recipe, errors, "instructions", "geen bereidingswijze ingevuld");

        if (mode == "add") {
            datafetch.handleRequest(recipe, errors, '/api/recipes', 'toegevoegd', 'POST', true);
        } else if (mode == "update") {
            datafetch.handleRequest(recipe, errors, '/api/recipes', 'aangepast', 'PUT', false);
        } else {
            $(".errors").append(`<li>Er liep iets mis.</li>`);
        }
    });

});