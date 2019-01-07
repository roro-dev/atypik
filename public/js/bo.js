$(document).ready(function() {
    
    if($('#logement_id_type').length > 0) {
        getParams();
        $('#logement_id_type').on('change', function() {
            getParams();
        })
    }

    if($('#villeSearch').length > 0) {
        $('#villeSearch').autocomplete({
            minLength: 2,
            source: function (requete, reponse) {
                $.ajax({
                    url: '/admin/logement/getVilles',
                    dataType: 'JSON',
                    method: 'post',
                    data: {'term': $('#villeSearch').val()},
                    success: function (donnee) {
                        console.log(donnee);
                        /*reponse(
                            $.map(donnee, function (objet) {
                                
                            })
                        );*/
                    }
                });
            }
        });
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