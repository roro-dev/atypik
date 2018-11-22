$(document).ready(function() {
    
    if($('#logement_id_type').length > 0) {
        $('#logement_id_type').on('change', function() {
            $.ajax({
                url: '/admin/parametres-type/getParamsByType',
                data: {'type': $(this).val()},
                method: 'post',
                success: function(response) {
                    params = JSON.parse(response);
                    $.each(params, function(k, v){
                        console.log(v.nom);
                        $('#parametres').empty();
                        $('#parametres').append('<label>'+v.nom+'</label>');
                        $('#parametres').append('<input class="form-control" type="text" name="param-'+ (k+1) +'">');
                    })
                }, 
                error: function() {
                    alert('Une erreur est survenue. Veuillez contactez l\'administrateur du site.');
                }
            })
        })
    }

})