$(document).ready(function() {
    $('#inputDepartureDate').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap4'
    });
    $('#inputArrivalDate').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap4'
    });

    if($('#villeAuto').length > 0) {
        $('#villeAuto').autocomplete({
            minLength: 2,
            source: function (requete, reponse) {
                $.ajax({
                    url: 'https://geo.api.gouv.fr/docs/communes',
                    dataType: 'JSON',
                    method: 'get',
                    data: {'name': $('#villeAuto').val(), 'fields': 'departement'},
                    success: function (donnee) {
                        console.log(donnee);
                        reponse(
                            $.map(donnee, function (objet) {
                                
                            })
                        );
                    }
                });
            }
        });
    }
})