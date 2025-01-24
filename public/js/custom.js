// import { url } from "inspector";
$(document).ready(function(){
    const formIdcambios = 'cambios_proyeccion';
    const formverif = document.getElementById(formIdcambios);
    
    if (formverif) {
        habilitar_inputs_cambios(formIdcambios);
    }
    var form = document.forms[1].id;
    
    var docentes_activos = $("#docentes_activos").val();
    if(docentes_activos == 0)
    {

        $("#v_b_dec_solic").hide();
    }
    else
    {
        $("#v_b_dec_solic").show();
    }
    
    var dur_dias_inicial = 0;
    $('#duracion_ra').val(dur_dias_inicial);

    var id_p_aca = $("#id_programa_academico").val();
    var id_e_aca = $("#id_espacio_academico").val();
    var num_apoyo = $("#num_apoyo").val();
    var id_docen_resp = $("#num_docen").attr('name');
    if(form == "edit_proyeccion" || form == "edit_solicitud")
    {
        recargarEspa_aca_edit(id_p_aca,id_e_aca,id_docen_resp,0);

        if(form == "edit_proyeccion")
        {
            revisar_soporte_pdf();
        }
    }
    else{

        recargarEspacios_aca(id_p_aca,id_docen_resp,1);
    }

    var cant_trans_menor_rp = $("#cant_trans_menor_rp").val();
    if(cant_trans_menor_rp >= 1)
    {
        $("#docente_trans_menor_rp").show();
    }
    else
    {
        $("#docente_trans_menor_rp").hide();
    }

    var cant_trans_menor_ra = $("#cant_trans_menor_ra").val();
    if(cant_trans_menor_ra >= 1)
    {
        $("#docente_trans_menor_ra").show();
    }
    else
    {
        $("#docente_trans_menor_ra").hide();
    }

    var cant_transp_rp_edit = $("#cant_transporte_rp_edit").val();
    if(cant_transp_rp_edit >= 1)
    {
        $("#docente_transp_edit_rp").show();
    }
    else
    {
        $("#docente_transp_edit_rp").hide();
    }

    var cant_transp_ra_edit = $("#cant_transporte_ra_edit").val();
    if(cant_transp_ra_edit >= 1)
    {
        $("#docente_transp_edit_ra").show();
    }
    else
    {
        $("#docente_transp_edit_ra").hide();
    }

    function revisar_soporte_pdf()
    {
        var soporte_pdf = $("#soporte_apoyo_pdf").attr('src');
        var num_apoyo_pdf = $("#num_apoyo").val();

        if(soporte_pdf == "data:application/pdf;base64," || soporte_pdf == undefined || soporte_pdf == "null")
        {
            if(num_apoyo_pdf >= 1)
            {
                $("#sop_pers_apoyo").attr('required','required');
                $("#soporte_apoyo").show();
                $("#ver_sopor_pdf").hide();
            }
            else if(num_apoyo_pdf == 0)
            {
                $("#sop_pers_apoyo").removeAttr('required','required');
                $("#soporte_apoyo").hide();
                $("#soporte_pers_apoyo").hide();
                $("#ver_sopor_pdf").hide();
                
            }
        }
        else if(soporte_pdf != "data:application/pdf;base64," && soporte_pdf != "null")
        {
            
            $("#sop_pers_apoyo").removeAttr('required','required');
            $("#soporte_apoyo").hide();
            $("#ver_sopor_pdf").show();
           
        }
    }

    var prac_integrada = $("#integrada").is(':checked');
    switch(prac_integrada)
    {
        case true:
            $("#espa_aca_int").show();
            cant_int = $("#cant_espa_aca").val();
            

            if(form == "edit_proyeccion" || form == "edit_solicitud")
            {
                num_max_apoyo = 10 - cant_int;
            }
            else{

                num_max_apoyo = 10;
            }

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max',num_max_apoyo);

            switch(cant_int)
            {
                case "1":
                    $("#esp_aca_1").show();
                    $("#esp_aca_2").hide();
                    $("#esp_aca_3").hide();
                    $("#esp_aca_4").hide();
                    $("#esp_aca_5").hide();
                    $("#esp_aca_6").hide();
                    $("#esp_aca_7").hide();
                    $("#esp_aca_1").attr("required","required");
                    $("#esp_aca_2").removeAttr("required","required");
                    $("#esp_aca_3").removeAttr("required","required");
                    $("#esp_aca_4").removeAttr("required","required");
                    $("#esp_aca_5").removeAttr("required","required");
                    $("#esp_aca_6").removeAttr("required","required");
                    $("#esp_aca_7").removeAttr("required","required");
                    break;
                case "2":
                    $("#esp_aca_1").show();
                    $("#esp_aca_2").show();
                    $("#esp_aca_3").hide();
                    $("#esp_aca_4").hide();
                    $("#esp_aca_5").hide();
                    $("#esp_aca_6").hide();
                    $("#esp_aca_7").hide();
                    $("#esp_aca_1").attr("required","required");
                    $("#esp_aca_2").attr("required","required");
                    $("#esp_aca_3").removeAttr("required","required");
                    $("#esp_aca_4").removeAttr("required","required");
                    $("#esp_aca_5").removeAttr("required","required");
                    $("#esp_aca_6").removeAttr("required","required");
                    $("#esp_aca_7").removeAttr("required","required");
                    break;
                case "3":
                    $("#esp_aca_1").show();
                    $("#esp_aca_2").show();
                    $("#esp_aca_3").show();
                    $("#esp_aca_4").hide();
                    $("#esp_aca_5").hide();
                    $("#esp_aca_6").hide();
                    $("#esp_aca_7").hide();
                    $("#esp_aca_1").attr("required","required");
                    $("#esp_aca_2").attr("required","required");
                    $("#esp_aca_3").attr("required","required");
                    $("#esp_aca_4").removeAttr("required","required");
                    $("#esp_aca_5").removeAttr("required","required");
                    $("#esp_aca_6").removeAttr("required","required");
                    $("#esp_aca_7").removeAttr("required","required");
                    break;
                case "4":
                    $("#esp_aca_1").show();
                    $("#esp_aca_2").show();
                    $("#esp_aca_3").show();
                    $("#esp_aca_4").show();
                    $("#esp_aca_5").hide();
                    $("#esp_aca_6").hide();
                    $("#esp_aca_7").hide();
                    $("#esp_aca_1").attr("required","required");
                    $("#esp_aca_2").attr("required","required");
                    $("#esp_aca_3").attr("required","required");
                    $("#esp_aca_4").attr("required","required");
                    $("#esp_aca_5").removeAttr("required","required");
                    $("#esp_aca_6").removeAttr("required","required");
                    $("#esp_aca_7").removeAttr("required","required");
                    break;
                case "5":
                    $("#esp_aca_1").show();
                    $("#esp_aca_2").show();
                    $("#esp_aca_3").show();
                    $("#esp_aca_4").show();
                    $("#esp_aca_5").show();
                    $("#esp_aca_6").hide();
                    $("#esp_aca_7").hide();
                    $("#esp_aca_1").attr("required","required");
                    $("#esp_aca_2").attr("required","required");
                    $("#esp_aca_3").attr("required","required");
                    $("#esp_aca_4").attr("required","required");
                    $("#esp_aca_5").attr("required","required");
                    $("#esp_aca_6").removeAttr("required","required");
                    $("#esp_aca_7").removeAttr("required","required");
                    break;
                case "6":
                    $("#esp_aca_1").show();
                    $("#esp_aca_2").show();
                    $("#esp_aca_3").show();
                    $("#esp_aca_4").show();
                    $("#esp_aca_5").show();
                    $("#esp_aca_6").show();
                    $("#esp_aca_7").hide();
                    $("#esp_aca_1").attr("required","required");
                    $("#esp_aca_2").attr("required","required");
                    $("#esp_aca_3").attr("required","required");
                    $("#esp_aca_4").attr("required","required");
                    $("#esp_aca_5").attr("required","required");
                    $("#esp_aca_6").attr("required","required");
                    $("#esp_aca_7").removeAttr("required","required");
                    break;
                case "7":
                    $("#esp_aca_1").show();
                    $("#esp_aca_2").show();
                    $("#esp_aca_3").show();
                    $("#esp_aca_4").show();
                    $("#esp_aca_5").show();
                    $("#esp_aca_6").show();
                    $("#esp_aca_7").show();
                    $("#esp_aca_1").attr("required","required");
                    $("#esp_aca_2").attr("required","required");
                    $("#esp_aca_3").attr("required","required");
                    $("#esp_aca_4").attr("required","required");
                    $("#esp_aca_5").attr("required","required");
                    $("#esp_aca_6").attr("required","required");
                    $("#esp_aca_7").attr("required","required");
            }

            break;
        case false:
            $("#espa_aca_int").hide();
            // $("#c_espa_aca").hide();
            break;
    }


   if(num_apoyo > 0)
   {
        $("#soporte_apoyo").show();
        num_max_apoyo = $("#num_apoyo").val();
        $("#total_docentes_apoyo").attr('max',num_max_apoyo);
   }
   else if(num_apoyo == 0 || num_apoyo == null)
   {
	    $("#total_docentes_apoyo").attr('max',0);
        $("#cant_docen_apoyo").hide();
        $("#soporte_apoyo").hide();
   }

    /*transporte ruta principal - rp Proyección*/
    var maxField_rp = 3;
    var addButton_rp = $('#add_transp_rp');
    var x_rp = 1;
    var nameFieldInput_rp = $('#transporte_rp_children').children().find('input[type=text]').attr('id');
    var nameOtroTransp_rp = $('#transporte_rp_children').children().find('input[type=text]').attr('id');
    var nameFieldRadio_rp = $('#transporte_rp_children').children().find('input[type=radio]').attr('id');
    var lengthRadio_rp;
    var shortNameRadio_rp;
    var w_rp,y_rp,z_rp;
    var div_copy_rp;
    var classError_rp;
    /*transporte ruta principal - rp Proyección*/

    /*transporte ruta alterna - ra Proyección*/
    var maxField_ra = 3;
    var addButton_ra = $('#add_transp_ra');
    var x_ra = 1;
    var nameFieldInput_ra = $('#transporte_ra_children').children().find('input[type=text]').attr('id');
    var nameOtroTransp_ra = $('#transporte_ra_children').children().find('input[type=text]').attr('id');
    var nameFieldRadio_ra = $('#transporte_ra_children').children().find('input[type=radio]').attr('id');
    var lengthRadio_ra;
    var shortNameRadio_ra;
    var w_ra,y_ra,z_ra;
    var div_copy_ra;
    var classError_ra;
    /*transporte ruta alterna - ra Proyección*/

    /*transporte ruta principal - rp Edit Proyección*/
    var maxField_edit_rp = 3;
    var addButton_edit_rp = $('#add_transp_edit_rp');
    var x_edit_rp = 1;
    var nameFieldInput_edit_rp = $('#transporte_rp_children').children().find('input[type=text]').attr('id');
    var nameFieldRadio_edit_rp = $('#transporte_rp_children').children().find('input[type=radio]').attr('id');
    var lengthRadio_edit_rp;
    var shortNameRadio_edit_rp;
    var w_edit_rp,y_edit_rp,z_edit_rp;
    var div_copy_edit_rp;
    var classError_edit_rp;
    /*transporte ruta principal - rp Edit Proyección*/

    /*transporte ruta alterna - ra Edit Proyección*/
    var maxField_edit_ra = 3;
    var addButton_edit_ra = $('#add_transp_ra');
    var x_edit_ra = 1;
    var nameFieldInput_edit_ra = $('#transporte_ra_children').children().find('input[type=text]').attr('id');
    var nameOtroTransp_edit_ra = $('#transporte_ra_children').children().find('input[type=text]').attr('id');
    var nameFieldRadio_edit_ra = $('#transporte_ra_children').children().find('input[type=radio]').attr('id');
    var lengthRadio_edit_ra;
    var shortNameRadio_edit_ra;
    var w_edit_ra,y_edit_ra,z_edit_ra;
    var div_copy_edit_ra;
    var classError_edit_ra;
    /*transporte ruta alterna - ra Edit Proyección*/

    /*espacios acadeémicos - ea Proyección*/
    var maxField_ea = 6;
    var addButton_ea = $('#add_ea');
    var x_ea = 1;
    var nameFieldInput_ea = $('#esp_aca_children').children().find('input[type=text]').attr('id');
    var nameEaFieldInput_ea;
    var lengthInput_ea;
    var shortNameInput_ea;
    var nameFieldSelect_ea = $('#esp_aca_children').children().find('select').attr('id');
    var nameEaFieldSelect_ea;
    var lengthSelect_ea;
    var shortIdSelect_ea;
    var w_ea,y_ea,z_ea,p_ea;
    var div_copy_ea;
    var classError_ea;
    var lengthDiv_ea;
    
    /*espacios acadeémicos - ea Proyección*/

    /*ruta principal - rp Proyección*/
    var maxField_url_rp = 6;
    var addButton_url_rp = $('#add_url_rp');
    var x_url_rp = 1;
    var nameFieldInput_url_rp = $('#rp_url_children').children().find('input[type=text]').attr('id');
    var w_url_rp,y_url_rp,z_url_rp;
    var div_copy_url_rp;
    var classError_url_rp;
    var newName_url_rp;

    var addButton_url_rp_edit = $('#add_url_rp_edit');
    /*ruta principal - rp Proyección*/

    /*ruta alterna - rp Proyección*/
    var maxField_url_ra = 6;
    var addButton_url_ra = $('#add_url_ra');
    var x_url_ra = 1;
    var nameFieldInput_url_ra = $('#ra_url_children').children().find('input[type=text]').attr('id');
    var w_url_ra,y_url_ra,z_url_ra;
    var div_copy_url_ra;
    var classError_url_ra;
    var newName_url_ra;

    var addButton_url_ra_edit = $('#add_url_ra_edit');
    
    /*ruta alterna - rp Proyección*/

    /*cantidad grupos*/
    var cant_grupos_load = $("#cant_grupos").val();
    /*cantidad grupos*/

    /*ruta principal - rp Proyección*/
    $(addButton_url_rp).click(function(e){
        e.preventDefault();
        // $("#ruta_principal").val("nameFieldInput_url_rp");
         if(x_url_rp < maxField_url_rp)
         {
            div_copy_url_rp = $('#rp_url_children').clone();
            div_copy_url_rp.find('span').remove();
            // div_copy_url_rp.find('input[type=text]').removeAttr('required');
            div_copy_url_rp.find('a').first().attr('id','remove_field_rp');
            div_copy_url_rp.find('a').first().attr('class','remove_field_url_rp imgButton');
            div_copy_url_rp.find('a').first().attr('title','Quitar campo');
            div_copy_url_rp.find('img').attr('src','/img/remove-icon.png');
            div_copy_url_rp.find('label').remove();
             
            x_url_rp++;    
            nameFieldInput_url_rp = div_copy_url_rp.find('input[type=text]').first().attr('id');
            length_url_rp = div_copy_url_rp.find('input[type=text]').first().attr('id').length;
            newName_url_rp = nameFieldInput_url_rp+"_"+x_url_rp;
        
            div_copy_url_rp.find('input[type=text]').first().attr('id', newName_url_rp);
            div_copy_url_rp.find('input[type=text]').first().attr('name', newName_url_rp);
            div_copy_url_rp.find('input[type=text]').first().attr('onchange','verifUrl_rp(this)');
            
            nameFieldVer_url_rp = div_copy_url_rp.find('a:nth-child(3)').attr('id');
            lengthVer_url_rp = div_copy_url_rp.find('a:nth-child(3)').attr('id').length;
            shortNameVer_url_rp = nameFieldVer_url_rp.substr(0,lengthVer_url_rp-1);

            newNameVer_url_rp = shortNameVer_url_rp+x_url_rp;
            div_copy_url_rp.find('a:nth-child(3)').attr('id', newNameVer_url_rp);
            div_copy_url_rp.find('a:nth-child(3)').attr('name', newNameVer_url_rp);
            div_copy_url_rp.find('a:nth-child(3)').attr('onclick','ir_rp('+x_url_rp+')');

            div_copy_url_rp.find('a:nth-child(3)').css("pointer-events","none");
            div_copy_url_rp.find('a:nth-child(3)').removeClass("btn-success");
            div_copy_url_rp.find('a:nth-child(3)').css("background-color","#83bfaa");
            div_copy_url_rp.find('a:nth-child(3)').css("border-color","#83bfaa");
            
            div_copy_url_rp.find('input[type=text]').first().attr('id', newName_url_rp);
            div_copy_url_rp.find('input[type=text]').first().attr('name', newName_url_rp);
            
            $("#rp_url").append(div_copy_url_rp);

            div_copy_url_rp.find('input[type=text]').val("");
            div_copy_url_rp.find('input[type=text]').css("borderColor","#d1d3e2");
         }
         
    });

    $('#rp_url').on('click', '.remove_field_url_rp', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().parent().remove();
            x_url_rp--;
            // y_rp=shortNameInput_rp+x_rp;
            // w_url_rp=shortNameRadio_rp+x_url_rp;
            classError_url_rp = "form-control @error('"+y_url_rp+"') is-invalid @enderror";
            	
            div_copy_url_rp.children().find('input[type=radio]').attr('id', w_url_rp);
            div_copy_url_rp.children().find('input[type=radio]').attr('name', w_url_rp);
        
    });
    /*ruta principal - rp Proyección*/

    /*ruta alterna - ra Proyección*/
    $(addButton_url_ra).click(function(e){
        e.preventDefault();
        // $("#ruta_principal").val("nameFieldInput_url_rp");
         if(x_url_ra < maxField_url_ra)
         {
            div_copy_url_ra = $('#ra_url_children').clone();
            div_copy_url_ra.find('span').remove();
            // div_copy_url_ra.find('input[type=text]').removeAttr('required');
            div_copy_url_ra.find('a').first().attr('id','remove_field_ra');
            div_copy_url_ra.find('a').first().attr('class','remove_field_url_ra imgButton');
            div_copy_url_ra.find('a').first().attr('title','Quitar campo');
            div_copy_url_ra.find('img').attr('src','/img/remove-icon.png');
            div_copy_url_ra.find('label').remove();
             
            x_url_ra++;    
            nameFieldInput_url_ra = div_copy_url_ra.find('input[type=text]').first().attr('id');
            length_url_ra = div_copy_url_ra.find('input[type=text]').first().attr('id').length;
            newName_url_ra = nameFieldInput_url_ra+"_"+x_url_ra;

            div_copy_url_ra.find('input[type=text]').first().attr('id', newName_url_ra);
            div_copy_url_ra.find('input[type=text]').first().attr('name', newName_url_ra);
            div_copy_url_ra.find('input[type=text]').first().attr('onchange','verifUrl_ra(this)');

            nameFieldVer_url_ra = div_copy_url_ra.find('a:nth-child(3)').attr('id');
            lengthVer_url_ra = div_copy_url_ra.find('a:nth-child(3)').attr('id').length;
            shortNameVer_url_ra = nameFieldVer_url_ra.substr(0,lengthVer_url_ra-1);

            newNameVer_url_ra = shortNameVer_url_ra+x_url_ra;
            div_copy_url_ra.find('a:nth-child(3)').attr('id', newNameVer_url_ra);
            div_copy_url_ra.find('a:nth-child(3)').attr('name', newNameVer_url_ra);
            div_copy_url_ra.find('a:nth-child(3)').attr('onclick','ir_ra('+x_url_ra+')');

            div_copy_url_ra.find('a:nth-child(3)').css("pointer-events","none");
            div_copy_url_ra.find('a:nth-child(3)').removeClass("btn-success");
            div_copy_url_ra.find('a:nth-child(3)').css("background-color","#83bfaa");
            div_copy_url_ra.find('a:nth-child(3)').css("border-color","#83bfaa");
        
            div_copy_url_ra.find('input[type=text]').first().attr('id', newName_url_ra);
            div_copy_url_ra.find('input[type=text]').first().attr('name', newName_url_ra);
            
            
            $("#ra_url").append(div_copy_url_ra);

            div_copy_url_ra.find('input[type=text]').val("");
            div_copy_url_ra.find('input[type=text]').css("borderColor","#d1d3e2");
            
         }
         
    });

    $('#ra_url').on('click', '.remove_field_url_ra', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().parent().remove();
            x_url_ra--;
            // y_rp=shortNameInput_rp+x_rp;
            // w_url_rp=shortNameRadio_rp+x_url_rp;
            classError_url_ra = "form-control @error('"+y_url_ra+"') is-invalid @enderror";
            	
            div_copy_url_ra.children().find('input[type=radio]').attr('id', w_url_ra);
            div_copy_url_ra.children().find('input[type=radio]').attr('name', w_url_ra);
        
    });
    /*ruta alterna - ra Proyección*/

    /*ruta principal - rp Proyección edit*/
    $(addButton_url_rp_edit).click(function(e){
        e.preventDefault();
        var rp_edit = $("input[id*='ruta_principal']");
        var x_url_rp_edit = rp_edit.length;
        // $("#ruta_principal").val("nameFieldInput_url_rp");
         if(x_url_rp_edit < maxField_url_rp)
         {
            div_copy_url_rp = $('#rp_url_children').clone();
            div_copy_url_rp.find('span').remove();
            // div_copy_url_rp.find('input[type=text]').removeAttr('required');
            div_copy_url_rp.find('a').first().attr('id','remove_field_rp');
            div_copy_url_rp.find('a').first().attr('class','remove_field_url_rp imgButton');
            div_copy_url_rp.find('a').first().attr('title','Quitar campo');
            div_copy_url_rp.find('img').attr('src','/img/remove-icon.png');
            div_copy_url_rp.find('label').remove();
             
            x_url_rp_edit++;    
            nameFieldInput_url_rp = div_copy_url_rp.find('input[type=text]').first().attr('id');
            length_url_rp = div_copy_url_rp.find('input[type=text]').first().attr('id').length;
            newName_url_rp = nameFieldInput_url_rp+"_"+x_url_rp_edit;
        
            div_copy_url_rp.find('input[type=text]').first().attr('id', newName_url_rp);
            div_copy_url_rp.find('input[type=text]').first().attr('name', newName_url_rp);
            div_copy_url_rp.find('input[type=text]').first().attr('onchange','verifUrl_rp(this)');
            
            nameFieldVer_url_rp = div_copy_url_rp.find('a:nth-child(3)').attr('id');
            lengthVer_url_rp = div_copy_url_rp.find('a:nth-child(3)').attr('id').length;
            shortNameVer_url_rp = nameFieldVer_url_rp.substr(0,lengthVer_url_rp-1);

            newNameVer_url_rp = shortNameVer_url_rp+x_url_rp_edit;
            div_copy_url_rp.find('a:nth-child(3)').attr('id', newNameVer_url_rp);
            div_copy_url_rp.find('a:nth-child(3)').attr('name', newNameVer_url_rp);
            div_copy_url_rp.find('a:nth-child(3)').attr('onclick','ir_rp('+x_url_rp_edit+')');

            div_copy_url_rp.find('a:nth-child(3)').css("pointer-events","none");
            div_copy_url_rp.find('a:nth-child(3)').removeClass("btn-success");
            div_copy_url_rp.find('a:nth-child(3)').css("background-color","#83bfaa");
            div_copy_url_rp.find('a:nth-child(3)').css("border-color","#83bfaa");
            
            div_copy_url_rp.find('input[type=text]').first().attr('id', newName_url_rp);
            div_copy_url_rp.find('input[type=text]').first().attr('name', newName_url_rp);
            
            $("#rp_url_edit").append(div_copy_url_rp);

            div_copy_url_rp.find('input[type=text]').val("");
            div_copy_url_rp.find('input[type=text]').css("borderColor","#d1d3e2");
         }
         
    });

    $('#rp_url_edit').on('click', '.remove_field_url_rp', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().parent().remove();
            x_url_rp_edit--;
            // y_rp=shortNameInput_rp+x_rp;
            // w_url_rp=shortNameRadio_rp+x_url_rp;
            classError_url_rp = "form-control @error('"+y_url_rp+"') is-invalid @enderror";
            	
            div_copy_url_rp.children().find('input[type=radio]').attr('id', w_url_rp);
            div_copy_url_rp.children().find('input[type=radio]').attr('name', w_url_rp);
        
    });
    /*ruta principal - rp Proyección edit*/

    /*ruta alterna - ra Proyección edit*/
    $(addButton_url_ra_edit).click(function(e){
        e.preventDefault();
        var ra_edit = $("input[id*='ruta_alterna']");
        var x_url_ra_edit = ra_edit.length;
        // $("#ruta_alterna").val("nameFieldInput_url_ra");
         if(x_url_ra_edit < maxField_url_ra)
         {
            div_copy_url_ra = $('#ra_url_children').clone();
            div_copy_url_ra.find('span').remove();
            // div_copy_url_ra.find('input[type=text]').removeAttr('required');
            div_copy_url_ra.find('a').first().attr('id','remove_field_ra');
            div_copy_url_ra.find('a').first().attr('class','remove_field_url_ra imgButton');
            div_copy_url_ra.find('a').first().attr('title','Quitar campo');
            div_copy_url_ra.find('img').attr('src','/img/remove-icon.png');
            div_copy_url_ra.find('label').remove();
             
            x_url_ra_edit++;    
            nameFieldInput_url_ra = div_copy_url_ra.find('input[type=text]').first().attr('id');
            length_url_ra = div_copy_url_ra.find('input[type=text]').first().attr('id').length;
            newName_url_ra = nameFieldInput_url_ra+"_"+x_url_ra_edit;

            div_copy_url_ra.find('input[type=text]').first().attr('id', newName_url_ra);
            div_copy_url_ra.find('input[type=text]').first().attr('name', newName_url_ra);
            div_copy_url_ra.find('input[type=text]').first().attr('onchange','verifUrl_ra(this)');

            nameFieldVer_url_ra = div_copy_url_ra.find('a:nth-child(3)').attr('id');
            lengthVer_url_ra = div_copy_url_ra.find('a:nth-child(3)').attr('id').length;
            shortNameVer_url_ra = nameFieldVer_url_ra.substr(0,lengthVer_url_ra-1);

            newNameVer_url_ra = shortNameVer_url_ra+x_url_ra_edit;
            div_copy_url_ra.find('a:nth-child(3)').attr('id', newNameVer_url_ra);
            div_copy_url_ra.find('a:nth-child(3)').attr('name', newNameVer_url_ra);
            div_copy_url_ra.find('a:nth-child(3)').attr('onclick','ir_ra('+x_url_ra_edit+')');

            div_copy_url_ra.find('a:nth-child(3)').css("pointer-events","none");
            div_copy_url_ra.find('a:nth-child(3)').removeClass("btn-success");
            div_copy_url_ra.find('a:nth-child(3)').css("background-color","#83bfaa");
            div_copy_url_ra.find('a:nth-child(3)').css("border-color","#83bfaa");
        
            div_copy_url_ra.find('input[type=text]').first().attr('id', newName_url_ra);
            div_copy_url_ra.find('input[type=text]').first().attr('name', newName_url_ra);
            
            
            $("#ra_url_edit").append(div_copy_url_ra);

            div_copy_url_ra.find('input[type=text]').val("");
            div_copy_url_ra.find('input[type=text]').css("borderColor","#d1d3e2");
            
         }
         
    });

    $("#ra_url_edit").on('click', '.remove_field_url_ra', function(e){
        e.preventDefault();

        $(this).parent().parent().parent().parent().remove();
        x_url_ra_edit--;
        classError_url_ra = "form-control @error('"+y_url_ra+"') is-invalid @error";
        div_copy_url_ra.children().find('input[type=radio]').attr('id', w_url_ra);
        div_copy_url_ra.children().find('input[type=radio]').attr('name', w_url_ra);
    });
    /*ruta alterna - ra Proyección edit*/

    /*transporte ruta principal - rp Proyección*/
    $(addButton_rp).click(function(e){
        e.preventDefault();
    
         if(x_rp < maxField_rp)
         {
            div_copy_rp = $('#transporte_rp_children').clone();
            div_copy_rp.children().find('span').remove();
            div_copy_rp.children().find('input[type=text]').removeAttr('required');
            div_copy_rp.children().find('a').attr('id','remove_field_rp');
            div_copy_rp.children().find('a').attr('class','remove_field_rp imgButton');
            div_copy_rp.children().find('a').attr('title','Remove field');
            div_copy_rp.children().find('img').attr('src','/img/remove-icon.png');
             
            x_rp++;    
            nameOtroTransp_rp = div_copy_rp.children().find('input[type=text]').first().attr('id');
            lengthOtroTransp_rp = div_copy_rp.children().find('input[type=text]').first().attr('id').length;
            shortNameOtroTransp_rp = nameOtroTransp_rp.substr(0,lengthOtroTransp_rp-1);
            o_rp = shortNameOtroTransp_rp+x_rp;

            vlrOtroTransp_rp = div_copy_rp.children().find('input[type=text]').eq(1).attr('id');
            lengthVlrOtroTransp_rp = div_copy_rp.children().find('input[type=text]').eq(1).attr('id').length;
            shortVlrOtroTransp_rp = vlrOtroTransp_rp.substr(0,lengthVlrOtroTransp_rp-1);
            vl_rp = shortVlrOtroTransp_rp+x_rp;

            lengthRadio_rp = div_copy_rp.children().find('input[type=radio]').attr('id').length;
            shortNameRadio_rp = nameFieldRadio_rp.substr(0,lengthRadio_rp-1);
            //  y_rp=shortNameInput_rp+x_rp;
            w_rp=shortNameRadio_rp+x_rp;

            //  classError_rp = "form-control @error('"+y_rp+"') is-invalid @enderror";
            
            div_copy_rp.children().find('select').attr('onchange','otroTransporte(this.value,'+x_rp+')')
            
            // div_copy_rp.children().find('input[type=text]').first().attr('readonly', 'readonly');
            div_copy_rp.children().find('input[type=text]').first().attr('id', o_rp);
            div_copy_rp.children().find('input[type=text]').first().attr('name', o_rp);
            
            div_copy_rp.children().find('input[type=text]').eq(1).attr('id', vl_rp);
            div_copy_rp.children().find('input[type=text]').eq(1).attr('name', vl_rp);
            // div_copy_rp.children().find('input[type=text]').eq(4).val("vl_rp");
            // div_copy_rp.children().find('input[type=text]').eq(1).removeAttr('disabled');

            div_copy_rp.children().find('input[type=radio]').attr('id', w_rp);
            div_copy_rp.children().find('input[type=radio]').attr('name', w_rp);
            //  div_copy_rp.children().find('input[type=text]').attr('class', "form-control");
            div_copy_rp.children().find('input[type=text]').val("");
            
            
            $("#transporte_rp").append(div_copy_rp);
            
         }
         
    });

    $('#transporte_rp').on('click', '.remove_field_rp', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().parent().remove();
            x_rp--;
            // y_rp=shortNameInput_rp+x_rp;
            w_rp=shortNameRadio_rp+x_rp;
            classError_rp = "form-control @error('"+y_rp+"') is-invalid @enderror";
            	
            div_copy_rp.children().find('input[type=radio]').attr('id', w_rp);
            div_copy_rp.children().find('input[type=radio]').attr('name', w_rp);
            // div_copy_rp.children().find('input[type=text]').attr('class', "form-control");
            // // div_copy_rp.children().find('input[type=text]').val("");
        
    });
    /*transporte ruta principal - rp Proyección*/

    /*transporte ruta alterna - ra Proyección*/
    $(addButton_ra).click(function(e){
        e.preventDefault();

         if(x_ra < maxField_ra)
         {
            div_copy_ra = $('#transporte_ra_children').clone();
            div_copy_ra.children().find('span').remove();
            div_copy_ra.children().find('input[type=text]').removeAttr('required');
            div_copy_ra.children().find('a').attr('id','remove_field_ra');
            div_copy_ra.children().find('a').attr('class','remove_field_ra imgButton');
            div_copy_ra.children().find('a').attr('title','Remove field');
            div_copy_ra.children().find('img').attr('src','/img/remove-icon.png');
             
            x_ra++;

            nameOtroTransp_ra = div_copy_ra.children().find('input[type=text]').first().attr('id');
            lengthOtroTransp_ra = div_copy_ra.children().find('input[type=text]').first().attr('id').length;
            shortNameOtroTransp_ra = nameOtroTransp_ra.substr(0,lengthOtroTransp_ra-1);
            o_ra = shortNameOtroTransp_ra+x_ra;

            vlrOtroTransp_ra = div_copy_ra.children().find('input[type=text]').eq(1).attr('id');
            lengthVlrOtroTransp_ra = div_copy_ra.children().find('input[type=text]').eq(1).attr('id').length;
            shortVlrOtroTransp_ra = vlrOtroTransp_ra.substr(0,lengthVlrOtroTransp_ra-1);
            vl_ra = shortVlrOtroTransp_ra+x_ra;

            lengthRadio_ra = div_copy_ra.children().find('input[type=radio]').attr('id').length;
            shortNameRadio_ra = nameFieldRadio_ra.substr(0,lengthRadio_ra-1);

            //  y_ra=shortNameInput_ra+x_ra;
             w_ra=shortNameRadio_ra+x_ra;
            //  classError_ra = "form-control @error('"+y_ra+"') is-invalid @enderror";

            div_copy_ra.children().find('select').attr('onchange','otroTransporte2(this.value,'+x_ra+')')

            // div_copy_ra.children().find('input[type=text]').first().attr('readonly', 'readonly');
            div_copy_ra.children().find('input[type=text]').first().attr('id', o_ra);
            div_copy_ra.children().find('input[type=text]').first().attr('name', o_ra);

            div_copy_ra.children().find('input[type=text]').eq(1).attr('id', vl_ra);
            div_copy_ra.children().find('input[type=text]').eq(1).attr('name', vl_ra);
             
             div_copy_ra.children().find('input[type=radio]').attr('id', w_ra);
             div_copy_ra.children().find('input[type=radio]').attr('name', w_ra);
            //  div_copy_ra.children().find('input[type=text]').attr('class', "form-control");
             div_copy_ra.children().find('input[type=text]').val("");
            
            $("#transporte_ra").append(div_copy_ra);
            
         }
         
    });

    $('#transporte_ra').on('click', '.remove_field_ra', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().parent().remove();
            x_ra--;
            w_ra=shortNameRadio_ra+x_ra;
            // classError_ra = "form-control @error('"+y_ra+"') is-invalid @enderror";
            	
            div_copy_ra.children().find('input[type=radio]').attr('id', w_ra);
            div_copy_ra.children().find('input[type=radio]').attr('name', w_ra);
            // div_copy_ra.children().find('input[type=text]').attr('class', "form-control");
            // div_copy_ra.children().find('input[type=text]').val("");
        
    });
    /*transporte ruta alterna - ra Proyección*/
    
    $("#transp_rp_2").hide();
    $("#transp_rp_3").hide();

    /*transporte ruta alterna - ra edit Proyección*/
    $(addButton_edit_rp).click(function(e){
        e.preventDefault();

        $(this).show();

        //  if(x_edit_ra < maxField_edit_ra)
        //  {
        //      div_copy_edit_ra = $('#transporte_ra_children').clone();
        //      div_copy_edit_ra.children().find('span').remove();
        //      div_copy_edit_ra.children().find('input[type=text]').removeAttr('required');
        //      div_copy_edit_ra.children().find('a').attr('id','remove_field_ra');
        //      div_copy_edit_ra.children().find('a').attr('class','remove_field_edit_ra imgButton');
        //      div_copy_edit_ra.children().find('a').attr('title','Remove field');
        //      div_copy_edit_ra.children().find('img').attr('src','/img/remove-icon.png');
             
        //      x_edit_ra++;

        //      nameOtroTransp_edit_ra = div_copy_edit_ra.children().find('input[type=text]').first().attr('id');
        //      lengthOtroTransp_edit_ra = div_copy_edit_ra.children().find('input[type=text]').first().attr('id').length;
        //      shortNameOtroTransp_edit_ra = nameOtroTransp_edit_ra.substr(0,lengthOtroTransp_edit_ra-1);
        //      o_edit_ra = shortNameOtroTransp_edit_ra+x_edit_ra;

        //     lengthRadio_edit_ra = div_copy_edit_ra.children().find('input[type=radio]').attr('id').length;
        //     shortNameRadio_edit_ra = nameFieldRadio_edit_ra.substr(0,lengthRadio_edit_ra-1);

        //     //  y_edit_ra=shortNameInput_edit_ra+x_edit_ra;
        //      w_edit_ra=shortNameRadio_edit_ra+x_edit_ra;
        //     //  classError_edit_ra = "form-control @error('"+y_edit_ra+"') is-invalid @enderror";

        //     div_copy_edit_ra.children().find('select').attr('onchange','otroTransporte2(this.value,'+x_edit_ra+')')

        //     // div_copy_edit_ra.children().find('input[type=text]').first().attr('readonly', 'readonly');
        //     div_copy_edit_ra.children().find('input[type=text]').first().attr('id', o_edit_ra);
        //     div_copy_edit_ra.children().find('input[type=text]').first().attr('name', o_edit_ra);
             
        //      div_copy_edit_ra.children().find('input[type=radio]').attr('id', w_edit_ra);
        //      div_copy_edit_ra.children().find('input[type=radio]').attr('name', w_edit_ra);
        //     //  div_copy_edit_ra.children().find('input[type=text]').attr('class', "form-control");
        //      div_copy_edit_ra.children().find('input[type=text]').val("");
            
        //     $("#transporte_ra").append(div_copy_edit_ra);
            
        //  }
         
    });

    $('#transporte_ra').on('click', '.remove_field_ra', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().parent().remove();
            x_ra--;
            w_ra=shortNameRadio_ra+x_ra;
            // classError_ra = "form-control @error('"+y_ra+"') is-invalid @enderror";
            	
            div_copy_ra.children().find('input[type=radio]').attr('id', w_ra);
            div_copy_ra.children().find('input[type=radio]').attr('name', w_ra);
            // div_copy_ra.children().find('input[type=text]').attr('class', "form-control");
            // div_copy_ra.children().find('input[type=text]').val("");
        
    });
    /*transporte ruta alterna - ra edit Proyección*/

    /*espacios académicos - ea registro_user*/
    $(addButton_ea).click(function(e){
        e.preventDefault();

        lengthDiv_ea = $('#esp_aca').find('#esp_aca_children .row').toArray().length;
        // $('#esp_aca_children').find('input[type=text]').val(x_ea);
        x_ea = lengthDiv_ea;

         if(x_ea < maxField_ea)
         {
            div_copy_ea = $('#esp_aca_children').clone();
            // div_copy_ea.children().find('span').remove(); -->para usar el searchEspaAca_2
            div_copy_ea.children().find('input[type=text]').removeAttr('required');
            div_copy_ea.children().find('a').attr('id','remove_field_ea');
            div_copy_ea.children().find('a').attr('class','remove_field_ea imgButton');
            div_copy_ea.children().find('a').attr('title','Remove field');
            div_copy_ea.children().find('img').attr('src','/img/remove-icon.png');

            x_ea++;
            // lengthDiv_ea++;
            // div_copy_ea.children().find('input[type=text]').val(x_ea);
             
            nameEaFieldInput_ea = div_copy_ea.children().find('input[type=text]').attr('name');
            lengthInput_ea = div_copy_ea.children().find('input[type=text]').attr('name').length;
            shortNameInput_ea = nameEaFieldInput_ea.substr(0, lengthInput_ea-2);
            y_ea=shortNameInput_ea+x_ea;

            nameEa2FieldInput_ea = div_copy_ea.children().find('a').prev().attr('id');
            lengthInput_ea1 = div_copy_ea.children().find('a').prev().attr('id').length;
            shortNameInput_ea1 = nameEa2FieldInput_ea.substr(0, lengthInput_ea1-1);
            y_ea1=shortNameInput_ea1+x_ea;
            //  classError_ea = "form-control @error('"+y_ea+"') is-invalid @enderror";

            nameEaFieldSelect_ea = div_copy_ea.children().find('select').attr('id');
            lengthSelect_ea = div_copy_ea.children().find('select').attr('id').length;
            shortIdSelect_ea = nameEaFieldSelect_ea.substr(0,lengthSelect_ea-1);
            p_ea = shortIdSelect_ea+x_ea;

        //    var prueba = div_copy_ea.children().find('option:selected').val();
        //    var idSelect_ea = "#id_programa_academico_"+x_ea;

        //    var opt_ea = $(idSelect_ea).children().find('option:selected').val();

            //  div_copy_ea.children().find('input[type=text]').attr('class', "form-control");
            div_copy_ea.children().find('label').attr('id','id_espacio_academico_'+x_ea);
            div_copy_ea.children().find('select').attr('id', p_ea);
            div_copy_ea.children().find('select').attr('onchange','searchEspaAca_2('+x_ea+')');
            div_copy_ea.children().find('input[type=text]').attr('onchange','searchEspaAca(this.value,'+x_ea+')');
            div_copy_ea.children().find('a').prev().attr('id', y_ea1);
            div_copy_ea.children().find('a').prev().attr('name', y_ea1);
            
            div_copy_ea.children().find('input[type=text]').val("");
            div_copy_ea.children().find('a').prev().val("");
            
            $('#esp_aca').append(div_copy_ea);
            
         }
         
    });

    $('#esp_aca').on('click', '.remove_field_ea', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().remove();
            x_ea--;
            
    //      classError_ra = "form-control @error('"+y_ra+"') is-invalid @enderror";

    //       div_copy_ra.children().find('input[type=text]').attr('class', "form-control");
            // div_copy_ra.children().find('input[type=text]').val("");
        
    });

    // Presupuesto programa academico
    if(form == "edit_solicitud"){
        const presupuestoInput = document.getElementById('presupuesto_restante');
        const presupuesto_restante = presupuestoInput ? presupuestoInput.value : null;
        if (presupuesto_restante !== null) {
            const lblpractica = document.getElementById('lblpractica');
            presupuesto_restante_format = Number(presupuesto_restante.replace(/[$.\s]/g, ''));
            console.log(presupuesto_restante_format);
            const radio_aprobacion_coordinador = document.querySelector('input[name="aprobacion_coordinador"][value="7"]');
            
            if(presupuesto_restante_format < 0){
                radio_aprobacion_coordinador.disabled = true;
                lblpractica.removeAttribute('hidden');
            } 
        }        
    }   
    // Presupuesto programa academico
    
    // Deshabilitar inputs de rutas cuando se selecciona un radio button
    if(form == "create_proyeccion_form" || form == "edit_proyeccion"){
        // Ruta principal
        const inputDestino_rp = document.getElementById('destino_rp');
        const inputCant_url_rp = document.getElementById('cant_url_rp');
        const inputCant_url_ruta_rp = document.getElementById('ruta_principal');
        const inputCant_detalle_recorrido_rp = document.getElementById('det_recorrido_interno_rp');
        const radioSi_rp = document.querySelector('input[name="realizada_bogota_rp"][value="1"]');
        const radioNo_rp = document.querySelector('input[name="realizada_bogota_rp"][value="0"]');
        inputDestino_rp.disabled = true;
        inputCant_url_rp.disabled = true;
        inputCant_url_ruta_rp.disabled = true;
        inputCant_detalle_recorrido_rp.disabled = true;

        if(radioSi_rp.checked || radioNo_rp.checked){
            inputDestino_rp.disabled = false;
            inputCant_url_rp.disabled = false;
            inputCant_url_ruta_rp.disabled = false;
            inputCant_detalle_recorrido_rp.disabled = false;
        }
        const toggleInput_rp = () => {
            if (radioSi_rp.checked || radioNo_rp.checked) {
                inputDestino_rp.disabled = false;
                inputCant_url_rp.disabled = false;
                inputCant_url_ruta_rp.disabled = false;
                inputCant_detalle_recorrido_rp.disabled = false;
            } else {
                inputDestino_rp.disabled = true;
                inputCant_url_rp.disabled = true;
                inputCant_url_ruta_rp.disabled = true;
                inputCant_detalle_recorrido_rp.disabled = true;
            }
        };

        radioSi_rp.addEventListener('change', toggleInput_rp);
        radioNo_rp.addEventListener('change', toggleInput_rp);

        // Ruta alterna
        const inputDestino_ra = document.getElementById('destino_ra');
        const inputCant_url_ra = document.getElementById('cant_url_ra');
        const inputCant_url_ruta_ra = document.getElementById('ruta_alterna');
        const inputCant_detalle_recorrido_ra = document.getElementById('det_recorrido_interno_ra');
        const radioSi_ra = document.querySelector('input[name="realizada_bogota_ra"][value="1"]');
        const radioNo_ra = document.querySelector('input[name="realizada_bogota_ra"][value="0"]');
        inputDestino_ra.disabled = true;
        inputCant_url_ra.disabled = true;
        inputCant_url_ruta_ra.disabled = true;
        inputCant_detalle_recorrido_ra.disabled = true;

        const toggleInput_ra = () => {
            if (radioSi_ra.checked || radioNo_ra.checked) {
                inputDestino_ra.disabled = false;
                inputCant_url_ra.disabled = false;
                inputCant_url_ruta_ra.disabled = false;
                inputCant_detalle_recorrido_ra.disabled = false;
            } else {
                inputDestino_ra.disabled = true;
                inputCant_url_ra.disabled = true;
                inputCant_url_ruta_ra.disabled = true;
                inputCant_detalle_recorrido_ra.disabled = true;
            }
        };

        radioSi_ra.addEventListener('change', toggleInput_ra);
        radioNo_ra.addEventListener('change', toggleInput_ra);
    }

    $(addButton_ea_edit).click(function(e){
        e.preventDefault();

        lengthDiv_ea = $('#esp_aca').find('#esp_aca_children .row').toArray().length;
        // $('#esp_aca_children').find('input[type=text]').val(x_ea);
        x_ea = lengthDiv_ea;

         if(x_ea < maxField_ea)
         {

               var f= $('#esp_aca_children_1');
               f.style.display = "Block";
        //     div_copy_ea = $('#esp_aca_children').clone();
        //     // div_copy_ea.children().find('span').remove(); -->para usar el searchEspaAca_2
        //     div_copy_ea.children().find('input[type=text]').removeAttr('required');
        //     div_copy_ea.children().find('a').attr('id','remove_field_ea_edit');
        //     div_copy_ea.children().find('a').attr('class','remove_field_ea_edit imgButton');
        //     div_copy_ea.children().find('a').attr('title','Remove field');
        //     div_copy_ea.children().find('img').attr('src','/img/remove-icon.png');

        //     x_ea++;
        //     // lengthDiv_ea++;
        //     // div_copy_ea.children().find('input[type=text]').val(x_ea);
             
        //     nameEaFieldInput_ea = div_copy_ea.children().find('input[type=text]').attr('name');
        //     lengthInput_ea = div_copy_ea.children().find('input[type=text]').attr('name').length;
        //     shortNameInput_ea = nameEaFieldInput_ea.substr(0, lengthInput_ea-2);
        //     y_ea=shortNameInput_ea+x_ea;

        //     nameEa2FieldInput_ea = div_copy_ea.children().find('a').prev().attr('id');
        //     lengthInput_ea1 = div_copy_ea.children().find('a').prev().attr('id').length;
        //     shortNameInput_ea1 = nameEa2FieldInput_ea.substr(0, lengthInput_ea1-1);
        //     y_ea1=shortNameInput_ea1+x_ea;
        //     //  classError_ea = "form-control @error('"+y_ea+"') is-invalid @enderror";

        //     nameEaFieldSelect_ea = div_copy_ea.children().find('select').attr('id');
        //     lengthSelect_ea = div_copy_ea.children().find('select').attr('id').length;
        //     shortIdSelect_ea = nameEaFieldSelect_ea.substr(0,lengthSelect_ea-1);
        //     p_ea = shortIdSelect_ea+x_ea;

        // //    var prueba = div_copy_ea.children().find('option:selected').val();
        // //    var idSelect_ea = "#id_programa_academico_"+x_ea;

        // //    var opt_ea = $(idSelect_ea).children().find('option:selected').val();

        //     //  div_copy_ea.children().find('input[type=text]').attr('class', "form-control");
        //     div_copy_ea.children().find('label').attr('id','id_espacio_academico_'+x_ea);
        //     div_copy_ea.children().find('select').attr('id', p_ea);
        //     div_copy_ea.children().find('select').attr('onchange','searchEspaAca_2('+x_ea+')');
        //     div_copy_ea.children().find('input[type=text]').attr('onchange','searchEspaAca(this.value,'+x_ea+')');
        //     div_copy_ea.children().find('a').prev().attr('id', y_ea1);
        //     div_copy_ea.children().find('a').prev().attr('name', y_ea1);
            
        //     div_copy_ea.children().find('input[type=text]').val("");
        //     div_copy_ea.children().find('a').prev().val("");
            
        //     $('#esp_aca').append(div_copy_ea);
            
         }
         
    });


    $('#esp_aca').on('click', '.remove_field_ea_edit', function(e){
        e.preventDefault();
       
        $(this).parent().parent().parent().remove();

            x_ea--;
            
    //      classError_ra = "form-control @error('"+y_ra+"') is-invalid @enderror";

    //       div_copy_ra.children().find('input[type=text]').attr('class', "form-control");
            // div_copy_ra.children().find('input[type=text]').val("");
        
    });
    /*espacios académicos - ea registro_user*/

});

