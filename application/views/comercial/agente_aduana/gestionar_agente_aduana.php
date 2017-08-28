<script type="text/javascript">
  $(function(){

    $('#listaAgenteAduana').DataTable();

    $(".newprospect").click(function(){
      $("#mdlNuevoAgente" ).dialog({
        modal: true,resizable: false,show: "blind",hide: "blind",position: 'center',width: 395,height: 230,draggable: false,closeOnEscape: false,
        buttons: {
        Registrar: function() {
            var agente_aduana = $('#agente_aduana').val();
            if(agente_aduana == ''){
              sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
            }else{
              var dataString = 'agente_aduana='+agente_aduana+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/save_agente_aduana/",
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    swal({
                    title: "El agente de aduana ha sido regristado con éxito!",
                    text: "",
                    type: "success",
                    confirmButtonText: "OK"
                    },function(isConfirm){
                      if (isConfirm) {
                        window.location.href="<?php echo base_url();?>comercial/gestionaduana";  
                      }
                    }
                  );
                  }else{
                    sweetAlert(msg, "", "error");
                  }
                }
              });
            }
          },
          Cancelar: function(){
            $("#mdlNuevoAgente").dialog("close");
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
                setTimeout('window.location.href="<?php echo base_url(); ?>comercial/gestionaduana"', 200);
        },
            'Cancelar': function () {
                  $(this).dialog('close');
            }
        }
    });
    // FIN DE ELIMINAR

    
  });

  // Editar Máquina
  function editar_agente(id_agente){
    var urlMaq = '<?php echo base_url();?>comercial/editaragente/'+id_agente;
    $("#mdlEditarAgenteAduana").load(urlMaq).dialog({
      modal: true, position: 'center', width: 430, height: 220, draggable: false, resizable: false, closeOnEscape: false,
      buttons: {
        Actualizar: function() {
          var editnombreagente = $('#editnombreagente').val(); 
          if(editnombreagente == ''){
            sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
          }else{
            var dataString = 'editnombreagente='+editnombreagente+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>comercial/actualizaragente/"+id_agente,
              data: dataString,
              success: function(msg){
                if(msg == 1){
                  swal({
                    title: "El agente de aduana ha sido actualizado con éxito!",
                    text: "",
                    type: "success",
                    confirmButtonText: "OK"
                    },function(isConfirm){
                      if (isConfirm) {
                        window.location.href="<?php echo base_url();?>comercial/gestionaduana";  
                      }
                    }
                  );
                }else{
                  sweetAlert(msg, "", "error");
                }
              }
            });
          }
        },
        Cancelar: function(){
          $("#mdlEditarAgenteAduana").dialog("close");
        }
      }
    });
  }

  function delete_agente_aduana(id_agente){
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
      var dataString = 'id_agente='+id_agente+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>comercial/eliminar_agente_aduana/",
        data: dataString,
        success: function(msg){
          if(msg == 'ok'){
            swal("Eliminado!", "El agente de aduana ha sido eliminado correctamente!", "success");
          }else if(msg == 'dont_delete'){
            sweetAlert("No se puede eliminar el agente de aduana", "Existen registro de facturas asociadas a este agente de aduana.", "error");
          }
        }
      });
    });
  } 

</script>

</head>
<body>
  <div id="contenedor">
    <div id="tituloCont">Datos del Agente Aduanero</div>
    <div id="formFiltro">
      <div id="options_productos">
        <div class="newprospect" style="width: 250px;">NUEVO AGENTE</div>
      </div>
      <?php 
        $existe = count($aduana);
        if($existe <= 0){
          echo 'No existen Agentes Aduaneros registrados en el Sistema.';
        }
        else
        {
      ?>
        <table border="0" cellspacing="0" cellpadding="0" id="listaAgenteAduana" style="float: left;width: 700px;" class="table table-hover table-striped">
          <thead>
            <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
              <td sort="idproducto" width="60" height="27">ID</td>
              <td sort="nombreprod" width="290">AGENTE DE ADUANA</td>
              <td width="20" style="background-image: none;">&nbsp;</td>
              <td width="20" style="background-image: none;">&nbsp;</td>
            </tr>
          </thead>
          <?php 
            $i = 1;
            foreach($aduana as $listaagenteaduana){ 
          ?>
          <tr class="contentTable" style="font-size: 12px;">
            <td height="27" style="vertical-align: middle;"><?php echo str_pad($i, 4, 0, STR_PAD_LEFT); ?></td>
            <td style="vertical-align: middle;"><?php echo $listaagenteaduana->no_agente; ?></td>
            <td width="20" align="center"><img class="editar_agente" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar Agente de Aduana" onClick="editar_agente(<?php echo $listaagenteaduana->id_agente; ?>)" style="cursor: pointer;"/></td>
            <td width="20" align="center"><img class="delete_agente_aduana" src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Agente de Aduana" onClick="delete_agente_aduana(<?php echo $listaagenteaduana->id_agente; ?>)" style="cursor: pointer;"/></td>
          </tr>
          <?php 
            $i++;
            } 
          ?>        
        </table>
        <?php 
          }
        ?>
    </div>
  </div>
  <div id="mdlEditarAgenteAduana"></div>
  <div id="modalerror"></div>
  <div id="finregistro"></div>
  <div id="errordatos"></div>
  <div style="display:none">
    <div id="direccionelim"><?php echo site_url('comercial/eliminaragente');?></div>
  </div>
  <div id="dialog-confirm" style="display: none;" title="Eliminar Nombre de Máquina">
    <p>
      <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
      ¿Está seguro que quiere eliminar el siguiente Agente Aduanero?<br /><strong>¡Esta acción no se puede revertir!</strong>
    </p>
  </div>

  <div id="mdlNuevoAgente" style="display:none">
    <div id="contenedor" style="width:345px; height:100px;">
      <div id="tituloCont">Nuevo Agente</div>
      <div id="formFiltro" style="width:500px;">
        <?php
          $agente_aduana = array('name'=>'agente_aduana','id'=>'agente_aduana','maxlength'=>'50', 'class'=>'required');
        ?>  
        <form method="post" id="nueva_maquina" style=" border-bottom:0px">
          <table style="width: 350px;">
            <tr>
              <td width="210" height="30" style="width: 210px;padding-bottom: 5px;">Agente de aduana:</td>
              <td width="261" height="30"><?php echo form_input($agente_aduana);?></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>