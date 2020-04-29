import datafetch from "./utils/datafetch.js";
import confirmation from "./utils/confirmation.js";

$(document).ready(function () {
    $(".switch.recipes input").change(function (e) {
        console.log("check");
        switchselector(this, "tr", ".onerecipe", "recipe");
    });

    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        // let meal = {};
        e.preventDefault();

        confirmation.requiredInputField(meal, errors, "name", "geen naam ingevuld");
        confirmation.requiredCheckboxes(meal, errors, "onerecipe", "recept");

        console.log(meal);

        datafetch.handleRequest(meal, errors, '/api/campmeals', 'toegevoegd', 'POST', true, redirect);

    });
});