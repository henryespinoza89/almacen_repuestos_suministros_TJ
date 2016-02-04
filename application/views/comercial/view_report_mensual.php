<?php
    if ($this->input->post('fechainicial')){
	    $fechainicial = array('name'=>'fechainicial','id'=>'fechainicial','maxlength'=>'10','value'=>$this->input->post('fechainicial'), 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
	}else{
	    $fechainicial = array('name'=>'fechainicial','id'=>'fechainicial','maxlength'=>'10', 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
	}

	if ($this->input->post('fechafinal')){
	    $fechafinal = array('name'=>'fechafinal','id'=>'fechafinal','maxlength'=>'10','value'=>$this->input->post('fechafinal'), 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
	}else{
	    $fechafinal = array('name'=>'fechafinal','id'=>'fechafinal','maxlength'=>'10', 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
	}
?>

<script type="text/javascript">
	$(function(){

		$("#export_report_mensual").click(function(){
    		var fechainicial = $("#fechainicial").val();
    		var fechafinal = $("#fechafinal").val();

    		if( fechainicial == '' || fechafinal == ''){
				$("#modalerror").html('<strong>!Todos los Campos del Formulario son Obligatorios. Verificar!</strong>').dialog({
		            modal: true,position: 'center',width: 450, height: 125,resizable: false,title: 'Validación de Registro',hide: 'blind',show: 'blind',
		          	buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
		        });
			}else{
				var array_json = Array();

	    		array_json[0] = fechainicial;
	    		array_json[1] = fechafinal;
	    		// Lo convierto a objeto
			    var jObject = {};

			    for(i in array_json)
			    {
			        jObject[i] = array_json[i];
			    }
			    // Luego lo paso por JSON  a un archivo php llamado js.php
			    jObject= JSON.stringify(jObject);
	    		
	    		url = '<?php echo base_url(); ?>comercial/al_exportar_report_factura_mensual/'+jObject;
	    		$(location).attr('href',url);
			}
    	});

	    $("#fechainicial").datepicker({ 
			dateFormat: 'yy-mm-dd',showOn: "button",
			buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
			buttonImageOnly: true,
		    changeMonth: true,
		    changeYear: true
		});
		$(".ui-datepicker-trigger").css('padding-left','7px');

		$("#fechafinal").datepicker({ 
			dateFormat: 'yy-mm-dd',showOn: "button",
			buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
			buttonImageOnly: true,
		    changeMonth: true,
		    changeYear: true
		});
		$(".ui-datepicker-trigger").css('padding-left','7px');
	    
	});
</script>

</head>
<body>
    <div id="contenedor" style="">
    	<div id="tituloCont" style="margin-bottom:0px;width: 1380px;">Reporte Mensual</div>
    	<div id="formFiltro" style="background: whitesmoke;padding-top: 5px;padding-left: 15px;padding-bottom: 15px;border-bottom: 1px solid #000;">
			<table width="703" border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
				<tr>
	                <td width="103" height="30">Fecha de Inicio:</td>
	                <td width="156" height="30"><?php echo form_input($fechainicial);?></td>
	                <td width="81" height="30">Fecha Final:</td>
	                <td width="168" height="30"><?php echo form_input($fechafinal);?></td>
                    <td width="195"><input name="submit" type="submit" id="export_report_mensual" class="export_report_mensual" value="Generar Reporte" style="background-color: #4B8A08;width: 140px;margin-bottom: 6px;" /></td>
	            </tr>
			</table>
		</div>
    </div>
    <div id="modalerror"></div>