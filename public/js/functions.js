function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("allIngredients");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function filterTable() {
    const searchFor = [];

    for (let i = 0; i < $(".search input").length; i++) {
        searchFor.push(new RegExp($(`.search input:nth-child(${i + 1})`).val(), 'i'));
    }

    const row = $(".searchable tr")

    row.hide();

    row.filter(function () {
        let tester = true;
        const that = this;

        searchFor.forEach(function (search) {
            test = search.test($(that).text());

            if (test == false) {
                return tester = false;
            }
        });

        return tester;
    }).show();
}

function filterList(filterBy, filterThis) {
    filterThis.filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(filterBy) > -1)
    });
}

function switchselector(that, element, checkbox) {
    if (that.checked) {
        $(element).css('display', 'none');
        $('input:checkbox[name="' + checkbox + '"]:checked').each(function () {
            console.log($(this).val());
            $('div' + element + '.' + $(this).val()).css('display', 'block');
        });
    } else {
        $(element).css('display', 'block');
    }
};

function enableChildInputfields(nameCheckbox, namechildInputfield) {
    $(`input:checkbox[name="${nameCheckbox}"]`).change(function (e) {
        const value = $(this).val();
        if (!$('input[name="unit-' + value + '"]').attr('disabled')) {
            return $(`input[name="${namechildInputfield}-${value}"]`).attr('disabled', true);
        } else {
            return $(`input[name="${namechildInputfield}-${value}"]`).attr('disabled', false);
        }
    });
}

function confirmationRequiredInputField(array, errors, id, errormsg) {
    if (!$(`input#${id}`).val()) {
        errors.push(errormsg)
    } else {
        array[`${id}`] = $(`input#${id}`).val();
    };
};

function confirmationRequiredSelect(array, errors, name, nameInString, errormsg) {
    if (name.value == "default") {
        errors.push(errormsg);
    } else {
        array[nameInString] = name.value;
    };
};

function confirmationRequiredTextarea(array, errors, id, errormsg) {
    if (!$('textarea').val()) {
        errors.push(errormsg)
    } else {
        array[`${id}`] = $("textarea").val();
    };
};

function confirmationOptionalInputField(array, id) {
    if ($(`input#${id}`).val()) {
        array[`${id}`] = $(`input#${id}`).val();
    };
};

function confirmationOptionalCheckboxes(array, name, className) {
    if ($(`.${className} input:checkbox:checked`).length != 0) {
        let subArray = {};
        let i = 0;
        $(`.${className} input:checkbox:checked`).each(function () {
            const oneValue = $(this).siblings().eq(0).text();
            subArray[i] = oneValue;
            i++;
        });
        array[name] = subArray
    };
}

function confirmationOneIngredient(array, errors) {
    if ($(".oneIngredient input:checkbox:checked").length == 0) {
        errors.push("geen ingredient geselecteerd");
    } else {
        let ingr = {};
        let i = 0;
        $(".oneIngredient input:checkbox:checked").each(function () {
            if (!$(this).siblings().children('input').val()) {
                errors.push(`geen hoeveelheid ingevuld voor ${$(this).siblings().eq(1).text()}`);
            } else {
                const oneIngredient = {};
                oneIngredient["quantity"] = $(this).siblings().children('input').val();

                oneIngredient["name"] = $(this).siblings().eq(1).text();
                ingr[i] = oneIngredient;
                i++;
            }
        });
        array["ingredients"] = ingr
    };
}