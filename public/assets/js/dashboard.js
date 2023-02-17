(function ($) {
    "use strict";
    $(function () {
        $(".todoCheckbox").change(updateTodoStatus);

        const date = new Date(Date.parse($("#oldDate").val()));

        if ($("#datepicker-popup").length) {
            $("#datepicker-popup").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "dd-mm-yyyy",
                weekStart: 1,
            });
            $("#datepicker-popup").datepicker("update", date);
        }

        $.fn.dataTable.moment("DD-MM-YYYY");
        $.fn.dataTable.moment("DD-MM-YYYY HH:mm");

        $("#uncompletedProjects").DataTable({
            aLengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, "All"],
            ],
            iDisplayLength: 10,
            ordering: true,
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
            ordering: true,
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
    });
})(jQuery);

function moveOneDay(direction) {
    const date = new Date(Date.parse($("#oldDate").val()));
    let newDate;

    if (direction == "forward") {
        newDate = new Date(date.getTime() + 86400000); // +1 day
    } else {
        newDate = new Date(date.getTime() - 86400000); // -1 day
    }

    $("#datepicker-popup").datepicker("update", newDate);
    $("#dateForm").submit();
}

function deleteTodoItem(uuid, index) {
    $.ajax({
        type: "GET",
        url: "/dashboard/deleteTodoItem",
        data: {
            uuid: uuid,
        },
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                $("#todoListItem" + index).remove();
            } else {
                alertify.alert(
                    "Something has gone wrong. Please try again later.",
                    function () {
                        window.location.reload();
                    }
                );
            }
        },
        error: function (data) {
            alertify.alert(
                "Something has gone wrong. Please try again later.",
                function () {
                    window.location.reload();
                }
            );
        },
    });
}

function addTodoItem() {
    const index = $("#newItemCounter").val();
    let listItem =
        "<div class='d-flex flex-center' id='newTodoListItem" + index + "'>";
    listItem += "<div class='form-group no-mb'>";
    listItem +=
        "<input type='text' maxlength='255' class='newTodoItemName form-control'>";
    listItem += "</div>";
    listItem +=
        "<div class='d-flex flex-gap-20'><i class='mdi mdi-check todo-icon text-success' onclick='saveNewTodoItem(\"" +
        index +
        "\")'></i>";
    listItem +=
        "<i class='mdi mdi-close todo-icon text-danger' onclick='deleteNewTodoItem(\"" +
        index +
        "\")'></i></div>";
    listItem += "</div>";

    // Update List
    $("#todoList").append(listItem);

    // Update counter
    $("#newItemCounter").val(parseInt($("#newItemCounter").val()) + 1);
}

function deleteNewTodoItem(index) {
    $("#newTodoListItem" + index).remove();
}

function saveNewTodoItem(index) {
    const name = $("#newTodoListItem" + index)
        .find(".newTodoItemName")
        .val();
    const date = $("#oldDate").val();

    if (!name.trim()) {
        alertify.alert("Please enter text in the todo item before saving.");
        return false;
    }

    $.ajax({
        type: "GET",
        url: "/dashboard/saveNewTodoItem",
        data: {
            name: name,
            date: date,
        },
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                // Get and update counter
                const todoListIndex = $("#itemCounter").val();
                $("#itemCounter").val(parseInt($("#itemCounter").val()) + 1);

                // Create list item
                let todoListItem =
                    "<div class='d-flex flex-center' id='todoListItem" +
                    todoListIndex +
                    "'>";
                todoListItem +=
                    "<div class='form-check form-check-flat form-check-primary todoListDiv'>";
                todoListItem +=
                    "<input type='hidden' class='todoItemUuid' value='" +
                    data.uuid +
                    "'>";
                todoListItem += "<label class='form-check-label text-white'>";
                todoListItem +=
                    "<input type='checkbox' class='form-check-input todoCheckbox'>" +
                    name;
                todoListItem += "<i class='input-helper'></i>";
                todoListItem += "</label>";
                todoListItem += "</div>";
                todoListItem +=
                    "<i class='mdi mdi-close todo-icon text-danger' onclick='deleteTodoItem(\"" +
                    data.uuid +
                    '", ' +
                    todoListIndex +
                    ")'></i>";
                todoListItem += "</div>";

                // Update List
                $("#todoList").append(todoListItem);

                // Remove old item
                deleteNewTodoItem(index);

                // Add onchange listener
                $(".todoCheckbox").change(updateTodoStatus);
            } else {
                alertify.alert(
                    "Something has gone wrong. Please try again later.",
                    function () {
                        window.location.reload();
                    }
                );
            }
        },
        error: function (data) {
            alertify.alert(
                "Something has gone wrong. Please try again later.",
                function () {
                    window.location.reload();
                }
            );
        },
    });
}

function updateTodoStatus() {
    if (this.checked) {
        $(this).parent().removeClass("text-white");
        $(this).parent().addClass("todo-done");
    } else {
        $(this).parent().addClass("text-white");
        $(this).parent().removeClass("todo-done");
    }

    $.ajax({
        type: "GET",
        url: "/dashboard/updateTODOStatus",
        data: {
            uuid: $(this).parent().parent().find(".todoItemUuid").val(),
            done: this.checked ? 1 : 0,
        },
        dataType: "JSON",
        success: function (data) {
            if (data.status != "ok") {
                alertify.alert(
                    "Something has gone wrong. Please try again later.",
                    function () {
                        window.location.reload();
                    }
                );
            }
        },
        error: function (data) {
            alertify.alert(
                "Something has gone wrong. Please try again later.",
                function () {
                    window.location.reload();
                }
            );
        },
    });
}
