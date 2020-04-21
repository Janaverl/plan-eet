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
        confirmationOptionalCheckboxesWithChildinput(camp, errors, "onemealmoment", "mealmoments", "mealmoment", "time", "geen tijdstip ingevuld")

        if ($("input#startdate").val() > $("input#enddate").val()) {
            errors.push("de einddatum moet na de begindatum komen.")
        };

        let $minutes;
        $(`input.time`).each(function () {
            if ($(this).val()) {
                $minutes = $(this).val().split(":")[1]
                if ($minutes != "00" && $minutes != "30") {
                    errors.push("het eetuur moet op het gehele uur, of op het halve uur plaatsvinden (vb: 12u00 kan, 12u15 niet, 12u30 wel)")
                }
            }
        });

        postdata(camp, errors, '/api/camps/store', 'toegevoegd', true);
    });
});