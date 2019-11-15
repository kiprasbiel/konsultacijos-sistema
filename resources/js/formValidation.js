// //Tikrina imones ikurimo data ir pagal tai palieka
// //tik leistinus konsultacijos tipus

//Jei imonei daugiau nei 5 metai, tai pasalina VKT is dropdown
jQuery(document).ready(function($){
    $("#company_reg_date").change(function () {
        var ivestaData = new Date($("#company_reg_date").val());
        var esamaData = new Date();
        var skirtumas = (esamaData - ivestaData)/1000/60/60/24/365;
        if(skirtumas >= 5){
            $('#con_type option[value="VKT"]').css("display", "none");
        }
    });
});


jQuery(document).ready(function($){
    $('.select2').select2();
});

jQuery(document).ready(function($) {



    $('#company_id').select2({
        placeholder: "Veskite pavadinimą...",
        minimumInputLength: 3,
        ajax: {
            delay: 500,
            url: '/search',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {

                return {

                    results: data
                };
            },
            cache: true
        }
    });

    $('#company_id').change(function () {
        $("#theme").html('');
        var klientas = $(this).select2('data');
        if (klientas != null){
            var ivestaData = new Date(klientas[0].company_reg_date);
            var esamaData = new Date();
            var skirtumas = (esamaData - ivestaData)/1000/60/60/24/365;
            $('#contacts').val(klientas[0].contacts);
            $.ajax({
                type: 'get',
                url: '/themesearch',
                data: {'theme':klientas[0].con_type, 'how_old':skirtumas},
                success: function (data) {
                    var visa_info = [];
                    data.forEach(funkcija);

                    function funkcija(item, index) {
                        visa_info.push({
                            id: item.id,
                            text: item.theme_number + '. ' + item.name
                        }) ;
                    };

                    $("#theme").select2({
                        data: visa_info
                    });
                }
            })
        }

    });



});