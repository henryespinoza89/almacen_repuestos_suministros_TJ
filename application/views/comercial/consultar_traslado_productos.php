<script type="text/javascript">
	$(function(){

    $("#exportar_traslados_excel").click(function(){
      var fechainicial = $("#fechainicial").val();
      var fechafinal = $("#fechafinal").val();
      if( fechainicial == '' || fechafinal == ''){
        sweetAlert("Falta completar campos obligatorios del formulario, por favor verifique!", "", "error");
      }else{
        var array_json = Array();
        array_json[0] = fechainicial;
        array_json[1] = fechafinal;
        var jObject = {};
        for(i in array_json){ 
          jObject[i] = array_json[i]; 
        }
        jObject= JSON.stringify(jObject);

        url = '<?php echo base_url(); ?>comercial/al_exportar_report_traslados/'+jObject;
        $(location).attr('href',url);
      }
    });
  
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

  $('#listar_traslados').DataTable();

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
      width: 420,
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
                $("#finregistro").html('<strong>!El Traslado ha sido eliminado correctamente!</strong>').dialog({
                  modal: true,position: 'center',width: 480,height: 125,resizable: false, title: '!Eliminación Conforme!',
                  buttons: { Ok: function(){
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
        },
        'Cancelar': function () {
          $(this).dialog('close');
        }
      }
    });
    /* Fin de Eliminar Salida */
	});

  //Fuera de $(function(){  });
  function resetear(){
      window.location.href="<?php echo base_url();?>comercial/gestionconsultarSalidaRegistros";
  }

</script>
</head>
<body>
  <div id="contenedor">
    <div id="tituloCont">Consultar Traslado de Productos</div>
    <div id="formFiltro">
      <form name="filtroBusqueda" action="#" method="post">
        <?php
          // para la fecha de inicio del periodo
          if ($this->input->post('fechainicial')){
            $fechainicial = array('name'=>'fechainicial','id'=>'fechainicial','maxlength'=>'10','value'=>$this->input->post('fechainicial'), 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
          }else{
            $fechainicial = array('name'=>'fechainicial','id'=>'fechainicial','maxlength'=>'10', 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
          }
          // para la fecha final del periodo
          if ($this->input->post('fechafinal')){
            $fechafinal = array('name'=>'fechafinal','id'=>'fechafinal','maxlength'=>'10','value'=>$this->input->post('fechafinal'), 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
          }else{
            $fechafinal = array('name'=>'fechafinal','id'=>'fechafinal','maxlength'=>'10', 'style'=>'width:100px','readonly'=> 'readonly', 'class'=>'required');
          }
        ?>
        <?php echo form_open(base_url()."comercial/consultar_traslado_productos", 'id="buscar"') ?>
          <div style="width: 580px;float: left;">
            <table width="800" border="0" cellspacing="0" cellpadding="0" style="float: left;margin-right: 300px;">
              <tr>
                <td width="90" style="height:30px;width: 90px;padding-bottom: 6px;">Fecha Inicial:</td>
                <td width="162"><?php echo form_input($fechainicial);?></td>
                <td width="90" style="height:30px;width: 90px;padding-bottom: 6px;">Fecha Final:</td>
                <td width="184"><?php echo form_input($fechafinal);?></td>
                <td>
                  <input name="submit" type="button" id="exportar_traslados_excel" value="EXPORTAR REPORTE DE TRASLADOS" style="padding-bottom:3px; padding-top:3px; margin-bottom: 9px; background-color: #FF5722; border-radius:6px; width: 215px;margin-right: 15px;" />
                </td>
              </tr>
            </table>
          </div>
        <?php echo form_close() ?>
      </form>
      <?php 
      $existe = count($trasladoproducto);
      if($existe <= 0){
        echo 'No existen Registros de Traslado en el Sistema.';
      }
      else
      {
      ?>
      <table border="0" cellspacing="0" cellpadding="0" id="listar_traslados" style="float: left;width:1050px;" class="table table-hover table-striped">
          <thead>
              <tr class="tituloTable" style="font-family: Helvetica Neu,Helvetica,Arial,sans-serif;font-size: 12px;height: 35px;">
                <td sort="idprod" width="75" height="27">ITEM</td>
                <td sort="nombreprod" width="120">Nº DE GUIA</td>
                <td sort="nombreprod" width="230">FECHA DE TRASLADO</td>
                <td sort="catprod" width="500">PRODUCTO O DESCRIPCION</td>
                <td sort="procprod" width="130">CANTIDAD</td>
                <!--<td width="20" style="background-image: none;">&nbsp;</td>-->
              </tr>
          </thead>
          <?php 
          $i = 1;
          foreach($trasladoproducto as $row){ ?>  
              <tr class="contentTable" style="font-size: 12px;">
                <td height="27" style="vertical-align: middle;"><?php echo str_pad($i, 3, 0, STR_PAD_LEFT); ?></td>
                <td style="vertical-align: middle;"><?php echo $row->id_traslado; ?></td>
                <td style="vertical-align: middle;"><?php echo $row->fecha_traslado; ?></td>
                <td style="vertical-align: middle;"><?php echo $row->no_producto; ?></td>
                <td style="vertical-align: middle;"><?php echo number_format($row->cantidad_traslado,2,'.',',');?></td>
                <!--
                <td width="20" style="vertical-align: middle;">
                  <a href="" class="eliminar_salida" id="elim_<?php echo $row->id_detalle_traslado; ?>">
                  <img src="<?php echo base_url();?>assets/img/trash.png" width="20" height="20" title="Eliminar Traslado"/></a>
                </td>
              </tr>
              -->
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
    <div id="direccionelim"><?php echo site_url('comercial/eliminartrasladoproducto');?></div>
  </div>
  <div id="dialog-confirm" style="display: none;" title="Eliminar Traslado">
    <p>
      <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
      ¿Está seguro que quiere eliminar el Traslado del producto?<br /><strong>¡Esta acción no se puede revertir!</strong>
    </p>
  </div>