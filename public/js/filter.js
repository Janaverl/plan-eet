$(document).ready(function () {
    // ---------------------------------------------
    // my functions
    function filterthis(filterBy, filterThis) {
        filterThis.filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filterBy) > -1)
        });
    }
    // start searching in the list of rayons as soon as the user starts typing in the inputfield
    $(".filterBy").on("keyup", function (e) {
        filterthis($(this).val().toLowerCase(), $("li"));
    });
});