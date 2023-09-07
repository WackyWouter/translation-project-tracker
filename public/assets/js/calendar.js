$(document).ready(function () {
    const DatePicker = tui.DatePicker;
    const TimePicker = tui.TimePicker;
    const Calendar = tui.Calendar;
    const calendars = JSON.parse($("#calendars").val());
    const events = JSON.parse($("#events").val());
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];

    var csrfName = $(".txt_csrfname").attr("name"); // CSRF Token name
    var csrfHash = $(".txt_csrfname").val(); // CSRF hash

    // Calendar setup
    const calendar = new Calendar("#calendar", {
        taskView: false,
        usageStatistics: false,
        defaultView: "week",
        calendars: calendars,
        template: {
            time(event) {
                if (event.raw.project) {
                    return `<span style="width: 100%;text-wrap: balance;">${event.title} - [${event.raw.project}]</span>`;
                } else {
                    return `<span style="width: 100%;text-wrap: balance;">${event.title}</span>`;
                }
            },
            popupDetailTitle(event) {
                if (event.raw.project) {
                    return `<span>${event.title} - [${event.raw.project}]</span>`;
                } else {
                    return event.title;
                }
            },
            monthGridHeader(model) {
                var day_date = parseInt(model.date.split("-")[2], 10);

                // Show month shorthand if first of the month
                if (day_date == 1) {
                    var month = months[model.month].substring(0, 3);
                    return `<span>${day_date} <span style="font-size: 12px;">${month}</span></span>`;
                } else {
                    return `<span>${day_date}</span>`;
                }
            },
        },
        theme: {
            common: {
                backgroundColor: "white",
                border: "1px solid #e5e5e5",
                gridSelection: {
                    backgroundColor: "rgba(255, 171, 0, 0.05)",
                    border: "1px solid rgb(255, 171, 0)",
                },
                dayName: { color: "#333" },
                holiday: { color: "#333" },
                saturday: { color: "#333" },
                today: { color: "#0d6efd" },
            },
            week: {
                dayName: {
                    borderLeft: "none",
                    borderTop: "1px solid #e5e5e5",
                    borderBottom: "1px solid #e5e5e5",
                    backgroundColor: "inherit",
                },
                dayGrid: {
                    borderRight: "1px solid #e5e5e5",
                    backgroundColor: "inherit",
                },
                dayGridLeft: {
                    borderRight: "1px solid #e5e5e5",
                    backgroundColor: "inherit",
                    width: "72px",
                },
                timeGrid: { borderRight: "1px solid #e5e5e5" },
                timeGridLeft: {
                    backgroundColor: "inherit",
                    borderRight: "1px solid #e5e5e5",
                    width: "72px",
                },
                timeGridLeftAdditionalTimezone: { backgroundColor: "white" },
                // timeGridHalfHourLine: { borderBottom: "1px dotted #e5e5e5" },
                // timeGridHourLine: { borderBottom: "1px solid #e5e5e5" },
                nowIndicatorLabel: { color: "#0d6efd" },
                nowIndicatorPast: { border: "1px dashed #0d6efd" },
                nowIndicatorBullet: { backgroundColor: "#0d6efd" },
                nowIndicatorToday: { border: "1px solid #0d6efd" },
                nowIndicatorFuture: { border: "1px dashed #0d6efd" },
                pastTime: { color: "#bbbbbb" },
                futureTime: { color: "#333333" },
                weekend: { backgroundColor: "inherit" },
                today: {
                    color: "#0d6efd",
                    backgroundColor: "rgba(81, 92, 230, 0.05)",
                },
                pastDay: { color: "#333333" },
                panelResizer: { border: "1px solid #e5e5e5" },
                gridSelection: { color: "rgb(255, 171, 0)" },
            },
            month: {
                dayExceptThisMonth: { color: "rgba(51, 51, 51, 0.4)" },
                dayName: {
                    borderLeft: "none",
                    backgroundColor: "inherit",
                },
                holidayExceptThisMonth: { color: "rgba(255, 64, 64, 0.4)" },
                moreView: {
                    border: "1px solid #d5d5d5",
                    boxShadow: "0 2px 6px 0 rgba(0, 0, 0, 0.1)",
                    backgroundColor: "white",
                    width: null,
                    height: null,
                },
                moreViewTitle: {
                    backgroundColor: "inherit",
                },
                weekend: { backgroundColor: "inherit" },
                gridCell: {
                    headerHeight: 31,
                    footerHeight: null,
                },
            },
        },
    });

    // Set calendar options
    calendar.setOptions({
        week: {
            taskView: false,
            startDayOfWeek: 1,
            hourStart: 7,
            hourEnd: 20,
        },
        useFormPopup: true,
        useDetailPopup: true,
    });

    // Calendar events
    calendar.on("beforeCreateEvent", (eventObj) => {
        // request to create event in db
        jQuery.ajax({
            type: "POST",
            url: "/calendar/createEvent",
            data: { event: JSON.stringify(eventObj), [csrfName]: csrfHash },
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    console.log(eventObj);
                    calendar.createEvents([
                        {
                            ...eventObj,
                            id: data.uuid,
                            attendees: data.attendees,
                        },
                    ]);
                } else {
                    alertify.alert(
                        "Something has gone wrong. Please try again later."
                    );
                }
            },
            error: function (data) {
                alertify.alert(
                    "Something has gone wrong. Please try again later."
                );
            },
            complete: function () {
                calendar.clearGridSelections();
            },
        });
    });

    calendar.on("beforeUpdateEvent", (eventObj) => {
        jQuery.ajax({
            type: "POST",
            url: "/calendar/updateEvent",
            data: {
                id: eventObj.event.id,
                changes: JSON.stringify(eventObj.changes),
                [csrfName]: csrfHash,
            },
            dataType: "JSON",
            success: function (data) {
                calendar.updateEvent(
                    eventObj.event.id,
                    eventObj.event.calendarId,
                    eventObj.changes
                );
            },
            error: function (data) {
                alertify.alert(
                    "Something has gone wrong. Please try again later."
                );
            },
        });
    });

    calendar.on("beforeDeleteEvent", (eventObj) => {
        jQuery.ajax({
            type: "POST",
            url: "/calendar/deleteEvent",
            data: { id: eventObj.id, [csrfName]: csrfHash },
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    calendar.deleteEvent(eventObj.id, eventObj.calendarId);
                } else {
                    alertify.alert(
                        "Something has gone wrong. Please try again later."
                    );
                }
            },
            error: function (data) {
                alertify.alert(
                    "Something has gone wrong. Please try again later."
                );
            },
            complete: function () {
                calendar.clearGridSelections();
            },
        });
    });

    // Loop over all events and convert them to js dates and create the event in the calendar
    events.forEach((event) => {
        event.start = new Date(event.start * 1000);
        event.end = new Date(event.end * 1000);
        calendar.createEvents([event]);
    });

    // Set the month display
    changeMonthName(calendar, months);

    // Click listeners
    $("#today").click(() => calendar.today());
    $("#prev").click(() => calendar.prev());
    $("#next").click(() => calendar.next());
    $("#day").click(() => calendar.changeView("day"));
    $("#week").click(() => calendar.changeView("week"));
    $("#month").click(() => calendar.changeView("month"));
    $(".changeView").click(() => highlightActiveViewBtn(calendar));
    $(".changesCalendar").click(() => {
        isTodayShown(calendar);
        changeMonthName(calendar, months);
    });
});

