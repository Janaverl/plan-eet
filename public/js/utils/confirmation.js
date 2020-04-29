function checkChildInput(errors, classname, name, nameChild, errormsgChild) {
    let errorArray = {};
    let i = 0;
    $(`.${classname} input:checkbox:checked`).each(function () {
        const value = $(this).val();
        if (!$(`input[name="${nameChild}-${value}"]`).val()) {
            errors.push(`${errormsgChild} voor ${$(`label[for="${value}"]`).text()}`);
        } else {
            const oneValue = {};
            oneValue[name] = $(`label[for="${value}"]`).text();
            oneValue[nameChild] = $(`input[name="${nameChild}-${value}"]`).val();
            errorArray[i] = oneValue;
            i++;
        }
    });

    return errorArray;
}

export default {

    requiredInputField(array, errors, id, errormsg) {
        if (!$(`input#${id}`).val()) {
            errors.push(errormsg)
        } else {
            array[`${id}`] = $(`input#${id}`).val();
        };
    },

    requiredSelect(array, errors, name, nameInString, errormsg) {
        if (name.value == "default") {
            errors.push(errormsg);
        } else {
            array[nameInString] = name.value;
        };
    },

    requiredTextarea(array, errors, id, errormsg) {
        if (!$('textarea').val()) {
            errors.push(errormsg)
        } else {
            array[`${id}`] = $("textarea").val();
        };
    },

    optionalInputField(array, id) {
        if ($(`input#${id}`).val()) {
            array[`${id}`] = $(`input#${id}`).val();
        };
    },

    optionalCheckboxes(array, name, className) {
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
    },

    requiredCheckboxes(array, errors, className, name) {
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
    },

    requiredCheckboxesWithChildinput(array, errors, classname, groupname, name, nameChild, errormsg, errormsgChild) {
        if ($(`.${classname} input:checkbox:checked`).length == 0) {
            errors.push(errormsg);
        } else {
            array[groupname] = checkChildInput(errors, classname, name, nameChild, errormsgChild);
        };
    },

    optionalCheckboxesWithChildinput(array, errors, classname, groupname, name, nameChild, errormsgChild) {
        if ($(`.${classname} input:checkbox:checked`).length != 0) {
            array[groupname] = checkChildInput(errors, classname, name, nameChild, errormsgChild);
        };
    },
};
