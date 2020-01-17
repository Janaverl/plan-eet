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
            confirmationRequiredInputField(ingredient, errors, "name", "geen naam ingevuld");
        };
        confirmationOptionalInputField(ingredient, "suggestion");
        confirmationRequiredSelect(ingredient, errors, unit, "unit", "geen maateenheid geselecteerd");
        confirmationRequiredSelect(ingredient, errors, rayon, "rayon", "geen rayon geselecteerd");

        // fetch the data or display errors
        if (mode == "add") {
            postdata(ingredient, errors, '/fetch/add/ingredient', 'toegevoegd', true);
        } else if (mode == "update") {
            postdata(ingredient, errors, '/fetch/update/ingredient', 'aangepast', false);
        } else {
            $(".errors").append(`<li>Er liep iets mis.</li>`);
        }
    });
});