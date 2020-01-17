document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');


    // TODO: this information needs to come from the database

    const allTheMeals = [
        // the meals before start-hour 
        {
            rendering: 'background',
            className: 'fc-nonbusiness',
            start: '2020-01-20T08:00:00',
            end: '2020-01-20T09:00:00'
        },
        {
            title: 'middagmaal met een hele lange titel',
            start: '2020-01-20T12:00:00',
            end: '2020-01-20T13:00:00',
        },
        {
            title: 'avondmaal',
            start: '2020-01-20T18:00:00',
            end: '2020-01-20T19:00:00'
        },
        {
            title: 'ontbijt',
            start: '2020-01-21T08:00:00',
            end: '2020-01-21T09:00:00'
        },
        {
            title: 'middagmaal',
            start: '2020-01-21T12:00:00',
            end: '2020-01-21T13:00:00'
        },
        {
            title: 'avondmaal',
            start: '2020-01-21T18:00:00',
            end: '2020-01-21T19:00:00'
        },
        {
            title: 'ontbijt',
            start: '2020-01-22T08:00:00',
            end: '2020-01-22T09:00:00'
        },
        {
            title: 'middagmaal',
            start: '2020-01-22T12:00:00',
            end: '2020-01-22T13:00:00'
        },
        {
            title: 'avondmaal',
            start: '2020-01-22T18:00:00',
            end: '2020-01-22T19:00:00'
        },
        {
            title: 'ontbijt',
            start: '2020-01-23T08:00:00',
            end: '2020-01-23T09:00:00'
        },
        {
            title: 'middagmaal',
            start: '2020-01-23T12:00:00',
            end: '2020-01-23T13:00:00'
        },
        {
            title: 'avondmaal',
            start: '2020-01-23T18:00:00',
            end: '2020-01-23T19:00:00'
        },
        {
            title: 'ontbijt',
            start: '2020-01-24T08:00:00',
            end: '2020-01-24T09:00:00'
        },
        {
            title: 'middagmaal',
            start: '2020-01-24T12:00:00',
            end: '2020-01-24T13:00:00'
        },
        {
            start: '2020-01-24T18:00:00',
            end: '2020-01-24T19:00:00',
            rendering: 'background',
            className: 'fc-nonbusiness'
        },
    ]
    const mealHours = [
        {
            daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
            startTime: '08:00',
            endTime: '9:00'
        },
        {
            daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
            startTime: '12:00',
            endTime: '13:00'
        },
        {
            daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
            startTime: '18:00',
            endTime: '19:00'
        }
    ]

    const start = '2020-01-20';
    const end = '2020-01-25'; // last day will be 2020-01-24
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
        events: allTheMeals,
        displayEventTime: false,
    });

    calendar.render();
});