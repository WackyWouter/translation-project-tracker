function changePassword() {
    let data = $("#changePwForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".main-error").html("");

    if (validatePasswords()) {
        $.ajax({
            type: "POST",
            url: "/account/savePassword",
            data: data,
            dataType: "JSON",
            success: function (data) {
                if (data.status == "ok") {
                    window.location.href = "/account/profile";
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

function validatePasswords() {
    let noErrorFound = true;
    const password = $("#password").val();
    const confPassword = $("#confPassword").val();
    const oldPassword = $("#oldPassword").val();

    // Check if password passes the strength requirements
    if (
        password.length < 8 ||
        !/[0-9]+/.test(password) ||
        !/[a-zA-Z]+/.test(password)
    ) {
        $(".passwordField")
            .find(".invalid-feedback")
            .html("Password is not strong enough.");
        $(".passwordField").find("input").addClass("is-invalid");
        noErrorFound = false;
    } else if (password !== confPassword) {
        $(".confPasswordField")
            .find(".invalid-feedback")
            .html("Passwords do not match.");
        $(".confPasswordField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    if (oldPassword.length == 0) {
        $(".oldPasswordField")
            .find(".invalid-feedback")
            .html("Old password can not be empty.");
        $(".oldPasswordField").find("input").addClass("is-invalid");
        noErrorFound = false;
    }

    return noErrorFound;
}

function saveAccount() {
    let data = $("#editAccountForm").serializeArray();

    // Empty old errors
    $(".form-control").removeClass("is-invalid");
    $(".invalid-feedback").html("");
    $(".main-error").html("");

    // if (validatePasswords()) {
    $.ajax({
        type: "POST",
        url: "/account/save",
        data: data,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                window.location.href = "/account/profile";
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
    // }
}

function validateAccount() {
    let noErrorFound = true;
    const username = $("#username").val();
    const email = $("#email").val();

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

    return noErrorFound;
}