/*Buscar Espacio Académico registro_user*/
function searchEspaAca(id, indice){

    var idSelect_pa = "#id_programa_academico_"+indice;
    var idSelected_pa = $(idSelect_pa).find('option:selected').val();
    var idInput_ea = $(idSelect_pa).next().next().find('input[type=text]').val();
    

    // if((idInput_ea == null))
    // {
    //     $("#espacio_academico_"+indice).val("Casilla de código académico vacía");
    //     $("#cod_espacio_academico_"+indice).next().next('input:text').css("border-color", "red");
    // }
    
    // if(idInput_ea != "")
    // {
        id_pa = idSelected_pa;
        url = '/buscar/espa_aca';
        opc = 1;

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: url,
            type: 'POST',
            cache: false,
            data: {'id':id, 'x':indice, 'id_pa':id_pa, 'opc':opc},                
            // beforeSend: function(xhr){
            // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            // },
            success:function(respu){
                console.log(respu);
                var nameEa = "#espacio_academico_"+indice;
                // var prog_a = $("#").val();
                $("#espacio_academico_"+indice).val(respu.espacio_academico);  
                $("#espacio_academico_"+indice).css("border-color", "#d1d3e2");
                $("#cod_espacio_academico_"+indice).next().next('input:text').css("border-color", "#d1d3e2");
                document.getElementById('submit_reg_user').disabled = false;

                if ( jQuery.isEmptyObject(respu) || respu == null) {
                    $("#espacio_academico_"+indice).val('Código no disponible para el programa seleccionado');
                    // $("#espacio_academico_"+indice).val('Código no esta disponible para el programa seleccionado');
                    // $("#espacio_academico_"+indice).css("border-color", "red");
                    $("#cod_espacio_academico_"+indice).next().next('input:text').css("border-color", "red");

                        //   $("#espacio_academico_"+indice).val(idInput_ea);  
                        document.getElementById('submit_reg_user').disabled = true;
                    
                }
                            
                },
                error: function(xhr, textStatus, thrownError) {
                
                }
        });
       
    // }
}

