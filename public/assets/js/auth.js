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

const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

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
        $(".pwdField")
            .find(".invalid-feedback")
            .html("Passwords do not match.");
        $(".pwdField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    return noErrorFound;
}
