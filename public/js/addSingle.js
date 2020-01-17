$(document).ready(function () {
    // --------------------------------------------
    // when the user clicks on confirmation
    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let value = {};
        e.preventDefault();

        // confirmation and saving te values
        confirmationRequiredInputField(value, errors, "name", "geen naam ingevuld");
        value["type"] = slug;

        postdata(value, errors, route, 'toegevoegd', true);

    });
});