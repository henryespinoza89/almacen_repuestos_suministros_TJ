<script type="text/javascript">
  $(function(){

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
          /*
          var compra = $("#compra").val();
          var venta = $("#venta").val();
          */
          var compra_dol = $("#datacompra_dol").val();
          var venta_dol = $("#dataventa_dol").val();
          var compra_eur = $("#datacompra_eur").val();
          var venta_eur = $("#dataventa_eur").val();
          var compra_fr = $("#datacompra_fr").val();
          var venta_fr = $("#dataventa_fr").val();
          var dataString = 'compra_dol=' + compra_dol+ '&venta_dol=' + venta_dol+ '&compra_eur=' + compra_eur+ '&venta_eur=' + venta_eur+ '&compra_fr=' + compra_fr+ '&venta_fr=' + venta_fr;
          /*'compra=' + compra + '&venta=' + venta+ */
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

    $(".newprospect").click(function() { //activacion de ventana modal
      $("#mdlNuevoTipoCambio" ).dialog({  //declaracion de ventana modal
          modal: true,resizable: false,show: "blind",position: 'center',width: 290,height: 390,draggable: false,closeOnEscape: false, //Aumenta el marco general
          buttons: {
          Registrar: function() {
              var fecha_registro = $('#fecha_registro').val(); dolar_compra_reg = $('#dolar_compra_reg').val(); dolar_venta_reg = $('#dolar_venta_reg').val();
              var euro_compra_reg = $('#euro_compra_reg').val(); euro_venta_reg = $('#euro_venta_reg').val(); fr_compra_reg = $('#fr_compra_reg').val(); 
              var fr_venta_reg= $('#fr_venta_reg').val();
              if(fecha_registro == '' || dolar_compra_reg == '' || dolar_venta_reg == ''|| euro_compra_reg == '' || fr_compra_reg == '' || fr_venta_reg == '' || euro_venta_reg == ''){
                sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
              }else{
                    var dataString = 'fecha_registro='+fecha_registro+'&dolar_compra_reg='+dolar_compra_reg+'&dolar_venta_reg='+dolar_venta_reg+'&euro_compra_reg='+euro_compra_reg+'&euro_venta_reg='+euro_venta_reg+'&fr_compra_reg='+fr_compra_reg+'&fr_venta_reg='+fr_venta_reg+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>comercial/registrartipocambio/",
                      data: dataString,
                      success: function(msg){
                        if(msg == 1){
                          swal({ title: "El Tipo de Cambio ha sido regristado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                          $("#mdlNuevoTipoCambio").dialog("close");
                          $('#fecha_registro').val('');
                          $('#dolar_compra_reg').val('');
                          $('#dolar_venta_reg').val('');
                          $('#euro_compra_reg').val('');
                          $('#euro_venta_reg').val('');
                          $('#fr_compra_reg').val('');
                          $('#fr_venta_reg').val('');
                        }else{
                          sweetAlert(msg, "", "error");
                        }
                      }
                    });
              }
          },
          Cancelar: function(){
            $("#mdlNuevoTipoCambio").dialog("close");
          }
          }
      });
    });

    $("#fecharegistro").datepicker({ 
        dateFormat: 'yy-mm-dd',showOn: "button",
        buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true
      });
    $(".ui-datepicker-trigger").css('padding-left','7px'); // esta linea separa la imagen del calendario del input

    $("#fecha_registro").datepicker({ 
        dateFormat: 'yy-mm-dd',showOn: "button",
        buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true
      });
    $(".ui-datepicker-trigger").css('padding-left','7px'); // esta linea separa la imagen del calendario del input

    $('#listaTipoCambio').DataTable();
  });
  
  //Fuera de $(function(){         });
  function resetear(){
      window.location.href="<?php echo base_url();?>comercial/gestiontipocambio";
  }

  // Editar Producto
  function editar_tipo_cambio(id_tipo_cambio){
    var urlMaq = '<?php echo base_url();?>comercial/editartipocambio/'+id_tipo_cambio;
    $("#mdlEditarTipoCambio").load(urlMaq).dialog({
      modal: true, position: 'center', width: 290, height: 360, draggable: false, resizable: false, closeOnEscape: false,
      buttons: {
        Actualizar: function() {
        var edit_fecha_actual = $('#edit_fecha_actual').val(); edit_dolar_compra = $('#edit_dolar_compra').val(); edit_dolar_venta = $('#edit_dolar_venta').val(); edit_euro_compra = $('#edit_euro_compra').val(); 
        var edit_euro_venta = $('#edit_euro_venta').val(); edit_fr_compra = $('#edit_fr_compra').val(); edit_fr_venta = $('#edit_fr_venta').val();
        if(edit_fecha_actual == '' || edit_dolar_compra == '' || edit_dolar_venta == '' || edit_fr_compra == '' || edit_euro_venta == '' || edit_fr_venta == '' || edit_euro_compra == ''){
          sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
        }else{
          var dataString = 'edit_fecha_actual='+edit_fecha_actual+'&edit_dolar_compra='+edit_dolar_compra+'&edit_dolar_venta='+edit_dolar_venta+'&edit_euro_compra='+edit_euro_compra+'&edit_fr_venta='+edit_fr_venta+'&edit_fr_compra='+edit_fr_compra+'&edit_euro_venta='+edit_euro_venta+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
          $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>comercial/actualizartipocambio/"+id_tipo_cambio,
            data: dataString,
            success: function(msg){
              if(msg == 1){
                swal({ title: "El Tipo de Cambio ha sido actualizado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                $("#mdlEditarTipoCambio").dialog("close");
              }else{
                sweetAlert(msg, "", "error");
              }
            }
          });
        }
      },
      Cancelar: function(){
        $("#mdlEditarTipoCambio").dialog("close");
      }
      }
    });
  }

