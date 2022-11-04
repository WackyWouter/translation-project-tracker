(function ($) {
    "use strict";
    $(function () {
        $("#logout").click(function () {
            window.location.href = "/logout";
        });

        const date = new Date(Date.parse($("#oldDate").val()));

        if ($("#datepicker-popup").length) {
            $("#datepicker-popup").datepicker({
                autoclose: true,
                todayHighlight: true,
                todayBtn: true,
            });
            $("#datepicker-popup").datepicker("update", date);
        }

        $("#uncompletedProjects").DataTable({
            aLengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, "All"],
            ],
            iDisplayLength: 10,
            language: {
                search: "",
                emptyTable: "No uncompleted projects found.",
            },
        });
        $("#uncompletedProjects").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_filter] input");
            search_input.attr("placeholder", "Search");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });

        $("#completedProjects").DataTable({
            aLengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, "All"],
            ],
            iDisplayLength: 10,
            language: {
                search: "",
                emptyTable: "No completed projects found.",
            },
        });
        $("#completedProjects").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_filter] input");
            search_input.attr("placeholder", "Search");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });

        $("#projects").DataTable({
            aLengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, "All"],
            ],
            iDisplayLength: 10,
            language: {
                search: "",
                emptyTable: "No projects found.",
            },
        });
        $("#projects").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_filter] input");
            search_input.attr("placeholder", "Search");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });
    });
})(jQuery);
