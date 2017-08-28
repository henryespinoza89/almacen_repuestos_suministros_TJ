<script type="text/javascript">
	$(function(){

  $("#nombre_producto").autocomplete({
    source: function (request, respond) {
      $.post("<?php echo base_url('comercial/traer_producto_autocomplete_consultar_salidas'); ?>", {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>", q: request.term},
      function (response) {
          respond(response);
      }, 'json');
    }, select: function (event, ui) {
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
            'nombre_producto' : nombre_producto
          },
          success: function(response){
            $("#stockactual").val(formatNumber.new(response));
          }
      });
      $("#cantidad").focus();
    }
  });

  $("#button_killer").on("click",function(){
    var fechainicial = $("#fechainicial").val();
    var fechafinal = $("#fechafinal").val();
    if(fechafinal == '' || fechainicial == ''){
      $("#modalerror").html('<strong>!Falta Completar algunos Campos del Formulario. Verificar!</strong>').dialog({
        modal: true,position: 'center',width: 450, height: 125,resizable: false,title: 'Validación de Registro',hide: 'blind',show: 'blind',
        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
      });
    }else{
      var dataString = 'fechainicial='+fechainicial+'&fechafinal='+fechafinal+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/procedimiento_eliminacion_salidas/",
        data: dataString,
        success: function(response){
          if(response == 1){
            $("#modalerror").empty().append('<span style="color:black"><b>!Procedimiento realizado con Éxito!</b></span>').dialog({
              modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {
                // window.location.href="<?php echo base_url();?>comercial/gestionconsultarSalidaRegistros";
                $(this).dialog("close");
              }}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
          }
        }
      });
    }
  });

$("#actualizar_saldos_iniciales").on("click",function(){
    var fechainicial = $("#fechainicial").val();
    var fechafinal = $("#fechafinal").val();
    if(fechafinal == '' || fechainicial == ''){
      $("#modalerror").html('<strong>!Falta Completar algunos Campos del Formulario. Verificar!</strong>').dialog({
        modal: true,position: 'center',width: 450, height: 125,resizable: false,title: 'Validación de Registro',hide: 'blind',show: 'blind',
        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
      });
    }else{
      var dataString = 'fechainicial='+fechainicial+'&fechafinal='+fechafinal+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/actualizar_saldos_iniciales_controller_version_6/",
        data: dataString,
        success: function(response){
          if(response == 1){
            $("#modalerror").empty().append('<span style="color:black"><b>!Procedimiento realizado con Éxito!</b></span>').dialog({
              modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
              buttons: { Ok: function() {
                $(this).dialog("close");
              }}
            });
            $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
          }
        }
      });
    }
  });

  $("#actualizar_precio_unitario").on("click",function(){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>comercial/actualizar_saldos_iniciales_controller_version_3/",      
      success: function(response){
        if(response == 1){
          $("#modalerror").empty().append('<span style="color:black"><b>!Procedimiento realizado con Éxito!</b></span>').dialog({
            modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
            buttons: { Ok: function() {
              $(this).dialog("close");
            }}
          });
          $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
        }
      }
    });
  });

  $("#actualizar_stock").on("click",function(){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>comercial/actualizar_stock_controller_version_4/",      
      success: function(response){
        if(response == 1){
          $("#modalerror").empty().append('<span style="color:black"><b>!Procedimiento realizado con Éxito!</b></span>').dialog({
            modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
            buttons: { Ok: function() {
              $(this).dialog("close");
            }}
          });
          $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
        }
      }
    });
  });

  $("#actualizar_stock_area").on("click",function(){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>comercial/actualizar_stock_controller_version_5/",      
      success: function(response){
        if(response == 1){
          $("#modalerror").empty().append('<span style="color:black"><b>!Procedimiento realizado con Éxito!</b></span>').dialog({
            modal: true,position: 'center',width: 400,height: 125,resizable: false,title: 'Registro de Salidas',hide: 'blind',show: 'blind',
            buttons: { Ok: function() {
              $(this).dialog("close");
            }}
          });
          $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
        }
      }
    });
  });

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

  $("#fecharegistro").datepicker({ 
    dateFormat: 'yy-mm-dd',showOn: "button",
    buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
    buttonImageOnly: true,
    changeMonth: true,
    changeYear: true
  });
  $(".ui-datepicker-trigger").css('padding-left','7px'); // esta linea separa la imagen del calendario del input
  
  $("#fechainicial").datepicker({ 
    dateFormat: 'yy-mm-dd',showOn: "button",
    buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
    buttonImageOnly: true,
    changeMonth: true,
    changeYear: true
  });
  $(".ui-datepicker-trigger").css('padding-left','7px'); // esta linea separa la imagen del calendario del input

  $("#fechafinal").datepicker({ 
    dateFormat: 'yy-mm-dd',showOn: "button",
    buttonImage: "<?php echo base_url();?>assets/img/calendar.png",
    buttonImageOnly: true,
    changeMonth: true,
    changeYear: true
  });
  $(".ui-datepicker-trigger").css('padding-left','7px'); // esta linea separa la imagen del calendario del input

  $('#listarSalidaProductos').DataTable();

  /* Eliminar Salida */
  $('a.eliminar_salida').bind('click', function () {
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
                $("#finregistro").html('<strong>!La Salida del Producto ha sido eliminado correctamente!</strong>').dialog({
                  modal: true,position: 'center',width: 480,height: 125,resizable: false, title: '!Eliminación Conforme!',
                  buttons: { Ok: function(){
                    // window.location.href="<?php echo base_url();?>comercial/gestionconsultarSalidaRegistros";
                    $("#finregistro").dialog('close');
                  }}
                });
              }else{
                $("#modalerror").empty().append(msg).dialog({
                  modal: true,position: 'center',width: 700,height: 125,resizable: false,title: '!No se puede eliminar la Salida!',
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
    /* Fin de Eliminar Salida */

	});

  //Fuera de $(function(){         });
  function resetear(){
    window.location.href="<?php echo base_url();?>comercial/gestionconsultarSalidaRegistros";
  }

  function delete_salida(id_salida_producto){
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
      var dataString = 'id_salida_producto='+id_salida_producto+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
      
      /*
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/eliminarsalidaproducto/",
        data: dataString,
        success: function(msg){
          if(msg == 'ok'){
            swal("Eliminado!", "El registro de salida ha sido eliminado correctamente.", "success");
          }else if(msg == 'periodo_cierre'){
            sweetAlert("No se puede eliminar el registro", "El registro de salida pertenece a un periodo donde se realizo un cierre de almacen!", "error");
          }
        }
      });
      */

      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/eliminarregistrosalida/",
        data: dataString,
        success: function(msg){
          if(msg == 'eliminacion_correcta'){
            swal({
              title: "La salida ha sido eliminada con Éxito!",
              text: "",
              type: "success",
              confirmButtonText: "OK"
            },function(isConfirm){
              if (isConfirm) {
                window.location.href="<?php echo base_url();?>comercial/gestion_consultar_salida_registros";  
              }
            });
          }else if(msg == 'periodo_cerrado'){
            sweetAlert("No se puede eliminar la salida", "No puede eliminar salidas de un periodo donde ya realizo el Cierre Mensual de Almacén. Verificar!", "error");
          }else if(msg == 'valores_negativos_producto'){
            sweetAlert("No se puede eliminar la salida", "Se produce valores negativos en el stock o precio unitario de los productos asociados a la salida. Existen salidas posteriores a la fecha de salida. Verificar!", "error");
          }
        }
      });


    });
  }

