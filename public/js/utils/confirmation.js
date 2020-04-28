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
