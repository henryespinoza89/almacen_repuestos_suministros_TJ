<script type="text/javascript">
  $(function(){

    $('#listaAreas').DataTable();

    $(".newprospect").click(function(){
      $("#mdlNuevaArea" ).dialog({
        modal: true,resizable: false,show: "blind",hide: "blind",position: 'center',width: 355,height: 250,draggable: false,closeOnEscape: false,
        buttons: {
        Registrar: function() {
            var area = $('#area').val(); nombre_responsable = $('#nombre_responsable').val();
            if(area == '' || nombre_responsable == ''){
              sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
            }else{
              var dataString = 'area='+area+'&nombre_responsable='+nombre_responsable+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/save_area_encargado/",
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    swal({ title: "El área ha sido regristado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                    $("#mdlNuevaArea").dialog("close");
                    $('#area').val('');
                    $('#nombre_responsable').val('');
                  }else{
                    sweetAlert(msg, "", "error");
                  }
                }
              });
            }
          },
          Cancelar: function(){
            $("#mdlNuevaArea").dialog("close");
          }
          }
      });
    });

  });

  function editar_area_encargado(id_area){
    var urlMaq = '<?php echo base_url();?>comercial/editararea/'+id_area;
    $("#mdlEditarNombreMaquina").load(urlMaq).dialog({
      modal: true, position: 'center', width: 360, height: 250, draggable: false, resizable: false, closeOnEscape: false,
      buttons: {
        Actualizar: function() {
          var editarea = $('#editarea').val(); editresponsable = $('#editresponsable').val(); editresponsable_sta_clara = $('#editresponsable_sta_clara').val();
          if(<?php echo $this->session->userdata('almacen'); ?> == 1){
            var nombre_encargado = editresponsable_sta_clara;
          }else if(<?php echo $this->session->userdata('almacen'); ?> == 2){
            var nombre_encargado = editresponsable;
          }
          if(editarea == '' || nombre_encargado == ''){
            sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
          }else{
            var dataString = 'editarea='+editarea+'&nombre_encargado='+nombre_encargado+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>comercial/actualizararea/"+id_area,
              data: dataString,
              success: function(msg){
                if(msg == 1){
                  swal({ title: "El área ha sido actualizado con éxito!",text: "",type: "success",confirmButtonText: "OK",timer: 2000 });
                  $("#mdlEditarNombreMaquina").dialog("close");
                  $('#editarea').val('');
                  $('#nombre_encargado').val('');
                }else{
                  sweetAlert(msg, "", "error");
                }
              }
            });
          }
        },
        Cancelar: function(){
          $("#mdlEditarNombreMaquina").dialog("close");
        }
      }
    });
  }
  
  function delete_area_encargado(id_area){
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
      var dataString = 'id_area='+id_area+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/eliminar_area/",
        data: dataString,
        success: function(msg){
          if(msg == 'ok'){
            swal("Eliminado!", "El área ha sido eliminado correctamente!", "success");
          }else if(msg == 'dont_delete'){
            sweetAlert("No se puede eliminar el área", "Existen salidas asociadas a esta área.", "error");
          }
        }
      });
    });
  }  

</script>

</head>
<body>
  <div id="contenedor">
    <div id="tituloCont">Áreas y encargados</div>
    <div id="formFiltro">
      <div id="options_productos">
        <div class="newprospect" style="width: 250px;">NUEVA AREA Y ENCARGADO</div>
      </div>
      <!--Iniciar listar-->
      <?php 
        $existe = count($listaarea);
        if($existe <= 0){
          echo 'No existen Áreas y Responsables registrados en el Sistema.';
        }
        else
        {
      ?>
      <table border="0" cellspacing="0" cellpadding="0" id="listaAreas" style="float: left;width: 700px;" class="table table-hover table-striped">
        <thead>
          <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
            <td sort="idproducto" width="100" height="27">ITEM</td>
            <td sort="nombreprod" width="180">AREA</td>
            <td sort="nombreprod" width="180">ENCARGADO</td>
            <td width="20" style="background-image: none;">&nbsp;</td>
            <td width="20" style="background-image: none;">&nbsp;</td>
          </tr>
        </thead>
        <?php
          $i = 1;
          foreach($listaarea as $list){ 
        ?>  
        <tr class="contentTable" style="font-size: 12px;">
          <td height="27" style="vertical-align: middle;"><?php echo str_pad($i, 4, 0, STR_PAD_LEFT); ?></td>
          <td style="vertical-align: middle;"><?php echo $list->no_area; ?></td>
          <td style="vertical-align: middle;"><?php 
                if($this->session->userdata('almacen') == 1){
                  echo $list->encargado_sta_clara;  
                }else if($this->session->userdata('almacen') == 2){
                  echo $list->encargado;
                }
              ?></td>
          <td width="20" align="center"><img class="editar_area_encargado" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar Área" onClick="editar_area_encargado(<?php echo $list->id_area; ?>)" style="cursor: pointer;"/></td>
          <td width="20" align="center"><img class="delete_area_encargado" src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar área" onClick="delete_area_encargado(<?php echo $list->id_area; ?>)" style="cursor: pointer;"/></td>
        </tr>
        <?php
          $i++;
          } 
        ?>         
      </table>
      <?php }?>
    </div>
  </div>
  <div id="mdlEditarNombreMaquina"></div>
  <div id="finregistro"></div>
  <div id="modalerror"></div>
  <div style="display:none">
    <div id="direccionelim"><?php echo site_url('comercial/eliminararea');?></div>
  </div>
  <div id="dialog-confirm" style="display: none;" title="Eliminar Área">
    <p>
      <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
      ¿Está seguro que quiere eliminar esta Nombre de Máquina?<br /><strong>¡Esta acción no se puede revertir!</strong>
    </p>
  </div>

  <div id="mdlNuevaArea" style="display:none">
    <div id="contenedor" style="width:305px; height:120px;">
      <div id="tituloCont">Nueva Área</div>
      <div id="formFiltro" style="width:500px;">
        <?php
          $area = array('name'=>'area','id'=>'area','maxlength'=>'50', 'class'=>'required');
          $nombre_responsable = array('name'=>'nombre_responsable','id'=>'nombre_responsable','maxlength'=>'50', 'class'=>'required');
        ?>  
        <form method="post" id="nueva_maquina" style=" border-bottom:0px">
          <table style="width: 300px;">
            <tr>
              <td width="152" height="30" style="width: 150px;padding-bottom: 5px;">Área:</td>
              <td width="261" height="30"><?php echo form_input($area);?></td>
            </tr>
            <tr>
              <td width="152" height="30" style="width: 150px;padding-bottom: 5px;">Responsable:</td>
              <td width="261" height="30"><?php echo form_input($nombre_responsable);?></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>


