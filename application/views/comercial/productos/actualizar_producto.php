<script type="text/javascript">
	$(function(){
		$("#editcat").change(function() {
			$("#editcat option:selected").each(function() {
		        categoria = $('#editcat').val();
		        $.post("<?php echo base_url(); ?>comercial/traeTipo", {
		            categoria : categoria , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
		        }, function(data) {
		            $("#edittipoprod").html(data);
		        });
			});
		});
	});
</script>

<div id="contenedor" style="width:300px; height:350px;">
	<div id="tituloCont">Editar Producto</div>
	<div id="formFiltro" style="width:500px;">
		<?php 
			$existe = count($datosprod);
			if($existe <= 0){
				echo 'El Producto no existe en la Base de Datos.';
			}
			else
			{
		?>
    	<form style="border-bottom:0px">
	    	<table>
	    	<?php
				$i=1;
				foreach($datosprod as $prod){
				#Datos del USUARIO
				$editidprod = array('name'=>'editidprod','id'=>'editidprod','maxlength'=>'20', 'value'=>$prod->id_producto, 'style'=>'width:150px');
				$editnombreprod = array('name'=>'editnombreprod','id'=>'editnombreprod','maxlength'=>'100', 'value'=>$prod->no_producto, 'style'=>'width:150px');
				$editobser = array('name'=>'editobser','id'=>'editobser','maxlength'=>'60', 'value'=>$prod->observacion, 'style'=>'width:150px');
				$editindicador = array('name'=>'editindicador','id'=>'editindicador','maxlength'=>'60', 'value'=>$prod->column_temp, 'style'=>'width:150px');
				$editestado = array('t'=>'ACTIVO', 'f'=>'INACTIVO',);
			?>
				<script type="text/javascript">
             		$("#editcat option[value='<?php echo $prod->id_categoria;?>']").attr("selected",true);
             		$("#editprocedencia option[value='<?php echo $prod->id_procedencia;?>']").attr("selected",true);
             		$("#edittipoprod option[value='<?php echo $prod->id_tipo_producto;?>']").attr("selected",true);
             		$("#editunid_med option[value='<?php echo $prod->id_unidad_medida;?>']").attr("selected",true);
             		$("#editarea option[value='<?php echo $prod->id_area;?>']").attr("selected",true);
             		$("#editestado option[value='<?php echo $prod->estado;?>']").attr("selected",true);

             		// Validar el campo AREA
             		var id_area = '<?php echo $prod->id_area;?>';
             		if( id_area == "" ){
             			$("#editarea").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
             		}
	            </script>
	    		<tr>
					<td width="127">ID Producto:</td>
					<td width="245"><?php echo form_input($editidprod); ?></td>
				</tr>
	    		<tr>
					<td width="127">Descripción:</td>
					<td width="245"><?php echo form_input($editnombreprod); ?></td>
				</tr>
				<tr>
              		<td width="127">Área:</td>
	              	<td><?php echo form_dropdown('editarea',$listaarea, '',"id='editarea' style='margin-left: 0px;width: 150px;'" );?></td>
	            </tr>
	    		<tr>
					<td width="127">Categoria:</td>
					<td><?php echo form_dropdown('editcat', $listacat, '',"id='editcat' style='margin-left: 0px;width: 150px;'"); ?></td>
				</tr>
				<tr>
					<td width="127">Tipo de Producto:</td>
					<td>
						<?php echo form_dropdown('edittipoprod', $listatipop, '',"id='edittipoprod' style='margin-left: 0px;width: 150px;'"); ?>
					</td>
				</tr>
	    		<tr>
					<td width="127">Procedencia:</td>
					<td><?php echo form_dropdown('editprocedencia', $listaproce, '',"id='editprocedencia' style='margin-left: 0px;width: 150px;'"); ?></td>
				</tr>
				<tr>
					<td width="127">Unidad de Medida:</td>
					<td width="245"><?php echo form_dropdown('editunid_med', $listaunimed, '',"id='editunid_med' style='margin-left: 0px;width: 150px;'"); ?></td>
				</tr>
	    		<tr>
					<td width="127">Observación:</td>
					<td width="245"><?php echo form_input($editobser); ?></td>
				</tr>
				<tr>
					<td width="127">Estado:</td>
					<td width="245"><?php echo form_dropdown('editestado', $editestado, '',"id='editestado' style='margin-left: 0px;width: 150px;'"); ?></td>
				</tr>
				<tr>
					<td width="127">Indicador:</td>
					<td width="245"><?php echo form_input($editindicador); ?></td>
				</tr>
			<?php }?>
	    	</table>
	 	</form>
	 	<?php } ?>
		</div>
	</div>