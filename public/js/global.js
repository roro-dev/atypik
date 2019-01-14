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
                    url: '/ajax/getVilles',
                    dataType: 'JSON',
                    method: 'post',
                    data: {'term': $('#villeAuto').val()},
                    success: function (donnee) {
                        reponse(
                            $.map(donnee, function (objet) {
                                return objet.nom;
                            })
                        );
                    }
                });
            }
        });
    }

    if($('#logement_ville').length > 0) {
        $('#logement_ville').autocomplete({
            minLength: 3,
            source: function (requete, reponse) {
                $.ajax({
                    url: '/ajax/getVilles',
                    dataType: 'JSON',
                    method: 'post',
                    data: {'term': $('#logement_ville').val()},
                    success: function (donnee) {
                        reponse(
                            $.map(donnee, function (objet) {
                                return objet.nom;
                            })
                        );
                    }
                    
                });
            },
            select: function( event, ui ) {
                console.log(ui);
            }
        });
    }

    if($('#logement_id_type').length > 0) {
        getParams();
        $('#logement_id_type').on('change', function() {
            getParams();
        })
    }
})


/**
 * Permet d'afficher les paramètres pour un logement
 * @param {array} tab 
 * @param {string} container 
 */
function showParams(tab, container) {
    if(tab.length > 0) {
        $(container).empty();
        $.each(tab, function(k, v){
            $(container).append('<label>'+v.nom+'</label>');
            $(container).append('<input class="form-control" type="text" name="params[' + v.id + ']">');
        });
    }
}

function getParams() {
    $.ajax({
        url: '/ajax/getParamsByType',
        data: {'type': $('#logement_id_type').val()},
        method: 'post',
        success: function(response) {
            showParams(JSON.parse(response), '#parametres');
        }, 
        error: function() {
            alert('Une erreur est survenue. Veuillez contactez l\'administrateur du site.');
        }
    });
}