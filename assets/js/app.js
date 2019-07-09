/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/global.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

require('bootstrap');
window.Swal = require('sweetalert2');


$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault();

        let form = this;

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: $(form).serialize(),
            dataType: 'json',
            beforeSend: () => {
                Swal.fire({
                    title: 'Carregando...',
                    showLoaderOnConfirm: true,
                    type: 'info'
                })
            }
        })
        .done(function(response) {
            console.log(response);
            let entityName = response.entityName

            $('#table-list').html(response.data);

            Swal.fire('Aviso', `${entityName}(s) cadastrada(os)(as) com sucesso!`, 'success')
        })
        .fail(function(response) {
            /**
             * Entity's name that was requested
             */
            var entityName = response.responseJSON.entityName;
        
            /**
             * Get propertyPath, title, parameters and type
             */
            
            var jsonResponse = response.responseJSON.data;

            for (let i = 0;i < jsonResponse.length;i++) {
                var violations = Object.values(jsonResponse[i].violations);

                for (violation of violations) {
                    console.log(violation)
                }
            }

            Swal.queue([{
                title: 'Houve algum erro',
                confirmButtonText: 'Entendi!',
                text: () => {
                    return "ASD"
                },
                // text: `${violation.title} ${parameters}`,
                type: 'warning',
            }])
        });

    });
});
