$(document).ready(function () {
    $(".last-login-input").on("keydown", function search(e) {
        if (e.keyCode == 13) {
            login();
        }
    });

    $(".last-register-input").on("keydown", function search(e) {
        if (e.keyCode == 13) {
            createNewUser();
        }
    });

    $(".last-new-pw-input").on("keydown", function search(e) {
        if (e.keyCode == 13) {
            updatePassword();
        }
    });

    $(".last-reset-pw-input").on("keydown", function search(e) {
        if (e.keyCode == 13) {
            resetPassword();
        }
    });
});

function login() {
    let data = $("#loginForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".invalid-feedback").html("");

    $.ajax({
        type: "POST",
        url: "/login",
        data: data,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                window.location.href = "/dashboard/home";
            } else {
                Object.keys(data.errors).forEach(function (key) {
                    $(key).find(".invalid-feedback").html(data.errors[key]);
                    $(key).find("input").addClass("is-invalid");
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

function createNewUser() {
    let data = $("#registerForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".main-error").html("");

    if (validateNewUser()) {
        $.ajax({
            type: "POST",
            url: "/register/newUser",
            data: data,
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    window.location.href = "/dashboard/home";
                } else {
                    Object.keys(data.errors).forEach(function (key) {
                        $(key).find(".invalid-feedback").html(data.errors[key]);
                        $(key).find("input").addClass("is-invalid");
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
function validateNewUser() {
    let noErrorFound = true;
    const username = $("#username").val();
    const email = $("#email").val();
    const password = $("#password").val();
    const passwordConf = $("#passwordConfirm").val();

    // Check if username is valid
    if (!/^[a-zA-Z0-9]{5,}$/.test(username)) {
        $(".usernameField")
            .find(".invalid-feedback")
            .html("Please enter a valid username.");
        $(".usernameField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if email is valid
    if (!validateEmail(email)) {
        $(".emailField")
            .find(".invalid-feedback")
            .html("Please enter a valid email.");
        $(".emailField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    // Check if password passes the strength requirements
    if (
        password.length < 8 ||
        !/[0-9]+/.test(password) ||
        !/[a-zA-Z]+/.test(password)
    ) {
        $(".pwdField")
            .find(".invalid-feedback")
            .html("Password is not strong enough.");
        $(".pwdField").find("input").addClass("is-invalid");
        noErrorFound = false;
    } else if (password !== passwordConf) {
        $(".confPwdField")
            .find(".invalid-feedback")
            .html("Passwords do not match.");
        $(".confPwdField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    return noErrorFound;
}

function resetPassword() {
    let data = $("#forgotPwForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".main-error").html("");
    $(".message").html("");

    if (validateResetPassword()) {
        $.ajax({
            type: "POST",
            url: "/resetPw/save",
            data: data,
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    $(".message").html("<b>Email send.</b>");
                } else {
                    Object.keys(data.errors).forEach(function (key) {
                        $(key).find(".invalid-feedback").html(data.errors[key]);
                        $(key).find("input").addClass("is-invalid");
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

function validateResetPassword() {
    let noErrorFound = true;
    const email = $("#email").val();

    // Check if email is valid
    if (!validateEmail(email)) {
        $(".emailField")
            .find(".invalid-feedback")
            .html("Please enter a valid email.");
        $(".emailField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    return noErrorFound;
}

function updatePassword() {
    let data = $("#resetPWForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".main-error").html("");

    if (validateUpdatePassword()) {
        $.ajax({
            type: "POST",
            url: "/resetPw/saveNewPassword",
            data: data,
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    window.location.href = "/";
                } else {
                    Object.keys(data.errors).forEach(function (key) {
                        $(key).find(".invalid-feedback").html(data.errors[key]);
                        $(key).find("input").addClass("is-invalid");
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

function validateUpdatePassword() {
    let noErrorFound = true;
    const password = $("#password").val();
    const passwordConf = $("#passwordConfirm").val();

    // Check if password passes the strength requirements
    if (
        password.length < 8 ||
        !/[0-9]+/.test(password) ||
        !/[a-zA-Z]+/.test(password)
    ) {
        $(".pwdField")
            .find(".invalid-feedback")
            .html("Password is not strong enough.");
        $(".pwdField").find("input").addClass("is-invalid");
        noErrorFound = false;
    } else if (password !== passwordConf) {
        $(".confPwdField")
            .find(".invalid-feedback")
            .html("Passwords do not match.");
        $(".confPwdField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    return noErrorFound;
}
