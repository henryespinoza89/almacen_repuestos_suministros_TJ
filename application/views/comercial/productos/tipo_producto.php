<?php
  //$nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=> '50','minlength'=>'1', 'style'=>'margin-bottom:0px' );
  if ($this->input->post('nombre')){
    $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=>'20','value'=>$this->input->post('nombre'), 'style'=>'width:150px', 'class'=>'required');
  }else{
    $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=>'20', 'style'=>'width:150px', 'class'=>'required');
  }
?>

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

    //$("#categoria").append('<option value="" selected="selected">:: SELECCIONE ::</option>');
      //Script para crear la tabla que será el contenedor de los productos registrados
    $('#listaTiposProductos').jTPS( {perPages:[10,15,20,'Todos'],scrollStep:1,scrollDelay:30,clickCallback:function () {     
            // target table selector
            var table = '#listaTiposProductos';
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
                                    $('#listaTiposProductos .sortableHeader:eq(' + parseInt(command[1]) + ')').click();
                            } else if (command[0] == 'sortdesc' && parseInt(command[1]) >= 0) {
                                    $('#listaTiposProductos .sortableHeader:eq(' + parseInt(command[1]) + ')').click().click();
                            } else if (command[0] == 'page' && parseInt(command[1]) >= 0) {
                                    $('#listaTiposProductos .pageSelector:eq(' + parseInt(command[1]) + ')').click();
                            }
                    }
            }
    }
    // bind mouseover for each tbody row and change cell (td) hover style
    $('#listaTiposProductos tbody tr:not(.stubCell)').bind('mouseover mouseout',
            function (e) {
                    // hilight the row
                    e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
            }
    );

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
        //alert(urlMaq);
        $("#mdlEditarTipoProducto").load(urlMaq).dialog({
          modal: true, position: 'center', width: 410, height: 230, draggable: false, resizable: false, closeOnEscape: false,
          buttons: {
            Actualizar: function() {
            $(".ui-dialog-buttonpane button:contains('Actualizar')").button("disable");
            $(".ui-dialog-buttonpane button:contains('Actualizar')").attr("disabled", true).addClass("ui-state-disabled");
            //CONTROLO LAS VARIABLES
            var edittipprod = $('#edittipprod').val(); editcateprod = $('#editcateprod').val();
            if(edittipprod == '' || editcateprod == ''){
              $("#modalerror").html('<b>ERROR:</b> Faltan completar el campos del formulario, por favor verifique.').dialog({
                modal: true,position: 'center',width: 450, height: 120,resizable: false,
                buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");$( this ).dialog( "close" );}}
              });
            }else{
              var dataString = 'edittipprod='+edittipprod+'&editcateprod='+editcateprod+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/actualizartipoproducto/"+id_tipo_producto,
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    $("#finregistro").html('!El Tipo de Producto ha sido actualizada con éxito!.').dialog({
                      modal: true,position: 'center',width: 400,height: 125,resizable: false, title: 'Fin de Registro',
                      buttons: { Ok: function(){
                        window.location.href="<?php echo base_url();?>comercial/gestiontipoproductos";
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
            $("#mdlEditarTipoProducto").dialog("close");
          }
                }
        });
      }



</script>

</head>
<body>
  <div id="contenedor">
    <div id="tituloCont">Registrar Tipo de Producto</div>
    <div id="formFiltro">
        <?php echo form_open(base_url()."comercial/registrartipoproducto", 'id="registrar"') ?>
          <table width="979" border="0" cellspacing="0" cellpadding="0" style="margin-top: 4px;">
            <tr>
              <td width="260" style="width: 250px;padding-bottom: 6px;">Seleccione la Categoría del Producto:</td>
              <?php
                  $existe = count($listacategoriaproducto);
                  if($existe <= 0){ ?>
                    <td width="200" height="28"><b><?php echo 'Registrar en el Sistema';?></b></td>
              <?php    
                  }
                  else
                  {
                ?>
                    <td width="200"><?php echo form_dropdown('categoria',$listacategoriaproducto,$selected_categoria,'id="categoria" style="width:158px;"');?></td>
              <?php }?>
            </tr>
            <tr>
              <td width="208" style="padding-bottom: 6px;">Ingrese el Tipo de Producto:</td>
              <td width="196" style="padding-top: 5px;"><?php echo form_input($nombre);?></td>
              <td width="103" align="left"><input name="submit" type="submit" id="submit" value="Registrar" /></td>
              <td width="472" ><?php echo validation_errors(); if(!empty($respuesta)){ echo $respuesta;} ?></td>
            </tr>
          </table>
        <?php echo form_close() ?>
        <div id="tituloCont" style="border-bottom-style:none;">Lista de Tipos de Productos asociadas a una Categoría</div>
        <!--Iniciar listar-->
        <?php 
          $existe = count($listatipoproducto);
          if($existe <= 0){
            echo 'No existen Tipos de Productos registrados en el Sistema.';
          }
          else
          {
        ?>
        <table border="0" cellspacing="0" cellpadding="0" id="listaTiposProductos">
          <thead>
            <tr class="tituloTable">
              <td sort="idproducto" width="80" height="25">Item</td>
              <td sort="nombreprod" width="180">Categoría de Producto</td>
              <td sort="nombreprod" width="180">Tipos de Producto</td>
              <td width="20">&nbsp;</td>
              <td width="20">&nbsp;</td>
            </tr>
          </thead>
          <?php
            $i=1;
            foreach($listatipoproducto as $listartipoproducto){ 
          ?>  
          <tr class="contentTable">
            <!--<td><?php //echo str_pad($listartipoproducto->id_marca_maquina, 5, 0, STR_PAD_LEFT); ?></td>-->
            <td height="27"><?php echo str_pad($i,4,0, STR_PAD_LEFT);?></td>
            <td><?php echo $listartipoproducto->no_categoria; ?></td>
            <td><?php echo $listartipoproducto->no_tipo_producto; ?></td>
            <td width="20" align="center"><img class="editar_tipo_producto" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar Tipo de Producto" onClick="editar_tipo_producto(<?php echo $listartipoproducto->id_tipo_producto; ?>)" /></td>
            <td width="20" align="center">
              <a href="" class="eliminar_registro" id="elim_<?php echo $listartipoproducto->id_tipo_producto; ?>">
              <img src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Tipo de Producto"/></a>
            </td>
          </tr>
          <?php
            $i++;
            } 
          ?> 
          <tfoot class="nav">
            <tr>
              <td colspan=8>
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