// Change the button that corresponds to the active view from an outline button to an filled in button
function highlightActiveViewBtn(calendar) {
    $(".changeView").each(function (index, element) {
        if ($(element).attr("id") === calendar.getViewName()) {
            $(element).removeClass("btn-outline-info");
            $(element).addClass("btn-info");
        } else {
            $(element).removeClass("btn-info");
            $(element).addClass("btn-outline-info");
        }
    });
}

function isTodayShown(calendar) {
    const startDate = new Date(calendar.getDateRangeStart());
    const endDate = new Date(calendar.getDateRangeEnd());
    const today = new Date();

    // Check that today is within the range of the start and enddate and change the button to filled if today is shown and outlined if today isnt shown
    if (
        startDate.getTime() <= today.getTime() &&
        endDate.getTime() >= today.getTime()
    ) {
        $("#today").removeClass("btn-outline-warning");
        $("#today").addClass("btn-warning");
    } else {
        $("#today").addClass("btn-outline-warning");
        $("#today").removeClass("btn-warning");
    }
}

function changeMonthName(calendar, months) {
    console.log(calendar.getViewName());
    if (calendar.getViewName() == "week") {
        var start_date = new Date(calendar.getDateRangeStart().d.d);
        var end_date = new Date(calendar.getDateRangeEnd().d.d);

        // Check if start week and end week are in the same year
        if (start_date.getFullYear() != end_date.getFullYear()) {
            // Check if start week and end week are in the same month
            if (start_date.getMonth() != end_date.getMonth()) {
                $("#monthDisplay").html(
                    months[start_date.getMonth()].substring(0, 3) +
                        " " +
                        start_date.getFullYear() +
                        " - " +
                        months[end_date.getMonth()].substring(0, 3) +
                        " " +
                        end_date.getFullYear()
                );
            } else {
                $("#monthDisplay").html(
                    months[start_date.getMonth()] +
                        " " +
                        start_date.getFullYear()
                );
            }

            // Check if start week and end week are in the same month
        } else if (start_date.getMonth() != end_date.getMonth()) {
            $("#monthDisplay").html(
                months[start_date.getMonth()].substring(0, 3) +
                    " - " +
                    months[end_date.getMonth()].substring(0, 3) +
                    " " +
                    start_date.getFullYear()
            );
        } else {
            $("#monthDisplay").html(
                months[start_date.getMonth()] + " " + start_date.getFullYear()
            );
        }
    } else {
        var date = new Date(calendar.getDate().d.d);
        $("#monthDisplay").html(
            months[date.getMonth()] + " " + date.getFullYear()
        );
    }
    // console.log("date", calendar.getDate());
    // console.log("start-date", calendar.getDateRangeStart());
    // console.log("end-date", calendar.getDateRangeEnd());
}
