<div id="contenedor" style="width:310px; height:90px;">
	<div id="tituloCont">Editar Área</div>
	<div id="formFiltro">
		<?php 
			$existe = count($datosarea);
			if($existe <= 0){
				echo 'El Área no existe en la Base de Datos.';
			}
			else
			{
		?>
    	<form style="border-bottom:0px">
	    	<table>
	    	<?php
				$i=1;
				foreach($datosarea as $data){
				#Datos del Nombre de Máquina
				$editarea = array('name'=>'editarea','id'=>'editarea','maxlength'=>'20', 'style'=>'width:150px', 'value'=>$data->no_area);
				$editresponsable = array('name'=>'editresponsable','id'=>'editresponsable','maxlength'=>'20', 'style'=>'width:150px', 'value'=>$data->encargado);
			?>
	    		<tr>
					<td width="152">Área:</td>
					<td width="350"><?php echo form_input($editarea); ?></td>
				</tr>
				<tr>
					<td width="152">Responsable:</td>
					<td width="350"><?php echo form_input($editresponsable); ?></td>
				</tr>
			<?php }?>
	    	</table>
	 	</form>
	 	<?php } ?>
		</div>
	</div>