function searchEspaAca_2(indice){

    var idSelect_pa = "id_programa_academico_"+indice;
    var idSelected_pa = $("#"+idSelect_pa).find('option:selected').val();
    var idInput_ea = $("#cod_espacio_academico_"+indice).next().next('input:text').val();

    url = '/buscar/espa_aca';
    opc = 2;

    if((idInput_ea == "") || (idInput_ea == null))
    {
        $("#espacio_academico_"+indice).val("Código Académico vacío");
        $("#cod_espacio_academico_"+indice).next().next('input:text').css("border-color", "red");
        document.getElementById('submit_reg_user').disabled = true;
    }
    
    else{

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: url,
            type: 'POST',
            cache: false,
            data: {'id_ea':idInput_ea, 'x':indice, 'id_pa':idSelected_pa, 'opc':opc},                
            // beforeSend: function(xhr){
            // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            // },
            success:function(respu){
                console.log(respu);
                var nameEa = "#espacio_academico_"+indice;
            
                // $("#espacio_academico_"+indice).val(idInput_ea);  
                $("#espacio_academico_"+indice).val(respu.espacio_academico);  
                $("#espacio_academico_"+indice).css("border-color", "#d1d3e2");
                $("#cod_espacio_academico_"+indice).next().next('input:text').css("border-color", "#d1d3e2");
                document.getElementById('submit_reg_user').disabled = false;

                if ( jQuery.isEmptyObject(respu) || respu == null) {
                    //   $("#espacio_academico_"+indice).val('El código '+id+' no esta disponible para el programa académico');
                    $("#espacio_academico_"+indice).val('Código no disponible para el programa seleccionado');
                    // $("#espacio_academico_"+indice).css("border-color", "red");

                        //   $("#espacio_academico_"+indice).val(idInput_ea);  
                    document.getElementById('submit_reg_user').disabled = true;
                }
                            
                },
                error: function(xhr, textStatus, thrownError) {
                
                }
            
        });
    }   
}

/*Buscar Espacio Académico registro_user*/

/*Asociar Espacio Académico */
function recargarEspacios_aca(id,id_docen, edit)
{
    url = '/recargar/espa_aca';
    espa_aca = $("#id_espacio_academico");
    espa_aca_1 = $("#id_espa_aca_1");
    espa_aca_2 = $("#id_espa_aca_2");
    espa_aca_3 = $("#id_espa_aca_3");
    espa_aca_4 = $("#id_espa_aca_4");
    espa_aca_5 = $("#id_espa_aca_5");
    espa_aca_6 = $("#id_espa_aca_6");
    espa_aca_7 = $("#id_espa_aca_7");
    id_prog_aca = id;
    id_docen = id_docen;
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type:"POST",
        data:{'id_prog_aca':id_prog_aca, 'id_docen':id_docen},
        success:function(respu){
            // if ( jQuery.isEmptyObject(respu) || respu == null) {
                
                espa_aca.find('option').remove();
                espa_aca_1.find('option').remove();
                espa_aca_2.find('option').remove();
                espa_aca_3.find('option').remove();
                espa_aca_4.find('option').remove();
                espa_aca_5.find('option').remove();
                espa_aca_6.find('option').remove();
                espa_aca_7.find('option').remove();

                $(respu.respu).each( function(i,v){
                    espa_aca.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $("#pregrado").val(v.pregrado);
                })
                
                $(respu.respu2).each( function(i,v){
                    espa_aca_1.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    espa_aca_2.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    espa_aca_3.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    espa_aca_4.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    espa_aca_5.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    espa_aca_6.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    espa_aca_7.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                })

                calc_viaticos_RP();
            // }
            if(edit == 1)
            {
                espa_aca_1 = $("#id_espa_aca_1").val();
                recargarDocenEspaAca(espa_aca_1,1);

                espa_aca_2 = $("#id_espa_aca_2").val();
                recargarDocenEspaAca(espa_aca_2,2);

                espa_aca_3 = $("#id_espa_aca_3").val();
                recargarDocenEspaAca(espa_aca_3,3);

                espa_aca_4 = $("#id_espa_aca_4").val();
                recargarDocenEspaAca(espa_aca_4,4);

                espa_aca_5 = $("#id_espa_aca_5").val();
                recargarDocenEspaAca(espa_aca_5,5);

                espa_aca_6 = $("#id_espa_aca_6").val();
                recargarDocenEspaAca(espa_aca_6,6);

                espa_aca_7 = $("#id_espa_aca_7").val();
                recargarDocenEspaAca(espa_aca_7,7);
            }    
                            
            },
            error: function(xhr, textStatus, thrownError) {
            
            }
    });

    
}
/*Asociar Espacio Académico */

/*Asociar Espacio Académico edit*/
function recargarEspa_aca_edit(id,id_espa_aca,id_docen,edit)
{
    url = '/recargar/espa_edit';
    espa_aca = $("#id_espacio_academico");
    espa_aca_1 = $("#id_espa_aca_1");
    espa_aca_2 = $("#id_espa_aca_2");
    espa_aca_3 = $("#id_espa_aca_3");
    espa_aca_4 = $("#id_espa_aca_4");
    espa_aca_5 = $("#id_espa_aca_5");
    espa_aca_6 = $("#id_espa_aca_6");
    espa_aca_7 = $("#id_espa_aca_7");
    id_espa_aca_1 = $("#id_espa_aca_1").val();
    id_espa_aca_2 = $("#id_espa_aca_2").val();
    id_espa_aca_3 = $("#id_espa_aca_3").val();
    id_espa_aca_4 = $("#id_espa_aca_4").val();
    id_espa_aca_5 = $("#id_espa_aca_5").val();
    id_espa_aca_6 = $("#id_espa_aca_6").val();
    id_espa_aca_7 = $("#id_espa_aca_7").val();
    id_prog_aca = id;
    id_espa_aca = id_espa_aca;
    id_docen = id_docen;
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type:"POST",
        data:{'id_prog_aca':id_prog_aca,'id_espa_aca':id_espa_aca,'id_docen':id_docen},
        success:function(respu){
            // if ( jQuery.isEmptyObject(respu) || respu == null) {
                
                espa_aca.find('option').remove();
                espa_aca_1.find('option').remove();
                espa_aca_2.find('option').remove();
                espa_aca_3.find('option').remove();
                espa_aca_4.find('option').remove();
                espa_aca_5.find('option').remove();
                espa_aca_6.find('option').remove();
                espa_aca_7.find('option').remove();

                $(respu.respu).each( function(i,v){
                    espa_aca.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espacio_academico > option[value="'+id_espa_aca+'"]').attr('selected','selected');
                    $("#pregrado").val(v.pregrado);
                })

                $(respu.respu2).each( function(i,v){
                    espa_aca_1.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espa_aca_1 > option[value="'+id_espa_aca_1+'"]').attr('selected','selected');
                    espa_aca_2.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espa_aca_2 > option[value="'+id_espa_aca_2+'"]').attr('selected','selected');
                    espa_aca_3.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espa_aca_3 > option[value="'+id_espa_aca_3+'"]').attr('selected','selected');
                    espa_aca_4.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espa_aca_4 > option[value="'+id_espa_aca_4+'"]').attr('selected','selected');
                    espa_aca_5.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espa_aca_5 > option[value="'+id_espa_aca_5+'"]').attr('selected','selected');
                    espa_aca_6.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espa_aca_6 > option[value="'+id_espa_aca_6+'"]').attr('selected','selected');
                    espa_aca_7.append('<option value="' + v.id + '">' + v.espacio_academico +'</option>');
                    $('#id_espa_aca_7 > option[value="'+id_espa_aca_7+'"]').attr('selected','selected');

                })

                calc_viaticos_RP();
                
                if(edit == 1)
                {
                    espa_aca_1 = $("#id_espa_aca_1").val();
                    recargarDocenEspaAca(espa_aca_1,1);

                    espa_aca_2 = $("#id_espa_aca_2").val();
                    recargarDocenEspaAca(espa_aca_2,2);

                    espa_aca_3 = $("#id_espa_aca_3").val();
                    recargarDocenEspaAca(espa_aca_3,3);

                    espa_aca_4 = $("#id_espa_aca_4").val();
                    recargarDocenEspaAca(espa_aca_4,4);

                    espa_aca_5 = $("#id_espa_aca_5").val();
                    recargarDocenEspaAca(espa_aca_5,5);

                    espa_aca_6 = $("#id_espa_aca_6").val();
                    recargarDocenEspaAca(espa_aca_6,6);

                    espa_aca_7 = $("#id_espa_aca_7").val();
                    recargarDocenEspaAca(espa_aca_7,7);
                }
            // }
                            
            },
            error: function(xhr, textStatus, thrownError) {
            
            }
    });
}
/*Asociar Espacio Académico edit*/

/*Asociar docentes a espacios academicos integradas */
// $("#id_espa_aca_1").bind("DOMSubtreeModified", function() {
//     alert("tree changed");
// });

function recargarDocenEspaAca(input,indice)
{
    url = '/recargar/docen_espa';
    id_espa_aca = input;
    docen_espa_aca = $("#id_docen_espa_aca_"+indice);
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type:"POST",
        data:{'id_espa_aca':id_espa_aca},
        success:function(respu){
            // if ( jQuery.isEmptyObject(respu) || respu == null) {
                
                $("#id_docen_espa_aca_"+indice).find('option').remove();
                $(respu).each( function(i,v){
                    $("#id_docen_espa_aca_"+indice).append('<option value="' + v.id + '">' + v.full_name +'</option>');
                    // $('#id_docen_espa_aca_'+indice +'> option[value="'+v.id+'"]').attr('selected','selected');
                })
                
            // }
                            
            },
            error: function(xhr, textStatus, thrownError) {
            
            }
    });
}
/*Asociar docentes a espacios academicos integradas */

/*OtroTransporte Proyección*/
function otroTransporte(id, indice)
{
    // if(id != 5)
    // {
        $('#otro_transporte_rp_'+indice).attr('readonly', 'readonly');
        $('#otro_transporte_rp_'+indice).removeAttr('required');
        $('#otro_transporte_rp_'+indice).val("");

        $('#vlr_otro_transporte_rp_'+indice).attr('readonly', 'readonly');
        $('#vlr_otro_transporte_rp_'+indice).removeAttr('required');
        $('#vlr_otro_transporte_rp_'+indice).val("");
    // }

    // else if(id==5)
    // {
    //     $('#otro_transporte_rp_'+indice).attr('required','required');
    //     $('#otro_transporte_rp_'+indice).removeAttr('readonly');

    //     $('#vlr_otro_transporte_rp_'+indice).attr('required','required');
    //     $('#vlr_otro_transporte_rp_'+indice).removeAttr('readonly');
    // }
}

function otroTransporte2(id, indice)
{
    // if(id != 5)
    // {
        $('#otro_transporte_ra_'+indice).attr('readonly', 'readonly');
        $('#otro_transporte_ra_'+indice).removeAttr('required');
        $('#otro_transporte_ra_'+indice).val("");

        $('#vlr_otro_transporte_ra_'+indice).attr('readonly', 'readonly');
        $('#vlr_otro_transporte_ra_'+indice).removeAttr('required');
        $('#vlr_otro_transporte_ra_'+indice).val("");
    // }

    // else if(id==5)
    // {
    //     $('#otro_transporte_ra_'+indice).attr('required','required');
    //     $('#otro_transporte_ra_'+indice).removeAttr('readonly');

    //     $('#vlr_otro_transporte_ra_'+indice).attr('required','required');
    //     $('#vlr_otro_transporte_ra_'+indice).removeAttr('readonly');
    // }
}

/*OtroTransporte Proyección*/

/*Bloquear input number proyección*/
$("#cant_grupos").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

$("#cant_grupos_edit").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

/*Bloquear input number proyección*/


/*Bloquear input number acompa proyección*/
$("#num_acompaniantes").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

// $("#cant_grupos_edit").keypress(function (e) {
//     e.preventDefault();
// }).keydown(function(e){
//     if ( e.keyCode === 8 || e.keyCode === 46 ) {
//         return false;
//     }
// });

/*Bloquear input number acompa proyección*/

/*Bloquear input number apoyo proyección*/
$("#num_apoyo").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

// $("#cant_grupos_edit").keypress(function (e) {
//     e.preventDefault();
// }).keydown(function(e){
//     if ( e.keyCode === 8 || e.keyCode === 46 ) {
//         return false;
//     }
// });

/*Bloquear input number apoyo proyección*/

/*Bloquear input number docentes apoyo proyección*/
$("#num_docentes_apoyo").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

// $("#cant_grupos_edit").keypress(function (e) {
//     e.preventDefault();
// }).keydown(function(e){
//     if ( e.keyCode === 8 || e.keyCode === 46 ) {
//         return false;
//     }
// });

/*Bloquear input number docentes num_docentes_apoyoapoyo proyección*/

/*Bloquear input cant vehic proyección*/
$("#cant_transporte_rp").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

$("#cant_transporte_ra").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});
/*Bloquear input cant vehic proyección*/

