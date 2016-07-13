<div id="contenedor" style="width:360px; height:130px;">
	<div id="tituloCont">Editar Tipo de Producto</div>
	<div id="formFiltro">
		<?php 
			$existe = count($datostipprod);
			if($existe <= 0){
				echo 'El Tipo de Producto no existe en la Base de Datos.';
			}
			else
			{
		?>
    	<form style="border-bottom:0px">
	    	<table style="width: 315px;">
		    	<?php
					$i=1;
					foreach($datostipprod as $tipprod){
					$edittipprod = array('name'=>'edittipprod','id'=>'edittipprod','maxlength'=>'30', 'style'=>'width:158px', 'value'=>$tipprod->no_tipo_producto);
				?>
				<script type="text/javascript">
					$("#editcateprod option[value='<?php echo $tipprod->id_categoria;?>']").attr("selected",true);
				</script>
					<tr>
						<td width="1300" height="30" style="padding-bottom: 6px;">Categoría de Producto:</td>
						<td width="300" height="30"><?php echo form_dropdown('editcateprod', $listacategoriaproducto, '',"id='editcateprod' style='width:158px;margin-left: 0px;'"); ?></td>
					</tr>
		    		<tr>
						<td width="1300" height="40" style="padding-bottom: 6px;">Tipo de Producto:</td>
						<td width="300" height="40" style="padding-top: 5px;"><?php echo form_input($edittipprod); ?></td>
					</tr>
				<?php }?>
	    	</table>
	 	</form>
	 	<?php } ?>
	</div>
</div>