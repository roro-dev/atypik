$(document).ready(function() {
    $('#inputDepartureDate').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap4'
    });
    $('#inputArrivalDate').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap4'
    });
    $('#dateDebut').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap4'
    });
    $('#dateFin').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap4'
    });

    if($('#villeAuto').length > 0) {
        $('#villeAuto').autocomplete({
            minLength: 3,
            source: function (requete, reponse) {
                $.ajax({
                    url: '/ville/getVilles',
                    dataType: 'JSON',
                    method: 'post',
                    data: {'term': $('#villeAuto').val()},
                    success: function (donnee) {
                        console.log(donnee);
                        /*reponse(
                            $.map(donnee, function (objet) {})
                        );*/
                    }
                });
            }
        });
    }
})