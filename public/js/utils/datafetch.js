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

    return requestOptions;
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
};

async function fetchDataToJson(requestOptions, route) {

    let response = await fetch(route, requestOptions);
    let result = await response.json();

    if (!response.ok) {
        return Promise.reject({
            status: result.status,
            type: result.type,
            title: result.title
        })
    }
    
    return result;
}

export default {
    handleRequest(data, errors, route, slug, method, clearfields, redirect = "") {

        if (errors.length > 0) {
            appendErrors(errors);
            return;
        }

        const requestOptions = setRequestOptions(data, method);
        
        fetchDataToJson(requestOptions, route)
        .then( () => {
            if (redirect === "") {
                appendSuccess(data["name"], slug);
                if (clearfields) {
                    clearFormFields()
                }
            } else {
                window.location.href = redirect;
            }
        })
        .catch(err => {
            const errormsg = createErrorMessage(err, data["name"]);
            appendErrormessage(errormsg);
        })
    }
};