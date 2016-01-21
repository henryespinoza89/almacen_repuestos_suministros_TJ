<script type="text/javascript">
  $(function(){

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
          //$(".ui-dialog-buttonpane button:contains('Ok')").attr("disabled", true).addClass("ui-state-disabled");
          var base_url = '<?php echo base_url();?>';
          /*
          var compra = $("#compra").val();
          var venta = $("#venta").val();
          */
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

    //Script para crear la tabla que será el contenedor de los productos registrados
    $('#listaProveedores').jTPS( {perPages:[10,20,30,50,'Todos'],scrollStep:1,scrollDelay:30,clickCallback:function () {     
            // target table selector
            var table = '#listaProveedores';
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
                                        $('#listaProveedores .sortableHeader:eq(' + parseInt(command[1]) + ')').click();
                                } else if (command[0] == 'sortdesc' && parseInt(command[1]) >= 0) {
                                        $('#listaProveedores .sortableHeader:eq(' + parseInt(command[1]) + ')').click().click();
                                } else if (command[0] == 'page' && parseInt(command[1]) >= 0) {
                                        $('#listaProveedores .pageSelector:eq(' + parseInt(command[1]) + ')').click();
                                }
                        }
                }
        }

        // bind mouseover for each tbody row and change cell (td) hover style
        $('#listaProveedores tbody tr:not(.stubCell)').bind('mouseover mouseout',
                function (e) {
                        // hilight the row
                        e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
                }
        );

    // Eliminar Proveedor
    $('a.eliminar_proveedor').bind('click', function () {
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
                  },
                  success: function(msg){
                    if(msg == 1){
                      $("#finregistro").html('<strong>!El Proveedor ha sido eliminado correctamente!</strong>').dialog({
                        modal: true,position: 'center',width: 350,height: 125,resizable: false, title: '!Eliminación Conforme!',hide: 'scale',show: 'scale',
                        buttons: { Ok: function(){
                          window.location.href="<?php echo base_url();?>comercial/gestionproveedores";
                        }}
                      });
                    }else{
                      $("#modalerror").empty().append(msg).dialog({
                        modal: true,position: 'center',width: 500,height: 150,resizable: false,title: '!No se puede eliminar el Proveedor!',hide: 'scale',show: 'scale',
                        buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");$( this ).dialog( "close" );}}
                      });
                      $(".ui-dialog-buttonpane button:contains('Registrar')").button("enable");
                    }
                      }
                });
                $(this).dialog('close');
                //setTimeout('window.location.href="<?php echo base_url(); ?>comercial/gestionproveedores"', 200);
        },
            'Cancelar': function () {
                  $(this).dialog('close');
            }
        }
    });
    // Fin de Eliminar
    $("#ruc_prov").validCampoFranz('0123456789');
    $(".downpdf_proveedor").click(function() {
      var url = '<?php echo base_url();?>comercial/reporteproveedorespdf';
      $(location).attr('href',url);  
    });
  });

  // Editar Proveedor
  function editar_proveedor(id_proveedor){
        var urlMaq = '<?php echo base_url();?>comercial/editarproveedor/'+id_proveedor;
        //alert(urlMaq);
        $("#mdlEditarProveedor").load(urlMaq).dialog({
          modal: true, position: 'center', width: 360, height: 585, draggable: false, resizable: false, closeOnEscape: false,
          buttons: {
            Actualizar: function() {
            $(".ui-dialog-buttonpane button:contains('Actualizar')").button("disable");
            $(".ui-dialog-buttonpane button:contains('Actualizar')").attr("disabled", true).addClass("ui-state-disabled");
            //CONTROLO LAS VARIABLES
            var edit_rz = $('#edit_rz').val(); edit_ruc = $('#edit_ruc').val(); edit_pais = $('#edit_pais').val(); edit_depa = $('#edit_depa').val(); 
            var edit_prov = $('#edit_prov').val(); edit_dist = $('#edit_dist').val(); edit_direc = $('#edit_direc').val();
            var edit_ref = $('#edit_ref').val(); edit_cont = $('#edit_cont').val(); edit_cargo = $('#edit_cargo').val();
            var edit_email = $('#edit_email').val(); edit_tel1 = $('#edit_tel1').val(); edit_tel2 = $('#edit_tel2').val();
            var edit_fax = $('#edit_fax').val(); edit_web = $('#edit_web').val();
            if(edit_rz == '' || edit_ruc == '' || edit_pais == '' || edit_direc == ''){
              $("#modalerror").html('<b>ERROR:</b> Falta completar los campos obligatorios del formulario, por favor verifique.').dialog({
                modal: true,position: 'center',width: 450, height: 150,resizable: false,
                buttons: { Ok: function() {$(".ui-dialog-buttonpane button:contains('Actualizar')").button("enable");$( this ).dialog( "close" );}}
              });
            }else{
              var dataString = 'edit_rz='+edit_rz+'&edit_ruc='+edit_ruc+'&edit_pais='+edit_pais+'&edit_depa='+edit_depa+'&edit_prov='+edit_prov+'&edit_web='+edit_web+'&edit_fax='+edit_fax+'&edit_tel2='+edit_tel2+'&edit_tel1='+edit_tel1+'&edit_email='+edit_email+'&edit_cargo='+edit_cargo+'&edit_cont='+edit_cont+'&edit_ref='+edit_ref+'&edit_pais='+edit_pais+'&edit_depa='+edit_depa+'&edit_direc='+edit_direc+'&edit_dist='+edit_dist+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>comercial/actualizarproveedor/"+id_proveedor,
                data: dataString,
                success: function(msg){
                  if(msg == 1){
                    $("#finregistro").html('!El Proveedor ha sido actualizado con éxito!.').dialog({
                      modal: true,position: 'center',width: 350,height: 125,resizable: false, title: 'Fin de Actualización',
                      buttons: { Ok: function(){
                        window.location.href="<?php echo base_url();?>comercial/gestionproveedores";
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
            $("#mdlEditarProveedor").dialog("close");
          }
                }
        });
      }

  function resetear(){
      window.location.href="<?php echo base_url();?>comercial/gestionproveedores";
  }

</script>
</head>
<body>
  <div id="contenedor">
    <?php if($tipocambio == 1){?>
      <div id="newtipocambio" title="Registrar Tipo de Cambio" style="font-size:11px;min-height:240px;">
        <?php echo form_open('/comercial/guardarTipoCambio',array('name'=>'tipodecambio')); ?>
          <?php
          /*
          $datacompra = array('name'=>'compra','id'=>'compra','maxlength'=>'5', 'size'=>'10');
          $dataventa = array('name'=>'venta','id'=>'venta','maxlength'=> '5', 'size'=>'10');
          */
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
              <td width="347" height="30"><a href="http://www.sbs.gob.pe/app/stats/tc-cv.asp" id="tipo_cambio" target="_blank">Superintendencia de Banca, Seguros y AFP</a></td>
            </tr>
          </table>
          <!--
          <fieldset style="border: 1px dashed #999999;width: 240px;float: left;margin-right: 15px;">
            <legend><strong>Tipo de Cambio en Soles</strong></legend>
            <table width="220" border="0" cellspacing="2" cellpadding="2" align="center">
              <tr>
                <td height="30">Valor de Compra:</td>
                <td height="30"><?php echo form_input($datacompra); ?></td>
              </tr>
              <tr>
                <td height="30">Valor de Venta:</td>
                <td height="30"><?php echo form_input($dataventa); ?></td>
              </tr>
            </table>
          </fieldset>
          -->
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
    <div id="tituloCont">Gestión de Proveedores</div>
    <div id="formFiltro">
      <div class="tituloFiltro">Búsqueda</div>
      <form name="filtroBusqueda" action="#" method="post">
        <?php
          // para el ID
          if ($this->input->post('ruc_prov')){
            $ruc_prov = array('name'=>'ruc_prov','id'=>'ruc_prov','maxlength'=>'11','value'=>$this->input->post('ruc_prov'));
          }else{
            $ruc_prov = array('name'=>'ruc_prov','id'=>'ruc_prov','maxlength'=>'11');
          }
          // para el NOMBRE Y APELLIDO
          if ($this->input->post('nombre')){
            $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=> '50','minlength'=>'1' , 'value' => $this->input->post('nombre'));
          }else{
            $nombre = array('name'=>'nombre','id'=>'nombre','maxlength'=> '50','minlength'=>'1');
          }
        ?>
        <?php echo form_open(base_url()."comercial/gestionproveedores", 'id="buscar"') ?>
          <table width="581" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="96">RUC:</td>
              <td width="222"><?php echo form_input($ruc_prov);?></td>
              <td width="263" style="padding-bottom:4px;">
                <input name="submit" type="submit" id="submit" value="Buscar"/>
                <input name="reset" type="button" onclick="resetear()" value="Reestablecer" />
              </td>
            </tr>
            <tr>
              <td>Proveedor:</td>
              <td><?php echo form_input($nombre);?></td>
            </tr>
          </table>
        <?php echo form_close() ?>
      </form>
      <div id="options">
        <div class="newprospect"><a href="<?php echo base_url();?>comercial/registrarproveedor">Nuevo Proveedor</a></div>
        <!--
        <?php
          //$existe = count($proveedor);
          //if($existe > 0){
        ?>
          <div class="downpdf_proveedor">Descargar en PDF</div>
        <?php //}?>
        <?php
          //$existe = count($proveedor);
          //if($existe > 0){
        ?>
          <div class="gestionreporteproveedor"><a href="<?php echo base_url(); ?>comercial/gestionreporteproveedor/">Gestionar Reporte de Proveedor</a></div>
        <?php //}?>
        -->
      </div>
      <!--Iniciar listar-->
        <?php 
          $existe = count($proveedor);
          if($existe <= 0){
            echo 'No existen Proveedores registrados en el Sistema.';
          }
          else
          {
        ?>

      <table style="width:1270px;" border="0" cellspacing="0" cellpadding="0" id="listaProveedores">
        <thead>
          <tr class="tituloTable">
            <td sort="idprov" width="85" height="25">Item</td>
            <td sort="rzprov" width="470">Razón Social</td>
            <td sort="rucprov" width="170">RUC</td>
            <td sort="paisprov" width="190">País</td>
            <td sort="contprov" width="460">Dirección</td>
            <td sort="telprov" width="120">Teléfono</td>
            <td sort="telprov" width="150">Fecha de Registro</td>
            <td width="20">&nbsp;</td>
            <td width="20">&nbsp;</td>
          </tr>
        </thead>
        <?php
          $i = 1;
          foreach($proveedor as $listaproveedores){ 
        ?>  
          <tr class="contentTable">
            <td style="height: 27px;"><?php echo str_pad($i, 5, 0, STR_PAD_LEFT); ?></td>
            <td><?php echo $listaproveedores->razon_social; ?></td>
            <td><?php echo $listaproveedores->ruc; ?></td>
            <td><?php echo $listaproveedores->pais; ?></td>
            <td><?php echo $listaproveedores->direccion; ?></td>
            <td><?php echo $listaproveedores->telefono1; ?></td>
            <td><?php echo $listaproveedores->fe_registro; ?></td>
            <td width="20" align="center"><img class="editar_proveedor" src="<?php echo base_url();?>assets/img/edit.png" width="20" height="20" title="Editar proveedor" onClick="editar_proveedor(<?php echo $listaproveedores->id_proveedor; ?>)" /></td>
            <td width="20" align="center">
              <a href="" class="eliminar_proveedor" id="elim_<?php echo $listaproveedores->id_proveedor; ?>">
              <img src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Proveedor"/></a>
            </td>
          </tr>
        <?php 
          $i++;
          } 
        ?>
        <tfoot class="nav">
                <tr>
                  <td colspan=9>
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
  <div id="mdlEditarProveedor"></div>
  <div id="modalerror"></div>
  <div id="finregistro"></div>
    <div style="display:none">
    <div id="direccionelim"><?php echo site_url('comercial/eliminarproveedor');?></div>
  </div>
  <div id="dialog-confirm" style="display: none;" title="Eliminar Proveedor">
    <p>
      <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
      ¿Está seguro que quiere eliminar este Proveedor?<br /><strong>¡Esta acción no se puede revertir!</strong>
    </p>
  </div>