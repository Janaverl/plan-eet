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

        show_error_or_fetch_data(value, errors, route, 'toegevoegd', 'POST', true);

    });
});