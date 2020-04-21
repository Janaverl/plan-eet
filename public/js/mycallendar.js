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

    fetch(`/api/camps/show/${slug}?camp=${camp}`, requestOptions)
        .then(response => response.json())
        .then(result => {
            makecallendar(result);
            document.getElementById("loader").style.display = "none";
        })
        .catch(error => console.log("error", error));

    function makecallendar(data) {
        const mealHours = data.mealhours;
        const start = data.start;
        const end = data.end;
        const breakfastHour = '08:00'
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            events: `/fetch/show/meals/${slug}?camp=${camp}`,
            // TODO: keep the loader untill all events are fetched
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
            eventDrop: (info) => {
                if(Date.parse(info.event.extendedProps.currentEventStart) == Date.parse(info.event.start)){
                    info.event.setExtendedProp("changed", false);
                    return;
                }

                info.event.setExtendedProp("changed", true);

                if(info.event.extendedProps.hasMeal){
                    $("#change").prop("disabled", false);
                }
            },
            eventOverlap: true, // makes it possible to overlap events during the planning process
            businessHours: mealHours,
            eventConstraint: 'businessHours',
            displayEventTime: false,
        });

        calendar.render();

        $("#change").on("click", (e) => {
            e.preventDefault();
    
            var allEvents = calendar.getEvents().map((event) => {
                console.log("start :::" + event.start);
                return event.start;
            });
    
            if (hasDuplicates(allEvents)) {
                window.alert("Helaas, er zijn dagen waarop meerdere maaltijden zijn gepland. Pas dit eerst aan vooraleer je de wijzigingen kan opslaan.");
                return;
            }
            window.alert("all set to change. TODO");
            // var checkedEvents = calendar.getEvents().map((event) => {
            //     if(event.extendedProps.changed){
            //         console.log(event.url);
            //     }
            // });

                // TODO: save the changes
        });
    }
});