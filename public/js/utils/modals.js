function closeOnClick(classname) {
    $(".close-modal").on("click", function (e) {
        $(".w3-modal."+classname).css("display", "none")
    })
}

export default {
    closeOnClick
}