/*Bloquear input cant url proyección*/
$("#cant_url_rp").keypress(function (e){
    e.preventDefault();
}).keydown(function (e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

$("#cant_url_ra").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

/*Bloquear input cant url proyección*/

/*Bloquear input cant transporte menor*/
$("#cant_trans_menor_rp").keypress(function (e){
    e.preventDefault();
}).keydown(function (e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

$("#cant_trans_menor_ra").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

/*Bloquear input cant transporte menor*/

/*Bloquear input cant espa aca user*/
$("#c_espa_aca_user").keypress(function (e) {
    e.preventDefault();
}).keydown(function(e){
    if ( e.keyCode === 8 || e.keyCode === 46 ) {
        return false;
    }
});

/*Bloquear input cant espa aca user*/

/* programa académico coordinador */
function progr_aca_coord(id)
{
    if(id != 4)
    {
        $("#id_programa_academico_coord").attr('readonly', 'readonly');
        $("#id_programa_academico_coord").attr('disabled', 'disabled');
        $("#id_programa_academico_coord").val(999);
    }
    else if(id == 4)
    {
        
        $("#id_programa_academico_coord").removeAttr('readonly','readonly');
        $("#id_programa_academico_coord").removeAttr('disabled','disabled');
        // $("#id_programa_academico_coord").attr('readonly', 'readonly');

    }
}
/* programa académico coordinador */

/* duracion RP - RA */
function duracionRP(dateText)
{
    var fecha_salida = new Date($('#fecha_salida_aprox_rp').val());
    var fecha_regreso = new Date($('#fecha_regreso_aprox_rp').val()); 
    var milis_dias = 86400000;
    var dif_milis = fecha_regreso - fecha_salida;
    if(isNaN(dif_milis))
    {
        dif_milis = 0;
    }
    var dif_dias = dif_milis / milis_dias + 1;

    if(Math.sign(dif_dias) == -1 || Math.sign(dif_dias) == -0)
    {
        dif_dias = 0;
    }

    $('#duracion_rp').val(dif_dias);

    calc_viaticos_RP();
    
}


function calc_viaticos_RP()
{
    
    var vlr_min_viat_estud = $("#vlr_estud_min").val();
    var vlr_min_viat_doce = $("#vlr_docen_min").val();
    var vlr_max_viat_estud = $("#vlr_estud_max").val();
    var vlr_max_viat_doce = $("#vlr_docen_max").val();
    var pregrado = $("#pregrado").val();
    id_prog_aca = $("#id_programa_academico").val();
    id_espa_aca = $("#id_espacio_academico").val();
    id_docen = $("#num_docen").attr('name');
    url = '/buscar/viaticos';

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type:"POST",
        data:{'id_prog_aca':id_prog_aca,'id_espa_aca':id_espa_aca,'id_docen':id_docen},
        success:function(respu){
            if ( jQuery.isEmptyObject(respu) || respu == null) 
            {
                
                var vlr_min_viat_estud = $("#vlr_estud_min").val();
                var vlr_min_viat_doce = $("#vlr_docen_min").val();
                var vlr_max_viat_estud = $("#vlr_estud_max").val();
                var vlr_max_viat_doce = $("#vlr_docen_max").val();
                var pregrado = $("#pregrado").val();
                
            }
            else if( !jQuery.isEmptyObject(respu) || respu != null)
            {
                vlr_min_viat_estud = respu.respu.vlr_estud_min;
                vlr_max_viat_estud = respu.respu.vlr_estud_max;
                vlr_min_viat_doce = respu.respu.vlr_docen_min;
                vlr_max_viat_doce = respu.respu.vlr_docen_max;
                pregrado = respu.respu2.pregrado;
            }
                            
            },
            error: function(xhr, textStatus, thrownError) {
            
            }
    });

    var fecha_salida = new Date($('#fecha_salida_aprox_rp').val());
    var fecha_regreso = new Date($('#fecha_regreso_aprox_rp').val()); 
    var milis_dias = 86400000;
    var dif_milis = fecha_regreso - fecha_salida;
    if(pregrado == "" || pregrado == null)
    {
        pregrado = 0;
    }

    if(isNaN(dif_milis))
    {
        dif_milis = 0;
    }
    var dif_dias = dif_milis / milis_dias + 1;

    // $('#duracion_rp').val(dif_dias);

    var fecha_salida_ra = new Date($('#fecha_salida_aprox_ra').val());
    var fecha_regreso_ra = new Date($('#fecha_regreso_aprox_ra').val()); 
    var milis_dias_ra = 86400000;
    var dif_milis_ra = fecha_regreso_ra - fecha_salida_ra;
    if(isNaN(dif_milis_ra))
    {
        dif_milis_ra = 0;
    }
    var dif_dias_ra = dif_milis_ra / milis_dias_ra + 1;

    num_estud = $('#num_estudiantes_aprox').val();
    prac_integrada = $("#integrada").is(':checked');

    // Habilitar viáticos a 0 cuando no se usa transporte para rutas principales y/o alternar
    var cant_trans_rp = parseInt($('#cant_transporte_rp').val());
    var cant_trans_ra = parseInt($('#cant_transporte_ra').val());

    switch(prac_integrada)
    {
        case true:
            cant_int = $("#cant_espa_aca").val();

            break;
        case false:
            cant_int = 0;
            break;
    }

    total_doc_apoyo = $('#total_docentes_apoyo').val();
    pers_apoyo = $('#num_apoyo').val();
    num_doc_apoyo = parseInt(cant_int) + parseInt(total_doc_apoyo);

    if(num_doc_apoyo == "" || num_doc_apoyo == undefined)
    {
        num_doc_apoyo = 0;
    }
    total_docentes = parseInt(num_doc_apoyo) + 1;

    if(Math.sign(dif_dias) == -1 || Math.sign(dif_dias) == -0)
    {
        dif_dias = 0;
    }

    if(dif_dias > 1)
    {
        viaticos_apoyo_doc_rp = (dif_dias-0.5)*(vlr_max_viat_doce*total_docentes);
        viaticos_apoyo_doc_rp_format = (new Intl.NumberFormat("es-CO").format(viaticos_apoyo_doc_rp));

        if(pregrado == 1)
        {
            viaticos_apoyo_estud_rp = num_estud*vlr_max_viat_estud*dif_dias;
            viaticos_apoyo_estud_rp_format = (new Intl.NumberFormat("es-CO").format(viaticos_apoyo_estud_rp));
        }
        else
        {
            viaticos_apoyo_estud_rp_format  = (new Intl.NumberFormat("es-CO").format(0));
        }
	// if transport equals 0
	if(cant_trans_rp == 0)
	{
	   viaticos_apoyo_doc_rp_format = (new Intl.NumberFormat("es-CO").format(0));
	   viaticos_apoyo_estud_rp_format = (new Intl.NumberFormat("es-CO").format(0));
	}

        // formatVlr(viaticos_apoyo_estud_rp_format);
        $("#vlr_apoyo_docentes_rp").val(viaticos_apoyo_doc_rp_format);
        $("#vlr_apoyo_estudiantes_rp").val(viaticos_apoyo_estud_rp_format);
    }
    else if(dif_dias==1)
    {
        viaticos_apoyo_doc_rp = vlr_min_viat_doce;
        if(pregrado == 1)
        {
            viaticos_apoyo_estud_rp = num_estud*vlr_min_viat_estud*dif_dias;
            viaticos_apoyo_estud_rp_format = (new Intl.NumberFormat("es-CO").format(viaticos_apoyo_estud_rp));
        }
        else
        {
            viaticos_apoyo_estud_rp_format  = (new Intl.NumberFormat("es-CO").format(0));
        }
        var bogota_rp= document.querySelector('input[name="realizada_bogota_rp"][value="1"]');
        if(bogota_rp){
            if(bogota_rp.checked){
                viaticos_apoyo_estud_rp_format  = (new Intl.NumberFormat("es-CO").format(0));
            }
        }
        if(cant_trans_rp == 0)
        {
           viaticos_apoyo_doc_rp = (new Intl.NumberFormat("es-CO").format(0));
           viaticos_apoyo_estud_rp_format = (new Intl.NumberFormat("es-CO").format(0));
        }

        $("#vlr_apoyo_docentes_rp").val(viaticos_apoyo_doc_rp);
        $("#vlr_apoyo_estudiantes_rp").val(viaticos_apoyo_estud_rp_format);

    }
    else if(dif_dias == 0)
    {
        $("#vlr_apoyo_docentes_rp").val(0);
        $("#vlr_apoyo_estudiantes_rp").val(0);
    }

    
    if(Math.sign(dif_dias_ra) == -1 || Math.sign(dif_dias_ra) == -0)
    {
        dif_dias_ra = 0;
    }
    if(dif_dias_ra > 1)
    {
        viaticos_apoyo_doc_ra = (dif_dias_ra-0.5)*(vlr_max_viat_doce*total_docentes);
        viaticos_apoyo_doc_ra_format = (new Intl.NumberFormat("es-CO").format(viaticos_apoyo_doc_ra));

        if(pregrado == 1)
        {
            viaticos_apoyo_estud_ra = num_estud*vlr_max_viat_estud*dif_dias_ra;
            viaticos_apoyo_estud_ra_format = (new Intl.NumberFormat("es-CO").format(viaticos_apoyo_estud_ra));
        }
        else
        {
            viaticos_apoyo_estud_ra_format  = (new Intl.NumberFormat("es-CO").format(0));
        }

        if(cant_trans_ra == 0)
        {
           viaticos_apoyo_doc_ra_format = (new Intl.NumberFormat("es-CO").format(0));
           viaticos_apoyo_estud_ra_format = (new Intl.NumberFormat("es-CO").format(0));
        }

        $("#vlr_apoyo_docentes_ra").val(viaticos_apoyo_doc_ra_format);
        $("#vlr_apoyo_estudiantes_ra").val(viaticos_apoyo_estud_ra_format);
    }
    else if(dif_dias_ra == 1)
    {
        viaticos_apoyo_doc_ra = vlr_min_viat_doce;

        if(pregrado == 1)
        {
            viaticos_apoyo_estud_ra = num_estud*vlr_min_viat_estud*dif_dias_ra;
            viaticos_apoyo_estud_ra_format = (new Intl.NumberFormat("es-CO").format(viaticos_apoyo_estud_ra));
        }
        else
        {
            viaticos_apoyo_estud_ra_format  = (new Intl.NumberFormat("es-CO").format(0));
        }
        var bogota_ra= document.querySelector('input[name="realizada_bogota_ra"][value="1"]');
        if(bogota_ra){
            if(bogota_ra.checked){
                viaticos_apoyo_estud_ra_format  = (new Intl.NumberFormat("es-CO").format(0));
            }
        }
        

        if(cant_trans_ra == 0)
        {
           viaticos_apoyo_doc_ra = (new Intl.NumberFormat("es-CO").format(0));
           viaticos_apoyo_estud_ra_format = (new Intl.NumberFormat("es-CO").format(0));
        }

        $("#vlr_apoyo_docentes_ra").val(viaticos_apoyo_doc_ra);
        $("#vlr_apoyo_estudiantes_ra").val(viaticos_apoyo_estud_ra_format);
    }
    else if(dif_dias_ra == 0)
    {
        $("#vlr_apoyo_docentes_ra").val(0);
        $("#vlr_apoyo_estudiantes_ra").val(0);
    }
    
}

function duracionRP2(dateText)
{
    var fecha_salida = new Date($('#fecha_salida_aprox_rp').val());
    var fecha_regreso = new Date($('#fecha_regreso_aprox_rp').val()); 
    var milis_dias = 86400000;
    var dif_milis = fecha_regreso - fecha_salida;
    var pregrado = $("#pregrado").val();

    if(isNaN(dif_milis))
    {
        dif_milis = 0;
    }
    var dif_dias = dif_milis / milis_dias + 1;

    if(Math.sign(dif_dias) == -1 || Math.sign(dif_dias) == -0)
    {
        dif_dias = 0;
    }

    $('#duracion_rp').val(dif_dias);
    calc_viaticos_RP();
}

function duracionRA(dateText)
{
    var fecha_salida = new Date($('#fecha_salida_aprox_ra').val());
    var fecha_regreso = new Date($('#fecha_regreso_aprox_ra').val()); 
    var milis_dias = 86400000;
    var dif_milis = fecha_regreso - fecha_salida;
    if(isNaN(dif_milis))
    {
        dif_milis = 0;
    }
    var dif_dias = dif_milis / milis_dias + 1;

    if(Math.sign(dif_dias) == -1 || Math.sign(dif_dias) == -0)
    {
        dif_dias = 0;
    }

    $('#duracion_ra').val(dif_dias);

    calc_viaticos_RP();
}

function duracionRA2(dateText)
{
    var fecha_salida = new Date($('#fecha_salida_aprox_ra').val());
    var fecha_regreso = new Date($('#fecha_regreso_aprox_ra').val()); 
    var milis_dias = 86400000;
    var dif_milis = fecha_regreso - fecha_salida;
    if(isNaN(dif_milis))
    {
        dif_milis = 0;
    }
    var dif_dias = dif_milis / milis_dias + 1;

    if(Math.sign(dif_dias) == -1 || Math.sign(dif_dias) == -0)
    {
        dif_dias = 0;
    }


    $('#duracion_ra').val(dif_dias);

    calc_viaticos_RP();
}

/*view edit duracion RP - RA */
function duracion_edit_RP(dateText)
{
    var fecha_salida = new Date($('#fecha_salida_aprox_rp').val());
    var fecha_regreso = new Date($('#fecha_regreso_aprox_rp').val()); 
    var milis_dias = 86400000;
    var dif_milis = fecha_regreso - fecha_salida;
    if(isNaN(dif_milis))
    {
        dif_milis = 0;
    }
    var dif_dias = dif_milis / milis_dias + 1;

    if(Math.sign(dif_dias) == -1 || Math.sign(dif_dias) == -0)
    {
        dif_dias = 0;
    }

    // $('#duracion_edit_rp').val("");
    $('#duracion_edit_rp').val(dif_dias);
    calc_viaticos_RP();
}

function duracion_edit_RA(dateText)
{
    var fecha_salida = new Date($('#fecha_salida_aprox_ra').val());
    var fecha_regreso = new Date($('#fecha_regreso_aprox_ra').val()); 
    var milis_dias = 86400000;
    var dif_milis = fecha_regreso - fecha_salida;
    if(isNaN(dif_milis))
    {
        dif_milis = 0;
    }
    var dif_dias = dif_milis / milis_dias + 1;

    if(Math.sign(dif_dias) == -1 || Math.sign(dif_dias) == -0)
    {
        dif_dias = 0;
    }

    // $('#duracion_edit_ra').val("");
    $('#duracion_edit_ra').val(dif_dias);
    calc_viaticos_RP();
}
/*view edit duracion RP - RA */

/* validar proyeccion electiva*/

function validar_proy_electiva()
{
    // confirm("Una ó más proyecciones preliminares seleccionadas cuentan espacios académico con práctica electiva registrada, ¿Desea continuar de igual manera?");
    var check_confirm = [];
    $('input[type=checkbox]:checked').each(function()
    {
       
        check_confirm.push(this.value);
    });

    url = '/proyecc_electiva';

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type: 'POST',
        cache: false,
        data: {'data':check_confirm},                
        // beforeSend: function(xhr){
        // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        // },
        success:function(respu){
            console.log(respu);

            if(respu.length >= 1)
            {
               var r = confirm("Una ó más proyecciones preliminares seleccionadas cuentan espacios académico con práctica electiva registrada, ¿Desea continuar de igual manera?");
               if(r == true)
               {
                 confirm_proy();
               }
               else
               {
                    alert("Las proyecciones que cuentan con espacios académicos que resgistran práctica electiva son: "+respu);
               }
            }
            else if(respu.length == 0)
            {
                confirm_proy();
            }
            if ( jQuery.isEmptyObject(respu) || respu == null) {
                
            }
                            
            },
            error: function(xhr, textStatus, thrownError) {
                
            }
        });
}

/* enviar confirmacion proyeccion*/
function confirm_proy()
{
    
    var check_confirm = [];
    $('input[type=checkbox]:checked').each(function()
    {
        if(this.value != "")
        {

            check_confirm.push(this.value);
        }
    });
    // $('#nefy').val(check_confirm);
    url = '/proyeccsend';

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type: 'PUT',
        cache: false,
        data: {'data':check_confirm},                
        // beforeSend: function(xhr){
        // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        // },
        success:function(respu){
            console.log(respu);

            window.location.replace(respu);
            if ( jQuery.isEmptyObject(respu) || respu == null) {
                // $("#resp_consulta").val('Código no disponible para el programa seleccionado');
            }
                            
            },
            error: function(xhr, textStatus, thrownError) {
                
            }
        });
}
/* enviar confirmacion proyeccion*/

/* enviar visto bueno decanatura proyeccion*/
function vb_proy()
{
    
    var check_confirm = [];
    $('input[type=checkbox]:checked').each(function()
    {
        if(this.value != "")
        {

            check_confirm.push(this.value);
        }
    });
    // $('#nefy').val(check_confirm);
    url = '/proyecc_vb';

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type: 'PUT',
        cache: false,
        data: {'data':check_confirm},                
        // beforeSend: function(xhr){
        // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        // },
        success:function(respu){
            console.log(respu);

            window.location.replace(respu);
            if ( jQuery.isEmptyObject(respu) || respu == null) {
                // $("#resp_consulta").val('Código no disponible para el programa seleccionado');
            }
                            
            },
            error: function(xhr, textStatus, thrownError) {
                
            }
        });
}
/* enviar visto bueno decanatura proyeccion*/

/* dar formato keyup*/
function formatVlr(input)
{
    var num = input.value.replace(/\./g,'');
    if(!isNaN(num)){
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');
    input.value = num;
    }
     
    else{ alert('Solo se permiten números');
    input.value = input.value.replace(/[^\d\.]*/g,'');
    }
}

function formatNmb(input)
{
    var num = input.value.replace(/\./g,'');
    num = num.trim();
    if(!isNaN(num)){
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');
    $(input).val(num);
    }
     
    else{ alert('Solo se permiten números');
    input.value = input.value.replace(/[^\d]*/g,'');
    }
}

function onlyNmb(input)
{
    var num = input.value.replace(/\./g,'');
    num = num.trim();
    if(!isNaN(num)){
        num = num.replace(/[^\d]*/g,'');
        $(input).val(num);
    }   
    else{ alert('Solo se permiten números');
        input.value = input.value.replace(/[^\d]*/g,'');
    }
}

/* Aviso toggle switch*/
function customAlerts(input, type, resp)
{
    if($(input).is(':checked'))
    {
        var name = input.name;
        $("#textModal").text("Cuenta con un plan de contingencia basado en la matriz de riesgos?");
        $("#textModal").css("text-align","justify");
        $("#myModal").modal({backdrop: 'static', show: true, keyboard: false});
        $("#type").val(type);
        $("#resp").val(resp);
        // $('#myModal').modal({backdrop: 'static', keyboard: false});
        $("#modal-btn-no").on("click", function(){
            var type = $("#type").val();
            var resp = $("#resp").val();
            $("#myModal").modal("hide");

            if(type == 1)
            {
                switch(resp)
                {
                    case "1":
                        inputResp = $("#areas_acuaticas_rp");
                        $(inputResp).prop('checked', false);
                        break;
                    case "2":
                        inputResp = $("#alturas_rp");
                        $(inputResp).prop('checked', false);
                        break;
                    case "3":
                        inputResp = $("#riesgo_biologico_rp");
                        $(inputResp).prop('checked', false);
                        break;
                    case "4":
                        inputResp = $("#espacios_confinados_rp");
                        $(inputResp).prop('checked', false);
                        break;
                }
            }
            else if(type == 2)
            {
                switch(resp)
                {
                    case "1":
                        inputResp = $("#areas_acuaticas_ra");
                        $(inputResp).prop('checked', false);
                        break;
                    case "2":
                        inputResp = $("#alturas_ra");
                        $(inputResp).prop('checked', false);
                        break;
                    case "3":
                        inputResp = $("#riesgo_biologico_ra");
                        $(inputResp).prop('checked', false);
                        break;
                    case "4":
                        inputResp = $("#espacios_confinados_ra");
                        $(inputResp).prop('checked', false);
                        break;
                }
            }
        });

        $("#modal-btn-si").on("click", function(){
            $("#myModal").modal("hide");
            // $(input).prop('checked', false);
        });
 
    }
}
/* Aviso toggle switch*/

/* documentaciòn adicional toggle switch*/
$("#cert_adic_1_lb").hide();
$("#cert_adic_1").hide();
$("#cert_adic_2_lb").hide();
$("#cert_adic_2").hide();
$("#cert_adic_3_lb").hide();
$("#cert_adic_3").hide();

function documAdicional(input,type)
{
    if($(input).is(':checked'))
    {
        switch(type)
        {
            case 1:
                $("#cert_adic_1_lb").show();
                $("#cert_adic_1").show();
                break;
            case 2:
                $("#cert_adic_2_lb").show();
                $("#cert_adic_2").show();
                break;
            case 3:
                $("#cert_adic_3_lb").show();
                $("#cert_adic_3").show();
                break;
        }
    }
    else{
        switch(type)
        {
            case 1:
                $("#cert_adic_1_lb").hide();
                $("#cert_adic_1").hide();
                break;
            case 2:
                $("#cert_adic_2_lb").hide();
                $("#cert_adic_2").hide();
                break;
            case 3:
                $("#cert_adic_3_lb").hide();
                $("#cert_adic_3").hide();
                break;
        }
    }
}
/* documentaciòn adicional toggle switch*/

function validar_proy_estudiantes()
{
    // confirm("Una ó más proyecciones preliminares seleccionadas cuentan espacios académico con práctica electiva registrada, ¿Desea continuar de igual manera?");
    var check_confirm = [];
    $('input[type=checkbox]:checked').each(function()
    {
        check_confirm.push(this.value);
    });

    url = '/proyecc_electiva';

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type: 'POST',
        cache: false,
        data: {'data':check_confirm},                
        // beforeSend: function(xhr){
        // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        // },
        success:function(respu){
            console.log(respu);

            if(respu.length >= 1)
            {
               var r = confirm("Una ó más proyecciones preliminares seleccionadas cuentan espacios académico con práctica electiva registrada, ¿Desea continuar de igual manera?");
               if(r == true)
               {
                 confirm_proy();
               }
               else
               {
                    alert("Las proyecciones que cuentan con espacios académicos que resgistran práctica electiva son: "+respu);
               }
            }
            else if(respu.length == 0)
            {
                confirm_proy();
            }
            if ( jQuery.isEmptyObject(respu) || respu == null) {
                
            }
                            
            },
            error: function(xhr, textStatus, thrownError) {
                
            }
        });
}

/* seleccionar solicitudes a exportar*/
function export_solicitud()
{
    
    var check_confirm = [];
    $('input[type=checkbox]:checked').each(function()
    {
        check_confirm.push(this.value);
    });
    // $('#nefy').val(check_confirm);
    url = '/exp_solicit_list_excel';

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type: 'GET',
        cache: false,
        data: {'data':check_confirm},                
        // beforeSend: function(xhr){
        // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        // },
        success:function(respu){
            console.log(respu);

            window.location = page;
            // if ( jQuery.isEmptyObject(respu) || respu == null) {
            //     // $("#resp_consulta").val('Código no disponible para el programa seleccionado');
            // }
                            
            },
            error: function(xhr, textStatus, thrownError) {
                
            }
        });
}


function total_sel_pend()
{
    var estado = $('#sel_proy_pend').prop('checked');
    if(estado == true)
    {
        for (i=0;i<document.proy_pend.elements.length;i++)
        {
    
            if(document.proy_pend.elements[i].type == "checkbox")
            {
        
                document.proy_pend.elements[i].checked=1
            }
        }
    }

    else if(estado == false)
    {
        for (i=0;i<document.proy_pend.elements.length;i++)
        {
    
            if(document.proy_pend.elements[i].type == "checkbox")
            {
        
                document.proy_pend.elements[i].checked=0
            }
        }
    }
    
}

function sel_todo_nada_proy()
{
    var estado = $('#sel_proy').prop('checked');
    var cant_sel=document.getElementById("cant_sel").innerHTML;
    cant_sel = Number(cant_sel);

    if(estado == true)
    {
        for (i=0;i<document.proy_buscador.elements.length;i++)
        {
    
            if(document.proy_buscador.elements[i].type == "checkbox")
            {
        
                if(i<302)
                {
                    document.proy_buscador.elements[i].checked=1;
                    cant_sel = i-1;
                    document.getElementById("cant_sel").innerHTML = cant_sel;

                }
            }

        }
    }

    else if(estado == false)
    {
        for (i=0;i<document.proy_buscador.elements.length;i++)
        {
    
            if(document.proy_buscador.elements[i].type == "checkbox")
            {
        
                if(document.proy_buscador.elements[i].id=="proyeccion_list[]")
                {
                    if(document.proy_buscador.elements[i].checked==1)
                    {
                        cant_sel=cant_sel-1;
                        document.getElementById("cant_sel").innerHTML = cant_sel;
                    }
                }

                document.proy_buscador.elements[i].checked=0
            }
        }
    }
    
}

$("input[id='proyeccion_list[]']").change(function (){

    var elemento=this;
    var cant_proy=document.proy_buscador.elements.length-2;
    var proy_sel=0;

    for (i=0;i<document.proy_buscador.elements.length;i++)
    {
        if(document.proy_buscador.elements[i].id=="proyeccion_list[]")
        {
            if(document.proy_buscador.elements[i].checked==1)
            {
                proy_sel++;
                document.getElementById("cant_sel").innerHTML = proy_sel;

                if(proy_sel==0 || proy_sel>300)
                {
                    export_proyeccion.disabled = true;
                    export_proyeccion.style.backgroundColor= '#83bfaa';
                    export_proyeccion.style.borderColor= '#83bfaa';
                }
                else if(proy_sel>0 && proy_sel<=300)
                {
                    export_proyeccion.disabled = false;
                    export_proyeccion.style.backgroundColor= '#447161';
                    export_proyeccion.style.borderColor= '#447161';
                }

            }
        }
    }
});

function sel_todo_nada_soli()
{
    var estado = $('#sel_soli').prop('checked');
    if(estado == true)
    {
        for (i=0;i<document.soli_buscador.elements.length;i++)
        {
    
            if(document.soli_buscador.elements[i].type == "checkbox")
            {
        
                document.soli_buscador.elements[i].checked=1
            }
        }
    }

    else if(estado == false)
    {
        for (i=0;i<document.soli_buscador.elements.length;i++)
        {
    
            if(document.soli_buscador.elements[i].type == "checkbox")
            {
        
                document.soli_buscador.elements[i].checked=0
            }
        }
    }
    
}

/*Solicitudes pendientes*/
function sel_solic_pend()
{
    var estado = $('#sel_soli_pend').prop('checked');
    if(estado == true)
    {
        for (i=0;i<document.soli_pend.elements.length;i++)
        {
    
            if(document.soli_pend.elements[i].type == "checkbox")
            {
        
                document.soli_pend.elements[i].checked=1
            }
        }
    }
    else if(estado == false)
    {
        for (i=0;i<document.soli_pend.elements.length;i++)
        {
    
            if(document.soli_pend.elements[i].type == "checkbox")
            {
        
                document.soli_pend.elements[i].checked=0
            }
        }
    }
}
/*Solicitudes pendientes*/

