$(document).ready(function(){
    const token = $("#token").val();

    $("#send").click(function(e){
        e.preventDefault();

        var message = $("#message").val();
        var roomId = $("#roomId").val();

        const formData = {'message':message, 'roomId':roomId, '_token':token};

        $.ajax({
            url: '/messages/send',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
        .done(function (data) { 
            if(data.success == 1){
                $("#message").val("");
                $("#thread").html(data.messages);
            }else{
                danger_snackbar(data.error, 5000);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown); 
        });
    });

    const interval = setInterval(function() {
        refresh();
    }, 2000);

    function refresh(){
        var roomId = $("#roomId").val();
        const formData = {'roomId':roomId, '_token':token};

        $.ajax({
            url: '/messages/refresh',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
        .done(function (data) { 
            if(data.success == 1){
                $("#thread").html(data.messages);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown); 
        });
    }

    $(".delete").click(function(e){
        e.preventDefault();

        var uuid = $(this).attr('data-code');

        const formData = {'uuid':uuid, '_token':token};

        $.ajax({
            url: '/messages/rooms/delete',
            type: 'POST',
            data: formData,
            datatype: 'json'
        })
        .done(function (data) { 
            if(data.success == 1){
                success_snackbar(data.message, 3000)
                setTimeout(function(){
                    location.reload();
                }, 3000);
            }else{
                danger_snackbar(data.error, 5000);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown); 
        });
    });

}); 
