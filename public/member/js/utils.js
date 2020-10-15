// Show success snack bar
function success_snackbar(message, fadeAfter){
	Snackbar.show({
        text: message,
        pos: 'bottom-right',
        showAction: false,
        actionText: "Dismiss",
        duration: fadeAfter,
        textColor: '#fff',
        backgroundColor: '#00a554'
    });
}

// Show danger snackbar
function danger_snackbar(message, fadeAfter){
	Snackbar.show({
        text: message,
        pos: 'bottom-right',
        showAction: false,
        actionText: "Dismiss",
        duration: fadeAfter,
        textColor: '#f80031',
        backgroundColor: '#fdd1da'
    });
}

// Show info snackbar
function info_snackbar(message, fadeAfter){
    Snackbar.show({
        text: message,
        pos: 'bottom-right',
        showAction: false,
        actionText: "Dismiss",
        duration: fadeAfter,
        textColor: '#3184ae',
        backgroundColor: '#e9f7fe'
    });
}

$(document).ready(function(){
    $("#frl").on("click", "span.bookmark-icon", function(e){
        e.preventDefault();

        var accId = $(this).attr('data-code');
        alert(accId);

    });
})