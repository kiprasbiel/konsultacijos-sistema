// //Tikrina imones ikurimo data ir pagal tai palieka
// //tik leistinus konsultacijos tipus

//Jei imonei daugiau nei 5 metai, tai pasalina VKT is dropdown
jQuery(document).ready(function($){
    $("#company_reg_date").change(function () {
        var ivestaData = new Date($("#company_reg_date").val());
        var esamaData = new Date();
        var skirtumas = (esamaData - ivestaData)/1000/60/60/24/365;
        if(skirtumas >= 5){
            $('#con_type > option:nth-child(1)').css("display", "none");
        }
        else {
            $('#con_type > option:nth-child(1)').css("display", "block");
        }
    });
});