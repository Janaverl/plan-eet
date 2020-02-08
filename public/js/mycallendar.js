document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    // Get all the data from the database
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    var requestOptions = {
        method: "GET",
        headers: myHeaders,
        redirect: "follow"
    };

    fetch(`/fetch/update/camp/${slug}?camp=${camp}`, requestOptions)
        .then(response => response.json())
        .then(result => {
            data = JSON.parse(result);
            console.log(data);
            makecallendar(data);
            document.getElementById("loader").style.display = "none";
            // $("#change").prop("disabled", false);
        })
        .catch(error => console.log("error", error));

    function makecallendar(data) {
        const mealHours = data.mealhours;
        const start = data.start;
        const end = data.end;
        const allthemeals = data.allthemeals;
        const breakfastHour = '08:00'
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            footer: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'today',
                right: 'prev,next' //positions the the prev/next button on the right 
            },
            height: 600,
            validRange: {
                start: start,
                end: end
            },
            nowIndicator: true,
            defaultView: 'dayGridMonth',
            // minTime: '06:00',
            // maxTime: '22:00',
            scrollTime: breakfastHour,
            firstDay: 0,
            navLinks: true, // click on day/week names to navigate views
            editable: true,
            slotDuration: '01:00',
            snapDuration: '00:30',
            eventDrop: function (info) {
                info.event.setExtendedProp("changed", true);
                $("#change").prop("disabled", false);
                console.log(info.event);
            },
            eventOverlap: true, // makes it possible to overlap events during the planning process
            businessHours: mealHours,
            eventConstraint: 'businessHours',
            events: allthemeals,
            displayEventTime: false,
        });

        calendar.render();

        $("#change").on("click", function (e) {
            e.preventDefault();

            var allEvents = calendar.getEvents().map(function (events) { console.log("start :::" + events.start); return events.start });

            if (hasDuplicates(allEvents)) {
                window.alert("Helaas, er zijn dagen waarop meerdere maaltijden zijn gepland. Versleep dit best eerst vooraleer je de wijzigingen kan opslaan.");
            } else {
                window.alert("all set to change. TODO");
                // TODO: save the changes
            };
        });
    }
});