</script>

</head>
<body>
  <div id="contenedor">
    <?php if($tipocambio == 1){?>
      <div id="newtipocambio" title="Registrar Tipo de Cambio" style="font-size:11px;min-height:240px;">
        <?php echo form_open('/comercial/guardarTipoCambio',array('name'=>'tipodecambio')); ?>
          <?php
          /*
          $datacompra = array('name'=>'compra','id'=>'compra','maxlength'=>'5', 'size'=>'10');
          $dataventa = array('name'=>'venta','id'=>'venta','maxlength'=> '5', 'size'=>'10');
          */
          $datacompra_dol = array('name'=>'datacompra_dol','id'=>'datacompra_dol','maxlength'=>'5', 'size'=>'10');
          $dataventa_dol = array('name'=>'dataventa_dol','id'=>'dataventa_dol','maxlength'=> '5', 'size'=>'10');
          $datacompra_eur = array('name'=>'datacompra_eur','id'=>'datacompra_eur','maxlength'=>'5', 'size'=>'10');
          $dataventa_eur = array('name'=>'dataventa_eur','id'=>'dataventa_eur','maxlength'=> '5', 'size'=>'10');
          $datacompra_fr = array('name'=>'datacompra_fr','id'=>'datacompra_fr','maxlength'=>'5', 'size'=>'10');
          $dataventa_fr = array('name'=>'dataventa_fr','id'=>'dataventa_fr','maxlength'=> '5', 'size'=>'10');
          ?>
          <table width="700" border="0" cellspacing="2" cellpadding="2" align="rigth">
            <tr>
              <td width="75" height="30">Fecha Actual:</td>
              <td width="104" height="30"><b><?php echo date('d-m-Y'); ?></b></td>
              <td width="90" height="30">Tipo de Cambio:</td>
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
    <div id="tituloCont">Gestión de Tipo de Cambio</div>
    <div id="formFiltro">
      <div id="options_tipo_cambio" style="margin-bottom: 15px;">
        <div class="newprospect" style="width: 200px;">Registrar Tipo de Cambio</div>
      </div>
        <?php 
          $existe = count($tipoCambio);
          if($existe <= 0){
            echo 'No existen Tipos de Cambio registrados en el Sistema.';
          }
          else
          {
        ?>
        <table border="0" cellspacing="0" cellpadding="0" id="listaTipoCambio" style="float: left;width:1365px;" class="table table-hover table-striped">
          <thead>
            <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
              <!--<td sort="idprod" width="85" height="27">ITEM</td>-->
              <td sort="idproducto" width="160" height="27">FECHA DE REGISTRO</td>
              <td sort="nombreprod" width="180">VALOR DE COMPRA DOLAR</td>
              <td sort="catprod" width="180">VALOR DE VENTA DOLAR</td>
              <td sort="nombreprod" width="180">VALOR DE COMPRA EURO</td>
              <td sort="catprod" width="180">VALOR DE VENTA EURO</td>
              <td sort="nombreprod" width="190">VALOR DE COMPRA F.S</td>
              <td sort="catprod" width="190">VALOR DE VENTA F.S</td>
              <td width="20" style="background-image: none;">&nbsp;</td>
            </tr>
          </thead>
          <?php
            $i = 1;
            foreach($tipoCambio as $listatipoCambio){ 
          ?>  
          <tr class="contentTable" style="font-size: 12px;">
            <!--<td height="27" style="vertical-align: middle;"><?php // echo str_pad($i, 4, 0, STR_PAD_LEFT); ?></td>-->
            <td style="vertical-align: middle;"><?php echo $listatipoCambio->fecha_actual; ?></td>
            <td style="vertical-align: middle;"><?php echo $listatipoCambio->dolar_compra; ?></td>
            <td style="vertical-align: middle;"><?php echo $listatipoCambio->dolar_venta; ?></td>
            <td style="vertical-align: middle;"><?php echo $listatipoCambio->euro_compra; ?></td>
            <td style="vertical-align: middle;"><?php echo $listatipoCambio->euro_venta; ?></td>
            <td style="vertical-align: middle;"><?php echo $listatipoCambio->fr_compra; ?></td>
            <td style="vertical-align: middle;"><?php echo $listatipoCambio->fr_venta; ?></td>
            <td width="20" align="center"><img class="editar_tipo_cambio" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar Tipo de Cambio" onClick="editar_tipo_cambio(<?php echo $listatipoCambio->id_tipo_cambio; ?>)" style="cursor: pointer;"/></td>
          </tr>
          <?php
            $i++;
            } 
          ?>       
        </table>
      <?php }?>

      <script type="text/javascript">
        $(function(){
          $("#dolar_compra_reg").mask("9.999");
          $("#dolar_venta_reg").mask("9.999");
          $("#euro_compra_reg").mask("9.999");
          $("#euro_venta_reg").mask("9.999");
          $("#fr_compra_reg").mask("9.999");
          $("#fr_venta_reg").mask("9.999");
        });
      </script>

      <div id="mdlEditarTipoCambio"></div>
      <div id="modalerror"></div>
      <div id="finregistro"></div>
      <!---  Ventanas modales -->
      <div id="mdlNuevoTipoCambio" style="display:none">
        <div id="contenedor" style="width:240px; height:260px;"> <!--Aumenta el marco interior-->
        <div id="tituloCont">Nuevo Tipo de Cambio</div>
        <div id="formFiltro" style="width:500px;">
        <?php
          $fecha_registro = array('name'=>'fecha_registro','id'=>'fecha_registro','maxlength'=>'10', 'style'=>'width:70px');//este es un input
          $dolar_compra_reg = array('name'=>'dolar_compra_reg','id'=>'dolar_compra_reg','maxlength'=>'5', 'style'=>'width:50px');//este es un input
          $dolar_venta_reg = array('name'=>'dolar_venta_reg','id'=>'dolar_venta_reg','maxlength'=>'5', 'style'=>'width:50px');//este es un input
          $euro_compra_reg = array('name'=>'euro_compra_reg','id'=>'euro_compra_reg','maxlength'=>'5', 'style'=>'width:50px');//este es un input
          $euro_venta_reg = array('name'=>'euro_venta_reg','id'=>'euro_venta_reg','maxlength'=>'5', 'style'=>'width:50px');//este es un input
          $fr_compra_reg = array('name'=>'fr_compra_reg','id'=>'fr_compra_reg','maxlength'=>'5', 'style'=>'width:50px');//este es un input
          $fr_venta_reg = array('name'=>'fr_venta_reg','id'=>'fr_venta_reg','maxlength'=>'5', 'style'=>'width:50px');//este es un input
        ?>  
            <form method="post" id="nuevo_tipo_camvbio" style=" border-bottom:0px">
              <table>
                <tr>
                  <td width="127">Fecha de Registro:</td>
                  <td width="245"><?php echo form_input($fecha_registro); ?></td>
                </tr>
                  <tr>
                  <td width="127">Compra Dólar:</td>
                  <td width="245"><?php echo form_input($dolar_compra_reg); ?></td>
                </tr>
                <tr>
                  <td width="127">Venta Dólar:</td>
                  <td width="245"><?php echo form_input($dolar_venta_reg); ?></td>
                </tr>
                  <tr>
                  <td width="127">Compra Euro:</td>
                  <td width="245"><?php echo form_input($euro_compra_reg); ?></td>
                </tr>
                <tr>
                  <td width="127">Venta Euro:</td>
                  <td width="245"><?php echo form_input($euro_venta_reg); ?></td>
                </tr>
                <tr>
                  <td width="127">Compra Fr. Suizo:</td>
                  <td width="245"><?php echo form_input($fr_compra_reg); ?></td>
                </tr>
                <tr>
                  <td width="127">Venta Fr. Suizo:</td>
                  <td width="245"><?php echo form_input($fr_venta_reg); ?></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>