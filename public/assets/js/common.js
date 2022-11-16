(function ($) {
    "use strict";
    $(function () {
        $("#logout").click(function () {
            window.location.href = "/logout";
        });

        //checkbox and radios
        $(".form-check label,.form-radio label").append(
            '<i class="input-helper"></i>'
        );

        //fullscreen
        $("#fullscreen-button").on("click", function toggleFullScreen() {
            if (
                (document.fullScreenElement !== undefined &&
                    document.fullScreenElement === null) ||
                (document.msFullscreenElement !== undefined &&
                    document.msFullscreenElement === null) ||
                (document.mozFullScreen !== undefined &&
                    !document.mozFullScreen) ||
                (document.webkitIsFullScreen !== undefined &&
                    !document.webkitIsFullScreen)
            ) {
                if (document.documentElement.requestFullScreen) {
                    document.documentElement.requestFullScreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullScreen) {
                    document.documentElement.webkitRequestFullScreen(
                        Element.ALLOW_KEYBOARD_INPUT
                    );
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        });
    });
})(jQuery);

alertify.defaults = {
    // dialogs defaults
    autoReset: true,
    basic: false,
    closable: true,
    closableByDimmer: true,
    invokeOnCloseOff: false,
    frameless: false,
    defaultFocusOff: false,
    maintainFocus: true, // <== global default not per instance, applies to all dialogs
    maximizable: true,
    modal: true,
    movable: true,
    moveBounded: false,
    overflow: true,
    padding: true,
    pinnable: true,
    pinned: true,
    preventBodyShift: false, // <== global default not per instance, applies to all dialogs
    resizable: true,
    startMaximized: false,
    transition: "pulse",
    transitionOff: false,
    tabbable:
        'button:not(:disabled):not(.ajs-reset),[href]:not(:disabled):not(.ajs-reset),input:not(:disabled):not(.ajs-reset),select:not(:disabled):not(.ajs-reset),textarea:not(:disabled):not(.ajs-reset),[tabindex]:not([tabindex^="-"]):not(:disabled):not(.ajs-reset)', // <== global default not per instance, applies to all dialogs

    // notifier defaults
    notifier: {
        // auto-dismiss wait time (in seconds)
        delay: 5,
        // default position
        position: "bottom-right",
        // adds a close button to notifier messages
        closeButton: false,
        // provides the ability to rename notifier classes
        classes: {
            base: "alertify-notifier",
            prefix: "ajs-",
            message: "ajs-message",
            top: "ajs-top",
            right: "ajs-right",
            bottom: "ajs-bottom",
            left: "ajs-left",
            center: "ajs-center",
            visible: "ajs-visible",
            hidden: "ajs-hidden",
            close: "ajs-close",
        },
    },

    // language resources
    glossary: {
        // dialogs default title
        title: "TPT",
        // ok button text
        ok: "Ok",
        // cancel button text
        cancel: "Cancel",
    },

    // theme settings
    theme: {
        // class name attached to prompt dialog input textbox.
        input: "ajs-input",
        // class name attached to ok button
        ok: "ajs-ok",
        // class name attached to cancel button
        cancel: "ajs-cancel",
    },
    // global hooks
    hooks: {
        // invoked before initializing any dialog
        preinit: function (instance) {},
        // invoked after initializing any dialog
        postinit: function (instance) {},
    },
};
function deleteProject(id) {
    alertify.confirm(
        "Are you sure you want to delete this project?",
        function () {
            $.ajax({
                type: "GET",
                url: "/dashboard/deleteProject",
                data: {
                    projectId: id,
                },
                dataType: "JSON",
                success: function (data) {
                    if (data.status == "ok") {
                        window.location.reload();
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
            });
        },
        function () {}
    );
}

function updateStatus(projectUuid, statusId) {
    $.ajax({
        type: "GET",
        url: "/dashboard/updateStatus",
        data: {
            projectUuid: projectUuid,
            statusId: statusId,
        },
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                window.location.reload();
            } else {
                alertify.alert(
                    "Something has gone wrong. Please try again later."
                );
            }
        },
        error: function (data) {
            alertify.alert("Something has gone wrong. Please try again later.");
        },
    });
}
