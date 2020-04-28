function filterList(filterBy, filterThis) {
    filterThis.filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(filterBy) > -1)
    });
}

function switchselector(that, elementtype, elementclass, checkbox) {
    if (that.checked) {
        $(elementclass).css('display', 'none');
        $('input:checkbox[name="' + checkbox + '"]:checked').each(function () {
            console.log($(this).val());
            $(`${elementtype}${elementclass}.` + $(this).val()).css('display', '');
        });
    } else {
        $(`${elementtype}${elementclass}`).css('display', '');
    }
};

function enableChildInputfields(nameCheckbox, namechildInputfield) {
    $(`input:checkbox[name="${nameCheckbox}"]`).change(function (e) {
        const value = $(this).val();
        if (!$(`input[name="${namechildInputfield}-${value}"]`).attr('disabled')) {
            return $(`input[name="${namechildInputfield}-${value}"]`).attr('disabled', true);
        } else {
            return $(`input[name="${namechildInputfield}-${value}"]`).attr('disabled', false);
        }
    });
}