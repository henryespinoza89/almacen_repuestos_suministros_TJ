<script type="text/javascript">
  $(function(){

    <?php 
      if ($this->input->post('categoria')){
        $selected_categoria =  (int)$this->input->post('categoria');
      }else{  $selected_categoria = "";
    ?>
      $("#categoria").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
    <?php 
      } 
    ?>

    $('#listaTiposProductos').DataTable();

    $(".newprospect").click(function(){
      $("#mdlTipoProducto" ).dialog({
        modal: true,resizable: false,show: "blind",hide: "blind",position: 'center',width: 465,height: 250,draggable: false,closeOnEscape: false, //Aumenta el marco general
        buttons: {
        Registrar: function() {
            var tipo_producto_modal = $('#tipo_producto_modal').val(); categoria = $('#categoria').val();
            if(tipo_producto_modal == '' || categoria == ''){
              sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
            }else{
              //REGISTRO
              var dataString = 'tipo_producto_modal='+tipo_producto_modal+'&categoria='+categoria+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/save_tipo_producto/",
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    swal({ title: "El Tipo de Producto ha sido regristado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                    $("#mdlTipoProducto").dialog("close");
                    $('#tipo_producto_modal').val('');
                    $('#categoria').val('');
                  }else{
                    sweetAlert(msg, "", "error");
                  }
                }
              });
            }
          },
          Cancelar: function(){
            $("#mdlTipoProducto").dialog("close");
          }
          }
      });
    });

    // ELIMINAR REGISTRO
    $('a.eliminar_registro').bind('click', function () {
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
                setTimeout('window.location.href="<?php echo base_url(); ?>comercial/gestiontipoproductos"', 200);
        },
            'Cancelar': function () {
                  $(this).dialog('close');
            }
        }
    });
    // FIN DE ELIMINAR

  });


  // Editar Máquina
  function editar_tipo_producto(id_tipo_producto){
        var urlMaq = '<?php echo base_url();?>comercial/editartipoproducto/'+id_tipo_producto;
        $("#mdlEditarTipoProducto").load(urlMaq).dialog({
          modal: true, position: 'center', width: 410, height: 260, draggable: false, resizable: false, closeOnEscape: false,
          buttons: {
            Actualizar: function() {
            var edittipprod = $('#edittipprod').val(); editcateprod = $('#editcateprod').val();
            if(edittipprod == '' || editcateprod == ''){
              sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
            }else{
              var dataString = 'edittipprod='+edittipprod+'&editcateprod='+editcateprod+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/update_tipo_producto/"+id_tipo_producto,
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    swal({ title: "El Tipo de Producto ha sido actualizado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                    $("#mdlEditarTipoProducto").dialog("close");
                  }else{
                    sweetAlert(msg, "", "error");
                  }
                }
              });
            }
          },
          Cancelar: function(){
            $("#mdlEditarTipoProducto").dialog("close");
          }
                }
        });
      }

  function delete_tipo_producto(id_tipo_producto){
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
      var dataString = 'id_tipo_producto='+id_tipo_producto+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/eliminar_tipo_producto/",
        data: dataString,
        success: function(msg){
          if(msg == 'ok'){
            swal("Eliminado!", "El Tipo de producto ha sido eliminado.", "success");
          }else if(msg == 'dont_delete'){
            sweetAlert("No se puede eliminar el tipo de producto", "Verificar que productos han sido registrados con este tipo de producto.", "error");
          }
        }
      });
    });
  }



</script>

</head>
<body>
  <div id="contenedor">
    <div id="tituloCont">Tipo de Producto</div>
    <div id="formFiltro">
      <div id="options_productos">
        <div class="newprospect" style="width: 220px;">NUEVO TIPO DE PRODUCTO</div>
      </div>
        <!--Iniciar listar-->
        <?php 
          $existe = count($listatipoproducto);
          if($existe <= 0){
            echo 'No existen Tipos de Productos registrados en el Sistema.';
          }
          else
          {
        ?>
        <table border="0" cellspacing="0" cellpadding="0" id="listaTiposProductos" style="float: left;width: 700px;" class="table table-hover table-striped">
          <thead>
            <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
              <td sort="idproducto" width="60" height="27">ITEM</td>
              <td sort="nombreprod" width="180">CATEGORIA DE PRODUCTO</td>
              <td sort="nombreprod" width="180">TIPO DE PRODUCTO</td>
              <td width="20" style="background-image: none;">&nbsp;</td>
              <td width="20" style="background-image: none;">&nbsp;</td>
            </tr>
          </thead>
          <?php
            $i=1;
            foreach($listatipoproducto as $listartipoproducto){ 
          ?>  
          <tr class="contentTable" style="font-size: 12px;">
            <td height="27" style="vertical-align: middle;"><?php echo str_pad($i,4,0, STR_PAD_LEFT);?></td>
            <td style="vertical-align: middle;"><?php echo $listartipoproducto->no_categoria; ?></td>
            <td style="vertical-align: middle;"><?php echo $listartipoproducto->no_tipo_producto; ?></td>
            <td width="20" align="center"><img class="editar_tipo_producto" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar Tipo de Producto" onClick="editar_tipo_producto(<?php echo $listartipoproducto->id_tipo_producto; ?>)" style="cursor: pointer;"/></td>
            <td width="20" align="center"><img class="delete_tipo_producto" src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Tipo de Producto" onClick="delete_tipo_producto(<?php echo $listartipoproducto->id_tipo_producto; ?>)" style="cursor: pointer;"/></td>
          </tr>
          <?php
            $i++;
            } 
          ?>         
        </table>
        <?php }?>
    </div>
  </div>
  <div id="mdlEditarTipoProducto"></div>
  <div id="finregistro"></div>
  <div id="modalerror"></div>
  <div style="display:none">
    <div id="direccionelim"><?php echo site_url('comercial/eliminartipoproducto');?></div>
  </div>
  <div id="dialog-confirm" style="display: none;" title="Eliminar Tipo de Producto">
    <p>
      <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
      ¿Está seguro que quiere eliminar este Tipo de Producto?<br /><strong>¡Esta acción no se puede revertir!</strong>
    </p>
  </div>

<!---  Ventanas modales -->
<div id="mdlTipoProducto" style="display:none">
  <div id="contenedor" style="width:415px; height:120px;">
    <div id="tituloCont">Nuevo Tipo de Producto</div>
    <div id="formFiltro" style="width:500px;">
    <?php $tipo_producto_modal = array('name'=>'tipo_producto_modal','id'=>'tipo_producto_modal','maxlength'=>'50', 'class'=>'required', 'style'=>'width:158px'); ?>  
      <form method="post" id="nueva_maquina" style=" border-bottom:0px">
        <table>
          <tr>
            <td width="260" style="width: 220px;padding-bottom: 6px;">Seleccione la Categoría del Producto:</td>
            <?php
              $existe = count($listacategoriaproducto);
              if($existe <= 0){ ?>
                <td width="200" height="28"><b><?php echo 'Registrar en el Sistema';?></b></td>
            <?php    
              }else{
            ?>
                <td width="200"><?php echo form_dropdown('categoria',$listacategoriaproducto,$selected_categoria,'id="categoria" style="width:158px;margin-left: 0px;"');?></td>
            <?php }?>
          </tr>
          <tr>
            <td width="208" style="padding-bottom: 6px;">Ingrese el Tipo de Producto:</td>
            <td width="196" style="padding-top: 5px;"><?php echo form_input($tipo_producto_modal);?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
