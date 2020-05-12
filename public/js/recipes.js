import string from "./utils/string.js";
import datafetch from "./utils/datafetch.js";


$(document).ready(function () {
    const classname = "remove-recipe";
    let recipe = {};

    $("."+classname).on("click", function (e) {
        recipe["name"] = string.stripIdWithClassname(this, classname);
        // datafetch.handleRequest(recipe, [], '/api/recipes', 'verwijderd', 'DELETE', true);
        datafetch.handleDeleteRequest(recipe, '/api/recipes');
    });
})