/*Solicitudes aprobadas*/
function sel_solic_aprobadas()
{
    var estado = $('#sel_solic_aprob').prop('checked');
    var btn_giro_pdf = document.getElementById("btn_giro_pdf");
    var btn_oficio_pdf = document.getElementById("btn_oficio_pdf");
    var btn_resolucion_pdf = document.getElementById("btn_resolucion_pdf");
    var btn_avance_pdf = document.getElementById("btn_avance_pdf");
    var btn_transporte_pdf = document.getElementById("btn_transporte_pdf");
    var btn_practica_pdf = document.getElementById("btn_practica_pdf");
    var giro_pdf = document.getElementById("giro_pdf");
    var oficio_pdf = document.getElementById("oficio_pdf");
    var resolucion_pdf = document.getElementById("resolucion_pdf");
    var avance_pdf = document.getElementById("avance_pdf");
    var transporte_pdf = document.getElementById("transporte_pdf");
    var practica_pdf = document.getElementById("practica_pdf");
    var num_solic_sel = 0;
    var lis_sol_sel= [];
    var value_item;

    if(estado == true)
    {
        for (i=0;i<document.soli_aprob.elements.length;i++)
        {
    
            if(document.soli_aprob.elements[i].type == "checkbox")
            {
                document.soli_aprob.elements[i].checked=1

                if(document.soli_aprob.elements[i].id == 'solic_aprob_list[]')
                {
                    if(document.soli_aprob.elements[i].checked == 1)
                    {
                        num_solic_sel++;
                        
                        value_item =document.soli_aprob.elements[i].value;
                        lis_sol_sel[num_solic_sel-1]=value_item;

                        giro_pdf.href = giro_pdf.origin+'/giropdf/'+lis_sol_sel;
                        oficio_pdf.href = oficio_pdf.origin+'/oficiopdf/'+lis_sol_sel;
                        resolucion_pdf.href = resolucion_pdf.origin+'/resolucionpdf/'+lis_sol_sel;
                        avance_pdf.href = avance_pdf.origin+'/avancepdf/'+lis_sol_sel;
                        fom_consec_dfama.action = avance_pdf.origin+'/consec_solic/'+lis_sol_sel;
                    }
                }

                if(num_solic_sel == 1)
                {
                    
                    transporte_pdf.href = transporte_pdf.origin+'/transportepdf/'+lis_sol_sel;
                    practica_pdf.href = practica_pdf.origin+'/formatoPracticapdf/'+lis_sol_sel;

                    btn_transporte_pdf.disabled = true;
                    btn_transporte_pdf.style.backgroundColor= '#83bfaa';
                    btn_transporte_pdf.style.borderColor= '#83bfaa';

                    btn_practica_pdf.disabled = true;
                    btn_practica_pdf.style.backgroundColor= '#83bfaa';
                    btn_practica_pdf.style.borderColor= '#83bfaa';
                }

                else if(num_solic_sel > 1)
                {
                    transporte_pdf.href = "";
                    practica_pdf.href = "";
                    
                    btn_transporte_pdf.disabled = true;
                    btn_transporte_pdf.style.backgroundColor= '#83bfaa';
                    btn_transporte_pdf.style.borderColor= '#83bfaa';

                    btn_practica_pdf.disabled = true;
                    btn_practica_pdf.style.backgroundColor= '#83bfaa';
                    btn_practica_pdf.style.borderColor= '#83bfaa';
                }
                else if(num_solic_sel == 0)
                {
                    giro_pdf.href = "";
                    oficio_pdf.href = "";
                    resolucion_pdf.href = "";
                    avance_pdf.href = "";
                    transporte_pdf.href = "";
                    practica_pdf.href = "";
                    fom_consec_dfama.action = "";
                }
            }
        }
    }
    else if(estado == false)
    {
        for (i=0;i<document.soli_aprob.elements.length;i++)
        {
    
            if(document.soli_aprob.elements[i].type == "checkbox")
            {
        
                document.soli_aprob.elements[i].checked=0

                if(document.soli_aprob.elements[i].id == 'solic_aprob_list[]')
                {
                    if(document.soli_aprob.elements[i].checked == 1)
                    {
                        num_solic_sel++;

                        value_item =document.soli_aprob.elements[i].value;
                        lis_sol_sel[num_solic_sel-1]=value_item;

                        giro_pdf.href = giro_pdf.origin+'/giropdf/'+lis_sol_sel;
                        oficio_pdf.href = oficio_pdf.origin+'/oficiopdf/'+lis_sol_sel;
                        resolucion_pdf.href = resolucion_pdf.origin+'/resolucionpdf/'+lis_sol_sel;
                        avance_pdf.href = avance_pdf.origin+'/avancepdf/'+lis_sol_sel;
                        fom_consec_dfama.action = avance_pdf.origin+'/consec_solic/'+lis_sol_sel;
                    }
                }

                if(num_solic_sel == 1)
                {
                    transporte_pdf.href = transporte_pdf.origin+'/transportepdf/'+lis_sol_sel;
                    practica_pdf.href = practica_pdf.origin+'/formatoPracticapdf/'+lis_sol_sel;

                    btn_transporte_pdf.disabled = false;
                    btn_transporte_pdf.style.backgroundColor= '#447161';
                    btn_transporte_pdf.style.borderColor= '#447161';

                    btn_practica_pdf.disabled = false;
                    btn_practica_pdf.style.backgroundColor= '#447161';
                    btn_practica_pdf.style.borderColor= '#447161';
                }
                else if(num_solic_sel > 1)
                {
                    transporte_pdf.href = "";
                    practica_pdf.href = "";

                    btn_transporte_pdf.disabled = true;
                    btn_transporte_pdf.style.backgroundColor= '#83bfaa';
                    btn_transporte_pdf.style.borderColor= '#83bfaa';

                    btn_practica_pdf.disabled = true;
                    btn_practica_pdf.style.backgroundColor= '#83bfaa';
                    btn_practica_pdf.style.borderColor= '#83bfaa';
                }
                else if(num_solic_sel == 0)
                {
                    giro_pdf.href = "";
                    oficio_pdf.href = "";
                    resolucion_pdf.href = "";
                    avance_pdf.href = "";
                    transporte_pdf.href = "";
                    practica_pdf.href = "";
                    fom_consec_dfama.action = "";
                }
            }
        }
    }
}

$("input[type=checkbox]").change(function (){

    var contador=0;
    var btn_transporte_pdf = document.getElementById("btn_transporte_pdf");
    var btn_practica_pdf = document.getElementById("btn_practica_pdf");
    var giro_pdf = document.getElementById("giro_pdf");
    var oficio_pdf = document.getElementById("oficio_pdf");
    var resolucion_pdf = document.getElementById("resolucion_pdf");
    var avance_pdf = document.getElementById("avance_pdf");
    var transporte_pdf = document.getElementById("transporte_pdf");
    var practica_pdf = document.getElementById("practica_pdf");
    var consec_dfama = document.getElementById("up_consec_dfama");
    var fom_consec_dfama = document.getElementById("fom_consec_dfama");
    
    var lis_sol_sel= [];
    var value_item;

    $("input[type=checkbox]").each(function(){
        if($(this).is(":checked"))
        {
            if(this.id == 'solic_aprob_list[]')
            {
                contador++;
                value_item =this.value;
                lis_sol_sel[contador-1]=value_item;

                giro_pdf.href = giro_pdf.origin+'/giropdf/'+lis_sol_sel;
                oficio_pdf.href = oficio_pdf.origin+'/oficiopdf/'+lis_sol_sel;
                resolucion_pdf.href = resolucion_pdf.origin+'/resolucionpdf/'+lis_sol_sel;
                avance_pdf.href = avance_pdf.origin+'/avancepdf/'+lis_sol_sel;
                fom_consec_dfama.action = avance_pdf.origin+'/consec_solic/'+lis_sol_sel;
            }
        }
    });

    if(contador > 1)
    {
        transporte_pdf.href = "";
        practica_pdf.href = ""

        btn_transporte_pdf.disabled = true;
        btn_transporte_pdf.style.backgroundColor= '#83bfaa';
        btn_transporte_pdf.style.borderColor= '#83bfaa';

        btn_practica_pdf.disabled = true;
        btn_practica_pdf.style.backgroundColor= '#83bfaa';
        btn_practica_pdf.style.borderColor= '#83bfaa';
        
    }
    else if(contador == 1)
    {

        transporte_pdf.href = transporte_pdf.origin+'/transportepdf/'+lis_sol_sel;
        practica_pdf.href = practica_pdf.origin+'/formatoPracticapdf/'+lis_sol_sel;

        btn_transporte_pdf.disabled = false;
        btn_transporte_pdf.style.backgroundColor= '#447161';
        btn_transporte_pdf.style.borderColor= '#447161';

        btn_practica_pdf.disabled = false;
        btn_practica_pdf.style.backgroundColor= '#447161';
        btn_practica_pdf.style.borderColor= '#447161';
    }
});

/*Solicitudes aprobadas*/

function total_sel_encuesta()
{
    var estado = $('#sel_encuesta').prop('checked');
    if(estado == true)
    {
        for (i=0;i<document.encuesta_trans.elements.length;i++)
        {
    
            if(document.encuesta_trans.elements[i].type == "checkbox")
            {
        
                document.encuesta_trans.elements[i].checked=1
            }
        }
    }

    else if(estado == false)
    {
        for (i=0;i<document.encuesta_trans.elements.length;i++)
        {
    
            if(document.encuesta_trans.elements[i].type == "checkbox")
            {
        
                document.encuesta_trans.elements[i].checked=0
            }
        }
    }
    
}

function total_sel_not_send()
{
    var estado = $('#sel_proy_not_send').prop('checked');
    if(estado == true)
    {
        for (i=0;i<document.proy_not_send.elements.length;i++)
        {
    
            if(document.proy_not_send.elements[i].type == "checkbox")
            {
        
                document.proy_not_send.elements[i].checked=1
            }
        }
    }

    else if(estado == false)
    {
        for (i=0;i<document.proy_not_send.elements.length;i++)
        {
    
            if(document.proy_not_send.elements[i].type == "checkbox")
            {
        
                document.proy_not_send.elements[i].checked=0
            }
        }
    }
    
}

$("input[type=checkbox]").change(function(){
 
    var elemento=this;
    var contador=0;

    if(document.proy_buscador)
    {
        $("input[id='proyeccion_list[]']").each(function(){
            if($(this).is(":checked"))
                contador++;
        });
    }
    else if(document.soli_buscador)
    {
        $("input[id='solicitud_list[]']").each(function(){
            if($(this).is(":checked"))
                contador++;
        });

    }

    var export_proyeccion = document.getElementById("export_proyeccion");
    var export_solicitud = document.getElementById("export_solicitud");
    var export_encusta = document.getElementById("export_encusta");
    var edit_solic_pend = document.getElementById("edit_solic_pend");

    if(contador == 0 || contador >300)
    {
        if(export_proyeccion != null)
        {
            export_proyeccion.disabled = true;
            export_proyeccion.style.backgroundColor= '#83bfaa';
            export_proyeccion.style.borderColor= '#83bfaa';
        }

        if(export_solicitud != null)
        {
            export_solicitud.disabled = true;
            export_solicitud.style.backgroundColor= '#83bfaa';
            export_solicitud.style.borderColor= '#83bfaa';
        }

        if(export_encusta != null)
        {
            export_encusta.disabled = true;
            export_encusta.style.backgroundColor= '#83bfaa';
            export_encusta.style.borderColor= '#83bfaa';
        }

        if(edit_solic_pend != null)
        {
            edit_solic_pend.disabled = true;
            edit_solic_pend.style.backgroundColor= '#83bfaa';
            edit_solic_pend.style.borderColor= '#83bfaa';
        }
    }
    else if(contador > 0 && contador <=300)
    {
        if(export_proyeccion != null)
        {
            export_proyeccion.disabled = false;
            export_proyeccion.style.backgroundColor= '#447161';
            export_proyeccion.style.borderColor= '#447161';
        }

        if(export_solicitud != null)
        {
            export_solicitud.disabled = false;
            export_solicitud.style.backgroundColor= '#447161';
            export_solicitud.style.borderColor= '#447161';
        }

        if(export_encusta != null)
        {
            export_encusta.disabled = false;
            export_encusta.style.backgroundColor= '#447161';
            export_encusta.style.borderColor= '#447161';
        }

        if(edit_solic_pend != null)
        {
            edit_solic_pend.disabled = false;
            edit_solic_pend.style.backgroundColor= '#447161';
            edit_solic_pend.style.borderColor= '#447161';
        }
    }
});

/*Solo permitir numeros y guion*/
$("#num_resolucion").keyup(function(){

    var text = $("#num_resolucion").val();
    var out = '';
    var filtro = '1234567890-';

    for (var i=0; i<text.length; i++)
    {
       if (filtro.indexOf(text.charAt(i)) != -1) 
       {
	     out += text.charAt(i);
         $("#num_resolucion").val(out);
       }
    }
});


window.onload = function()
{
    var contenedor = document.getElementById('cont_carga');
    contenedor.style.visibility = 'hidden';
    contenedor.style.opacity = '0';
}

/*$(window).load(function() {
    $(".cont_carga").fadeOut("slow");
});*/

/*Cantidad espacios academicos usuario*/


$("#esp_aca_user_1").show();
$("#esp_aca_user_2").hide();
$("#esp_aca_user_3").hide();
$("#esp_aca_user_4").hide();
$("#esp_aca_user_5").hide();
$("#esp_aca_user_6").hide();

$("#c_espa_aca_user").change('keypress', function () {
    num_espa_aca_user = $("#c_espa_aca_user").val();
    
    switch(num_espa_aca_user)
    {
        case "1":
            $("#esp_aca_user_1").show();
            $("#esp_aca_user_2").hide();
            $("#esp_aca_user_3").hide();
            $("#esp_aca_user_4").hide();
            $("#esp_aca_user_5").hide();
            $("#esp_aca_user_6").hide();
            $("#cod_espacio_academico_2").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_3").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_4").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "2":
            $("#esp_aca_user_1").show();
            $("#esp_aca_user_2").show();
            $("#esp_aca_user_3").hide();
            $("#esp_aca_user_4").hide();
            $("#esp_aca_user_5").hide();
            $("#esp_aca_user_6").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_4").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "3":
            $("#esp_aca_user_1").show();
            $("#esp_aca_user_2").show();
            $("#esp_aca_user_3").show();
            $("#esp_aca_user_4").hide();
            $("#esp_aca_user_5").hide();
            $("#esp_aca_user_6").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "4":
            $("#esp_aca_user_1").show();
            $("#esp_aca_user_2").show();
            $("#esp_aca_user_3").show();
            $("#esp_aca_user_4").show();
            $("#esp_aca_user_5").hide();
            $("#esp_aca_user_6").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().attr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "5":
            $("#esp_aca_user_1").show();
            $("#esp_aca_user_2").show();
            $("#esp_aca_user_3").show();
            $("#esp_aca_user_4").show();
            $("#esp_aca_user_5").show();
            $("#esp_aca_user_6").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().attr('required','required');
            $("#cod_espacio_academico_5").next().next().attr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "6":
            $("#esp_aca_user_1").show();
            $("#esp_aca_user_2").show();
            $("#esp_aca_user_3").show();
            $("#esp_aca_user_4").show();
            $("#esp_aca_user_5").show();
            $("#esp_aca_user_6").show();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().attr('required','required');
            $("#cod_espacio_academico_5").next().next().attr('required','required');
            $("#cod_espacio_academico_6").next().next().attr('required','required');
            break;
    }

});

$("#esp_aca_user_1_edit").hide();
$("#esp_aca_user_2_edit").hide();
$("#esp_aca_user_3_edit").hide();
$("#esp_aca_user_4_edit").hide();
$("#esp_aca_user_5_edit").hide();
$("#esp_aca_user_6_edit").hide();

$("#c_espa_aca_user_edit").change('keypress', function () {
    num_espa_aca_user = $("#c_espa_aca_user_edit").val();
    
    switch(num_espa_aca_user)
    {
        case "1":
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").hide();
            $("#esp_aca_user_3_edit").hide();
            $("#esp_aca_user_4_edit").hide();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            $("#cod_espacio_academico_2").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_3").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_4").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "2":
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").hide();
            $("#esp_aca_user_4_edit").hide();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_4").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "3":
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").hide();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "4":
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").show();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().attr('required','required');
            $("#cod_espacio_academico_5").next().next().removeAttr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "5":
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").show();
            $("#esp_aca_user_5_edit").show();
            $("#esp_aca_user_6_edit").hide();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().attr('required','required');
            $("#cod_espacio_academico_5").next().next().attr('required','required');
            $("#cod_espacio_academico_6").next().next().removeAttr('required','required');
            break;
        case "6":
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").show();
            $("#esp_aca_user_5_edit").show();
            $("#esp_aca_user_6_edit").show();
            $("#cod_espacio_academico_2").next().next().attr('required','required');
            $("#cod_espacio_academico_3").next().next().attr('required','required');
            $("#cod_espacio_academico_4").next().next().attr('required','required');
            $("#cod_espacio_academico_5").next().next().attr('required','required');
            $("#cod_espacio_academico_6").next().next().attr('required','required');
            break;
    }

});

$("#ocul_esp_user").hide();

function ver_esp()
{
    var num_esp = $("#c_espa_aca_user_edit").val();
    $("#ver_esp_user").hide();
    $("#ocul_esp_user").show();
    $("#c_espa_aca_user_edit").removeAttr("readonly");

    switch(num_esp)
    {
        case '1':
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").hide();
            $("#esp_aca_user_3_edit").hide();
            $("#esp_aca_user_4_edit").hide();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            break;
        case '2':
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").hide();
            $("#esp_aca_user_4_edit").hide();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            break;
        case '3':
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").hide();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            break;
        case '4':
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").show();
            $("#esp_aca_user_5_edit").hide();
            $("#esp_aca_user_6_edit").hide();
            break;
        case '5':
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").show();
            $("#esp_aca_user_5_edit").show();
            $("#esp_aca_user_6_edit").hide();
            break;
        case '6':
            $("#esp_aca_user_1_edit").show();
            $("#esp_aca_user_2_edit").show();
            $("#esp_aca_user_3_edit").show();
            $("#esp_aca_user_4_edit").show();
            $("#esp_aca_user_5_edit").show();
            $("#esp_aca_user_6_edit").show();
            break;
    }

}

function ocul_esp()
{
    $("#ocul_esp_user").hide();
    $("#ver_esp_user").show();
    $("#c_espa_aca_user").attr("readonly","readonly");
    $("#esp_aca_user_1_edit").hide();
    $("#esp_aca_user_2_edit").hide();
    $("#esp_aca_user_3_edit").hide();
    $("#esp_aca_user_4_edit").hide();
    $("#esp_aca_user_5_edit").hide();
    $("#esp_aca_user_6_edit").hide();
}

/*Cantidad espacios academicos usuario*/

/*Cantidad docentes apoyo Proyección create*/
$("#apoyo").hide();
$("#ap_1").hide();
$("#ap_2").hide();
$("#ap_3").hide();
$("#ap_4").hide();
$("#ap_5").hide();
$("#ap_6").hide();
$("#ap_7").hide();
$("#ap_8").hide();
$("#ap_9").hide();
$("#ap_10").hide();
$("#soporte_apoyo").hide();
$("#cant_docen_apoyo").hide();

$("#num_apoyo").change('keypress', function () {
    num_apoyo = $("#num_apoyo").val();
    total_doc_apoyo = $("#total_docentes_apoyo").val();
    
    if(parseInt(num_apoyo) >= 1 && parseInt(num_apoyo) <= 10)
    {
        $("#soporte_apoyo").show();
        $("#sop_pers_apoyo").attr('required','required');
        $("#cant_docen_apoyo").show();
        $("#total_docentes_apoyo").removeAttr('max');
        $("#total_docentes_apoyo").attr('max',num_apoyo);

        if(parseInt(total_doc_apoyo) > parseInt(num_apoyo))
        {
            $("#total_docentes_apoyo").val(num_apoyo);
        }
    }
    else{
        $("#soporte_apoyo").hide();
        $("#sop_pers_apoyo").removeAttr('required','required');
        $("#cant_docen_apoyo").hide();
		$("#total_docentes_apoyo").attr('max',0);
		$("#total_docentes_apoyo").val(0);
    }
    
    switch(num_apoyo)
    {
        case "0":
            $("#apoyo").hide();
            $("#apoyo_1").val("");
            $("#apoyo_2").val("");
            $("#apoyo_3").val("");
            $("#apoyo_4").val("");
            $("#apoyo_5").val("");
            $("#apoyo_6").val("");
            $("#apoyo_7").val("");
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            break;
        case "1":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#apoyo_2").val("");
            $("#apoyo_3").val("");
            $("#apoyo_4").val("");
            $("#apoyo_5").val("");
            $("#apoyo_6").val("");
            $("#apoyo_7").val("");
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_2").hide();
            $("#ap_3").hide();
            $("#ap_4").hide();
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "2":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#apoyo_3").val("");
            $("#apoyo_4").val("");
            $("#apoyo_5").val("");
            $("#apoyo_6").val("");
            $("#apoyo_7").val("");
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_3").hide();
            $("#ap_4").hide();
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "3":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").hide();
            $("#apoyo_5").val("");
            $("#apoyo_6").val("");
            $("#apoyo_7").val("");
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_4").hide();
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "4":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#apoyo_5").val("");
            $("#apoyo_6").val("");
            $("#apoyo_7").val("");
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "5":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#apoyo_6").val("");
            $("#apoyo_7").val("");
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "6":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#apoyo_7").val("");
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "7":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#apoyo_8").val("");
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "8":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#ap_8").show();
            $("#apoyo_9").val("");
            $("#apoyo_10").val("");
            $("#ap_9").hide();
            $("#ap_10").hide();
            break;
        case "9":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#ap_8").show();
            $("#ap_9").show();
            $("#apoyo_10").val("");
            $("#ap_10").hide();
            break;
        case "10":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#ap_8").show();
            $("#ap_9").show();
            $("#ap_10").show();
            break;
    }
});

/*Cantidad docentes apoyo Proyección create*/

/*Cantidad Grupos Proyección create*/
$("#Grupos").show();
$("#gp_1").show();
$("#gp_2").hide();
$("#gp_3").hide();
$("#gp_4").hide();

$("#cant_grupos").change('keypress', function () {
    val = $("#cant_grupos").val();
    
    if(val==1)
    {
        $("#Grupos").show();
        $("#gp_1").show();
        $("#gp_2").hide();
        $("#gp_3").hide();
        $("#gp_4").hide();
    }
    else if(val==2)
    {
        $("#gp_2").show();
        $("#gp_3").hide();
        $("#gp_4").hide();
    }
    else if(val==3)
    {
        $("#gp_2").show();
        $("#gp_3").show();
        $("#gp_4").hide();
    }
    else if(val==4)
    {
        $("#gp_2").show();
        $("#gp_3").show();
        $("#gp_4").show();
    }
});

/*Cantidad Grupos Proyección create*/

/*Cantidad Grupos Proyección Edit*/
$("#Grupos_edit").hide();
$("#gp_1_edit").hide();
$("#gp_2_edit").hide();
$("#gp_3_edit").hide();
$("#gp_4_edit").hide();

$("#cant_grupos_edit").change('keypress', function () {
    val = $("#cant_grupos_edit").val();
    
    if(val==1)
    {
        $("#Grupos_edit").show();
        $("#gp_1_edit").show();
        $("#gp_2_edit").hide();
        $("#gp_3_edit").hide();
        $("#gp_4_edit").hide();
    }
    else if(val==2)
    {
        $("#gp_2_edit").show();
        $("#gp_3_edit").hide();
        $("#gp_4_edit").hide();
    }
    else if(val==3)
    {
        $("#gp_2_edit").show();
        $("#gp_3_edit").show();
        $("#gp_4_edit").hide();
    }
    else if(val==4)
    {
        $("#gp_2_edit").show();
        $("#gp_3_edit").show();
        $("#gp_4_edit").show();
    }
});

$("#ocul_grupos").hide();
function ver_gps()
{
    var num_gps = $("#cant_grupos_edit").val();
    $("#ver_grupos").hide();
    $("#ocul_grupos").show();
    $("#cant_grupos_edit").removeAttr("readonly");

    if(num_gps==1)
    {
        $("#Grupos_edit").show();
        $("#gp_1_edit").show();
        $("#gp_2_edit").hide();
        $("#gp_3_edit").hide();
        $("#gp_4_edit").hide();
    }
    else if(num_gps==2)
    {
        $("#Grupos_edit").show();
        $("#gp_1_edit").show();
        $("#gp_2_edit").show();
        $("#gp_3_edit").hide();
        $("#gp_4_edit").hide();
    }
    else if(num_gps==3)
    {
        $("#Grupos_edit").show();
        $("#gp_1_edit").show();
        $("#gp_2_edit").show();
        $("#gp_3_edit").show();
        $("#gp_4_edit").hide();
    }
    else if(num_gps==4)
    {
        $("#Grupos_edit").show();
        $("#gp_1_edit").show();
        $("#gp_2_edit").show();
        $("#gp_3_edit").show();
        $("#gp_4_edit").show();
    }

}

function ocul_gps()
{
    $("#ocul_grupos").hide();
    $("#ver_grupos").show();
    $("#cant_grupos_edit").attr("readonly","readonly");
    $("#Grupos_edit").hide();
}

/*Cantidad Grupos Proyección Edit*/

