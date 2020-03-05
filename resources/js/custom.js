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
        //If selecting Neapmoketos kons
        if ($("#con_payment2").is(":checked")){
            $("#con-date1").attr("disabled", true);
        }
        else {
            $("#con-date1").attr("disabled", false);
        }
    });

    $("#con-month-exp-form").change(function () {
        if ($("#is-sent1").is(":checked") && $("#con_payment1").is(":checked") && $("#con-date1").is(":checked")){
            $("#send_month").attr("disabled", false);
        }
        else {
            $("#send_month").attr("disabled", true);
        }
    });

    $("#prefill-button").click(function () {
        $("#is-sent1").attr("checked", true);
        $("#con_payment1").attr("checked", true);
        $("#con-date1").attr("checked", true);
        $("#send_month").attr("disabled", false);
    });
});
