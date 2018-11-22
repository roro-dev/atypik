$(document).ready(function() {
    
    if($('#logement_id_type').length > 0) {
        $('#logement_id_type').on('change', function() {
            $.ajax({
                url: '/admin/parametres-type/getParamsByType',
                data: {'type': $(this).val()},
                method: 'post',
                success: function(response) {
                    console.log(response);
                    showParams(JSON.parse(response), '#parametres');
                }, 
                error: function() {
                    alert('Une erreur est survenue. Veuillez contactez l\'administrateur du site.');
                }
            })
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