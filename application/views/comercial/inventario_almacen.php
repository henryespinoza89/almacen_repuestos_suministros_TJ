<script type="text/javascript">
	$(function(){
		$("#report_kardex_excel").click(function(){
			var area_combo = $("#area").val();

			var array_json = Array();
			array_json[0] = area_combo;

			var jObject = {};
			for(i in array_json){
		        jObject[i] = array_json[i];
		    }
		    jObject= JSON.stringify(jObject);

    		url = '<?php echo base_url(); ?>comercial/al_exportar_inventario_almacen/'+jObject;
    		$(location).attr('href',url);
    	});

    	$("#area").append('<option value="" selected="selected">:: SELECCIONE EL ÁREA DEL PRODUCTO ::</option>');
	});
</script>

</head>
<body>
    <div id="contenedor" style="">
    	<div id="tituloCont" style="margin-bottom:0px;width: 1380px;">Inventario de Almacén</div>
    	<div id="formFiltro" style="background: whitesmoke;padding-top: 25px;padding-left: 15px;padding-bottom: 25px;border-bottom: 1px solid #000;">
			<table width="900" border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
				<tr>
	                <td width="320" height="30" style="padding-bottom: 4px;">La Fecha considerada para el reporte es la del sistema: <?php echo date('d-m-y');?></td>
	                <td style="width: 200px;">
	                	<?php echo form_dropdown('area',$listaarea,'',"id='area' style='margin-left: 0px;width: 250px;height: 25px;'");?>
              		</td>
                    <td width="195"><input name="submit" type="submit" id="report_kardex_excel" class="report_kardex_excel" value="EXPORTAR INVENTARIO" style="padding-bottom:5px; padding-top:5px; margin-bottom: 4px; background-color: #FF5722; border-radius:6px; width:180px;padding-left: 13px;" /></td>
	            </tr>
			</table>
		</div>
    </div>
    <div id="modalerror"></div>