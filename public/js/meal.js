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

        confirmationRequiredInputField(meal, errors, "name", "geen naam ingevuld");
        confirmationRequiredCheckboxes(meal, errors, "onerecipe", "recept");

        console.log(meal);

        postdata(meal, errors, '/api/campmeals/store', 'toegevoegd', true, redirect);

    });
});