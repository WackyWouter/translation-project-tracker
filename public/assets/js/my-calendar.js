function deleteCalendar(calendarId) {
    var csrfName = $(".txt_csrfname").attr("name"); // CSRF Token name
    var csrfHash = $(".txt_csrfname").val(); // CSRF hash
    alertify.confirm(
        "You will be deleting all the events associated with this calendar. Are you sure you want to continue?",
        function () {
            jQuery.ajax({
                type: "POST",
                url: "/myCalendars/deleteCalendar",
                data: { calendarId: calendarId, [csrfName]: csrfHash },
                dataType: "JSON",
                success: function (data) {
                    if (data.status == "ok") {
                        window.location.reload();
                    } else {
                        if (data.hasOwnProperty("error")) {
                            alertify.alert(data.error);
                        } else {
                            alertify.alert(
                                "Something has gone wrong. Please try again later."
                            );
                        }
                    }
                },
                error: function (data) {
                    alertify.alert(
                        "Something has gone wrong. Please try again later."
                    );
                },
            });
        },
        function () {}
    );
}
