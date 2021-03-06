<?php
	if ($this->input->post('fecharegistro')){
		$fecharegistro = array('name'=>'fecharegistro','id'=>'fecharegistro','maxlength'=>'10','value'=>$this->input->post('fecharegistro'), 'style'=>'width:158px','readonly'=> 'readonly', 'class'=>'required');
	}else{
		$fecharegistro = array('name'=>'fecharegistro','id'=>'fecharegistro','maxlength'=>'10', 'style'=>'width:158px','readonly'=> 'readonly', 'class'=>'required');
	}
	
	if ($this->input->post('numcomprobante')){
		$numcomprobante = array('name'=>'numcomprobante','id'=>'numcomprobante','maxlength'=>'12','value'=>$this->input->post('numcomprobante'), 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false');
	}else{
		$numcomprobante = array('name'=>'numcomprobante','id'=>'numcomprobante','maxlength'=>'12', 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false');
	}

	if ($this->input->post('numcomprobante_enable')){
		$numcomprobante_enable = array('name'=>'numcomprobante_enable','id'=>'numcomprobante_enable','maxlength'=>'10','value'=>$this->input->post('numcomprobante_enable'), 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false','readonly'=> 'readonly');
	}else{
		$numcomprobante_enable = array('name'=>'numcomprobante_enable','id'=>'numcomprobante_enable','maxlength'=>'10', 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false','readonly'=> 'readonly');
	}

	if ($this->input->post('seriecomprobante')){
		$seriecomprobante = array('name'=>'seriecomprobante','id'=>'seriecomprobante','maxlength'=>'5','value'=>$this->input->post('seriecomprobante'), 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false');
	}else{
		$seriecomprobante = array('name'=>'seriecomprobante','id'=>'seriecomprobante','maxlength'=>'5', 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false');
	}

	if ($this->input->post('seriecomprobante_enable')){
		$seriecomprobante_enable = array('name'=>'seriecomprobante_enable','id'=>'seriecomprobante_enable','maxlength'=>'3','value'=>$this->input->post('seriecomprobante_enable'), 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false','readonly'=> 'readonly');
	}else{
		$seriecomprobante_enable = array('name'=>'seriecomprobante_enable','id'=>'seriecomprobante_enable','maxlength'=>'3', 'style'=>'width:74px', 'class'=>'required','onpaste'=>'return false','readonly'=> 'readonly');
	}
	
	if ($this->input->post('id_agente')){
		$id_agente = array('name'=>'id_agente','id'=>'id_agente','type'=>'hidden','value'=>$this->input->post('id_agente'));
	}else{
		$id_agente = array('name'=>'id_agente','id'=>'id_agente','type'=>'hidden','value'=>'2');
	}

	if ($this->input->post('cantidad')){
		$cantidad = array('name'=>'cantidad','id'=>'cantidad','maxlength'=>'10','value'=>$this->input->post('cantidad'), 'style'=>'width:70px', 'class'=>'required', 'onkeyup'=>'calcular()','onpaste'=>'return false');
	}else{
		$cantidad = array('name'=>'cantidad','id'=>'cantidad','maxlength'=>'10', 'style'=>'width:70px', 'class'=>'required', 'onkeyup'=>'calcular()','onpaste'=>'return false');
	}

	if ($this->input->post('pu')){
		$pu = array('name'=>'pu','id'=>'pu','maxlength'=>'10','value'=>$this->input->post('pu'),'style'=>'width:70px', 'class'=>'required', 'onkeyup'=>'calcular()','onpaste'=>'return false');
	}else{
		$pu = array('name'=>'pu','id'=>'pu','maxlength'=>'10', 'style'=>'width:70px', 'class'=>'required', 'onkeyup'=>'calcular()','onpaste'=>'return false');
	}

	if ($this->input->post('nombre_producto')){
	    $nombre_producto = array('name'=>'nombre_producto','id'=>'nombre_producto','value'=>$this->input->post('nombre_producto'), 'style'=>'width:265px;font-family: verdana;','placeholder'=>' :: Nombre del Producto ::');
	}else{
	    $nombre_producto = array('name'=>'nombre_producto','id'=>'nombre_producto', 'style'=>'width:265px;font-family: verdana;','placeholder'=>' :: Nombre del Producto ::'); 
	}

	if ($this->input->post('nombre_proveedor')){
	    $nombre_proveedor = array('name'=>'nombre_proveedor','id'=>'nombre_proveedor','value'=>$this->input->post('nombre_proveedor'), 'style'=>'width:200px;font-family: verdana;','placeholder'=>' :: Nombre del Proveedor ::');
	}else{
	    $nombre_proveedor = array('name'=>'nombre_proveedor','id'=>'nombre_proveedor', 'style'=>'width:200px;font-family: verdana;','placeholder'=>' :: Nombre del Proveedor ::'); 
	}

	if ($this->input->post('nombre_proveedor_enabled')){
		$nombre_proveedor_enabled = array('name'=>'nombre_proveedor_enabled','id'=>'nombre_proveedor_enabled','value'=>$this->input->post('nombre_proveedor_enabled'), 'style'=>'width:200px;font-family: verdana;', 'readonly'=> 'readonly', 'placeholder'=>' :: Nombre del Proveedor ::');
	}else{
		$nombre_proveedor_enabled = array('name'=>'nombre_proveedor_enabled','id'=>'nombre_proveedor_enabled', 'style'=>'width:200px;font-family: verdana;', 'readonly'=> 'readonly', 'placeholder'=>' :: Nombre del Proveedor ::');
	}

	if ($this->input->post('unidadmedida')){
	    $unidadmedida = array('name'=>'unidadmedida','id'=>'unidadmedida','maxlength'=> '10', 'value' => $this->input->post('unidadmedida'), 'style'=>'width:100px','readonly'=> 'readonly');
	}else{
	    $unidadmedida = array('name'=>'unidadmedida','id'=>'unidadmedida','maxlength'=> '10', 'style'=>'width:100px','readonly'=> 'readonly');
	}

	if ($this->input->post('stockactual')){
	    $stockactual = array('name'=>'stockactual','id'=>'stockactual','maxlength'=> '10', 'value' => $this->input->post('stockactual'), 'style'=>'width:100px','readonly'=> 'readonly');
	}else{
	    $stockactual = array('name'=>'stockactual','id'=>'stockactual','maxlength'=> '10', 'style'=>'width:100px','readonly'=> 'readonly');
	}
	
	$igvpu = array('name'=>'igvpu','id'=>'igvpu', 'style'=>'width:40px','readonly'=> 'readonly'); 
	$pusinigv = array('name'=>'pusinigv','id'=>'pusinigv', 'style'=>'width:40px','readonly'=> 'readonly');
	$pt = array('name'=>'pt','id'=>'pt', 'style'=>'width:40px','readonly'=> 'readonly'); 
	$igvpt = array('name'=>'igvpt','id'=>'igvpt', 'style'=>'width:40px','readonly'=> 'readonly'); 
	$ptsinigv = array('name'=>'ptsinigv','id'=>'ptsinigv', 'style'=>'width:40px','readonly'=> 'readonly');
	$gastosaduanero = array('name'=>'gastosaduanero','id'=>'gastosaduanero', 'style'=>'width:80px');
	$gastosaduanero_enable = array('name'=>'gastosaduanero_enable','id'=>'gastosaduanero_enable', 'style'=>'width:80px','readonly'=> 'readonly');

	$csigv  = array( 'true'=>'FACTURA CON IGV', 'false'=>'FACTURA SIN IGV');
?>

<script type="text/javascript">

	var formatNumber = {
    	separador: ",", // separador para los miles
    	sepDecimal: '.', // separador para los decimales
	    formatear:function (num){
		    num =  Math.round(num*100)/100; // permite redondear el valor a dos decimales
		    num +='';
		    var splitStr = num.split('.');
		    var splitLeft = splitStr[0];
		    var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
		    var regx = /(\d+)(\d{3})/;
		    while (regx.test(splitLeft)) {
		        splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
		    }
		    return this.simbol + splitLeft  +splitRight;
		    //return Math.round((this.simbol + splitLeft  +splitRight)*100)/100;
		    //return parseFloat(this.simbol + splitLeft  +splitRight).toFixed(2);
	    },
	    new:function(num, simbol){
	        this.simbol = simbol ||'';
	      	return this.formatear(num);
	    }
  	}
  	/*
	function calculargastos(){
		porcentaje = $("#porcentaje").val();
		if(porcentaje == '') porcentaje = 0;

		<?php 
            $existe = $this->cart->total_items();
            if($existe <= 0){
        ?>
            	gastosaduanero = 0;
        <?php 
    		}
              else
            {
        ?>
        		gastosaduanero = (<?php echo ($this->cart->total()+($this->cart->total()*0.18));?>)*(porcentaje/100);
        <?php
        	}
        ?>
        porcent = (porcentaje/100);
        $("#gastosaduanero").val(gastosaduanero); 
        $("#porcent").val(porcent);
	}
	*/
	function calcular(){
		unitario = $("#pu").val();
		if(unitario == '') unitario = 0;

		cantidad = $("#cantidad").val();
		if(cantidad == '') cantidad = 0;

		total = unitario * cantidad;

		igv_unitario = unitario / 1.18;
		pusinigv = unitario - igv_unitario;

		igv_total = total / 1.18;
		ptsinigv = total - igv_total;

		$("#pt").val(total);
		$("#igvpu").val(pusinigv);
		$("#pusinigv").val(igv_unitario);

		$("#igvpt").val(ptsinigv);
		$("#ptsinigv").val(igv_total);
	}

$(function(){

	$("#nombre_producto").focus();

	$("#seriecomprobante").keyup(function(){
      	var longitud = $("#seriecomprobante").val().length;
      	if(longitud == 3){
        	$("#numcomprobante").focus();
      	}
    });

    $("#gastosaduanero").keyup(function(){
      	var valor = $("#gastosaduanero").val();
      	$("#porcent").val(valor);
    });

	$("#nombre_producto").autocomplete({
        source: function (request, respond) {
        	var id_area = $("#area").val();
			if(id_area == ""){
              	sweetAlert("Seleccionar el Área del Producto. Verificar!", "", "error");
			}else{
	        	$.post("<?php echo base_url('comercial/traer_producto_autocomplete'); ?>", {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>", q: request.term, a: id_area},
		        function (response) {
		            respond(response);
		        }, 'json');
			}
        }, select: function (event, ui) {
        	var id_area = $("#area").val();
	        var selectedObj = ui.item;
	        var nombre_producto = selectedObj.nombre_producto;

	        $("#nombre_producto").val(nombre_producto);
	        nombre_producto = $("#nombre_producto").val();
	        var ruta = $('#direccion_traer_unidad_medida').text();
	        $.ajax({
	            type: 'get',
	            url: ruta,
	            data: {
	            	'nombre_producto' : nombre_producto
	            },
	            success: function(response){
	            	$("#unidadmedida").val(response);
	            }
	        });
	        var ruta2 = $('#direccion_traer_stock').text();
	        $.ajax({
	          	type: 'get',
	          	url: ruta2,
	          	data: {
	            	'nombre_producto' : nombre_producto,
	            	'id_area' : id_area
	          	},
	          	success: function(response){
	            	$("#stockactual").val(formatNumber.new(response));
	          	}
	        });
	        $("#cantidad").focus();
        }
    });

	$("#nombre_proveedor").autocomplete({
        source: function (request, respond) {
        	$.post("<?php echo base_url('comercial/traer_proveedor_autocomplete'); ?>", {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>", q: request.term},
	        function (response) {
	            respond(response);
	        }, 'json');
        }, select: function (event, ui) {
	        var selectedObj = ui.item;
	        var razon_social = selectedObj.razon_social;
	        $("#nombre_proveedor").val(razon_social);
        }
    });

		$("#error_general").html('!Falta completar el campo N° de Comprobante!<br>!Falta seleccionar el campo Moneda!<br>!Falta seleccionar el campo Proveedor!<br>!Falta seleccionar el campo Fecha de Registro!<br>!Falta seleccionar el campo Agente de Aduana!').dialog({
	      modal: true,position: 'center',width: 400,height: 175,resizable: false, title: 'Validación de Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_general_carrito").html('!Falta seleccionar el campo Producto!<br>!Falta completar el campo Cantidad!<br>!Falta completar el campo Precio Unitario!<br>!Falta seleccionar el campo Área!').dialog({
	      modal: true,position: 'center',width: 400,height: 175,resizable: false, title: 'Validación de Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_carrito_prod").html('!Falta seleccionar el campo Producto!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Validación de Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_carrito_qty").html('!Falta seleccionar el campo Cantidad!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Validación de Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_carrito_pu").html('!Falta seleccionar el campo Precio Unitario!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Validación de Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });
	    /*
	    $("#error_porcentaje_model").html('!Ingresar el Porcentaje de Gastos al Agente de Aduana!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });
		*/
	    $("#error_tipo_cambio").html('!No existe un Tipo de Cambio para el día con el que se Registra la Factura!').dialog({
	      modal: true,position: 'center',width: 500,height: 145,resizable: false, title: 'No existe Tipo de Cambio',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#factura_duplicada").html('!La Factura ya se encuentra registrada. Verificar!').dialog({
	      modal: true,position: 'center',width: 500,height: 145,resizable: false, title: 'Registro duplicado',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#mensaje_registro_correcto").html('<b>!La Factura se registro satisfactoriamente!</b>').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Mensaje',
	      buttons: { Ok: function(){
	      	$("#fecharegistro").val("");
	      	$("#moneda").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
	      	//$("#moneda").val("");
	        //window.location.href="<?php echo base_url();?>comercial/gestioningreso";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_csigv").html('!Falta seleccionar el campo Con/Sin IGV!').dialog({
	      modal: true,position: 'center',width: 500,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_area").html('!Falta seleccionar el campo Área!').dialog({
	      modal: true,position: 'center',width: 500,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_periodo_cerrado").html('<b>!No se puede realizar el registro!</b><br><b>La Fecha seleccionada corresponde a un Periodo de Cierre Anterior</b>').dialog({
	      modal: true,position: 'center',width: 500,height: 135,resizable: false, title: 'Validación',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_nombreProveedor").html('<b>El Proveedor no existe en la Base de Datos</b>').dialog({
	      modal: true,position: 'center',width: 500,height: 135,resizable: false, title: 'Validación',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_compro").html('!Falta completar el campo N° de Comprobante!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_fe").html('!Falta completar el campo Fecha de Registro!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_moneda").html('!Falta completar el campo Moneda!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_prov").html('!Falta completar el campo Proveedor!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

	    $("#error_agente").html('!Falta completar el campo Agente de Aduana!').dialog({
	      modal: true,position: 'center',width: 400,height: 145,resizable: false, title: 'Error/Campos Vacios',
	      buttons: { Ok: function(){
	        //window.location.href="<?php echo base_url();?>comercial/gestionarea";
	        $(this).dialog('close');
	      }}
	    });

		//Validar si existe el tipo de cambio del día registrado en el sistema
	    <?php if(isset($tipocambio) && $tipocambio == 1){ ?>
	    //Registro del Tipo de Cambio
	    $("#compra").mask("9.999");
	    $("#venta").mask("9.999");
	    $("#datacompra_dol").mask("9.999");
	    $("#dataventa_dol").mask("9.999");
	    $("#datacompra_eur").mask("9.999");
	    $("#dataventa_eur").mask("9.999");
	    $("#datacompra_fr").mask("9.999");
	    $("#dataventa_fr").mask("9.999");
	    $( "#newtipocambio" ).dialog({
		    modal: true,
		    position: 'center',
		    draggable: false,
		    resizable: false,
		    closeOnEscape: false,
		    width:835,
		    height:'auto',
		    buttons: {
        	'Guardar': function() {
          $(".ui-dialog-buttonpane button:contains('Guardar')").button("disable");
          //$(".ui-dialog-buttonpane button:contains('Ok')").attr("disabled", true).addClass("ui-state-disabled");
          var base_url = '<?php echo base_url();?>';
          var compra_dol = $("#datacompra_dol").val();
          var venta_dol = $("#dataventa_dol").val();
          var compra_eur = $("#datacompra_eur").val();
          var venta_eur = $("#dataventa_eur").val();
          var compra_fr = $("#datacompra_fr").val();
          var venta_fr = $("#dataventa_fr").val();
          var dataString = 'compra_dol=' + compra_dol+ '&venta_dol=' + venta_dol+ '&compra_eur=' + compra_eur+ '&venta_eur=' + venta_eur+ '&compra_fr=' + compra_fr+ '&venta_fr=' + venta_fr;
          $.ajax({
            type: "POST",
            url: base_url+"comercial/guardarTipoCambio",
            data: dataString,
            success: function(msg){
              if(msg == 'ok'){
                $("#finregistro").html('!El Tipo de Cambio ha sido regristado con éxito!.').dialog({
                  modal: true,position: 'center',width: 350,height: 125,resizable: false, title: 'Fin de Registro',
                  buttons: { Ok: function(){
                    window.location.href="<?php echo base_url();?>comercial/gestioningreso";
                  }}
                });
              }else{
                $("#retorno").empty().append(msg);
                $(".ui-dialog-buttonpane button:contains('Guardar')").button("enable");
              }
            }
          });
        }
      }
    });
    <?php } ?>

	<?php 
		if ($this->input->post('proveedor')){
			$selected_prov =  (int)$this->input->post('proveedor');
		}else{	$selected_prov = "";
	?>
   		$("#proveedor").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
	<?php 
		}	
	?>

	<?php 
		if ($this->input->post('moneda')){
			$selected_moneda =  (int)$this->input->post('moneda');
		}else{	$selected_moneda = "";
	?>
   		$("#moneda").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
	<?php 
		}	
	?>

	<?php
		if ($this->input->post('id_agente')){
			$selected_agente =  (int)$this->input->post('id_agente');
		}else{
			$selected_agente = 2;
	?>
	<?php 
		}	
	?>

	<?php
		if ($this->session->userdata('csigv') == ""){
			$selected_csigv = "false";
	?>
	<?php
		}else{	
			if($this->session->userdata('csigv') == "true"){
				$selected_csigv = "true";
			}else if($this->session->userdata('csigv') == "false"){
				$selected_csigv = "false";
			}
		}
	?>

		<?php 
	      	if ($this->input->post('area')){
	        	$selected_area =  (int)$this->input->post('area');
	      	}else{  $selected_area = "";
	    ?>
	      	$("#area").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
	    <?php 
	      	} 
	    ?>

		$("#agente").change(function() {
	    $("#agente option:selected").each(function(){
	            agente = $('#agente').val();
	            $("#id_agente").val(agente);
	        });
	    });

	    $("#nomproducto").change(function() {
			$("#nomproducto option:selected").each(function() {
		        nomproducto = $('#nomproducto').val();
		        $.post("<?php echo base_url(); ?>comercial/traerUnidadMedida", {
		            nomproducto : nomproducto , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
		        }, function(data) {
		            $("#unidadmedida").val(data);
		        });
		        $.post("<?php echo base_url(); ?>comercial/traerStock", {
		            nomproducto : nomproducto , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
		        }, function(data) {
		            $("#stockactual").val(data);
		        });
		    });
		});

		$("#agente").change(function() {
			$("#agente option:selected").each(function() {
		        agente = $('#agente').val();
		        $("#prueba").val(agente);
		    });
		});

       	$("#nomproducto").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
        $("#numcomprobante").validCampoFranz('0123456789-');
        $("#cantidad").validCampoFranz('0123456789.');
        $("#pu").validCampoFranz('0123456789.');

		<?php 
			$existe = $this->cart->total_items();
			if($existe <= 0){
		?>
			$("#fecharegistro")=null;
		<?php	
			}else{
		?>
			$("#fecharegistro").datepicker({ 
				dateFormat: 'yy-mm-dd',showOn: "button",
				buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
				buttonImageOnly: true,
			    changeMonth: true,
			    changeYear: true
			});
			$(".ui-datepicker-trigger").css('padding-left','7px'); // esta linea separa la imagen del calendario del input
		<?php
      		}
      	?>
	});

</script>

<div id="contenedor">
	<?php if($tipocambio == 1){?>
      <div id="newtipocambio" title="Registrar Tipo de Cambio" style="font-size:11px;min-height:240px;">
        <?php echo form_open('/comercial/guardarTipoCambio',array('name'=>'tipodecambio')); ?>
          <?php
	          $datacompra_dol = array('name'=>'datacompra_dol','id'=>'datacompra_dol','maxlength'=>'5', 'size'=>'10');
	          $dataventa_dol = array('name'=>'dataventa_dol','id'=>'dataventa_dol','maxlength'=> '5', 'size'=>'10');
	          $datacompra_eur = array('name'=>'datacompra_eur','id'=>'datacompra_eur','maxlength'=>'5', 'size'=>'10');
	          $dataventa_eur = array('name'=>'dataventa_eur','id'=>'dataventa_eur','maxlength'=> '5', 'size'=>'10');
	          $datacompra_fr = array('name'=>'datacompra_fr','id'=>'datacompra_fr','maxlength'=>'5', 'size'=>'10');
	          $dataventa_fr = array('name'=>'dataventa_fr','id'=>'dataventa_fr','maxlength'=> '5', 'size'=>'10');
          ?>
          <table width="700" border="0" cellspacing="2" cellpadding="2" align="rigth">
            <tr>
              <td width="101" height="30">Fecha Actual:</td>
              <td width="104" height="30"><b><?php echo date('d-m-Y'); ?></b></td>
              <td width="122" height="30">Tipo de Cambio:</td>
              <td width="347" height="30"><a href="http://www.sbs.gob.pe/app/stats/tc-cv.asp" id="tipo_cambio" target="_blank">Superintendencia de Banca, Seguros y AFP</a></td>
            </tr>
          </table>
          <fieldset style="border: 1px dashed #999999;width: 240px;float: left;margin-right: 15px;margin-bottom:5px;">
            <legend><strong>Tipo de Cambio en Dólares</strong></legend>
            <table width="220" border="0" cellspacing="2" cellpadding="2" align="center">
              <tr>
                <td height="30">Valor de Compra:</td>
                <td height="30"><?php echo form_input($datacompra_dol); ?></td>
              </tr>
              <tr>
                <td height="30">Valor de Venta:</td>
                <td height="30"><?php echo form_input($dataventa_dol); ?></td>
              </tr>
            </table>
          </fieldset>
          <fieldset style="border: 1px dashed #999999;width: 240px;float: left;margin-right: 15px;margin-bottom:5px;">
            <legend><strong>Tipo de Cambio en Euros</strong></legend>
            <table width="220" border="0" cellspacing="2" cellpadding="2" align="center">
              <tr>
                <td height="30">Valor de Compra:</td>
                <td height="30"><?php echo form_input($datacompra_eur); ?></td>
              </tr>
              <tr>
                <td height="30">Valor de Venta:</td>
                <td height="30"><?php echo form_input($dataventa_eur); ?></td>
              </tr>
            </table>
          </fieldset>
          <fieldset style="border: 1px dashed #999999;width: 240px;float: left;margin-bottom:10px;">
            <legend><strong>Tipo de Cambio en Franco Suizo</strong></legend>
            <table width="220" border="0" cellspacing="2" cellpadding="2" align="center">
              <tr>
                <td height="30">Valor de Compra:</td>
                <td height="30"><?php echo form_input($datacompra_fr); ?></td>
              </tr>
              <tr>
                <td height="30">Valor de Venta:</td>
                <td height="30"><?php echo form_input($dataventa_fr); ?></td>
              </tr>
            </table>
          </fieldset>
        <?php echo form_close() ?>
        <div id="retorno"></div>
      </div>
    <?php } ?>
	<div id="tituloCont" style="margin-bottom: 10px;">Registro de Ingreso de Productos</div>
	<div id="formFiltro">
		<div id="options" style="border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 0;">
        	<div class="newagente"><a href="<?php echo base_url(); ?>comercial/gestionaduana/">Gestionar Datos del Agente Aduanero</a></div>
        	<div class="newconsult"><a href="<?php echo base_url(); ?>comercial/gestionconsultarRegistros_optionsAdvanced/">Consultar Registros de Ingreso</a></div>
        	<!--<div class="newotros"><a href="<?php //echo base_url(); ?>comercial/gestionotrosDoc/">Otros</a></div>-->
        	<div class="facturas_opcion_masiva"><a href="<?php echo base_url(); ?>comercial/gestionfacturasmasivas/">Registrar Facturas Importadas - Opción Masiva</a></div>
      	</div>
			<?php echo form_open("comercial/finalizar_registro", 'id="finalizar_registro_ingreso"') ?>
				<div id="datoscompro">
					<table width="518" border="0" cellspacing="0" cellpadding="0">
						<input type="hidden" name="porcent" id="porcent" value="0">
						<input type="hidden" name="prueba" id="prueba" value="0">
						<!--<input type="type" name="id_agente" id="id_agente">-->
						<?php echo form_input($id_agente);?>
				        <tr>
				          	<td width="148" valign="middle" height="30">Comprobante:</td>
				          	<?php
				          		$existe = count($listacomprobante);
				          		if($existe <= 0){ ?>
					            	<td width="330" height="30"><b><?php echo 'Registrar en el Sistema';?></b></td>
					        <?php    
					            }
					            else
					            {
				          	?>
				          		<?php 
									$existe = $this->cart->total_items();
									if($existe <= 0){
								?>
				          			<td width="370" height="30"><?php echo form_dropdown('comprobante',$listacomprobante,'selected_compro',"id='comprobante' disabled='disabled' style='width:158px;margin-left: 0px;'");?></td>
				          		<?php	
									}else{
								?>
									<td width="370" height="30"><?php echo form_dropdown('comprobante',$listacomprobante,'selected_compro','id="comprobante" style="width:158px;margin-left: 0px; "');?></td>
								<?php
					          		}
					          	?>
				          	<?php }?>
				        </tr>
				        <tr>
				          	<td width="148" valign="middle" height="30" style="padding-bottom: 4px;">Fecha de Registro:</td>
				          	<td width="370" height="30" style="padding-top: 4px;"><?php echo form_input($fecharegistro);?></td>
				        </tr>
				    </table>
				    <table width="309" border="0" cellspacing="0" cellpadding="0">
						<tr>
							
							<?php 
								$existe = $this->cart->total_items();
								if($existe <= 0){
							?>
								<td width="148" valign="middle" height="30">N° de Comprobante:</td>
								<td width="85" height="30"><?php echo form_input($seriecomprobante_enable);?></td>
								<td width="61" height="30"><?php echo form_input($numcomprobante_enable);?></td>								
							<?php	
								}else{
							?>
				          		<td width="148" valign="middle" height="30">N° de Comprobante:</td>
				          		<td width="85" height="30"><?php echo form_input($seriecomprobante);?></td>
				          		<td width="61" height="30"><?php echo form_input($numcomprobante);?></td>
				          	<?php
				          		}
				          	?>
						</tr>
					</table>
					<table width="518" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="148" valign="middle" height="30">Moneda:</td>
				          	<?php
				          		$existe = count($listasimmon);
				          		if($existe <= 0){ ?>
					            	<td width="330" height="30"><b><?php echo 'Registrar en el Sistema';?></b></td>
					        <?php    
					            }
					            else
					            {
				          	?>
				          			<?php 
										$existe = $this->cart->total_items();
										if($existe <= 0){
									?>
				          				<td width="370" height="30"><?php echo form_dropdown('moneda',$listasimmon,$selected_moneda,"id='moneda' disabled='disabled' style='width:158px;margin-left: 0px;'");?></td>
				          			<?php	
										}else{
									?>
				          				<td width="370" height="30"><?php echo form_dropdown('moneda',$listasimmon,$selected_moneda,'id="moneda" style="width:158px;margin-left: 0px;"');?></td>
				          			<?php
						          		}
						          	?>
				          	<?php }?>
						</tr>
						<tr>
							<tr>
								<?php 
									$existe = $this->cart->total_items();
									if($existe <= 0){
								?>
					                <td width="127" valign="middle" height="30" style="padding-bottom: 4px;">Proveedor:</td>
					                <td width="228" height="30" colspan="5"><?php echo form_input($nombre_proveedor_enabled);?></td>
				                <?php	
									}else{
								?>
									<td width="127" valign="middle" height="30" style="padding-bottom: 4px;">Proveedor:</td>
					                <td width="228" height="30" colspan="5"><?php echo form_input($nombre_proveedor);?></td>
				                <?php
					          		}
					          	?>
				            </tr>
						</tr>						        
				        <tr> 
				        	<td height="30" colspan="2" style="padding-top: 4px; padding-left: 169px;"><input name="submit" type="submit" id="submit" value="FINALIZAR REGISTRO" style="padding-bottom:3px; padding-top:3px; margin-bottom: 14px; background-color: #FF5722; border-radius:6px; width:180px;padding-left: 13px;" /></td>
				        </tr>
				    </table>
				</div>
			<?php echo form_close() ?>
			<?php echo form_open("comercial/agregarcarrito", 'id="agregarcarrito"') ?>
				<div id="datosprod">
					<table width="457" border="0" cellspacing="0" cellpadding="0">
				        <tr>
				          	<td width="128" valign="middle" height="30" style="width: 127px;">Con/Sin IGV:</td>
				          	<?php 
				          		if($this->session->userdata('csigv') == ""){
				          	?>
				          		<td><?php echo form_dropdown('csigv',$csigv,$selected_csigv,'id="csigv" style="width:158px;margin-left: 0px;"');?></td>
				          	<?php	
								}else{
							?>
								<td><?php echo form_dropdown('csigv',$csigv,$selected_csigv,'id="csigv" style="width:158px;margin-left: 0px;"');?></td>
							<?php
				          		}
				          	?>
				        </tr>
					</table>
					<table width="391" border="0" cellspacing="0" cellpadding="0" style="margin-top: 3px;">			        
				        <!--
				        <tr>
				        	<td width="127" valign="middle" style="color:#005197;" height="30">Unidad de Medida:</td>
				          	<td width="128" height="30"><?php // echo form_input($unidadmedida);?></td>
							<td width="87" valign="middle" style="color:#005197;" height="30">Stock Actual:</td>
				          	<td width="155" height="30"><?php // echo form_input($stockactual);?></td>
				        </tr>
				        -->	
				        <tr>
			              	<td style="width: 127px;">Área:</td>
			              	<td width="263"><?php echo form_dropdown('area',$listaarea,$selected_area,"id='area' style='width:158px;margin-left: 0px;'" );?></td>
			            </tr>
					</table>
					<table width="900" border="0" cellspacing="0" cellpadding="0" style="margin-top: 3px;">
						<tr>
			                <td width="135" valign="middle" height="30" style="padding-bottom: 4px;">Producto:</td>
			                <td width="290" height="30"><?php echo form_input($nombre_producto);?></td>
			                <td width="127" valign="middle" style="color:#005197;padding-bottom: 4px;" height="30">Unidad de Medida:</td>
				          	<td width="128" height="30"><?php echo form_input($unidadmedida);?></td>
							<td width="95" valign="middle" style="color:#005197;padding-bottom: 4px;" height="30">Stock Actual:</td>
				          	<td width="155" height="30"><?php echo form_input($stockactual);?></td>
			            </tr>
			            <div id="zonaresultados" style="margin-top: 24px;margin-left: 127px;position: absolute;">
          
           	 			</div>
					</table>			
					<table width="258" border="0" cellspacing="0" cellpadding="0">			        
						<tr>
							<td width="124" valign="middle" height="30">Cantidad:</td>
				          	<td width="128" height="30"><?php echo form_input($cantidad);?></td>
						</tr>
					</table>
					<table width="285" border="0" cellspacing="0" cellpadding="0">			        
						<tr>
						    <td width="122" valign="middle" height="30" style="width: 56px;">Precio Unitario:</td>
						    <td width="65" height="30"><?php echo form_input($pu);?></td>
						</tr>
					</table>
					<table width="614" border="0" cellspacing="0" cellpadding="0">
						<tr>
					       	<td width="117" style="padding-top: 3px;" colspan="6"><input name="submit" type="submit" id="submit" value="AGREGAR PRODUCTO" style="padding-bottom:3px; padding-top:3px; margin-bottom: 4px; background-color: #FF5722; border-radius:6px; margin-left: 300px; width: 150px;" /></td>
					    </tr>
					</table>
				</div>	
			<?php echo form_close() ?>
			<?php echo form_open("#", 'id="porcAgente"') ?>
				<div id="datosaduana" style="display: none;">
					<table width="518" border="0" cellspacing="0" cellpadding="0">
						<input type="hidden" name="gastos" id="gastos">
				        <tr>
				          	<td width="148" valign="middle">Agente de Aduana:</td>
				          	<?php
				          		$existe = count($listaagente);
				          		if($existe <= 0){ ?>
					            	<td width="330" height="30"><b><?php echo 'Registrar en el Sistema';?></b></td>
					        <?php    
					            }
					            else
					            {
				          	?>
				          		<?php 
									$existe = $this->cart->total_items();
									if($existe <= 0){
								?>
				          			<td width="370" height="30"><?php echo form_dropdown('agente',$listaagente,$selected_agente,"id='agente' disabled='disabled' style='width:158px;'");?></td>
				          		<?php	
									}else{
								?>
									<td width="370" height="30"><?php echo form_dropdown('agente',$listaagente,$selected_agente,'id="agente" style="width:158px;"');?></td>
								<?php
					          		}
					          	?>
				          	<?php }?>
				        </tr>
						<tr>
				          	<td width="148" valign="middle" style="color:#005197;" height="30">Gastos Aduanero:</td>
				          	<?php 
								$existe = $this->cart->total_items();
								if($existe <= 0){
							?>
				          		<td width="370" height="30"><?php echo form_input($gastosaduanero_enable);?></td>
				          	<?php	
								}else{
							?>
								<td width="370" height="30"><?php echo form_input($gastosaduanero);?></td>
							<?php
				          		}
				          	?>

				        </tr>
				    </table>
				</div>
			<?php echo form_close() ?>
			<!--Iniciar listar-->
			<!---->
			<div style="float: left;margin-right: 0px;margin-top: 5px;">
				<?php 
		            $existe = $this->cart->total_items();
		            if($existe <= 0){
		            	echo 'Ingresar los Datos del Comprobante y sus Productos Respectivamente';
		            }
		            else
		            {
		        ?>
			</div>
	        <?php echo form_open("comercial/actualizar_carrito", 'id="actualizar" style="border-bottom: none; float: left;"') ?>
		        <table border="0" cellspacing="0" cellpadding="0" id="listaProductos"> <!--style="margin-left: 90px;"-->
			        <thead>
			            <tr class="tituloTable">
			              <td sort="idprod" width="80" height="27">ITEM</td>
			              <td sort="idproducto" width="80" height="27">CANTIDAD</td>
			              <td sort="nombreprod" width="380">PRODUCTO O DESCRIPCION</td>
			              <td sort="catprod" width="120">ID PRODUCTO</td>
			              <td sort="catprod" width="120">AREA</td>
			              <td sort="procprod" width="136">PRECIO UNITARIO</td>
			              <td sort="procprod" width="136">VALOR TOTAL</td>
			              <td sort="procprod" width="20">&nbsp;</td>
			            </tr>
			        </thead>
		            <?php 
		            $i = 1;
		            foreach($this->cart->contents() as $item){
		            	?>
		            	<input type="hidden" name="<?php echo $i; ?>[rowid]" value="<?php echo $item['rowid']; ?>" >

				        <tr class="contentTable" style="height: 32px; border-color: #F1EEEE;border-bottom-style: solid;">
				            <td><?php echo str_pad($i, 3, 0, STR_PAD_LEFT); ?></td>
				            <td>
				            	<input type="text" name="<?php echo $i; ?>[qty]" value="<?php echo $item['qty']; ?>" style="border-style: inherit; color: #898989; margin-bottom: 0px; padding: 0px; font-size: 11px; font-family: verdana; width: 80px; text-align: center;" >
				            </td>
				            <td><?php echo $item['name']; ?></td>
				            <td><?php echo $item['id']; ?></td>
            	            <?php 
            	            	if($this->cart->has_options($item['rowid']) === TRUE){
            		            	foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
            				?>
            	            		<td><?php echo $option_value; ?></td>
            	            	<?php } ?>
                        	<?php } ?>
				            <td>
				            	<!--<input type="text" name="<?php //echo $i; ?>[price]" value="<?php //echo $item['price']; ?>" style="border-style: inherit; color: #898989; margin-bottom: 0px; padding: 0px; font-size: 11px; font-family: verdana; width: 80px; text-align: center;" >-->
				            	<?php echo number_format($item['price'],3,'.',','); ?>
				            </td>
				            <td><?php echo number_format($item['subtotal'],2,'.',','); ?></td>
				            <td width="20" align="center">
				            	<?php echo anchor('comercial/remove/'.$item['rowid'],'X',array('style'=>'text-decoration: none; color:#898989;')); ?>
				            </td>
				        </tr>
		            <?php 
						$i++;
						} 
					?>
					<tr style="height: 29px;">
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td style="text-align:center; padding:2px; color:#000; height: 25px; border-color: #F1EEEE;border-bottom-style: solid;"> SUB-TOTAL: </td>
		            	<td style="text-align:center; padding:2px; color:#000; height: 25px; border-color: #F1EEEE;border-bottom-style: solid;"> <?php
		            																																	if($this->session->userdata('csigv') == "false"){
		            																																		echo number_format($this->cart->total(),2,'.',',');
		            																																	}else if($this->session->userdata('csigv') == "true"){
		            																																		echo number_format((($this->cart->total()/1.18)),2,'.',',');
		            																																	}
		            																																?></td>
		            </tr>
					<tr style="height: 29px;">
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td style="text-align:center; padding:2px; color:#000; height: 25px; border-color: #F1EEEE;border-bottom-style: solid;"> I.G.V. 18%: </td>
		            	<td style="text-align:center; padding:2px; color:#000; height: 25px; border-color: #F1EEEE;border-bottom-style: solid;"> <?php
		            																																	if($this->session->userdata('csigv') == "false"){
		            																																		echo number_format(($this->cart->total()*0.18),2,'.',',');
		            																																	}else if($this->session->userdata('csigv') == "true"){
		            																																		echo number_format(((($this->cart->total()/1.18))*0.18),2,'.',',');
		            																																	}	
		            																																?></td>
		            </tr>
		            <tr style="height: 29px;">
		                <td></td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td style="text-align:center; padding:2px; color:#000; height: 25px; border-color: #F1EEEE;border-bottom-style: solid;"> TOTAL: </td>
		                <!--<td colspan="5">TOTAL:</td>-->
		                <td style="text-align:center; padding:2px; color:#000; height: 25px; border-color: #F1EEEE;border-bottom-style: solid;"> <?php
		                																																if($this->session->userdata('csigv') == "false"){
		            																																		echo number_format(($this->cart->total()+($this->cart->total()*0.18)),2,'.',','); 
		            																																	}else if($this->session->userdata('csigv') == "true"){
		            																																		echo number_format($this->cart->total(),2,'.',',');
		            																																	}
		                																															?></td>
		            </tr>
		            <tr>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>
		            </tr>
		            <tr>
		            	<td><input name="actualizar" type="submit" id="submit" value="ACTUALIZAR" style="padding-bottom:3px; padding-top:3px; background-color: #FF5722; border-radius:6px;" /></td>
		            	<td colspan="2"><?php echo anchor('comercial/vaciar_listado', 'VACIAR LISTADO', array('style'=>'text-decoration: none; background-color: #FF5722; color: white; font-family: tahoma; border-radius: 6px; padding: 4px 15px 5px 15px; font-size: 11px;margin-left: 15px;')); ?></td>
		            	<td>&nbsp;</td>
		            	<td>&nbsp;</td>            	
		            </tr>
		        </table>
		    <?php echo form_close() ?>
	        <?php 
	        	}
	        ?>
	        
	        <table style="margin-top:20px;">
	        	<tr>
	        		<td width="472" ><span style="color:red;"><?php if(!empty($error)){ echo $error;} ?></span></td>
	        	</tr>
	        </table>
			
	</div>
</div>
<div id="finregistro"></div>
<div id="modalerror"></div>

<div style="display:none">
    <div id="direccion_traer_unidad_medida"><?php echo site_url('comercial/traerUnidadMedida_Autocompletado');?></div>
</div>

<div style="display:none">
    <div id="direccion_traer_stock"><?php echo site_url('comercial/traerStock_Autocompletado');?></div>
</div>

<?php if(!empty($respuesta_general)){ ?>
    <div id="error_general"></div>
<?php } ?>

<?php if(!empty($respuesta_compro)){ ?>
    <div id="error_compro"></div>
<?php } ?>

<?php if(!empty($respuesta_fe)){ ?>
    <div id="error_fe"></div>
<?php } ?>

<?php if(!empty($respuesta_moneda)){ ?>
    <div id="error_moneda"></div>
<?php } ?>

<?php if(!empty($respuesta_prov)){ ?>
    <div id="error_prov"></div>
<?php } ?>

<?php if(!empty($respuesta_agente)){ ?>
    <div id="error_agente"></div>
<?php } ?>

<?php if(!empty($respuesta_general_carrito)){ ?>
    <div id="error_general_carrito"></div>
<?php } ?>

<?php if(!empty($respuesta_carrito_prod)){ ?>
    <div id="error_carrito_prod"></div>
<?php } ?>

<?php if(!empty($respuesta_carrito_qty)){ ?>
    <div id="error_carrito_qty"></div>
<?php } ?>

<?php if(!empty($respuesta_carrito_pu)){ ?>
    <div id="error_carrito_pu"></div>
<?php } ?>
<!--
<?php //if(!empty($error_porcentaje)){ ?>
    <div id="error_porcentaje_model"></div>
<?php //} ?>
-->
<?php if(!empty($error_tipo_cambio)){ ?>
    <div id="error_tipo_cambio"></div>
<?php } ?>

<?php if(!empty($factura_duplicada)){ ?>
    <div id="factura_duplicada"></div>
<?php } ?>

<?php if(!empty($respuesta_csigv)){ ?>
    <div id="error_csigv"></div>
<?php } ?>

<?php if(!empty($respuesta_area)){ ?>
    <div id="error_area"></div>
<?php } ?>

<?php if(!empty($error_periodo_cerrado)){ ?>
    <div id="error_periodo_cerrado"></div>
<?php } ?>

<?php if(!empty($error_nombreProveedor)){ ?>
    <div id="error_nombreProveedor"></div>
<?php } ?>

<?php if(!empty($mensaje_registro_correcto)){ ?>
    <div id="mensaje_registro_correcto"></div>
<?php } ?>