<?php
  $file = array('name'=>'file','id'=>'file','maxlength'=>'20', 'style'=>'width:300px', 'class'=>'required', 'type'=>'file');
?>

<script type="text/javascript">
  $(function(){
  
  /* ------------ VALIDACIÓN DE DATOS DE PRODUCTOS ------------ */
  <?php if(!empty($respuesta_validacion_producto_invalido)){ ?>
    var producto_erroneo = "<?php echo $respuesta_validacion_producto_invalido; ?>" ;
  <?php } ?>

  <?php if(!empty($respuesta_validacion_producto_invalido)){ ?>
    $("#error_respuesta_validacion_producto_invalido").html('<strong>! Se encontro un Error en el Producto en la Fila '+ producto_erroneo + ' !<br> Verificar el Archivo Excel/Csv y volver a Cargar la Data.</strong>').dialog({
      modal: true,position: 'center',width: 500,height: 138, resizable: false, title: 'Error de Validación',hide: 'scale',show: 'scale',
      buttons: { Ok: function(){
        $(this).dialog('close');
      }}
    });
  <?php } ?>
  // ------------ FIN DE VALIDACIÓN DE PRODUCTOS ------------

  /* ------------ VALIDACIÓN DE DATOS DE PRODUCTOS ------------ */
  <?php if(!empty($respuesta_validacion_area_invalido)){ ?>
    var area_erroneo = "<?php echo $respuesta_validacion_area_invalido; ?>" ;
  <?php } ?>

  <?php if(!empty($respuesta_validacion_area_invalido)){ ?>
    $("#error_respuesta_validacion_area_invalido").html('<strong>! Se encontro un Error en el Área en la Fila '+ area_erroneo + ' !<br> Verificar el Archivo Excel/Csv y volver a Cargar la Data.</strong>').dialog({
      modal: true,position: 'center',width: 500,height: 138, resizable: false, title: 'Error de Validación',hide: 'scale',show: 'scale',
      buttons: { Ok: function(){
        $(this).dialog('close');
      }}
    });
  <?php } ?>
  /* ------------ FIN DE VALIDACIÓN DE PRODUCTOS ------------ */

  });
</script>

</head>
<body>
  <div id="contenedor" style="padding-top: 10px;">
    <div id="tituloCont">Carga Masiva de Actualización de Productos</div>
    <div id="formFiltro">
      <form id="formulario" action="<?php echo base_url('comercial/actualizar_informacion_producto');?>" enctype="multipart/form-data" method="post" style="padding-bottom: 13px;">
        <table width="625" border="0" cellspacing="0" cellpadding="0" style="margin-top: 4px;">
          <tr>
            <td width="187">Seleccione el Archivo a subir:</td>
            <td width="194" style="padding-top: 5px;"><?php echo form_input($file);?></td>
            <td><input id="" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" type="hidden" /></td>
            <td width="134" align="left"><input name="submit" type="submit" id="submit" value="Subir Archivo" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <div id="finregistro"></div>
  <div id="modalerror"></div>

  <?php if(!empty($respuesta_validacion_producto_invalido)){ ?>
    <div id="error_respuesta_validacion_producto_invalido"></div>
  <?php } ?>

  <?php if(!empty($respuesta_validacion_area_invalido)){ ?>
    <div id="error_respuesta_validacion_area_invalido"></div>
  <?php } ?>