$(document).ready(function () {
    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        todayBtn: true,
        format: "dd-mm-yyyy",
    });

    // Populate the date fields if possible
    if ($("#oldStartDate").val().trim().length > 0) {
        const startDate = new Date(Date.parse($("#oldStartDate").val()));
        $("#start-datepicker-popup").datepicker("update", startDate);
    }

    if ($("#oldDueDate").val().trim().length > 0) {
        const dueDate = new Date(Date.parse($("#oldDueDate").val()));
        $("#due-datepicker-popup").datepicker("update", dueDate);
    }

    if ($("#oldPlannedDate").val().trim().length > 0) {
        const plannedDate = new Date(Date.parse($("#oldPlannedDate").val()));
        $("#planned-datepicker-popup").datepicker("update", plannedDate);
    }
});

function saveProject() {
    let data = $("#projectForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".datepicker").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".main-error").html("");

    if (validateProject()) {
        $.ajax({
            type: "POST",
            url: "/dashboard/saveProject",
            data: data,
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    if ($("#prevPage").val() == "dashboard") {
                        window.location.href =
                            "/dashboard/home?dateInput=" +
                            $("#dateInput").val();
                    } else {
                        window.location.href = "/dashboard/allProjects";
                    }
                } else {
                    Object.keys(data.errors).forEach(function (key) {
                        $(key).find(".invalid-feedback").html(data.errors[key]);
                        $(key).find("input").addClass("is-invalid");
                        $(key).find(".datepicker").addClass("is-invalid");
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