/*Cantidad acompañantes  proyeccion - Solicitud edit*/
$("#ocul_acompa").hide();
function ver_acomp()
{
    var num_acom = $("#num_acompaniantes").val();
    $("#ver_acompa").hide();
    $("#ocul_acompa").show();
    $("#num_acompaniantes").removeAttr("readonly");
    $("#acompa").show();
    
    switch(num_acom)
    {
        case "0":
            $("#acompa").hide();
            break;
        case "1":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").hide();
            $("#ac_3").hide();
            $("#ac_4").hide();
            $("#ac_5").hide();
            $("#ac_6").hide();
            $("#ac_7").hide();
            $("#ac_8").hide();
            $("#ac_9").hide();
            $("#ac_10").hide();
            break;
        case "2":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").hide();
            $("#ac_4").hide();
            $("#ac_5").hide();
            $("#ac_6").hide();
            $("#ac_7").hide();
            $("#ac_8").hide();
            $("#ac_9").hide();
            $("#ac_10").hide();
            break;
        case "3":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").hide();
            $("#ac_5").hide();
            $("#ac_6").hide();
            $("#ac_7").hide();
            $("#ac_8").hide();
            $("#ac_9").hide();
            $("#ac_10").hide();
            break;
        case "4":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").show();
            $("#ac_5").hide();
            $("#ac_6").hide();
            $("#ac_7").hide();
            $("#ac_8").hide();
            $("#ac_9").hide();
            $("#ac_10").hide();
            break;
        case "5":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").show();
            $("#ac_5").show();
            $("#ac_6").hide();
            $("#ac_7").hide();
            $("#ac_8").hide();
            $("#ac_9").hide();
            $("#ac_10").hide();
            
            break;
        case "6":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").show();
            $("#ac_5").show();
            $("#ac_6").show();
            $("#ac_7").hide();
            $("#ac_8").hide();
            $("#ac_9").hide();
            $("#ac_10").hide();
            break;
        case "7":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").show();
            $("#ac_5").show();
            $("#ac_6").show();
            $("#ac_7").show();
            $("#ac_8").hide();
            $("#ac_9").hide();
            $("#ac_10").hide();
            break;
        case "8":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").show();
            $("#ac_5").show();
            $("#ac_6").show();
            $("#ac_7").show();
            $("#ac_8").show();
            $("#ac_9").hide();
            $("#ac_10").hide();
            break;
        case "9":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").show();
            $("#ac_5").show();
            $("#ac_6").show();
            $("#ac_7").show();
            $("#ac_8").show();
            $("#ac_9").show();
            $("#ac_10").hide();
            break;
        case "10":
            $("#acompa").show();
            $("#ac_1").show();
            $("#ac_2").show();
            $("#ac_3").show();
            $("#ac_4").show();
            $("#ac_5").show();
            $("#ac_6").show();
            $("#ac_7").show();
            $("#ac_8").show();
            $("#ac_9").show();
            $("#ac_10").show();
            break;
    }

}

function ocul_acomp()
{
    $("#ocul_acompa").hide();
    $("#ver_acompa").show();
    $("#num_acompaniantes").attr("readonly","readonly");
    $("#acompa").hide();
}
/*Cantidad acompañantes proyeccion - solicitud Edit*/

/*Cantidad docentes apoyo proyeccion - solicitud Edit*/
$("#ocul_apoyo").hide();

function ver_apoy()
{
    var num_apoyo = $("#num_apoyo").val();
    $("#ver_apoyo").hide();
    $("#ocul_apoyo").show();
    $("#num_apoyo").removeAttr("readonly");
    $("#apoyo").show();
    $("#cant_docen_apoyo").show();
    
    switch(num_apoyo)
    {
        case "0":
            $("#apoyo").hide();
            $("#cant_docen_apoyo").hide();
            break;
        case "1":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").hide();
            $("#ap_3").hide();
            $("#ap_4").hide();
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "2":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").hide();
            $("#ap_4").hide();
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "3":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").hide();
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "4":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").hide();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "5":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").hide();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "6":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").hide();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "7":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#ap_8").hide();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "8":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#ap_8").show();
            $("#ap_9").hide();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "9":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#ap_8").show();
            $("#ap_9").show();
            $("#ap_10").hide();
            $("#cant_docen_apoyo").show();
            break;
        case "10":
            $("#apoyo").show();
            $("#ap_1").show();
            $("#ap_2").show();
            $("#ap_3").show();
            $("#ap_4").show();
            $("#ap_5").show();
            $("#ap_6").show();
            $("#ap_7").show();
            $("#ap_8").show();
            $("#ap_9").show();
            $("#ap_10").show();
            $("#cant_docen_apoyo").show();
            break;
    }
}

function ocul_apoy()
{
    $("#ocul_apoyo").hide();
    $("#ver_apoyo").show();
    $("#num_apoyo").attr("readonly","readonly");
    $("#apoyo").hide();
    $("#cant_docen_apoyo").hide();
}
/*Cantidad docentes apoyo solicitud Edit*/

/*Cantidad vehiculos proyeccion Edit*/
$("#transporte_rp_1").show();
$("#transporte_rp_2").hide();
$("#transporte_rp_3").hide();

$("#cant_transporte_rp").change('keypress', function () {
    val = $("#cant_transporte_rp").val();
    
    if(val >= 1)
    {
        $("#docente_transp_rp").show();
    }
    else
    {
        $("#docente_transp_rp").hide();
    }

    switch(val)
    {
        case "0":
            $("#capac_transp_rp_1").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_rp_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_rp_3").find("input[type=text]").removeAttr("required","required");
            $("#transporte_rp_1").hide();
            $("#transporte_rp_2").hide();
            $("#transporte_rp_3").hide();
            break;
        case "1":
            $("#transporte_rp_1").show();
            $("#transporte_rp_2").hide();
            $("#transporte_rp_3").hide();
            $("#capac_transp_rp_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_rp_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_rp_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "2":
            $("#transporte_rp_1").show();
            $("#transporte_rp_2").show();
            $("#transporte_rp_3").hide();
            $("#capac_transp_rp_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_rp_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_rp_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "3":
            $("#transporte_rp_1").show();
            $("#transporte_rp_2").show();
            $("#transporte_rp_3").show();
            $("#capac_transp_rp_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_rp_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_rp_3").find("input[type=text]").attr("required","required");
            break;
    }
});

$("#transporte_rp_1_edit").hide();
$("#transporte_rp_2_edit").hide();
$("#transporte_rp_3_edit").hide();

$("#cant_transporte_rp_edit").change('keypress', function () {
    val = $("#cant_transporte_rp_edit").val();
    
    if(val >= 1)
    {
        $("#docente_transp_edit_rp").show();
    }
    else
    {
        $("#docente_transp_edit_rp").hide();
    }

    switch(val)
    {
        case "0":
            $("#capac_transp_edit_rp_1").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_edit_rp_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_edit_rp_3").find("input[type=text]").removeAttr("required","required");
            $("#transporte_rp_1_edit").hide();
            $("#transporte_rp_2_edit").hide();
            $("#transporte_rp_3_edit").hide();
            break;
        case "1":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").hide();
            $("#transporte_rp_3_edit").hide();
            $("#capac_transp_edit_rp_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_rp_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_edit_rp_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "2":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").show();
            $("#transporte_rp_3_edit").hide();
            $("#capac_transp_edit_rp_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_rp_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_rp_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "3":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").show();
            $("#transporte_rp_3_edit").show();
            $("#capac_transp_edit_rp_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_rp_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_rp_3").find("input[type=text]").attr("required","required");
            break;
    }
});

$("#transporte_ra_1").show();
$("#transporte_ra_2").hide();
$("#transporte_ra_3").hide();

$("#cant_transporte_ra").change('keypress', function()
{
    val = $("#cant_transporte_ra").val();
    
    if(val >= 1)
    {
        $("#docente_transp_ra").show();
    }
    else
    {
        $("#docente_transp_ra").hide();
    }

    switch(val)
    {
        case "0":
            $("#capac_transp_ra_1").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_ra_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_ra_3").find("input[type=text]").removeAttr("required","required");
            $("#transporte_ra_1").hide();
            $("#transporte_ra_2").hide();
            $("#transporte_ra_3").hide();
            break;
        case "1":
            $("#transporte_ra_1").show();
            $("#transporte_ra_2").hide();
            $("#transporte_ra_3").hide();
            $("#capac_transp_ra_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_ra_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_ra_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "2":
            $("#transporte_ra_1").show();
            $("#transporte_ra_2").show();
            $("#transporte_ra_3").hide();
            $("#capac_transp_ra_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_ra_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_ra_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "3":
            $("#transporte_ra_1").show();
            $("#transporte_ra_2").show();
            $("#transporte_ra_3").show();
            $("#capac_transp_ra_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_ra_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_ra_3").find("input[type=text]").attr("required","required");
            break;
    }
});

$("#transporte_ra_1_edit").hide();
$("#transporte_ra_2_edit").hide();
$("#transporte_ra_3_edit").hide();

$("#cant_transporte_ra_edit").change('keypress', function()
{
    val = $("#cant_transporte_ra_edit").val();
    
    if(val >= 1)
    {
        $("#docente_transp_edit_ra").show();
    }
    else
    {
        $("#docente_transp_edit_ra").hide();
    }

    switch(val)
    {
        case "0":
            $("#capac_transp_edit_ra_1").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_edit_ra_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_edit_ra_3").find("input[type=text]").removeAttr("required","required");
            $("#transporte_ra_1_edit").hide();
            $("#transporte_ra_2_edit").hide();
            $("#transporte_ra_3_edit").hide();
            break;
        case "1":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").hide();
            $("#transporte_ra_3_edit").hide();
            $("#capac_transp_edit_ra_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_ra_2").find("input[type=text]").removeAttr("required","required");
            $("#capac_transp_edit_ra_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "2":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").show();
            $("#transporte_ra_3_edit").hide();
            $("#capac_transp_edit_ra_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_ra_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_ra_3").find("input[type=text]").removeAttr("required","required");
            break;
        case "3":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").show();
            $("#transporte_ra_3_edit").show();
            $("#capac_transp_edit_ra_1").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_ra_2").find("input[type=text]").attr("required","required");
            $("#capac_transp_edit_ra_3").find("input[type=text]").attr("required","required");
            break;
    }
});

$("#ocul_vehi").hide();
function ver_vehic()
{
    var cant_vehi = $("#cant_transporte_rp_edit").val();
    $("#ver_vehi").hide();
    $("#ocul_vehi").show();
    $("#cant_transporte_rp_edit").removeAttr("readonly");

    switch(cant_vehi)
    {
        case "0":
            $("#transporte_rp_1_edit").hide();
            $("#transporte_rp_2_edit").hide();
            $("#transporte_rp_3_edit").hide();
            break;
        case "1":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").hide();
            $("#transporte_rp_3_edit").hide();
            break;
        case "2":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").show();
            $("#transporte_rp_3_edit").hide();
            break;
        case "3":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").show();
            $("#transporte_rp_3_edit").show();
            break;
    }
}

function ver_vehic_transp($proy_1,$proy_2,$proy_3)
{
    var cant_vehi = $("#cant_transporte_rp_edit").val();
    $("#ver_vehi").hide();
    $("#ocul_vehi").show();
    $("#cant_transporte_rp_edit").removeAttr("readonly");

    switch(cant_vehi)
    {
        case "0":
            $("#transporte_rp_1_edit").hide();
            $("#transporte_rp_2_edit").hide();
            $("#transporte_rp_3_edit").hide();
            break;
        case "1":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").hide();
            $("#transporte_rp_3_edit").hide();
            break;
        case "2":
            $("#transporte_rp_1_edit").show();
            $("#transporte_rp_2_edit").show();
            $("#transporte_rp_3_edit").hide();
            break;
        case "3":
            $("#transporte_rp_2_edit").show();
            $("#transporte_rp_3_edit").show();
            $("#transporte_rp_1_edit").show();
            break;
    }
}

function ocul_vehic()
{
    $("#ocul_vehi").hide();
    $("#ver_vehi").show();
    $("#cant_transporte_rp_edit").attr("readonly","readonly");

    $("#transporte_rp_1_edit").hide();
    $("#transporte_rp_2_edit").hide();
    $("#transporte_rp_3_edit").hide();
}

$("#ocul_vehi_ra").hide();
function ver_vehic_ra()
{
    var cant_vehi = $("#cant_transporte_ra_edit").val();
    $("#ver_vehi_ra").hide();
    $("#ocul_vehi_ra").show();
    $("#cant_transporte_ra_edit").removeAttr("readonly");

    switch(cant_vehi)
    {
        case "0":
            $("#transporte_ra_1_edit").hide();
            $("#transporte_ra_2_edit").hide();
            $("#transporte_ra_3_edit").hide();
            break;
        case "1":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").hide();
            $("#transporte_ra_3_edit").hide();
            break;
        case "2":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").show();
            $("#transporte_ra_3_edit").hide();
            break;
        case "3":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").show();
            $("#transporte_ra_3_edit").show();
            break;
    }
}

function ver_vehic_transp_ra($proy_1,$proy_2,$proy_3)
{
    var cant_vehi = $("#cant_transporte_ra_edit").val();
    $("#ver_vehi_ra").hide();
    $("#ocul_vehi_ra").show();
    $("#cant_transporte_ra_edit").removeAttr("readonly");

    switch(cant_vehi)
    {
        case "0":
            $("#transporte_ra_1_edit").hide();
            $("#transporte_ra_2_edit").hide();
            $("#transporte_ra_3_edit").hide();
            break;
        case "1":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").hide();
            $("#transporte_ra_3_edit").hide();
            break;
        case "2":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").show();
            $("#transporte_ra_3_edit").hide();
            break;
        case "3":
            $("#transporte_ra_1_edit").show();
            $("#transporte_ra_2_edit").show();
            $("#transporte_ra_3_edit").show();
            break;
    }
}

function ocul_vehic_ra()
{
    $("#ocul_vehi_ra").hide();
    $("#ver_vehi_ra").show();
    $("#cant_transporte_ra_edit").attr("readonly","readonly");

    $("#transporte_ra_1_edit").hide();
    $("#transporte_ra_2_edit").hide();
    $("#transporte_ra_3_edit").hide();
}
/*Cantidad vehiculos proyeccion Edit*/

/*Cantidad Transporte Menor create*/

$("#t_menor_rp_1").hide();
$("#t_menor_rp_2").hide();
$("#t_menor_rp_3").hide();
$("#t_menor_rp_4").hide();

$("#cant_trans_menor_rp").change('keypress', function () {
    num_t_menor = $("#cant_trans_menor_rp").val();
    
    if(num_t_menor >= 1)
    {
        $("#docente_trans_menor_rp").show();
    }
    else
    {
        $("#docente_trans_menor_rp").hide();
    }

    switch(num_t_menor)
    {
        case "0":
            $("#docente_trans_menor_rp").hide();
            $("#t_menor_rp_1").hide();
            $("#t_menor_rp_2").hide();
            $("#t_menor_rp_3").hide();
            $("#t_menor_rp_4").hide();
            
            break;
        case "1":
            $("#t_menor_rp_1").show();
            $("#t_menor_rp_2").hide();
            $("#t_menor_rp_3").hide();
            $("#t_menor_rp_4").hide();
            break;
        case "2":
            $("#t_menor_rp_1").show();
            $("#t_menor_rp_2").show();
            $("#t_menor_rp_3").hide();
            $("#t_menor_rp_4").hide();
            break;
        case "3":
            $("#t_menor_rp_1").show();
            $("#t_menor_rp_2").show();
            $("#t_menor_rp_3").show();
            $("#t_menor_rp_4").hide();
            break;
        case "4":
            $("#t_menor_rp_1").show();
            $("#t_menor_rp_2").show();
            $("#t_menor_rp_3").show();
            $("#t_menor_rp_4").show();
            break;
        
    }

});

$("#t_menor_ra_1").hide();
$("#t_menor_ra_2").hide();
$("#t_menor_ra_3").hide();
$("#t_menor_ra_4").hide();

$("#cant_trans_menor_ra").change('keypress', function () {
    num_t_menor = $("#cant_trans_menor_ra").val();

    if(num_t_menor >= 1)
    {
        $("#docente_trans_menor_ra").show();
    }
    else
    {
        $("#docente_trans_menor_ra").hide();
    }
    
    switch(num_t_menor)
    {
        case "0":
            $("#t_menor_ra_1").hide();
            $("#t_menor_ra_2").hide();
            $("#t_menor_ra_3").hide();
            $("#t_menor_ra_4").hide();
            
            break;
        case "1":
            $("#t_menor_ra_1").show();
            $("#t_menor_ra_2").hide();
            $("#t_menor_ra_3").hide();
            $("#t_menor_ra_4").hide();
            break;
        case "2":
            $("#t_menor_ra_1").show();
            $("#t_menor_ra_2").show();
            $("#t_menor_ra_3").hide();
            $("#t_menor_ra_4").hide();
            break;
        case "3":
            $("#t_menor_ra_1").show();
            $("#t_menor_ra_2").show();
            $("#t_menor_ra_3").show();
            $("#t_menor_ra_4").hide();
            break;
        case "4":
            $("#t_menor_ra_1").show();
            $("#t_menor_ra_2").show();
            $("#t_menor_ra_3").show();
            $("#t_menor_ra_4").show();
            break;
        
    }

});

/*Cantidad Transporte Menor create*/

/* soporte personal apoyo */

$("#soporte_pers_apoyo").hide();
$("#ocul_sop_per").hide();

function ver_soporte()
{
    $("#soporte_pers_apoyo").show();
    $("#ocul_sop_per").show();
    $("#ver_sop_per").hide();
}

function ocul_soporte()
{
    $("#soporte_pers_apoyo").hide();
    $("#ocul_sop_per").hide();
    $("#ver_sop_per").show();
}
/* soporte personal apoyo */

/*Cantidad URL*/
$("#rp_url_2").hide();
$("#rp_url_3").hide();
$("#rp_url_4").hide();
$("#rp_url_5").hide();
$("#rp_url_6").hide();

$("#cant_url_rp").change('keypress', function (){
    val = $("#cant_url_rp").val();

    switch(val)
    {
        case "1":
            $("#rp_url_1").show();
            $("#rp_url_2").hide();
            $("#rp_url_3").hide();
            $("#rp_url_4").hide();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").removeAttr("required","required");
            $("#ruta_principal_3").removeAttr("required","required");
            $("#ruta_principal_4").removeAttr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            $("#ruta_principal_2").val("");
            $("#ruta_principal_3").val("");
            $("#ruta_principal_4").val("");
            $("#ruta_principal_5").val("");
            $("#ruta_principal_6").val("");
            break;
        case "2":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").hide();
            $("#rp_url_4").hide();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").removeAttr("required","required");
            $("#ruta_principal_4").removeAttr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            $("#ruta_principal_3").val("");
            $("#ruta_principal_4").val("");
            $("#ruta_principal_5").val("");
            $("#ruta_principal_6").val("");
            break;
        case "3":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").hide();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").removeAttr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            $("#ruta_principal_4").val("");
            $("#ruta_principal_5").val("");
            $("#ruta_principal_6").val("");
            break;
        case "4":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").show();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").attr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            $("#ruta_principal_5").val("");
            $("#ruta_principal_6").val("");
            break;
        case "5":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").show();
            $("#rp_url_5").show();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").attr("required","required");
            $("#ruta_principal_5").attr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            $("#ruta_principal_6").val("");
            break;
        case "6":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").show();
            $("#rp_url_5").show();
            $("#rp_url_6").show();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").attr("required","required");
            $("#ruta_principal_5").attr("required","required");
            $("#ruta_principal_6").attr("required","required");
            break;
    }
});

$("#ra_url_2").hide();
$("#ra_url_3").hide();
$("#ra_url_4").hide();
$("#ra_url_5").hide();
$("#ra_url_6").hide();

$("#cant_url_ra").change('keypress', function(){
    val = $("#cant_url_ra").val();

    switch(val)
    {
        case "1":
            $("#ra_url_1").show();
            $("#ra_url_2").hide();
            $("#ra_url_3").hide();
            $("#ra_url_4").hide();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").removeAttr("required","required");
            $("#ruta_alterna_3").removeAttr("required","required");
            $("#ruta_alterna_4").removeAttr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            $("#ruta_alterna_2").val("");
            $("#ruta_alterna_3").val("");
            $("#ruta_alterna_4").val("");
            $("#ruta_alterna_5").val("");
            $("#ruta_alterna_6").val("");
            break;
        case "2":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").hide();
            $("#ra_url_4").hide();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").removeAttr("required","required");
            $("#ruta_alterna_4").removeAttr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            $("#ruta_alterna_3").val("");
            $("#ruta_alterna_4").val("");
            $("#ruta_alterna_5").val("");
            $("#ruta_alterna_6").val("");
            break;
        case "3":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").hide();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").removeAttr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            $("#ruta_alterna_4").val("");
            $("#ruta_alterna_5").val("");
            $("#ruta_alterna_6").val("");
            break;
        case "4":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").show();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").attr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            $("#ruta_alterna_5").val("");
            $("#ruta_alterna_6").val("");
            break;
        case "5":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").show();
            $("#ra_url_5").show();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").attr("required","required");
            $("#ruta_alterna_5").attr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            $("#ruta_alterna_6").val("");
            break;
        case "6":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").show();
            $("#ra_url_5").show();
            $("#ra_url_6").show();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").attr("required","required");
            $("#ruta_alterna_5").attr("required","required");
            $("#ruta_alterna_6").attr("required","required");
            break;
    }
});
/*Cantidad URL*/

/*Espacios Académicos prácticas integradas*/

$("#esp_aca_1").hide();
$("#esp_aca_2").hide();
$("#esp_aca_3").hide();
$("#esp_aca_4").hide();
$("#esp_aca_5").hide();
$("#esp_aca_6").hide();
$("#esp_aca_7").hide();

$("input[name=integrada]").change('keypress', function(){
    var resp = $(this).val();
    switch(resp)
    {
        case "0":
            $("#c_espa_aca").hide();
            $("#esp_aca_1").hide()
            $("#esp_aca_2").hide();
            $("#esp_aca_3").hide();
            $("#esp_aca_4").hide();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            $("#cant_espa_aca").removeAttr('value','value');
            num_apoyo =$("#num_apoyo").val();

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max',10);

            break;
        case "1":
            $("#c_espa_aca").show();
            $("#esp_aca_1").show();
            $("#cant_espa_aca").attr('value','value');
            $("#cant_espa_aca").val("1");
            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo == 10)
            {
                $("#num_apoyo").val(9);
                $("#num_apoyo").removeAttr('max');
                $("#num_apoyo").attr('max',9);
                $("#ap_10").hide();
            }
            else if(num_apoyo == 0){
                
                $("#num_apoyo").removeAttr('max');
                $("#num_apoyo").attr('max',10 - 1);
            }
            else{
                
                $("#num_apoyo").removeAttr('max');
                $("#num_apoyo").attr('max',10 - num_apoyo);
            }

            
            break;
    }

    calc_viaticos_RP();

});