</script>
</head>
<body>
  <div id="contenedor">
    <div id="tituloCont">Consultar salida de productos</div>
    <div id="formFiltro">
      <!--
      <div>
        <input name="submit" type="submit" id="button_killer" value=" Buttom Killer xD" style="padding-bottom:3px; padding-top:3px; margin-bottom: 15px; background-color: #CD0A0A; border-radius:6px; width: 150px;margin-right: 15px;" />
      </div>
      -->
      <!--
      <div>
        <input name="submit" type="submit" id="actualizar_saldos_iniciales" value="Actualizar saldos iniciales" style="padding-bottom:3px; padding-top:3px; margin-bottom: 15px; background-color: #CD0A0A; border-radius:6px; width: 150px;margin-right: 15px;" />
      </div>
      -->
      <!--
      <div>
        <input name="submit" type="submit" id="actualizar_precio_unitario" value="Actualizar Precio Unitario" style="padding-bottom:3px; padding-top:3px; margin-bottom: 15px; background-color: #CD0A0A; border-radius:6px; width: 150px;margin-right: 15px;" />
      </div>
      -->
      <!--
      <div>
        <input name="submit" type="submit" id="actualizar_stock" value="Actualizar Stock" style="padding-bottom:3px; padding-top:3px; margin-bottom: 15px; background-color: #CD0A0A; border-radius:6px; width: 150px;margin-right: 15px;" />
      </div>
      -->
      <!--
      <div>
        <input name="submit" type="submit" id="actualizar_stock_area" value="Actualizar Stock por Área" style="padding-bottom:3px; padding-top:3px; margin-bottom: 15px; background-color: #CD0A0A; border-radius:6px; width: 150px;margin-right: 15px;" />
      </div>
      -->
      <?php
        foreach($anios_registros_salidas as $row_anios){
          $input_filter_list_anio = array('name'=>'input_filter_list_anio_'.$row_anios->fecha_registro,'id'=>'input_filter_list_anio_'.$row_anios->fecha_registro,'maxlength'=>'20', 'value'=>$row_anios->fecha_registro, 'style'=>'display:none');
      ?>
        <form name="filtroBusqueda" action="#" method="post" style="width:140px; float:left;margin-bottom: 0px;border-bottom: none;">
          <?php echo form_open(base_url()."comercial/gestion_consultar_salida_registros", 'id="buscar" style="width:780px;margin-bottom: 0px;border-bottom: none;"') ?>
            <table width="150" border="0" cellspacing="0" cellpadding="0" style="display:block;float: left;">
              <tr>
                <td width="219" style="display: none;"><?php echo form_input($input_filter_list_anio);?></td>
                <td width="150" style="padding-bottom:4px;">
                  <?php 
                    if ($this->input->post('input_filter_list_anio_'.$row_anios->fecha_registro)){
                  ?>
                    <input name="submit" type="submit" id="submit" value="<?php echo $row_anios->fecha_registro ?>" style="padding-bottom:3px; padding-top:3px; margin-bottom: 15px; background-color: #FF5722; border-radius:6px; width: 100px;margin-right: 15px;" />
                  <?php } else { ?>
                    <input name="submit" type="submit" id="submit" value="<?php echo $row_anios->fecha_registro ?>" style="padding-bottom:3px; padding-top:3px; margin-bottom: 15px; background-color: #303F9F; border-radius:6px; width: 100px;margin-right: 15px;" />
                  <?php } ?>
                </td>
              </tr>
            </table>
          <?php echo form_close() ?>
        </form>
      <?php
        } 
      ?>
      
      <?php 
      $existe = count($salidaproducto);
      if($existe <= 0){
        echo 'No existen Registros de Salida en el Sistema.';
      }
      else
      {
      ?>
      <table border="0" cellspacing="0" cellpadding="0" id="listarSalidaProductos" style="float: left;width:1360px;" class="table table-hover table-striped">
          <thead>
              <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
                <td sort="idprod" width="75" height="25">ITEM</td>
                <td sort="procprod" width="150">AREA</td>
                <td sort="procprod" width="150">SOLICITANTE</td>
                <td sort="procprod" width="100">FECHA</td>
                <td sort="procprod" width="350">PRODUCTO O DESCRIPCION</td>
                <td sort="procprod" width="90">CANTIDAD</td>
                <td width="20" style="background-image: none;">&nbsp;</td>
                <!--
                
                <td width="20">&nbsp;</td>
                -->
              </tr>
          </thead>
          <?php 
          $i = 1;
          foreach($salidaproducto as $listasalidaproductos){ ?>  
              <tr class="contentTable" style="font-size: 12px;">
                <td height="27" style="vertical-align: middle;"><?php echo str_pad($i, 3, 0, STR_PAD_LEFT); ?></td>
                <td style="vertical-align: middle;"><?php echo $listasalidaproductos->no_area; ?></td>
                <td style="vertical-align: middle;"><?php echo $listasalidaproductos->solicitante; ?></td>
                <td style="vertical-align: middle;"><?php echo $listasalidaproductos->fecha; ?></td>
                <td style="vertical-align: middle;"><?php echo $listasalidaproductos->no_producto; ?></td>
                <td style="vertical-align: middle;"><?php echo number_format($listasalidaproductos->cantidad_salida,2,'.',',');?></td>
                <!--
                <td width="20" align="center"><img class="editar_producto" src="<?php // echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar producto" onClick="editar_producto(<?php echo $listasalidaproductos->id_salida_producto; ?>)" /></td>
                -->
                <td width="20" align="center">
                  <img class="delete_salida" src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Salida" onClick="delete_salida(<?php echo $listasalidaproductos->id_salida_producto; ?>)" style="cursor: pointer;"/>
                  <!--
                  <a href="" class="eliminar_salida" id="elim_<?php // echo $listasalidaproductos->id_salida_producto; ?>">
                  <img src="<?php // echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Salida"/></a>
                  -->
                </td>
                
              </tr>
          <?php 
            $i++;
            } 
          ?>       
      </table>
    <?php }?>
    </div>
  </div>
  <div id="modalerror"></div>
  <div id="finregistro"></div>
  <div style="display:none">
    <div id="direccionelim"><?php echo site_url('comercial/eliminarsalidaproducto');?></div>
  </div>
  <div id="dialog-confirm" style="display: none;" title="Eliminar Salida">
    <p>
      <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
      ¿Está seguro que quiere eliminar la Salida del producto?<br /><strong>¡Esta acción no se puede revertir!</strong>
    </p>
  </div>