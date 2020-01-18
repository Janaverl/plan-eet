$(document).ready(function () {

    $("#startdate").on("change", function (e) {
        $("#enddate").prop('min', $("#startdate").val());
        // console.log($("#enddate").val());
    });

    $("#enddate").on("change", function (e) {
        $("#startdate").prop('max', $("#enddate").val());
        // console.log($("#startdate").val());
    });

    enableChildInputfields("mealmoments", "time");

    $(".confirm").on("click", function (e) {
        console.log($("#startdate").val());
        $(".errors").empty();
        let errors = [];
        let camp = {};
        e.preventDefault();

        // confirmation and saving te values
        confirmationRequiredInputField(camp, errors, "name", "geen naam ingevuld");
        confirmationRequiredInputField(camp, errors, "nrOfParticipants", "geen aantal deelnemers ingevuld");
        confirmationRequiredInputField(camp, errors, "startdate", "geen begindatum ingevuld");
        confirmationRequiredInputField(camp, errors, "starttime", "geen beginuur ingevuld");
        confirmationRequiredInputField(camp, errors, "enddate", "geen einddatum ingevuld");
        confirmationRequiredInputField(camp, errors, "endtime", "geen einduur ingevuld");
        confirmationOptionalCheckboxesWithChildinput(camp, errors, "onemealmoment", "mealmoment", "time", "geen tijdstip ingevuld")

        if ($("input#startdate").val() > $("input#enddate").val()) {
            errors.push("de einddatum moet na de begindatum komen.")
        };

        postdata(camp, errors, '/fetch/add/camp', 'toegevoegd', true);
    });
});