$(document).ready(function () {
    const token = $("#token").val();

    // Sign up listener
    $("#signUp").click(function (e) {
        e.preventDefault();

        const type = $("input[name='account-type-radio']:checked").val();
        const email = $("#email").val();
        const password = $("#password").val();
        const confirm = $("#confirm").val();

        if (!validateEmail($.trim(email)) || $.trim(email) == '') {
            danger_snackbar('Enter a valid email address', 5000);
            return false;
        } else if ($.trim(password) != $.trim(confirm)) {
            danger_snackbar('Passwords do not match', 5000);
            return false;
        } else if (type == null) {
            danger_snackbar('Please select a user type!', 5000);
            return false;
        } else {
            var formData = {'type': type, 'email': email, 'password': password, '_token': token};

            $.ajax({
                url: '/register',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
                .done(function (data) {
                    if (data.success == 1) {
                        success_snackbar(data.message, 2000);
                        setTimeout(function () {
                            window.location.href = data.redirect;
                        }, 2000);
                    } else {
                        danger_snackbar(data.message, 8000);
                    }
                })
                .fail(function (data) {
                    var errors = JSON.parse(data.responseText);
                    errors['error'].forEach(element => danger_snackbar('Error - ' + element, 8000));
                });
        }
    });

    // Sign in listener
    $("#signIn").click(function (e) {
        e.preventDefault();

        const email = $("#emailaddress").val();
        const password = $("#password").val();

        var formData = {'email': email, 'password': password, '_token': token};
        $.ajax({
            url: '/login',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
            .done(function (data) {
                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.message, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {

                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
    });

    // Forgot listener
    $("#forgot").click(function (e) {
        e.preventDefault();

        const email = $("#emailaddress").val();

        var formData = {'email': email, '_token': token};
        $.ajax({
            url: '/forgot-password',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
            .done(function (data) {
                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.message, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
    });

    // Onboard a student
    $("#onboardStudent").click(function (e) {
        e.preventDefault();

        const first = $("#first").val();
        const last = $("#last").val();
        const username = $("#username").val();
        const gender = $("#gender").val();
        const dob = $("#dob").val();
        const phone = $("#phone").val();
        const school = $("#school").val();

        var formData = {
            'first': first,
            'last': last,
            'username': username,
            'gender': gender,
            'dob': dob,
            'phone': phone,
            'school': school,
            '_token': token
        };
        $.ajax({
            url: '/onboard/student',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
            .done(function (data) {
                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.message, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
    });

    // Onboard a parent
    $("#onboardParent").click(function (e) {
        e.preventDefault();

        const first = $("#first").val();
        const last = $("#last").val();
        const username = $("#username").val();
        const gender = $("#gender").val();
        const dob = $("#dob").val();
        const phone = $("#phone").val();
        const school = $("#school").val();

        var formData = {
            'first': first,
            'last': last,
            'username': username,
            'gender': gender,
            'dob': dob,
            'phone': phone,
            'school': school,
            '_token': token
        };
        $.ajax({
            url: '/onboard/parent',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
            .done(function (data) {
                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.message, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
    });

    // Solution expert apply
    $("#apply").click(function (e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('application'));

        $("#apply").html("<img src='/img/spinner.gif' height='20' width='20' />");
        $("#apply").attr("disabled", true);

        $.ajax({
            url: '/freelancer/applications/submit',
            type: 'POST',
            data: formData,
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false
        })
            .done(function (data) {
                $("#apply").attr("disabled", false);
                $("#apply").html("Submit Application");

                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.error, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                $("#apply").attr("disabled", false);
                $("#apply").html("Submit Application");
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });

    })

    // Show qualification field if they select other as qualification
    $('#qualification').change(function () {
        if (this.value === 'Other') {
            $("#q-other").removeClass("hidden");
        } else {
            $("#q-other").addClass("hidden");
        }
    });

    $('#fl-qualification').change(function () {
        if (this.value === 'Other') {
            $("#q-other").removeClass("hidden");
        } else {
            $("#q-other").addClass("hidden");
        }
    });

    // Show socialiate complete profile sections based on the selected role
    $('input[type=radio][name=account-type-radio]').change(function () {
        //alert(this.value);
        if (this.value === 'Student') {
            $("#student").removeClass("hidden");
            $("#parent").addClass("hidden");
            $("#fl").addClass("hidden");
        } else if (this.value === 'Professional') {
            $("#parent").removeClass("hidden");
            $("#student").addClass("hidden");
            $("#fl").addClass("hidden");
        } else if (this.value === 'FL') {
            $("#fl").removeClass("hidden");
            $("#parent").addClass("hidden");
            $("#student").addClass("hidden");
        }
    });

    // Socialite - Student complete profile
    $("#studentCompleteProfile").click(function (e) {
        e.preventDefault();

        const type = $("input[name='account-type-radio']:checked").val();
        const first = $("#student-first").val();
        const last = $("#student-last").val();
        const email = $("#student-email").val();
        const username = $("#student-username").val();
        const gender = $("#student-gender").val();
        const dob = $("#student-dob").val();
        const phone = $("#student-phone").val();
        const school = $("#student-school").val();

        var formData = {
            'type': type,
            'first': first,
            'last': last,
            'email': email,
            'username': username,
            'gender': gender,
            'dob': dob,
            'phone': phone,
            'school': school,
            '_token': token
        };

        $.ajax({
            url: '/socialite/complete-profile/student',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
            .done(function (data) {
                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.message, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
    });

    // Socialite - Professional complete profile
    $("#parentCompleteProfile").click(function (e) {
        e.preventDefault();

        const type = $("input[name='account-type-radio']:checked").val();
        const first = $("#parent-first").val();
        const last = $("#parent-last").val();
        const email = $("#parent-email").val();
        const username = $("#parent-username").val();
        const gender = $("#parent-gender").val();
        const dob = $("#parent-dob").val();
        const phone = $("#parent-phone").val();
        const school = $("#parent-school").val();

        var formData = {
            'type': type,
            'first': first,
            'last': last,
            'email': email,
            'username': username,
            'gender': gender,
            'dob': dob,
            'phone': phone,
            'school': school,
            '_token': token
        };

        $.ajax({
            url: '/socialite/complete-profile/parent',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
            .done(function (data) {
                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.message, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
    });

    $("#seCompleteProfile").click(function (e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('application'));
        var areas = $('#areas').val();
        formData.append("areas", areas)
        formData.append("type", "FL");

        $("#seCompleteProfile").html("<img src='/img/spinner.gif' height='20' width='20' />");
        $("#seCompleteProfile").attr("disabled", true);

        $.ajax({
            url: '/socialite/complete-profile/fl',
            type: 'POST',
            data: formData,
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false
        })
            .done(function (data) {
                console.log(data);
                $("#seCompleteProfile").attr("disabled", false);
                $("#seCompleteProfile").html("Complete Profile");

                if (data.success == 1) {
                    window.location.href = data.redirect;
                } else {
                    danger_snackbar(data.error, 8000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                $("#seCompleteProfile").attr("disabled", false);
                $("#seCompleteProfile").html("Complete Profile");
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
    })

    //Email validation function
    function validateEmail(sEmail) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        }
    }

});
