$(document).ready(function(){
    const token = $("#token").val();

    $("#updateBrand").click(function(e){
        e.preventDefault();

        var name = $("#name").val();
        var country = $("#country").val();
        var city = $("#city").val();
        var address = $("#address").val();

        if($.trim(name) == '' || $.trim(country) == '' || $.trim(city) == '' || $.trim(address) == ''){
            danger_snackbar("All fields are required", 5000);
            return false;
        }else{
            const formData = {'name':name, 'city':city, 'address':address, 'country':country, '_token':token};

            $.ajax({
                url: '/brand/profile/update',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
            .done(function (data) { 
                if(data[0].success == 1){
                    success_snackbar(data[0].message, 5000);
                }else{
                    danger_snackbar(data[0].message, 5000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown); 
            });
        }
    });

    $("#updateInfluencer").click(function(e){
        e.preventDefault();

        var first = $("#first").val();
        var last = $("#last").val();
        var country = $("#country").val();

        if($.trim(first) == '' || $.trim(last) == '' || $.trim(country) == ''){
            danger_snackbar("All fields are required", 5000);
            return false;
        }else{
            const formData = {'first':first, 'last':last, 'country':country, '_token':token};

            $.ajax({
                url: '/influencer/profile/update',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
            .done(function (data) { 
                if(data[0].success == 1){
                    success_snackbar(data[0].message, 5000);
                }else{
                    danger_snackbar(data[0].message, 5000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown); 
            });
        }
    });

    $("#addChangePhone").click(function(e){
        e.preventDefault();

        var phone = $("#phone").val();

        if($.trim(phone) == ''){
            danger_snackbar("Phone number is required", 5000);
            return false;
        }else if(!validatePhone($.trim(phone))){
        	danger_snackbar("Invalid phone number. Accepte format: 254xxxxxxxxx", 5000);
            return false;
        }else{
            const formData = {'phone':phone,  '_token':token};

            $.ajax({
                url: '/verification/phone',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
            .done(function (data) { 
                if(data[0].success == 1){
                	success_snackbar(data[0].message, 5000);

                    jQuery(document).ready(function ($) {
                        $.magnificPopup.open({
                            items: {
                                src: '#small-dialog'
                            }
                        });
                    });
                }else if(data[0].success == 3){
                	success_snackbar(data[0].message, 5000);
                }else{
                    danger_snackbar(data[0].message, 5000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown); 
            });
        }
    });

    $("#verify").click(function(e){
        e.preventDefault();

        var code = $("#code").val();

        if($.trim(code) == '' || $.trim(code).length != 4 || !$.isNumeric($.trim(code))){
            danger_snackbar("Invalid verification code", 5000);
            return false;
        }else{
            const formData = {'code':code,  '_token':token};

            $.ajax({
                url: '/verification/verify-phone',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
            .done(function (data) { 
                if(data[0].success == 1){
                	success_snackbar(data[0].message, 5000);
                	setTimeout(function(){
                        window.location.reload();
                    }, 2000);
                	
                }else{
                    danger_snackbar(data[0].message, 5000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown); 
            });
        }
    });

    // Influencer toggle auto discovery switch
    $("#discoverySwitch").click(function(e){
        const formData = {'_token':token};
        $.ajax({
            url: '/influencer/settings/toggle-autodiscovery',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
        .done(function (data) { 
            if(data[0].success == 1){
                success_snackbar(data[0].message, 5000);
            }else{
                danger_snackbar(data[0].message, 5000);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown); 
        });
    });

    // Influencer toggle pre authorize campaigns switch
    $("#preauthorizeSwitch").click(function(e){
        const formData = {'_token':token};
        $.ajax({
            url: '/influencer/settings/toggle-preauthorize',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
        .done(function (data) { 
            if(data[0].success == 1){
                success_snackbar(data[0].message, 5000);
            }else{
                danger_snackbar(data[0].message, 5000);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown); 
        });
    });

    $("#updateSecurity").click(function(e){
        e.preventDefault();

        var oldPass = $("#current").val();
        var newPass = $("#newPass").val();
        var confirm = $("#confirm").val();

        if($.trim(oldPass) == '' || $.trim(newPass) == '' || $.trim(confirm) == ''){
            danger_snackbar("All fields are required", 5000);
            return false;
        }else if($.trim(confirm) != $.trim(newPass)){
            danger_snackbar("New password does not match confirm password", 5000);
            return false;
        }else{
            const formData = {'oldPass':oldPass, 'newPass':newPass, '_token':token};

            $.ajax({
                url: '/settings/change-password',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
            .done(function (data) { 
                if(data[0].success == 1){
                    success_snackbar(data[0].message, 5000);
                    setTimeout(function(){
                        window.location.href = "/";
                    }, 3000);
                }else{
                    danger_snackbar(data[0].message, 5000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown); 
            });
        }
    });

    function validatePhone(number){
    	var filter = /^(?:254)?(7(?:(?:[129][0-9])|(?:0[0-8])|(4[0-1]))[0-9]{6})$/;
        if (filter.test(number)) {
            return true;
        }
    }

}); 
