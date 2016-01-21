	<?php
		//controles para la busqueda
		$idprospecto = array('name'=>'idprospecto','id'=>'idprospecto','maxlength'=>'9', 'size'=>'0');
		$buscar = array('name'=>'buscar','id'=>'buscar','value'=>'Buscar');
		//INFORMACION BÁSICA
		//$codprov = array('name'=>'codprov','id'=>'codprov','maxlength'=>'10', 'size'=>'0', 'class'=>'required');
		$ruc = array('name'=>'ruc','id'=>'ruc','maxlength'=> '11','minlength'=>'11','class'=>'required');//este es un input
		$rz = array('name'=>'rz','id'=>'rz','maxlength'=>'50', 'class'=>'required');//este es un input
		//UBICACION
		$pais = array('name'=>'pais','id'=>'pais','maxlength'=>'40','class'=>'required');//este es un input
        $departamento = array('name'=>'departamento','id'=>'departamento','maxlength'=>'50');//este es un input
        $provincia = array('name'=>'provincia','id'=>'provincia','maxlength'=>'50');//este es un input
        $distrito = array('name'=>'distrito','id'=>'distrito','maxlength'=>'50');//este es un input
        $direccion = array('name'=>'direccion','id'=>'direccion','maxlength'=>'100' ,'style'=>'width:384px;','class'=>'required');//este es un input
		$referencia=array('name'=>'referencia','id'=>'referencia','maxlength'=> '150','minlength'=>'1','style'=>'width:584px;');//este es un input
		//INFORMACION DE CONTACTO
		$contacto = array('name'=>'contacto','id'=>'contacto','maxlength'=> '100','minlength'=>'1');//este es un input	
		$cargo = array('name'=>'cargo','id'=>'cargo','maxlength'=> '100','minlength'=>'1');//este es un input	
		$email = array('name'=>'email','id'=>'email','maxlength'=> '50','minlength'=>'1');//este es un input
		$telefono1 = array('name'=>'telefono1','id'=>'telefono1','maxlength'=> '14','minlength'=>'7');//este es un input
		$telefono2 = array('name'=>'telefono2','id'=>'telefono2','maxlength'=> '14','minlength'=>'7');//este es un input
		$web = array('name'=>'web','id'=>'web','maxlength'=>'30');//este es un input
        $fax = array('name'=>'fax','id'=>'fax','maxlength'=>'14');//este es un input
        $observacion = array('name'=>'observacion','id'=>'observacion','maxlength'=>'30');//este es un input
	?>
	<script type="text/javascript">
	$(function() {
        //Codigó para la creación de los steps
		//$("#form-2").validate();
		$("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                $("#form-2").validate().settings.ignore = ":disabled,:hidden";
                return $("#form-2").valid();
            },
            onFinishing: function (event, currentIndex)
            {
                $("#form-2").validate().settings.ignore = ":disabled";
                return $("#form-2").valid();
            },
            onFinished: function (event, currentIndex)
            {
                //$("#form-2").submit();
                var dataString = $("#form-2").serialize();
                $('.actions.clearfix').css("display","none");

                var nroruc = $('#ruc').val();
                $.post("<?php echo base_url(); ?>comercial/existeRuc", {
					nroruc : nroruc , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				}, function(data){
					//alert("la info que se resive es : "+data);
					if(data == '1'){
						$.post("<?php echo base_url(); ?>comercial/datosRucExiste", {
						    nroruc : nroruc , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
						}, function(datos) {
				        	var info = '<p>El número de RUC que ha indicado ya se encuentra registrado en el sistema. ¿Desea continuar?</p>';
			        		var datosruc = info+datos;
				        	$("#modalexiste").html(datosruc).dialog({
								modal: true,position: 'center',width: 790,resizable: false,
								buttons: { 
									Volver: function() {
										$('.actions.clearfix').css("float","left");
				            			$('.actions.clearfix').css("display","inline");
				            			$("#modalexiste").dialog("close");
				            			return false;
									},
									Cancelar: function(){
										$('.actions.clearfix').css("float","left");
				            			$('.actions.clearfix').css("display","inline");
				            			$("#modalexiste").dialog("close");
				            			setTimeout('window.location.href="gestionproveedores/"', 800);
				            			return false;
									}
								}
							});
						});
					}else{
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>comercial/nuevo_proveedor",
							data: dataString,
							success: function(msg){
								if(msg == '0'){
									alert('No se registro al Proveedor :( ' +dataString );
								}else{
									$("#finregistro").html('!El proveedor ha sido regristado con éxito!.').dialog({
									modal: true,position: 'center',width: 350,height: 125,resizable: false, title: 'Fin de Registro',
										buttons: { Ok: function(){
										window.location.href="<?php echo base_url();?>comercial/gestionproveedores";
		                  				}}
                    				});
								}
							}
						});
					}
				});
            }
        });
        //Validaciones
        $("#codprov").validCampoFranz('0123456789');
		$("#ruc").validCampoFranz('0123456789');
		$("#telefono1").validCampoFranz('0123456789- ');            	
		$("#telefono2").validCampoFranz('0123456789-');
		$("#fax").validCampoFranz('0123456789-');
		$("#departamentos").change(function() {
			$("#departamentos option:selected").each(function() {
			        departamentos = $('#departamentos').val();
			        $.post("<?php echo base_url(); ?>usuario/traeProvincias", {
			            departamentos : departamentos , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
			        }, function(data) {
			            $("#provincias").html(data);
			            $("#distrito").html('<option value="0">Seleccione una Provincia</option>');
			        });
			    });
		});
		$("#provincias").change(function() {
		    $("#provincias option:selected").each(function() {
		        provincias = $('#provincias').val();
		        $.post("<?php echo base_url(); ?>usuario/traeDistritos", {
		            provincias : provincias, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
		        }, function(data) {
		            $("#distrito").html(data);
		        });
		    });
		});

		 //Agregamos SELECIONE a los combos
    	$("select").append('<option value="" selected="selected">:: SELECCIONE ::</option>');

    	$("#fecharegistro").datepicker({ 
		dateFormat: 'yy-mm-dd',showOn: "button",
		buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
		buttonImageOnly: true
		});
	}); // Final del $(function() {
	
	function pad(n, length){
	   n = n.toString();
	   while(n.length < length) n = "0" + n;
	   return n;
	}

	function finalizar(){
		window.location.href="<?php echo base_url();?>comercial";
	}

	function regresar(){
		window.location.href="<?php echo base_url();?>comercial";
	}
	</script>
