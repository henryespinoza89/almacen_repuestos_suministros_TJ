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
          modal: true,resizable: false,show: "blind",position: 'center',width: 350,height: 340,draggable: false,closeOnEscape: false, //Aumenta el marco general
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
    //Script para crear la tabla que será el contenedor de los productos registrados
    $('#listaMaquinas').jTPS( {perPages:[10,20,30,50,'Todos'],scrollStep:1,scrollDelay:30,clickCallback:function () {     
            // target table selector
            var table = '#listaMaquinas';
            // store pagination + sort in cookie 
            document.cookie = 'jTPS=sortasc:' + $(table + ' .sortableHeader').index($(table + ' .sortAsc')) + ',' +
                    'sortdesc:' + $(table + ' .sortableHeader').index($(table + ' .sortDesc')) + ',' +
                    'page:' + $(table + ' .pageSelector').index($(table + ' .hilightPageSelector')) + ';';
            }
        });

        // reinstate sort and pagination if cookie exists
        var cookies = document.cookie.split(';');
        for (var ci = 0, cie = cookies.length; ci < cie; ci++) {
                var cookie = cookies[ci].split('=');
                if (cookie[0] == 'jTPS') {
                        var commands = cookie[1].split(',');
                        for (var cm = 0, cme = commands.length; cm < cme; cm++) {
                                var command = commands[cm].split(':');
                                if (command[0] == 'sortasc' && parseInt(command[1]) >= 0) {
                                        $('#listaMaquinas .sortableHeader:eq(' + parseInt(command[1]) + ')').click();
                                } else if (command[0] == 'sortdesc' && parseInt(command[1]) >= 0) {
                                        $('#listaMaquinas .sortableHeader:eq(' + parseInt(command[1]) + ')').click().click();
                                } else if (command[0] == 'page' && parseInt(command[1]) >= 0) {
                                        $('#listaMaquinas .pageSelector:eq(' + parseInt(command[1]) + ')').click();
                                }
                        }
                }
        }

        // bind mouseover for each tbody row and change cell (td) hover style
        $('#listaMaquinas tbody tr:not(.stubCell)').bind('mouseover mouseout',
                function (e) {
                        // hilight the row
                        e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
                }
        );

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
  function editar_maquina(id_maquina){
        var urlMaq = '<?php echo base_url();?>comercial/editarmaquina/'+id_maquina;
        //alert(urlMaq);
        $("#mdlEditarMaquina").load(urlMaq).dialog({
          modal: true, position: 'center', width: 350, height: 340, draggable: false, resizable: false, closeOnEscape: false,
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
                url: "<?php echo base_url(); ?>comercial/actualizarmaquina/"+id_maquina,
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    $("#finregistro").html('!Los datos de la Máquina ha sido regristado con éxito!.').dialog({
                      modal: true,position: 'center',width: 400,height: 125,resizable: false, title: 'Fin de Actualización',
                      buttons: { Ok: function(){
                        window.location.href="<?php echo base_url();?>comercial/gestionmaquinas";
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
      }


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
    <div id="tituloCont">Gestión de Maquinarias</div>
    <div id="formFiltro">
      <div class="tituloFiltro">Búsqueda</div>
      <form name="filtroBusqueda" action="#" method="post">
        <?php
          // para el ID
          if ($this->input->post('mod_maquina')){
            $mod_maquina = array('name'=>'mod_maquina','id'=>'mod_maquina','minlength'=>'1' ,'maxlength'=>'10','value'=>$this->input->post('mod_maquina'),'onkeypress'=>'onlytext()');
          }else{
            $mod_maquina = array('name'=>'mod_maquina','id'=>'mod_maquina','maxlength'=>'10','onkeypress'=>'onlytext()');
          }
          // para el NOMBRE Y APELLIDO
          if ($this->input->post('nombre')){
            $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=> '50','minlength'=>'1' , 'value' => $this->input->post('nombre'),'onkeypress'=>'onlytext()');
          }else{
            $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=> '50','minlength'=>'1','onkeypress'=>'onlytext()');
          }
        ?>
        <?php echo form_open(base_url()."comercial/gestionmaquinas", 'id="buscar"') ?>
          <table width="679" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="128">Nom. de Máquina:</td>
              <td width="235"><?php echo form_input($nombre);?></td>
            <td width="316" style="padding-bottom:4px;"><input name="submit" type="submit" id="submit" value="Buscar" />
                  <input name="reset" type="button" onclick="resetear()" value="Reestablecer" />
            </td>
            </tr>
            <tr>
              <td>Marca de Máquina:</td>
              <td><?php echo form_input($mod_maquina);?></td>
            </tr>
          </table>
        <?php echo form_close() ?>
      </form>
      <div id="options">
        <div class="newprospect" >Registro de Máquina</div>
        <div class="newnamemaq"><a href="<?php echo base_url(); ?>comercial/nuevonombremaquina/">Tipo de Máquina</a></div>
        <div class="newmarcmaq"><a href="<?php echo base_url(); ?>comercial/marcamaquina/">Marca de Máquina</a></div>
        <div class="newmodmaq"><a href="<?php echo base_url(); ?>comercial/modelomaquina/">Modelo de Máquina</a></div>
        <div class="newmarcmaq"><a href="<?php echo base_url(); ?>comercial/seriemaquina/">Serie de Máquina</a></div>
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
        <table border="0" cellspacing="0" cellpadding="0" id="listaMaquinas">
          <thead>
            <tr class="tituloTable">
              <td sort="idproducto" width="100" height="25">ID Máquina</td>
              <td sort="nombreprod" width="155">Máquina</td>
              <td sort="catprod" width="155">Marca</td>
              <td sort="procprod" width="155">Modelo</td>
              <td sort="procprod" width="155">Serie</td>
              <td sort="obserprod" width="120">Estado</td>
              <td sort="obserprod" width="220">Observación</td>
              <td sort="obserprod" width="140">Fecha de Registro</td>
              <td width="20">&nbsp;</td>
              <td width="20">&nbsp;</td>
            </tr>
          </thead>
          <?php   foreach($maquina as $listamaquinas){ ?>  
          <tr class="contentTable">
            <td style="height: 27px;"><?php echo str_pad($listamaquinas->id_maquina, 5, 0, STR_PAD_LEFT); ?></td>
            <td><?php echo $listamaquinas->nombre_maquina; ?></td>
            <td><?php echo $listamaquinas->no_marca; ?></td>
            <td><?php echo $listamaquinas->no_modelo; ?></td>
            <td><?php echo $listamaquinas->no_serie; ?></td>
            <td><?php echo $listamaquinas->no_estado_maquina; ?></td>
            <td><?php echo $listamaquinas->observacion_maq; ?></td>
            <td><?php echo $listamaquinas->fe_registro; ?></td>
            <td width="20" align="center"><img class="editar_maquina" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar Máquina" onClick="editar_maquina(<?php echo $listamaquinas->id_maquina; ?>)" /></td>
            <td width="20" align="center">
              <a href="" class="eliminar_maquina" id="elim_<?php echo $listamaquinas->id_maquina; ?>">
              <img src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Máquina"/></a>
            </td>
          </tr>
              <?php } ?> 
          <tfoot class="nav">
                  <tr>
                    <td colspan=10>
                          <div class="pagination"></div>
                          <div class="paginationTitle">Página</div>
                          <div class="selectPerPage"></div>
                      </td>
                  </tr>                   
          </tfoot>          
        </table>
      <?php }?>
    </div>
  </div>
  <!---  Ventanas modales -->
  <div id="mdlNuevaMaquina" style="display:none">
      <div id="contenedor" style="width:300px; height:210px;"> <!--Aumenta el marco interior-->
      <div id="tituloCont">Nueva Maquinaria</div>
      <div id="formFiltro">
      <?php
        $marca = array('name'=>'marca','id'=>'marca','maxlength'=>'50');//este es un input
        $modelo = array('name'=>'modelo','id'=>'modelo','maxlength'=>'50');//este es un input
        $observacion = array('name'=>'obser','id'=>'obser','maxlength'=>'100');//este es un input
      ?>  
            <form method="post" id="nuevo_producto" style=" border-bottom:0px">
            <table>
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
                        <td width="300"><?php echo form_dropdown('maquina',$listamaquina,'',"id='maquina' style='width:120px;'");?></td>
                  <?php }?>
              </tr>
              <tr>
                <td width="148" valign="middle">Marca:</td>
                <td>
                  <select name="marca" id="marca" class='required' style='width:120px;'></select>
                </td>
              </tr>
              <tr>
                <td width="148" valign="middle">Modelo:</td>
                <td>
                  <select name="modelo" id="modelo" class='required' style='width:170px;'></select>
                </td>
              </tr>
              <tr>
                <td width="148" valign="middle">Serie:</td>
                <td>
                  <select name="serie" id="serie" class='required' style='width:170px;'></select>
                </td>
              </tr>
              <tr>
                  <td>Estado:</td>
                  <td><?php echo form_dropdown('estado',$estado, '','id="estado"');?></td>
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