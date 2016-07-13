<script type="text/javascript">
	$("#editnombremaq").change(function() {
	$("#editnombremaq option:selected").each(function() {
	      maquina = $('#editnombremaq').val();
	      $.post("<?php echo base_url(); ?>comercial/traeMarca", {
	          maquina : maquina , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
	      }, function(data) {
	          $("#editmarca").html(data);
	          $("#editmodelo").html('<option value="0">:: SELECCIONE UNA MARCA ::</option>');
	          $("#editserie").html('<option value="0">:: SELECCIONE UN MODELO ::</option>');
	      });
	  });
	});

    $("#editmarca").change(function() {
    $("#editmarca option:selected").each(function() {
          marca = $('#editmarca').val();
          $.post("<?php echo base_url(); ?>comercial/traeModelo", {
              marca : marca , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
          }, function(data) {
              $("#editmodelo").html(data);
              $("#editserie").html('<option value="0">:: SELECCIONE UN MODELO ::</option>');
          });
        });
    });

    $("#editmodelo").change(function() {
    $("#editmodelo option:selected").each(function() {
          modelo = $('#editmodelo').val();
          $.post("<?php echo base_url(); ?>comercial/traeSerie", {
              modelo : modelo , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
          }, function(data) {
              $("#editserie").html(data);
              //$("#Serie").html('<option value="0">:: SELECCIONE UN MODELO ::</option>');
          });
      });
    });

    //$("select").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
</script>
<div id="contenedor" style="width:300px; height:230px;">
	<div id="tituloCont">Editar Máquina</div>
	<div id="formFiltro">
		<?php 
			$existe = count($datosmaq);
			if($existe <= 0){
				echo 'La Máquina no existe en la Base de Datos.';
			}
			else
			{
		?>
    	<form style="border-bottom:0px">
	    	<table style="width: 290px;">
	    	<?php
				$i=1;
				foreach($datosmaq as $maq){
				#Datos del USUARIO 
					$editobser = array('name'=>'editobser','id'=>'editobser','maxlength'=>'50', 'value'=>$maq->observacion_maq);
			?>
				<script type="text/javascript">
             		$("#editnombremaq option[value='<?php echo $maq->id_nombre_maquina;?>']").attr("selected",true);
             		$("#editmarca option[value='<?php echo $maq->id_marca_maquina;?>']").attr("selected",true);
             		$("#editmodelo option[value='<?php echo $maq->id_modelo_maquina;?>']").attr("selected",true);
             		$("#editserie option[value='<?php echo $maq->id_serie_maquina;?>']").attr("selected",true);
             		$("#editestado option[value='<?php echo $maq->id_estado_maquina;?>']").attr("selected",true);
	            </script>
	    		<tr>
					<td width="300">Tipo Máquina:</td>
					<td width="300"><?php echo form_dropdown('editnombremaq', $listamaquina, '',"id='editnombremaq' style='width:120px;margin-left: 0px;'"); ?></td>
				</tr>
	    		<tr>
					<td width="300">Marca:</td>
					<td width="300"><?php echo form_dropdown('editmarca', $listmarca, '',"id='editmarca' style='width:120px;margin-left: 0px;'"); ?></td>
				</tr>
	    		<tr>
					<td width="300">Modelo:</td>
					<td width="300"><?php echo form_dropdown('editmodelo', $listmodelo, '',"id='editmodelo' style='width:170px;margin-left: 0px;'"); ?></td>
				</tr>
				<tr>
					<td width="300">Serie:</td>
					<td width="300"><?php echo form_dropdown('editserie', $listserie, '',"id='editserie' style='width:170px;margin-left: 0px;'"); ?></td>
				</tr>
	    		<tr>
	    			<td>Estado:</td>
	    			<td><?php echo form_dropdown('editestado', $editestado, '',"id='editestado' style='margin-left: 0px;'"); ?></td>
	    		</tr>
	    		<tr>
					<td width="300">Observación:</td>
					<td width="300"><?php echo form_input($editobser); ?></td>
				</tr>
			<?php }?>
	    	</table>
	 	</form>
	 	<?php } ?>
		</div>
	</div>