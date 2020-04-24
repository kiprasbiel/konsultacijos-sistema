jQuery(document).ready(function ($) {
    $('#reg_county').select2();

    $('#company_id').select2({
        placeholder: "Veskite pavadinimą...",
        minimumInputLength: 3,
        ajax: {
            type: 'get',
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

    // Fetch the preselected item, and add to the control
    const clientSelect_id = $('#company_id').val();
    const theme_id = $('#theme').val();
    console.log("Original theme id: " + theme_id);
    // $("#company_id > option").remove();
    var clientSelect = $('#company_id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/search/' + clientSelect_id,
        dataType: 'json',
    }).then(function (data) {
        const all_data = data;
        // create the option and append to Select2
        var option = new Option(data.text, data.id, true, true);
        clientSelect.append(option).trigger('change');

        // manually trigger the `select2:select` event
        clientSelect.trigger({
            type: 'select2:select',
            params: {
                data: data.company_reg_date
            }
        });
        themeListUpdate(data);

    });

    function themeListUpdate($this){
        $("#theme").html('');
        // var klientas = $($this).select2('data');
        var ivestaData = new Date($this.company_reg_date);
        var esamaData = new Date();
        var skirtumas = (esamaData - ivestaData) / 1000 / 60 / 60 / 24 / 365;
        $('#contacts').val($this.contacts);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/themesearch',
            data: {
                'theme': $this.con_type,
                'how_old': skirtumas,
                'vkt': $this.vkt,
                'expo': $this.expo,
                'eco': $this.eco,
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
                    } else if (item.theme == 'EXPO') {
                        expo_array.push({
                            id: item.id,
                            text: item.theme_number + '. ' + item.text
                        });
                    } else {
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

                $('#theme').val(theme_id);
                $("#theme").trigger("change");


            }
        });

    }

    $('#company_id').change(function () {
        themeListUpdate($(this).select2('data')[0]);
    });



});
