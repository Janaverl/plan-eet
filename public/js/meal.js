$(document).ready(function () {
    $(".switch.recipes input").change(function (e) {
        console.log("check");
        switchselector(this, "tr", ".onerecipe", "recipe");
    });
});