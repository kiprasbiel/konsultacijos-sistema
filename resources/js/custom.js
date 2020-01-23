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
        modal.find('.modal-title').text('Pašalinti vartotoją ' + name);
        modal.find('#modal_description').html('Pasirinkite kam priskirti <strong>' + name + '</strong> konsultacijas ir klientus:');
        modal.find('#user_delete_form').attr('action', 'http://konsultacijos.test/vartotojai/' + id);

    })
});
