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