$("#cant_espa_aca").change('keypress', function(){
    val = $("#cant_espa_aca").val();

    switch(val)
    {
        case "1":
            $("#esp_aca_1").show();
            $("#esp_aca_2").hide();
            $("#esp_aca_3").hide();
            $("#esp_aca_4").hide();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            
            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo > 9 )
            {
                $("#num_apoyo").val(9);
                $("#ap_10").hide();
            }

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max','9');

            break;
        case "2":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").hide();
            $("#esp_aca_4").hide();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
           

            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo > 8)
            {
                $("#num_apoyo").val(8);
                $("#ap_10").hide();            
                $("#ap_9").hide();
            }

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max','8');

            break;
        case "3":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").hide();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();

            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo > 7)
            {
                $("#num_apoyo").val(7);
                $("#ap_10").hide();
                $("#ap_9").hide();
                $("#ap_8").hide();
            }

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max','7');

            break;
        case "4":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            
            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo > 6)
            {
                $("#num_apoyo").val(6);

                $("#ap_10").hide();
                $("#ap_9").hide();
                $("#ap_8").hide();
                $("#ap_7").hide();
            }

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max','6');

            break;
        case "5":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").show();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();

            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo > 5)
            {
                $("#num_apoyo").val(5);

                $("#ap_10").hide();
                $("#ap_9").hide();
                $("#ap_8").hide();
                $("#ap_7").hide();
                $("#ap_6").hide();
            }
            
            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max','5');

            break;
        case "6":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").show();
            $("#esp_aca_6").show();
            $("#esp_aca_7").hide();

            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo > 4)
            {
                $("#num_apoyo").val(4);

                $("#ap_10").hide();
                $("#ap_9").hide();
                $("#ap_8").hide();
                $("#ap_7").hide();
                $("#ap_6").hide();
                $("#ap_5").hide();
            }

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max','4');

            break;
        case "7":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").show();
            $("#esp_aca_6").show();
            $("#esp_aca_7").show();
            
            num_apoyo =$("#num_apoyo").val();
            if(num_apoyo > 3)
            {
                $("#num_apoyo").val(3);

                $("#ap_10").hide();
                $("#ap_9").hide();
                $("#ap_8").hide();
                $("#ap_7").hide();
                $("#ap_6").hide();
                $("#ap_5").hide();
                $("#ap_4").hide();
            }

            $("#num_apoyo").removeAttr('max');
            $("#num_apoyo").attr('max','3');
            
            break;

    }

    calc_viaticos_RP();

});

$("#ocul_integ").hide();

function ver_intg()
{
    var cant_integ = $("#cant_espa_aca").val();
    $("#ver_integ").hide();
    $("#ocul_integ").show();
    $("#cant_espa_aca").removeAttr("readonly","readonly");

    switch(cant_integ)
    {
        case "1":
            $("#esp_aca_1").show();
            $("#esp_aca_2").hide();
            $("#esp_aca_3").hide();
            $("#esp_aca_4").hide();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            $("#esp_aca_1").attr("required","required");
            $("#esp_aca_2").removeAttr("required","required");
            $("#esp_aca_3").removeAttr("required","required");
            $("#esp_aca_4").removeAttr("required","required");
            $("#esp_aca_5").removeAttr("required","required");
            $("#esp_aca_6").removeAttr("required","required");
            $("#esp_aca_7").removeAttr("required","required");
            break;
        case "2":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").hide();
            $("#esp_aca_4").hide();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            $("#esp_aca_1").attr("required","required");
            $("#esp_aca_2").attr("required","required");
            $("#esp_aca_3").removeAttr("required","required");
            $("#esp_aca_4").removeAttr("required","required");
            $("#esp_aca_5").removeAttr("required","required");
            $("#esp_aca_6").removeAttr("required","required");
            $("#esp_aca_7").removeAttr("required","required");
            break;
        case "3":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").hide();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            $("#esp_aca_1").attr("required","required");
            $("#esp_aca_2").attr("required","required");
            $("#esp_aca_3").attr("required","required");
            $("#esp_aca_4").removeAttr("required","required");
            $("#esp_aca_5").removeAttr("required","required");
            $("#esp_aca_6").removeAttr("required","required");
            $("#esp_aca_7").removeAttr("required","required");
            break;
        case "4":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").hide();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            $("#esp_aca_1").attr("required","required");
            $("#esp_aca_2").attr("required","required");
            $("#esp_aca_3").attr("required","required");
            $("#esp_aca_4").attr("required","required");
            $("#esp_aca_5").removeAttr("required","required");
            $("#esp_aca_6").removeAttr("required","required");
            $("#esp_aca_7").removeAttr("required","required");
            break;
        case "5":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").show();
            $("#esp_aca_6").hide();
            $("#esp_aca_7").hide();
            $("#esp_aca_1").attr("required","required");
            $("#esp_aca_2").attr("required","required");
            $("#esp_aca_3").attr("required","required");
            $("#esp_aca_4").attr("required","required");
            $("#esp_aca_5").attr("required","required");
            $("#esp_aca_6").removeAttr("required","required");
            $("#esp_aca_7").removeAttr("required","required");
            break;
        case "6":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").show();
            $("#esp_aca_6").show();
            $("#esp_aca_7").hide();
            $("#esp_aca_1").attr("required","required");
            $("#esp_aca_2").attr("required","required");
            $("#esp_aca_3").attr("required","required");
            $("#esp_aca_4").attr("required","required");
            $("#esp_aca_5").attr("required","required");
            $("#esp_aca_6").attr("required","required");
            $("#esp_aca_7").removeAttr("required","required");
            break;
        case "7":
            $("#esp_aca_1").show();
            $("#esp_aca_2").show();
            $("#esp_aca_3").show();
            $("#esp_aca_4").show();
            $("#esp_aca_5").show();
            $("#esp_aca_6").show();
            $("#esp_aca_7").show();
            $("#esp_aca_1").attr("required","required");
            $("#esp_aca_2").attr("required","required");
            $("#esp_aca_3").attr("required","required");
            $("#esp_aca_4").attr("required","required");
            $("#esp_aca_5").attr("required","required");
            $("#esp_aca_6").attr("required","required");
            $("#esp_aca_7").attr("required","required");
            break;

    }
}

function ocul_intg()
{
    var cant_integ = $("#cant_espa_aca").val();
    $("#ver_integ").show();
    $("#ocul_integ").hide();
    $("#cant_espa_aca").attr("readonly","readonly");

    $("#esp_aca_1").hide();
    $("#esp_aca_2").hide();
    $("#esp_aca_3").hide();
    $("#esp_aca_4").hide();
    $("#esp_aca_5").hide();
    $("#esp_aca_6").hide();
    $("#esp_aca_7").hide();
    $("#esp_aca_1").removeAttr("required","required");
    $("#esp_aca_2").removeAttr("required","required");
    $("#esp_aca_3").removeAttr("required","required");
    $("#esp_aca_4").removeAttr("required","required");
    $("#esp_aca_5").removeAttr("required","required");
    $("#esp_aca_6").removeAttr("required","required");
    $("#esp_aca_7").removeAttr("required","required");
    
}
/*Espacios Académicos prácticas integradas*/

/*ver trasnporte menor*/
$("#ocul_trans_menor_rp").hide();

function ver_t_menor_rp()
{
    cant_t_menor = $("#cant_trans_menor_rp").val();
    $("#ver_trans_menor_rp").hide();
    $("#ocul_trans_menor_rp").show();
    $("#cant_trans_menor_rp").removeAttr('readonly','readonly')

    switch(cant_t_menor)
    {
        case "1":
            $("#t_menor_rp_1").show();
            $("#trans_menor_rp_1").attr('required','required');
            $("#vlr_trans_menor_rp_1").attr('required','required');
            $("#t_menor_rp_2").hide();
            $("#trans_menor_rp_2").removeAttr('required','required');
            $("#vlr_trans_menor_rp_2").removeAttr('required','required');
            $("#t_menor_rp_3").hide();
            $("#trans_menor_rp_3").removeAttr('required','required');
            $("#vlr_trans_menor_rp_3").removeAttr('required','required');
            $("#t_menor_rp_4").hide();
            $("#trans_menor_rp_4").removeAttr('required','required');
            $("#vlr_trans_menor_rp_4").removeAttr('required','required');
            break;
        case "2":
            $("#t_menor_rp_1").show();
            $("#trans_menor_rp_1").attr('required','required');
            $("#vlr_trans_menor_rp_1").attr('required','required');
            $("#t_menor_rp_2").show();
            $("#trans_menor_rp_2").attr('required','required');
            $("#vlr_trans_menor_rp_2").attr('required','required');
            $("#t_menor_rp_3").hide();
            $("#trans_menor_rp_3").removeAttr('required','required');
            $("#vlr_trans_menor_rp_3").removeAttr('required','required');
            $("#t_menor_rp_4").hide();
            $("#trans_menor_rp_4").removeAttr('required','required');
            $("#vlr_trans_menor_rp_4").removeAttr('required','required');
            break;
        case "3":
            $("#t_menor_rp_1").show();
            $("#trans_menor_rp_1").attr('required','required');
            $("#vlr_trans_menor_rp_1").attr('required','required');
            $("#t_menor_rp_2").show();
            $("#trans_menor_rp_2").attr('required','required');
            $("#vlr_trans_menor_rp_2").attr('required','required');
            $("#t_menor_rp_3").show();
            $("#trans_menor_rp_3").attr('required','required');
            $("#vlr_trans_menor_rp_3").attr('required','required');
            $("#t_menor_rp_4").hide();
            $("#trans_menor_rp_4").removeAttr('required','required');
            $("#vlr_trans_menor_rp_4").removeAttr('required','required');
            break;
        case "4":
            $("#t_menor_rp_1").show();
            $("#trans_menor_rp_1").attr('required','required');
            $("#vlr_trans_menor_rp_1").attr('required','required');
            $("#t_menor_rp_2").show();
            $("#trans_menor_rp_2").attr('required','required');
            $("#vlr_trans_menor_rp_2").attr('required','required');
            $("#t_menor_rp_3").show();
            $("#trans_menor_rp_3").attr('required','required');
            $("#vlr_trans_menor_rp_3").attr('required','required');
            $("#t_menor_rp_4").show();
            $("#trans_menor_rp_4").attr('required','required');
            $("#vlr_trans_menor_rp_4").attr('required','required');
            break;
    }
}

function ocul_t_menor_rp()
{
    $("#ver_trans_menor_rp").show();
    $("#ocul_trans_menor_rp").hide();
    $("#cant_trans_menor_rp").attr('readonly','readonly')

    $("#t_menor_rp_1").hide();
    $("#trans_menor_rp_1").removeAttr('required','required');
    $("#vlr_trans_menor_rp_1").removeAttr('required','required');
    $("#t_menor_rp_2").hide();
    $("#trans_menor_rp_2").removeAttr('required','required');
    $("#vlr_trans_menor_rp_2").removeAttr('required','required');
    $("#t_menor_rp_3").hide();
    $("#trans_menor_rp_3").removeAttr('required','required');
    $("#vlr_trans_menor_rp_3").removeAttr('required','required');
    $("#t_menor_rp_4").hide();
    $("#trans_menor_rp_4").removeAttr('required','required');
    $("#vlr_trans_menor_rp_4").removeAttr('required','required');
}

$("#ocul_trans_menor_ra").hide();

function ver_t_menor_ra()
{
    cant_t_menor = $("#cant_trans_menor_ra").val();
    $("#ver_trans_menor_ra").hide();
    $("#ocul_trans_menor_ra").show();
    $("#cant_trans_menor_ra").removeAttr('readonly','readonly')

    switch(cant_t_menor)
    {
        case "1":
            $("#t_menor_ra_1").show();
            $("#trans_menor_ra_1").attr('required','required');
            $("#vlr_trans_menor_ra_1").attr('required','required');
            $("#t_menor_ra_2").hide();
            $("#trans_menor_ra_2").removeAttr('required','required');
            $("#vlr_trans_menor_ra_2").removeAttr('required','required');
            $("#t_menor_ra_3").hide();
            $("#trans_menor_ra_3").removeAttr('required','required');
            $("#vlr_trans_menor_ra_3").removeAttr('required','required');
            $("#t_menor_ra_4").hide();
            $("#trans_menor_ra_4").removeAttr('required','required');
            $("#vlr_trans_menor_ra_4").removeAttr('required','required');
            break;
        case "2":
            $("#t_menor_ra_1").show();
            $("#trans_menor_ra_1").attr('required','required');
            $("#vlr_trans_menor_ra_1").attr('required','required');
            $("#t_menor_ra_2").show();
            $("#trans_menor_ra_2").attr('required','required');
            $("#vlr_trans_menor_ra_2").attr('required','required');
            $("#t_menor_ra_3").hide();
            $("#trans_menor_ra_3").removeAttr('required','required');
            $("#vlr_trans_menor_ra_3").removeAttr('required','required');
            $("#t_menor_ra_4").hide();
            $("#trans_menor_ra_4").removeAttr('required','required');
            $("#vlr_trans_menor_ra_4").removeAttr('required','required');
            break;
        case "3":
            $("#t_menor_ra_1").show();
            $("#trans_menor_ra_1").attr('required','required');
            $("#vlr_trans_menor_ra_1").attr('required','required');
            $("#t_menor_ra_2").show();
            $("#trans_menor_ra_2").attr('required','required');
            $("#vlr_trans_menor_ra_2").attr('required','required');
            $("#t_menor_ra_3").show();
            $("#trans_menor_ra_3").attr('required','required');
            $("#vlr_trans_menor_ra_3").attr('required','required');
            $("#t_menor_ra_4").hide();
            $("#trans_menor_ra_4").removeAttr('required','required');
            $("#vlr_trans_menor_ra_4").removeAttr('required','required');
            break;
        case "4":
            $("#t_menor_ra_1").show();
            $("#trans_menor_ra_1").attr('required','required');
            $("#vlr_trans_menor_ra_1").attr('required','required');
            $("#t_menor_ra_2").show();
            $("#trans_menor_ra_2").attr('required','required');
            $("#vlr_trans_menor_ra_2").attr('required','required');
            $("#t_menor_ra_3").show();
            $("#trans_menor_ra_3").attr('required','required');
            $("#vlr_trans_menor_ra_3").attr('required','required');
            $("#t_menor_ra_4").show();
            $("#trans_menor_ra_4").attr('required','required');
            $("#vlr_trans_menor_ra_4").attr('required','required');
            break;
    }
}

function ocul_t_menor_ra()
{
    $("#ver_trans_menor_ra").show();
    $("#ocul_trans_menor_ra").hide();
    $("#cant_trans_menor_ra").attr('readonly','readonly');

    $("#t_menor_ra_1").hide();
    $("#trans_menor_ra_1").removeAttr('required','required');
    $("#vlr_trans_menor_ra_1").removeAttr('required','required');
    $("#t_menor_ra_2").hide();
    $("#trans_menor_ra_2").removeAttr('required','required');
    $("#vlr_trans_menor_ra_2").removeAttr('required','required');
    $("#t_menor_ra_3").hide();
    $("#trans_menor_ra_3").removeAttr('required','required');
    $("#vlr_trans_menor_ra_3").removeAttr('required','required');
    $("#t_menor_ra_4").hide();
    $("#trans_menor_ra_4").removeAttr('required','required');
    $("#vlr_trans_menor_ra_4").removeAttr('required','required');
}
/*ver trasnporte menor*/


/* ver rutas rp */
$("#rp_url_edit").hide();
$("#ocul_rutas_rp").hide();
function ver_rp()
{
    var cant_vehi = $("#cant_url_rp").val();
    $("#ver_rutas_rp").hide();
    $("#ocul_rutas_rp").show();
    $("#rp_url_edit").show();
    $("#cant_url_rp").removeAttr("readonly","readonly");

    switch(cant_vehi)
    {
        case "1":
            $("#rp_url_1").show();
            $("#rp_url_2").hide();
            $("#rp_url_3").hide();
            $("#rp_url_4").hide();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").removeAttr("required","required");
            $("#ruta_principal_3").removeAttr("required","required");
            $("#ruta_principal_4").removeAttr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            break;
        case "2":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").hide();
            $("#rp_url_4").hide();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").removeAttr("required","required");
            $("#ruta_principal_4").removeAttr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            break;
        case "3":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").hide();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").removeAttr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            break;
        case "4":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").show();
            $("#rp_url_5").hide();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").attr("required","required");
            $("#ruta_principal_5").removeAttr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            break;
        case "5":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").show();
            $("#rp_url_5").show();
            $("#rp_url_6").hide();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").attr("required","required");
            $("#ruta_principal_5").attr("required","required");
            $("#ruta_principal_6").removeAttr("required","required");
            break;
        case "6":
            $("#rp_url_1").show();
            $("#rp_url_2").show();
            $("#rp_url_3").show();
            $("#rp_url_4").show();
            $("#rp_url_5").show();
            $("#rp_url_6").show();
            $("#ruta_principal_2").attr("required","required");
            $("#ruta_principal_3").attr("required","required");
            $("#ruta_principal_4").attr("required","required");
            $("#ruta_principal_5").attr("required","required");
            $("#ruta_principal_6").attr("required","required");
            break;
    }
}

function ocul_rp()
{
    $("#ocul_rutas_rp").hide();
    $("#ver_rutas_rp").show();
    $("#rp_url_edit").hide();
    $("#cant_url_rp").attr("readonly","readonly");
}
/* ver rutas rp */

/* ver rutas ra */
$("#ra_url_edit").hide();
$("#ocul_rutas_ra").hide();

function ver_ra()
{
    var cant_vehi = $("#cant_url_ra").val();
    $("#ver_rutas_ra").hide();
    $("#ocul_rutas_ra").show();
    $("#ra_url_edit").show();    
    $("#cant_url_ra").removeAttr("readonly","readonly");

    switch(cant_vehi)
    {
        case "1":
            $("#ra_url_1").show();
            $("#ra_url_2").hide();
            $("#ra_url_3").hide();
            $("#ra_url_4").hide();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").removeAttr("required","required");
            $("#ruta_alterna_3").removeAttr("required","required");
            $("#ruta_alterna_4").removeAttr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            break;
        case "2":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").hide();
            $("#ra_url_4").hide();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").removeAttr("required","required");
            $("#ruta_alterna_4").removeAttr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            break;
        case "3":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").hide();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").removeAttr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            break;
        case "4":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").show();
            $("#ra_url_5").hide();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").attr("required","required");
            $("#ruta_alterna_5").removeAttr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            break;
        case "5":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").show();
            $("#ra_url_5").show();
            $("#ra_url_6").hide();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").attr("required","required");
            $("#ruta_alterna_5").attr("required","required");
            $("#ruta_alterna_6").removeAttr("required","required");
            break;
        case "6":
            $("#ra_url_1").show();
            $("#ra_url_2").show();
            $("#ra_url_3").show();
            $("#ra_url_4").show();
            $("#ra_url_5").show();
            $("#ra_url_6").show();
            $("#ruta_alterna_2").attr("required","required");
            $("#ruta_alterna_3").attr("required","required");
            $("#ruta_alterna_4").attr("required","required");
            $("#ruta_alterna_5").attr("required","required");
            $("#ruta_alterna_6").attr("required","required");
            break;
    }
}

function ocul_ra()
{
    $("#ocul_rutas_ra").hide();
    $("#ver_rutas_ra").show();
    $("#ra_url_edit").hide();    
}
/* ver rutas ra */

/* IR rutas - rp */
function ir_rp(id)
{
    var url = "";
    switch(id)
    {   
        case 1:
            url = $('#ruta_principal').val();
            window.open(url);
            break;
        case 2:
            url = $('#ruta_principal_'+id).val();
            window.open(url);
            break;
        case 3:
            url = $('#ruta_principal_'+id).val();
            window.open(url);
            break;
        case 4:
            url = $('#ruta_principal_'+id).val();
            window.open(url);
            break;     
        case 5:
            url = $('#ruta_principal_'+id).val();
            window.open(url);
            break;
        case 6:
            url = $('#ruta_principal_'+id).val();
            window.open(url);
            break;   

    }
}
/* IR rutas - rp */

/* IR rutas - ra */
function ir_ra(id)
{
    var url = "";
    switch(id)
    {   
        case 1:
            url = $('#ruta_alterna').val();
            window.open(url);
            break;
        case 2:
            url = $('#ruta_alterna_'+id).val();
            window.open(url);
            break;
        case 3:
            url = $('#ruta_alterna_'+id).val();
            window.open(url);
            break;
        case 4:
            url = $('#ruta_alterna_'+id).val();
            window.open(url);
            break;     
        case 5:
            url = $('#ruta_alterna_'+id).val();
            window.open(url);
            break;
        case 6:
            url = $('#ruta_alterna_'+id).val();
            window.open(url);
            break;   

    }
}
/* IR rutas - ra */

/* comprobar url rutas */
function verifUrl_rp(input)
{
    var url_rp = input.value;
    var nameButton_rp = input.name;
    var iniciales = url_rp.startsWith("https://www.google.com/maps/dir/");
    var indice_rp = nameButton_rp.charAt(nameButton_rp.length -1);

    if(iniciales == true)
    {
        switch(indice_rp)
        {
            case "l":
                $('#btnVer_url_rp_1').css("pointer-events","auto");
                $('#btnVer_url_rp_1').addClass("btn-success");
                $('#btnVer_url_rp_1').css("background-color","#083f14");
                $('#btnVer_url_rp_1').css("border-color","#083f14");
                break;
            case "2":
                $('#btnVer_url_rp_2').css("pointer-events","auto");
                $('#btnVer_url_rp_2').addClass("btn-success");
                $('#btnVer_url_rp_2').css("background-color","#083f14");
                $('#btnVer_url_rp_2').css("border-color","#083f14");
                break;
            case "3":
                $('#btnVer_url_rp_3').css("pointer-events","auto");
                $('#btnVer_url_rp_3').addClass("btn-success");
                $('#btnVer_url_rp_3').css("background-color","#083f14");
                $('#btnVer_url_rp_3').css("border-color","#083f14");
                break;
            case "4":
                $('#btnVer_url_rp_4').css("pointer-events","auto");
                $('#btnVer_url_rp_4').addClass("btn-success");
                $('#btnVer_url_rp_4').css("background-color","#083f14");
                $('#btnVer_url_rp_4').css("border-color","#083f14");
                break;     
            case "5":
                $('#btnVer_url_rp_5').css("pointer-events","auto");
                $('#btnVer_url_rp_5').addClass("btn-success");
                $('#btnVer_url_rp_5').css("background-color","#083f14");
                $('#btnVer_url_rp_5').css("border-color","#083f14");
                break;
            case "6":
                $('#btnVer_url_rp_6').css("pointer-events","auto");
                $('#btnVer_url_rp_6').addClass("btn-success");
                $('#btnVer_url_rp_6').css("background-color","#083f14");
                $('#btnVer_url_rp_6').css("border-color","#083f14");
                break;   
        }
        $(input).css("borderColor","#d1d3e2");
    }
    else if(iniciales == false)
    {
        $(input).css("borderColor","red");
        
        switch(indice_rp)
        {
            case "l":
                $('#btnVer_url_rp_1').css("pointer-events","none");
                $('#btnVer_url_rp_1').removeClass("btn-success");
                $('#btnVer_url_rp_1').css("background-color","#447161");
                $('#btnVer_url_rp_1').css("border-color","#447161");
                break;
            case "2":
                $('#btnVer_url_rp_2').css("pointer-events","none");
                $('#btnVer_url_rp_2').removeClass("btn-success");
                $('#btnVer_url_rp_2').css("background-color","#447161");
                $('#btnVer_url_rp_2').css("border-color","#447161");
                break;
            case "3":
                $('#btnVer_url_rp_3').css("pointer-events","none");
                $('#btnVer_url_rp_3').removeClass("btn-success");
                $('#btnVer_url_rp_3').css("background-color","#447161");
                $('#btnVer_url_rp_3').css("border-color","#447161");
                break;
            case "4":
                $('#btnVer_url_rp_4').css("pointer-events","none");
                $('#btnVer_url_rp_4').removeClass("btn-success");
                $('#btnVer_url_rp_4').css("background-color","#447161");
                $('#btnVer_url_rp_4').css("border-color","#88c944716146");
                break;     
            case "5":
                $('#btnVer_url_rp_5').css("pointer-events","none");
                $('#btnVer_url_rp_5').removeClass("btn-success");
                $('#btnVer_url_rp_5').css("background-color","#447161");
                $('#btnVer_url_rp_5').css("border-color","#447161");
                break;
            case "6":
                
                $('#btnVer_url_rp_6').css("pointer-events","none");
                $('#btnVer_url_rp_6').removeClass("btn-success");
                $('#btnVer_url_rp_6').css("background-color","#447161");
                $('#btnVer_url_rp_6').css("border-color","#447161");
                break;  
        }
        var pt = $("#msg_modal_rp_t");
        var pc = $("#msg_modal_rp_c");
        var pb = $("#msg_modal_rp_b");
        var ct = pt.children();
        var cc = pc.children();
        var cb = pb.children();
        pt.text("El formato ingresado es incorrecto.");
        pc.text("Puede verificar en el manual de usuario el formato correcto.");
        pb.text("El formato ingresado es incorrecto.");
        pt.append(ct);
        pc.append(cc);
        pb.append(cb);

        $("#modal_rp").modal();
        // alert("El formato ingresado es equivocado.\nPuede verificar en el manual de usuario el formato adecuado.\n");
    }

}

