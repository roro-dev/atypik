$(document).ready(function() {

    if(window.location.hash.length > 0) {
        $('#link_' + window.location.hash.replace('#', '')).click();
    } else {
        $('#dashboard').addClass('active');
    }

});