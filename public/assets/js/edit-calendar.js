$(document).ready(function () {
    Coloris({
        themeMode: "dark",
        alpha: false,
        // theme: "default",
        theme: "large",
        // theme: "polaroid",
        // theme: "pill",
    });
});

function setSuggestedColour(
    textColor,
    backgroundColor,
    dragBgColor,
    borderColor
) {
    $("#calendarColor").val(textColor);
    $("#calendarBgColor").val(backgroundColor);
    $("#calendarDragBgColor").val(dragBgColor);
    $("#calendarBorderColor").val(borderColor);

    document
        .querySelector("#calendarColor")
        .dispatchEvent(new Event("input", { bubbles: true }));
    document
        .querySelector("#calendarBgColor")
        .dispatchEvent(new Event("input", { bubbles: true }));
    document
        .querySelector("#calendarDragBgColor")
        .dispatchEvent(new Event("input", { bubbles: true }));
    document
        .querySelector("#calendarBorderColor")
        .dispatchEvent(new Event("input", { bubbles: true }));
}

function setPresetTitle(event) {
    const title = $(event.target).val();
    if (title.length > 0) {
        $(".suggestedColour").html($(event.target).val());
    } else {
        $(".suggestedColour").html("Calendar 1");
    }
}

function saveCalendar() {
    let data = $("#calendarForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".row").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".invalid-feedback").removeClass("d-block");
    $(".main-error").html("");

    if (validateCalendar()) {
        $.ajax({
            type: "POST",
            url: "/myCalendars/saveCalendar",
            data: data,
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    window.location.href = "/myCalendars";
                } else {
                    if (data.hasOwnProperty("errors")) {
                        Object.keys(data.errors).forEach(function (key) {
                            $(key)
                                .find(".invalid-feedback")
                                .html(data.errors[key]);
                            $(key)
                                .find(".invalid-feedback")
                                .addClass("d-block");
                            $(key).find("input").addClass("is-invalid");
                            $(key).find("select").addClass("is-invalid");
                            $(key).find(".row").addClass("is-invalid");
                        });
                    } else {
                        $(".main-error").html(
                            "Something has gone wrong. Please try again later."
                        );
                    }
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

function validateCalendar() {
    let noErrorFound = true;
    const calendarTitle = $("#calendarTitle").val();
    const calendarColor = $("#calendarColor").val();
    const calendarBgColor = $("#calendarBgColor").val();
    const calendarDragBgColor = $("#calendarDragBgColor").val();
    const calendarBorderColor = $("#calendarBorderColor").val();

    // Check if title is empty
    if (calendarTitle.trim().length == 0) {
        $(".titleField")
            .find(".invalid-feedback")
            .html("Title can not be empty.");
        $(".titleField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if text color is empty and if it is valid hex code
    if (calendarColor.trim().length == 0) {
        $(".colorField")
            .find(".invalid-feedback")
            .html("Text Colour can not be empty.");
        $(".colorField").find(".invalid-feedback").addClass("d-block");
        $(".colorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    } else if (
        Array.from(calendarColor)[0] != "#" ||
        calendarColor.length != 7
    ) {
        $(".colorField")
            .find(".invalid-feedback")
            .html("Invalid colour code. Hex code should be in format #FFFFFF");
        $(".colorField").find(".invalid-feedback").addClass("d-block");
        $(".colorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if background color is empty and if it is valid hex code
    if (calendarBgColor.trim().length == 0) {
        $(".bgColorField")
            .find(".invalid-feedback")
            .html("Background Colour can not be empty.");
        $(".bgColorField").find(".invalid-feedback").addClass("d-block");
        $(".bgColorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    } else if (
        Array.from(calendarBgColor)[0] != "#" ||
        calendarBgColor.length != 7
    ) {
        $(".bgColorField")
            .find(".invalid-feedback")
            .html("Invalid colour code. Hex code should be in format #FFFFFF");
        $(".bgColorField").find(".invalid-feedback").addClass("d-block");
        $(".bgColorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if drag background color is empty and if it is valid hex code
    if (calendarDragBgColor.trim().length == 0) {
        $(".dragBgColorField")
            .find(".invalid-feedback")
            .html("Drag Background Colour can not be empty.");
        $(".dragBgColorField").find(".invalid-feedback").addClass("d-block");
        $(".dragBgColorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    } else if (
        Array.from(calendarDragBgColor)[0] != "#" ||
        calendarDragBgColor.length != 7
    ) {
        $(".dragBgColorField")
            .find(".invalid-feedback")
            .html("Invalid colour code. Hex code should be in format #FFFFFF");
        $(".dragBgColorField").find(".invalid-feedback").addClass("d-block");
        $(".dragBgColorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if border color is empty and if it is valid hex code
    if (calendarBorderColor.trim().length == 0) {
        $(".borderColorField")
            .find(".invalid-feedback")
            .html("Border Colour can not be empty.");
        $(".borderColorField").find(".invalid-feedback").addClass("d-block");
        $(".borderColorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    } else if (
        Array.from(calendarBorderColor)[0] != "#" ||
        calendarBorderColor.length != 7
    ) {
        $(".borderColorField")
            .find(".invalid-feedback")
            .html("Invalid colour code. Hex code should be in format #FFFFFF");
        $(".borderColorField").find(".invalid-feedback").addClass("d-block");
        $(".borderColorField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    return noErrorFound;
}