function verifUrl_ra(input)
{
    var url_ra = input.value;
    var nameButton_ra = input.name;
    var iniciales = url_ra.startsWith("https://www.google.com/maps/dir/");
    var indice_ra = nameButton_ra.charAt(nameButton_ra.length -1);
    
    if(iniciales == true)
    {
        switch(indice_ra)
        {
            case "a":
                $('#btnVer_url_ra_1').css("pointer-events","auto");
                $('#btnVer_url_ra_1').addClass("btn-success");
                $('#btnVer_url_ra_1').css("background-color","#083f14");
                $('#btnVer_url_ra_1').css("border-color","#083f14");
                break;
            case "2":
                $('#btnVer_url_ra_2').css("pointer-events","auto");
                $('#btnVer_url_ra_2').addClass("btn-success");
                $('#btnVer_url_ra_2').css("background-color","#083f14");
                $('#btnVer_url_ra_2').css("border-color","#083f14");
                break;
            case "3":
                $('#btnVer_url_ra_3').css("pointer-events","auto");
                $('#btnVer_url_ra_3').addClass("btn-success");
                $('#btnVer_url_ra_3').css("background-color","#083f14");
                $('#btnVer_url_ra_3').css("border-color","#083f14");
                break;
            case "4":
                $('#btnVer_url_ra_4').css("pointer-events","auto");
                $('#btnVer_url_ra_4').addClass("btn-success");
                $('#btnVer_url_ra_4').css("background-color","#083f14");
                $('#btnVer_url_ra_4').css("border-color","#083f14");
                break;     
            case "5":
                $('#btnVer_url_ra_5').css("pointer-events","auto");
                $('#btnVer_url_ra_5').addClass("btn-success");
                $('#btnVer_url_ra_5').css("background-color","#083f14");
                $('#btnVer_url_ra_5').css("border-color","#083f14");
                break;
            case "6":
                $('#btnVer_url_ra_6').css("pointer-events","auto");
                $('#btnVer_url_ra_6').addClass("btn-success");
                $('#btnVer_url_ra_6').css("background-color","#083f14");
                $('#btnVer_url_ra_6').css("border-color","#083f14");
                break;   
        }
        $(input).css("borderColor","#d1d3e2");
    }
    else if(iniciales == false)
    {
        $(input).css("borderColor","red");

        switch(indice_ra)
        {
            case "a":
                $('#btnVer_url_ra_1').css("pointer-events","none");
                $('#btnVer_url_ra_1').removeClass("btn-success");
                $('#btnVer_url_ra_1').css("background-color","#447161");
                $('#btnVer_url_ra_1').css("border-color","#447161");
                break;
            case "2":
                $('#btnVer_url_ra_2').css("pointer-events","none");
                $('#btnVer_url_ra_2').removeClass("btn-success");
                $('#btnVer_url_ra_2').css("background-color","#447161");
                $('#btnVer_url_ra_2').css("border-color","#447161");
                break;
            case "3":
                $('#btnVer_url_ra_3').css("pointer-events","none");
                $('#btnVer_url_ra_3').removeClass("btn-success");
                $('#btnVer_url_ra_3').css("background-color","#447161");
                $('#btnVer_url_ra_3').css("border-color","#447161");
                break;
            case "4":
                $('#btnVer_url_ra_4').css("pointer-events","none");
                $('#btnVer_url_ra_4').removeClass("btn-success");
                $('#btnVer_url_ra_4').css("background-color","#447161");
                $('#btnVer_url_ra_4').css("border-color","#447161");
                break;     
            case "5":
                $('#btnVer_url_ra_5').css("pointer-events","none");
                $('#btnVer_url_ra_5').removeClass("btn-success");
                $('#btnVer_url_ra_5').css("background-color","#447161");
                $('#btnVer_url_ra_5').css("border-color","#447161");
                break;
            case "6":
                
                $('#btnVer_url_ra_6').css("pointer-events","none");
                $('#btnVer_url_ra_6').removeClass("btn-success");
                $('#btnVer_url_ra_6').css("background-color","#447161");
                $('#btnVer_url_ra_6').css("border-color","#447161");
                break;   
        }
        
        var pt = $("#msg_modal_ra_t");
        var pc = $("#msg_modal_ra_c");
        var pb = $("#msg_modal_ra_b");
        var ct = pt.children();
        var cc = pc.children();
        var cb = pb.children();
        pt.text("El formato ingresado es incorrecto.");
        pc.text("Puede verificar en el manual de usuario el formato correcto.");
        pb.text("El formato ingresado es incorrecto.");
        pt.append(ct);
        pc.append(cc);
        pb.append(cb);

        $("#modal_ra").modal();
    }
    
}
/* comprobar url rutas */

/* IR rutas - rp */
function ir_sal_lleg_rp(opc)
{
    url = "";
    switch(opc)
    {
        case 1:
            url = $("#lugar_salida_rp").val();
            break;
        case 2:
            url = $("#lugar_regreso_rp").val();
            break;
    }
    window.open(url);
}
/* IR rutas - rp */

/* IR rutas - ra */
function ir_sal_lleg_ra(opc)
{
    url = "";
    switch(opc)
    {
        case 1:
            url = $("#lugar_salida_ra").val();
            break;
        case 2:
            url = $("#lugar_regreso_ra").val();
            break;
    }
    window.open(url);
}
/* IR rutas - ra */

/* comprobar lugar salida - regreso -rp*/
function verf_rp(input,opc)
{
    var url_sal_lleg_rp = input.value;
    var iniciales = url_sal_lleg_rp.startsWith("https://www.google.com/maps/dir/");

    if(iniciales == true)
    {
        $(input).css("borderColor","#d1d3e2");
        
        switch(opc)
        {
            case 1:
                $('#btnVer_sal_rp').css("pointer-events","auto");
                $('#btnVer_sal_rp').addClass("btn-success");
                $('#btnVer_sal_rp').css("background-color","#447161");
                $('#btnVer_sal_rp').css("border-color","#447161");
                break;
            case 2:
                $('#btnVer_reg_rp').css("pointer-events","auto");
                $('#btnVer_reg_rp').addClass("btn-success");
                $('#btnVer_reg_rp').css("background-color","#447161");
                $('#btnVer_reg_rp').css("border-color","#447161");
                break;
        }
    }
    else if(iniciales == false)
    {
        $(input).css("borderColor","red");
        
        switch(opc)
        {
            case 1:
                $('#btnVer_sal_rp').css("pointer-events","none");
                $('#btnVer_sal_rp').removeClass("btn-success");
                $('#btnVer_sal_rp').css("background-color","#83bfaa");
                $('#btnVer_sal_rp').css("border-color","#83bfaa");
                break;
            case 2:
                $('#btnVer_reg_rp').css("pointer-events","none");
                $('#btnVer_reg_rp').removeClass("btn-success");
                $('#btnVer_reg_rp').css("background-color","#83bfaa");
                $('#btnVer_reg_rp').css("border-color","#83bfaa");
                break;
        }
        
        var pt = $("#msg_modal_rp_t");
        var pc = $("#msg_modal_rp_c");
        var pb = $("#msg_modal_rp_b");
        var ct = pt.children();
        var cc = pc.children();
        var cb = pb.children();
        pt.text("El formato ingresado es incorrecto.");
        pc.text("Puede verificar en el manual de usuario el formato correcto.");
        pb.text("El formato ingresado es incorrecto.");
        pt.append(ct);
        pc.append(cc);
        pb.append(cb);

        $("#modal_rp").modal();
    }

}
/* comprobar lugar salida - regreso -rp*/

/* comprobar lugar salida - regreso -ra*/
function verf_ra(input,opc)
{
    var url_sal_lleg_ra = input.value;
    var iniciales = url_sal_lleg_ra.startsWith("https://www.google.com/maps/dir/");

    if(iniciales == true)
    {
        switch(opc)
        {
            case 1:
                $('#btnVer_sal_ra').css("pointer-events","auto");
                $('#btnVer_sal_ra').addClass("btn-success");
                $('#btnVer_sal_ra').css("background-color","#447161");
                $('#btnVer_sal_ra').css("border-color","#447161");
                break;
            case 2:
                $('#btnVer_reg_ra').css("pointer-events","auto");
                $('#btnVer_reg_ra').addClass("btn-success");
                $('#btnVer_reg_ra').css("background-color","#447161");
                $('#btnVer_reg_ra').css("border-color","#447161");
                break;
        }

        $(input).css("borderColor","#d1d3e2");
    }
    else if(iniciales == false)
    {
        $(input).css("borderColor","red");

        switch(opc)
        {
            case 1:
                $('#btnVer_sal_ra').css("pointer-events","none");
                $('#btnVer_sal_ra').removeClass("btn-success");
                $('#btnVer_sal_ra').css("background-color","#83bfaa");
                $('#btnVer_sal_ra').css("border-color","#83bfaa");
                break;
            case 2:
                $('#btnVer_reg_ra').css("pointer-events","none");
                $('#btnVer_reg_ra').removeClass("btn-success");
                $('#btnVer_reg_ra').css("background-color","#83bfaa");
                $('#btnVer_reg_ra').css("border-color","#83bfaa");
                break;
        }
        
        var pt = $("#msg_modal_ra_t");
        var pc = $("#msg_modal_ra_c");
        var pb = $("#msg_modal_ra_b");
        var ct = pt.children();
        var cc = pc.children();
        var cb = pb.children();
        pt.text("El formato ingresado es incorrecto.");
        pc.text("Puede verificar en el manual de usuario el formato correcto.");
        pb.text("El formato ingresado es incorrecto.");
        pt.append(ct);
        pc.append(cc);
        pb.append(cb);

        $("#modal_ra").modal();
    }
}
/* comprobar lugar salida - regreso -ra*/

/* Personas Mayores de Edad */
$("#permiso_acudiente").hide();
function mayorEdad(dateText)
{
    var hoy = new Date();
    var fecha_naci =  new Date($('#fecha_nacimiento').val());
    fecha_naci.setDate(fecha_naci.getDate() + 1);
    var milis_dias = 86400000;
    var dif_milis = hoy - fecha_naci;
    var dif_dias = dif_milis / milis_dias + 1;
    var edad = dif_dias / 365;

    if(edad < 18)
    {
        $("#permiso_acudiente").show();
    }
    else if(edad >=18)
    {
        $("#permiso_acudiente").hide();
    }
}
/* Personas Mayores de Edad */

function valid_edit_proy()
{
    var ra_edit = $("input[id*='capac_transporte_ra_[]']");
    var hhh = document.getElementById("capac_transporte_ra_[]");
    //var h1 = ra_edit[0].value().length;
    //alert(hhh.length);
    if(hhh==0){
        alert("Colocar la capacidad del vehiculo");
        document.getElementById("capac_transporte_ra_[]").focus();
        return 0;
    }

    //alert("Gracias LV");
    document.edit_proyeccion.submit();
}

/* acordeon preguntas */
var acc = document.getElementsByName("accPregFrec");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
/* acordeon preguntas */

/* no conformidades transporte */

$("#no_conf_trans_1").hide();
$("#no_conf_trans_2").hide();
$("#no_conf_trans_3").hide();
$("#no_conf_trans_4").hide();
$("#no_conf_trans_5").hide();
$("#no_conf_trans_6").hide();
$("#no_conf_trans_7").hide();

function no_conf_trans(input, type)
{
    if($(input).is(':checked'))
    {
        switch(type)
        {
            case 1:
                $("#no_conf_trans_1").hide();
                $("#no_cumplio_expect").removeAttr('required','required');
                break;
            case 2:
                $("#no_conf_trans_2").hide();
                $("#no_ruta_prevista").removeAttr('required','required');
                break;
            case 3:
                $("#no_conf_trans_3").hide();
                $("#no_carac_solicitadas").removeAttr('required','required');
                break;
            case 4:
                $("#no_conf_trans_4").hide();
                $("#comport_adecuado").removeAttr('required','required');
                break;
            case 5:
                $("#no_conf_trans_5").hide();
                $("#no_horar_estab").removeAttr('required','required');
                break;
            case 6:
                $("#no_conf_trans_6").show();
                $("#con_nov_cron_ruta").attr('required','required');
                break;
            case 7:
                $("#no_conf_trans_7").hide();
                $("#no_adecuado_traslado").removeAttr('required','required');
                break;

        }
    }

    else if($(input).not(':checked'))
    {
        switch(type)
        {
            case 1:
                $("#no_conf_trans_1").show();
                $("#no_cumplio_expect").attr('required','required');
                break;
            case 2:
                $("#no_conf_trans_2").show();
                $("#no_ruta_prevista").attr('required','required');
                break;
            case 3:
                $("#no_conf_trans_3").show();
                $("#no_carac_solicitadas").attr('required','required');
                break;
            case 4:
                $("#no_conf_trans_4").show();
                $("#no_comport_adecuado").attr('required','required');
                break;
            case 5:
                $("#no_conf_trans_5").show();
                $("#no_horar_estab").attr('required','required');
                break;
            case 6:
                $("#no_conf_trans_6").hide();
                $("#con_nov_cron_ruta").removeAttr('required','required');
                break;
            case 7:
                $("#no_conf_trans_7").show();
                $("#no_adecuado_traslado").attr('required','required');
                break;

        }
    }
}
/* no conformidades transporte */

/* ADMIN_INTEGRADAS */

function admin_integradas(cant_int, num_apoyo)
{
    num_max_apoyo = 10 - cant_int;

    $("#num_apoyo").removeAttr('max');
    $("#num_apoyo").attr('max',num_max_apoyo);

    // switch(cant_int)
    // {
    //     case "1":
    //         num_apoyo =$("#num_apoyo").val();
    //         $("#num_apoyo").val(num_apoyo-cant_int);

    //         break;
    //     case "2":
    //         num_apoyo =$("#num_apoyo").val();
    //         $("#num_apoyo").removeAttr('max');
    //         $("#num_apoyo").attr('max',num_apoyo-cant_int);
    //         $("#num_apoyo").val(num_apoyo-cant_int);
    //         break;
    //     case "3":
    //         num_apoyo =$("#num_apoyo").val();
    //         $("#num_apoyo").removeAttr('max');
    //         $("#num_apoyo").attr('max',num_apoyo-cant_int);
    //         $("#num_apoyo").val(num_apoyo-cant_int);
    //         break;
    //     case "4":
    //         num_apoyo =$("#num_apoyo").val();
    //         $("#num_apoyo").removeAttr('max');
    //         $("#num_apoyo").attr('max',num_apoyo-cant_int);
    //         $("#num_apoyo").val(num_apoyo-cant_int);
    //         break;
    //     case "5":
    //         num_apoyo =$("#num_apoyo").val();
    //         $("#num_apoyo").removeAttr('max');
    //         $("#num_apoyo").attr('max',num_apoyo-cant_int);
    //         $("#num_apoyo").val(num_apoyo-cant_int);
    //         break;
    //     case "6":
    //         num_apoyo =$("#num_apoyo").val();
    //         $("#num_apoyo").removeAttr('max');
    //         $("#num_apoyo").attr('max',num_apoyo-cant_int);
    //         $("#num_apoyo").val(num_apoyo-cant_int);
    //         break;
    //     case "7":
    //         num_apoyo =$("#num_apoyo").val();
    //         $("#num_apoyo").removeAttr('max');
    //         $("#num_apoyo").attr('max',num_apoyo-cant_int);
    //         $("#num_apoyo").val(num_apoyo-cant_int);
            
    //         break;

    // }

}
/* ADMIN_INTEGRADAS */

/* no conformidades transporte */

/* buscador proyección */
$("input[name='proyeccion_list[]']").change('keypress', function(){

    var list_proy_sel = [];
    var cont_proy_sel = 0;
        for (i=0;i<document.proy_buscador.elements.length;i++)
        {
    
            if(document.proy_buscador.elements[i].type == "checkbox")
            {
        
                if(document.proy_buscador.elements[i].checked == true)
                {
                    list_proy_sel[cont_proy_sel] = document.proy_buscador.elements[i].value;
                    cont_proy_sel++;
                }
            }
        }
    
    

    var check_confirm = [];
    check_confirm=list_proy_sel;

    url = '/sel_proy/buscador';

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type: 'POST',
        cache: false,
        data: {'data':check_confirm},                
        // beforeSend: function(xhr){
        // xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        // },
        success:function(respu){
            console.log(respu);

            window.location = page;
            // if ( jQuery.isEmptyObject(respu) || respu == null) {
            //     // $("#resp_consulta").val('Código no disponible para el programa seleccionado');
            // }
                            
            },
            error: function(xhr, textStatus, thrownError) {
                
            }
        });
});
/* buscador proyección */

/* observ. inactividad proyecciones */
$('#div_obs_inact_proy').hide();
function obsInactProy(inactProy)
{
    var est_inact_proy = inactProy.value;

    if(est_inact_proy == 1)
    {
        $('#div_obs_inact_proy').hide();
        $('#obs_inact_proy').removeAttr('required','required');
    }
    else if(est_inact_proy == 2)
    {
        $('#div_obs_inact_proy').show();
        $('#obs_inact_proy').attr('required','required');
    }
}
/* observ. inactividad proyecciones */

/* observ. inactividad solicitudes */

/* observ. inactividad solicitudes */
function validar_realizada_bogota() {
    const realizadaBogotaRP = document.getElementsByName('realizada_bogota_rp');
    const realizadaBogotaRA = document.getElementsByName('realizada_bogota_ra');

    function isRadioSelected(radioGroup) {
        for (const radio of radioGroup) {
            if (radio.checked) {
                return true;
            }
        }
        return false;
    }
    if (!isRadioSelected(realizadaBogotaRP)) {
        alert("Debe seleccionar si la práctica se realizará en Bogotá o no\nEn: Ruta Principal");
        realizadaBogotaRP[0].focus();
        return false;
    }
    if (!isRadioSelected(realizadaBogotaRA)) {
        alert("Debe seleccionar si la práctica se realizará en Bogotá o no\nEn: Ruta de Contingencia");
        realizadaBogotaRA[0].focus();
        return false;
    }
    return true; 
}

function confirmarGuardarPresupuesto(event) {
    const confirmar = confirm('¿Estás seguro(a) de que deseas guardar los cambios?');

    if (!confirmar) {
        event.preventDefault();
        return false;
    }

    return true;
}

function ver_estudiantes(){
    const tabla = document.getElementById('tabla_estudiantes');
    const icono = document.getElementById('icono_ver_estud');
    
    if (tabla.hasAttribute('hidden')) {
        tabla.removeAttribute('hidden');
    } else {
        tabla.setAttribute('hidden', '');
    }
    icono.classList.toggle('fa-eye');
    icono.classList.toggle('fa-eye-slash');
}

function rechazo_solic_asist(){
    const rdbtn_pendiente = document.querySelector('input[name="aprobacion_asistD"][value="5"]');
    const rdbtn_aprobado = document.querySelector('input[name="aprobacion_asistD"][value="7"]');
    const si_capital = document.querySelector('input[name="si_capital"][value="1"]');
    const no_capital = document.querySelector('input[name="si_capital"][value="0"]');
    const sol_necesidad = document.getElementById('num_solicitud_necesidad');
    const num_resolucion = document.getElementById('num_resolucion');
    const fecha_resolucion = document.getElementById('fecha_resolucion');
    const num_cdp = document.getElementById('num_cdp');
    if (rdbtn_aprobado.checked) {
        si_capital.disabled = false;
        no_capital.disabled = false;
        sol_necesidad.disabled = false;
        num_resolucion.disabled = false;
        fecha_resolucion.disabled = false;
        num_cdp.disabled = false;
    } else {
        si_capital.disabled = true;
        no_capital.disabled = true;
        sol_necesidad.disabled = true;
        num_resolucion.disabled = true;
        fecha_resolucion.disabled = true;
        num_cdp.disabled = true;
    }
}

function checkEmptyInput(input) {
    if (input.value.trim() === "") {
        input.value = "0";
    }
}

function clearDefaultValue(input) {
    if (input.value === "0") {
        input.value = "";
    }
}

function restoreDefaultValue(input) {
    if (input.value.trim() === "") {
        input.value = "0";
    }
}

function habilitar_inputs_cambios(formId) {
    const form = document.getElementById(formId);

    if (form) {
        const integradaNo = document.querySelector('input[name="integrada"][value="0"]');
        const integradaSi = document.querySelector('input[name="integrada"][value="1"]');
        const cantEstAca = document.getElementById('cant_espa_aca');

        integradaNo.addEventListener('change', toggleCantEstAca);
        integradaSi.addEventListener('change', toggleCantEstAca);

        if (integradaNo && integradaSi && cantEstAca) {

            toggleCantEstAca();

            integradaNo.addEventListener('change', toggleCantEstAca);
            integradaSi.addEventListener('change', toggleCantEstAca);

            function toggleCantEstAca() {
                if (integradaNo.checked) {
                    cantEstAca.setAttribute('readonly', '');
                } else {
                    cantEstAca.removeAttribute('readonly');
                }
            }
        }
        ver_rp();
        ver_ra();
        ver_vehic();
        ver_vehic_ra();

        function inputs_div() {
            const div = document.getElementById('transporte_rp_2_edit');
            if (div) {
                const inputs = div.querySelectorAll('input, select, textarea, button');
                inputs.forEach(input => {
                    input.required = false;
                });
            }

            const div2 = document.getElementById('transporte_rp_3_edit');
            if (div2) {
                const inputs = div2.querySelectorAll('input, select, textarea, button');
                inputs.forEach(input => {
                    input.required = false;
                });
            }

            const docente_resp_t_menor_rp = document.getElementById('docente_resp_t_menor_rp');
            docente_resp_t_menor_rp.removeAttribute('required');

            const docente_resp_t_menor_ra = document.getElementById('docente_resp_t_menor_ra');
            docente_resp_t_menor_ra.removeAttribute('required');

            const div3 = document.getElementById('transporte_ra_2_edit');
            if (div3) {
                const inputs = div3.querySelectorAll('input, select, textarea, button');
                inputs.forEach(input => {
                    input.required = false;
                });
            }

            const div4 = document.getElementById('transporte_ra_3_edit');
            if (div4) {
                const inputs = div4.querySelectorAll('input, select, textarea, button');
                inputs.forEach(input => {
                    input.required = false;
                });
            }

        }
        inputs_div();
    } else {
        console.error(`No se encontró un formulario con el ID "${formId}"`);
    }
}
