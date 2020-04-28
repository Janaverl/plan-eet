function setRequestOptions(data, method) {
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

    return requestOptions;
}

function isResponseOk(responseOk) {
    if(!responseOk){
        return false;
    }
    return true;
}

function appendErrormessage(errormessage) {
    $(".errors").append(`<li>${errormessage}</li>`)
}

function appendErrors(errors) {
    errors.forEach(errormessage =>
        appendErrormessage(errormessage)
    );
}

function appendSuccess(name, slug) {
    $(".success").append(`<li>${name} werd succesvol ${slug}.</li>`);
}

function clearFormFields() {
    $('.w3-check').prop('checked', false);
    $('input').val('');
    $('textarea').val('');
    $('select').val("default");
    $('.unit').attr('disabled', true);
    $('.time').attr('disabled', true);
}

function createErrorMessage(error, name) {
    switch(error.type) {
        case "must_be_unique_value":
            return `${name} bestaat reeds.`
        case "cannot_be_null":
            return 'Vul alle verplichte velden in.'
        case "unauthorized_user":
            return 'Je hebt niet de rechten om deze actie te doen.'
        default:
            return `Er liep iets mis. error ${error.status} ::: ${error.title}`
      }
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
        appendErrors(errors);
        return;
    }

    const requestOptions = setRequestOptions(data, method);

    let hasExceptions;

    fetch(route, requestOptions)
    .then(response => {
        hasExceptions = !isResponseOk(response.ok);
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
            appendSuccess(data["name"], slug);
            if (clearfields) {
                clearFormFields()
            }
        } else {
            window.location.href = redirect;
        }
        return result;
    })
    .catch(error => {
        const errormsg = createErrorMessage(error, data["name"]);
        appendErrormessage(errormsg);
    });
}