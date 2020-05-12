import string from "./utils/string.js";
import datafetch from "./utils/datafetch.js";
import modals from "./utils/modals.js";


$(document).ready(function () {
    const classname = "remove-recipe";
    let recipe = {};

    $("."+classname).on("click", function (e) {
        recipe["name"] = string.stripIdWithClassname(this, classname);
        datafetch.handleDeleteRequest(recipe, '/api/recipes');
    });

    modals.closeOnClick("remove");
    modals.closeOnClick("details");
})