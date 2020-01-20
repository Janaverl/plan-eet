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
                right: 'prev,next today', //positions the the prev/next button on the right 
                center: 'title', //sets the title of the month to center
                left: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            height: 500,
            validRange: {
                start: start,
                end: end
            },
            nowIndicator: true,
            defaultView: 'timeGridWeek',
            // minTime: '06:00',
            // maxTime: '22:00',
            scrollTime: breakfastHour,
            firstDay: 0,
            navLinks: true, // click on day/week names to navigate views
            editable: true,
            slotDuration: '01:00',
            eventOverlap: true, // makes it possible to overlap events during the planning process
            // TODO: get businessdates from mealmoments
            businessHours: mealHours,
            eventConstraint: 'businessHours',
            events: allthemeals,
            displayEventTime: false,
        });

        calendar.render();
    }
});