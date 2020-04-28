function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir; var switchcount = 0;
    table = document.getElementById("tableToSort");
    console.log(table);
    console.log(table.rows);
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        console.log(rows);
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

function confirmationRequiredCheckboxes(array, errors, className, name) {
    if ($(`.${className} input:checkbox:checked`).length == 0) {
        errors.push(`geen ${name} geselecteerd`);
    } else {
        let subArray = {};
        let i = 0;
        $(`.${className} input:checkbox:checked`).each(function () {
            const oneValue = $(this).val();
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

function confirmationOptionalCheckboxesWithChildinput(array, errors, classname, groupname, name, nameChild, errormsgChild) {
    if ($(`.${classname} input:checkbox:checked`).length != 0) {
        let subArray = {};
        let i = 0;
        $(`.${classname} input:checkbox:checked`).each(function () {
            const value = $(this).val();
            if (!$(`input[name="${nameChild}-${value}"]`).val()) {
                errors.push(`${errormsgChild} voor ${$(`label[for="${value}"]`).text()}`);
            } else {
                const oneValue = {};
                oneValue[name] = $(`label[for="${value}"]`).text();
                oneValue[nameChild] = $(`input[name="${nameChild}-${value}"]`).val();
                subArray[i] = oneValue;
                i++;
            }
        });
        array[groupname] = subArray
    };
}

/**
 * 
 * @param {array} data 
 * @param {array} errors 
 * @param {string} route 
 * @param {string} slug 
 * @param {string} method 
 * @param {boolean} clearfields 
 * @param {string} redirect 
 */
function show_error_or_fetch_data(data, errors, route, slug, method, clearfields, redirect = "") {

    if (errors.length > 0) {
        errors.forEach(error =>
            $(".errors").append(`<li>${error}</li>`)
        );
        return;
    }

    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    var raw = JSON.stringify(data);

    var requestOptions = {
        method: method,
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };
    console.log(raw);

    let hasExceptions = false;

    fetch(route, requestOptions)
    .then(response => {
        if(!response.ok){
            hasExceptions = true;
        }
        return response.json()
    })
    .then(result => {
        if(hasExceptions){
            return Promise.reject({
                status: result.status,
                type: result.type,
                title: result.title
                })
        }
        if (redirect == "") {
            $(".success").append(`<li>${data["name"]} werd succesvol ${slug}.</li>`);
            if (clearfields) {
                $('.w3-check').prop('checked', false);
                $('input').val('');
                $('textarea').val('');
                $('select').val("default");
                $('.unit').attr('disabled', true);
                $('.time').attr('disabled', true);
            }
        } else {
            window.location.href = redirect;
        }
        return result;
    })
    .catch(error => {
        let errormsg;
        switch(error.type) {
            case "must_be_unique_value":
                errormsg = `${data["name"]} bestaat reeds.`
                break;
            case "cannot_be_null":
                errormsg = 'Vul alle verplichte velden in.'
                break;
            case "unauthorized_user":
                errormsg = 'Je hebt niet de rechten om deze actie te doen.'
                break;
            default:
                errormsg = `Er liep iets mis. error ${error.status} ::: ${error.title}`
          }
          $(".errors").append(`<li>${errormsg}</li>`);
    });
}

/**
 * returns a boolean
 * @param {array} array 
 */
function hasDuplicates(array) {
    var valuesSoFar = Object.create(null);
    for (var i = 0; i < array.length; ++i) {
        var value = array[i];
        if (value in valuesSoFar) {
            return true;
        }
        valuesSoFar[value] = true;
    }
    return false;
}