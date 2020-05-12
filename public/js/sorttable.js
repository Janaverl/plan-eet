$(document).ready(function () {
    $(".icons").hover(function () {
        console.log($(this).parent());
        $(this).parent().toggleClass("hovered")
    });

    $('.search').keyup(filterTable);

    for (let i = 0; i < $(".sortable").length; i++) {
        $(`.sortable:nth-child(${i + 1})`).on("click", function () {
            sortTable(i);
        })
    }

});