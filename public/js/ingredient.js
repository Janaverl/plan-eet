import datafetch from "./utils/datafetch.js";
import confirmation from "./utils/confirmation.js";

$(document).ready(function () {

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let ingredient = {};
        e.preventDefault();

        // confirmation and saving te values
        if (mode == "update") {
            ingredient["name"] = slug;
        } else {
            confirmation.requiredInputField(ingredient, errors, "name", "geen naam ingevuld");
        };
        confirmation.optionalInputField(ingredient, "suggestion");
        confirmation.requiredSelect(ingredient, errors, unit, "unit", "geen maateenheid geselecteerd");
        confirmation.requiredSelect(ingredient, errors, rayon, "rayon", "geen rayon geselecteerd");

        // fetch the data or display errors
        if (mode == "add") {
            datafetch.handleRequest(ingredient, errors, '/api/ingredients', 'toegevoegd', 'POST', true);
        } else if (mode == "update") {
            datafetch.handleRequest(ingredient, errors, '/api/ingredients', 'aangepast', 'PUT', false);
        } else {
            $(".errors").append(`<li>Er liep iets mis.</li>`);
        }
    });
});