jQuery(document).ready(function($){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });


    //User destroy modal
    $('#user_destroy_form').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        var host = window.location.origin;
        modal.find('.modal-title').text('Pašalinti vartotoją ' + name);
        modal.find('#modal_description').html('Pasirinkite kam priskirti <strong>' + name + '</strong> konsultacijas ir klientus:');
        modal.find('#user_delete_form').attr('action', host + '/vartotojai/' + id);

    })

    if ($(".aw-error")[0]){
        $('#import-submit').attr('disabled', true);
    }

    $('#con_payment').change(function () {
        if ($(this).val() == 2){
            $('#send_month').css('display', 'none');
        }
        else {
            $('#send_month').css('display', 'block');
        }

    });

    //Exports JS checking
    $("input[name='con-date']").change(function () {
        if ($("#con-date1").is(":checked")){
            $("#con_payment2").attr("disabled", true);
        }
        else {
            $("#con_payment2").attr("disabled", false);
        }
    });

    $("input[name='con_payment']").change(function () {
        if ($("#con_payment2").is(":checked")){
            $("#con-date1").attr("disabled", true);
        }
        else {
            $("#con-date1").attr("disabled", false);
        }
    });
});
