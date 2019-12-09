jQuery(document).ready(function ($) {
    $('#reg_county').select2();

    if(($("#company_id").val())){
        console.log("Bandymas uzpildyti data kintamaji");
        console.log($("#company_id").val());
        console.log("This: " + this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/theme-list-update',
            data: {'company_id': $("#company_id").val()},
            success: function (data) {
                return data;
            }
        });
    }



    $('#company_id').select2({
        placeholder: "Veskite pavadinimą...",
        minimumInputLength: 3,
        ajax: {
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
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

    function themeListUpdate($this) {
        $("#theme").html('');
        var klientas = $($this).select2('data');
        if (klientas != null) {
            var ivestaData = new Date(klientas[0].company_reg_date);
            var esamaData = new Date();
            var skirtumas = (esamaData - ivestaData) / 1000 / 60 / 60 / 24 / 365;
            $('#contacts').val(klientas[0].contacts);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/themesearch',
                data: {
                    'theme': klientas[0].con_type,
                    'how_old': skirtumas,
                    'vkt': klientas[0].vkt,
                    'expo': klientas[0].expo,
                    'eco': klientas[0].eco,
                },
                success: function (data) {
                    var visa_info = [];
                    var vkt_array = [];
                    var expo_array = [];
                    var eco_array = [];
                    data.forEach(funkcija);

                    function funkcija(item, index) {
                        if (item.theme == "VKT") {
                            vkt_array.push({
                                id: item.id,
                                text: item.theme_number + '. ' + item.text
                            });
                        }
                        else if(item.theme == 'EXPO'){
                            expo_array.push({
                                id: item.id,
                                text: item.theme_number + '. ' + item.text
                            });
                        }
                        else {
                            eco_array.push({
                                id: item.id,
                                text: item.theme_number + '. ' + item.text
                            });
                        }
                    };

                    if (vkt_array.length > 0) {
                        visa_info.push({
                            text: 'VKT',
                            children: vkt_array
                        });
                    }

                    if (expo_array.length > 0) {
                        visa_info.push({
                            text: 'EXPO',
                            children: expo_array
                        });
                    }

                    if (eco_array.length > 0) {
                        visa_info.push({
                            text: 'ECO',
                            children: eco_array
                        });
                    }
                    $("#theme").select2({
                        data: visa_info
                    });
                }
            })
        }
    };

    $('#company_id').change(function () {
        themeListUpdate(this);
    });


    $('#ex-date').change(function () {
        getConsultations();
    });
    $('#con_type').change(function () {
        getConsultations();
    });

    function getConsultations() {
        if($('#con_type').val() && $('#ex-date').val()){
            console.log("Abu laukeliai uzpildyti");
            console.log($('#con_type').val());
            console.log($('#ex-date').val());

            $.ajax({

            });
        }
    }

});