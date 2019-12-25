$(document).ready(function () {
    $(".change").hover(function () {
        console.log($(this).parent());
        $(this).parent().toggleClass("hovered")
    });

    $('.search').keyup(filterTable);

    for (let i = 0; i < $(".sortTitles th").length; i++) {
        $(`.sortTitles th:nth-child(${i + 1})`).on("click", function () {
            sortTable(i);
        })
    }

});