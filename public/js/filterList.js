$(document).ready(function () {
    // start searching in the list as soon as the user starts typing in the inputfield
    $(".filterBy").on("keyup", function (e) {
        filterList($(this).val().toLowerCase(), $("li"));
    });
});