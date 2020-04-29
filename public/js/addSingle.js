import datafetch from "./utils/datafetch.js";
import confirmation from "./utils/confirmation.js";

$(document).ready(function () {
    // --------------------------------------------
    // when the user clicks on confirmation
    $(".confirm").on("click", function (e) {
        $(".errors").empty();
        let errors = [];
        let value = {};
        e.preventDefault();

        // confirmation and saving te values
        confirmation.requiredInputField(value, errors, "name", "geen naam ingevuld");
        value["type"] = slug;

        datafetch.handleRequest(value, errors, route, 'toegevoegd', 'POST', true);

    });
});