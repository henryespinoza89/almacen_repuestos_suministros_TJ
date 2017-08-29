<script type="text/javascript">


  function onlytext(){
    if((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
      event.returnValue = false;
  }

   $(function(){
  //Validar si existe el tipo de cambio del día registrado en el sistema
    <?php if(isset($tipocambio) && $tipocambio == 1){ ?>
    //Registro del Tipo de Cambio
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
  $("#maquina").change(function() {
  $("#maquina option:selected").each(function() {
          maquina = $('#maquina').val();
          $.post("<?php echo base_url(); ?>comercial/traeMarca", {
              maquina : maquina , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
          }, function(data) {
              $("#marca").html(data);
              $("#modelo").html('<option value="0">:: SELECCIONE UNA MARCA ::</option>');
              $("#serie").html('<option value="0">:: SELECCIONE UN MODELO ::</option>');
          });
      });
  });

  $("#marca").change(function() {
  $("#marca option:selected").each(function() {
          marca = $('#marca').val();
          $.post("<?php echo base_url(); ?>comercial/traeModelo", {
              marca : marca , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
          }, function(data) {
              $("#modelo").html(data);
              $("#serie").html('<option value="0">:: SELECCIONE UN MODELO ::</option>');
          });
      });
  });

  $("#modelo").change(function() {
  $("#modelo option:selected").each(function() {
          modelo = $('#modelo').val();
          $.post("<?php echo base_url(); ?>comercial/traeSerie", {
              modelo : modelo , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
          }, function(data) {
              $("#serie").html(data);
              //$("#Serie").html('<option value="0">:: SELECCIONE UN MODELO ::</option>');
          });
      });
  });

  $("select").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
    //Venta Modal Registrar Producto
    $(".newprospect").click(function() { //activacion de ventana modal
      $("#mdlNuevaMaquina" ).dialog({  //declaracion de ventana modal
          modal: true,resizable: false,show: "blind",position: 'center',width: 350,height: 360,draggable: false,closeOnEscape: false, //Aumenta el marco general
          buttons: {
          Registrar: function() {
              $(".ui-dialog-buttonpane button:contains('Registrar')").button("disable");
              $(".ui-dialog-buttonpane button:contains('Registrar')").attr("disabled", true).addClass("ui-state-disabled");
              //CONTROLO LAS VARIABLES
              var maquina = $('#maquina').val(); marca = $('#marca').val(); modelo = $('#modelo').val();
              var serie = $('#serie').val(); estado = $('#estado').val(); obser = $('#obser').val(); 
              if(maquina == '' || marca == ''|| modelo == '' || serie == '' || estado == ''){
                $("#modalerror").html('<b>ERROR:</b> Faltan completar algunos campos del formulario, por favor verifique.').dialog({
                  modal: true,position: 'center',width: 450, height: 150,resizable: false,
                  buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                });
              }else{
                //REGISTRO
                    var dataString = 'maquina='+maquina+'&marca='+marca+'&modelo='+modelo+'&serie='+serie+'&estado='+estado+'&obser='+obser+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>comercial/registrarmaquina/",
                      data: dataString,
                      success: function(msg){
                        if(msg == 1){
                          $("#finregistro").html('!La Máquina ha sido regristada con éxito!.').dialog({
                          modal: true,position: 'center',width: 300,height: 125,resizable: false, title: 'Fin de Registro',
                          buttons: { Ok: function(){
                            window.location.href="<?php echo base_url();?>comercial/gestionmaquinas";
                            }}
                          });
                        }else{
                          $("#modalerror").empty().append(msg).dialog({
                            modal: true,position: 'center',width: 500,height: 130,resizable: false,
                            buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                          });
                          $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
                        }
                      }
                    });
              }
          },
          Cancelar: function(){
            $("#mdlNuevaMaquina").dialog("close");
          }
          }
      });
    });

    $('#listaMaquinas').DataTable();

        $("#almacen").append('<option value="" selected="selected">:: SELECCIONE ::</option>');

        $(".downpdfMaquina").click(function() {
          var url = '<?php echo base_url();?>comercial/reportemaquinaspdf';
          $(location).attr('href',url);  
        });
        
        // Eliminar Máquina
        $('a.eliminar_maquina').bind('click', function () {
          var ruta = $('#direccionelim').text();
            var id = $(this).attr('id').replace('elim_', '');
            var parent = $(this).parent().parent();
            //var usuario = $('#us123').text();
            $("#dialog-confirm").data({
                  'delid': id,
                  'parent': parent,
                  'ruta': ruta
                  //'idusuario': usuario
            }).dialog('open');
            return false;
        });
        $("#dialog-confirm").dialog({
            resizable: false,
            bgiframe: true,
            autoOpen: false,
            width: 400,
            height: "auto",
            zindex: 9998,
            modal: false,
            buttons: {
              'Eliminar': function () {
                var parent = $(this).data('parent');
                    var id = $(this).data('delid');
                    var ruta = $(this).data('ruta');
                    //var idusuario = $(this).data('idusuario');
                    $.ajax({
                         type: 'get',
                         url: ruta,
                          data: {
                            'eliminar' : id
                            //'idusuario' : idusuario
                          }
                    });
                    $(this).dialog('close');
                    setTimeout('window.location.href="<?php echo base_url(); ?>comercial/gestionmaquinas"', 200);
            },
                'Cancelar': function () {
                      $(this).dialog('close');
                }
            }
        });
        // Fin de Eliminar

      $(".downpdf").click(function() {
        var url = '<?php echo base_url();?>reporte_maquinas/index';
        $(location).attr('href',url);   
      });
  });
  
  //Fuera de $(function(){         });

  function resetear(){
      window.location.href="<?php echo base_url();?>comercial/gestionmaquinas";
  }

  // Editar Máquina
 /* function editar_maquina(id_maquina){
        var urlMaq = '<?php echo base_url();?>comercial/editarmaquina/'+id_maquina;
        //alert(urlMaq);
        $("#mdlEditarMaquina").load(urlMaq).dialog({
          modal: true, position: 'center', width: 350, height: 360, draggable: false, resizable: false, closeOnEscape: false,
          buttons: {
            Actualizar: function() {
            $(".ui-dialog-buttonpane button:contains('Actualizar')").button("disable");
            $(".ui-dialog-buttonpane button:contains('Actualizar')").attr("disabled", true).addClass("ui-state-disabled");
            //CONTROLO LAS VARIABLES             
            var editnombremaq = $('#editnombremaq').val(); editmarca = $('#editmarca').val(); editmodelo = $('#editmodelo').val(); 
            var editserie = $('#editserie').val(); editobser = $('#editobser').val(); editestado = $('#editestado').val();
            if(editnombremaq == '' || editmodelo == '' || editserie == '' || editestado == ''){
              $("#modalerror").html('<b>ERROR:</b> Faltan completar algunos campos del formulario, por favor verifique.').dialog({
                modal: true,position: 'center',width: 450, height: 150,resizable: false,
                buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");$( this ).dialog( "close" );}}
              });
            }else{
              var dataString = 'editnombremaq='+editnombremaq+'&editmarca='+editmarca+'&editmodelo='+editmodelo+'&editserie='+editserie+'&editestado='+editestado+'&editobser='+editobser+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php //echo base_url(); ?>comercial/actualizarmaquina/"+id_maquina,
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    $("#finregistro").html('!Los datos de la Máquina ha sido regristado con éxito!.').dialog({
                      modal: true,position: 'center',width: 400,height: 125,resizable: false, title: 'Fin de Actualización',
                      buttons: { Ok: function(){
                        window.location.href="<?php //echo base_url();?>comercial/gestionmaquinas";
                      }}
                    });
                  }else{
                    $("#modalerror").empty().append(msg).dialog({
                      modal: true,position: 'center',width: 500,height: 220,resizable: false,
                      buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");$( this ).dialog( "close" );}}
                    });
                    $(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");
                  }
                }
              });
            }
          },
          Cancelar: function(){
            $("#mdlEditarMaquina").dialog("close");
          }
                }
        });
      }*/



</script>


</head>
<body>
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
              <td width="347" height="30"><a href="http://www.sbs.gob.pe/app/stats/tc-cv.asp" target="_blank" id="tipo_cambio">Superintendencia de Banca, Seguros y AFP</a></td>
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
    <div id="tituloCont">Gestión de maquinas</div>
    <div id="formFiltro">
      <div id="options" style="margin-bottom: 18px;">
        <div class="newprospect" style="width: 170px;">Registro de Máquina</div>
        <div class="newnamemaq" style="width: 150px;"><a href="<?php echo base_url(); ?>comercial/nuevonombremaquina/">Tipo de Máquina</a></div>

        <div class="newmarcmaq" style="width: 165px;"><a href="<?php echo base_url(); ?>comercial/marcamaquina/">Marca de Máquina</a></div>
        <div class="newmodmaq" style="width: 165px;"><a href="<?php echo base_url(); ?>comercial/modelomaquina/">Modelo de Máquina</a></div>
        <div class="newmarcmaq" style="width: 165px;"><a href="<?php echo base_url(); ?>comercial/seriemaquina/">Serie de Máquina</a></div>
        <!--
        <?php
           // $existe = count($maquina);
           // if($existe > 0){
        ?>
          <div class="downpdfMaquina">Descargar en PDF</div>
        <?php // }?>
        -->
      </div>
      <!--Iniciar listar-->
        <?php 
          $existe = count($maquina);
          if($existe <= 0){
            echo 'No existen Máquinas registradas en el Sistema.';
          }
          else
          {
        ?>

        <table border="0" cellspacing="0" cellpadding="0" id="listaMaquinas" style="width:1360px;" class="table table-hover table-striped">
          <thead>
            <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
              <td sort="idproducto" width="70" height="27">ID</td>
              <td sort="nombreprod" width="155">MAQUINA</td>
              <td sort="catprod" width="155">MARCA</td>
              <td sort="procprod" width="155">Modelo</td>
              <td sort="procprod" width="155">SERIE</td>
              <td sort="obserprod" width="120">ESTADO</td>
              <td sort="obserprod" width="200">OBSERVACIÓN</td>
              <td sort="obserprod" width="170">FECHA DE REGISTRO</td>
             

            </tr>
          </thead>
          <?php
               
            foreach($maquina as $listamaquinas){ 
          ?>  
          <tr class="contentTable" style="font-size: 12px;">
              <td style="height: 27px;" style="vertical-align: middle;"><?php echo str_pad($listamaquinas->id_maquina, 5, 0, STR_PAD_LEFT); ?></td>
              <td style="vertical-align: middle;"><?php echo $listamaquinas->nombre_maquina; ?></td>
              <td style="vertical-align: middle;"><?php echo $listamaquinas->no_marca; ?></td>
              <td style="vertical-align: middle;"><?php echo $listamaquinas->no_modelo; ?></td>
              <td style="vertical-align: middle;"><?php echo $listamaquinas->no_serie; ?></td>
              <td style="vertical-align: middle;"><?php echo $listamaquinas->no_estado_maquina; ?></td>
              <td style="vertical-align: middle;"><?php echo $listamaquinas->observacion_maq; ?></td>
              <td style="vertical-align: middle;"><?php echo $listamaquinas->fe_registro; ?></td>
            
              
        </tr>
          <?php } ?>        
        </table>
      <?php }?>
    </div>
  </div>
  <!---  Ventanas modales -->
  <div id="mdlNuevaMaquina" style="display:none">
      <div id="contenedor" style="width:300px; height:230px;"> <!--Aumenta el marco interior-->
      <div id="tituloCont">Nueva Maquinaria</div>
      <div id="formFiltro">
      <?php
        $marca = array('name'=>'marca','id'=>'marca','maxlength'=>'50');//este es un input
        $modelo = array('name'=>'modelo','id'=>'modelo','maxlength'=>'50');//este es un input
        $observacion = array('name'=>'obser','id'=>'obser','maxlength'=>'100');//este es un input
      ?>  
            <form method="post" id="nuevo_producto" style=" border-bottom:0px">
            <table style="width: 290px;">
              <tr>
                  <td width="300">Tipo Máquina:</td>
                  <?php
                      $existe = count($listamaquina);
                      if($existe <= 0){ ?>
                        <td width="330" height="28"><b><?php echo 'Registrar en el Sistema';?></b></td>
                  <?php    
                      }
                      else
                      {
                    ?>
                        <td width="300"><?php echo form_dropdown('maquina',$listamaquina,'',"id='maquina' style='width:120px;margin-left: 0px;'");?></td>
                  <?php }?>
              </tr>
              <tr>
                <td width="148" valign="middle">Marca:</td>
                <td>
                  <select name="marca" id="marca" class='required' style='width:120px;margin-left: 0px;'></select>
                </td>
              </tr>
              <tr>
                <td width="148" valign="middle">Modelo:</td>
                <td>
                  <select name="modelo" id="modelo" class='required' style='width:170px;margin-left: 0px;'></select>
                </td>
              </tr>
              <tr>
                <td width="148" valign="middle">Serie:</td>
                <td>
                  <select name="serie" id="serie" class='required' style='width:170px;margin-left: 0px;'></select>
                </td>
              </tr>
              <tr>
                  <td>Estado:</td>
                  <td><?php echo form_dropdown('estado',$estado, '',"id='editestado' style='margin-left: 0px;'");?></td>
              </tr>
              <tr>
                  <td width="300">Observaciones:</td>
                  <td width="300"><?php echo form_input($observacion);?></td>
              </tr>
            </table>
            </form>
        </div>
      </div>
    </div>
    <div id="mdlEditarMaquina"></div>
    <div id="modalerror"></div>
    <div id="finregistro"></div>
      <div style="display:none">
      <div id="direccionelim"><?php echo site_url('comercial/eliminarmaquina');?></div>
    </div>
    <div id="dialog-confirm" style="display: none;" title="Eliminar Máquina">
      <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
        ¿Está seguro que quiere eliminar esta Máquina?<br /><strong>¡Esta acción no se puede revertir!</strong>
      </p>
    </div>