</header>
<div id="contenedor">
	<!--<div id="tituloCont">Nuevo Proveedor</div>-->
	<div id="tituloCont">Registro de Proveedores</div>
	<div id="formFiltro">
		<?php echo form_open("comercial/nuevo_proveedor", 'id="form-2" style="border:none"') ?>
			<div id="wizard">
                <h2>Información básica</h2>
                <section>
                    <table width="666" border="0" cellspacing="2" cellpadding="2">
					  <!--
						<tr>
					    	<td width="167">Código Proveedor : (*)</td>
					    	<td width="485" colspan="2"><?php echo form_input($codprov);?></td>
					  	</tr>
					  -->
					  <tr>
					    <td>Razón Social: (*)</td>
					    <td colspan="2"><?php echo form_input($rz);?></td>
					  </tr>
					  <tr>
					    <td width="167">RUC : (*)</td>
					    <td colspan="2"><?php echo form_input($ruc);?></td>
					  </tr>
					</table>
                </section>
                <h2>Ubicación</h2>
                <section>
					<table width="745" border="0" cellspacing="2" cellpadding="2">
					  	<tr>
                  			<td width="223">País: (*) </td>
                  			<td width="508" colspan="2"><?php echo form_input($pais);?></td>
              			</tr>
					  	<tr>
					    	<td>Departamento:</td>
					    	<td colspan="2"><?php echo form_input($departamento);?></td>
					  	</tr>
					  	<tr>
					    	<td>Provincia:</td>
					    	<td colspan="2"><?php echo form_input($provincia);?></td>
					  	</tr>
					  	<tr>
					    	<td>Distrito:</td>
					    	<td colspan="2"><?php echo form_input($distrito);?></td>
					    <tr>
		                  	<td>Dirección: (*)</td>
		                  	<td colspan="2"><?php echo form_input($direccion);?></td>
              			</tr>
					  	<tr>
					    	<td>Referencia:</td>
					    	<td colspan="2"><?php echo form_input($referencia); ?></td>
					  	</tr>
					</table>
                </section>
                <h2>Información de Contácto</h2>
                <section>
	                    <table width="710" border="0" cellspacing="2" cellpadding="2">
						  	<tr>
						    	<td width="131">Contacto:</td>
						    	<td colspan="2"><?php echo form_input($contacto);?></td>
						  	</tr>
						  	<tr>
						    	<td width="131">Cargo:</td>
						    	<td colspan="2"><?php echo form_input($cargo);?></td>
						  	</tr>
						  	<tr>
							    <td>Email:</td>
							    <td colspan="2"><?php echo form_input($email);?></td>
					      	</tr>
						  	<tr>
							    <td width="131">Teléfono 1: (*)</td>
							    <td colspan="2"><?php echo form_input($telefono1);?></td>
						  	</tr>
						  	<tr>
							    <td>Teléfono 2:</td>
							    <td colspan="2"><?php echo form_input($telefono2);?></td>
						  	</tr>
						  	<tr>
							    <td>Fax:</td>
							    <td colspan="2"><?php echo form_input($fax);?></td>
						  	</tr>
						  	<tr>
	                  			<td width="131">Web Site:</td>
	                  			<td width="565"><?php echo form_input($web);?></td>
	              			</tr>
						</table>
                </section>
		    </div>
	    <?php echo form_close() ?>
	</div>
</div>
<div id="finregistro"></div>
<div id="modalexiste" title="AVISO:" style="display:none">
	<p>El número de RUC que ha indicado ya se encuentra registrado en el sistema para este periodo.</p>
</div>
</body>
</html>