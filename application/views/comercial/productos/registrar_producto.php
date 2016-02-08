<script type="text/javascript">
  $(function(){

    /** Función de Autocompletado para el Tipo de Proceso **/
    $("#uni_med").autocomplete({
      source: function (request, respond) {
        $.post("<?php echo base_url('comercial/traer_unidad_medida_autocomplete'); ?>", {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>", q: request.term},
        function (response) {
          respond(response);
        }, 'json');
      }, select: function (event, ui) {
        var selectedObj = ui.item;
        $("#uni_med").val(selectedObj.nom_uni_med);
        /* Fin del código */
      }
    });
    /** Fin de la Función **/

    /* Función Autocompletar para el Nombre del Producto */
    $("#producto_asociado").autocomplete({
        source: function (request, respond) {
          $.post("<?php echo base_url('comercial/traer_producto_autocomplete'); ?>", {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>", q: request.term},
          function (response) {
              respond(response);
          }, 'json');
        }, select: function (event, ui) {
          var selectedObj = ui.item;
          $("#nombre_producto").val(selectedObj.nombre_producto);
        }
    });
    /** Fin de la Función **/

    $("#agregar_indice").click(function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/agregar_indice/",
        success: function(response){
        if(response == 1){
            $("#modalerror").empty().append('<span style="color:black"><b>!Indices Agregados con éxito!</b></span>').dialog({
              modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {
                window.location.href="<?php echo base_url();?>comercial/gestionproductos";
              }}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
        }else{
          $("#modalerror").empty().append('<span style="color:red"><b>!ERROR!</b></span>').dialog({
              modal: true,position: 'center',width: 480,height: 125,resizable: false,title: 'Error de Validación',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
            }
        }
      });
    });
    
    $("#eliminar_registros").click(function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/eliminar_salidas_2014/",
        success: function(response){
        if(response == 1){
            $("#modalerror").empty().append('<span style="color:black"><b>!Registros de Salida Eliminados correctamente!</b></span>').dialog({
              modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {
                window.location.href="<?php echo base_url();?>comercial/gestionproductos";
              }}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
        }else{
          $("#modalerror").empty().append('<span style="color:red"><b>!ERROR!</b></span>').dialog({
              modal: true,position: 'center',width: 480,height: 125,resizable: false,title: 'Error de Validación',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
            }
        }
      });
    });

    $("#actualizar_saldos_iniciales").click(function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/actualizar_saldos_iniciales/",
        success: function(response){
        if(response == 1){
            $("#modalerror").empty().append('<span style="color:black"><b>!Datos Actualizados!</b></span>').dialog({
              modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {
                window.location.href="<?php echo base_url();?>comercial/gestionproductos";
              }}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
        }else{
          $("#modalerror").empty().append('<span style="color:red"><b>!ERROR!</b></span>').dialog({
              modal: true,position: 'center',width: 480,height: 125,resizable: false,title: 'Error de Validación',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
            }
        }
      });
    });

    $("#export_excel").click(function(){
      url = '<?php echo base_url(); ?>comercial/co_exportar_resumen_producto_excel';
      $(location).attr('href',url);
    });

    $("#consolidar").click(function(){
      url = '<?php echo base_url(); ?>comercial/consolidar_stock';
      $(location).attr('href',url);
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
          var base_url = '<?php echo base_url();?>';
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
    
    //$("select").append('<option value="" selected="selected">:: SELECCIONE ::</option>');

    //Venta Modal Registrar Producto
    $(".newprospect").click(function() { //activacion de ventana modal
      $("#mdlNuevoProducto" ).dialog({  //declaracion de ventana modal
          modal: true,resizable: false,show: "blind",position: 'center',width: 370,height: 390,draggable: false,closeOnEscape: false, //Aumenta el marco general
          buttons: {
          Registrar: function() {
              $(".ui-dialog-buttonpane button:contains('Registrar')").button("disable");
              $(".ui-dialog-buttonpane button:contains('Registrar')").attr("disabled", true).addClass("ui-state-disabled");
              //CONTROLO LAS VARIABLES
              var codigopro = $('#codigopro').val(); nombrepro = $('#nombrepro').val(); categoria = $('#categoriaN').val(); tipo = $('#tipo').val(); area = $('#area').val();
              var procedencia = $('#procedenciaN').val(); obser = $('#obser').val(); uni_med = $('#uni_med').val(); producto_asociado = $('#producto_asociado').val();
              if(codigopro == '' || nombrepro == '' || categoria == ''|| procedencia == '' || uni_med == '' || tipo == '' || area == ''){
                $("#modalerror").html('<b>Faltan completar algunos campos del formulario, por favor verifique!</b>').dialog({
                  modal: true,position: 'center',width: 450, height: 135,resizable: false,title: 'Validación/Campos Vacios',hide: 'scale',show: 'scale',
                  buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                });
              }else{
                var dataString = 'codigopro='+codigopro+'&nombrepro='+nombrepro+'&categoria='+categoria+'&procedencia='+procedencia+'&uni_med='+uni_med+'&obser='+obser+'&tipo='+tipo+'&area='+area+'&producto_asociado='+producto_asociado+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
                //alert(nombrepro);
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url(); ?>comercial/registrarproducto/",
                  data: dataString,
                  success: function(msg){
                    if(msg == 1){
                      $("#finregistro").html('!El Producto ha sido regristado con éxito!.').dialog({
                        modal: true,position: 'center',width: 300,height: 125,resizable: false, title: 'Fin de Registro',
                        buttons: { Ok: function(){
                          window.location.href="<?php echo base_url();?>comercial/gestionproductos";
                        }}
                      });
                    }else if(msg == 'unidad_no_existe'){
                      $("#modalerror").html('<strong>!La Unidad de Medida ingresada no es Correcta. Verificar!</strong>').dialog({
                        modal: true,position: 'center',width: 450, height: 125,resizable: false,title: 'Validación de Registro',hide: 'blind',show: 'blind',
                        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                      });
                    }else if(msg == 'codigo_producto'){
                      $("#modalerror").html('<strong>!El Código del Producto ya se encuentra asociado al Área seleccionada. Verificar!</strong>').dialog({
                        modal: true,position: 'center',width: 580, height: 125,resizable: false,title: 'Validación de Registro',hide: 'blind',show: 'blind',
                        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                      });
                    }else if(msg == 'nombre_producto'){
                      $("#modalerror").html('<strong>!El Nombre del Producto ya se encuentra asociado al Área seleccionada. Verificar!</strong>').dialog({
                        modal: true,position: 'center',width: 580, height: 125,resizable: false,title: 'Validación de Registro',hide: 'blind',show: 'blind',
                        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                      });
                    }else if(msg == 'error_registro'){
                      $("#modalerror").html('<strong>!Se ha producto un error. Intentelo Nuevamente!</strong>').dialog({
                        modal: true,position: 'center',width: 450, height: 125,resizable: false,title: 'Validación de Registro',hide: 'blind',show: 'blind',
                        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                      });
                    }
                  }
                });
              }
          },
          Cancelar: function(){
            $("#mdlNuevoProducto").dialog("close");
          }
          }
      });
    });

    $("#categoriaN").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
    $("#procedenciaN").append('<option value="" selected="selected">:: SELECCIONE ::</option>');

    $("#categoriaN").change(function() {
    $("#categoriaN option:selected").each(function() {
        categoria = $('#categoriaN').val();
        $.post("<?php echo base_url(); ?>comercial/traeTipo", {
            categoria : categoria , <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
        }, function(data) {
            $("#tipo").html(data);
        });
      });
    });

    <?php 
      if ($this->input->post('area')){
        $selected_area =  (int)$this->input->post('area');
      }else{  $selected_area = "";
    ?>
      $("#area").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
    <?php 
      } 
    ?>
    
        //Script para crear la tabla que será el contenedor de los productos registrados
        $('#listaProductos').jTPS( {perPages:[10,20,'Todos'],scrollStep:1,scrollDelay:30,clickCallback:function () {     
            // target table selector
            var table = '#listaProductos';
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
                                        $('#listaProductos .sortableHeader:eq(' + parseInt(command[1]) + ')').click();
                                } else if (command[0] == 'sortdesc' && parseInt(command[1]) >= 0) {
                                        $('#listaProductos .sortableHeader:eq(' + parseInt(command[1]) + ')').click().click();
                                } else if (command[0] == 'page' && parseInt(command[1]) >= 0) {
                                        $('#listaProductos .pageSelector:eq(' + parseInt(command[1]) + ')').click();
                                }
                        }
                }
        }

        // bind mouseover for each tbody row and change cell (td) hover style
        $('#listaProductos tbody tr:not(.stubCell)').bind('mouseover mouseout',
                function (e) {
                        // hilight the row
                        e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
                }
        );
        //Mostrar ::SELECCIONE:: en los combobox
        $("#almacen").append('<option value="" selected="selected">:: SELECCIONE ::</option>');

        $(".downpdf").click(function() {
          var url = '<?php echo base_url();?>comercial/reporteproductospdf';
          $(location).attr('href',url);  
        });

        // Eliminar Producto
        $('a.eliminar_producto').bind('click', function () {
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
                $.ajax({
                  type: 'get',
                  url: ruta,
                  data: {
                    'eliminar' : id
                  },
                  success: function(msg){
                    if(msg == 1){
                      $("#finregistro").html('<strong>!El Producto ha sido eliminado correctamente!</strong>').dialog({
                        modal: true,position: 'center',width: 350,height: 125,resizable: false, title: '!Eliminación Conforme!',
                        buttons: { Ok: function(){
                          window.location.href="<?php echo base_url();?>comercial/gestionproductos";
                        }}
                      });
                    }else{
                      $("#modalerror").empty().append(msg).dialog({
                        modal: true,position: 'center',width: 500,height: 125,resizable: false,title: '!No se puede eliminar el Producto!',
                        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                      });
                      $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
                    }
                  }
                });
                $(this).dialog('close');
                //setTimeout('window.location.href="<?php echo base_url(); ?>comercial/gestionproductos"', 200);
              },
              'Cancelar': function () {
                    $(this).dialog('close');
              }
            }
        });
        // FIN DE ELIMINAR
        
  });

  function resetear(){
    window.location.href="<?php echo base_url();?>comercial/gestionproductos";
  }

  // Editar Producto
  function editar_producto(id_pro){
        var urlMaq = '<?php echo base_url();?>comercial/editarproducto/'+id_pro;
        //alert(urlMaq);
        $("#mdlEditarProducto").load(urlMaq).dialog({
          modal: true, position: 'center', width: 350, height: 458, draggable: false, resizable: false, closeOnEscape: false,
          buttons: {
            Actualizar: function() {
            $(".ui-dialog-buttonpane button:contains('Actualizar')").button("disable");
            $(".ui-dialog-buttonpane button:contains('Actualizar')").attr("disabled", true).addClass("ui-state-disabled");
            //CONTROLO LAS VARIABLES
            var editidprod = $('#editidprod').val(); editnombreprod = $('#editnombreprod').val(); editcat = $('#editcat').val(); editunid_med = $('#editunid_med').val(); 
            var editobser = $('#editobser').val(); editprocedencia = $('#editprocedencia').val(); edittipoprod = $('#edittipoprod').val();
            var editestado = $('#editestado').val(); editindicador = $('#editindicador').val(); editarea = $('#editarea').val();
            if(editidprod == '' || editnombreprod == '' || editcat == '' || editprocedencia == '' || editunid_med == '' || edittipoprod == '' || editarea == ''){
              $("#modalerror").html('<b>ERROR:</b> Faltan completar algunos campos del formulario, por favor verifique.').dialog({
                modal: true,position: 'center',width: 500, height: 125,resizable: false, title: 'Validación',
                buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");$( this ).dialog( "close" );}}
              });
            }else{
              var dataString = 'editidprod='+editidprod+'&editnombreprod='+editnombreprod+'&editarea='+editarea+'&edittipoprod='+edittipoprod+'&editcat='+editcat+'&editunid_med='+editunid_med+'&editprocedencia='+editprocedencia+'&editobser='+editobser+'&editestado='+editestado+'&editindicador='+editindicador+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/actualizarproducto/"+id_pro,
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    $("#finregistro").html('!El Producto ha sido actualizado con éxito!.').dialog({
                      modal: true,position: 'center',width: 300,height: 125,resizable: false, title: 'Fin de Actualización',
                      buttons: { Ok: function(){
                        // window.location.href="<?php echo base_url();?>comercial/gestionproductos";
                        $("#mdlEditarProducto").dialog("close");
                        $( this ).dialog( "close" );
                      }}
                    });
                  }else{
                    $("#modalerror").empty().append(msg).dialog({
                      modal: true,position: 'center',width: 500,height: 125,resizable: false,
                      buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");$( this ).dialog( "close" );}}
                    });
                    $(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");
                  }
                }
              });
            }
          },
          Cancelar: function(){
            $("#mdlEditarProducto").dialog("close");
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
    <div id="tituloCont">Gestión de Productos - Repuestos y Suministros</div>
    <div id="formFiltro">
      <div class="tituloFiltro" style="width:1400px; float:left;">Búsqueda</div>
      <!--<div class="tituloFiltro">Filtros para Exportar a PDF</div>-->
      <form name="filtroBusqueda" action="#" method="post" style="width:1380px; float:left;">
        <?php
          if ($this->input->post('id_producto')){
            $id_producto = array('name'=>'id_producto','id'=>'id_producto','maxlength'=>'20','value'=>$this->input->post('id_producto'));
          }else{
            $id_producto = array('name'=>'id_producto','id'=>'id_producto','maxlength'=>'20');
          }
          // para el NOMBRE Y APELLIDO
          if ($this->input->post('nombre')){
            $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=> '50','minlength'=>'1' , 'value' => $this->input->post('nombre'));
          }else{
            $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=> '50','minlength'=>'1');
          }
          // para el almacen
          if ($this->input->post('almacen')){
            $selected_almacen =  $this->input->post('almacen');
          }else{
            $selected_almacen = "";
          }
        ?>
        <?php echo form_open(base_url()."comercial/gestionproductos", 'id="buscar" style="width:780px;"') ?>
          <table width="770" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="131" height="30">ID de Producto:</td>
              <td width="219"><?php echo form_input($id_producto);?></td>
            <td width="420" style="padding-bottom:4px;">
              <input name="submit" type="submit" id="submit" value="Buscar" />
              <input name="reset" type="button" onclick="resetear()" value="Reestablecer" />
            </td>
            </tr>
            <tr>
              <td height="30">Nom. de Producto:</td>
              <td><?php echo form_input($nombre);?></td>
            </tr>
          </table>
        <?php echo form_close() ?>
      </form>
      <div id="options_productos">
        <div class="newprospect">Nuevo Producto</div>
        <div class="newct"><a href="<?php echo base_url(); ?>comercial/gestioncategoriaproductos/">Categoria de Producto</a></div>
        <div class="newtp"><a href="<?php echo base_url(); ?>comercial/gestiontipoproductos/">Tipo de Producto</a></div>
        <!--<input name="export_excel" type="submit" id="export_excel" value="Exportar Resumen a Excel" style="padding-bottom:3px; padding-top:3px; background-color: #0B610B; border-radius:6px;width: 155px;float: right;" />-->
        <!--<input name="eliminar_registros" type="submit" id="eliminar_registros" value="Eliminar registros" style="padding-bottom:3px; padding-top:3px; background-color: #0B610B; border-radius:6px;width: 155px;float: right;" />
        <input name="actualizar_saldos_iniciales" type="submit" id="actualizar_saldos_iniciales" value="Actualizar saldos iniciales" style="padding-bottom:3px; padding-top:3px; background-color: #0B610B; border-radius:6px;width: 155px;float: right;" />
        <!--<input name="consolidar" type="submit" id="consolidar" value="Consolidar Stock" style="padding-bottom:3px; padding-top:3px; background-color: #0B610B; border-radius:6px;width: 155px;float: right;" />-->
        <!--<input name="agregar_indice" type="submit" id="agregar_indice" value="Agregar Indice" style="padding-bottom:3px; padding-top:3px; background-color: #0B610B; border-radius:6px;width: 155px;float: right;" />-->
      </div>
      <!--Iniciar listar-->
        <?php
          $existe = count($producto);
          if($existe <= 0){
            echo 'No existen Productos registrados en el Sistema.';
          }
          else
          {
        ?>
        <table border="0" cellspacing="0" cellpadding="0" id="listaProductos" style="width:1380px;">
          <thead>
            <tr class="tituloTable">
              <td sort="idprod" width="70" height="25">Item</td>
              <td sort="idproducto" width="100" height="25">ID Producto</td>
              <td sort="nombreprod" width="330">Nombre o Descripción</td>
              <td sort="nombreprod" width="120">Área</td>
              <td sort="catprod" width="120">Categoria</td>
              <td sort="catprod" width="120">Tipo Producto</td>
              <!--<td sort="procprod" width="150">Procedencia</td>-->
              <td sort="procprod" width="120">Unidad de Medida</td>
              <td sort="procprod" width="125">Stock Sta. Clara</td>
              <td sort="procprod" width="125">Stock Sta. Anita</td>
              <td sort="procprod" width="20"></td>
              <td width="20">&nbsp;</td>
              <td width="20">&nbsp;</td>
            </tr>
          </thead>
          <?php
            $i = 1;
            foreach($producto as $listaproductos){ 
          ?>  
          <tr class="contentTable">
            <td height="27"><?php echo str_pad($i, 4, 0, STR_PAD_LEFT); ?></td>
            <td><?php echo $listaproductos->id_producto; ?></td>
            <td><?php echo $listaproductos->no_producto; ?></td>
            <td><?php echo $listaproductos->no_area; ?></td>
            <td><?php echo $listaproductos->no_categoria; ?></td>
            <td><?php echo $listaproductos->no_tipo_producto; ?></td>
            <!--<td><?php //echo $listaproductos->no_procedencia; ?></td>-->
            <td><?php echo $listaproductos->nom_uni_med; ?></td>
            <td><?php echo $listaproductos->stock_area_sta_clara; ?></td>
            <td><?php echo $listaproductos->stock_area_sta_anita; ?></td>
            <td>
              <?php 
                if($listaproductos->column_temp == ""){
                  /*echo "Vacio";*/
              ?>
                <span class="icon-ban" style="color: red;"></span>
              <?php
                }else if($listaproductos->column_temp == "NUEVO" || $listaproductos->column_temp == "NUEVO 14" || $listaproductos->column_temp == "NUEVO 14S"){
              ?>
                <span class="fa fa-thumbs-o-up" style="color: green;"></span>  
              <?php
                }
              ?>
            </td>
            <td width="20" align="center"><img class="editar_producto" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar producto" onClick="editar_producto(<?php echo $listaproductos->id_pro; ?>)" /></td>
            <td width="20" align="center">
              <a href="" class="eliminar_producto" id="elim_<?php echo $listaproductos->id_pro; ?>">
              <img src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Producto"/></a>
            </td>
          </tr>
          <?php
            $i++;
            } 
          ?> 
          <tfoot class="nav">
                  <tr>
                    <td colspan=12>
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
  <div id="mdlNuevoProducto" style="display:none">
      <div id="contenedor" style="width:320px; height:265px;"> <!--Aumenta el marco interior-->
      <div id="tituloCont">Nuevo Producto</div>
      <div id="formFiltro" style="width:500px;">
      <?php
        $codigopro = array('name'=>'codigopro','id'=>'codigopro','maxlength'=>'20', 'style'=>'width:150px');//este es un input
        $nombrepro = array('name'=>'nombrepro','id'=>'nombrepro','maxlength'=>'60', 'style'=>'width:150px');//este es un input
        $observacion = array('name'=>'obser','id'=>'obser','maxlength'=>'100', 'style'=>'width:150px');//este es un input
        $uni_med = array('name'=>'uni_med','id'=>'uni_med','maxlength'=>'30', 'style'=>'width:150px');//este es un input
        $precio_unitario = array('name'=>'precio_unitario','id'=>'precio_unitario','maxlength'=>'30', 'style'=>'width:150px');//este es un input
        $stock = array('name'=>'stock','id'=>'stock','maxlength'=>'30', 'style'=>'width:150px');//este es un input
        $producto_asociado = array('name'=>'producto_asociado','id'=>'producto_asociado','maxlength'=>'100', 'style'=>'width:150px');//este es un input
      ?>  
        <form method="post" id="nuevo_producto" style=" border-bottom:0px">
          <table>
            <tr>
              <td width="130">ID Producto:</td>
              <td width="263"><?php echo form_input($codigopro);?></td>
            </tr>
            <tr>
              <td width="130">Descripción:</td>
              <td width="263"><?php echo form_input($nombrepro);?></td>
            </tr>
            <tr>
              <td>Área:</td>
              <td width="263"><?php echo form_dropdown('area',$listaarea,$selected_area,"id='area'" );?></td>
            </tr>
            <tr> 
                <td>Categoria:</td>
                <td width="263"><?php echo form_dropdown('categoriaN',$listacategoria,'','id="categoriaN"');?>
                <div align="right"></div></td>
            </tr>
            <tr> 
                <td height="30">Tipo de Producto:</td>
                <td>
                  <select name="tipo" id="tipo" class='required' style='width:158px;'></select>
                </td>
            </tr>
            <tr>
                <td>Procedencia:</td>
                <td><?php echo form_dropdown('procedenciaN',$listaprocedencia,'','id="procedenciaN"');?></td>
            </tr>
            <tr>
                <td>Unidad de Medida:</td>
                <td><?php echo form_input($uni_med);?></td>
            </tr>
            <tr>
                <td width="130">Observaciones:</td>
                <td width="263"><?php echo form_input($observacion);?></td>
            </tr>
            <!--
            <tr>
                <td width="130">Producto Asociado:</td>
                <td width="263"><?php //echo form_input($producto_asociado);?></td>
            </tr>
            -->
          </table>
        </form>
        </div>
      </div>
    </div>
    <div id="mdlEditarProducto"></div>
    <div id="modalerror"></div>
    <div id="finregistro"></div>
    <div style="display:none">
      <div id="direccionelim"><?php echo site_url('comercial/eliminarproducto');?></div>
    </div>
    <div id="dialog-confirm" style="display: none;" title="Eliminar Producto">
      <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
        ¿Está seguro que quiere eliminar el producto?<br /><strong>¡Esta acción no se puede revertir!</strong>
      </p>
    </div>