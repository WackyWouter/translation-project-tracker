$(document).ready(function () {
    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "dd-mm-yyyy",
        weekStart: 1,
    });

    const today = new Date();

    // Populate the date fields if possible
    if ($("#oldStartDate").val().trim().length > 0) {
        const startDate = new Date(Date.parse($("#oldStartDate").val()));
        $("#start-datepicker-popup").datepicker("update", startDate);
    } else {
        $("#start-datepicker-popup").datepicker("update", today);
    }

    if ($("#oldDueDate").val().trim().length > 0) {
        const dueDate = new Date(Date.parse($("#oldDueDate").val()));
        $("#due-datepicker-popup").datepicker("update", dueDate);
    } else {
        $("#due-datepicker-popup").datepicker("update", today);
    }

    if ($("#oldPlannedDate").val().trim().length > 0) {
        const plannedDate = new Date(Date.parse($("#oldPlannedDate").val()));
        $("#planned-datepicker-popup").datepicker("update", plannedDate);
    } else {
        $("#planned-datepicker-popup").datepicker("update", today);
    }

    if ($("#oldStartEvent").val().trim().length > 0) {
        const startEvent = new Date(Date.parse($("#oldStartEvent").val()));
        $("#start-event-datepicker-popup").datepicker("update", startEvent);
    }

    if ($("#oldEndEvent").val().trim().length > 0) {
        const endEvent = new Date(Date.parse($("#oldEndEvent").val()));
        $("#end-event-datepicker-popup").datepicker("update", endEvent);
    }

    $("#allDayCheck").change(function (event) {
        if ($(event.target).prop("checked")) {
            $("#startEventHour").prop("disabled", true);
            $("#startEventMin").prop("disabled", true);
            $("#endEventHour").prop("disabled", true);
            $("#endEventMin").prop("disabled", true);
        } else {
            $("#startEventHour").prop("disabled", false);
            $("#startEventMin").prop("disabled", false);
            $("#endEventHour").prop("disabled", false);
            $("#endEventMin").prop("disabled", false);
        }
    });

    $("#calendarEventCheck").change(function (event) {
        if ($(event.target).prop("checked")) {
            $("#eventCalendarForm").removeClass("d-none");

            // Populate event details only if we do not have an event id
            if ($("#eventId").val().trim().length == 0) {
                $("#eventTitle").val($("#projectTitle").val());
                $("#startEvent").val($("#startDate").val());
                $("#startEventHour").val($("#startHour").val());
                $("#startEventMin").val($("#startMin").val());
                $("#endEvent").val($("#dueDate").val());
                $("#endEventHour").val($("#dueHour").val());
                $("#endEventMin").val($("#dueMin").val());

                var startEvent = $("#startEvent").val().split("-");
                startEvent = new Date(
                    startEvent[2],
                    startEvent[1] - 1,
                    startEvent[0]
                );
                $("#start-event-datepicker-popup").datepicker(
                    "update",
                    startEvent
                );

                var endEvent = $("#endEvent").val().split("-");
                endEvent = new Date(endEvent[2], endEvent[1] - 1, endEvent[0]);
                $("#end-event-datepicker-popup").datepicker("update", endEvent);
            }
        } else {
            $("#eventCalendarForm").addClass("d-none");
        }
    });
});

function saveProject() {
    let data = $("#projectForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".row").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".main-error").html("");

    if (validateProject()) {
        // Check if we need to give event deletion warning
        const calendarEvent = $("#calendarEventCheck").prop("checked");
        const eventId = $("#eventId").val();

        // If calendar event is unchecked but we have an event id give event deletion warning
        if (!calendarEvent && eventId) {
            alertify.confirm(
                "You will be deleting the event associated with this project. Are you sure you want to continue?",
                function () {
                    sendSaveProjectRequest(data);
                },
                function () {}
            );
        } else {
            sendSaveProjectRequest(data);
        }
    }
}

function sendSaveProjectRequest(data) {
    $.ajax({
        type: "POST",
        url: "/dashboard/saveProject",
        data: data,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                // If project is set to completed show alert asking if hours have been logged
                if (data.action == "edit" && $("#status").val() == 4) {
                    alertify.alert(
                        "Make sure you have logged your time for project: <b>" +
                            data.projectName +
                            "</b>",
                        function () {
                            if ($("#prevPage").val() == "dashboard") {
                                window.location.href =
                                    "/dashboard/home?dateInput=" +
                                    $("#dateInput").val();
                            } else {
                                window.location.href = "/dashboard/allProjects";
                            }
                        }
                    );
                } else {
                    if ($("#prevPage").val() == "dashboard") {
                        window.location.href =
                            "/dashboard/home?dateInput=" +
                            $("#dateInput").val();
                    } else {
                        window.location.href = "/dashboard/allProjects";
                    }
                }
            } else {
                Object.keys(data.errors).forEach(function (key) {
                    $(key).find(".invalid-feedback").html(data.errors[key]);
                    $(key).find("input").addClass("is-invalid");
                    $(key).find("select").addClass("is-invalid");
                    $(key).find(".row").addClass("is-invalid");
                });
            }
        },
        error: function (data) {
            $(".main-error").html(
                "Something has gone wrong. Please try again later."
            );
        },
    });
}

