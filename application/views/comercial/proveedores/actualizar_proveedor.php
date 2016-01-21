<script type="text/javascript">
	$("#edit_ruc").validCampoFranz('0123456789');
	$("#edit_tel1").validCampoFranz('0123456789- ');            	
	$("#edit_tel2").validCampoFranz('0123456789-');
	$("#edit_fax").validCampoFranz('0123456789-');
</script>
<div id="contenedor" style="width:310px; height:455px;">
	<div id="tituloCont">Editar Proveedor</div>
	<div id="formFiltro" style="width:500px;">
		<?php 
			$existe = count($datosprov);
			if($existe <= 0){
				echo 'El Proveedor no existe en la Base de Datos.';
			}
			else
			{
		?>
    	<form style="border-bottom:0px">
	    	<table>
	    	<?php
				$i=1;
				foreach($datosprov as $prov){
				#Datos del proveedor
				$edit_rz = array('name'=>'edit_rz','id'=>'edit_rz','maxlength'=>'50', 'value'=>$prov->razon_social, 'style'=>'width:180px');
				$edit_ruc = array('name'=>'edit_ruc','id'=>'edit_ruc','maxlength'=>'11', 'value'=>$prov->ruc, 'style'=>'width:180px');
				$edit_pais = array('name'=>'edit_pais','id'=>'edit_pais','maxlength'=>'40', 'value'=>$prov->pais, 'style'=>'width:180px');
				$edit_depa = array('name'=>'edit_depa','id'=>'edit_depa','maxlength'=>'40', 'value'=>$prov->departamento, 'style'=>'width:180px');
				$edit_prov = array('name'=>'edit_prov','id'=>'edit_prov','maxlength'=>'40', 'value'=>$prov->provincia, 'style'=>'width:180px');
				$edit_dist = array('name'=>'edit_dist','id'=>'edit_dist','maxlength'=>'40', 'value'=>$prov->distrito, 'style'=>'width:180px');
				$edit_direc = array('name'=>'edit_direc','id'=>'edit_direc','maxlength'=>'100', 'value'=>$prov->direccion, 'style'=>'width:180px');
				$edit_ref = array('name'=>'edit_ref','id'=>'edit_ref','maxlength'=>'40', 'value'=>$prov->referencia, 'style'=>'width:180px');
				$edit_cont = array('name'=>'edit_cont','id'=>'edit_cont','maxlength'=>'50', 'value'=>$prov->contacto, 'style'=>'width:180px');
				$edit_cargo = array('name'=>'edit_cargo','id'=>'edit_cargo','maxlength'=>'40', 'value'=>$prov->cargo, 'style'=>'width:180px');
				$edit_email = array('name'=>'edit_email','id'=>'edit_email','maxlength'=>'50', 'value'=>$prov->email, 'style'=>'width:180px');
				$edit_tel1 = array('name'=>'edit_tel1','id'=>'edit_tel1','maxlength'=>'14', 'value'=>$prov->telefono1, 'style'=>'width:180px');
				$edit_tel2 = array('name'=>'edit_tel2','id'=>'edit_tel2','maxlength'=>'14', 'value'=>$prov->telefono2, 'style'=>'width:180px');
				$edit_fax = array('name'=>'edit_fax','id'=>'edit_fax','maxlength'=>'14', 'value'=>$prov->fax, 'style'=>'width:180px');
				$edit_web = array('name'=>'edit_web','id'=>'edit_web','maxlength'=>'30', 'value'=>$prov->web, 'style'=>'width:180px');
			?>
				<tr>
					<td width="120">Razón Social: (*)</td>
					<td width="232"><?php echo form_input($edit_rz); ?></td>
			  	</tr>
	    		<tr>
					<td width="120">RUC: (*)</td>
					<td width="232"><?php echo form_input($edit_ruc); ?></td>
				</tr>
	    		<tr>
					<td width="120">País: (*)</td>
					<td width="232"><?php echo form_input($edit_pais); ?></td>
				</tr>
	    		<tr>
					<td width="120">Departamento:</td>
					<td width="232"><?php echo form_input($edit_depa); ?></td>
				</tr>
				<tr>
					<td width="120">Provincia:</td>
					<td width="232"><?php echo form_input($edit_prov); ?></td>
				</tr>
	    		<tr>
					<td width="120">Distrito:</td>
					<td width="232"><?php echo form_input($edit_dist); ?></td>
				</tr>
				<tr>
	    			<td width="120">Dirección: (*)</td>
	    			<td width="232"><?php echo form_input($edit_direc); ?></td>
	    		</tr>
				<tr>
	    			<td width="120">Referencia:</td>
	    			<td width="232"><?php echo form_input($edit_ref); ?></td>
	    		</tr>
				<tr>
	    			<td width="120">Contacto:</td>
	    			<td width="232"><?php echo form_input($edit_cont); ?></td>
	    		</tr>
	    		<tr>
	    			<td width="120">Cargo:</td>
	    			<td width="232"><?php echo form_input($edit_cargo); ?></td>
	    		</tr>				
	    		<tr>
	    			<td width="120">Email:</td>
	    			<td width="232"><?php echo form_input($edit_email); ?></td>
	    		</tr>				
	    		<tr>
	    			<td width="120">Teléfono 1:</td>
	    			<td width="232"><?php echo form_input($edit_tel1); ?></td>
	    		</tr>				
	    		<tr>
	    			<td width="120">Teléfono 2:</td>
	    			<td width="232"><?php echo form_input($edit_tel2); ?></td>
	    		</tr>				
	    		<tr>
	    			<td width="120">Fax:</td>
	    			<td width="232"><?php echo form_input($edit_fax); ?></td>
	    		</tr>				
	    		<tr>
	    			<td width="120">Web Site:</td>
	    			<td width="232"><?php echo form_input($edit_web); ?></td>
	    		</tr>
			<?php }?>
	    	</table>
	 	</form>
	 	<?php } ?>
		</div>
	</div>