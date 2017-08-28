<script type="text/javascript">
  $(function(){

    $("#nombrepro_agregar_area").autocomplete({
      source: function (request, respond) {
        $.post("<?php echo base_url('comercial/traer_producto_autocomplete_agregar_area'); ?>", {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>", q: request.term},
        function (response) {
            respond(response);
        }, 'json');
      }, select: function (event, ui) {
        var selectedObj = ui.item;
        var nombre_producto = selectedObj.nombre_producto;
        $("#nombrepro_agregar_area").val(nombre_producto);
      }
    });

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
          $.ajax({
            type: "POST",
            url: base_url+"comercial/guardarTipoCambio",
            data: dataString,
            success: function(msg){
              if(msg == 'ok'){
                $('#datacompra_dol').val('');
                $('#dataventa_dol').val('');
                $('#datacompra_eur').val('');
                $('#dataventa_eur').val('');
                $('#datacompra_fr').val('');
                $('#dataventa_fr').val('');
                swal({ title: "El Tipo de Cambio ha sido regristado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                $("#newtipocambio").dialog("close");
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
          modal: true,resizable: false,show: "blind",position: 'center',width: 370,height: 420,draggable: false,closeOnEscape: false, //Aumenta el marco general
          buttons: {
          Registrar: function() {
              var codigopro = $('#codigopro').val(); nombrepro = $('#nombrepro').val(); categoria = $('#categoriaN').val(); tipo = $('#tipo').val(); area = $('#area').val();
              var procedencia = $('#procedenciaN').val(); obser = $('#obser').val(); uni_med = $('#uni_med').val(); producto_asociado = $('#producto_asociado').val();
              if(codigopro == '' || nombrepro == '' || categoria == ''|| procedencia == '' || uni_med == '' || tipo == '' || area == ''){
                sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
              }else{
                var dataString = 'codigopro='+codigopro+'&nombrepro='+nombrepro+'&categoria='+categoria+'&procedencia='+procedencia+'&uni_med='+uni_med+'&obser='+obser+'&tipo='+tipo+'&area='+area+'&producto_asociado='+producto_asociado+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url(); ?>comercial/registrarproducto/",
                  data: dataString,
                  success: function(msg){
                    if(msg == 1){
                      swal({ title: "El Producto ha sido regristado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                      $("#mdlNuevoProducto").dialog("close");
                      $('#codigopro').val('');
                      $('#nombrepro').val('');
                      $('#area').val('');
                      $('#categoriaN').val('');
                      $('#tipo').val('');
                      $('#procedenciaN').val('');
                      $('#uni_med').val('');
                      $('#obser').val('');
                    }else if(msg == 'unidad_no_existe'){
                      sweetAlert("!La Unidad de Medida ingresada no es correcta. Verificar!", "", "error");
                    }else if(msg == 'codigo_producto'){
                      sweetAlert("!El Código del Producto ya se encuentra asociado al Área seleccionada. Verificar!", "", "error");
                    }else if(msg == 'nombre_producto'){
                      sweetAlert("!El Nombre del Producto ya se encuentra asociado al Área seleccionada. Verificar!", "", "error");
                    }else if(msg == 'error_registro'){
                      sweetAlert("!Se ha producto un error. Intentelo Nuevamente!", "", "error");
                    }else if(msg == 'nombre_duplicado'){
                      sweetAlert("Validación", "!El nombre del producto ya se encuentra registrado en el sistema!", "error");
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

    $(".newprospect_new_area").click(function() {
      $("#mdl_area_producto" ).dialog({
        modal: true,resizable: false,show: "blind",position: 'center',width: 400,height: 270,draggable: false,closeOnEscape: false, //Aumenta el marco general
        buttons: {
        Registrar: function() {
            var nombrepro_agregar_area = $('#nombrepro_agregar_area').val(); area = $('#area_2').val();
            if(nombrepro_agregar_area == '' || area == ''){
              sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
            }else{
              var dataString = 'nombrepro_agregar_area='+nombrepro_agregar_area+'&area='+area+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/registrar_producto_nueva_area/",
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    swal({ title: "El Producto ha sido asociado a la nueva área con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                    $("#mdl_area_producto").dialog("close");
                    $('#nombrepro_agregar_area').val('');
                    $('#area_2').val('');
                  }else if(msg == 'area_duplicada'){
                    sweetAlert("Validación", "!El producto ya se encuentra asociado al área seleccionada. Verificar!", "error");
                  }
                }
              });
            }
        },
        Cancelar: function(){
          $("#mdl_area_producto").dialog("close");
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

    <?php 
      if ($this->input->post('area_2')){
        $selected_agregar_area =  (int)$this->input->post('area_2');
      }else{  $selected_agregar_area = "";
    ?>
      $("#area_2").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
    <?php 
      } 
    ?>
    
    $('#listaProductos').DataTable();

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
          $("#dialog-confirm").data({
            'delid': id,
            'parent': parent,
            'ruta': ruta
          }).dialog('open');
          return false;
        });

        $("#dialog-confirm").dialog({
          resizable: false,bgiframe: true,autoOpen: false,width: 400,height: "auto",zindex: 9998,modal: false,
          buttons: {
            'Eliminar': function () {
              var parent = $(this).data('parent');
              var id = $(this).data('delid');
              var ruta = $(this).data('ruta');
              $.ajax({
                type: 'get',
                url: ruta,
                data: {'eliminar' : id },
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
            },
            'Cancelar': function () {
                  $(this).dialog('close');
            }
          }
        });

        // Ruta para eliminacion de producto por area
        $('a.eliminar_producto_area').bind('click', function () {
          var ruta = $('#direccionelim_area').text();
          var id_detalle_producto_area = $(this).attr('id').replace('elim_', '');
          var parent = $(this).parent().parent();
          $("#dialog-confirm").data({
            'delid': id_detalle_producto_area,
            'parent': parent,
            'ruta': ruta
          }).dialog('open');
          return false;
        });

        $("#dialog-confirm").dialog({
          resizable: false,bgiframe: true,autoOpen: false,width: 400,height: "auto",zindex: 9998,modal: false,
          buttons: {
            'Eliminar': function () {
              var parent = $(this).data('parent');
              var id_detalle_producto_area = $(this).data('delid');
              var ruta = $(this).data('ruta');
              $.ajax({
                type: 'get',
                url: ruta,
                data: {'eliminar' : id_detalle_producto_area },
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
                      modal: true,position: 'center',width: 600,height: 125,resizable: false,title: '!No se puede eliminar el Producto!',
                      buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                    });
                    $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
                  }
                }
              });
              $(this).dialog('close');
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
  function editar_producto(id_pro,id_detalle_producto_area){
    // pasamos un objeto como parametro
    var array_json = Array();
    array_json[0] = id_pro;
    array_json[1] = id_detalle_producto_area;

    // conviertier a objeto
    var jObject = {};
    for(i in array_json){
        jObject[i] = array_json[i];
    }
    jObject= JSON.stringify(jObject);

    var urlMaq = '<?php echo base_url();?>comercial/editarproducto/'+jObject;
    $("#mdlEditarProducto").load(urlMaq).dialog({
      modal: true, position: 'center', width: 350, height: 483, draggable: false, resizable: false, closeOnEscape: false,
      buttons: {
        Actualizar: function() {
        var editidprod = $('#editidprod').val(); editnombreprod = $('#editnombreprod').val(); editcat = $('#editcat').val(); editunid_med = $('#editunid_med').val(); 
        var editobser = $('#editobser').val(); editprocedencia = $('#editprocedencia').val(); edittipoprod = $('#edittipoprod').val();
        var editestado = $('#editestado').val(); editindicador = $('#editindicador').val(); editarea = $('#editarea').val();
        if(editidprod == '' || editnombreprod == '' || editcat == '' || editprocedencia == '' || editunid_med == '' || edittipoprod == '' || editarea == ''){
          sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
        }else{
          var dataString = 'editidprod='+editidprod+'&editnombreprod='+editnombreprod+'&editarea='+editarea+'&edittipoprod='+edittipoprod+'&editcat='+editcat+'&editunid_med='+editunid_med+'&editprocedencia='+editprocedencia+'&editobser='+editobser+'&editestado='+editestado+'&editindicador='+editindicador+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
          $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>comercial/actualizarproducto/"+jObject,
            data: dataString,
            success: function(msg){
              if(msg == 1){
                swal({ title: "El Producto ha sido actualizado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                $("#mdlEditarProducto").dialog("close");
              }else{
                sweetAlert(msg, "", "error");
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

  function delete_producto(id_pro){
          swal({   
            title: "Estas seguro?",
            text: "No se podrá recuperar esta información!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar!",
            closeOnConfirm: false 
          },
          function(){
            var dataString = 'id_pro='+id_pro+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>comercial/eliminarproducto/",
              data: dataString,
              success: function(msg){
                if(msg == 'ok'){
                  swal("Eliminado!", "El producto ha sido eliminado.", "success");
                }else if(msg == 'dont_delete'){
                  sweetAlert("No se puede eliminar el producto", "El producto debe estar asociado a una factura, salida o cierre de almacén.", "error");
                }
              }
            });
          });
        }

        

        function delete_producto_area(id_detalle_producto_area){
          swal({   
            title: "Estas seguro?",
            text: "No se podrá recuperar esta información!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar!",
            closeOnConfirm: false 
          },
          function(){
            var dataString = 'id_detalle_producto_area='+id_detalle_producto_area+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>comercial/eliminarproducto_area/",
              data: dataString,
              success: function(msg){
                if(msg == 'ok'){
                  swal("Eliminado!", "El producto ha sido eliminado.", "success");
                }else if(msg == 'dont_delete'){
                  sweetAlert("No se puede eliminar el producto", "El Producto tiene Stock Asignado para esa Área.", "error");
                }
              }
            });
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
      <!--<div class="tituloFiltro">Filtros para Exportar a PDF</div>-->
      <div id="options_productos">
        <div class="newprospect">Nuevo Producto</div>
        <div class="newprospect_new_area" style="width: 260px;">Agregar un producto a una nueva área</div>
        <div class="newct"><a href="<?php echo base_url(); ?>comercial/gestioncategoriaproductos/">Categoria de Producto</a></div>
        <div class="newtp"><a href="<?php echo base_url(); ?>comercial/gestiontipoproductos/">Tipo de Producto</a></div>
        <input name="export_excel" type="submit" id="export_excel" value="EXPORTAR INVENTARIO DE ALMACEN" style="padding-bottom:5px; padding-top:3px; background-color: #FF5722; border-radius:6px;width: 215px;margin-left:407px;" />
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
        <table border="0" cellspacing="0" cellpadding="0" id="listaProductos" style="width:1370px;padding-top: 8px;" class="table table-hover table-striped">
          <thead>
            <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
              <td sort="idprod" width="65" height="27">ITEM</td>
              <td sort="procprod" width="120" height="27">ID PRODUCTO</td>
              <td sort="procprod" width="340">NOMBRE O DESCRIPCIÓN</td>
              <td sort="procprod" width="130">AREA</td>
              <td sort="procprod" width="120">CATEGORIA</td>
              <td sort="procprod" width="130">TIPO PRODUCTO</td>
              <!--<td sort="procprod" width="120">UNIDAD MEDIDA</td>-->
              <td sort="procprod" width="110">STA. CLARA</td>
              <td sort="procprod" width="110">STA. ANITA</td>
              <td width="28" style="background-image: none;"></td>
              <td width="20" style="background-image: none;">&nbsp;</td>
              <td width="20" style="background-image: none;">&nbsp;</td>
            </tr>
          </thead>
          <?php
            $i = 1;
            foreach($producto as $listaproductos){
              $vacio = 0;
          ?>  
          <tr class="contentTable" style="font-size: 12px;">
            <td height="27" style="vertical-align: middle;"><?php echo str_pad($i, 4, 0, STR_PAD_LEFT); ?></td>
            <td style="vertical-align: middle;"><?php echo $listaproductos->id_producto; ?></td>
            <td style="vertical-align: middle;"><?php echo $listaproductos->no_producto; ?></td>
            <td style="vertical-align: middle;"><?php echo $listaproductos->no_area; ?></td>
            <td style="vertical-align: middle;"><?php echo $listaproductos->no_categoria; ?></td>
            <td style="vertical-align: middle;"><?php echo $listaproductos->no_tipo_producto; ?></td>
            <!--<td><?php //echo $listaproductos->no_procedencia; ?></td>-->
            <!--<td style="vertical-align: middle;"><?php //echo $listaproductos->nom_uni_med; ?></td>-->
            <td style="vertical-align: middle;"><?php echo $listaproductos->stock_area_sta_clara; ?></td>
            <td style="vertical-align: middle;"><?php echo $listaproductos->stock_area_sta_anita; ?></td>
            <td style="vertical-align: middle;">
              <?php 
                if($listaproductos->column_temp == ""){
              ?>
                <span class="icon-ban" style="color: red;cursor: pointer;"></span>
              <?php
                }else if($listaproductos->column_temp == "NUEVO" || $listaproductos->column_temp == "NUEVO 14" || $listaproductos->column_temp == "NUEVO 14S"){
              ?>
                <span class="fa fa-thumbs-o-up" style="color: green;cursor: pointer;"></span>
              <?php
                }
              ?>
            </td>
            <td width="20" style="vertical-align: middle;">
              <img class="editar_producto" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar producto" onClick="editar_producto(<?php echo $listaproductos->id_pro; ?>, <?php if($listaproductos->id_detalle_producto_area != ''){echo $listaproductos->id_detalle_producto_area;}else{echo $vacio;} ?>)" style="cursor: pointer;"/>
            </td>
            <?php 
              if($listaproductos->id_detalle_producto_area == ''){
            ?>
              <td width="20" style="vertical-align: middle;">
                <img class="delete_producto" src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Producto" onClick="delete_producto(<?php echo $listaproductos->id_pro; ?>)" style="cursor: pointer;"/>
                <!--
                <a href="" class="eliminar_producto" id="elim_<?php //echo $listaproductos->id_pro; ?>">
                <img src="<?php //echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Producto" style="cursor: pointer;"/></a>
                -->
              </td>
            <?php
              }else{
            ?>
              <td width="20" style="vertical-align: middle;">
                <img class="delete_producto_area" src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Producto" onClick="delete_producto_area(<?php echo $listaproductos->id_detalle_producto_area; ?>)" style="cursor: pointer;"/>
                <!--
                <a href="" class="eliminar_producto_area" id="elim_<?php //echo $listaproductos->id_detalle_producto_area; ?>">
                <img src="<?php //echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Producto" style="cursor: pointer;"/></a>
                -->
              </td>
            <?php } ?>
          </tr>
          <?php
            $i++;
            } 
          ?>      
        </table>
      <?php }?>
    </div>
  </div>
  <!---  Ventanas modales -->
  <div id="mdlNuevoProducto" style="display:none">
    <div id="contenedor" style="width:320px; height:290px;"> <!--Aumenta el marco interior-->
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
            <td width="263"><?php echo form_dropdown('area',$listaarea,$selected_area,"id='area' style='margin-left: 0px;width: 150px;'" );?></td>
          </tr>
          <tr> 
              <td>Categoria:</td>
              <td width="263"><?php echo form_dropdown('categoriaN',$listacategoria,'',"id='categoriaN' style='margin-left: 0px;width: 150px;'");?>
              <div align="right"></div></td>
          </tr>
          <tr> 
              <td height="30">Tipo de Producto:</td>
              <td>
                <select name="tipo" id="tipo" class='required' style='width:158px;margin-left: 0px;width: 150px;'></select>
              </td>
          </tr>
          <tr>
              <td>Procedencia:</td>
              <td><?php echo form_dropdown('procedenciaN',$listaprocedencia,'',"id='procedenciaN' style='margin-left: 0px;width: 150px;'");?></td>
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

  <div id="mdl_area_producto" style="display:none">
    <div id="contenedor" style="width:350px; height:140px;"> <!--Aumenta el marco interior-->
      <div id="tituloCont">Agregar área a un producto</div>
      <div id="formFiltro" style="width:500px;">
      <?php
        $nombrepro_agregar_area = array('name'=>'nombrepro_agregar_area','id'=>'nombrepro_agregar_area','maxlength'=>'60', 'style'=>'width:180px;margin-left: 18px;');//este es un input
      ?>  
      <form method="post" id="nuevo_producto" style=" border-bottom:0px">
        <table>
          <tr>
            <td width="130" style="text-align: end;padding-bottom: 4px;">NOMBRE DEL PRODUCTO:</td>
            <td width="263"><?php echo form_input($nombrepro_agregar_area);?></td>
          </tr>
          <tr>
            <td style="text-align: end;padding-bottom: 4px;">AREA:</td>
            <td width="263"><?php echo form_dropdown('area_2',$listaarea,$selected_agregar_area,"id='area_2' style='width: 180px;margin-left: 18px;'" );?></td>
          </tr>
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
    <div style="display:none">
      <div id="direccionelim_area"><?php echo site_url('comercial/eliminarproducto_area');?></div>
    </div>
    <div id="dialog-confirm" style="display: none;" title="Eliminar Producto">
      <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
        ¿Está seguro que quiere eliminar el producto?<br /><strong>¡Esta acción no se puede revertir!</strong>
      </p>
    </div>