function validateProject() {
    let noErrorFound = true;
    const projectTitle = $("#projectTitle").val();
    const sourceLang = $("#sourceLang").val();
    const targetLang = $("#targetLang").val();
    const startDate = $("#startDate").val();
    const dueDate = $("#dueDate").val();
    const wordCount = $("#wordCount").val();
    const plannedDate = $("#plannedDate").val();

    const calendarEvent = $("#calendarEventCheck").prop("checked");

    // Check if title is empty
    if (projectTitle.trim().length == 0) {
        $(".titleField")
            .find(".invalid-feedback")
            .html("Title can not be empty.");
        $(".titleField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if source language is empty
    if (sourceLang.trim().length == 0) {
        $(".sourceLangField")
            .find(".invalid-feedback")
            .html("Source Language can not be empty.");
        $(".sourceLangField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if target language is empty
    if (targetLang.trim().length == 0) {
        $(".targetLangField")
            .find(".invalid-feedback")
            .html("Target Language can not be empty.");
        $(".targetLangField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if date is empty and if its the correct format
    if (startDate.trim().length == 0 || !isValidDate(startDate)) {
        $(".startDateField")
            .find(".invalid-feedback")
            .html("Start Date needs to be in dd-mm-yyyy format.");
        $(".startDateField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if date is empty and if its the correct format
    if (dueDate.trim().length == 0 || !isValidDate(dueDate)) {
        $(".dueDateField")
            .find(".invalid-feedback")
            .html("Due Date needs to be in dd-mm-yyyy format.");
        $(".dueDateField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if date is empty and if its the correct format
    if (plannedDate.trim().length == 0 || !isValidDate(plannedDate)) {
        $(".plannedDateField")
            .find(".invalid-feedback")
            .html("Planned Date needs to be in dd-mm-yyyy format.");
        $(".plannedDateField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if wordcount only consists of digits
    if (!/^[0-9]+$/.test(wordCount)) {
        $(".wordCountField")
            .find(".invalid-feedback")
            .html("Word count needs to be a positive number.");
        $(".wordCountField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    if (calendarEvent) {
        const eventTitle = $("#eventTitle").val();
        const startEvent = $("#startEvent").val();
        const endEvent = $("#endEvent").val();
        const eventCalendar = $("#eventCalendar").val();

        // Check if event title is empty
        if (eventTitle.trim().length == 0) {
            $(".eventTitleField")
                .find(".invalid-feedback")
                .html("Event Title can not be empty.");
            $(".eventTitleField").find("input").addClass("is-invalid");
            noErrorFound = false;
        }

        // Check if date is empty and if its the correct format
        if (startEvent.trim().length == 0 || !isValidDate(startEvent)) {
            $(".startEventField")
                .find(".invalid-feedback")
                .html("Start Event needs to be in dd-mm-yyyy format.");
            $(".startEventField").find("input").addClass("is-invalid");
            noErrorFound = false;
        }

        // Check if date is empty and if its the correct format
        if (endEvent.trim().length == 0 || !isValidDate(endEvent)) {
            $(".endEventField")
                .find(".invalid-feedback")
                .html("End Event needs to be in dd-mm-yyyy format.");
            $(".endEventField").find("input").addClass("is-invalid");
            noErrorFound = false;
        }

        if (!eventCalendar) {
            $(".eventCalendarField")
                .find(".invalid-feedback")
                .html("A calendar needs to be selected.");
            $(".eventCalendarField").find("input").addClass("is-invalid");
            noErrorFound = false;
        }
    }

    return noErrorFound;
}

function isValidDate(dateString) {
    // First check for the pattern
    if (!/^\d{1,2}\-\d{1,2}\-\d{4}$/.test(dateString)) return false;

    // Parse the date parts to integers
    var parts = dateString.split("-");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if (year < 1000 || year > 3000 || month == 0 || month > 12) return false;

    var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    // Adjust for leap years
    if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
}
