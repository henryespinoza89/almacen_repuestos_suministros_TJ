<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comercial extends CI_Controller {

	/**
	* Index Page for this controller.
	*
	* Maps to the following URL
	* 		http://example.com/index.php/welcome
	*	- or -  
	* 		http://example.com/index.php/welcome/index
	*	- or -
	* Since this controller is set as the default controller in 
	* config/routes.php, it's displayed at http://example.com/
	*
	* So any other public methods not prefixed with an underscore will
	* map to /index.php/welcome/<method_name>
	* @see http://codeigniter.com/user_guide/general/urls.html
	*/

	public function __construct(){
		parent::__construct();	
		//Se controla la variable de Session
		$this->load->model('model_usuario');		
		$this->load->model('model_comercial');
		$this->load->library('session');
		$this->load->library('table');
		//$this->cart->validar_caracteres();
		$this->load->helper(array('form', 'url'));
		/*
		if($this->session->userdata('session') == 1 ){
			if (!($this->session->userdata('tipo') == 1)){redirect($this->session->userdata('ruta'));}
		}else{
			redirect('login');
		}
		*/			
	}

	public function index(){
		if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
		}else{
			$data['tipocambio'] = 1;
		}
		$data['listaarea']= $this->model_comercial->listarArea();
		$data['almacen']= $this->model_comercial->listarAlmacen();
		$data['producto']= $this->model_comercial->listarProducto();
		$data['liseditar_productotamaquina']= $this->model_comercial->listarMaquinas();
		$data['listacategoria'] = $this->model_comercial->listarCategoria();
		$data['listaprocedencia'] = $this->model_comercial->listarProcedencia();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/productos/registrar_producto',$data);
	}

	public function logout()
	{	
		$this->cart->destroy();
		//$this->session->unset_userdata('session');
		$this->session->sess_destroy();
		redirect('');
	}

	public function gestioninventario(){
		if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
		}else{
			$data['tipocambio'] = 1;
		}
		$this->load->view('comercial/menu_script');
		$this->load->view('comercial/menu_cabecera');
		$this->load->view('comercial/view_inventario');
	}

	public function save_categoria_producto(){
        $result = $this->model_comercial->save_categoria_producto();
        if(!$result){
            echo '!La categoría del producto ya se encuentra registrada. Verificar!';
        }else{
            echo '1';
        }
    }

    public function save_area_encargado(){
        $result = $this->model_comercial->save_area_encargado_model();
        if(!$result){
            echo '!El área ya se encuentra registrada. Verificar!';
        }else{
            echo '1';
        }
    }

    public function save_agente_aduana(){
        $result = $this->model_comercial->save_agente_aduana_model();
        if(!$result){
            echo '!El agente de aduana ya se encuentra registrado. Verificar!';
        }else{
            echo '1';
        }
    }

    public function update_categoria_producto(){
        $editcatprod = strtoupper($this->security->xss_clean($this->input->post('editcatprod')));
        // Creación del array con los datos del codigo del producto para insertarlo en la BD
        $actualizar_data = array('no_categoria' => $editcatprod,);
        $result = $this->model_comercial->update_categoria_producto($actualizar_data, $editcatprod);
        if(!$result){
            echo '!La categoría del producto ya se encuentra registrada. Verificar!';
        }else{
            echo '1';
        }
    }

    public function eliminar_categoria_producto(){
        $id_categoria = $this->security->xss_clean($this->input->post('id_categoria'));
        $result = $this->model_comercial->eliminar_categoria_producto($id_categoria);
        if(!$result){
            echo 'dont_delete';
        }else{
            echo 'ok';
        }
    }

    public function eliminar_area()
	{
		$idarea = $this->security->xss_clean($this->input->post('id_area'));
		$result = $this->model_comercial->eliminar_area_modal($idarea);
		if(!$result){
            echo 'dont_delete';
        }else{
            echo 'ok';
        }
	}

	public function eliminar_agente_aduana()
	{
		$id_agente = $this->security->xss_clean($this->input->post('id_agente'));
		$result = $this->model_comercial->eliminar_agente_aduana_modal($id_agente);
		if(!$result){
            echo 'dont_delete';
        }else{
            echo 'ok';
        }
	}

    public function save_tipo_producto(){
        $result = $this->model_comercial->save_tipo_producto();
        if(!$result){
            echo '!El Tipo de producto ya se encuentra registrado para esta Categoría. Verificar!';
        }else{
            echo '1';
        }
    }

    public function update_tipo_producto(){
        $edittipprod = strtoupper($this->security->xss_clean($this->input->post('edittipprod')));
        $editcateprod = strtoupper($this->security->xss_clean($this->input->post('editcateprod')));
        // Creación del array con los datos del codigo del producto para insertarlo en la BD
        $actualizar_data = array('no_tipo_producto' => $edittipprod,'id_categoria' => $editcateprod,);
        $result = $this->model_comercial->update_tipo_producto($actualizar_data, $edittipprod, $editcateprod);
        if(!$result){
            echo '!El Tipo de producto ya se encuentra registrado para esta Categoría. Verificar!';
        }else{
            echo '1';
        }
    }

    public function eliminar_tipo_producto(){
        $id_tipo_producto = $this->security->xss_clean($this->input->post('id_tipo_producto'));
        $result = $this->model_comercial->eliminar_tipo_producto($id_tipo_producto);
        if(!$result){
            echo 'dont_delete';
        }else{
            echo 'ok';
        }
    }

	public function gestioninventarioalmacen(){
		if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
		}else{
			$data['tipocambio'] = 1;
		}
		$data['listaarea']= $this->model_comercial->listarArea();
		$this->load->view('comercial/menu_script');
		$this->load->view('comercial/menu_cabecera');
		$this->load->view('comercial/inventario_almacen', $data);
	}

	public function guardar_informacion_productos(){
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$filename = $_FILES['file']['tmp_name'];
		if(($gestor = fopen($filename, "r")) !== FALSE){
			while (($datos = fgetcsv($gestor,1000,";")) !== FALSE){
				
				// Insert Tabla detalle_producto
				$nombre_producto = trim($datos[1]);
				$stock = trim($datos[3]);
				$precio_unitario = trim($datos[4]);
				// Array
				$a_data_detalle = array(
										'no_producto'=>utf8_decode($nombre_producto),
										'stock'=>utf8_decode($stock),
										'precio_unitario'=>utf8_decode($precio_unitario),
										);
				$id_insert_detalle = $this->model_comercial->save_detalle_producto($a_data_detalle);
				// Fin - insert

				// Insert Tabla Productos
				$id_producto = trim($datos[0]);
				$id_unidad_medida = trim($datos[2]);
				$id_procedencia = trim($datos[7]);
				$id_categoria = trim($datos[5]);
				$id_tipo_producto = trim($datos[6]);
				// Array
				$a_data_producto = array(
										'id_producto'=>trim($id_producto),
										'id_almacen'=>trim($id_almacen),
										'id_procedencia'=>trim($id_procedencia),
										'id_categoria'=>trim($id_categoria),
										'id_detalle_producto'=>trim($id_insert_detalle),
										'id_tipo_producto'=>trim($id_tipo_producto),
										'id_unidad_medida'=>trim($id_unidad_medida),
										);
				$this->model_comercial->save_producto($a_data_producto);
				// Fin - insert
			}	
		}
	}

	public function guardar_informacion_factura_importada(){
		$this->form_validation->set_rules('comprobante', 'Comprobante', 'trim|required|xss_clean');
		$this->form_validation->set_rules('numcomprobante', 'Nro. de Comprobante', 'trim|required|xss_clean');
		$this->form_validation->set_rules('seriecomprobante', 'Serie de Comprobante', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nombre_proveedor', 'Proveedor', 'trim|required|xss_clean');
		$this->form_validation->set_rules('fecharegistro', 'Fecha de Registro', 'trim|required|xss_clean');
		$this->form_validation->set_rules('moneda', 'Moneda', 'trim|required|xss_clean');
		$this->form_validation->set_rules('agente', 'Agente de Aduana', 'trim|required|xss_clean');
		if($this->input->post('comprobante') == 2){
			$this->form_validation->set_rules('total_factura_contabilidad', 'Agente de Aduana', 'trim|required|xss_clean');
		}
		/* Mensajes */
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		/* Delimitadores de ERROR: */
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');
		if($this->form_validation->run() == FALSE)
		{
			$nombre = $this->security->xss_clean($this->session->userdata('nombre'));
			$apellido = $this->security->xss_clean($this->session->userdata('apaterno'));
			if($nombre == "" AND $apellido == ""){
				$this->load->view('login');
			}else{
				if($this->input->post('comprobante') == "" AND $this->input->post('numcomprobante') == "" AND $this->input->post('seriecomprobante') == "" AND $this->input->post('fecharegistro') == "" AND $this->input->post('moneda') == "" AND $this->input->post('nombre_proveedor') == "" ){
					$data['respuesta_general'] = '<span style="color:red"><b>ERROR:</b> Falta completar los campos.</span>';
				}else if($this->input->post('comprobante') == ""){
					$data['respuesta_compro_seleccion'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo N° de Comprobante.</span>';
				}else if($this->input->post('numcomprobante') == ""){
					$data['respuesta_compro'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo N° de Comprobante.</span>';
				}else if($this->input->post('seriecomprobante') == ""){
					$data['respuesta_serie'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo N° de Comprobante.</span>';
				}else if($this->input->post('nombre_proveedor') == ""){
					$data['respuesta_prov'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Proveedor.</span>';
				}else if($this->input->post('fecharegistro') == ""){
					$data['respuesta_fe'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Fecha de Registro.</span>';
				}else if($this->input->post('moneda') == ""){
					$data['respuesta_moneda'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Moneda.</span>';
				}else if($this->input->post('agente') == ""){
					$data['respuesta_agente'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Agente.</span>';
				}else if($this->input->post('comprobante') == 2 AND $this->input->post('total_factura_contabilidad') == ""){
					$data['respuesta_total_factura'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Total Factura.</span>';
				}
				$data['listaagente']= $this->model_comercial->listaAgenteAduana();
				$data['listaproveedor']= $this->model_comercial->listaProveedor();
				$data['listasimmon']= $this->model_comercial->listaSimMon();
				$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
				$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
				$this->load->view('comercial/menu_script');
				$this->load->view('comercial/menu_cabecera');
				$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
			}
		}else{
			/* Inicio del proceso - transacción */
			$this->db->trans_begin();

			$i = 1;
			$cont_area = 1;
			$y = 0;
			$suma_parciales_factura = 0;
			$indicador = TRUE;
			$indicador_area = TRUE;
			/* Obtengo las variables generales de la factura */
			$id_comprobante = $this->security->xss_clean($this->input->post('comprobante'));
			$seriecomprobante = $this->security->xss_clean($this->input->post('seriecomprobante'));
			$numcomprobante = $this->security->xss_clean($this->input->post('numcomprobante'));
			$id_moneda = $this->security->xss_clean($this->input->post('moneda'));
			$nombre_proveedor = $this->security->xss_clean($this->input->post("nombre_proveedor"));
			$fecharegistro = $this->security->xss_clean($this->input->post('fecharegistro'));
			$id_agente = $this->security->xss_clean($this->input->post('agente'));
			$total_factura_contabilidad = $this->security->xss_clean($this->input->post('total_factura_contabilidad'));
			$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
			if($total_factura_contabilidad == ""){
				$total_factura_contabilidad = 0;
			}
			/* Obtener el id del proveedor */
			$this->db->select('id_proveedor');
			$this->db->where('razon_social',$nombre_proveedor);
			$query = $this->db->get('proveedor');
			foreach($query->result() as $row){
			    $id_proveedor = $row->id_proveedor;
			}

			// validacion de contenido
			/* Validar si existe un error en los productos a registrar */
			$filename = $_FILES['file']['tmp_name'];
			if(($gestor = fopen($filename, "r")) !== FALSE){
				while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
					// Obtener los valores de la hoja de excel
					$codigo_producto = trim($datos[0]);
					$cantidad_ingreso = trim($datos[1]);
					$precio_ingreso = trim($datos[2]);
					/* ------------------------------------------ */
					$this->db->select('id_detalle_producto');
		            $this->db->where('id_producto',$codigo_producto);
		            $query = $this->db->get('producto');
		            if($query->num_rows() > 0){
		            	$i = $i + 1;
		            }else{
		            	$indicador = FALSE;
		            	$data['respuesta_validacion_facturas_importadas'] = $i;
						$data['listaagente']= $this->model_comercial->listaAgenteAduana();
						$data['listaproveedor']= $this->model_comercial->listaProveedor();
						$data['listasimmon']= $this->model_comercial->listaSimMon();
						$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
						$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
						$this->load->view('comercial/menu_script');
						$this->load->view('comercial/menu_cabecera');
						$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
						break;
		            }
				}
			}else{
				echo "No se cargo el archivo CSV";
				die();
			}

			
			if($indicador == TRUE){
				// Validar si existe un error en AREAS asignadas a cada producto
				$filename = $_FILES['file']['tmp_name'];
				if(($gestor = fopen($filename, "r")) !== FALSE){
					while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
						// Obtener los valores de la hoja de excel
						$codigo_producto = trim($datos[0]);
						$cantidad_ingreso = trim($datos[1]);
						$precio_ingreso = trim($datos[2]);
						$nombre_area = trim($datos[3]);
						// ------------------------------------------
						$this->db->select('id_area');
			            $this->db->where('no_area',$nombre_area);
			            $query = $this->db->get('area');
			            if($query->num_rows() > 0){
			            	$cont_area = $cont_area + 1;
			            }else{
			            	$indicador_area = FALSE;
			            	$data['respuesta_validacion_areas_productos_importadas'] = $cont_area;
							$data['listaagente']= $this->model_comercial->listaAgenteAduana();
							$data['listaproveedor']= $this->model_comercial->listaProveedor();
							$data['listasimmon']= $this->model_comercial->listaSimMon();
							$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
							$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
							$this->load->view('comercial/menu_script');
							$this->load->view('comercial/menu_cabecera');
							$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
							break;
			            }
					}
				}else{
					echo "No se cargo el archivo CSV";
					die();
				}
			}
			

			if( $indicador == TRUE && $indicador_area == TRUE ){
				//if( $indicador == TRUE ){
				/* Guardo los datos generales de la factura o verifico que ya existe por medio de una guia de remision para obtener el id_ingreso_producto*/
				/* Agregamos el registro_ingreso a la bd */
				$datos = array(
					"id_comprobante" => $id_comprobante,
					"serie_comprobante" => $seriecomprobante,
					"nro_comprobante" => $numcomprobante,
					"fecha" => $fecharegistro,
					"id_moneda" => $id_moneda,
					"id_proveedor" => $id_proveedor,
					"total" => $total_factura_contabilidad,
					"id_almacen" => $almacen,
					"cs_igv" => "FALSE",
					"id_agente" => $id_agente
				);
				$id_ingreso_producto = $this->model_comercial->agrega_ingreso($datos, $seriecomprobante, $numcomprobante, $id_proveedor, $fecharegistro);

				if($id_ingreso_producto == FALSE){
		            $data['validacion_no_existe_tipo_cambio'] = '<span style="color:red"><b>ERROR:</b> no_se_encontro_factura_importada </span>';
					$data['listaagente']= $this->model_comercial->listaAgenteAduana();
					$data['listaproveedor']= $this->model_comercial->listaProveedor();
					$data['listasimmon']= $this->model_comercial->listaSimMon();
					$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
					$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
					$this->load->view('comercial/menu_script');
					$this->load->view('comercial/menu_cabecera');
					$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
		        }else if($id_ingreso_producto == 'actualizacion_registro'){
		            // var_dump('actualizacion_registro');
		            $filename = $_FILES['file']['tmp_name'];
		            // Sumo el sub-total de la factura, sin considerar los gastos de importacion
					if(($gestor = fopen($filename, "r")) !== FALSE){
						while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
							$codigo_producto = trim($datos[0]);
							$cantidad_ingreso = trim($datos[1]);
							$precio_ingreso = trim($datos[2]);
							$suma_parciales_factura = $suma_parciales_factura + ($cantidad_ingreso * $precio_ingreso);
						}
					}else{
						echo "No se cargo el archivo CSV";
						die();
					}

					if(($gestor = fopen($filename, "r")) !== FALSE){
						while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
							// Obtener los valores de la hoja de excel
							$codigo_producto = trim($datos[0]);
							$cantidad_ingreso = trim($datos[1]);
							$precio_ingreso = trim($datos[2]);
							// ------------------------------------------
							$this->db->select('id_detalle_producto');
				            $this->db->where('id_producto',$codigo_producto);
				            $query = $this->db->get('producto');
				            foreach($query->result() as $row){
				                $id_detalle_producto = $row->id_detalle_producto;
				            }
							$id_insert = $this->model_comercial->actualizar_detalle_kardex_importado($id_proveedor,$id_comprobante,$suma_parciales_factura,$id_detalle_producto,$cantidad_ingreso,$precio_ingreso,$fecharegistro,$seriecomprobante,$numcomprobante,$total_factura_contabilidad,$almacen);
							if($id_insert == true){
								$y = $y + 1;
							}else if($id_insert == 'no_se_encontro_factura_importada'){
				            	$data['respuesta_validacion_actualizacion_importadas'] = '<span style="color:red"><b>ERROR:</b> no_se_encontro_factura_importada </span>';
								$data['listaagente']= $this->model_comercial->listaAgenteAduana();
								$data['listaproveedor']= $this->model_comercial->listaProveedor();
								$data['listasimmon']= $this->model_comercial->listaSimMon();
								$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
								$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
								$this->load->view('comercial/menu_script');
								$this->load->view('comercial/menu_cabecera');
								$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
								break;
							}
							// Limpio la variable porque si no encuentra uno de los id que busco, se queda con el ultimo que encontro y lo registra
							$id_detalle_producto = "";
						}
					}else{
						echo "No se cargo el archivo CSV";
						die();
					}

					if($y != 0){
						$data['respuesta_registro_satisfactorio'] = $y;
						$data['listaagente']= $this->model_comercial->listaAgenteAduana();
						$data['listaproveedor']= $this->model_comercial->listaProveedor();
						$data['listasimmon']= $this->model_comercial->listaSimMon();
						$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
						$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
						$this->load->view('comercial/menu_script');
						$this->load->view('comercial/menu_cabecera');
						$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
					}
		        }else{
		        	if($id_comprobante == 4){
			        	$filename = $_FILES['file']['tmp_name'];
						if(($gestor = fopen($filename, "r")) !== FALSE){
							while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
								$codigo_producto = trim($datos[0]);
								$cantidad_ingreso = trim($datos[1]);
								$precio_ingreso = trim($datos[2]);
								$suma_parciales_factura = 0;
							}
						}else{
							echo "No se cargo el archivo CSV";
							die();
						}

						if(($gestor = fopen($filename, "r")) !== FALSE){
							while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
								// Obtener los valores de la hoja de excel
								$codigo_producto = trim($datos[0]);
								$cantidad_ingreso = trim($datos[1]);
								$precio_ingreso = trim($datos[2]);
								$nombre_area = trim($datos[3]);
								/* ------------------------------------------ */
								$this->db->select('id_detalle_producto,id_pro');
					            $this->db->where('id_producto',$codigo_producto);
					            $query = $this->db->get('producto');
					            foreach($query->result() as $row){
					                $id_detalle_producto = $row->id_detalle_producto;
					                $id_pro = $row->id_pro;
					            }
					            // obtener el id_area
					            $this->db->select('id_area');
					            $this->db->where('no_area',$nombre_area);
					            $query = $this->db->get('area');
					            foreach($query->result() as $row){
					                $id_area = $row->id_area;
					            }
					            //
								$a_data = array(
												'unidades'=>$cantidad_ingreso,
												'id_detalle_producto'=>$id_detalle_producto,
												'precio'=>$precio_ingreso,
												'id_ingreso_producto'=>$id_ingreso_producto,
												'unidades_referencial'=>$cantidad_ingreso,
												'id_area'=>$id_area,
												);
								$id_insert = $this->model_comercial->inserta_factura_masiva($nombre_area,$id_comprobante,$suma_parciales_factura,$a_data,$id_detalle_producto,$cantidad_ingreso,$precio_ingreso,$fecharegistro,$seriecomprobante,$numcomprobante,0,$almacen);
								if($id_insert == true){
									$y = $y + 1;
								}
								/* Limpio la variable porque si no encuentra uno de los id que busco, se queda con el ultimo que encontro y lo registra */
								$id_detalle_producto = "";
							}
						}else{
							echo "No se cargo el archivo CSV";
							die();
						}

						if($y != 0){
							$data['respuesta_registro_satisfactorio'] = $y;
							$data['listaagente']= $this->model_comercial->listaAgenteAduana();
							$data['listaproveedor']= $this->model_comercial->listaProveedor();
							$data['listasimmon']= $this->model_comercial->listaSimMon();
							$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
							$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
							$this->load->view('comercial/menu_script');
							$this->load->view('comercial/menu_cabecera');
							$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
						}
		        	}else if($id_comprobante == 2){
			        	$filename = $_FILES['file']['tmp_name'];
						if(($gestor = fopen($filename, "r")) !== FALSE){
							while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
								$codigo_producto = trim($datos[0]);
								$cantidad_ingreso = trim($datos[1]);
								$precio_ingreso = trim($datos[2]);

								$suma_parciales_factura = $suma_parciales_factura + ($cantidad_ingreso * $precio_ingreso);
							}
						}else{
							echo "No se cargo el archivo CSV";
							die();
						}

						if(($gestor = fopen($filename, "r")) !== FALSE){
							while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
								// Obtener los valores de la hoja de excel
								$codigo_producto = trim($datos[0]);
								$cantidad_ingreso = trim($datos[1]);
								$precio_ingreso = trim($datos[2]);
								$nombre_area = trim($datos[3]);
								// Obtener los ID
								$this->db->select('id_detalle_producto,id_pro');
					            $this->db->where('id_producto',$codigo_producto);
					            $query = $this->db->get('producto');
					            foreach($query->result() as $row){
					                $id_detalle_producto = $row->id_detalle_producto;
					                $id_pro = $row->id_pro;
					            }
					            // obtener el id_area
					            $this->db->select('id_area');
					            $this->db->where('no_area',$nombre_area);
					            $query = $this->db->get('area');
					            foreach($query->result() as $row){
					                $id_area = $row->id_area;
					            }
					            // ------------------------------------------
								$a_data = array(
												'unidades'=>$cantidad_ingreso,
												'id_detalle_producto'=>$id_detalle_producto,
												'precio'=>$precio_ingreso,
												'id_ingreso_producto'=>$id_ingreso_producto,
												'unidades_referencial'=>$cantidad_ingreso,
												'id_area'=>$id_area,
												);
								$id_insert = $this->model_comercial->inserta_factura_masiva($nombre_area,$id_comprobante,$suma_parciales_factura,$a_data,$id_detalle_producto,$cantidad_ingreso,$precio_ingreso,$fecharegistro,$seriecomprobante,$numcomprobante,$total_factura_contabilidad,$almacen);
								if($id_insert == true){
									$y = $y + 1;
								}
								// Limpio la variable porque si no encuentra uno de los id que busco, se queda con el ultimo que encontro y lo registra
								$id_detalle_producto = "";
							}
						}else{
							echo "No se cargo el archivo CSV";
							die();
						}
						
						if($y != 0){
							$data['respuesta_registro_satisfactorio'] = $y;
							$data['listaagente']= $this->model_comercial->listaAgenteAduana();
							$data['listaproveedor']= $this->model_comercial->listaProveedor();
							$data['listasimmon']= $this->model_comercial->listaSimMon();
							$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
							$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
							$this->load->view('comercial/menu_script');
							$this->load->view('comercial/menu_cabecera');
							$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
						}
		        	}
		        }
			}

			/* Fin del proceso - transacción */
        	$this->db->trans_complete();
		}
	}

	public function test_factura_importada(){
		print_r("entro al test");
		$i = 0;
		$suma_parciales_factura = 0;
		/* Obtengo las variables generales de la factura */

		$id_comprobante = $this->security->xss_clean($this->input->post('id_comprobante'));
		/*
		$seriecomprobante = $this->security->xss_clean($this->input->post('seriecomprobante'));
		$numcomprobante = $this->security->xss_clean($this->input->post('numcomprobante'));
		$id_moneda = $this->security->xss_clean($this->input->post('moneda'));
		$id_proveedor = $this->security->xss_clean($this->input->post('proveedor'));
		$fecharegistro = $this->security->xss_clean($this->input->post('fecharegistro'));
		$id_agente = $this->security->xss_clean($this->input->post('agente'));
		$total_factura_contabilidad = $this->security->xss_clean($this->input->post('total_factura_contabilidad'));
		*/
		$file = $this->security->xss_clean($this->input->post('documento_file'));
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));



		$filename = $_FILES[$file]['tmp_name'];
		if(($gestor = fopen($filename, "r")) !== FALSE){
			while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
				// Obtener los valores de la hoja de excel
				$codigo_producto = trim($datos[0]);
				$cantidad_ingreso = trim($datos[1]);
				$precio_ingreso = trim($datos[2]);
				$suma_parciales_factura = $suma_parciales_factura + ($cantidad_ingreso * $precio_ingreso);
			}
		}

		print_r("Se registro satisfactoriamente: ".$suma_parciales_factura." registros".$id_comprobante);
	}

	public function gestioncategoriaproductos(){
		$data['categoriaproducto']= $this->model_comercial->listarCategoriaProductos();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/productos/categoria_producto', $data);
	}

	public function gestionfacturasmasivas(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre'));
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno'));
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			$data['listaagente']= $this->model_comercial->listaAgenteAduana();
			$data['listaproveedor']= $this->model_comercial->listaProveedor();
			$data['listasimmon']= $this->model_comercial->listaSimMon();
			$data['listacomprobante']= $this->model_comercial->listaComprobante_importado();
			$data['factura_import']= $this->model_comercial->get_facturas_importadas_pendientes();
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/comprobantes/facturas_opcion_masiva', $data);
		}
	}

	public function obtener_datos_importacion(){
        $id_ingreso_producto = $this->input->post('id_ingreso_producto');
        $resultado = $this->model_comercial->get_datos_detalle_pedido($id_ingreso_producto);
        if (count($resultado) > 0){
            foreach ($resultado as $data) {
                $array = array(
                    "id_comprobante" => $data['id_comprobante'],
                    "nro_comprobante" => $data['nro_comprobante'],
                    "serie_comprobante" => $data['serie_comprobante'],
                    "id_moneda" => $data['id_moneda'],
                    "razon_social" => $data['razon_social'],
                    "fecha" => $data['fecha'],
                    "id_agente" => $data['id_agente'],
                    "id_ingreso_producto" => $data['id_ingreso_producto'],
                );
            }
            echo '' . json_encode($array) . '';
        }else{
            echo 'vacio';
        }
    }

	public function registrarcategoriaproducto()
	{
		$this->form_validation->set_rules('nombre', 'Nombre de la Categoría del Producto', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 30 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
        	$data['categoriaproducto']= $this->model_comercial->listarCategoriaProductos();
			$this->load->view('comercial/menu');
	    	$this->load->view('comercial/productos/categoria_producto', $data);
		}
		else
		{
	        $result = $this->model_comercial->saveCetegoriaProducto();
	        // Verificamos que existan resultados
	        if(!$result){
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Esta Categoría de Producto ya se encuentra registrado.</span>';
	        	$data['categoriaproducto']= $this->model_comercial->listarCategoriaProductos();
				$this->load->view('comercial/menu');
		    	$this->load->view('comercial/productos/categoria_producto', $data);
	        }else{
	        	redirect('comercial/gestioncategoriaproductos');
	        }
		}
	}

	public function editarcategoriaproducto(){
		$data['datoscatprod']= $this->model_comercial->getCatProdEditar();
		$this->load->view('comercial/productos/actualizar_categoria_producto', $data);
	}

	public function actualizarcategoriaproducto()
	{
		$this->form_validation->set_rules('editcatprod', 'Categoría de Producto', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaCategoriaProducto();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Esta Categoría de Producto ya se encuentra registrada.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function eliminarcategoriaproducto()
	{
		$idcategoriaproducto = $this->input->get('eliminar');
		$this->model_comercial->eliminarCategoriaProducto($idcategoriaproducto);
	}

	public function registrartipoproducto()
	{
		$this->form_validation->set_rules('categoria', 'Seleccione Categoría', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nombre', 'Tipo de Producto', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 30 dígitos como máximo.');
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
        	$data['listacategoriaproducto']= $this->model_comercial->listarCategoriaProdCombo();
			$data['listatipoproducto']= $this->model_comercial->listarTipoProd();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/productos/tipo_producto', $data);
		}
		else
		{
	        $result = $this->model_comercial->saveTipoProducto();	        
	        if(!$result){
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Este Tipo de Producto ya se encuentra registrada.</span>';
	        	$data['listacategoriaproducto']= $this->model_comercial->listarCategoriaProdCombo();
				$data['listatipoproducto']= $this->model_comercial->listarTipoProd();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/productos/tipo_producto', $data);
	        }else{
	        	redirect('comercial/gestiontipoproductos');
	        
	        }
		}
	}

	public function gestiontipoproductos(){
		$data['listacategoriaproducto']= $this->model_comercial->listarCategoriaProdCombo();
		$data['listatipoproducto']= $this->model_comercial->listarTipoProd();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/productos/tipo_producto', $data);
	}

	public function editartipoproducto(){
		$data['listacategoriaproducto']= $this->model_comercial->listarCategoriaProdCombo();
		$data['datostipprod']= $this->model_comercial->getTipoProdEditar();
		$this->load->view('comercial/productos/actualizar_tipo_producto', $data);
	}

	public function actualizartipoproducto()
	{
		$this->form_validation->set_rules('editcateprod', 'Categoría de Producto', 'trim|required|xss_clean');
		$this->form_validation->set_rules('edittipprod', 'Tipo de Producto', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaTipoProducto();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Este Tipo asociado a esta Categoría de Producto ya existe.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function eliminartipoproducto()
	{
		$id_tipo_producto = $this->input->get('eliminar');
		$this->model_comercial->eliminarTipoProducto($id_tipo_producto);
	}

	public function traeTipo()
	{
        $tipo = $this->model_comercial->getTipo();
        echo '<option value=""> :: SELECCIONE ::</option>';
        foreach($tipo as $fila)
        {
        	echo '<option value="'.$fila->id_tipo_producto.'">'.$fila->no_tipo_producto.'</option>';
	    }
	}

	public function gestionproductos(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
				$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['listaarea']= $this->model_comercial->listarArea();
			$data['almacen']= $this->model_comercial->listarAlmacen();
			$data['producto']= $this->model_comercial->listarProducto();
			$data['listamaquina']= $this->model_comercial->listarMaquinas();
			$data['listacategoria'] = $this->model_comercial->listarCategoria();
			$data['listaprocedencia'] = $this->model_comercial->listarProcedencia();
			/*$this->load->view('comercial/menu');*/
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/productos/registrar_producto',$data);
		}
	}

	public function traer_unidad_medida_autocomplete() {
		$termino = strtoupper($this->input->post('q'));
        $resultado = $this->model_comercial->get_unidad_medida_autocomplete($termino);

        $array = array("label" => "No se encontraron resultados");

        if ($resultado != null) {

            $data = array();

            foreach ($resultado as $datos) {
                $array = array(
                    "label" => $datos['nom_uni_med'],
                    "nom_uni_med" => $datos['nom_uni_med']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

	public function gestionproveedores(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
				$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['proveedor']= $this->model_comercial->listarProveedores();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/proveedores/gestionar_proveedores',$data);
		}
	}

	public function gestionsalida(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
				$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['listaarea']= $this->model_comercial->listarArea();
			$data['listamaquina']= $this->model_comercial->listarMaquinas();
			$data['salidaproducto']= $this->model_comercial->listaSalidaProducto_2013();
			$data['areas_salidas']= $this->model_comercial->listar_areas_salidas();
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/salida_almacen/registro_salida', $data);
		}
	}

	public function gestiontipocambio(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
				$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['tipoCambio']= $this->model_comercial->listarTipoCambio();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/tipo_cambio/tipo_cambio', $data);
		}
	}

	public function gestioningreso(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['listaarea']= $this->model_comercial->listarArea();
			$data['listaagente']= $this->model_comercial->listaAgenteAduana();
			$data['listacomprobante']= $this->model_comercial->listaComprobante();
			$data['listaproveedor']= $this->model_comercial->listaProveedor();
			$data['listasimmon']= $this->model_comercial->listaSimMon();
			$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/comprobantes/registro_ingreso', $data);
		}
	}

	public function gestioncuadreinventario(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['listaarea']= $this->model_comercial->listarArea();
			$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/view_cuadre_inventario', $data);
		}
	}
	
	public function gestionreportkardexproducto(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/view_kardex_producto');
		}
	}

	public function gestionreportsunat(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/view_kardex_sunat');
		}
	}

	public function gestionreportentrada(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/view_report_entrada');
		}
	}

	public function gestionreportmensual(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/view_report_mensual');
		}
	}

	public function gestionreportsalida(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/view_report_salida');
		}
	}

	public function gestionreportkardexgeneral(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['indice']= $this->model_comercial->ComboIndice();
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/view_kardex_general',$data);
		}
	}

	public function traer_producto_autocomplete_traslado() {
		
		$termino = strtoupper($this->input->post('q'));
		$id_area = strtoupper($this->input->post('a'));
        $resultado = $this->model_comercial->get_nombre_producto_autocomplete_traslado($termino, $id_area);

        $array = array( "label" => "no se encontraron resultados" );

        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $producto) {
                $array = array(
                    "label" => $producto['no_producto'],
                    "nombre_producto" => $producto['no_producto'],
                    "id_detalle_producto" => $producto['id_detalle_producto'],
                    "stock_sta_anita" => $producto['stock_area_sta_anita'],
                    "stock_sta_clara" => $producto['stock_area_sta_clara'],
                    "column_temp" => $producto['column_temp']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

	public function traer_producto_autocomplete() {
		$termino = strtoupper($this->input->post('q'));
		$id_area = strtoupper($this->input->post('a'));
        $resultado = $this->model_comercial->get_nombre_producto_autocomplete_area($termino, $id_area);

        $array = array( "label" => "no se encontraron resultados" );

        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $producto) {
                $array = array(
                    "label" => $producto['no_producto'],
                    "nombre_producto" => $producto['no_producto']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

    public function traer_producto_autocomplete_agregar_area() {
		$termino = strtoupper($this->input->post('q'));
        $resultado = $this->model_comercial->get_nombre_producto_autocomplete_agregar_area($termino);

        $array = array( "label" => "no se encontraron resultados" );

        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $producto) {
                $array = array(
                    "label" => $producto['no_producto'],
                    "nombre_producto" => $producto['no_producto']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

    public function traer_producto_autocomplete_consultar_salidas() {
		$termino = strtoupper($this->input->post('q'));
        $resultado = $this->model_comercial->get_nombre_producto_autocomplete_consultar_salidas($termino);

        $array = array( "label" => "no se encontraron resultados" );

        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $producto) {
                $array = array(
                    "label" => $producto['no_producto'],
                    "nombre_producto" => $producto['no_producto']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

    public function traer_proveedor_autocomplete() {
		
		$termino = strtoupper($this->input->post('q'));
        $resultado = $this->model_comercial->get_nombre_proveedor_autocomplete($termino);

        $array = array( "label" => "no se encontraron resultados" );

        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $proveedor) {
                $array = array(
                    "label" => $proveedor['razon_social'],
                    "razon_social" => $proveedor['razon_social']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

    public function traer_producto_autocomplete_salida() {
		
		$termino = strtoupper($this->input->post('q'));
		$id_area = strtoupper($this->input->post('a'));
        $resultado = $this->model_comercial->get_nombre_producto_autocomplete_salida($termino, $id_area);

        $array = array( "label" => "no se encontraron resultados" );

        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $producto) {
                $array = array(
                    "label" => $producto['no_producto'],
                    "nombre_producto" => $producto['no_producto'],
                    "id_detalle_producto" => $producto['id_detalle_producto'],
                    "column_temp" => $producto['column_temp']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

    public function traer_solicitante_autocomplete() {
		
		$termino = strtoupper($this->input->post('q'));
        $resultado = $this->model_comercial->get_nombre_solicitante_autocomplete_salida($termino);
        $array = array( "label" => "no se encontraron resultados" );
        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $producto) {
                $array = array(
                    "label" => $producto['solicitante'],
                    "nombre_solicitante" => $producto['solicitante']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

    public function traer_producto_autocomplete_with_id() {
		
		$termino = strtoupper($this->input->post('q'));
        $resultado = $this->model_comercial->get_nombre_producto_autocomplete_with_id($termino);

        $array = array( "label" => "no se encontraron resultados" );

        if ($resultado != null) {
            $data = array();
            foreach ($resultado as $producto) {
                $array = array(
                    "label" => $producto['no_producto'],
                    "nombre_producto" => $producto['no_producto'],
                    "id_detalle_producto" => $producto['id_detalle_producto']
                );
                array_push($data, $array);
            }
        }
        print(json_encode($data));
    }

    public function traerUnidadMedida_Autocompletado()
	{
		$nombre_producto = $this->input->get('nombre_producto');
        $variable = $this->model_comercial->getDataUnidadMedida($nombre_producto);
        foreach($variable as $fila){
        	echo $fila->nom_uni_med;
	    }
	}

	public function buscar_nombre_producto_autocompletar(){
		$nombre_producto = $this->model_comercial->getNombreProducto_autocompletar();
	    if( $nombre_producto != ""){
		    foreach($nombre_producto as $dato){
		    	echo "<li>".$dato->no_producto."</li>";
		    }
	    }
	}

	public function traerStock_Autocompletado()
	{
		$nombre_producto = $this->input->get('nombre_producto');
		$id_area = $this->input->get('id_area');
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		if($id_almacen == 1){
			$variable = $this->model_comercial->getDataStock($nombre_producto, $id_area);
	        foreach($variable as $fila){
	        	echo $fila->stock_area_sta_clara;
		    }
		}else if($id_almacen == 2){
	        $variable = $this->model_comercial->getDataStock($nombre_producto, $id_area);
	        foreach($variable as $fila){
	        	echo $fila->stock_area_sta_anita;
		    }
		}
	}

	public function traer_stock_general_cuadre()
	{
		$nombre_producto = $this->input->get('nombre_producto');
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$variable = $this->model_comercial->getDataStock_general_cuadre($nombre_producto);
		if($id_almacen == 1){
	        foreach($variable as $fila){
	        	echo $fila->stock_sta_clara;
		    }
		}else if($id_almacen == 2){
	        foreach($variable as $fila){
	        	echo $fila->stock;
		    }
		}
	}
	
	public function gestionreporteproducto(){
		$data['listaprocedencia'] = $this->model_comercial->listarProcedencia();
		$data['listasimmon']= $this->model_comercial->listaSimMon();
		$data['listacategoria'] = $this->model_comercial->listarCategoria();
		$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestion_reporte_producto',$data);
	}

	public function gestionreporteingreso(){
		$data['listaagente']= $this->model_comercial->listaAgenteAduana();
		$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
		$data['listaproveedor']= $this->model_comercial->listaProveedor();
		$data['listasimmon']= $this->model_comercial->listaSimMon();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestion_reporte_ingreso',$data);
	}

	public function gestionreporteingreso_otros(){
		$data['listacomprobante']= $this->model_comercial->listarComprobantes();
		$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
		$data['listaproveedor']= $this->model_comercial->listaProveedor();
		$data['listasimmon']= $this->model_comercial->listaSimMon();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestion_reporte_ingreso_otros',$data);
	}

	public function gestionreportesalida(){
		$data['listaarea']= $this->model_comercial->listarArea();
		$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestion_reporte_salida',$data);
	}
	
	public function gestionreportemaquina(){
		$data['estado']= $this->model_comercial->listarEstado();
		$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestion_reporte_maquina',$data);
	}

	public function gestionreporteproveedor(){
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestion_reporte_proveedor');
	}

	public function gestionmaquinas(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
				$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['listamaquina']= $this->model_comercial->listarMaquinas();
			$data['estado']= $this->model_comercial->listarEstado();
			$data['maquina']= $this->model_comercial->listarMaquinaRegistradas();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/maquinas/registrar_maquinas',$data);
		}
	}

	public function registrarproveedor(){
		$this->load->view('comercial/menu');
		$this->load->view('comercial/registrar_proveedor');
	}

	public function cierre_almacen(){
		$fecha_cierre = $this->security->xss_clean($this->input->post('fecha_cierre'));
		/* Procedimiento de validación */
		$result_validacion = $this->model_comercial->validacion_cierre_almacen_model($fecha_cierre);
		/* Fin */
		if($result_validacion == 'validacion_conforme'){
			$result = $this->model_comercial->cierre_almacen_model($fecha_cierre); /* Guarda el detalle del cierre en la tabla saldos_iniciales */
			if(!$result){
		        echo '<span style="color:red">ERROR: No se puede guardar</span>';
		    }else{
		    	$result_monto = $this->model_comercial->cierre_almacen_montos_model($fecha_cierre); /* guarda el monto de cierre del mes en la tabla monto_cierre */
		    	if(!$result_monto){
			        echo 'error_validacion_monto';
			    }else{
			    	echo 'ok';
			    }
		    }
		}else if($result_validacion == 'error_validacion'){
			echo 'error_validacion';
		}
	}

	public function registrar_cierre_mes(){
		$fecha_inicial = $this->security->xss_clean($this->input->post('fecha_inicial'));
		$fecha_final = $this->security->xss_clean($this->input->post('fecha_final'));
		// Formateo de la fecha
        $elementos = explode("-", $fecha_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        // Nombre del mes
        if($mes == 1){
            $nombre_mes = "ENERO";
        }else if($mes == 2){
            $nombre_mes = "FEBRERO";
        }else if($mes == 3){
            $nombre_mes = "MARZO";
        }else if($mes == 4){
            $nombre_mes = "ABRIL";
        }else if($mes == 5){
            $nombre_mes = "MAYO";
        }else if($mes == 6){
            $nombre_mes = "JUNIO";
        }else if($mes == 7){
            $nombre_mes = "JULIO";
        }else if($mes == 8){
            $nombre_mes = "AGOSTO";
        }else if($mes == 9){
            $nombre_mes = "SETIEMBRE";
        }else if($mes == 10){
            $nombre_mes = "OCTUBRE";
        }else if($mes == 11){
            $nombre_mes = "NOVIEMBRE";
        }else if($mes == 12){
            $nombre_mes = "DICIEMBRE";
        }
        // Fecha posterior
        if($mes == 12){
            $anio = $anio + 1;
            $mes_siguiente = 1;
            $dia = 1;
        }else if($mes <= 11 ){
            $mes_siguiente = $mes + 1;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada = implode("-", $array);
        $fecha_formateada = date("Y-m-d", strtotime($fecha_formateada));
        // validar que existen saldos iniciales registrados para esa fecha
        $result_s_i = $this->model_comercial->validar_cierre_duplicado($fecha_formateada);
        if($result_s_i == 'cierre_duplicado'){
			// Procedimiento de validación
			$this->db->select('id_monto_cierre');
	        $this->db->where('nombre_mes',$nombre_mes);
	        $this->db->where('fecha_auxiliar',$fecha_formateada);
	        $query = $this->db->get('monto_cierre');
	        if(count($query->result()) > 0){
	        	echo 'error_validacion';
	        }else{
	        	$result_monto = $this->model_comercial->cierre_almacen_montos_2016($fecha_formateada,$nombre_mes,$fecha_final); // guarda el monto de cierre del mes en la tabla monto_cierre
		    	if(!$result_monto){
			        echo 'error_validacion_monto';
			    }else{
			    	echo '1';
			    }
	        }
        }else{
            echo 'no_existe_saldos_iniciales';
        }
	}
	
	public function gestioncierrealmacen(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['monto']= $this->model_comercial->listarMontoCierre();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/view_cierre_almacen', $data);
		}
	}

	public function gestion_cierre_saldos_iniciales(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre')); //Variable de sesion
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno')); //Variable de sesion
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			$data['monto']= $this->model_comercial->listarMontoCierre();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/view_cierre_saldos_iniciales', $data);
		}
	}

	public function nuevonombremaquina(){
		$data['nombremaquinas']= $this->model_comercial->listarNombreMaquinas();
		//$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/maquinas/nuevo_nombre_maquina', $data);
	}

	public function marcamaquina(){
		//$data['nombremaquinas']= $this->model_comercial->listarNombreMaquinas();
		//$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$data['marcamaquinas']= $this->model_comercial->listarMarcaMaquinas();
		$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/maquinas/marca_maquina', $data);
	}

	public function modelomaquina(){
		$data['modelomaquinas']= $this->model_comercial->listarModeloMaquinas();
		$data['listamarca']= $this->model_comercial->listarMarca();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/maquinas/modelo_maquina',$data);
	}

	public function seriemaquina(){
		$data['seriemaquinas']= $this->model_comercial->listarSerieMaquinas();
		$data['listamodelo']= $this->model_comercial->listarModelo();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/maquinas/serie_maquina',$data);
	}

	public function gestionmoneda(){
		$data['listamoneda']= $this->model_comercial->listarMoneda();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestionar_moneda',$data);
	}

	public function gestionaduana(){
		$data['aduana']= $this->model_comercial->listarAduana();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/agente_aduana/gestionar_agente_aduana',$data);
	}

	public function gestioncomprobante(){
		$data['comprobante']= $this->model_comercial->listarComprobantes_lista();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/gestionar_comprobante',$data);
	}

	public function gestionconsultarRegistros(){
		$data['registros']= $this->model_comercial->listaRegistros();
		$data['listaproveedor']= $this->model_comercial->listaProveedor();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/comprobantes/consulta_registros_ingreso', $data);
	}

	public function gestionconsultarRegistros_optionsAdvanced(){
		$data['registros']= $this->model_comercial->listaRegistros();
		$data['anios_registros']= $this->model_comercial->lista_anios_registros();
		$this->load->view('comercial/menu');
	$this->load->view('comercial/comprobantes/consulta_registros_ingreso_optionsAdvanced', $data);
	}

	public function gestiontraslados(){
		if($this->model_comercial->existeTipoCambio() == TRUE){
			$data['tipocambio'] = 0;
		}else{
			$data['tipocambio'] = 1;
		}
		$data['listaarea']= $this->model_comercial->listarArea();
		$data['listaalmacen_partida']= $this->model_comercial->listaAlmacenCombo_traslado_inicio();
		$data['listaalmacen_llegada']= $this->model_comercial->listaAlmacenCombo_traslado_llegada();
		$this->load->view('comercial/menu_script');
		$this->load->view('comercial/menu_cabecera');
		$this->load->view('comercial/traslados', $data);
	}

	public function agregar_detalle_producto_traslado_ajax(){
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$nombre_producto = $this->input->post('nombre_producto');
		$cantidad = $this->input->post('cantidad');
		$id_area = $this->input->post('id_area');
		/* Get data product */
		$this->db->select('id_detalle_producto');
        $this->db->where('no_producto',$nombre_producto);
        $query = $this->db->get('detalle_producto');
        foreach($query->result() as $row){
            $id_detalle_producto = $row->id_detalle_producto;
        }
        // Obtengo los datos del producto
		$this->db->select('id_pro');
        $this->db->where('id_detalle_producto',$id_detalle_producto);
        $query = $this->db->get('producto');
        foreach($query->result() as $row){
            $id_pro = $row->id_pro;
        }
        // Datos del area
        $this->db->select('no_area');
        $this->db->where('id_area',$id_area);
        $query = $this->db->get('area');
        foreach($query->result() as $row){
            $no_area = $row->no_area;
        }
        $arr1 = explode(" ", $no_area);

		$this->db->select('id_detalle_producto_area,stock_area_sta_anita,stock_area_sta_clara');
        $this->db->where('id_pro',$id_pro);
        $this->db->where('id_area',$id_area);
        $query = $this->db->get('detalle_producto_area');
        if(count($query->result()) > 0){
        	foreach($query->result() as $row){
        	    $id_detalle_producto_area = $row->id_detalle_producto_area;
        	    $stock_area_sta_anita = $row->stock_area_sta_anita;
        	    $stock_area_sta_clara = $row->stock_area_sta_clara;
        	}
        	if($id_almacen == 1){ // Sta. Clara
        		if($cantidad > $stock_area_sta_clara){
        			echo 'stock_insuficiente';
        		}else{
        			$data = array(
        				'id' => $id_detalle_producto,
        				'qty' => $cantidad,
        				'price' => 5,
        				'name'=> $nombre_producto,
        				'options'=> $arr1
        			);
        			$this->cart->insert($data);
        			echo 'successfull';
        		}
        	}if($id_almacen == 2){ // Sta. Anita
        		if($cantidad > $stock_area_sta_anita){
        			echo 'stock_insuficiente';
        		}else{
        			$data = array(
        				'id' => $id_detalle_producto,
        				'qty' => $cantidad,
        				'price' => 5,
        				'name'=> $nombre_producto,
        				'options'=> $arr1
        			);
        			$this->cart->insert($data);
        			echo 'successfull';
        		}
        	}
        }else{
        	echo 'error_get_data';
        }
	}

	public function al_exportar_report_traslados(){
        $data = $this->security->xss_clean($this->uri->segment(3));
        $data = json_decode($data, true);
        $f_inicial = $data[0];
        $f_final = $data[1];

        $this->load->library('pHPExcel');
        /* variables de PHPExcel */
        $objPHPExcel = new PHPExcel();
        $nombre_archivo = "phpExcel";

        /* propiedades de la celda */
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

        // Add new sheet
        $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
        $objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $borders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
        );

        $styleArray = array(
            'font' => array(
                'bold' => true
            )
        );

        /* propiedades de la celda */
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);
        

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(80);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

        //Write cells
        $objWorkSheet->setCellValue('A1', 'ITEM')
        			 ->setCellValue('B1', 'Nº DE GUIA')
                     ->setCellValue('C1', 'FECHA DE TRASLADO')
                     ->setCellValue('D1', 'PRODUCTO O DESCRIPCION')
                     ->setCellValue('E1', 'CANTIDAD TRASLADO');

        /* Traer informacion de la BD */
        $movimientos_salida = $this->model_comercial->get_traslado_producto_area($f_inicial,$f_final);
        $existe = count($movimientos_salida);
        $sumatoria_totales = 0;
        $p = 2; // contador de filas del excel
        $i = 1; // Este calor es el contador de cuantos registros existen
        if($existe > 0){
            foreach ($movimientos_salida as $data) {
                /* $no_producto = htmlentities($data->no_producto, ENT_QUOTES,'UTF-8'); */
                /* Formatos */
                $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                /* Centrar contenido */
                $objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);

                /* border */
                $objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);

                $objWorkSheet->setCellValue('A'.$p, $i)
                             ->setCellValue('B'.$p, $data->id_traslado)
                             ->setCellValue('C'.$p, $data->fecha_traslado)
                             ->setCellValue('D'.$p, $data->no_producto)
                             ->setCellValue('E'.$p, $data->cantidad_traslado);
                $p = $p + 1;
                $i = $i + 1;
                //$sumatoria_totales = $sumatoria_totales + ($data->cantidad_salida*$data->p_u_salida);
            }
        }
        /* ---------------------------------------------------------------------- */
        /* Rename sheet */
        $objWorkSheet->setTitle("Reporte_de_traslados");
        $objPHPExcel->setActiveSheetIndex(0);

        /* datos de la salida del excel */
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Reporte_de_traslados.xls");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        echo 'ok';
    }

	public function finalizar_registro_traslado()
	{
		$this->db->trans_begin();
    	// Obtengo variables
    	$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
    	$id_almacen_partida = $this->security->xss_clean($this->input->post("id_almacen_partida"));
    	$id_almacen_llegada = $this->security->xss_clean($this->input->post("id_almacen_llegada"));
		$fecharegistro = $this->security->xss_clean($this->input->post("fecharegistro"));
		// Obtengo variables de la libreria Cart
		$carrito = $this->cart->contents();
		
		$datos = array(
			"id_almacen_partida" => $id_almacen_partida,
			"id_almacen_llegada" => $id_almacen_llegada,
			"fecha_traslado" => $fecharegistro
		);
		$id_ingreso_traslado = $this->model_comercial->agrega_ingreso_traslado($datos);
		if(!$id_ingreso_traslado){
            echo '3';
        }else{
        	// Agregamos el detalle del comprobante
			$result = $this->model_comercial->agregar_detalle_ingreso_traslado($carrito, $id_ingreso_traslado, $fecharegistro, $id_almacen);
			if(!$result){
	            echo '2';
	        }else{
	        	$this->cart->destroy();
				echo '1';
	        }
        }
        $this->db->trans_complete();
	}

	function remove_traslados($rowid){
		$this->cart->update(array(
			'rowid' => $rowid,
			'qty' => 0
		));
		redirect('comercial/gestiontraslados');
	}

	function vaciar_listado_traslado(){
		$this->cart->destroy();
		redirect('comercial/gestiontraslados');
	}

	public function gestion_consultar_salida_registros(){
		$data['salidaproducto']= $this->model_comercial->listaSalidaProducto();
		$data['anios_registros_salidas']= $this->model_comercial->lista_anios_registros_salida();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/salida_almacen/consulta_registros_salida', $data);
	}

	public function consultar_traslado_productos(){
		$data['trasladoproducto']= $this->model_comercial->listaTrasladoProducto();
		// $data['listaarea']= $this->model_comercial->listarArea();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/consultar_traslado_productos', $data);
	}

	public function gestionconsultarRegistros_otros(){
		$data['registros']= $this->model_comercial->listaRegistros_otros();
		$data['listaproveedor']= $this->model_comercial->listaProveedor();
		$data['listacomprobante']= $this->model_comercial->listarComprobantes();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/consulta_registros_ingreso_otros', $data);
	}

	public function gestionotrosDoc(){
		//$this->cart->destroy();
		$data['listaagente']= $this->model_comercial->listaAgenteAduana();
		$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
		$data['listacomprobante']= $this->model_comercial->listarComprobantes();
		$data['listaproveedor']= $this->model_comercial->listaProveedor();
		$data['listasimmon']= $this->model_comercial->listaSimMon();
		$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/registro_ingreso_otros', $data);
	}

	public function gestionarea(){
		$data['listaarea']= $this->model_comercial->listarAreaE();
		//$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
		$this->load->view('comercial/menu');
		$this->load->view('comercial/area_responsable', $data);
	}

	public function registrartipocambio()
	{
		$this->form_validation->set_rules('fecha_registro', 'Fecha de Registro', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 10 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->saveTipoCambio_vista();	       
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo 'La fecha seleccionada ya tiene un tipo de cambio asignado en el sistema. Verificar!';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function registrarproducto()
	{
        $result = $this->model_comercial->saveProducto();      
        // Verificamos que existan resultados
    	if($result == 'codigo_producto'){
         	echo 'codigo_producto';
        }else if($result =='registro_correcto'){
        	echo '1';
        }else if($result =='unidad_no_existe'){
        	echo 'unidad_no_existe';
        }else if($result =='nombre_producto'){
        	echo 'nombre_producto';
        }else if($result =='error_registro'){
        	echo 'error_registro';
        }else if($result =='nombre_duplicado'){
        	echo 'nombre_duplicado';
        }
	}

	public function registrar_producto_nueva_area()
	{
        $result = $this->model_comercial->save_agregar_producto_area();      
        // verificamos que existan resultados
    	if($result == 'area_duplicada'){
         	echo 'area_duplicada';
        }else if($result =='registro_correcto'){
        	echo '1';
        }
	}

	public function registrarnombremaquina()
	{
		$this->form_validation->set_rules('nombre', 'Nombre de Nueva Máquina', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 30 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			//$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Debe Ingresar un Nombre de Máquina.</span>';
        	$data['nombremaquinas']= $this->model_comercial->listarNombreMaquinas();
			$data['listamaquina']= $this->model_comercial->listarMaquinas();
			$this->load->view('comercial/menu');
	    	$this->load->view('comercial/maquinas/nuevo_nombre_maquina', $data);
		}
		else
		{
	        $result = $this->model_comercial->saveNombreMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Este Tipo de Máquina ya se encuentra registrado.</span>';
	        	$data['nombremaquinas']= $this->model_comercial->listarNombreMaquinas();
				$data['listamaquina']= $this->model_comercial->listarMaquinas();
				$this->load->view('comercial/menu');
		    	$this->load->view('comercial/maquinas/nuevo_nombre_maquina', $data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/nuevonombremaquina');
	        
	        }
		}
	}

	public function registrarmarcamaquina()
	{
		$this->form_validation->set_rules('nombre', 'Nombre de Nueva Máquina', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('maquina', 'Tipo de Máquina', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 30 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			//$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Debe Ingresar un Nombre de Máquina.</span>';
        	$data['marcamaquinas']= $this->model_comercial->listarMarcaMaquinas();
			$data['listamaquina']= $this->model_comercial->listarMaquinas();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/maquinas/marca_maquina', $data);
		}
		else
		{
	        $result = $this->model_comercial->saveMarcaMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Esta Marca de Máquina ya se encuentra registrada.</span>';
	        	$data['marcamaquinas']= $this->model_comercial->listarMarcaMaquinas();
				$data['listamaquina']= $this->model_comercial->listarMaquinas();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/maquinas/marca_maquina', $data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/marcamaquina');
	        
	        }
		}
	}

	public function registrararea()
	{
		$this->form_validation->set_rules('area', 'Área', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('nombre', 'Responsable', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 30 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			if($this->input->post('nombre') == "" AND $this->input->post('area') == ""){
				$data['respuesta_ambos'] = '<span style="color:red"><b>ERROR:</b> Falta completar los campos.</span>';
			}else if($this->input->post('area') == ""){
				$data['respuesta_area'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Área.</span>';
			}else if($this->input->post('nombre') == ""){
				$data['respuesta_responsable'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Responsable.</span>';
			}
        	$data['listaarea']= $this->model_comercial->listarAreaE();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/area_responsable', $data);
		}
		else
		{
	        $result = $this->model_comercial->saveArea();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	        	$data['listaarea']= $this->model_comercial->listarAreaE();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/area_responsable', $data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/gestionarea');
	        
	        }
		}
	}

		public function registrarmodelomaquina()
	{
		$this->form_validation->set_rules('nombre', 'Modelo de la Marca', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('marca', 'Marca de la Máquina', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 30 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			//$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Debe Ingresar un Nombre de Máquina.</span>';
        	$data['modelomaquinas']= $this->model_comercial->listarModeloMaquinas();
			$data['listamarca']= $this->model_comercial->listarMarca();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/maquinas/modelo_maquina',$data);
		}
		else
		{
	        $result = $this->model_comercial->saveModeloMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Este Modelo de Máquina ya se encuentra registrado.</span>';
	        	$data['marcamaquinas']= $this->model_comercial->listarMarcaMaquinas();
				$data['modelomaquinas']= $this->model_comercial->listarModeloMaquinas();
				$data['listamarca']= $this->model_comercial->listarMarca();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/maquinas/modelo_maquina',$data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/modelomaquina');
	        
	        }
		}
	}

		public function registrarseriemaquina()
	{
		$this->form_validation->set_rules('serie', 'Serie del Modelo', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('modelo', 'Modelo de la Máquina', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 30 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			//$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Debe Ingresar un Nombre de Máquina.</span>';
        	$data['seriemaquinas']= $this->model_comercial->listarSerieMaquinas();
			$data['listamodelo']= $this->model_comercial->listarModelo();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/maquinas/serie_maquina',$data);
		}
		else
		{
	        $result = $this->model_comercial->saveSerieMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Esta Serie de Máquina ya se encuentra registrado.</span>';
	        	$data['seriemaquinas']= $this->model_comercial->listarSerieMaquinas();
				$data['listamodelo']= $this->model_comercial->listarModelo();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/maquinas/serie_maquina',$data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/seriemaquina');
	        
	        }
		}
	}

	public function registrarmoneda()
	{
		$this->form_validation->set_rules('nombre', 'Nombre de Moneda', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('simbolo', 'Símbolo de Moneda', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 10 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			//$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Debe Ingresar un Nombre de Máquina.</span>';
			$data['listamoneda']= $this->model_comercial->listarMoneda();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/gestionar_moneda',$data);
		}
		else
		{
	        $result = $this->model_comercial->saveMoneda();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Este Nombre de Moneda ya se encuentra registrado.</span>';
				$data['listamoneda']= $this->model_comercial->listarMoneda();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/gestionar_moneda',$data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/gestionmoneda');
	        
	        }
		}
	}

	public function registraraduana()
	{
		$this->form_validation->set_rules('nombre', 'Nombre del Agente Aduananero', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 10 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			$data['error']= validation_errors();
			//$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Debe Ingresar un Nombre de Máquina.</span>';
			$data['aduana']= $this->model_comercial->listarAduana();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/agente_aduana/gestionar_agente_aduana',$data);
		}
		else
		{
	        $result = $this->model_comercial->saveAgente();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Este Agente Aduanero ya se encuentra registrado.</span>';
				$data['aduana']= $this->model_comercial->listarAduana();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/agente_aduana/gestionar_agente_aduana',$data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/gestionaduana');
	        
	        }
		}
	}

	public function registrarcomprobante()
	{
		$this->form_validation->set_rules('nombre', 'Nombre del Tipo de Comprobante', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 10 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			$data['error']= validation_errors();
			//$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Debe Ingresar un Nombre de Máquina.</span>';
			$data['comprobante']= $this->model_comercial->listarComprobantes_lista();
			$this->load->view('comercial/menu');
			$this->load->view('comercial/gestionar_comprobante',$data);
		}
		else
		{
	        $result = $this->model_comercial->saveComprobante();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	        	//echo "<script languaje='javascript'>alert('Hola')</script>";
	            //echo '<span style="color:red"><b>ERROR:</b> Este Nombre de Máquina ya se encuentra registrado.</span>';
	            //echo “<script languaje=’javascript’>alert(‘Material en depósito : “.$descripcion_material.”‘)</script>”;
	        	$data['respuesta'] = '<span style="color:red"><b>ERROR:</b> Este Tipo de Comprobante ya se encuentra registrado.</span>';
				$data['comprobante']= $this->model_comercial->listarComprobantes_lista();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/gestionar_comprobante',$data);
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/gestioncomprobante');
	        
	        }
		}
	}

	public function registrarmaquina()
	{
		//$this->form_validation->set_rules('codigomaq', 'Código de Máquina', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('marca', 'Marca', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('modelo', 'Modelo', 'trim|required|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('obser', 'Nombre del Producto', 'trim|min_length[1]|max_length[50]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->saveMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Esta Máquina ya se encuentra registrada.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function nuevo_proveedor(){

		$this->form_validation->set_rules('ruc', 'RUC', 'trim|required|min_length[11]|max_length[11]|xss_clean');
		$this->form_validation->set_rules('rz', 'Razón Social', 'trim|required|min_length[1]|max_length[50]|xss_clean');

		$this->form_validation->set_rules('pais', 'País', 'trim|required|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('departamento', 'Departamento','trim|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('provincia', 'Provincia', 'trim|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('distrito', 'Distrito', 'trim|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('direccion', 'Direccion', 'trim|required|min_length[1]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('referencia', 'Referencia', 'trim|min_length[1]|max_length[50]|xss_clean');

		$this->form_validation->set_rules('contacto', 'Contacto', 'trim|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('cargo', 'Cargo', 'trim|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('telefono1', 'Teléfono 1', 'trim|min_length[7]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('telefono2', 'Teléfono 2', 'trim|[7]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('web', 'Dirección Web', 'trim|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('fax', 'Fax', 'trim|min_length[1]|max_length[10]|xss_clean');

		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{

	        $result = $this->model_comercial->saveProveedor();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            //$this->form_validation->set_error_delimiters('<span style="color:red;font-size:12px"><b>ERROR:</b> El RUC ya se encuentra registrado.', '</span><br>');
	            echo '<span style="color:red"><b>ERROR:</b> El RUC ya se encuentra registrado.</span>';
	            
	        }else{
	        	//Registramos la sesion del usuario
	        	redirect('comercial/gestionproveedores');
	        }
		}
	}

	public function registroingresoprod(){

		$this->form_validation->set_rules('cantidad', 'Cantidad', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('pt', 'Precio Total', 'trim|required|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('numcomprobante', 'N° de Comprobante', 'trim|required|min_length[1]|max_length[40]|xss_clean');
		$this->form_validation->set_rules('fecharegistro', 'Fecha de Registro', 'trim|required|min_length[1]|max_length[40]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->saveRegistroIngreso();
	        //$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            //$this->form_validation->set_error_delimiters('<span style="color:red;font-size:12px"><b>ERROR:</b> El RUC ya se encuentra registrado.', '</span><br>');
	            echo '<span style="color:red"><b>ERROR:</b> El Producto ya se encuentra registrado con este N° de Comprobante.</span>';
	        }else{
	        	$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
				$data['listacomprobante']= $this->model_comercial->listaComprobante();
				$data['listaproveedor']= $this->model_comercial->listaProveedor();
				$data['listasimmon']= $this->model_comercial->listaSimMon();
				$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
				$data['listaarea']= $this->model_comercial->listarArea();
				$this->load->view('comercial/menu');
				$this->load->view('comercial/comprobantes/registro_ingreso', $data);
	        }
		}
	}
/*
	public function listaregistroingreso(){
		$this->form_validation->set_rules('numcomprobante', 'N° de Comprobante', 'trim|required|min_length[1]|max_length[40]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','<b>ERROR:</b> Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','<b>ERROR:</b> El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','<b>ERROR:</b> El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        //$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
	        echo "hola";
		}
	}
*/

	public function datosRucExiste()
	{
        $datos = $this->model_comercial->getDatosRucExiste();
        echo '<table width="750" border="0" cellspacing="1" cellpadding="1">
			  <tr class="tituloTable">
			    <td width="100">RUC</td>
			    <td width="300">RAZON SOCIAL</td>
			    <td width="300" >DIRECCIÓN</td>
			  </tr>';
        foreach($datos as $fila)
        {
        	echo '<tr class="contentTable">
				    <td>'.$fila->ruc.'</td>
				    <td>'.$fila->razon_social.'</td>
				    <td>'.$fila->direccion.'</td>
				  </tr>';
	    }
	    echo '</table>';
	}

	public function existeRuc()
	{
       
        $existe = $this->model_comercial->existeRuc();
        if($existe){
        	echo '1';
        }else{
        	echo '0';
        }

	}

	public function editarmaquina(){
		$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$data['listmarca']= $this->model_comercial->listarMarca();
		$data['listmodelo']= $this->model_comercial->listarModelo();
		$data['listserie']= $this->model_comercial->listarSerie();
		$data['editestado']= $this->model_comercial->listarEstado();
		$data['datosmaq']= $this->model_comercial->getMaqEditar();
		$this->load->view('comercial/maquinas/actualizar_maquina', $data);
	}

	public function editarnombremaquina(){
		$data['datosnommaq']= $this->model_comercial->getNomMaqEditar();
		$this->load->view('comercial/maquinas/actualizar_nombre_maquina', $data);
	}

	public function editararea(){
		$data['datosarea']= $this->model_comercial->getDatosArea();
		$this->load->view('comercial/actualizar_area', $data);
	}

	public function editarseriemaquina(){
		$data['listamodelo']= $this->model_comercial->listarModelo();
		$data['datossermaq']= $this->model_comercial->getSerMaqEditar();
		$this->load->view('comercial/maquinas/actualizar_serie_maquina', $data);
	}

	public function editarmarcamaquina(){
		$data['listamaquina']= $this->model_comercial->listarMaquinas();
		$data['datosmarmaq']= $this->model_comercial->getMarMaqEditar();
		$this->load->view('comercial/maquinas/actualizar_marca_maquina', $data);
	}

	public function editarmodelomaquina(){
		$data['listamarca']= $this->model_comercial->listarMarca();
		$data['datosmodmaq']= $this->model_comercial->getModMaqEditar();
		$this->load->view('comercial/maquinas/actualizar_modelo_maquina', $data);
	}

	public function editarmoneda(){
		$data['datosmoneda']= $this->model_comercial->getDatosMoneda();
		$this->load->view('comercial/actualizar_moneda', $data);
	}

	public function editaragente(){
		$data['agente']= $this->model_comercial->getDatosAgente();
		$this->load->view('comercial/agente_aduana/actualizar_agente', $data);
	}

	public function editarcomprobante(){
		$data['comprobante']= $this->model_comercial->getDatosComprobante();
		$this->load->view('comercial/actualizar_comprobante', $data);
	}

	public function editarproducto(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$id_pro = $data[0];
		$id_detalle_producto_area = $data[1];
        // cargar vista
		$data['listaarea']= $this->model_comercial->listarArea();
		$data['listacat'] = $this->model_comercial->listarCategoria();
		$data['listatipop'] = $this->model_comercial->listarTipoProdCombo($id_pro);
		$data['listaunimed'] = $this->model_comercial->listarUnidadMedidaCombo();
		$data['listaproce'] = $this->model_comercial->listarProcedencia();
		$data['datosprod']= $this->model_comercial->getProdEditar();
		$this->load->view('comercial/productos/actualizar_producto', $data);
	}

	public function editartipocambio(){
		$data['datosTC']= $this->model_comercial->getTCEditar();
		$this->load->view('comercial/tipo_cambio/actualizar_tipo_cambio', $data);	
	}

	public function mostrardetalle(){
		$data['detFac']= $this->model_comercial->getDetalleFactura();
		$data['detProd']= $this->model_comercial->getDetalleProd();
		$this->load->view('comercial/comprobantes/mostrar_detalle', $data);
	}

	public function mostrarDetalleSalidas(){
		$id_area = $this->security->xss_clean($this->uri->segment(3));
		$fecha_actual = date('Y-m-d');
		$data['dataSalidas']= $this->model_comercial->getSalidasProductos($id_area, $fecha_actual);
		$this->load->view('comercial/salida_almacen/mostrar_detalle_salidas', $data);
	}

	public function print_pdf_salidas_area(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfSalidaProductos');
	    // Obtener las variables
		$id_area = $this->security->xss_clean($this->uri->segment(3));
		$fecha_actual = date('Y-m-d');

		/* Formato para la fecha inicial */
        $elementos = explode("-", $fecha_actual);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        $array = array($dia, $mes, $anio);
        $fecha_formateada = implode("-", $array);

        // Creacion del PDF

	    /*
	     * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
	     * heredó todos las variables y métodos de fpdf
	    */
        $this->pdf = new PdfSalidaProductos();
	    // Agregamos una página
	    $this->pdf->AddPage();
	    // Define el alias para el número de página que se imprimirá en el pie
	    $this->pdf->AliasNbPages();

	    /* Se define el titulo, márgenes izquierdo, derecho y
	     * el color de relleno predeterminado
	    */
	    $this->pdf->SetTitle("Documento de Salida");
	    $this->pdf->SetLeftMargin(25);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);

        // Se define el formato de fuente: Arial, negritas, tamaño 9
	    $this->pdf->SetFont('Arial', 'B', 7);

	    $almacen = $this->security->xss_clean($this->session->userdata('almacen'));

	    if($almacen == 1){
	    	$nombre_almacen = "SANTA CLARA";
	    	$nombre_encargado = "GUILLERMO SANCHEZ FLORES";
	    }else if($almacen == 2){
	    	$nombre_almacen = "SANTA ANITA";
	    	$nombre_encargado = "ASCENCIO OSORIO AMADOR";
	    }

	    // Obtener el nombre del almacen
	    $this->db->select('no_area');
        $this->db->where('id_area',$id_area);
        $query = $this->db->get('area');
        if(count($query->result()) > 0){
        	foreach($query->result() as $row){
        		$no_area = $row->no_area;
        	}
        }

	    $this->pdf->SetFont('Arial','B',11);
	    $this->pdf->Cell(30,20,utf8_decode($nombre_almacen),0,0,'C');
	    $this->pdf->Cell(243,20,utf8_decode('N° - 000'.$almacen),0,0,'C');
	    $this->pdf->Ln(13);

	    $this->pdf->SetFont('Arial','B',8);
	    $this->pdf->Cell(30,20,utf8_decode("FECHA                          : "),'',0,'L','0');
	    $this->pdf->Cell(10,20,"    ",'',0,'c','0');
	    $this->pdf->Cell(10,20,"     ".$dia,'',0,'c','0');
	    $this->pdf->Cell(10,20," -   ".$mes,'',0,'c','0');
	    $this->pdf->Cell(10,20," -   ".$anio,'',0,'c','0');
	    $this->pdf->Ln(8);
	    $this->pdf->Cell(30,20,utf8_decode("DESPACHADO POR    : "),'',0,'L','0');
	    $this->pdf->Cell(40,20,"                  ".$nombre_encargado,'',0,'L','0');
	    $this->pdf->Ln(8);
	    $this->pdf->Cell(30,20,utf8_decode("AREA                            : "),'',0,'L','0');
	    $this->pdf->Cell(40,20,"                  ".$no_area,'',0,'L','0');
	    $this->pdf->Ln(20);

	    $this->pdf->SetFont('Arial','B',7);
	    $this->pdf->Cell(10,7,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
        $this->pdf->Cell(70,7,utf8_decode('NOMBRE O DESCRIPCIÓN DEL PRODUCTO'),'BLTR',0,'C','1');
        $this->pdf->Cell(20,7,utf8_decode('CANTIDAD'),'BLTR',0,'C','1');
        $this->pdf->Cell(25,7,utf8_decode('UNIDAD MED.'),'BLTR',0,'C','1');
        $this->pdf->Cell(35,7,utf8_decode('SOLICITANTE'),'BLTR',0,'C','1');
	    $this->pdf->Ln(7);
	    $x = 1;

	    $result = $this->model_comercial->getSalidasProductos($id_area, $fecha_actual);
	    $existe = count($result);
	    if($existe > 0){
	    	foreach ($result as $row) {
		    	$this->pdf->Cell(10,7,$x++,'BR BL BT',0,'C',0);
				$this->pdf->Cell(70,7,utf8_decode($row->no_producto),'BR BT',0,'C',0);
				$this->pdf->Cell(20,7,$row->cantidad_salida,'BR BT',0,'C',0);
				$this->pdf->Cell(25,7,$row->nom_uni_med,'BR BT',0,'C',0);
				$this->pdf->Cell(35,7,$row->solicitante,'BR BT',0,'C',0);
				$this->pdf->Ln(7);
			}
	    }

	    // Firma de Conformidad
		$this->pdf->Ln(15);
		$this->pdf->Cell(20,20,utf8_decode("........................................................................."),'',0,'L','0');
		$this->pdf->Cell(88,20,utf8_decode(" "),'',0,'L','0');
		$this->pdf->Cell(100,20,utf8_decode("........................................................................."),'',0,'L','0');
		$this->pdf->Ln(4);
		$this->pdf->Cell(18,20,utf8_decode("    "),'',0,'L','0');
		$this->pdf->Cell(20,20,utf8_decode("B° V° JEFE"),'',0,'L','0');
		$this->pdf->Cell(87,20,utf8_decode("    "),'',0,'L','0');
		$this->pdf->Cell(110,20,utf8_decode("FIRMA Y SELLO"),'',0,'L','0');
	    	

	    /*
	     * Se manda el pdf al navegador
	     *
	     * $this->pdf->Output(nombredelarchivo, destino);
	     *
	     * I = Muestra el pdf en el navegador
	     * D = Envia el pdf para descarga
	     *
	     */
	    $this->pdf->Output("Documento de Traslado.pdf", 'D');
	}

	public function editarproveedor(){
		$data['datosprov']= $this->model_comercial->getProvEditar();
		$this->load->view('comercial/proveedores/actualizar_proveedor', $data);
	}

	public function eliminarnombremaquina(){
		$idnombremaquina = $this->input->get('eliminar');
		$this->model_comercial->eliminarNombreMaquina($idnombremaquina);
	}

	public function eliminarseriemaquina()
	{
		$idseriemaquina = $this->input->get('eliminar');
		$this->model_comercial->eliminarSerieMaquina($idseriemaquina);
	}

	public function eliminarmarcamaquina()
	{
		$idmarcamaquina = $this->input->get('eliminar');
		$this->model_comercial->eliminarMarcaMaquina($idmarcamaquina);
	}

	public function eliminarmodelomaquina()
	{
		$idmodelomaquina = $this->input->get('eliminar');
		$this->model_comercial->eliminarModeloMaquina($idmodelomaquina);
	}

	public function eliminarmoneda()
	{
		$idmoneda = $this->input->get('eliminar');
		$this->model_comercial->eliminarMoneda($idmoneda);
	}

	public function gestioninterfaz()
	{
		$nombre = $this->security->xss_clean($this->session->userdata('nombre'));
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno'));
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			$this->load->view('comercial/menu');
			$this->load->view('comercial/interfaz');
		}
	}

	public function actualizar_informacion_producto(){
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$i = 1;
		$cont = 1;
		$cont_area = 1;
		$mensaje_registro = 1;
		$indicador_producto = TRUE;
		$indicador_area = TRUE;
		// Validar si los datos de los productos y areas corresponde a los de la BD
		// Validando el nombre del producto
		$filename = $_FILES['file']['tmp_name'];
		if(($gestor = fopen($filename, "r")) !== FALSE){
			while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
				// Obtener los valores del numero de partida
				$id_detalle_producto = utf8_decode(trim($datos[0]));
				// ------------------------------------------
				$this->db->select('id_detalle_producto');
	            $this->db->where('id_detalle_producto',$id_detalle_producto);
	            $query = $this->db->get('detalle_producto');
	            if($query->num_rows() == 1){
	            	$cont = $cont + 1;
	            }else if($query->num_rows() == 2){
	            	var_dump($id_detalle_producto.' DOS ');
	            }else if($query->num_rows() == 0){
	            	var_dump($id_detalle_producto.' CERO ');
	            	$indicador_producto = FALSE;
	            	$data['respuesta_validacion_producto_invalido'] = $cont;
					$this->load->view('comercial/menu');
					$this->load->view('comercial/interfaz', $data);
					$mensaje_registro = 2;
					break;
	            }
			}
		}
		if($indicador_producto == TRUE){
			// Validando el nombre del area
			$filename = $_FILES['file']['tmp_name'];
			if(($gestor = fopen($filename, "r")) !== FALSE){
				while (($datos = fgetcsv($gestor,1000,",")) !== FALSE){
					// Obtener los valores del numero de partida
					$id_detalle_producto = utf8_decode(trim($datos[0]));
					$id_area = utf8_decode(trim($datos[1]));
					// Obtener el id del producto
					$this->db->select('id_detalle_producto,stock,stock_sta_clara');
	            	$this->db->where('id_detalle_producto',$id_detalle_producto);
	            	$query = $this->db->get('detalle_producto');
	            	foreach ($query->result() as $row) {
	            		$id_detalle_producto = $row->id_detalle_producto;
	            		$stock_sta_anita = $row->stock;
	            		$stock_sta_clara = $row->stock_sta_clara;
	            	}
	            	$this->db->select('id_pro');
	            	$this->db->where('id_detalle_producto',$id_detalle_producto);
	            	$query = $this->db->get('producto');
	            	foreach ($query->result() as $row) {
	            		$id_pro = $row->id_pro;
	            	}
					// ------------------------------------------
					if($id_area != 'null'){
						$this->db->select('id_area');
			            $this->db->where('id_area',$id_area);
			            $query = $this->db->get('area');
			            if($query->num_rows() == 1){
			            	$cont_area = $cont_area + 1;
			            	foreach ($query->result() as $row) {
			            		$id_area = $row->id_area;
			            	}
			            	// Actualizar el area al producto
			            	// validar si existe el area registrada con el producto
			            	/*
			            	$this->db->select('id_detalle_producto_area');
			            	$this->db->where('id_pro',$id_pro);
			            	$this->db->where('id_area',$id_area);
			            	$query = $this->db->get('detalle_producto_area');
			            	if($query->num_rows() == 0){
			            		$datos = array(
								    "id_area" => $id_area,
								    "id_pro" => $id_pro,
								);
								$this->db->insert('detalle_producto_area', $datos);
			            	}
			            	*/
			            	// Procedo a realizar la actualizacion dependiendo del area
			            	// Obtengo el stock en funcion del almacen teniendo como filtro
        					$this->db->select('id_detalle_producto_area');
        	            	$this->db->where('id_pro',$id_pro);
        	            	$this->db->where('id_area',$id_area);
        	            	$query = $this->db->get('detalle_producto_area');
        	            	if($query->num_rows() == 1){
	        	            	foreach ($query->result() as $row) {
	        	            		$id_detalle_producto_area = $row->id_detalle_producto_area;
	        	            	}
	        	            	// Actualizar el stock de cada area
	        	            	if($id_almacen == 1){
	        	            		$actualizar = array('stock_area_sta_clara'=> $stock_sta_clara);
									$this->db->where('id_detalle_producto_area',$id_detalle_producto_area);
									$this->db->update('detalle_producto_area', $actualizar);
	        	            	}else if($id_almacen == 2){
	        	            		$actualizar = array('stock_area_sta_anita'=> $stock_sta_anita);
									$this->db->where('id_detalle_producto_area',$id_detalle_producto_area);
									$this->db->update('detalle_producto_area', $actualizar);
	        	            	}
	        	            	$cont_area = $cont_area + 1;
        	            	}else if($query->num_rows() == 2){
        	            		var_dump('Producto con dos areas '.$id_detalle_producto);
        	            	}else{
        	            		var_dump('Validar producto '.$id_detalle_producto);
        	            	}
			            }else{
			            	$indicador_area = FALSE;
			            	$data['respuesta_validacion_area_invalido'] = $cont_area;
							$this->load->view('comercial/menu');
							$this->load->view('comercial/interfaz', $data);
							$mensaje_registro = 2;
							break;
			            }
			        }else{
			        	$cont_area = $cont_area + 1;
			        }
				}
			}
		}
		if($mensaje_registro == 1){
			$i = $i - 1;
			$data['respuesta_registro_realizados'] = $i;
        	$this->load->view('comercial/menu');
			$this->load->view('comercial/interfaz', $data);
		}
	}

	public function eliminarproducto_area()
	{
		$id_detalle_producto_area = $this->security->xss_clean($this->input->post('id_detalle_producto_area'));
		$result = $this->model_comercial->eliminarProducto_area($id_detalle_producto_area);
		if($result == 'existe_stock'){
            echo 'dont_delete';
        }else if($result == 'eliminacion_correcta'){
        	echo 'ok';
        }
	}

	public function eliminarproducto()
	{
		$id_pro = $this->security->xss_clean($this->input->post('id_pro'));
		$result = $this->model_comercial->eliminarProducto($id_pro);
		if($result == 'producto_factura' || $result == 'producto_saldo_inicial'){
            echo 'dont_delete';
        }else if($result == 'eliminacion_correcta'){
        	echo 'ok';
        }
	}

	public function eliminar_proveedor_ajax()
	{
		$id_proveedor = $this->security->xss_clean($this->input->post('id_proveedor'));
		$result = $this->model_comercial->eliminar_proveedor_ajax($id_proveedor);
		if($result == 'proveedor_factura'){
            echo 'dont_delete';
        }else if($result == 'eliminacion_correcta'){
        	echo 'ok';
        }
	}

	public function eliminaragente()
	{
		$idagente = $this->input->get('eliminar');
		$this->model_comercial->eliminarAgente($idagente);
	}

	public function eliminarcomprobante()
	{
		$idcomprobante = $this->input->get('eliminar');
		$this->model_comercial->eliminarComprobante($idcomprobante);
	}

	public function eliminarproveedor()
	{
		$idproveedor = $this->input->get('eliminar');
		$result = $this->model_comercial->eliminarProveedor($idproveedor);
		if(!$result){
            echo '<b>--> Este Proveedor está asociado a una Factura.</b><br><b>--> Para eliminar este Proveedor, primero deberá eliminar la Factura a la que esta asociada.</b>';
        }else{
        	echo '1';
        }
	}

	public function eliminarmaquina()
	{
		$idmaquina = $this->input->get('eliminar');
		$this->model_comercial->eliminarMaquina($idmaquina);
	}

	public function actualizarmaquina()
	{
		$this->form_validation->set_rules('editnombremaq', 'Tipo Máquina', 'trim|required|xss_clean');
		$this->form_validation->set_rules('editmarca', 'Marca', 'trim|required|xss_clean');
		$this->form_validation->set_rules('editmodelo', 'Modelo', 'trim|required|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 50 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Esta Máquina no se encuentra registrada.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizarnombremaquina()
	{
		$this->form_validation->set_rules('editnombremaq', 'Nombre Máquina', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaNombreMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Esta Máquina ya se encuentra registrada.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizararea()
	{
        $result = $this->model_comercial->actualizaArea();
        if(!$result){
            echo 'Esta área ya se encuentra registrada en el sistema. Verificar!';
        }else{
        	echo '1';
        }
	}

	public function actualizarseriemaquina()
	{
		$this->form_validation->set_rules('editmodelomaq', 'Modelo de Máquina', 'trim|required|xss_clean');
		$this->form_validation->set_rules('editseriemaq', 'Serie de Máquina', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaSerieMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Esta Serie asociado a este Modelo ya existe.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizarmarcamaquina()
	{
		$this->form_validation->set_rules('editnombremaq', 'Tipo de Máquina', 'trim|required|xss_clean');
		$this->form_validation->set_rules('editmarcamaq', 'Marca del Tipo de Máquina', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaMarcaMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Esta Marca asociado a este Tipo de Máquina ya existe.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizarmodelomaquina()
	{
		$this->form_validation->set_rules('editmarcamaq', 'Marca de Máquina', 'trim|required|xss_clean');
		$this->form_validation->set_rules('editmodelomaq', 'Modelo del Tipo de Máquina', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaModeloMaquina();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Esta Modelo asociado a esta Marca ya existe.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizaragente()
	{
		$this->form_validation->set_rules('editnombreagente', 'Nombre del Agente Aduanero', 'trim|required|min_length[1]|max_length[50]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 50 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaAgente();
	        if(!$result){
	            echo 'Este agente de aduana ya se encuentra registrado. Verificar!';
	        }else{
	        	echo '1';
	        }
		}
	}

	public function actualizarcomprobante()
	{
		$this->form_validation->set_rules('editnombrecomprobante', 'Nombre del Tipo de Comprobante', 'trim|required|min_length[1]|max_length[30]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaComprobante();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Este Tipo de Comprobante ya se encuentra registrado.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizarmoneda()
	{
		$this->form_validation->set_rules('editnombremon', 'Nombre de Moneda', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('editsimbolomon', 'Símbolo de Moneda', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 10 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaMoneda();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Este Tipo de Moneda ya se encuentra registrado.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizarproducto()
	{
		$this->form_validation->set_rules('editidprod', 'ID Producto', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('editnombreprod', 'Descripción', 'trim|required|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('editobser', 'Observación', 'trim|max_length[50]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaProducto();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Este Código ya esta asociado a un Producto.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizartipocambio()
	{
		$this->form_validation->set_rules('edit_dolar_compra', 'Valor de Compra Dólar', 'trim|required|min_length[1]|max_length[5]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 5 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaTipoCambio();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> Tipo de Cambio ya registrado.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function actualizarproveedor()
	{
		$this->form_validation->set_rules('edit_rz', 'Razón Social', 'trim|required|xss_clean');
		$this->form_validation->set_rules('edit_ruc', 'RUC', 'min_length[11]|max_length[11]|trim|required|xss_clean');
		$this->form_validation->set_rules('edit_direc', 'Dirección', 'max_length[50]|trim|required|xss_clean');
		$this->form_validation->set_rules('edit_tel1', 'Teléfono 1', 'trim|xss_clean|required|');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 11 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 50 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
	        $result = $this->model_comercial->actualizaProveedor();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR:</b> El RUC de este Proveedor ya se encuentra registrado.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function traerFacturasImportadas(){
    	$resultado = $this->model_comercial->get_datos_factura_importada();
   		if (count($resultado) == 0) {
	        echo '0';
	    }else{
	    	echo '<table width="570" border="0" cellspacing="1" cellpadding="1" style="margin-bottom: 20px;margin-left: 25px;">
					<tr>
				  		<td colspan="4" class="title-formulate-selected"><strong>Facturas Importadas</strong></td>
				    </tr>
				    <tr class="tituloTable-fact-import">
				    	<td width="100">Fecha</td>
				    	<td width="270">Proveedor</td>
				    	<td width="75">Serie</td>
				    	<td width="115">Correlativo</td>
				    	<td width="20"> </td>
				    </tr>';
				    foreach($resultado as $key => $row){
				    	echo '<tr class="contentTable-fact-import" style="font-size: 11px;">
							    <td>'.$row->fecha.'</td>
							    <td>'.$row->razon_social.'</td>
							    <td>'.$row->serie_comprobante.'</td>
							    <td>'.$row->nro_comprobante.'</td>
							    <td> <a href="#" onClick="gestionar_factura_importada(event, \''.$row->id_ingreso_producto.'\')" ><i class="fa fa-pencil-square-o" title="Actualizar"></i></a></td>
						     </tr>';
				    }
			echo '</table>';
	    }	    
    }

	public function traerStock()
	{
        $stock = $this->model_comercial->getStock();
        foreach($stock as $dato){
        	echo $dato->stock;
        }
	}

	public function traerEncargado()
	{
        $encar = $this->model_comercial->getEncargado();
        foreach($encar as $dato){
        	echo $dato->encargado;
        }
	}

	public function traerUnidadMedida()
	{
        $unidad_medida = $this->model_comercial->getUnidadMedida();
        foreach($unidad_medida as $dato){
        	echo $dato->unidad_medida;
        }
	}

	public function agregarcarrito(){
		//print_r($_POST);
		$this->form_validation->set_rules('nombre_producto', 'Nombre del Producto', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cantidad', 'Cantidad', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pu', 'Precio Unitario', 'trim|required|xss_clean');
		$this->form_validation->set_rules('area', 'Área', 'trim|required|xss_clean');
		$this->form_validation->set_rules('csigv', 'Con/Sin IGV', 'trim|required|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			//$data['error']= validation_errors();
			if($this->model_comercial->existeTipoCambio() == TRUE){
				$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			if($this->input->post('nombre_producto') == "" AND $this->input->post('cantidad') == "" AND $this->input->post('pu') == ""){
				$data['respuesta_general_carrito'] = '<span style="color:red"><b>ERROR:</b> Falta completar los campos.</span>';
			}else if($this->input->post('nombre_producto') == ""){
				$data['respuesta_carrito_prod'] = '<span style="color:red"><b>ERROR:</b> Falta seleccionar el campo Producto.</span>';
			}else if($this->input->post('cantidad') == ""){
				$data['respuesta_carrito_qty'] = '<span style="color:red"><b>ERROR:</b> Falta seleccionar el campo Cantidad.</span>';
			}else if($this->input->post('pu') == ""){
				$data['respuesta_carrito_pu'] = '<span style="color:red"><b>ERROR:</b> Falta seleccionar el campo Precio Unitario.</span>';
			}else if($this->input->post('csigv') == ""){
				$data['respuesta_csigv'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Agente de Aduana.</span>';
			}else if($this->input->post('area') == ""){
				$data['respuesta_area'] = '<span style="color:red"><b>ERROR:</b> Falta seleccionar el campo Área</span>';
			}
			$data['listaarea']= $this->model_comercial->listarArea();
			$data['listaagente']= $this->model_comercial->listaAgenteAduana();
			$data['listacomprobante']= $this->model_comercial->listaComprobante();
			$data['listaproveedor']= $this->model_comercial->listaProveedor();
			$data['listasimmon']= $this->model_comercial->listaSimMon();
			$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/comprobantes/registro_ingreso', $data);
		}else{
			$this->cart->total();

			$datasession_igv = array(
				'csigv' => $this->input->post('csigv')
			);
			$this->session->set_userdata($datasession_igv);

			$nombre_producto = $this->input->post('nombre_producto');
			$id_area = $this->input->post('area');

			$this->db->select('no_area');
	        $this->db->where('id_area',$id_area);
	        $query = $this->db->get('area');
	        foreach($query->result() as $row){
	            $no_area = $row->no_area;
	        }
			$arr1 = explode(" ", $no_area);

			$this->db->select('id_detalle_producto');
	        $this->db->where('no_producto',$nombre_producto);
	        $query = $this->db->get('detalle_producto');
	        foreach($query->result() as $row){
	            $id_detalle_producto = $row->id_detalle_producto;
	        }

		    $this->db->select('id_producto');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $query = $this->db->get('producto');
	        foreach($query->result() as $row){
	            $id_producto = $row->id_producto;
	        }

			$data = array(
				'id' => $id_producto,
				'qty' => $this->input->post('cantidad'),
				'price' => $this->input->post('pu'),
				'name'=> $nombre_producto,
				'options'=> $arr1
			);
			$this->cart->insert($data);

			redirect('comercial/gestioningreso');
		}
	}

		public function agregarcarrito_otros(){
		//print_r($_POST);
		$this->form_validation->set_rules('nomproducto', 'Nombre del Producto', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cantidad', 'Cantidad', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pu', 'Precio Unitario', 'trim|required|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			$data['error']= validation_errors();
			$data['listaagente']= $this->model_comercial->listaAgenteAduana();
			$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
			$data['listacomprobante']= $this->model_comercial->listarComprobantes();
			$data['listaproveedor']= $this->model_comercial->listaProveedor();
			$data['listasimmon']= $this->model_comercial->listaSimMon();
			$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
			$this->load->view('comercial/registro_ingreso_otros', $data);
		}else{
			$this->cart->total();
		
			$id_detalle_producto = $this->input->post('nomproducto');

		    $this->db->select('id_producto');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $query = $this->db->get('producto');
	        foreach($query->result() as $row){
	            $id_producto = $row->id_producto;
	        }

		    $this->db->select('no_producto');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $query = $this->db->get('detalle_producto');
	        foreach($query->result() as $row){
	            $no_producto = $row->no_producto;
	        }

			$data = array(
				'id' => $id_producto,
				'qty' => $this->input->post('cantidad'),
				'price' => $this->input->post('pu'),
				'name'=> $no_producto
			);
			$this->cart->insert($data);
			
			/*
			$data['listaagente']= $this->model_comercial->listaAgenteAduana();
			$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
			$data['listacomprobante']= $this->model_comercial->listarComprobantes();
			$data['listaproveedor']= $this->model_comercial->listaProveedor();
			$data['listasimmon']= $this->model_comercial->listaSimMon();
			$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
			$this->load->view('comercial/registro_ingreso_otros', $data);
			*/
			redirect('comercial/gestionotrosDoc');
		}
	}

	function actualizar_carrito(){
		//print_r($_POST);
		$data = $this->input->post();
		$this->cart->update($data);
		redirect('comercial/gestioningreso');
	}

	
	function remove($rowid){
		$this->cart->update(array(
			'rowid' => $rowid,
			'qty' => 0
		));
		redirect('comercial/gestioningreso');
	}

	function remove_otros($rowid){
		$this->cart->update(array(
			'rowid' => $rowid,
			'qty' => 0
		));
		redirect('comercial/gestionotrosDoc');
	}

	function vaciar_listado(){
		$this->cart->destroy();
		$this->session->unset_userdata('csigv');
		redirect('comercial/gestioningreso');
	}

	function vaciar_listado_otros(){
		$this->cart->destroy();
		redirect('comercial/gestionotrosDoc');
	}

	function actualizar_carrito_otros(){
		$data = $this->input->post();
		$this->cart->update($data);
		redirect('comercial/gestionotrosDoc');
	}

	function mostrar(){
		print_r($_POST);
		//echo 1;
	}

	public function UpdatePassword()
	{
		$this->form_validation->set_rules('password', 'Contraseña Actual', 'trim|required|max_length[12]|xss_clean');
		$this->form_validation->set_rules('datacontrasena', 'Nueva Contraseña', 'trim|required|max_length[12]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE){
			if($this->input->post('password') == "" AND $this->input->post('datacontrasena') == ""){
				echo '<span style="color:red"><b>ERROR:</b> Falta completar los campos. Verifique por favor.</span>';
			}else if($this->input->post('password') == ""){
				echo '<span style="color:red"><b>ERROR:</b> Falta completar el campo Contraseña Actual.</span>';
			}else if($this->input->post('datacontrasena') == ""){
				echo '<span style="color:red"><b>ERROR:</b> Falta completar el campo Nueva Contraseña.</span>';
			}
		}else {
			$result = $this->model_comercial->UpdatePassword();
	        // Verificamos que existan resultados
	        if(!$result){
	            //Sí no se encotnraron datos.
	            echo '<span style="color:red"><b>ERROR: </b>Validación Incorrecta de Contraseña. Su Contraseña Actual no Coincide.</span>';
	        }else{
	        	//Registramos la sesion del usuario
	        	echo '1';
	        }
		}
	}

	public function agregar_indice(){
		$result = $this->model_comercial->updateIndice();
        // Verificamos que existan resultados
        if(!$result){
            //Sí no se encotnraron datos.
            echo '<span style="color:red"><b>ERROR: </b>ERROR</span>';
        }else{
        	//Registramos la sesion del usuario
        	echo '1';
        }
	}

	public function finalizar_registro()
	{
		$this->form_validation->set_rules('numcomprobante', 'Nro. de Comprobante', 'trim|required|min_length[1]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('fecharegistro', 'Fecha de Registro', 'trim|required|xss_clean');
		$this->form_validation->set_rules('moneda', 'Moneda', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('proveedor', 'Proveedor', 'trim|required|xss_clean');
		$this->form_validation->set_rules('id_agente', 'Agente de Aduana', 'trim|required|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			//$data['error']= validation_errors();
			if($this->model_comercial->existeTipoCambio() == TRUE){
				$data['tipocambio'] = 0;
			}else{
				$data['tipocambio'] = 1;
			}
			if($this->input->post('numcomprobante') == "" AND $this->input->post('fecharegistro') == "" AND $this->input->post('moneda') == "" AND $this->input->post('proveedor') == "" AND $this->input->post('id_agente') == ""){
				$data['respuesta_general'] = '<span style="color:red"><b>ERROR:</b> Falta completar los campos.</span>';
			}else if($this->input->post('numcomprobante') == ""){
				$data['respuesta_compro'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo N° de Comprobante.</span>';
			}else if($this->input->post('moneda') == ""){
				$data['respuesta_moneda'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Moneda.</span>';
			}else if($this->input->post('nombre_proveedor') == ""){
				$data['respuesta_prov'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Proveedor.</span>';
			}else if($this->input->post('fecharegistro') == ""){
				$data['respuesta_fe'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Fecha de Registro.</span>';
			}else if($this->input->post('id_agente') == ""){
				$data['respuesta_agente'] = '<span style="color:red"><b>ERROR:</b> Falta completar el campo Agente de Aduana.</span>';
			}
			$data['listaagente']= $this->model_comercial->listaAgenteAduana();
			$data['listaarea']= $this->model_comercial->listarArea();
			//$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
			$data['listacomprobante']= $this->model_comercial->listaComprobante();
			$data['listaproveedor']= $this->model_comercial->listaProveedor();
			$data['listasimmon']= $this->model_comercial->listaSimMon();
			$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
			$this->load->view('comercial/menu_script');
			$this->load->view('comercial/menu_cabecera');
			$this->load->view('comercial/comprobantes/registro_ingreso', $data);
		}else{
			if(($this->input->post('id_agente') != 2 AND $this->input->post('id_agente') != 3 AND $this->input->post('id_agente') != 4) AND ($this->input->post('porcent') == 0)){
					if($this->model_comercial->existeTipoCambio() == TRUE){
						$data['tipocambio'] = 0;
					}else{
						$data['tipocambio'] = 1;
					}
					$data['error_porcentaje'] = '<span style="color:red"><b>ERROR:</b> Ingresar el Porcentaje de Gastos asignado a la Factura.</span>';
					$data['listaagente']= $this->model_comercial->listaAgenteAduana();
					//$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
					$data['listaarea']= $this->model_comercial->listarArea();
					$data['listacomprobante']= $this->model_comercial->listaComprobante();
					$data['listaproveedor']= $this->model_comercial->listaProveedor();
					$data['listasimmon']= $this->model_comercial->listaSimMon();
					$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
					$this->load->view('comercial/menu_script');
					$this->load->view('comercial/menu_cabecera');
					$this->load->view('comercial/comprobantes/registro_ingreso', $data);
			}else{
				$existe = $this->cart->total_items();
				if($existe <= 0){
					if($this->model_comercial->existeTipoCambio() == TRUE){
						$data['tipocambio'] = 0;
					}else{
						$data['tipocambio'] = 1;
					}
					$data['error'] = '<span style="color:red"><b>ERROR:</b> Debe Registrar un Productos como mínimo a la Factura.</span>';
					$data['listaagente']= $this->model_comercial->listaAgenteAduana();
					$data['listaarea']= $this->model_comercial->listarArea();
					$data['listacomprobante']= $this->model_comercial->listaComprobante();
					$data['listaproveedor']= $this->model_comercial->listaProveedor();
					$data['listasimmon']= $this->model_comercial->listaSimMon();
					$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
					$this->load->view('comercial/menu_script');
					$this->load->view('comercial/menu_cabecera');
					$this->load->view('comercial/comprobantes/registro_ingreso', $data);
			    }else{
			    	// Realizar la inserción a la BD
			    	$tipo_comprobante = $this->security->xss_clean($this->input->post("comprobante"));
					$numcomprobante = $this->security->xss_clean($this->input->post("numcomprobante"));
					$seriecomprobante = $this->security->xss_clean($this->input->post("seriecomprobante"));
					$moneda = $this->security->xss_clean($this->input->post("moneda"));
					$nombre_proveedor = $this->security->xss_clean($this->input->post("nombre_proveedor"));
					$fecharegistro = $this->security->xss_clean($this->input->post("fecharegistro"));
					$porcentaje = $this->security->xss_clean($this->input->post("porcent"));
					$id_agente = $this->security->xss_clean($this->input->post("id_agente"));
					$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
					$csigv = $this->security->xss_clean($this->session->userdata('csigv'));
					if ($this->session->userdata('csigv') == "true"){
		                $total = $this->cart->total();
		            }else if ($this->session->userdata('csigv') == "false"){
		                $total = $this->cart->total()+($this->cart->total()*0.18);
		            }
		            // Contenido de la libreria cart
					$carrito = $this->cart->contents();
					// Validar si el ingreso esta en un periodo que ya cerro
					$result_cierre = $this->model_comercial->validarRegistroCierre($fecharegistro);
					if($result_cierre == 'periodo_cerrado'){
						if($this->model_comercial->existeTipoCambio() == TRUE){
							$data['tipocambio'] = 0;
						}else{
							$data['tipocambio'] = 1;
						}
						$data['error_periodo_cerrado'] = '<span style="color:red"><b>!No se puede realizar el registro!</b><br><b>La Fecha seleccionada corresponde a un Periodo de Cierre Anterior</b></span>';
						$data['listaagente']= $this->model_comercial->listaAgenteAduana();
						$data['listaarea']= $this->model_comercial->listarArea();
						$data['listacomprobante']= $this->model_comercial->listaComprobante();
						$data['listaproveedor']= $this->model_comercial->listaProveedor();
						$data['listasimmon']= $this->model_comercial->listaSimMon();
						$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
						$this->load->view('comercial/menu_script');
									$this->load->view('comercial/menu_cabecera');
						$this->load->view('comercial/comprobantes/registro_ingreso', $data);
					}else if($result_cierre == 'successfull'){
						/* Iniciar variable */
						$id_proveedor = "";
						$this->db->select('id_proveedor');
				        $this->db->where('razon_social',$nombre_proveedor);
				        $query = $this->db->get('proveedor');
				        foreach($query->result() as $row){
				            $id_proveedor = $row->id_proveedor;
				        }
				        if($id_proveedor == ""){
				        	if($this->model_comercial->existeTipoCambio() == TRUE){
								$data['tipocambio'] = 0;
							}else{
								$data['tipocambio'] = 1;
							}
							$data['error_nombreProveedor'] = '<span style="color:red"><b>El Proveedor no existe en la Base de Datos</b></span>';
							$data['listaagente']= $this->model_comercial->listaAgenteAduana();
							$data['listaarea']= $this->model_comercial->listarArea();
							$data['listacomprobante']= $this->model_comercial->listaComprobante();
							$data['listaproveedor']= $this->model_comercial->listaProveedor();
							$data['listasimmon']= $this->model_comercial->listaSimMon();
							$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
							$this->load->view('comercial/menu_script');
									$this->load->view('comercial/menu_cabecera');
							$this->load->view('comercial/comprobantes/registro_ingreso', $data);
				        }else{
				        	// Agregamos le registro_ingreso a la bd
							$datos = array(
								"id_comprobante" => $tipo_comprobante,
								"serie_comprobante" => $seriecomprobante,
								"nro_comprobante" => $numcomprobante,
								"fecha" => $fecharegistro,
								"id_moneda" => $moneda,
								"id_proveedor" => $id_proveedor,
								"total" => $total,
								"gastos" => $porcentaje,
								"id_almacen" => $almacen,
								"id_agente" => $id_agente,
								"cs_igv" => $csigv
							);

							$id_ingreso_producto = $this->model_comercial->agrega_ingreso($datos, $seriecomprobante, $numcomprobante, $id_proveedor, $fecharegistro);

							if(!$id_ingreso_producto){
								// Si no se encotnraron datos.
					            if($this->model_comercial->existeTipoCambio() == TRUE){
									$data['tipocambio'] = 0;
								}else{
									$data['tipocambio'] = 1;
								}
								$data['error_tipo_cambio'] = '<span style="color:red"><b>ERROR:</b> No existe un Tipo de Cambio para el día con el que se Registra la Factura.</span>';
								$data['listaagente']= $this->model_comercial->listaAgenteAduana();
								$data['listaarea']= $this->model_comercial->listarArea();
								$data['listacomprobante']= $this->model_comercial->listaComprobante();
								$data['listaproveedor']= $this->model_comercial->listaProveedor();
								$data['listasimmon']= $this->model_comercial->listaSimMon();
								$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
								$this->load->view('comercial/menu_script');
									$this->load->view('comercial/menu_cabecera');
								$this->load->view('comercial/comprobantes/registro_ingreso', $data);
							}else if($id_ingreso_producto == 'actualizacion_registro'){
					            if($this->model_comercial->existeTipoCambio() == TRUE){
									$data['tipocambio'] = 0;
								}else{
									$data['tipocambio'] = 1;
								}
								$data['factura_duplicada'] = 'msg';
								$data['listaagente']= $this->model_comercial->listaAgenteAduana();
								$data['listaarea']= $this->model_comercial->listarArea();
								$data['listacomprobante']= $this->model_comercial->listaComprobante();
								$data['listaproveedor']= $this->model_comercial->listaProveedor();
								$data['listasimmon']= $this->model_comercial->listaSimMon();
								$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
								$this->load->view('comercial/menu_script');
									$this->load->view('comercial/menu_cabecera');
								$this->load->view('comercial/comprobantes/registro_ingreso', $data);
							}else{
								// Agregamos el detalle del comprobante
								$result = $this->model_comercial->agregar_detalle_ingreso($carrito, $id_ingreso_producto, $fecharegistro, $numcomprobante, $seriecomprobante, $porcentaje, $almacen);

								if(!$result){
						            // Si no se encotnraron datos.
						            if($this->model_comercial->existeTipoCambio() == TRUE){
										$data['tipocambio'] = 0;
									}else{
										$data['tipocambio'] = 1;
									}
									$data['error_tipo_cambio'] = '<span style="color:red"><b>ERROR:</b> No existe un Tipo de Cambio para el día con el que se Registra la Factura.</span>';
									$data['listaarea']= $this->model_comercial->listarArea();
									$data['listaagente']= $this->model_comercial->listaAgenteAduana();
									$data['listacomprobante']= $this->model_comercial->listaComprobante();
									$data['listaproveedor']= $this->model_comercial->listaProveedor();
									$data['listasimmon']= $this->model_comercial->listaSimMon();
									$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
									$this->load->view('comercial/menu_script');
									$this->load->view('comercial/menu_cabecera');
									$this->load->view('comercial/comprobantes/registro_ingreso', $data);
						        }else{
						        	$this->cart->destroy();
						        	$this->session->unset_userdata('csigv');
						        	/* Mensaje de confirmacion */
						        	if($this->model_comercial->existeTipoCambio() == TRUE){
										$data['tipocambio'] = 0;
									}else{
										$data['tipocambio'] = 1;
									}
						        	$data['mensaje_registro_correcto'] = '<span style="color:red"><b>ERROR:</b> No existe un Tipo de Cambio para el día con el que se Registra la Factura.</span>';
						        	$data['listaarea']= $this->model_comercial->listarArea();
						        	$data['listaagente']= $this->model_comercial->listaAgenteAduana();
						        	$data['listacomprobante']= $this->model_comercial->listaComprobante();
						        	$data['listaproveedor']= $this->model_comercial->listaProveedor();
						        	$data['listasimmon']= $this->model_comercial->listaSimMon();
						        	$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
						        	$this->load->view('comercial/menu_script');
									$this->load->view('comercial/menu_cabecera');
						        	$this->load->view('comercial/comprobantes/registro_ingreso', $data);
						        	/*
						        	$this->cart->destroy();
						        	$this->session->unset_userdata('csigv');
									redirect('comercial/gestioningreso');
									*/
						        }
							}
				        }
					}
			    }
			}
		}
	}

	public function cuadrar_orden_ingreso()
	{
    	// Realizar la inserción a la BD
		$nombre_producto = $this->security->xss_clean($this->input->post("nombre_producto"));
		$stockactual = $this->security->xss_clean($this->input->post("stockactual"));
		$cantidad = $this->security->xss_clean($this->input->post("cantidad"));
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		// Obtener el id_detalle_producto
		$this->db->select('id_detalle_producto');
        $this->db->where('no_producto',$nombre_producto);
        $query = $this->db->get('detalle_producto');
        if($query->num_rows()>0){
        	foreach($query->result() as $row){
                $id_detalle_producto = $row->id_detalle_producto;
            }
        }
	    // Agregamos le registro_ingreso a la bd
	    $cantidad_ingreso = $cantidad - $stockactual;
	    if($cantidad_ingreso > 0){
			$datos = array(
				"id_detalle_producto" => $id_detalle_producto,
				"cantidad_ingreso" => $cantidad_ingreso,
				"fecha_registro" => date('Y-m-d'),
				"id_almacen" => $almacen
			);
			$id_ingreso_producto = $this->model_comercial->insert_orden_ingreso($datos);

			if($id_ingreso_producto == 'error_inesperado'){
	            echo 'error_inesperado';
			}else{
				// Agregamos el detalle del comprobante
				$result = $this->model_comercial->kardex_orden_ingreso($id_ingreso_producto, $id_detalle_producto, $cantidad_ingreso, $almacen);

				if($result == 'registro_correcto'){
					echo '1';
		        }else{
		        	echo 'error_kardex';
		        }
		    }
	    }else{
	    	echo 'cantidad_negativa';
	    }
	}

	public function cuadrar_producto_almacen(){
		$aux_parametro_cuadre = 0;
		$auxiliar_last_kardex = 0;
		$auxiliar_last_salida = 0;
		$nombre_producto = $this->security->xss_clean($this->input->post('nombre_producto'));
		$area = $this->security->xss_clean($this->input->post('area'));
		$cantidad = $this->security->xss_clean($this->input->post('cantidad'));
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		// Obtengo los datos del producto
		$this->db->select('id_detalle_producto');
        $this->db->where('no_producto',$nombre_producto);
        $query = $this->db->get('detalle_producto');
        foreach($query->result() as $row){
            $id_detalle_producto = $row->id_detalle_producto;
        }
        // Obtengo los datos del producto
		$this->db->select('id_pro');
        $this->db->where('id_detalle_producto',$id_detalle_producto);
        $query = $this->db->get('producto');
        foreach($query->result() as $row){
            $id_pro = $row->id_pro;
        }
        // Generar el ciclo
        do{
        	// Obtener stock del producto - de acuerdo al almacen
        	$this->db->select('stock,precio_unitario,stock_sta_clara');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $query = $this->db->get('detalle_producto');
	        foreach($query->result() as $row){
	        	$stockactual = $row->stock; // Sta. anita
	        	$stock_sta_clara = $row->stock_sta_clara; // Sta. clara
	        	$precio_unitario = $row->precio_unitario;
	        }
	        // Obtener la ultima salida del producto de la tabla salida_producto y kardex_producto
	        // kardex_producto
	        $this->db->select('id_kardex_producto,cantidad_salida,descripcion,fecha_registro');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $this->db->order_by("id_kardex_producto", "asc");
	        $query = $this->db->get('kardex_producto');
	        if(count($query->result()) > 0){
	        	foreach($query->result() as $row){
	        		$auxiliar_last_kardex = $row->id_kardex_producto;
	        		$cantidad_salida_kardex = $row->cantidad_salida;
	        		$descripcion = $row->descripcion;
	        		$fecha_registro = $row->fecha_registro;
	        	}
	        }
	        // salida_producto
	        $this->db->select('id_salida_producto,cantidad_salida,fecha');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $this->db->order_by("id_salida_producto", "asc");
	        $query = $this->db->get('salida_producto');
	        if(count($query->result()) > 0){
	        	foreach($query->result() as $row){
	        		$auxiliar_last_salida = $row->id_salida_producto;
	        		$cantidad_salida_table_salida = $row->cantidad_salida;
	        	}
	        }
	        // Validar a que almacen pertenece
	        if($id_almacen == 2){
		        // El stock del sistema supera al stock fisico
		        if($stockactual > $cantidad){
	        		$unidad_base_salida = $stockactual - $cantidad;
	        		// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
					// tabla salida_producto
					$a_data = array('id_area' => $area,
									'fecha' => date('Y-m-d'),
									'id_detalle_producto' => $id_detalle_producto,
									'cantidad_salida' => $unidad_base_salida,
									'id_almacen' => $id_almacen,
									'p_u_salida' => $precio_unitario,
									);
					$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
					// tabla kardex
					$new_stock = ($stockactual + $stock_sta_clara) - $unidad_base_salida;
					$stock_general = $stockactual + $stock_sta_clara;
					$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
				        	                'descripcion' => "SALIDA",
				        	                'id_detalle_producto' => $id_detalle_producto,
				        	                'stock_anterior' => $stock_general,
				        	                'precio_unitario_anterior' => $precio_unitario,
				        	                'cantidad_salida' => $unidad_base_salida,
				        	                'stock_actual' => $new_stock,
				        	                'precio_unitario_actual' => $precio_unitario,
				        	                'num_comprobante' => $result_insert,
				        	                );
				    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
		    	    // Actualizar stock de acuerdo al cuadre
		    	    // Vuelvo a traer el stock porque lineas arriba ya lo actualice
		    	    $this->db->select('stock');
		            $this->db->where('id_detalle_producto',$id_detalle_producto);
		            $query = $this->db->get('detalle_producto');
		            foreach($query->result() as $row){
		            	$stock_final = $row->stock;
		            }
		            // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
		            $this->model_comercial->descontarStock($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
		    	    // Enviar parametro para terminar bucle
		    		$aux_parametro_cuadre = 1;
		    		echo '1';
	    		}else if($cantidad_salida_kardex == $cantidad_salida_table_salida && $descripcion == 'SALIDA'){ // Validacion de cantidad de salida 
		        	// El stock fisico supera el stock del sistema
		        	if($stockactual < $cantidad){
		        		// Eliminar las salidas necesarias para recuperar el stock del producto
		        		// Validando que no se pase del stock que se necesita como cuadre
		        		$stock_actualizado = $stockactual + $cantidad_salida_kardex; // unidades final del producto
		        		if($stock_actualizado == $cantidad){
		        			// Eliminar salida // registro del kardex // actualizar stock
		        			$this->model_comercial->descontarStock_regresarstock($id_detalle_producto,$cantidad,$stock_actualizado,$id_almacen);
		        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
							$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
							$aux_parametro_cuadre = 1;
							echo '1';
		        		}else if($stock_actualizado > $cantidad){
		        			$unidad_base_salida = $cantidad - $stockactual;
		        			$unidad_base_salida = $cantidad_salida_kardex - $unidad_base_salida;
		        			// Eliminar salida // registro del kardex // actualizar stock
		        			$this->model_comercial->descontarStock_regresarstock($id_detalle_producto,$cantidad,$stock_actualizado,$id_almacen);
		        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
							$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
							// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
							// tabla salida_producto
							$a_data = array('id_area' => $area,
											'fecha' => date('Y-m-d'),
											'id_detalle_producto' => $id_detalle_producto,
											'cantidad_salida' => $unidad_base_salida,
											'id_almacen' => $id_almacen,
											'p_u_salida' => $precio_unitario,
											);
							$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
							// tabla kardex
							$new_stock = ($stock_actualizado + $stock_sta_clara) - $unidad_base_salida;
							$stock_general = $stock_actualizado + $stock_sta_clara;
							$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
						        	                'descripcion' => "SALIDA",
						        	                'id_detalle_producto' => $id_detalle_producto,
						        	                'stock_anterior' => $stock_general,
						        	                'precio_unitario_anterior' => $precio_unitario,
						        	                'cantidad_salida' => $unidad_base_salida,
						        	                'stock_actual' => $new_stock,
						        	                'precio_unitario_actual' => $precio_unitario,
						        	                'num_comprobante' => $result_insert,
						        	                );
						    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
						    // Actualizar stock de acuerdo al cuadre
						    // Vuelvo a traer el stock porque lineas arriba ya lo actualice
						    $this->db->select('stock');
					        $this->db->where('id_detalle_producto',$id_detalle_producto);
					        $query = $this->db->get('detalle_producto');
					        foreach($query->result() as $row){
					        	$stock_final = $row->stock;
					        }
					        // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
					        $this->model_comercial->descontarStock($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
						    // Enviar parametro para terminar bucle
							$aux_parametro_cuadre = 1;
							echo '1';
		        		}else if($stock_actualizado < $cantidad){
		        			// Eliminar salida // registro del kardex // actualizar stock
		        			$this->model_comercial->descontarStock_regresarstock($id_detalle_producto,$cantidad,$stock_actualizado,$id_almacen);
		        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
							$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
		        		}
		        	}
		        }else{
		        	echo 'cantidad_erronea_salidas';
		        	die();
		        }
	        }else if($id_almacen == 1){
	        	// El stock del sistema supera al stock fisico
		        if($stock_sta_clara > $cantidad){
	        		$unidad_base_salida = $stock_sta_clara - $cantidad;
	        		// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
					// tabla salida_producto
					$a_data = array('id_area' => $area,
									'fecha' => date('Y-m-d'),
									'id_detalle_producto' => $id_detalle_producto,
									'cantidad_salida' => $unidad_base_salida,
									'id_almacen' => $id_almacen,
									'p_u_salida' => $precio_unitario,
									);
					$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
					// tabla kardex
					$new_stock = ($stockactual + $stock_sta_clara) - $unidad_base_salida;
					$stock_general = $stockactual + $stock_sta_clara;
					$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
				        	                'descripcion' => "SALIDA",
				        	                'id_detalle_producto' => $id_detalle_producto,
				        	                'stock_anterior' => $stock_general,
				        	                'precio_unitario_anterior' => $precio_unitario,
				        	                'cantidad_salida' => $unidad_base_salida,
				        	                'stock_actual' => $new_stock,
				        	                'precio_unitario_actual' => $precio_unitario,
				        	                'num_comprobante' => $result_insert,
				        	                );
				    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
		    	    // Actualizar stock de acuerdo al cuadre
		    	    // Vuelvo a traer el stock porque lineas arriba ya lo actualice
		    	    $this->db->select('stock_sta_clara');
		            $this->db->where('id_detalle_producto',$id_detalle_producto);
		            $query = $this->db->get('detalle_producto');
		            foreach($query->result() as $row){
		            	$stock_final = $row->stock_sta_clara;
		            }
		            // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
		            $this->model_comercial->descontarStock($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
		    	    // Enviar parametro para terminar bucle
		    		$aux_parametro_cuadre = 1;
		    		echo '1';
	    		}else if($cantidad_salida_kardex == $cantidad_salida_table_salida && $descripcion == 'SALIDA'){ // Validacion de cantidad de salida 
		        	// El stock fisico supera el stock del sistema
		        	if($stock_sta_clara < $cantidad){
		        		// Eliminar las salidas necesarias para recuperar el stock del producto
		        		// Validando que no se pase del stock que se necesita como cuadre
		        		$stock_actualizado = $stock_sta_clara + $cantidad_salida_kardex; // unidades final del producto
		        		if($stock_actualizado == $cantidad){
		        			// Eliminar salida // registro del kardex // actualizar stock
		        			$this->model_comercial->descontarStock_regresarstock($id_detalle_producto,$cantidad,$stock_actualizado,$id_almacen);
		        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
							$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
							//$this->model_comercial->actualizar_saldos_iniciales_cuadre($fecha_registro,$id_pro,$stock_actualizado,$id_almacen);
							$aux_parametro_cuadre = 1;
							echo '1';
		        		}else if($stock_actualizado > $cantidad){
		        			$unidad_base_salida = $cantidad - $stock_sta_clara;
		        			$unidad_base_salida = $cantidad_salida_kardex - $unidad_base_salida;
		        			//$stock_para_cuadre = $cantidad_salida_table_salida - $unidad_base_salida;
		        			// Eliminar salida // registro del kardex // actualizar stock
		        			$this->model_comercial->descontarStock_regresarstock($id_detalle_producto,$cantidad,$stock_actualizado,$id_almacen);
		        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
							$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
							//$this->model_comercial->actualizar_saldos_iniciales_cuadre($fecha_registro,$id_pro,$cantidad,$id_almacen);
							// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
							// tabla salida_producto
							$a_data = array('id_area' => $area,
											'fecha' => date('Y-m-d'),
											'id_detalle_producto' => $id_detalle_producto,
											'cantidad_salida' => $unidad_base_salida,
											'id_almacen' => $id_almacen,
											'p_u_salida' => $precio_unitario,
											);
							$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
							// tabla kardex
							$new_stock = ($stock_actualizado + $stockactual) - $unidad_base_salida;
							$stock_general = $stock_actualizado + $stockactual;
							$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
						        	                'descripcion' => "SALIDA",
						        	                'id_detalle_producto' => $id_detalle_producto,
						        	                'stock_anterior' => $stock_general,
						        	                'precio_unitario_anterior' => $precio_unitario,
						        	                'cantidad_salida' => $unidad_base_salida,
						        	                'stock_actual' => $new_stock,
						        	                'precio_unitario_actual' => $precio_unitario,
						        	                'num_comprobante' => $result_insert,
						        	                );
						    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
						    // Actualizar stock de acuerdo al cuadre
						    // Vuelvo a traer el stock porque lineas arriba ya lo actualice
						    $this->db->select('stock,stock_sta_clara');
					        $this->db->where('id_detalle_producto',$id_detalle_producto);
					        $query = $this->db->get('detalle_producto');
					        foreach($query->result() as $row){
					        	$stock_final = $row->stock_sta_clara;
					        }
					        // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
					        $this->model_comercial->descontarStock($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
						    // Enviar parametro para terminar bucle
							$aux_parametro_cuadre = 1;
							echo '1';
		        		}else if($stock_actualizado < $cantidad){
		        			// Eliminar salida // registro del kardex // actualizar stock
		        			$this->model_comercial->descontarStock_regresarstock($id_detalle_producto,$cantidad,$stock_actualizado,$id_almacen);
		        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
							$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
							//$this->model_comercial->actualizar_saldos_iniciales_cuadre($fecha_registro,$id_pro,$stock_actualizado,$id_almacen);
		        		}
		        	}
		        }else{
		        	echo 'cantidad_erronea_salidas';
		        	die();
		        }
	        }
	    }while($aux_parametro_cuadre == 0);

	}

	public function cuadrar_producto_area_almacen_version_inicial(){
		$aux_parametro_cuadre = 0;
		$auxiliar_last_kardex = 0;
		$auxiliar_last_salida = 0;
		$nombre_producto = $this->security->xss_clean($this->input->post('nombre_producto'));
		$area = $this->security->xss_clean($this->input->post('area'));
		$cantidad = $this->security->xss_clean($this->input->post('cantidad'));
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		// Obtengo los datos del producto
		$this->db->select('id_detalle_producto');
        $this->db->where('no_producto',$nombre_producto);
        $query = $this->db->get('detalle_producto');
        foreach($query->result() as $row){
            $id_detalle_producto = $row->id_detalle_producto;
        }
        // Obtengo los datos del producto
		$this->db->select('id_pro');
        $this->db->where('id_detalle_producto',$id_detalle_producto);
        $query = $this->db->get('producto');
        foreach($query->result() as $row){
            $id_pro = $row->id_pro;
        }
        // Generar el ciclo
        do{
        	$suma_stock_producto_areas = 0;
        	// Obtener stock del general del producto - de acuerdo al almacen
        	$this->db->select('stock,precio_unitario,stock_sta_clara');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $query = $this->db->get('detalle_producto');
	        foreach($query->result() as $row){
	        	$stockactual = $row->stock; // Sta. anita
	        	$stock_sta_clara = $row->stock_sta_clara; // Sta. clara
	        	$precio_unitario = $row->precio_unitario;
	        }
	        // Obtener la ultima salida del producto de la tabla salida_producto y kardex_producto
	        // kardex_producto
	        $this->db->select('id_kardex_producto,cantidad_salida,descripcion,fecha_registro');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $this->db->order_by("id_kardex_producto", "asc");
	        $query = $this->db->get('kardex_producto');
	        if(count($query->result()) > 0){
	        	foreach($query->result() as $row){
	        		$auxiliar_last_kardex = $row->id_kardex_producto;
	        		$cantidad_salida_kardex = $row->cantidad_salida;
	        		$descripcion = $row->descripcion;
	        		$fecha_registro = $row->fecha_registro;
	        	}
	        }
	        // salida_producto
	        $this->db->select('id_salida_producto,cantidad_salida,fecha');
	        $this->db->where('id_detalle_producto',$id_detalle_producto);
	        $this->db->order_by("id_salida_producto", "asc");
	        $query = $this->db->get('salida_producto');
	        if(count($query->result()) > 0){
	        	foreach($query->result() as $row){
	        		$auxiliar_last_salida = $row->id_salida_producto;
	        		$cantidad_salida_table_salida = $row->cantidad_salida;
	        	}
	        }else{
	        	$auxiliar_last_salida = "";
	        	$cantidad_salida_table_salida = "";
	        }
	        // Validar a que almacen pertenece
	        if($id_almacen == 1){
	        	// Actualizar stock del producto por area
	        	$result_update = $this->model_comercial->actualizar_stock_producto_area($id_pro,$area,$id_almacen,$cantidad);
	        	// Obtener la suma total de stock del producto distribuido en areas ya actualizado
	        	$this->db->select('stock_area_sta_clara');
	        	$this->db->where('id_pro',$id_pro);
	        	$query = $this->db->get('detalle_producto_area');
	        	foreach($query->result() as $row){
	        	    $suma_stock_producto_areas = $suma_stock_producto_areas + $row->stock_area_sta_clara;
	        	}
	        	// Hasta aca solo se ha actualizado el stock del producto por area
	        	if($result_update){
			        // El stock del sistema supera al stock fisico
			        if($stock_sta_clara == $suma_stock_producto_areas){
			        	$aux_parametro_cuadre = 1;
		    			echo '1';
			        }else if($stock_sta_clara > $suma_stock_producto_areas){
		        		$unidad_base_salida = $stock_sta_clara - $suma_stock_producto_areas;
		        		// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
						// tabla salida_producto
						$a_data = array('id_area' => $area,
										'fecha' => date('Y-m-d'),
										'id_detalle_producto' => $id_detalle_producto,
										'cantidad_salida' => $unidad_base_salida,
										'id_almacen' => $id_almacen,
										'p_u_salida' => $precio_unitario,
										);
						$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
						// tabla kardex
						$new_stock = ($stockactual + $stock_sta_clara) - $unidad_base_salida;
						$stock_general = $stockactual + $stock_sta_clara;
						$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
					        	                'descripcion' => "SALIDA",
					        	                'id_detalle_producto' => $id_detalle_producto,
					        	                'stock_anterior' => $stock_general,
					        	                'precio_unitario_anterior' => $precio_unitario,
					        	                'cantidad_salida' => $unidad_base_salida,
					        	                'stock_actual' => $new_stock,
					        	                'precio_unitario_actual' => $precio_unitario,
					        	                'num_comprobante' => $result_insert,
					        	                );
					    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
			    	    // Actualizar stock de acuerdo al cuadre
			    	    // Vuelvo a traer el stock porque lineas arriba ya lo actualice
			    	    $this->db->select('stock_sta_clara');
			            $this->db->where('id_detalle_producto',$id_detalle_producto);
			            $query = $this->db->get('detalle_producto');
			            foreach($query->result() as $row){
			            	$stock_final = $row->stock_sta_clara;
			            }
			            // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
			            $this->model_comercial->descontarStock_general($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
			    	    // Enviar parametro para terminar bucle
			    		$aux_parametro_cuadre = 1;
			    		echo '1';
		    		}else if($cantidad_salida_kardex == $cantidad_salida_table_salida && $descripcion == 'SALIDA'){ // Validacion de cantidad de salida
		    			// El stock fisico supera el stock del sistema
		    			if($stock_sta_clara < $suma_stock_producto_areas){
		    				// Eliminar las salidas necesarias para recuperar el stock del producto
		    				// Validando que no se pase del stock que se necesita como cuadre
		    				$stock_actualizado = $stock_sta_clara + $cantidad_salida_kardex; // unidades final del producto
		    				if($stock_actualizado == $suma_stock_producto_areas){
		    					// Eliminar salida // registro del kardex // actualizar stock
		    					$this->model_comercial->update_stock_general_cuadre($id_detalle_producto,$stock_actualizado,$id_almacen);
		    					$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
								$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
								$aux_parametro_cuadre = 1;
								echo '1';
		    				}else if($stock_actualizado > $suma_stock_producto_areas){
		    					$unidad_base_salida = $stock_actualizado - $suma_stock_producto_areas;
		    					//$unidad_base_salida = $cantidad_salida_kardex - $unidad_base_salida;
		    					// Eliminar salida // registro del kardex // actualizar stock
		    					$this->model_comercial->update_stock_general_cuadre($id_detalle_producto,$stock_actualizado,$id_almacen);
		    					$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
								$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
								// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
								// tabla salida_producto
								$a_data = array('id_area' => $area,
												'fecha' => date('Y-m-d'),
												'id_detalle_producto' => $id_detalle_producto,
												'cantidad_salida' => $unidad_base_salida,
												'id_almacen' => $id_almacen,
												'p_u_salida' => $precio_unitario,
												);
								$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
								// tabla kardex
								$new_stock = ($stock_actualizado + $stockactual) - $unidad_base_salida;
								$stock_general = $stock_actualizado + $stockactual;
								$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
							        	                'descripcion' => "SALIDA",
							        	                'id_detalle_producto' => $id_detalle_producto,
							        	                'stock_anterior' => $stock_general,
							        	                'precio_unitario_anterior' => $precio_unitario,
							        	                'cantidad_salida' => $unidad_base_salida,
							        	                'stock_actual' => $new_stock,
							        	                'precio_unitario_actual' => $precio_unitario,
							        	                'num_comprobante' => $result_insert,
							        	                );
							    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
					    	    // Actualizar stock de acuerdo al cuadre
					    	    // Vuelvo a traer el stock porque lineas arriba ya lo actualice
					    	    $this->db->select('stock_sta_clara');
					            $this->db->where('id_detalle_producto',$id_detalle_producto);
					            $query = $this->db->get('detalle_producto');
					            foreach($query->result() as $row){
					            	$stock_final = $row->stock_sta_clara;
					            }
			                    // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
			                    $this->model_comercial->descontarStock_general($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
			            	    // Enviar parametro para terminar bucle
			            		$aux_parametro_cuadre = 1;
			            		echo '1';
		    				}else if($stock_actualizado < $suma_stock_producto_areas){
			        			// Eliminar salida // registro del kardex // actualizar stock
			        			$this->model_comercial->update_stock_general_cuadre($id_detalle_producto,$stock_actualizado,$id_almacen);
			        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
								$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
			        		}
		    			}else{
		    				echo 'cantidad_erronea_salidas';
		    				$aux_parametro_cuadre = 1;
		    			}
		    		}else if(($descripcion == 'ENTRADA') && ($stock_sta_clara < $suma_stock_producto_areas)){
		    			$cantidad_ingreso = $suma_stock_producto_areas - $stock_sta_clara;
		    			if($cantidad_ingreso > 0){
		    				$datos = array(
								"id_detalle_producto" => $id_detalle_producto,
								"cantidad_ingreso" => $cantidad_ingreso,
								"fecha_registro" => date('Y-m-d'),
								"id_almacen" => $id_almacen
							);
							$id_ingreso_producto = $this->model_comercial->insert_orden_ingreso($datos);
							if($id_ingreso_producto == 'error_inesperado'){
					            echo 'error_inesperado';
					            $aux_parametro_cuadre = 1;
							}else{
								// Agregamos el detalle del comprobante
								$result = $this->model_comercial->kardex_orden_ingreso($id_ingreso_producto, $id_detalle_producto, $cantidad_ingreso, $id_almacen);
								if($result == 'registro_correcto'){
									$aux_parametro_cuadre = 1;
									echo '1';
						        }else{
						        	echo 'error_kardex';
						        	$aux_parametro_cuadre = 1;
						        }
							}
		    			}else{
					    	echo 'cantidad_negativa';
					    	$aux_parametro_cuadre = 1;
					    }
		    		}
				}
	        }else if($id_almacen == 2){
	        	// Actualizar stock del producto por area
	        	// La cantidad ingresada por el usuario se envia directamente al campo de la tabla
	        	$result_update = $this->model_comercial->actualizar_stock_producto_area($id_pro,$area,$id_almacen,$cantidad);
	        	// Obtener la suma total de stock del producto distribuido en areas ya actualizado
	        	$this->db->select('stock_area_sta_anita');
	        	$this->db->where('id_pro',$id_pro);
	        	$query = $this->db->get('detalle_producto_area');
	        	foreach($query->result() as $row){
	        	    $suma_stock_producto_areas = $suma_stock_producto_areas + $row->stock_area_sta_anita;
	        	}
	        	// Hasta aca solo se ha actualizado el stock del producto por area
        		if($result_update){
        			// El stock del sistema supera al stock fisico
        			if($stockactual > $suma_stock_producto_areas){
        				var_dump('El stock del sistema supera al stock fisico');
		        		$unidad_base_salida = $stockactual - $suma_stock_producto_areas;
		        		// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
						// tabla salida_producto
						$a_data = array('id_area' => $area,
										'fecha' => date('Y-m-d'),
										'id_detalle_producto' => $id_detalle_producto,
										'cantidad_salida' => $unidad_base_salida,
										'id_almacen' => $id_almacen,
										'p_u_salida' => $precio_unitario,
										);
						$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
						// tabla kardex
						$new_stock = ($stockactual + $stock_sta_clara) - $unidad_base_salida;
						$stock_general = $stockactual + $stock_sta_clara;
						$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
					        	                'descripcion' => "SALIDA",
					        	                'id_detalle_producto' => $id_detalle_producto,
					        	                'stock_anterior' => $stock_general,
					        	                'precio_unitario_anterior' => $precio_unitario,
					        	                'cantidad_salida' => $unidad_base_salida,
					        	                'stock_actual' => $new_stock,
					        	                'precio_unitario_actual' => $precio_unitario,
					        	                'num_comprobante' => $result_insert,
					        	                );
					    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
					    // Actualizar stock de acuerdo al cuadre
		    	    	// Vuelvo a traer el stock porque lineas arriba ya lo actualice
		    	    	$this->db->select('stock');
			            $this->db->where('id_detalle_producto',$id_detalle_producto);
			            $query = $this->db->get('detalle_producto');
			            foreach($query->result() as $row){
			            	$stock_final = $row->stock;
			            }
			            // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
			            $this->model_comercial->descontarStock_general($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
			    	    // Enviar parametro para terminar bucle
			    		$aux_parametro_cuadre = 1;
			    		echo '1';
        			}else if($cantidad_salida_kardex == $cantidad_salida_table_salida && $descripcion == 'SALIDA'){ // Validacion de cantidad de salida
        				// El stock fisico supera el stock del sistema
        				if($stockactual < $suma_stock_producto_areas){
        					// Eliminar las salidas necesarias para recuperar el stock del producto
	    					// Validando que no se pase del stock que se necesita como cuadre
	    					$stock_actualizado = $stockactual + $cantidad_salida_kardex; // unidades final del producto
	    					if($stock_actualizado == $suma_stock_producto_areas){
		    					// Eliminar salida // registro del kardex // actualizar stock
		    					$this->model_comercial->update_stock_general_cuadre($id_detalle_producto,$stock_actualizado,$id_almacen);
		    					$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
								$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
								$aux_parametro_cuadre = 1;
								echo '1';
		    				}else if($stock_actualizado > $suma_stock_producto_areas){
		    					$unidad_base_salida = $stock_actualizado - $suma_stock_producto_areas;
	    						// $unidad_base_salida = $cantidad_salida_kardex - $unidad_base_salida;
	    						// Eliminar salida // registro del kardex // actualizar stock
		    					$this->model_comercial->update_stock_general_cuadre($id_detalle_producto,$stock_actualizado,$id_almacen);
		    					$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
								$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
								// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
								// tabla salida_producto
								$a_data = array('id_area' => $area,
												'fecha' => date('Y-m-d'),
												'id_detalle_producto' => $id_detalle_producto,
												'cantidad_salida' => $unidad_base_salida,
												'id_almacen' => $id_almacen,
												'p_u_salida' => $precio_unitario,
												);
								$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
								// tabla kardex
								$new_stock = ($stock_actualizado + $stock_sta_clara) - $unidad_base_salida;
								$stock_general = $stock_actualizado + $stock_sta_clara;
								$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
							        	                'descripcion' => "SALIDA",
							        	                'id_detalle_producto' => $id_detalle_producto,
							        	                'stock_anterior' => $stock_general,
							        	                'precio_unitario_anterior' => $precio_unitario,
							        	                'cantidad_salida' => $unidad_base_salida,
							        	                'stock_actual' => $new_stock,
							        	                'precio_unitario_actual' => $precio_unitario,
							        	                'num_comprobante' => $result_insert,
							        	                );
							    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
							    // Actualizar stock de acuerdo al cuadre
				    	    	// Vuelvo a traer el stock porque lineas arriba ya lo actualice
				    	    	$this->db->select('stock');
					            $this->db->where('id_detalle_producto',$id_detalle_producto);
					            $query = $this->db->get('detalle_producto');
					            foreach($query->result() as $row){
					            	$stock_final = $row->stock;
					            }
					            // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
			                    $this->model_comercial->descontarStock_general($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
			            	    // Enviar parametro para terminar bucle
			            		$aux_parametro_cuadre = 1;
			            		echo '1';
		    				}else if($stock_actualizado < $suma_stock_producto_areas){
			        			// Eliminar salida // registro del kardex // actualizar stock
			        			$this->model_comercial->update_stock_general_cuadre($id_detalle_producto,$stock_actualizado,$id_almacen);
			        			$this->model_comercial->eliminar_insert_kardex($auxiliar_last_kardex);
								$this->model_comercial->eliminar_insert_salida($auxiliar_last_salida);
			        		}
		    			}else{
		    				echo 'cantidad_erronea_salidas';
		    				$aux_parametro_cuadre = 1;
		    			}
        			}else if(($descripcion == 'ENTRADA') && ($stockactual < $suma_stock_producto_areas)){
		    			$cantidad_ingreso = $suma_stock_producto_areas - $stockactual;
		    			if($cantidad_ingreso > 0){
		    				$datos = array(
								"id_detalle_producto" => $id_detalle_producto,
								"cantidad_ingreso" => $cantidad_ingreso,
								"fecha_registro" => date('Y-m-d'),
								"id_almacen" => $id_almacen
							);
							$id_ingreso_producto = $this->model_comercial->insert_orden_ingreso($datos);
							if($id_ingreso_producto == 'error_inesperado'){
					            echo 'error_inesperado';
					            $aux_parametro_cuadre = 1;
							}else{
								// Agregamos el detalle del comprobante
								$result = $this->model_comercial->kardex_orden_ingreso($id_ingreso_producto, $id_detalle_producto, $cantidad_ingreso, $id_almacen);
								if($result == 'registro_correcto'){
									$aux_parametro_cuadre = 1;
									echo '1';
						        }else{
						        	echo 'error_kardex';
						        	$aux_parametro_cuadre = 1;
						        }
							}
		    			}else{
					    	echo 'cantidad_negativa';
					    	$aux_parametro_cuadre = 1;
					    }
		    		}else{
		    			$aux_parametro_cuadre = 1;
		    			echo '1';
		    		}
        		}
	        }
        }while($aux_parametro_cuadre == 0);
	}

	public function cuadrar_producto_area_almacen(){
		$aux_parametro_cuadre = 0;
		$auxiliar_last_kardex = 0;
		$auxiliar_last_salida = 0;
		$nombre_producto = $this->security->xss_clean($this->input->post('nombre_producto'));
		$area = $this->security->xss_clean($this->input->post('area'));
		$cantidad = $this->security->xss_clean($this->input->post('cantidad'));
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		// Obtengo los datos del producto
		$this->db->select('id_detalle_producto,stock,stock_sta_clara,precio_unitario');
        $this->db->where('no_producto',$nombre_producto);
        $query = $this->db->get('detalle_producto');
        foreach($query->result() as $row){
            $id_detalle_producto = $row->id_detalle_producto;
            $stock_sta_anita = $row->stock;
            $stock_sta_clara = $row->stock_sta_clara;
            $precio_unitario = $row->precio_unitario;
        }

        // validar si tiene movimientos en el kardex
        $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex_eliminar($id_detalle_producto);
        $existe = count($detalle_movimientos_kardex);

        if(($stock_sta_anita == 0 && $stock_sta_clara == 0 && $precio_unitario == NULL) && ($existe == 0)){
        	echo 'stock_precio_cero';
        }else{
			// echo $id_detalle_producto;
			// Obtengo los datos del producto
			$this->db->select('id_pro');
			$this->db->where('id_detalle_producto',$id_detalle_producto);
			$query = $this->db->get('producto');
			foreach($query->result() as $row){
			    $id_pro = $row->id_pro;
			}
			// Generar el ciclo

			do{
				$suma_stock_producto_areas = 0;
				// Obtener stock del general del producto - de acuerdo al almacen
				$this->db->select('stock,precio_unitario,stock_sta_clara');
			    $this->db->where('id_detalle_producto',$id_detalle_producto);
			    $query = $this->db->get('detalle_producto');
			    foreach($query->result() as $row){
			    	$stockactual = $row->stock; // Sta. anita
			    	$stock_sta_clara = $row->stock_sta_clara; // Sta. clara
			    	$precio_unitario = $row->precio_unitario;
			    }
			    // Obtener la ultima salida del producto de la tabla salida_producto y kardex_producto
			    // kardex_producto
			    $this->db->select('id_kardex_producto,cantidad_salida,descripcion,fecha_registro');
			    $this->db->where('id_detalle_producto',$id_detalle_producto);
			    $this->db->order_by("id_kardex_producto", "asc");
			    $query = $this->db->get('kardex_producto');
			    if(count($query->result()) > 0){
			    	foreach($query->result() as $row){
			    		$auxiliar_last_kardex = $row->id_kardex_producto;
			    		$cantidad_salida_kardex = $row->cantidad_salida;
			    		$descripcion = $row->descripcion;
			    		$fecha_registro = $row->fecha_registro;
			    	}
			    }
			    // salida_producto
			    $this->db->select('id_salida_producto,cantidad_salida,fecha');
			    $this->db->where('id_detalle_producto',$id_detalle_producto);
			    $this->db->order_by("id_salida_producto", "asc");
			    $query = $this->db->get('salida_producto');
			    if(count($query->result()) > 0){
			    	foreach($query->result() as $row){
			    		$auxiliar_last_salida = $row->id_salida_producto;
			    		$cantidad_salida_table_salida = $row->cantidad_salida;
			    	}
			    }else{
			    	$auxiliar_last_salida = "";
			    	$cantidad_salida_table_salida = "";
			    }
			    // Validar a que almacen pertenece
			    if($id_almacen == 1){
			    	// Actualizar stock del producto por area
			    	$result_update = $this->model_comercial->actualizar_stock_producto_area($id_pro,$area,$id_almacen,$cantidad);
			    	// Obtener la suma total de stock del producto distribuido en areas ya actualizado
			    	$this->db->select('stock_area_sta_clara');
			    	$this->db->where('id_pro',$id_pro);
			    	$query = $this->db->get('detalle_producto_area');
			    	foreach($query->result() as $row){
			    	    $suma_stock_producto_areas = $suma_stock_producto_areas + $row->stock_area_sta_clara;
			    	}
			    	// Hasta aca solo se ha actualizado el stock del producto por area
			    	if($result_update){
				        // El stock del sistema supera al stock fisico
				        if($stock_sta_clara == $suma_stock_producto_areas){
				        	$aux_parametro_cuadre = 1;
			    			echo '1';
				        }else if($stock_sta_clara > $suma_stock_producto_areas){
			        		$unidad_base_salida = $stock_sta_clara - $suma_stock_producto_areas;
			        		// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
							// tabla salida_producto
							$a_data = array('id_area' => $area,
											'fecha' => date('Y-m-d'),
											'id_detalle_producto' => $id_detalle_producto,
											'cantidad_salida' => $unidad_base_salida,
											'id_almacen' => $id_almacen,
											'p_u_salida' => $precio_unitario,
											);
							$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
							// tabla kardex
							$new_stock = ($stockactual + $stock_sta_clara) - $unidad_base_salida;
							$stock_general = $stockactual + $stock_sta_clara;
							$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
						        	                'descripcion' => "SALIDA",
						        	                'id_detalle_producto' => $id_detalle_producto,
						        	                'stock_anterior' => $stock_general,
						        	                'precio_unitario_anterior' => $precio_unitario,
						        	                'cantidad_salida' => $unidad_base_salida,
						        	                'stock_actual' => $new_stock,
						        	                'precio_unitario_actual' => $precio_unitario,
						        	                'num_comprobante' => $result_insert,
						        	                );
						    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
				    	    // Actualizar stock de acuerdo al cuadre
				    	    // Vuelvo a traer el stock porque lineas arriba ya lo actualice
				    	    $this->db->select('stock_sta_clara');
				            $this->db->where('id_detalle_producto',$id_detalle_producto);
				            $query = $this->db->get('detalle_producto');
				            foreach($query->result() as $row){
				            	$stock_final = $row->stock_sta_clara;
				            }
				            // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
				            $this->model_comercial->descontarStock_general($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
				    	    // Enviar parametro para terminar bucle
				    		$aux_parametro_cuadre = 1;
				    		echo '1';
			    		}else if($stock_sta_clara < $suma_stock_producto_areas){
			    			$cantidad_ingreso = $suma_stock_producto_areas - $stock_sta_clara;
			    			if($cantidad_ingreso > 0){
			    				$datos = array(
									"id_detalle_producto" => $id_detalle_producto,
									"cantidad_ingreso" => $cantidad_ingreso,
									"fecha_registro" => date('Y-m-d'),
									"id_almacen" => $id_almacen
								);
								$id_ingreso_producto = $this->model_comercial->insert_orden_ingreso($datos);
								if($id_ingreso_producto == 'error_inesperado'){
						            echo 'error_inesperado';
						            $aux_parametro_cuadre = 1;
								}else{
									// Agregamos el detalle del comprobante
									$result = $this->model_comercial->kardex_orden_ingreso($id_ingreso_producto, $id_detalle_producto, $cantidad_ingreso, $id_almacen);
									if($result == 'registro_correcto'){
										$aux_parametro_cuadre = 1;
										echo '1';
							        }else{
							        	echo 'error_kardex';
							        	$aux_parametro_cuadre = 1;
							        }
								}
			    			}else{
						    	echo 'cantidad_negativa';
						    	$aux_parametro_cuadre = 1;
						    }
			    		}
					}
			    }else if($id_almacen == 2){
			    	// Actualizar stock del producto por area
			    	// La cantidad ingresada por el usuario se envia directamente al campo de la tabla
			    	$result_update = $this->model_comercial->actualizar_stock_producto_area($id_pro,$area,$id_almacen,$cantidad);
			    	// Obtener la suma total de stock del producto distribuido en areas ya actualizado
			    	$this->db->select('stock_area_sta_anita');
			    	$this->db->where('id_pro',$id_pro);
			    	$query = $this->db->get('detalle_producto_area');
			    	foreach($query->result() as $row){
			    	    $suma_stock_producto_areas = $suma_stock_producto_areas + $row->stock_area_sta_anita;
			    	}
			    	// Hasta aca solo se ha actualizado el stock del producto por area
					if($result_update){
						// El stock del sistema supera al stock fisico
						if($stockactual == $suma_stock_producto_areas){
				        	$aux_parametro_cuadre = 1;
			    			echo '1';
				        }else if($stockactual > $suma_stock_producto_areas){
			        		$unidad_base_salida = $stockactual - $suma_stock_producto_areas;
			        		// Realizar la salida con la cantidad necesaria para cuadrar el producto en el almacen
							// tabla salida_producto
							$a_data = array('id_area' => $area,
											'fecha' => date('Y-m-d'),
											'id_detalle_producto' => $id_detalle_producto,
											'cantidad_salida' => $unidad_base_salida,
											'id_almacen' => $id_almacen,
											'p_u_salida' => $precio_unitario,
											);
							$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
							// tabla kardex
							$new_stock = ($stockactual + $stock_sta_clara) - $unidad_base_salida;
							$stock_general = $stockactual + $stock_sta_clara;
							$a_data_kardex = array('fecha_registro' => date('Y-m-d'),
						        	                'descripcion' => "SALIDA",
						        	                'id_detalle_producto' => $id_detalle_producto,
						        	                'stock_anterior' => $stock_general,
						        	                'precio_unitario_anterior' => $precio_unitario,
						        	                'cantidad_salida' => $unidad_base_salida,
						        	                'stock_actual' => $new_stock,
						        	                'precio_unitario_actual' => $precio_unitario,
						        	                'num_comprobante' => $result_insert,
						        	                );
						    $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
						    // Actualizar stock de acuerdo al cuadre
			    	    	// Vuelvo a traer el stock porque lineas arriba ya lo actualice
			    	    	$this->db->select('stock');
				            $this->db->where('id_detalle_producto',$id_detalle_producto);
				            $query = $this->db->get('detalle_producto');
				            foreach($query->result() as $row){
				            	$stock_final = $row->stock;
				            }
				            // Descontar stock - el nuevo stock debe ser de acuerdo al valor de cuadre
				            $this->model_comercial->descontarStock_general($id_detalle_producto,$unidad_base_salida,$stock_final,$id_almacen);
				    	    // Enviar parametro para terminar bucle
				    		$aux_parametro_cuadre = 1;
				    		echo '1';
						}else if($stockactual < $suma_stock_producto_areas){
			    			$cantidad_ingreso = $suma_stock_producto_areas - $stockactual;
			    			if($cantidad_ingreso > 0){
			    				$datos = array(
									"id_detalle_producto" => $id_detalle_producto,
									"cantidad_ingreso" => $cantidad_ingreso,
									"fecha_registro" => date('Y-m-d'),
									"id_almacen" => $id_almacen
								);
								$id_ingreso_producto = $this->model_comercial->insert_orden_ingreso($datos);
								if($id_ingreso_producto == 'error_inesperado'){
						            echo 'error_inesperado';
						            $aux_parametro_cuadre = 1;
								}else{
									// Agregamos el detalle del comprobante
									$result = $this->model_comercial->kardex_orden_ingreso($id_ingreso_producto, $id_detalle_producto, $cantidad_ingreso, $id_almacen);
									if($result == 'registro_correcto'){
										$aux_parametro_cuadre = 1;
										echo '1';
							        }else{
							        	echo 'error_kardex';
							        	$aux_parametro_cuadre = 1;
							        }
								}
			    			}else{
						    	echo 'cantidad_negativa';
						    	$aux_parametro_cuadre = 1;
						    }
			    		}
					}
			    }
			}while($aux_parametro_cuadre == 0);
        }
	}

	function finalizar_salida_before_13()
	{
		/* Inicio del proceso - transacción */
		$this->db->trans_begin();
		$contador_kardex = 0;
		$aux_bucle_saldos_ini = 0;
		// VALIDACION DE CAMPOS DE STOCK POR AREAS NO TODOS LOS PRODUCTOS TIENEN ESTA INNFORMACION
        $stock_area_sta_clara = "";
        $stock_area_sta_anita = "";
        $id_detalle_producto_area = "";
        $stock_inicial = "";
        $aux = 0;
		$auxiliar = 0;
        $auxiliar_2 = 0;
        $auxiliar_3 = 0;
        $auxiliar_contador = 0;
        $validar_stock = "";
        $validar_stock_paso_2 = "";
        $auxiliar_stock_negatiVo = "";
		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$id_detalle_producto_hidden = $this->security->xss_clean($this->input->post('id_detalle_producto_hidden'));
		$id_area = $this->security->xss_clean($this->input->post('id_area'));
		$solicitante = strtoupper($this->security->xss_clean($this->input->post('solicitante')));
		$fecharegistro = $this->security->xss_clean($this->input->post('fecharegistro'));
		$nombre_producto = $this->security->xss_clean($this->input->post('nombre_producto'));
		$cantidad = $this->security->xss_clean($this->input->post('cantidad'));
		// Obtengo los datos del producto antes de actualizarlos. Stock y Precio Unitario anterior
		$this->db->select('id_detalle_producto,stock,precio_unitario,stock_sta_clara');
        $this->db->where('id_detalle_producto',$id_detalle_producto_hidden);
        $query = $this->db->get('detalle_producto');
        foreach($query->result() as $row){
            $id_detalle_producto = $row->id_detalle_producto;
            $stock_actual_sta_anita = $row->stock;
            $precio_unitario = $row->precio_unitario;
            $stock_actual_sta_clara = $row->stock_sta_clara;
        }
        // Seleccion el id de la tabla producto
        $this->db->select('id_pro');
        $this->db->where('id_detalle_producto',$id_detalle_producto);
        $this->db->where('estado','TRUE');
        $query = $this->db->get('producto');
        foreach($query->result() as $row){
            $id_pro = $row->id_pro;
        }
        // Seleccionar el stock de acuerdo al producto y al área
        // Actualización del Stock
        $this->db->select('stock_area_sta_clara,stock_area_sta_anita,id_detalle_producto_area');
        $this->db->where('id_area',$id_area);
        $this->db->where('id_pro',$id_pro);
        $query = $this->db->get('detalle_producto_area');
        foreach($query->result() as $row){
            $stock_area_sta_clara = $row->stock_area_sta_clara;
            $stock_area_sta_anita = $row->stock_area_sta_anita;
            $id_detalle_producto_area = $row->id_detalle_producto_area;
        }

        // Obtener el valor si es un producto "NUEVO"
        $this->db->select('column_temp');
        $this->db->where('id_detalle_producto',$id_detalle_producto);
        $query = $this->db->get('producto');
        foreach($query->result() as $row){
            $column_temp = $row->column_temp;
        }

        /* Validar el stock disponible por almacen */
        if($id_almacen == 1){
        	if($cantidad > $stock_area_sta_clara){
	        	echo 'error_stock';
	        }else{
	        	/* Validar si la salida esta en un periodo que ya cerro */
	        	$result_cierre = $this->model_comercial->validarRegistroCierre($fecharegistro);
	        	if($result_cierre == 'successfull'){ 
	        		// Cuando la salida se realiza en el mes actual todavia no se tiene un cierre de almacen
			        // $hora = date('d-m-Y H:i:s'); //Para obtener la hora del sistema
			        /* Realizar la salida del prodcuto */
					$a_data = array('id_area' => $id_area,
									'fecha' => $fecharegistro,
									'id_detalle_producto' => $id_detalle_producto,
									'cantidad_salida' => $cantidad,
									'id_almacen' => $id_almacen,
									'p_u_salida' => $precio_unitario,
									'solicitante' => $solicitante,
									);
					$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
					// Fin del registro de la salida
					// Procedimiento para conocer la factura a la que pertenece la salida
					// ademas de descontar el stock del producto a las unidades referencial
					// Ubico las dos ultimas facturas usadas para cargar el stock de ese producto
					$contador_facturas = 0;
					$variable_u = FALSE;
		    		$variable_p = FALSE;
					$invoice = $this->model_comercial->get_info_facturas_report($id_detalle_producto);
					if(count($invoice) > 0){
						$contador_facturas = count($invoice);
						if($contador_facturas == 2){
							foreach ($invoice as $row) {
								// Almacenar toda la informacion en variables distintas
								// Obtener las unidades referenciales de ese producto en esa factura
								$id_ingreso_producto = $row->id_ingreso_producto;
								if($variable_u == FALSE){
									// Con el ID de la factura unico el stock referencial del producto
									$this->db->select('unidades_referencial');
							        $this->db->where('id_detalle_producto',$id_detalle_producto);
							        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
							        $query = $this->db->get('detalle_ingreso_producto');
							        foreach($query->result() as $row){
							            $unidades_referencial_u = $row->unidades_referencial;
							        }
							        $id_factura_u = $id_ingreso_producto;
							        $variable_u = TRUE;
								}else if($variable_p == FALSE && $variable_u == TRUE){
									$this->db->select('unidades_referencial');
							        $this->db->where('id_detalle_producto',$id_detalle_producto);
							        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
							        $query = $this->db->get('detalle_ingreso_producto');
							        foreach($query->result() as $row){
							            $unidades_referencial_p = $row->unidades_referencial;
							        }
							        $id_factura_p = $id_ingreso_producto;
							        $variable_p = TRUE;
								}
							}
							// Verifico si la cantidad del stock referencial de la segunda factura tiene stock
							// suficiente para generar la salida
							if( $unidades_referencial_p >= $cantidad ){
								// La salida se efectuo con stock de esta factura
								// Guardar el id de la factura en el registro que se realizo lineas arriba
								// $id_factura_final = $id_factura_p;
								// Actualizar el stock de las unidades de referencia
								$unidades_actualizadas = $unidades_referencial_p - $cantidad;
								$actualizar = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_p);
								$this->db->update('detalle_ingreso_producto', $actualizar);
								// Guardar la relacion de la salida con la factura
								$registro_data = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_p,
								    'cantidad_utilizada'=> $cantidad
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data);
							}else if( $unidades_referencial_p < $cantidad && $unidades_referencial_p != 0){
								// Utilizamos las unidades referenciales para completar la salida
								$unidades_restantes = $cantidad - $unidades_referencial_p;
								// Actualizamos la penultima factura
								$actualizar_p = array('unidades_referencial'=> 0);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_p);
								$this->db->update('detalle_ingreso_producto', $actualizar_p);
								// Guardar la relacion de la salida con la factura
								$registro_data_p = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_p,
								    'cantidad_utilizada'=> $unidades_referencial_p
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_p);
								// Actualizamos la ultima factura
								$unidades_actualizadas = $unidades_referencial_u - $unidades_restantes;
								$actualizar_u = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_u);
								$this->db->update('detalle_ingreso_producto', $actualizar_u);
								// Guardar la relacion de la salida con la factura
								$registro_data_u = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_u,
								    'cantidad_utilizada'=> $unidades_restantes
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_u);
							}else if($unidades_referencial_p == 0){
								// Actualizamos la ultima factura
								$unidades_actualizadas = $unidades_referencial_u - $cantidad;
								$actualizar_u = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_u);
								$this->db->update('detalle_ingreso_producto', $actualizar_u);
								// Guardar la relacion de la salida con la factura
								$registro_data_u = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_u,
								    'cantidad_utilizada'=> $cantidad
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_u);
							}
						}else if($contador_facturas == 1){
							foreach ($invoice as $row) {
								$id_ingreso_producto = $row->id_ingreso_producto;
								// Seleccionar unidades referencial
								$this->db->select('unidades_referencial');
						        $this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
						        $query = $this->db->get('detalle_ingreso_producto');
						        foreach($query->result() as $row){
						            $unidades_referencial_u = $row->unidades_referencial;
						        }
						        $unidades_actualizadas = $unidades_referencial_u - $cantidad;
						        $actualizar_u = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
								$this->db->update('detalle_ingreso_producto', $actualizar_u);
								// Guardar la relacion de la salida con la factura
								$registro_data_u = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_ingreso_producto,
								    'cantidad_utilizada'=> $cantidad
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_u);
							}
						}
					}

					if($result_insert != ""){
		    		    $elementos_f = explode("-", $fecharegistro);
                        $anio = $elementos_f[0];
                        $mes = 1;
                        $dia = 1;
                        $array = array($anio, $mes, $dia);
                        $fecha_final_anio = implode("-", $array);
                        $fecha_final_anio = date("Y-m-d", strtotime($fecha_final_anio));
                        do{
                            // de acuerdo a la fecha obtener el saldo inicial del mes
                            $elementos_f = explode("-", $fecharegistro);
                            $anio = $elementos_f[0];
                            $mes = $elementos_f[1] - $aux;
                            $dia = 1;
                            $array = array($anio, $mes, $dia);
                            $fecha_formateada = implode("-", $array);
                            $fecha_formateada = date("Y-m-d", strtotime($fecha_formateada));
                            // consultar en bd por el saldo inicial del producto en dicha fecha
                            $this->db->select('stock_inicial');
                            $this->db->where('fecha_cierre',$fecha_formateada);
                            $this->db->where('id_pro',$id_pro);
                            $query = $this->db->get('saldos_iniciales');
                            if(count($query->result()) > 0){
                                foreach($query->result() as $row){
                                    $stock_inicial = $row->stock_inicial;
                                }
                            }
                            $aux++;
                        }while($stock_inicial == "" && $fecha_formateada != $fecha_final_anio);
                        // si el stock_inicial es vacio no tiene registros en dos meses anteriores entonces es un producto nuevo
                        if($stock_inicial == ""){ // codigo para productos nuevos
                            $stock_inicial = 0;
                        }
                        // consultar por los movimientos del producto en el mes para acumularlo en la variable stock_inicial
                        $result_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$fecha_formateada,$fecharegistro);
                        $existe = count($result_kardex);
                        if($existe > 0){
                            foreach ($result_kardex as $data) {
                                if($data->descripcion == "ENTRADA" || $data->descripcion == "IMPORTACION" || $data->descripcion == "ORDEN INGRESO"){
                                    if($contador_kardex == 0){
                                        $stock_saldo_final = $stock_inicial + $data->cantidad_ingreso;
                                        $contador_kardex++;
                                    }else{
                                        $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                                    }
                                }else if($data->descripcion == "SALIDA"){
                                    if($contador_kardex == 0){
                                        $stock_saldo_final = $stock_inicial - $data->cantidad_salida;
                                        $contador_kardex++;
                                    }else{
                                        $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
                                    }
                                }
                            }
                        }else{
                            $stock_saldo_final = $stock_inicial;
                        }
                        // validacion del stock final para realizar la salida y descuento del producto
                        $stock_saldo_final = $stock_saldo_final - $cantidad;
                        if($stock_saldo_final >= 0 ){
                            // descuento el stock
                            $this->model_comercial->descontarStock($id_detalle_producto,$cantidad,$stock_actual_sta_anita,$id_almacen, $id_area);
                            // registro en el kardex
                            $a_data_kardex = array('fecha_registro' => $fecharegistro,
                                                    'descripcion' => "SALIDA",
                                                    'id_detalle_producto' => $id_detalle_producto,
                                                    'cantidad_salida' => $cantidad,
                                                    'num_comprobante' => $result_insert,
                                                    );
                            $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
                        }else{
                            $validar_stock = 'no_existe_stock_disponible';
                        }
                        // Hasta este punto actualiza los datos del ultimo movimiento realizado en la fecha sea una salida o un ingreso
                        if($validar_stock == 'no_existe_stock_disponible'){
                            echo 'no_existe_stock_disponible';
                        }else{
                            // Creo las variables de sesion para un registro más rapido Area y Fecha, se quedará con el ultimo registro realizado
                            $datasession_area_fecha_salida = array(
                                'id_area' => $this->security->xss_clean($this->input->post('id_area')),
                                'fecharegistro' => strtoupper($this->security->xss_clean($this->input->post('fecharegistro'))),
                            );
                            $this->session->set_userdata($datasession_area_fecha_salida);
                            // Enviar parametro
                            echo '1';
                        }
				    }
	        	}else{
	        		// La salida corresponde a un periodo donde ya se realizo el cierre de almacen
	        		echo 'error_cierre';
	        	}
	        }
        }else if($id_almacen == 2){
        	if($cantidad > $stock_area_sta_anita){
	        	echo 'error_stock';
	        }else{
	        	/* Validar si la salida esta en un periodo que ya cerro */
	        	$result_cierre = $this->model_comercial->validarRegistroCierre($fecharegistro);
	        	if($result_cierre == 'successfull'){
					//$hora = date('d-m-Y H:i:s'); //Para obtener la hora del sistema
			        /* Realizar la salida del prodcuto */
					$a_data = array('id_area' => $id_area,
									'fecha' => $fecharegistro,
									'id_detalle_producto' => $id_detalle_producto,
									'cantidad_salida' => $cantidad,
									'id_almacen' => $id_almacen,
									'p_u_salida' => $precio_unitario,
									'solicitante' => $solicitante,
									);
					$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);
					/* Fin del registro de la salida */
					// Procedimiento para conocer la factura a la que pertenece la salida
					// ademas de descontar el stock del producto a las unidades referencial
					// Ubico las dos ultimas facturas usadas para cargar el stock de ese producto
					$contador_facturas = 0;
					$variable_u = FALSE;
		    		$variable_p = FALSE;
					$invoice = $this->model_comercial->get_info_facturas_report($id_detalle_producto);
					if(count($invoice) > 0){
						$contador_facturas = count($invoice);
						if($contador_facturas == 2){
							foreach ($invoice as $row) {
								// Almacenar toda la informacion en variables distintas
								// Obtener las unidades referenciales de ese producto en esa factura
								$id_ingreso_producto = $row->id_ingreso_producto;
								if($variable_u == FALSE){
									// Con el ID de la factura unico el stock referencial del producto
									$this->db->select('unidades_referencial');
							        $this->db->where('id_detalle_producto',$id_detalle_producto);
							        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
							        $query = $this->db->get('detalle_ingreso_producto');
							        foreach($query->result() as $row){
							            $unidades_referencial_u = $row->unidades_referencial;
							        }
							        $id_factura_u = $id_ingreso_producto;
							        $variable_u = TRUE;
								}else if($variable_p == FALSE && $variable_u == TRUE){
									$this->db->select('unidades_referencial');
							        $this->db->where('id_detalle_producto',$id_detalle_producto);
							        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
							        $query = $this->db->get('detalle_ingreso_producto');
							        foreach($query->result() as $row){
							            $unidades_referencial_p = $row->unidades_referencial;
							        }
							        $id_factura_p = $id_ingreso_producto;
							        $variable_p = TRUE;
								}
							}
							// Verifico si la cantidad del stock referencial de la segunda factura tiene stock
							// suficiente para generar la salida
							if( $unidades_referencial_p >= $cantidad ){
								// La salida se efectuo con stock de esta factura
								// Guardar el id de la factura en el registro que se realizo lineas arriba
								// $id_factura_final = $id_factura_p;
								// Actualizar el stock de las unidades de referencia
								$unidades_actualizadas = $unidades_referencial_p - $cantidad;
								$actualizar = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_p);
								$this->db->update('detalle_ingreso_producto', $actualizar);
								// Guardar la relacion de la salida con la factura
								$registro_data = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_p,
								    'cantidad_utilizada'=> $cantidad
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data);
							}else if( $unidades_referencial_p < $cantidad && $unidades_referencial_p != 0){
								// Utilizamos las unidades referenciales para completar la salida
								$unidades_restantes = $cantidad - $unidades_referencial_p;
								// Actualizamos la penultima factura
								$actualizar_p = array('unidades_referencial'=> 0);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_p);
								$this->db->update('detalle_ingreso_producto', $actualizar_p);
								// Guardar la relacion de la salida con la factura
								$registro_data_p = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_p,
								    'cantidad_utilizada'=> $unidades_referencial_p
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_p);
								// Actualizamos la ultima factura
								$unidades_actualizadas = $unidades_referencial_u - $unidades_restantes;
								$actualizar_u = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_u);
								$this->db->update('detalle_ingreso_producto', $actualizar_u);
								// Guardar la relacion de la salida con la factura
								$registro_data_u = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_u,
								    'cantidad_utilizada'=> $unidades_restantes
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_u);
							}else if($unidades_referencial_p == 0){
								// Actualizamos la ultima factura
								$unidades_actualizadas = $unidades_referencial_u - $cantidad;
								$actualizar_u = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_factura_u);
								$this->db->update('detalle_ingreso_producto', $actualizar_u);
								// Guardar la relacion de la salida con la factura
								$registro_data_u = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_factura_u,
								    'cantidad_utilizada'=> $cantidad
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_u);
							}
						}else if($contador_facturas == 1){
							// var_dump('opcion_factura_1');
							foreach ($invoice as $row) {
								$id_ingreso_producto = $row->id_ingreso_producto;
								// Seleccionar unidades referencial
								$this->db->select('unidades_referencial');
						        $this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
						        $query = $this->db->get('detalle_ingreso_producto');
						        foreach($query->result() as $row){
						            $unidades_referencial_u = $row->unidades_referencial;
						        }
						        $unidades_actualizadas = $unidades_referencial_u - $cantidad;
						        $actualizar_u = array('unidades_referencial'=> $unidades_actualizadas);
								$this->db->where('id_detalle_producto',$id_detalle_producto);
						        $this->db->where('id_ingreso_producto',$id_ingreso_producto);
								$this->db->update('detalle_ingreso_producto', $actualizar_u);
								// Guardar la relacion de la salida con la factura
								$registro_data_u = array(
								    'id_salida_producto'=> $result_insert,
								    'id_ingreso_producto'=> $id_ingreso_producto,
								    'cantidad_utilizada'=> $cantidad
								);
								$this->db->insert('adm_facturas_asociadas', $registro_data_u);
							}
						}
					}

					if($result_insert != ""){
						$elementos_f = explode("-", $fecharegistro);
                        $anio = $elementos_f[0];
                        $mes = 1;
                        $dia = 1;
                        $array = array($anio, $mes, $dia);
                        $fecha_final_anio = implode("-", $array);
                        $fecha_final_anio = date("Y-m-d", strtotime($fecha_final_anio));
                        do{
                            // de acuerdo a la fecha obtener el saldo inicial del mes
                            $elementos_f = explode("-", $fecharegistro);
                            $anio = $elementos_f[0];
                            $mes = $elementos_f[1] - $aux;
                            $dia = 1;
                            $array = array($anio, $mes, $dia);
                            $fecha_formateada = implode("-", $array);
                            $fecha_formateada = date("Y-m-d", strtotime($fecha_formateada));
                            // consultar en bd por el saldo inicial del producto en dicha fecha
                            $this->db->select('stock_inicial');
                            $this->db->where('fecha_cierre',$fecha_formateada);
                            $this->db->where('id_pro',$id_pro);
                            $query = $this->db->get('saldos_iniciales');
                            if(count($query->result()) > 0){
                                foreach($query->result() as $row){
                                    $stock_inicial = $row->stock_inicial;
                                }
                            }
                            $aux++;
                        }while($stock_inicial == "" && $fecha_formateada != $fecha_final_anio);
                        // si el stock_inicial es vacio no tiene registros en dos meses anteriores entonces es un producto nuevo
                        if($stock_inicial == ""){ // codigo para productos nuevos
                            $stock_inicial = 0;
                        }
                        // consultar por los movimientos del producto en el mes para acumularlo en la variable stock_inicial
                        $result_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$fecha_formateada,$fecharegistro);
                        $existe = count($result_kardex);
                        if($existe > 0){
                            foreach ($result_kardex as $data) {
                                if($data->descripcion == "ENTRADA" || $data->descripcion == "IMPORTACION" || $data->descripcion == "ORDEN INGRESO"){
                                    if($contador_kardex == 0){
                                        $stock_saldo_final = $stock_inicial + $data->cantidad_ingreso;
                                        $contador_kardex++;
                                    }else{
                                        $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                                    }
                                }else if($data->descripcion == "SALIDA"){
                                    if($contador_kardex == 0){
                                        $stock_saldo_final = $stock_inicial - $data->cantidad_salida;
                                        $contador_kardex++;
                                    }else{
                                        $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
                                    }
                                }
                            }
                        }else{
                            $stock_saldo_final = $stock_inicial;
                        }
                        // validacion del stock final para realizar la salida y descuento del producto
                        $stock_saldo_final = $stock_saldo_final - $cantidad;
                        if($stock_saldo_final >= 0 ){
                            // descuento el stock
                            $this->model_comercial->descontarStock($id_detalle_producto,$cantidad,$stock_actual_sta_anita,$id_almacen, $id_area);
                            // registro en el kardex
                            $a_data_kardex = array('fecha_registro' => $fecharegistro,
                                                    'descripcion' => "SALIDA",
                                                    'id_detalle_producto' => $id_detalle_producto,
                                                    'cantidad_salida' => $cantidad,
                                                    'num_comprobante' => $result_insert,
                                                    );
                            $result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
                        }else{
                            $validar_stock = 'no_existe_stock_disponible';
                        }
                        // Hasta este punto actualiza los datos del ultimo movimiento realizado en la fecha sea una salida o un ingreso
                        if($validar_stock == 'no_existe_stock_disponible'){
                            echo 'no_existe_stock_disponible';
                        }else{                            
                            // Creo las variables de sesion para un registro más rapido Area y Fecha, se quedará con el ultimo registro realizado
                            $datasession_area_fecha_salida = array(
                                'id_area' => $this->security->xss_clean($this->input->post('id_area')),
                                'fecharegistro' => strtoupper($this->security->xss_clean($this->input->post('fecharegistro'))),
                            );
                            $this->session->set_userdata($datasession_area_fecha_salida);
                            // Enviar parametro
                            echo '1';
                        }
	    		    }
	    		}else{
	        		echo 'error_cierre';
	        	}
	       	}
	    }
        // Fin del proceso - transacción
		$this->db->trans_complete();
	}

	function finalizar_salida_cuadre_contabilidad(){
		/* Inicio del proceso - transacción */
		$this->db->trans_begin();

		$validar_stock = "";

		$id_almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$fecharegistro = $this->security->xss_clean($this->input->post('fecharegistro'));
		$nombre_producto = $this->security->xss_clean($this->input->post('nombre_producto'));
		$cantidad = $this->security->xss_clean($this->input->post('cantidad'));
		$id_area = $this->security->xss_clean($this->input->post('id_area'));

		// Obtengo los datos del producto antes de actualizarlos. Stock y Precio Unitario anterior
		$this->db->select('id_detalle_producto,stock,precio_unitario,stock_sta_clara');
        $this->db->where('no_producto',$nombre_producto);
        $query = $this->db->get('detalle_producto');
        foreach($query->result() as $row){
            $id_detalle_producto = $row->id_detalle_producto;
            $stock_actual_sta_anita = $row->stock;
            $precio_unitario = $row->precio_unitario;
            $stock_actual_sta_clara = $row->stock_sta_clara;
        }

        // Seleccion el id de la tabla producto
        $this->db->select('id_pro');
        $this->db->where('id_detalle_producto',$id_detalle_producto);
        $query = $this->db->get('producto');
        foreach($query->result() as $row){
            $id_pro = $row->id_pro;
        }

        if($id_almacen == 2){
        	/* Validar si la salida esta en un periodo que ya cerro */
	        $result_cierre = $this->model_comercial->validarRegistroCierre($fecharegistro);

        	if($result_cierre == 'periodo_cerrado'){
        		
				// Gestión de kardex
				// Obtener el ultimo id de registro para la fecha
				$this->db->select('id_kardex_producto');
			    $this->db->where('fecha_registro <=',$fecharegistro);
			    $this->db->where('id_detalle_producto',$id_detalle_producto);
			    $this->db->order_by("fecha_registro", "asc");
			    $this->db->order_by("id_kardex_producto", "asc");
			    $query = $this->db->get('kardex_producto');
			    if(count($query->result()) > 0){
	    			foreach($query->result() as $row){
	    	            $auxiliar = $row->id_kardex_producto; // devuelve el ultimo id que no necesariamente es el mayor
	    	        }
	    	        // Obtener los datos del ultimo registro de la fecha
	    	        $this->db->select('stock_actual,precio_unitario_actual_promedio,precio_unitario_anterior,descripcion,precio_unitario_actual');
	    	        $this->db->where('id_kardex_producto',$auxiliar);
	    	        $query = $this->db->get('kardex_producto');
	    	        foreach($query->result() as $row){
	    	            $stock_actual = $row->stock_actual;
	    	            $precio_unitario_actual_promedio = $row->precio_unitario_actual_promedio;
	    	            $precio_unitario_anterior = $row->precio_unitario_anterior;
	    	            $descripcion = $row->descripcion;
	    	            $precio_unitario_actual = $row->precio_unitario_actual;
	    	        }
	    	        if($descripcion == 'SALIDA'){
	    	            $precio_unitario_anterior_especial = $precio_unitario_anterior;
	    	        }else if($descripcion == 'ENTRADA'){
	    	            $precio_unitario_anterior_especial = $precio_unitario_actual_promedio;
	    	        }

	    	        // Realizo en este punto el registro de la salida ya que obtengo el ultimo precio unitario correcto
	    	        // realizar el registro de la salida
	        		$a_data = array('id_area' => $id_area,
									'fecha' => $fecharegistro,
									'id_detalle_producto' => $id_detalle_producto,
									'cantidad_salida' => $cantidad,
									'id_almacen' => $id_almacen,
									'p_u_salida' => $precio_unitario_anterior_especial,
									);
					$result_insert = $this->model_comercial->saveSalidaProducto($a_data,true);

	    	        // restar la cantidad de salida al stock actual
	    	        $new_stock = $stock_actual - $cantidad;
	    	        // realizar el registro del movimiento en el kardex
	    	        if($new_stock >= 0){
	    	        	// Realizar el registro en el kardex
	    	        	$a_data_kardex = array('fecha_registro' => $fecharegistro,
	    	        	                'descripcion' => "SALIDA",
	    	        	                'id_detalle_producto' => $id_detalle_producto,
	    	        	                'stock_anterior' => $stock_actual,
	    	        	                'precio_unitario_anterior' => $precio_unitario_anterior_especial,
	    	        	                'cantidad_salida' => $cantidad,
	    	        	                'stock_actual' => $new_stock,
	    	        	                'precio_unitario_actual' => $precio_unitario_anterior_especial,
	    	        	                'num_comprobante' => $result_insert,
	    	        	                );
	    	        	$result_kardex = $this->model_comercial->saveSalidaProductoKardex($a_data_kardex,true);
	    	        }else{
	    	        	$this->model_comercial->eliminar_insert_salida($result_insert);
				        $validar_stock = 'no_existe_stock_disponible';
	    	        }
			    }else{
			    	echo 'se considera hacer salidas que tengan movimientos anteriores';
				}

				if($validar_stock != 'no_existe_stock_disponible'){
					// Considero los registro en el kardex de la salida como el ultimo movimiento
					// Se da paso a verificar si existen salidas posteriores a la fecha, para su actualización
					$id_kardex_producto = "";
					$auxiliar_contador = 0;
					$this->db->select('id_kardex_producto');
            		$this->db->where('fecha_registro >',$fecharegistro);
            		$this->db->where('id_detalle_producto',$id_detalle_producto);
		    		$this->db->order_by("fecha_registro", "asc");
		    		$this->db->order_by("id_kardex_producto", "asc");
		    		$query = $this->db->get('kardex_producto');
		    		if(count($query->result()) > 0){
		    			foreach($query->result() as $row){
		    				// Procedimiento
                    		$id_kardex_producto = $row->id_kardex_producto; // ID del movimiento en el kardex
                    		// Obtener los datos del movimiento del kardex
	                        $this->db->select('stock_actual,precio_unitario_actual_promedio,precio_unitario_anterior,descripcion,stock_anterior,cantidad_salida,cantidad_ingreso,precio_unitario_actual,id_detalle_producto,fecha_registro');
	                        $this->db->where('id_kardex_producto',$id_kardex_producto);
	                        $query = $this->db->get('kardex_producto');
	                        foreach($query->result() as $row_2){
	                        	$id_detalle_producto = $row_2->id_detalle_producto;
	                            $stock_actual_act = $row_2->stock_actual;
	                            $precio_unitario_actual_promedio_act = $row_2->precio_unitario_actual_promedio;
	                            $precio_unitario_anterior_act = $row_2->precio_unitario_anterior;
	                            $descripcion_act = $row_2->descripcion;
	                            $stock_anterior_act = $row_2->stock_anterior;
	                            $cantidad_salida_act = $row_2->cantidad_salida;
	                            $cantidad_ingreso_act = $row_2->cantidad_ingreso;
	                            $precio_unitario_actual_act = $row_2->precio_unitario_actual;
	                            $fecha_registro_kardex_post = $row_2->fecha_registro;
	                            if($auxiliar_contador == 0){
                                    // El stock anterior viene a ser el stock actual del movimiento anterior
                                    $new_stock_anterior_act = $new_stock; // stock_anterior
                                    $new_precio_unitario_anterior_act = $precio_unitario_anterior_especial; // precio_unitario_anterior
                                    $auxiliar_contador++;
                                }
                                // Actualización del registro
                        		if($descripcion_act == 'ENTRADA' || $descripcion_act == 'ORDEN INGRESO'){
                        			/* Actualizar los datos para una entrada */
                            		$stock_actual_final = $new_stock_anterior_act + $cantidad_ingreso_act;
                            		$precio_unitario_actual_promedio_final = (($new_stock_anterior_act*$new_precio_unitario_anterior_act)+($cantidad_ingreso_act*$precio_unitario_actual_act))/($new_stock_anterior_act+$cantidad_ingreso_act);
                            		/* Actualizar BD */
	                                $actualizar = array(
	                                    'stock_anterior'=> $new_stock_anterior_act,
	                                    'precio_unitario_anterior'=> $new_precio_unitario_anterior_act,
	                                    'stock_actual'=> $stock_actual_final,
	                                    'precio_unitario_actual_promedio'=> $precio_unitario_actual_promedio_final
	                                );
	                                $this->db->where('id_kardex_producto',$id_kardex_producto);
	                                $this->db->update('kardex_producto', $actualizar);
	                                /* fin de actualizar */
	                                /* Actualizar el precio unitario del producto */
	                                $actualizar = array(
	                                    'precio_unitario'=> $precio_unitario_actual_promedio_final,
	                                    'stock' => $stock_actual_final
	                                );
	                                $this->db->where('id_detalle_producto',$id_detalle_producto);
	                                $this->db->update('detalle_producto', $actualizar);
                        		}else if($descripcion_act == 'SALIDA'){
                        			/* Actualizar los datos para una salida */
	                                $stock_actual_final = $new_stock_anterior_act - $cantidad_salida_act;
	                                $precio_unitario_actual_final = $new_precio_unitario_anterior_act;
	                                $precio_unitario_anterior_final = $new_precio_unitario_anterior_act;
	                                /* Actualizar BD */
	                                $actualizar = array(
	                                    'stock_anterior'=> $new_stock_anterior_act,
	                                    'precio_unitario_anterior'=> $precio_unitario_anterior_final,
	                                    'stock_actual'=> $stock_actual_final,
	                                    'precio_unitario_actual'=> $precio_unitario_actual_final
	                                );
	                                $this->db->where('id_kardex_producto',$id_kardex_producto);
	                                $this->db->update('kardex_producto', $actualizar);
	                                /* fin de actualizar */
	                                $actualizar = array(
	                                    'stock' => $stock_actual_final
	                                );
	                                $this->db->where('id_detalle_producto',$id_detalle_producto);
	                                $this->db->update('detalle_producto', $actualizar);
                        		}if($descripcion_act == 'IMPORTACION'){
                        			/* Actualizar los datos para una entrada */
	                                $stock_actual_final = $new_stock_anterior_act + $cantidad_ingreso_act;
	                                $precio_unitario_actual_promedio_final = 0;
	                                /* Actualizar BD */
	                                $actualizar = array(
	                                    'stock_anterior'=> $new_stock_anterior_act,
	                                    'precio_unitario_anterior'=> $new_precio_unitario_anterior_act,
	                                    'stock_actual'=> $stock_actual_final,
	                                    'precio_unitario_actual_promedio'=> $precio_unitario_actual_promedio_final
	                                );
	                                $this->db->where('id_kardex_producto',$id_kardex_producto);
	                                $this->db->update('kardex_producto', $actualizar);
	                                /* fin de actualizar */
	                                /* Actualizar el precio unitario del producto */
	                                $actualizar = array(
	                                    'precio_unitario'=> $precio_unitario_actual_promedio_final,
	                                    'stock' => $stock_actual_final
	                                );
	                                $this->db->where('id_detalle_producto',$id_detalle_producto);
	                                $this->db->update('detalle_producto', $actualizar);
                        		}
                        		// Dejar variables con el ultimo registro del stock y precio unitario obtenido para el siguiente recorrido
                        		$new_stock_anterior_act = $stock_actual_final;
                        		if($new_stock_anterior_act >= 0){
	                        		if($descripcion_act == 'ENTRADA' || $descripcion_act == 'ORDEN INGRESO'){
		                                $new_precio_unitario_anterior_act = $precio_unitario_actual_promedio_final;
		                            }else if($descripcion_act == 'SALIDA'){
		                                $new_precio_unitario_anterior_act = $precio_unitario_actual_final;
		                            }else if($descripcion_act == 'IMPORTACION'){
		                                $new_precio_unitario_anterior_act = 0;
		                            }
                        		}else{
                        			echo 'negativo_registros_posteriores';
                        		}

                        		// se necesita conocer si el registro que se esta trabajando corresponde al ultimo del mes
                        		// Selecciono el ultimo id del periodo al que corresponde la fecha
	                            $elementos = explode("-", $fecha_registro_kardex_post);
	                            $anio = $elementos[0];
	                            $mes = $elementos[1];
	                            $dia = $elementos[2];
	                            if($mes == 12){
	                                $anio = $anio + 1;
	                                $mes_siguiente = 1;
	                                $dia = 1;
	                            }else if($mes <= 11 ){
	                                $mes_siguiente = $mes + 1;
	                                $dia = 1;
	                            }
	                            $array = array($anio, $mes_siguiente, $dia);
	                            $fecha_formateada_post = implode("-", $array);
	                            // Formato
	                            $this->db->select('id_kardex_producto');
	                            $this->db->where('fecha_registro >=',$fecha_registro_kardex_post);
	                            $this->db->where('fecha_registro <',date($fecha_formateada_post));
	                            $this->db->where('id_detalle_producto',$id_detalle_producto);
	                            $this->db->order_by("fecha_registro", "asc");
	                            $this->db->order_by("id_kardex_producto", "asc");
	                            $query = $this->db->get('kardex_producto');
	                            if(count($query->result()) > 0){
		                            foreach($query->result() as $row_3){
		                                $id_kardex_producto_ultimo = $row_3->id_kardex_producto;
		                            }
		                        }
	                            // verificar si el id que se esta trabajando es el ultimo del mes
	                            // para actualizar los saldos iniciales y el monto de cierre
	                            if($id_kardex_producto == $id_kardex_producto_ultimo){
	                            	// Actualizar los saldos iniciales y el monto de cierre
	                            	// Esta fecha me va a servir para ubicar el cierre del producto del mes posterior para su actualizacion
			                        $this->db->select('id_saldos_iniciales,stock_inicial,stock_inicial_sta_clara,precio_uni_inicial');
			                        $this->db->where('id_pro',$id_pro);
			                        $this->db->where('fecha_cierre',$fecha_formateada_post);
			                        $query = $this->db->get('saldos_iniciales');
			                        if($query->num_rows() > 0){
			                        	foreach($query->result() as $row){
			                        	    $id_saldos_iniciales = $row->id_saldos_iniciales;
			                        	    $stock_inicial_antes_actualizacion = $row->stock_inicial;
			                        	    $stock_inicial_sta_clara_antes_actualizacion = $row->stock_inicial_sta_clara;
			                        	    $precio_uni_inicial_antes_actualizacion = $row->precio_uni_inicial; // todavia no esta actualizado
			                        	}
			                        	if($id_almacen == 2){ // Sta. anita
		                                    $actualizar = array(
		                                        'precio_uni_inicial'=> $new_precio_unitario_anterior_act,
		                                        'stock_inicial'=> $new_stock_anterior_act
		                                    );
		                                    $this->db->where('id_saldos_iniciales',$id_saldos_iniciales);
		                                    $this->db->update('saldos_iniciales', $actualizar);
		                                }
		                                // Actualizar monto final de cierre del mes
                                		// Obtengo los stock de cierre actualizados en el paso anterior
                                		$stock_general_cierre = $stock_inicial_antes_actualizacion + $stock_inicial_sta_clara_antes_actualizacion;
                                		$monto_parcial_producto_anterior = $precio_uni_inicial_antes_actualizacion * $stock_general_cierre;
                                		$monto_parcial_producto_nuevo = $new_precio_unitario_anterior_act * ($stock_general_cierre - $cantidad);
                                		// Seleccionar el monto de cierre
		                                $this->db->select('fecha_cierre,monto_cierre_sta_anita,monto_cierre_sta_clara,fecha_auxiliar');
		                                $this->db->where('fecha_auxiliar',$fecha_formateada_post);
		                                $query = $this->db->get('monto_cierre');
		                                if($query->num_rows()>0){
		                                	foreach($query->result() as $row){
		                                        $fecha_cierre = $row->fecha_cierre;
		                                        $monto_cierre_sta_anita = $row->monto_cierre_sta_anita;
		                                        $monto_cierre_sta_clara = $row->monto_cierre_sta_clara;
		                                        $fecha_auxiliar = $row->fecha_auxiliar;
		                                    }
		                                	$monto_cierre_sta_anita = $monto_cierre_sta_anita - $monto_parcial_producto_anterior;
		                                	$monto_cierre_sta_anita = $monto_cierre_sta_anita + $monto_parcial_producto_nuevo;
		                                	// Nuevo monto de cierre general
                                        	$monto_general_actualizado = $monto_cierre_sta_anita + $monto_cierre_sta_clara;
                                        	$actualizar = array(
	                                            'monto_cierre'=> $monto_general_actualizado,
	                                            'monto_cierre_sta_anita'=> $monto_cierre_sta_anita
	                                        );
                                        	$this->db->where('fecha_auxiliar',$fecha_formateada_post);
                                        	$this->db->update('monto_cierre',$actualizar);
		                                }
			                        }
				                }
	                        }
		    			}
		    			echo '1';
		    		}
				}else{
					echo 'no_existe_stock_disponible';
				}
				
        	}else{
        		echo 'error';
        	}
        }

        /* Fin del proceso - transacción */
		$this->db->trans_complete();
	}
	
	function finalizar_registro_otros()
	{
		$this->form_validation->set_rules('comprobante', 'Comprobante', 'trim|required|xss_clean');
		$this->form_validation->set_rules('numcomprobante', 'Nro. de Comprobante', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('fecharegistro', 'Fecha de Registro', 'trim|required|xss_clean');
		$this->form_validation->set_rules('moneda', 'Moneda', 'trim|required|xss_clean');
		$this->form_validation->set_rules('proveedor', 'Proveedor', 'trim|required|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 1 dígito como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 20 dígitos como máximo.');
		//Delimitadores de ERROR:
		$this->form_validation->set_error_delimiters('<span>', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			$data['error']= validation_errors();
			$data['listaagente']= $this->model_comercial->listaAgenteAduana();
			$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
			$data['listacomprobante']= $this->model_comercial->listarComprobantes();
			$data['listaproveedor']= $this->model_comercial->listaProveedor();
			$data['listasimmon']= $this->model_comercial->listaSimMon();
			$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
			$this->load->view('comercial/registro_ingreso_otros', $data);
		}
		else
		{
			$existe = $this->cart->total_items();
			if($existe <= 0){
				$data['error'] = '<span style="color:red"><b>ERROR:</b> Debe Registrar un Productos como mínimo al Comprobante.</span>';
				$data['listaagente']= $this->model_comercial->listaAgenteAduana();
				$data['prodIngresados']= $this->model_comercial->listarProductosIngresados();
				$data['listacomprobante']= $this->model_comercial->listarComprobantes();
				$data['listaproveedor']= $this->model_comercial->listaProveedor();
				$data['listasimmon']= $this->model_comercial->listaSimMon();
				$data['listanombreproducto']= $this->model_comercial->listaNombreProducto();
				$this->load->view('comercial/registro_ingreso_otros', $data);
			}else{
				$tipo_comprobante = $this->security->xss_clean($this->input->post("comprobante"));
				$numcomprobante = $this->security->xss_clean($this->input->post("numcomprobante"));
				$moneda = $this->security->xss_clean($this->input->post("moneda"));
				$proveedor = $this->security->xss_clean($this->input->post("proveedor"));
				$fecharegistro = $this->security->xss_clean($this->input->post("fecharegistro"));
				//$porcentaje = $this->security->xss_clean($this->input->post("porcent"));
				$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
				$total = $this->cart->total()+($this->cart->total()*0.18);

				$carrito = $this->cart->contents();

				//Agregamos le registro_ingreso a la bd
				$datos = array(
					"id_comprobante" => $tipo_comprobante,
					"nro_comprobante" => $numcomprobante,
					"fecha" => $fecharegistro,
					"id_moneda" => $moneda,
					"id_proveedor" => $proveedor,
					"total" => $total,
					//"gastos" => $porcentaje,
					"id_almacen" => $almacen
				);
				$id_ingreso_producto = $this->model_comercial->agrega_ingreso($datos);

				//Agregamos el detalle del comprobante
				$result = $this->model_comercial->agregar_detalle_ingreso($carrito, $id_ingreso_producto);

				if(!$result){
		            //Sí no se encotnraron datos.
		            echo '<span style="color:red"><b>ERROR:</b> Este Proveedor no se encuentra registrado.</span>';
		        }else{
		        	//Registramos la sesion del usuario
		        	$this->cart->destroy();
					redirect('comercial/gestionotrosDoc');
		        }

				//print_r($id_ingreso_producto);
				//redirect('comercial/gestioningreso');
			}
		}
	}

	public function traeMarca()
	{
        $marca = $this->model_comercial->getMarca();
        echo '<option value=""> :: SELECCIONE ::</option>';
        foreach($marca as $fila)
        {
        	echo '<option value="'.$fila->id_marca_maquina.'">'.$fila->no_marca.'</option>';
	    }
	}

	public function traeModelo()
	{
        $modelo = $this->model_comercial->getModelo();
        echo '<option value=""> :: SELECCIONE ::</option>';
        foreach($modelo as $fila)
        {
        	echo '<option value="'.$fila->id_modelo_maquina.'">'.$fila->no_modelo.'</option>';
	    }
	}

	public function traeSerie()
	{
        $modelo = $this->model_comercial->getSerie();
        echo '<option value=""> :: SELECCIONE ::</option>';
        foreach($modelo as $fila)
        {
        	echo '<option value="'.$fila->id_serie_maquina.'">'.$fila->no_serie.'</option>';
	    }
	}

	public function reportemaquinaspdf(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfMaquinas');

	    // Se obtienen los alumnos de la base de datos
	    $maquina = $this->model_comercial->listarMaquinaFiltroPdf();

	    // Creacion del PDF

	    /*
	     * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
	     * heredó todos las variables y métodos de fpdf
	     */
	    $this->pdf = new PdfMaquinas();
	    // Agregamos una página
	    $this->pdf->AddPage();
	    // Define el alias para el número de página que se imprimirá en el pie
	    $this->pdf->AliasNbPages();

	    /* Se define el titulo, márgenes izquierdo, derecho y
	     * el color de relleno predeterminado
	     */
	    $this->pdf->SetTitle("Lista de Máquinas");
	    $this->pdf->SetLeftMargin(25);
	    $this->pdf->SetRightMargin(25);
	    $this->pdf->SetFillColor(200,200,200);

	    // Se define el formato de fuente: Arial, negritas, tamaño 9
	    $this->pdf->SetFont('Arial', 'B', 7);
	    /*
	     * TITULOS DE COLUMNAS
	     *
	     * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
	     */
	    /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
	    $this->pdf->Ln(9);
	    */
	    $existe = count($maquina);
  		if($existe > 0){
		    $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
		    //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
		    $this->pdf->Cell(35,9,utf8_decode('NOMBRE DE MÁQUINA'),'BLTR',0,'C','1');
		    $this->pdf->Cell(30,9,'MARCA','BLTR',0,'C','1');
		    $this->pdf->Cell(30,9,utf8_decode('MODELO'),'BLTR',0,'C','1');
		    $this->pdf->Cell(30,9,utf8_decode('SERIE'),'BLTR',0,'C','1');
		    $this->pdf->Cell(30,9,utf8_decode('ESTADO'),'BLTR',0,'C','1');
		    $this->pdf->Cell(50,9,utf8_decode('OBSERVACIÓN'),'BLTR',0,'C','1');
		    $this->pdf->Cell(37,9,utf8_decode('FECHA DE REGISTRO'),'BLTR',0,'C','1');
		    $this->pdf->Ln(9);
		    // La variable $x se utiliza para mostrar un número consecutivo
		    $x = 1;
		    foreach ($maquina as $maq) {
		        // se imprime el numero actual y despues se incrementa el valor de $x en uno
		        $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
		        // Se imprimen los datos de cada user
		        //$this->pdf->Cell(25,5,$user->id_user,'B',0,'L',0);
		        $this->pdf->Cell(35,8,$maq->nombre_maquina,'BR BT',0,'C',0);
		        $this->pdf->Cell(30,8,$maq->no_marca,'BR BT',0,'C',0);
		        $this->pdf->Cell(30,8,$maq->no_modelo,'BR BT',0,'C',0);
		        $this->pdf->Cell(30,8,$maq->no_serie,'BR BT',0,'C',0);
		        $this->pdf->Cell(30,8,$maq->no_estado_maquina,'BR BT',0,'C',0);
		        $this->pdf->Cell(50,8,$maq->observacion_maq,'BR BT',0,'C',0);
		        $this->pdf->Cell(37,8,$maq->fe_registro,'BR BT',0,'C',0);
		        //Se agrega un salto de linea
		        $this->pdf->Ln(8);
		    }
		}
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
	    /*
	     * Se manda el pdf al navegador
	     *
	     * $this->pdf->Output(nombredelarchivo, destino);
	     *
	     * I = Muestra el pdf en el navegador
	     * D = Envia el pdf para descarga
	     *
	     */
	    $this->pdf->Output("Lista de Proveedores.pdf", 'I');
	}

	public function reporteproveedorespdf(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdf');

	    // Se obtienen los alumnos de la base de datos
	    $proveedores = $this->model_comercial->listarProveedoresFiltroPdf();
 
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new Pdf();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Proveedores");
        $this->pdf->SetLeftMargin(25);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($proveedores);
  		if($existe > 0){
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(50,9,utf8_decode('RAZÓN SOCIAL'),'BLTR',0,'C','1');
	        $this->pdf->Cell(25,9,'RUC','BLTR',0,'C','1');
	        $this->pdf->Cell(35,9,utf8_decode('PAÍS'),'BLTR',0,'C','1');
	        $this->pdf->Cell(76,9,utf8_decode('DIRECCIÓN'),'BLTR',0,'C','1');
	        $this->pdf->Cell(25,9,utf8_decode('TELÉFONO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(31,9,utf8_decode('FECHA DE REGISTRO'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        foreach ($proveedores as $proveedor) {
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada proveedor
	            //$this->pdf->Cell(25,5,$proveedor->id_proveedor,'B',0,'L',0);
	            $this->pdf->Cell(50,8,$proveedor->razon_social,'BR BT',0,'C',0);
	            $this->pdf->Cell(25,8,$proveedor->ruc,'BR BT',0,'C',0);
	            $this->pdf->Cell(35,8,$proveedor->pais,'BR BT',0,'C',0);
	            $this->pdf->Cell(76,8,$proveedor->direccion,'BR BT',0,'C',0);
	            $this->pdf->Cell(25,8,$proveedor->telefono1,'BR BT',0,'C',0);
	            $this->pdf->Cell(31,8,$proveedor->fe_registro,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }
	    }
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de Proveedores.pdf", 'I');
	}

	public function reporteingresospdf(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfIngresos');

	    // Se obtienen los alumnos de la base de datos
	    $reg_ingresos = $this->model_comercial->listaRegistrosFiltroPdf();
	    $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }
 
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfIngresos();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Registros de Ingreso");
        $this->pdf->SetLeftMargin(25);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($reg_ingresos);
  		if($existe > 0){
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(27,9,utf8_decode('COMPROBANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(34,9,utf8_decode('N° DE COMPROBANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(53,9,utf8_decode('PROVEEDOR'),'BLTR',0,'C','1');
	        $this->pdf->Cell(33,9,utf8_decode('FECHA DE REGISTRO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(31,9,utf8_decode('MONEDA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(19,9,utf8_decode('IGV'),'BLTR',0,'C','1');
	        $this->pdf->Cell(25,9,utf8_decode('MONTO TOTAL'),'BLTR',0,'C','1');
	        $this->pdf->Cell(20,9,utf8_decode('GASTOS'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        // Creo las variables contenedoras de la suma
	        $sum_total = 0;
	        $suma_soles = 0;
	        foreach ($reg_ingresos as $reg) {
	        	// Obtengo el tipo de cambio del día con el que se registro la factura
		        $this->db->select('dolar_venta,euro_venta,fr_venta');
		        $this->db->where('fecha_actual',$reg->fecha);
		        $query = $this->db->get('tipo_cambio');
		        foreach($query->result() as $row){
		            $dolar_venta_fechaR = $row->dolar_venta;
		            $euro_venta_fechaR = $row->euro_venta;
		            $fr_venta_fechaR = $row->fr_venta;
		        }
	        	if($reg->no_moneda == 'DOLARES'){
	        		$convert_soles = $reg->total * $dolar_venta_fechaR;
	        		$suma_soles = $suma_soles + $convert_soles;
	        	}else if($reg->no_moneda == 'EURO'){
	        		$convert_soles = $reg->total * $euro_venta_fechaR;
	        		$suma_soles = $suma_soles + $convert_soles;
	        	}else if($reg->no_moneda == 'FRANCO SUIZO'){
	        		$convert_soles = $reg->total * $fr_venta_fechaR;
	        		$suma_soles = $suma_soles + $convert_soles;
	        	}else{
	        		$suma_soles = $suma_soles + $reg->total;
	        	}
	        	$gasto_aduana = $reg->total * $reg->gastos;
	        	$sub_total = $reg->total / 1.18;
	        	$igv = $reg->total - $sub_total;
	        	$sum_total = $sum_total + $reg->total;
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada reg
	            //$this->pdf->Cell(25,5,$reg->id_reg,'B',0,'L',0);
	            $this->pdf->Cell(27,8,$reg->no_comprobante,'BR BT',0,'C',0);
	            $this->pdf->Cell(34,8,$reg->nro_comprobante,'BR BT',0,'C',0);
	            $this->pdf->Cell(53,8,$reg->razon_social,'BR BT',0,'C',0);
	            $this->pdf->Cell(33,8,$reg->fecha,'BR BT',0,'C',0);
	            $this->pdf->Cell(31,8,utf8_decode($reg->nombresimbolo),'BR BT',0,'C',0);
	            $this->pdf->Cell(19,8,@number_format($igv, 2, '.', ''),'BR BT',0,'C',0);
	            $this->pdf->Cell(25,8,$reg->total,'BR BT',0,'C',0);
	            $this->pdf->Cell(20,8,$gasto_aduana,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }
	        $suma_dolares = $suma_soles / $dolar_venta;
	        $suma_euros = $suma_soles / $euro_venta;
	        $suma_libras = $suma_soles / $fr_venta;
	    	$this->pdf->Ln(4);
	        $this->pdf->Cell(125,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);
	        $this->pdf->Cell(160,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma_soles, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN EUROS'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'EUR '.@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('Fr. ').@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	    }
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
	        //Se agrega un salto de linea
	        /*
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(163,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,6,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(8);
	        $this->pdf->Cell(215,8,'IMPORTE TOTAL DE INGRESOS EN SOLES',0,0,'R',0);
	        $this->pdf->Cell(25,7.5,'S/. '.$sum_total,0,0,'R',0);
	        $this->pdf->Ln(8);
	        $this->pdf->Cell(218.5,8,'IMPORTE TOTAL DE INGRESOS EN DOLARES',0,0,'R',0);
	        $this->pdf->Ln(8);
	        $this->pdf->Cell(215.5,8,'IMPORTE TOTAL DE INGRESOS EN EUROS',0,0,'R',0);
			*/
	        /*
	         * Se manda el pdf al navegador
	         *
	         * $this->pdf->Output(nombredelarchivo, destino);
	         *
	         * I = Muestra el pdf en el navegador
	         * D = Envia el pdf para descarga
	         *
	         */
	        $this->pdf->Output("Lista de Registro de Ingreso de Productos.pdf", 'I');
	}

	public function reporteingresospdf_otros(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfIngresos');

	    // Se obtienen los alumnos de la base de datos
	    $reg_ingresos = $this->model_comercial->listaRegistrosFiltroPdf_otros();
	    $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }
 
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfIngresos();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Registros de Ingreso");
        $this->pdf->SetLeftMargin(25);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($reg_ingresos);
  		if($existe > 0){
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(35,9,utf8_decode('COMPROBANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(35,9,utf8_decode('N° DE COMPROBANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(55,9,utf8_decode('PROVEEDOR'),'BLTR',0,'C','1');
	        $this->pdf->Cell(35,9,utf8_decode('FECHA DE REGISTRO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(31,9,utf8_decode('MONEDA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(25,9,utf8_decode('MONTO TOTAL'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        $sum_total = 0;
	        $suma_soles = 0;
	        foreach ($reg_ingresos as $reg) {
	        	// Obtengo el tipo de cambio del día con el que se registro la factura
		        $this->db->select('dolar_venta,euro_venta,fr_venta');
		        $this->db->where('fecha_actual',$reg->fecha);
		        $query = $this->db->get('tipo_cambio');
		        foreach($query->result() as $row){
		            $dolar_venta_fechaR = $row->dolar_venta;
		            $euro_venta_fechaR = $row->euro_venta;
		            $fr_venta_fechaR = $row->fr_venta;
		        }
	        	if($reg->no_moneda == 'DOLARES'){
	        		$convert_soles = $reg->total * $dolar_venta_fechaR;
	        		$suma_soles = $suma_soles + $convert_soles;
	        	}else if($reg->no_moneda == 'EURO'){
	        		$convert_soles = $reg->total * $euro_venta_fechaR;
	        		$suma_soles = $suma_soles + $convert_soles;
	        	}else if($reg->no_moneda == 'FRANCO SUIZO'){
	        		$convert_soles = $reg->total * $fr_venta_fechaR;
	        		$suma_soles = $suma_soles + $convert_soles;
	        	}else{
	        		$suma_soles = $suma_soles + $reg->total;
	        	}
	        	$sub_total = $reg->total / 1.18;
	        	$sum_total = $sum_total + $reg->total;
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada reg
	            //$this->pdf->Cell(25,5,$reg->id_reg,'B',0,'L',0);
	            $this->pdf->Cell(35,8,utf8_decode($reg->no_comprobante),'BR BT',0,'C',0);
	            $this->pdf->Cell(35,8,$reg->nro_comprobante,'BR BT',0,'C',0);
	            $this->pdf->Cell(55,8,$reg->razon_social,'BR BT',0,'C',0);
	            $this->pdf->Cell(35,8,$reg->fecha,'BR BT',0,'C',0);
	            $this->pdf->Cell(31,8,utf8_decode($reg->nombresimbolo),'BR BT',0,'C',0);
	            $this->pdf->Cell(25,8,$reg->total,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }
	        $suma_dolares = $suma_soles / $dolar_venta;
	        $suma_euros = $suma_soles / $euro_venta;
	        $suma_libras = $suma_soles / $fr_venta;
	    	$this->pdf->Ln(4);
	        $this->pdf->Cell(125,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);
	        $this->pdf->Cell(160,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma_soles, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN EUROS'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'EUR '.@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('Fr. ').@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	    }
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
	        //Se agrega un salto de linea
	        /*
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(163,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,6,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(8);
	        $this->pdf->Cell(215,8,'IMPORTE TOTAL DE INGRESOS EN SOLES',0,0,'R',0);
	        $this->pdf->Cell(25,7.5,'S/. '.$sum_total,0,0,'R',0);
	        $this->pdf->Ln(8);
	        $this->pdf->Cell(218.5,8,'IMPORTE TOTAL DE INGRESOS EN DOLARES',0,0,'R',0);
	        $this->pdf->Ln(8);
	        $this->pdf->Cell(215.5,8,'IMPORTE TOTAL DE INGRESOS EN EUROS',0,0,'R',0);
			*/
	        /*
	         * Se manda el pdf al navegador
	         *
	         * $this->pdf->Output(nombredelarchivo, destino);
	         *
	         * I = Muestra el pdf en el navegador
	         * D = Envia el pdf para descarga
	         *
	         */
	        $this->pdf->Output("Lista de Proveedores.pdf", 'I');
	}

	public function reportesalidapdf(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfSalidas');

	    // Se obtienen los alumnos de la base de datos
	    $reg_salida = $this->model_comercial->listaRegistrosSalidaFiltroPdf();
	    $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }
 
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfSalidas();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Registros de Salida");
        $this->pdf->SetLeftMargin(13);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($reg_salida);
  		if($existe > 0){ 
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(24,9,utf8_decode('MÁQUINA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(24,9,utf8_decode('MARCA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(24,9,utf8_decode('MODELO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(23,9,utf8_decode('SERIE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(23,9,utf8_decode('ÁREA'),'BLTR',0,'C','1');
	        //$this->pdf->Cell(23,9,utf8_decode('SOLICITANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(24,9,utf8_decode('FECHA SALIDA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(80,9,utf8_decode('PRODUCTO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(18,9,utf8_decode('CANTIDAD'),'BLTR',0,'C','1');
	        $this->pdf->Cell(18,9,utf8_decode('PREC. UNIT.'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        $suma_soles = 0;
	        foreach ($reg_salida as $reg) {
	        	$suma_soles = $suma_soles + ($reg->cantidad_salida * $reg->precio_unitario);
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada reg
	            //$this->pdf->Cell(23,5,$reg->id_reg,'B',0,'L',0);
	            $this->pdf->Cell(24,8,$reg->nombre_maquina,'BR BT',0,'C',0);
	            $this->pdf->Cell(24,8,$reg->no_marca,'BR BT',0,'C',0);
	            $this->pdf->Cell(24,8,$reg->no_modelo,'BR BT',0,'C',0);
	            $this->pdf->Cell(23,8,$reg->no_serie,'BR BT',0,'C',0);
	            $this->pdf->Cell(23,8,$reg->no_area,'BR BT',0,'C',0);
	            //$this->pdf->Cell(23,8,$reg->solicitante,'BR BT',0,'C',0);
	            $this->pdf->Cell(24,8,$reg->fecha,'BR BT',0,'C',0);
	            $this->pdf->Cell(80,8,$reg->no_producto,'BR BT',0,'C',0);
	            $this->pdf->Cell(18,8,$reg->cantidad_salida,'BR BT',0,'C',0);
	            $this->pdf->Cell(18,8,$reg->precio_unitario,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }
	        $suma_dolares = $suma_soles / $dolar_venta;
	        $suma_euros = $suma_soles / $euro_venta;
	        $suma_libras = $suma_soles / $fr_venta;

	        $this->pdf->Ln(4);
	        $this->pdf->Cell(140,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);

	        $this->pdf->Cell(175,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma_soles, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(175,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(175,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN EUROS'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'EUR '.@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(175,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('Fr. ').@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	    }
        else
        {
        	$this->pdf->Cell(105,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de Salida de Productos.pdf", 'I');
	}

	public function reportesalida_solicitante_pdf(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfSalidas');

	    // Se obtienen los alumnos de la base de datos
	    $reg_salida = $this->model_comercial->listaRegistrosSalidaFiltroPdf();
	    $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }
 
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfSalidas();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Registros de Salida");
        $this->pdf->SetLeftMargin(13);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($reg_salida);
  		if($existe > 0){ 
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(27,9,utf8_decode('MÁQUINA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(27,9,utf8_decode('SERIE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(34,9,utf8_decode('SOLICITANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(27,9,utf8_decode('ÁREA'),'BLTR',0,'C','1');
	        //$this->pdf->Cell(23,9,utf8_decode('SOLICITANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(25,9,utf8_decode('FECHA SALIDA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(80,9,utf8_decode('PRODUCTO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(18,9,utf8_decode('CANTIDAD'),'BLTR',0,'C','1');
	        $this->pdf->Cell(20,9,utf8_decode('PREC. UNIT.'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        $suma_soles = 0;
	        foreach ($reg_salida as $reg) {
	        	$suma_soles = $suma_soles + ($reg->cantidad_salida * $reg->precio_unitario);
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada reg
	            //$this->pdf->Cell(23,5,$reg->id_reg,'B',0,'L',0);
	            $this->pdf->Cell(27,8,$reg->nombre_maquina,'BR BT',0,'C',0);
	            $this->pdf->Cell(27,8,$reg->no_serie,'BR BT',0,'C',0);
	            $this->pdf->Cell(34,8,$reg->solicitante,'BR BT',0,'C',0);
	            $this->pdf->Cell(27,8,$reg->no_area,'BR BT',0,'C',0);
	            //$this->pdf->Cell(23,8,$reg->solicitante,'BR BT',0,'C',0);
	            $this->pdf->Cell(25,8,$reg->fecha,'BR BT',0,'C',0);
	            $this->pdf->Cell(80,8,$reg->no_producto,'BR BT',0,'C',0);
	            $this->pdf->Cell(18,8,$reg->cantidad_salida,'BR BT',0,'C',0);
	            $this->pdf->Cell(20,8,$reg->precio_unitario,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }
	        $suma_dolares = $suma_soles / $dolar_venta;
	        $suma_euros = $suma_soles / $euro_venta;
	        $suma_libras = $suma_soles / $fr_venta;

	        $this->pdf->Ln(4);
	        $this->pdf->Cell(140,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);

	        $this->pdf->Cell(175,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma_soles, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(175,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(175,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN EUROS'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'EUR '.@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(175,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('Fr. ').@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	    }
        else
        {
        	$this->pdf->Cell(105,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
	        /*
	         * Se manda el pdf al navegador
	         *
	         * $this->pdf->Output(nombredelarchivo, destino);
	         *
	         * I = Muestra el pdf en el navegador
	         * D = Envia el pdf para descarga
	         *
	         */
	        $this->pdf->Output("Lista de Salida de Productos.pdf", 'I');
	}

	public function reporteproductospdf(){
		// Se carga el modelo alumno
        //$this->load->model('model_comercial');
        // Se carga la libreria fpdf
        $this->load->library('pdfProductos');
 
        // Se obtienen los productos de la base de datos
        $productos = $this->model_comercial->listarProductoFiltro();
        // se obtienen los tipos de cambio del día
        $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }

        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfProductos();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Productos");
        $this->pdf->SetLeftMargin(25);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($productos);
  		if($existe > 0){ 
        	$this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(25,9,utf8_decode('ID PRODUCTO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(90,9,utf8_decode('NOMBRE O DESCRIPCIÓN DEL PRODUCTO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(24,9,utf8_decode('CATEGORIA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(24,9,utf8_decode('PROCEDENCIA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(20,9,utf8_decode('UNIDAD MED.'),'BLTR',0,'C','1');
	        $this->pdf->Cell(25,9,utf8_decode('MÁQUINA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(15,9,utf8_decode('STOCK'),'BLTR',0,'C','1');
	        $this->pdf->Cell(19,9,utf8_decode('PRECIO UNI.'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        $suma_soles = 0;
	        foreach ($productos as $prod) {
	        	$suma_soles = $suma_soles + ($prod->stock*$prod->precio_unitario);
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada user
	            //$this->pdf->Cell(25,5,$user->id_user,'B',0,'L',0);
	            $this->pdf->Cell(25,8,$prod->id_producto,'BR BT',0,'C',0);
	            $this->pdf->Cell(90,8,$prod->no_producto,'BR BT',0,'C',0);
	            $this->pdf->Cell(24,8,$prod->no_categoria,'BR BT',0,'C',0);
	            $this->pdf->Cell(24,8,$prod->no_procedencia,'BR BT',0,'C',0);
	            $this->pdf->Cell(20,8,$prod->unidad_medida,'BR BT',0,'C',0);
	            $this->pdf->Cell(25,8,$prod->nombre_maquina,'BR BT',0,'C',0);
	            $this->pdf->Cell(15,8,$prod->stock,'BR BT',0,'C',0);
	            $this->pdf->Cell(19,8,$prod->precio_unitario,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }
	        $suma_dolares = $suma_soles / $dolar_venta;
	        $suma_euros = $suma_soles / $euro_venta;
	        $suma_libras = $suma_soles / $fr_venta;
	        /*$this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);*/
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(125,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);
	        $this->pdf->Cell(160,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma_soles, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,'IMPORTE TOTAL DE INGRESOS EN EUROS',0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('E. ').@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);
	        $this->pdf->Cell(160,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'Fr. '.@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
        }
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de Productos.pdf", 'I');
	}

	public function reporteingreso_producto_pdf(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfIngresos');

	    // Se obtienen los alumnos de la base de datos
	    $reg_ingresos = $this->model_comercial->listaRegistros_productoFiltroPdf();
 		// se obtienen los tipos de cambio del día
        $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfIngresos();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Registros de Ingreso");
        $this->pdf->SetLeftMargin(25);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($reg_ingresos);
  		if($existe > 0){
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(26,9,utf8_decode('N° DE FACTURA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(31,9,utf8_decode('MONEDA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(43,9,utf8_decode('PROVEEDOR'),'BLTR',0,'C','1');
	        $this->pdf->Cell(30,9,utf8_decode('FECHA DE REGISTRO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(74,9,utf8_decode('NOMBRE DEL PRODUCTO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(20,9,utf8_decode('PREC. UNIT.'),'BLTR',0,'C','1');
	        $this->pdf->Cell(18,9,utf8_decode('UNIDADES'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        $suma = 0;
	        foreach ($reg_ingresos as $reg) {
	        	$this->db->select('dolar_venta,euro_venta,fr_venta');
		        $this->db->where('fecha_actual',$reg->fecha);
		        $query = $this->db->get('tipo_cambio');
		        foreach($query->result() as $row){
		            $dolar_venta_fechaR = $row->dolar_venta;
		            $euro_venta_fechaR = $row->euro_venta;
		            $fr_venta_fechaR = $row->fr_venta;
		        }
	        	if($reg->no_moneda == 'DOLARES'){
	        		$convert_soles = $reg->precio * $dolar_venta_fechaR;
	        		$suma = $suma + ($convert_soles * $reg->unidades);
	        	}else if($reg->no_moneda == 'EURO'){
	                $convert_soles = $reg->precio * $euro_venta_fechaR;
	                $suma = $suma + ($convert_soles * $reg->unidades);
	            }else if($reg->no_moneda == 'FRANCO SUIZO'){
	                $convert_soles = $reg->precio * $fr_venta_fechaR;
	                $suma = $suma + ($convert_soles * $reg->unidades);
	            }else{
	            	$suma = $suma + ($reg->precio * $reg->unidades);	
	            }
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada reg
	            //$this->pdf->Cell(25,5,$reg->id_reg,'B',0,'L',0);
	            $this->pdf->Cell(26,8,$reg->nro_comprobante,'BR BT',0,'C',0);
	            $this->pdf->Cell(31,8,utf8_decode($reg->nombresimbolo),'BR BT',0,'C',0);
	            $this->pdf->Cell(43,8,$reg->razon_social,'BR BT',0,'C',0);
	            $this->pdf->Cell(30,8,$reg->fecha,'BR BT',0,'C',0);
	            $this->pdf->Cell(74,8,$reg->no_producto,'BR BT',0,'C',0);
	            $this->pdf->Cell(20,8,$reg->precio,'BR BT',0,'C',0);
	            $this->pdf->Cell(18,8,$reg->unidades,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }

	        $suma_dolares = $suma / $dolar_venta;
	        $suma_euros = $suma / $euro_venta;
	        $suma_libras = $suma / $fr_venta;

	        $this->pdf->Ln(4);
	        $this->pdf->Cell(125,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);

	        $this->pdf->Cell(160,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,'IMPORTE TOTAL DE INGRESOS EN EUROS',0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('E. ').@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'Fr. '.@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
	    }
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de Registro de Ingreso de Productos.pdf", 'I');
	}

	public function reporteingreso_producto_pdf_otros(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfIngresos_otros');

	    // Se obtienen los alumnos de la base de datos
	    $reg_ingresos = $this->model_comercial->listaRegistros_productoFiltroPdf_otros();
 		// se obtienen los tipos de cambio del día
        $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfIngresos_otros();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Registros de Ingreso");
        $this->pdf->SetLeftMargin(10);
        $this->pdf->SetRightMargin(5);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($reg_ingresos);
  		if($existe > 0){
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(30,9,utf8_decode('COMPROBANTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(25,9,utf8_decode('N° DE COMP.'),'BLTR',0,'C','1');
	        $this->pdf->Cell(31,9,utf8_decode('MONEDA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(43,9,utf8_decode('PROVEEDOR'),'BLTR',0,'C','1');
	        $this->pdf->Cell(32,9,utf8_decode('FECHA DE REGISTRO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(68,9,utf8_decode('NOMBRE DEL PRODUCTO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(20,9,utf8_decode('PREC. UNIT.'),'BLTR',0,'C','1');
	        $this->pdf->Cell(18,9,utf8_decode('UNIDADES'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        $suma = 0;
	        foreach ($reg_ingresos as $reg) {
	        	// Obtengo el tipo de cambio del día con el que se registro la factura
		        $this->db->select('dolar_venta,euro_venta,fr_venta');
		        $this->db->where('fecha_actual',$reg->fecha);
		        $query = $this->db->get('tipo_cambio');
		        foreach($query->result() as $row){
		            $dolar_venta_fechaR = $row->dolar_venta;
		            $euro_venta_fechaR = $row->euro_venta;
		            $fr_venta_fechaR = $row->fr_venta;
		        }

	        	if($reg->no_moneda == 'DOLARES'){
	        		$convert_soles = $reg->precio * $dolar_venta_fechaR;
	        		$suma = $suma + ($convert_soles * $reg->unidades);
	        	}else if($reg->no_moneda == 'EURO'){
	                $convert_soles = $reg->precio * $euro_venta_fechaR;
	                $suma = $suma + ($convert_soles * $reg->unidades);
	            }else if($reg->no_moneda == 'FRANCO SUIZO'){
	                $convert_soles = $reg->precio * $fr_venta_fechaR;
	                $suma = $suma + ($convert_soles * $reg->unidades);
	            }else{
	            	$suma = $suma + ($reg->precio * $reg->unidades);	
	            }
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada reg
	            //$this->pdf->Cell(25,5,$reg->id_reg,'B',0,'L',0);
	            $this->pdf->Cell(30,8,utf8_decode($reg->no_comprobante),'BR BT',0,'C',0);
	            $this->pdf->Cell(25,8,$reg->nro_comprobante,'BR BT',0,'C',0);
	            $this->pdf->Cell(31,8,utf8_decode($reg->nombresimbolo),'BR BT',0,'C',0);
	            $this->pdf->Cell(43,8,$reg->razon_social,'BR BT',0,'C',0);
	            $this->pdf->Cell(32,8,$reg->fecha,'BR BT',0,'C',0);
	            $this->pdf->Cell(68,8,$reg->no_producto,'BR BT',0,'C',0);
	            $this->pdf->Cell(20,8,$reg->precio,'BR BT',0,'C',0);
	            $this->pdf->Cell(18,8,$reg->unidades,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }

	        $suma_dolares = $suma / $dolar_venta;
	        $suma_euros = $suma / $euro_venta;
	        $suma_libras = $suma / $fr_venta;

	        $this->pdf->Ln(4);
	        $this->pdf->Cell(125,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);

	        $this->pdf->Cell(160,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,'IMPORTE TOTAL DE INGRESOS EN EUROS',0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('E. ').@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'LE. '.@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
	    }
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de Registro de Ingreso de Productos.pdf", 'I');
	}

	public function reporteingreso_agente_pdf(){
		// Se carga el modelo alumno
	    $this->load->model('model_comercial');
	    // Se carga la libreria fpdf
	    $this->load->library('pdfIngresos');

	    // Se obtienen los alumnos de la base de datos
	    $reg_ingresos = $this->model_comercial->listaRegistros_agenteFiltroPdf();
	    // se obtienen los tipos de cambio del día
        $this->db->select('dolar_venta,euro_venta,fr_venta');
        $this->db->where('fecha_actual',date('Y-m-d'));
        $query = $this->db->get('tipo_cambio');
        foreach($query->result() as $row){
            $dolar_venta = $row->dolar_venta;
            $euro_venta = $row->euro_venta;
            $fr_venta = $row->fr_venta;
        }
        // Creacion del PDF
 
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new PdfIngresos();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Lista de Registros de Ingreso");
        $this->pdf->SetLeftMargin(25);
        $this->pdf->SetRightMargin(25);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 7);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        /*$this->pdf->Cell(245,9,utf8_decode('LISTA DE PROVEEDORES'),'TBR TBL',0,'C','1');
        $this->pdf->Ln(9);
        */
        $existe = count($reg_ingresos);
  		if($existe > 0){
	        $this->pdf->Cell(10,9,utf8_decode('N°'),'BLTR',0,'C','1'); //La letra "C" indica la alineación del texto dentro del campo de la tabla: Center, Left L, Rigth R
	        //$this->pdf->Cell(25,8,'ID','TB',0,'L','1');
	        $this->pdf->Cell(26,9,utf8_decode('N° DE FACTURA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(50,9,utf8_decode('PROVEEDOR'),'BLTR',0,'C','1');
	        $this->pdf->Cell(32,9,utf8_decode('FECHA DE REGISTRO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(31,9,utf8_decode('MONEDA'),'BLTR',0,'C','1');
	        $this->pdf->Cell(23,9,utf8_decode('MONTO TOTAL'),'BLTR',0,'C','1');
	        $this->pdf->Cell(36,9,utf8_decode('AGENTE'),'BLTR',0,'C','1');
	        $this->pdf->Cell(26,9,utf8_decode('PORC. ASIGNADO'),'BLTR',0,'C','1');
	        $this->pdf->Cell(18,9,utf8_decode('GASTOS'),'BLTR',0,'C','1');
	        $this->pdf->Ln(9);
	        // La variable $x se utiliza para mostrar un número consecutivo
	        $x = 1;
	        $suma = 0;
	        foreach ($reg_ingresos as $reg) {
	        	// se obtienen los tipos de cambio del día
		        $this->db->select('dolar_venta,euro_venta,fr_venta');
		        $this->db->where('fecha_actual',$reg->fecha);
		        $query = $this->db->get('tipo_cambio');
		        foreach($query->result() as $row){
		            $dolar_venta_fechaR = $row->dolar_venta;
		            $euro_venta_fechaR = $row->euro_venta;
		            $fr_venta_fechaR = $row->fr_venta;
		        }

	        	$porcentaje = $reg->gastos*100;
	        	$gasto_agente = $reg->total * $reg->gastos;

	        	if($reg->no_moneda == 'DOLARES'){
	                  $convert_soles = $gasto_agente * $dolar_venta_fechaR;
	                  $suma = $suma + $convert_soles;
	            }else if($reg->no_moneda == 'EURO'){
	                  $convert_soles = $gasto_agente * $euro_venta_fechaR;
	                  $suma = $suma + $convert_soles;
	            }else if($reg->no_moneda == 'FRANCO SUIZO'){
	                  $convert_soles = $gasto_agente * $fr_venta_fechaR;
	                  $suma = $suma + $convert_soles;
	            }else{
	                  $suma = $suma + $gasto_agente;
	            }
	            // se imprime el numero actual y despues se incrementa el valor de $x en uno
	            $this->pdf->Cell(10,8,$x++,'BR BL BT',0,'C',0);
	            // Se imprimen los datos de cada reg
	            //$this->pdf->Cell(25,5,$reg->id_reg,'B',0,'L',0);
	            $this->pdf->Cell(26,8,$reg->nro_comprobante,'BR BT',0,'C',0);
	            $this->pdf->Cell(50,8,$reg->razon_social,'BR BT',0,'C',0);
	            $this->pdf->Cell(32,8,$reg->fecha,'BR BT',0,'C',0);
	            $this->pdf->Cell(31,8,utf8_decode($reg->nombresimbolo),'BR BT',0,'C',0);
	            $this->pdf->Cell(23,8,$reg->total,'BR BT',0,'C',0);
	            $this->pdf->Cell(36,8,$reg->no_agente,'BR BT',0,'C',0);
	            $this->pdf->Cell(26,8,$porcentaje.'%','BR BT',0,'C',0);
	            $this->pdf->Cell(18,8,@number_format($gasto_agente, 2, '.', ''),'BR BT',0,'C',0);
	            //$this->pdf->Cell(18,8,$,'BR BT',0,'C',0);
	            //Se agrega un salto de linea
	            $this->pdf->Ln(8);
	        }

	        $suma_dolares = $suma / $dolar_venta;
	        $suma_euros = $suma / $euro_venta;
	        $suma_libras = $suma / $fr_venta;

	        $this->pdf->Ln(4);
	        $this->pdf->Cell(125,8,'',0,'R',0,0);
	        $this->pdf->Cell(30,5,'RESUMEN DE TOTALES','B','R',0,0);
	        $this->pdf->Ln(6);

	        $this->pdf->Cell(160,8,'Tipo de Cambio al '.date('d-m-Y'),0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE GASTOS EN SOLES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'S/. '.@number_format($suma, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Dólar ').$dolar_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN DÓLARES'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'$. '.@number_format($suma_dolares, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Euro ').$euro_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,'IMPORTE TOTAL DE INGRESOS EN EUROS',0,'R','R',0);
	        $this->pdf->Cell(25,8,utf8_decode('E. ').@number_format($suma_euros, 2, '.', ''),0,0,'R',0);
	        $this->pdf->Ln(4);

	        $this->pdf->Cell(160,8,utf8_decode('Venta Fr. Suizo ').$fr_venta,0,'L','R',0);
	        $this->pdf->Cell(65,8,utf8_decode('IMPORTE TOTAL DE INGRESOS EN FR. SUIZO'),0,'R','R',0);
	        $this->pdf->Cell(25,8,'Fr. '.@number_format($suma_libras, 2, '.', ''),0,0,'R',0);
	    }
        else
        {
        	$this->pdf->Cell(100,8,utf8_decode('NO EXISTEN RESULTADOS PARA EL TIPO DE BÚSQUEDA QUE HA SELECCIONADO'),0,'R','R',0);
  		}
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de Proveedores.pdf", 'I');
	}

	public function guardarTipoCambio()
	{
		$this->form_validation->set_rules('compra_dol', 'Compra en Dólares', 'trim|required|min_length[4]|max_length[5]|xss_clean');
		$this->form_validation->set_rules('venta_dol', 'Venta en Dólares', 'trim|required|min_length[4]|max_length[5]|xss_clean');
		$this->form_validation->set_rules('compra_eur', 'Compra en Euros', 'trim|required|min_length[4]|max_length[5]|xss_clean');
		$this->form_validation->set_rules('venta_eur', 'Venta en Euros', 'trim|required|min_length[4]|max_length[5]|xss_clean');
		$this->form_validation->set_rules('compra_fr', 'Compra en Franco Suizo', 'trim|required|min_length[4]|max_length[5]|xss_clean');
		$this->form_validation->set_rules('venta_fr', 'Venta en Franco Suizo', 'trim|required|min_length[4]|max_length[5]|xss_clean');
		//Mensajes
		$this->form_validation->set_message('required','ERROR: Falta completar el campo: %s.');
		$this->form_validation->set_message('min_length','ERROR: El campo %s debe tener 4 dígitos como mínimo.');
		$this->form_validation->set_message('max_length','ERROR: El campo %s debe tener 5 dígitos como máximo.');
		//Dolimitadores de ERROR: Color
		$this->form_validation->set_error_delimiters('<span style="color:red;font-size:10px">', '</span><br>');

		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
        	$datacompra_dol = $this->security->xss_clean($this->input->post('compra_dol'));
        	$dataventa_dol = $this->security->xss_clean($this->input->post('venta_dol'));
        	$datacompra_eur = $this->security->xss_clean($this->input->post('compra_eur'));
        	$dataventa_eur = $this->security->xss_clean($this->input->post('venta_eur'));
        	$datacompra_fr = $this->security->xss_clean($this->input->post('compra_fr'));
        	$dataventa_fr = $this->security->xss_clean($this->input->post('venta_fr'));
        	if(!empty($datacompra_dol) && !empty($dataventa_dol) && !empty($datacompra_eur) && !empty($dataventa_eur) && !empty($datacompra_fr) && !empty($dataventa_fr)){	
		        $result = $this->model_comercial->saveTipoCambio();
		        if(!$result){
		            echo '<span style="color:red">ERROR: No se puede guardar ni actualizar.</span>';
		        }else{
		        	echo 'ok';
		        }
        	}else{ 
        		echo 'no'; 
        	}
		}
	}
	/*
	public function eliminarregistroingreso()
	{
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$id_registro_ingreso = $this->security->xss_clean($this->input->post('id_ingreso_producto'));
		$result = $this->model_comercial->eliminarRegistroIngreso_aleatorio($id_registro_ingreso,$almacen);
		if(!$result){
            echo 'dont_delete';
        }else{
        	echo '1';
        }
	}
	*/
	public function eliminarregistroingreso()
    {   
        $this->db->trans_begin();
        $contador_kardex_v = 0;
        $contador_kardex = 0;
        $aux = 0;
        $almacen = $this->security->xss_clean($this->session->userdata('almacen'));
        $id_registro_ingreso = $this->security->xss_clean($this->input->post('id_ingreso_producto'));
        // validar que la factura a eliminar no corresponde a una fecha en la que ya se realizo un cierre
        $result_fecha_factura = $this->model_comercial->get_fecha_factura_eliminar($id_registro_ingreso);
        foreach ($result_fecha_factura as $row_fecha){
            $fecha_registro = $row_fecha->fecha;
            // formato de fecha para la comparacion
            $elementos = explode("-", $fecha_registro);
            $anio = $elementos[0];
            $mes = $elementos[1];
            $dia = $elementos[2];
            // Validar si el mes es diciembre 12 : sino sale fuera de rango
            if($mes == 12){
                $anio = $anio + 1;
                $mes_siguiente = 1;
                $dia = 1;
            }else if($mes <= 11 ){
                $mes_siguiente = $mes + 1;
                $dia = 1;
            }
            $array = array($anio, $mes_siguiente, $dia);
            $fecha_formateada = implode("-", $array);
            // consulta si la factura corresponde a un periodo que ya cerro
            $elementos = explode("-", date('Y-m-d'));
	        $anio = $elementos[0];
	        $mes = $elementos[1];
	        $dia = $elementos[2];
	        // personalizar
	        $anio = $anio;
	        $mes = 1;
	        $dia = 1;
	        // fecha inicial
	        $array = array($anio, $mes, $dia);
	        $fecha_inicial = implode("-", $array);
	        $fecha_inicial = date("Y-m-d", strtotime($fecha_inicial));
	        // var_dump($fecha_inicial);
	        // validacion
            $this->db->select('id_saldos_iniciales');
            $this->db->where('fecha_cierre',$fecha_formateada);
            $query = $this->db->get('saldos_iniciales');
            if($query->num_rows() > 0){
                echo 'periodo_cerrado';
            }else{
                // Proceso de validacion de resultados
                // Eliminar el kardex de cada producto asociado a la factura e ir actualizando el stock y su precio unitario
                $result_mov_kardex_v = $this->model_comercial->get_kardex_producto_eliminar($id_registro_ingreso); // trae los productos asociados a la factura
                foreach ($result_mov_kardex_v as $row_mov_v){
                    // iniciar valores
                    $stock_saldo_final = 0;
                    $precio_unitario_saldo_final = 0;
                    // obtener valores de la consulta
                    $id_detalle_producto = $row_mov_v->id_detalle_producto;
                    //$id_detalle_producto = 7455;
                    $fecha_registro = $row_mov_v->fecha;
                    $nro_comprobante = $row_mov_v->nro_comprobante;
                    $id_area = $row_mov_v->id_area;
                    $id_pro = $row_mov_v->id_pro;
                    // $id_pro = 7382;
                    $unidades_entrada = $row_mov_v->unidades;
                    // obtener los saldos iniciales para iniciar con el recorrido
                    $saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($fecha_inicial,$id_pro);
                    if( count($saldos_iniciales) > 0 ){
                    	foreach ($saldos_iniciales as $result) {
                    		$total_saldos_iniciales = $result->stock_inicial + $result->stock_inicial_sta_clara;
                    		$stock_inicial_kardex = $total_saldos_iniciales;
                    		$precio_unitario_inicial_kardex = $result->precio_uni_inicial;
                    	}
                    }else{
                    	$stock_inicial_kardex = 0;
                		$precio_unitario_inicial_kardex = 0;
                    }
                    // var_dump('saldos '.$stock_inicial_kardex.' '.$precio_unitario_inicial_kardex);
                    // actualizacion del stock y precio unitario del podructo en funcion del kardex
                    $detalle_movimientos_kardex_v = $this->model_comercial->traer_movimientos_kardex_eliminar($id_detalle_producto);
                    $existe_v = count($detalle_movimientos_kardex_v);
                    if($existe_v > 0){
                        foreach ($detalle_movimientos_kardex_v as $data_v) {
                            $numero_comprobante_kardex_v = $data_v->num_comprobante;
                            $fecha_registro_kardex_v = $data_v->fecha_registro;
                            // Obtener del id de ingreso de producto, por medio del numero del comprobante de la tabla ingreso_producto


                            // var_dump("ENTRADA ".$data_v->descripcion." ");
                            if($nro_comprobante != $numero_comprobante_kardex_v){ // OJO !! revisar que al momento de eliminar no se intente eliminar una factura duplicada 
                            	//porque no estar contando como entrada ninguna de las dos factura y saldra negativo, ahora ultimo estoy agregando la fecha como tipo de filtro pero solo servira
                            	// cuando sea duplicado pero con fechas diferentes, AQUI SE TIENE QUE APLICAR UN FILTRO DIFERENTE PARA IDENTIFICAR QUE NO SEAN IGUALES
                            	// PUEDE SER POR EL ID DEL REGISTRO
                                if($data_v->descripcion == "ENTRADA" || $data_v->descripcion == "IMPORTACION"){
                                    if($contador_kardex_v == 0){
                                    	// var_dump("SI ".$stock_inicial_kardex." ");
                                        $stock_saldo_final = $stock_inicial_kardex + $data_v->cantidad_ingreso;
                            			$precio_unitario_saldo_final = (($data_v->cantidad_ingreso*$data_v->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data_v->cantidad_ingreso + $stock_inicial_kardex);
                                        $contador_kardex_v++;
                                        // var_dump("ENTRADA ".$data_v->cantidad_ingreso." ");
                                        // if( $id_detalle_producto == 3971 ){
                                        	// var_dump("SI ".$stock_inicial_kardex." ");
                                        	// var_dump("ENTRADA ".$data_v->cantidad_ingreso." ");
                                        	// var_dump("SALDO FINAL ".$stock_saldo_final." <br>");
                                        // }
                                    }else{
                                    	// var_dump("ENTRADA ".$data_v->cantidad_ingreso." ");
                                        $stock_antes_actualizar = $stock_saldo_final;
                                        $stock_saldo_final = $stock_saldo_final + $data_v->cantidad_ingreso;
                                        $precio_unitario_saldo_final = (($data_v->cantidad_ingreso*$data_v->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data_v->cantidad_ingreso + $stock_antes_actualizar);
                                        // if( $id_detalle_producto == 3971 ){
                                        	// var_dump("ENTRADA ".$data_v->cantidad_ingreso." ");
                                        	// var_dump("SALDO FINAL ".$stock_saldo_final." <br>");
                                        // }
                                    }
                                }else if($data_v->descripcion == "SALIDA"){
                                	if($contador_kardex_v == 0){
                                		// var_dump("SALIDA ".$data_v->cantidad_salida." ");
                                		$stock_saldo_final = $stock_inicial_kardex - $data_v->cantidad_salida;
                            			$precio_unitario_saldo_final = $precio_unitario_inicial_kardex;
                            			$contador_kardex++;
                            			// if( $id_detalle_producto == 3971 ){
                            				// var_dump("SI ".$stock_inicial_kardex." ");
                                        	// var_dump("SALIDA ".$data_v->cantidad_salida." ");
                                        	// var_dump("SALDO FINAL ".$stock_saldo_final." <br>");
                            			// }
                                	}else{
                                		// var_dump("SALIDA ".$data_v->cantidad_salida." ");
	                                    $stock_saldo_final = $stock_saldo_final - $data_v->cantidad_salida;
	                                    $precio_unitario_saldo_final = $precio_unitario_saldo_final;
	                                    // if( $id_detalle_producto == 3971 ){
                                        	// var_dump("SALIDA ".$data_v->cantidad_salida." ");
                                        	// var_dump("SALDO FINAL ".$stock_saldo_final." <br>");
                            			// }
                                	}
                                }else if($data_v->descripcion == "ORDEN INGRESO"){
                                    if($contador_kardex_v == 0){
                                    	$stock_saldo_final = $stock_inicial_kardex + $data_v->cantidad_ingreso;
			                            $precio_unitario_saldo_final = (($data_v->cantidad_ingreso*$data_v->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data_v->cantidad_ingreso + $stock_inicial_kardex);
			                            $contador_kardex++;
                                    }else{
	                                    $stock_saldo_final = $stock_saldo_final + $data_v->cantidad_ingreso;
	                                    $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                                    }
                                }
                            }
                        }
                    }else{
                        $stock_saldo_final = 0;
                        $precio_unitario_saldo_final = 0;
                    }

                    if($stock_saldo_final < 0 || $precio_unitario_saldo_final < 0){
                        // echo 'valores_negativos_producto '.$stock_saldo_final." ".$precio_unitario_saldo_final." ";
                        var_dump($id_detalle_producto." ".$stock_saldo_final." ".$precio_unitario_saldo_final." \n");
                        $aux++;
                    }
                    //die();
                }

                if($aux == 0){
                    // Eliminar el kardex de cada producto asociado a la factura e ir actualizando el stock y su precio unitario
                    $result_mov_kardex = $this->model_comercial->get_kardex_producto_eliminar($id_registro_ingreso); // trae los productos asociados a la factura
                    foreach ($result_mov_kardex as $row_mov){
                        // iniciar valores
                        $stock_saldo_final = 0;
                        $precio_unitario_saldo_final = 0;
                        // obtener valores de la consulta
                        $id_detalle_producto = $row_mov->id_detalle_producto;
                        $fecha_registro = $row_mov->fecha;
                        $nro_comprobante = $row_mov->nro_comprobante;
                        $id_area = $row_mov->id_area;
                        $id_pro = $row_mov->id_pro;
                        $unidades = $row_mov->unidades;
                        // eliminacion del kardex del producto
                        $sql = "DELETE FROM kardex_producto WHERE id_detalle_producto = " . $id_detalle_producto . " AND DATE(fecha_registro) = '" .$fecha_registro."' AND num_comprobante = '" .$nro_comprobante."'";
                        $query = $this->db->query($sql);
                        // obtener los saldos iniciales para iniciar con el recorrido
	                    $saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($fecha_inicial,$id_pro);
	                    if( count($saldos_iniciales) > 0 ){
	                    	foreach ($saldos_iniciales as $result) {
	                    		$total_saldos_iniciales = $result->stock_inicial + $result->stock_inicial_sta_clara;
	                    		$stock_inicial_kardex = $total_saldos_iniciales;
	                    		$precio_unitario_inicial_kardex = $result->precio_uni_inicial;
	                    	}
	                    }else{
	                    	$stock_inicial_kardex = 0;
	                		$precio_unitario_inicial_kardex = 0;
	                    }
                        // actualizacion del stock y precio unitario del podructo en funcion del kardex // para lo cual necesitamos obtener el ultimo registro en el kardex de ese producto
                        $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex_eliminar($id_detalle_producto);
                        $existe = count($detalle_movimientos_kardex);
                        if($existe > 0){
                            foreach ($detalle_movimientos_kardex as $data) {
                                if($data->descripcion == "ENTRADA" || $data->descripcion == "IMPORTACION"){
                                    if($contador_kardex == 0){
                                        $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
                                        $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
                                        $contador_kardex++;
                                    }else{
                                        $stock_antes_actualizar = $stock_saldo_final;
                                        $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                                        $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
                                    }
                                }else if($data->descripcion == "SALIDA"){
                                    if($contador_kardex == 0){
                                    	$stock_saldo_final = $stock_inicial_kardex - $data->cantidad_salida;
										$precio_unitario_saldo_final = $precio_unitario_inicial_kardex;
										$contador_kardex++;
                                    }else{
	                                    $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
	                                    $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                                    }
                                }else if($data->descripcion == "ORDEN INGRESO"){
                                    if($contador_kardex == 0){
                                    	$stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
                                        $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
                                        $contador_kardex++;
                                    }else{
	                                    $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
	                                    $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                                    }
                                }
                            }
                        }else{
                            $stock_saldo_final = 0;
                            $precio_unitario_saldo_final = 0;
                        }

                        // obtener el stock del producto de acuerdo al almacen para descontar // STOCK GENERAL
                        $this->db->select('stock,stock_sta_clara');
				        $this->db->where('id_detalle_producto',$id_detalle_producto);
				        $query = $this->db->get('detalle_producto');
					    if(count($query->result()) > 0){
					        foreach($query->result() as $row){
					            $stock_sta_anita = $row->stock;
					            $stock_sta_clara = $row->stock_sta_clara;
					        }
					        if($almacen == 1){
					        	$actualizar_p_u_2 = array(
		                            'precio_unitario'=> $precio_unitario_saldo_final,
		                            'stock_sta_clara' => $stock_saldo_final - $stock_sta_anita
		                        );
		                        $this->db->where('id_detalle_producto',$id_detalle_producto);
		                        $this->db->update('detalle_producto', $actualizar_p_u_2);
					        }else if($almacen == 2){
					        	$actualizar_p_u_2 = array(
		                            'precio_unitario'=> $precio_unitario_saldo_final,
		                            'stock' => $stock_saldo_final - $stock_sta_clara
		                        );
		                        $this->db->where('id_detalle_producto',$id_detalle_producto);
		                        $this->db->update('detalle_producto', $actualizar_p_u_2);
					        }
					    }

					    // REGRESAR EL STOCK POR AREA DE LOS PRODUCTOS
					    $this->db->select('stock_area_sta_anita,stock_area_sta_clara');
				        $this->db->where('id_area',$id_area);
				        $this->db->where('id_pro',$id_pro);
				        $query = $this->db->get('detalle_producto_area');
				        if(count($query->result()) > 0){
				        	foreach($query->result() as $row){
					            $stock_area_sta_anita = $row->stock_area_sta_anita;
					            $stock_area_sta_clara = $row->stock_area_sta_clara;
					        }
					        if($almacen == 1){
					        	$actualizar_p_u_area = array(
		                            'stock_area_sta_clara' => $stock_area_sta_clara - $unidades
		                        );
		                        $this->db->where('id_area',$id_area);
				        		$this->db->where('id_pro',$id_pro);
		                        $this->db->update('detalle_producto_area', $actualizar_p_u_area);
					        }else if($almacen == 2){
					        	$actualizar_p_u_area = array(
		                            'stock_area_sta_anita' => $stock_area_sta_anita - $unidades
		                        );
		                        $this->db->where('id_area',$id_area);
				        		$this->db->where('id_pro',$id_pro);
		                        $this->db->update('detalle_producto_area', $actualizar_p_u_area);
					        }

				        }

                    }
                    // ELIMINAR REGISTROS
                    $sql = "DELETE FROM adm_facturas_asociadas WHERE id_ingreso_producto = " . $id_registro_ingreso . "";
                    $query = $this->db->query($sql);

                    $sql = "DELETE FROM detalle_ingreso_producto WHERE id_ingreso_producto = " . $id_registro_ingreso . "";
                    $query = $this->db->query($sql);

                    $sql = "DELETE FROM ingreso_producto WHERE id_ingreso_producto = " . $id_registro_ingreso . "";
                    $query = $this->db->query($sql);

                    echo 'eliminacion_correcta';
                    $this->db->trans_complete();
                }else{
                    echo 'valores_negativos_producto';
                }
            }
        }
    }

    public function al_exportar_kardex_producto_excel_v2(){
        $data = $this->security->xss_clean($this->uri->segment(3));
        $data = json_decode($data, true);
        $id_detalle_producto = $data[0];
        $f_inicial = $data[1];
        $f_final = $data[2];

        (array)$arr = str_split($f_final, 4);
        $anio = $arr[0];

        // Formato para la fecha inicial
        $elementos = explode("-", $f_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        $array = array($dia, $mes, $anio);
        $f_inicial = implode("-", $array);
        // Fin

        $this->load->library('pHPExcel');
        /* variables de PHPExcel */
        $objPHPExcel = new PHPExcel();
        $nombre_archivo = "phpExcel";

        /* propiedades de la celda */
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

        /* Here your first sheet */
        $sheet = $objPHPExcel->getActiveSheet();

        /* Traer informacion de la BD */
        $nombre_productos_salidas = $this->model_comercial->traer_nombres_kardex_producto($id_detalle_producto);
        /* Recorro con todos los nombres seleccionados que tienen una salida/ingreso en el kardex */
        /*  */
        $i = 0;
        foreach ($nombre_productos_salidas as $reg) {
            $nombre_producto = $reg->no_producto;
            $id_unidad_medida = $reg->id_unidad_medida;
            $id_detalle_producto = $reg->id_detalle_producto;
            $id_pro = $reg->id_pro;

            // Add new sheet
            $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
            $objPHPExcel->setActiveSheetIndex($i)->mergeCells('A1:D1');
            $objPHPExcel->setActiveSheetIndex($i)->mergeCells('A12:D12');
            $objPHPExcel->setActiveSheetIndex($i)->mergeCells('E12:G12');
            $objPHPExcel->setActiveSheetIndex($i)->mergeCells('H12:J12');
            $objPHPExcel->setActiveSheetIndex($i)->mergeCells('K12:M12');

            /* Style - Bordes */
            $borders = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    )
                ),
            );

            $style = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
            );

            $style_2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                )
            );

            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($borders);

            $objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

            $objPHPExcel->getActiveSheet()->getStyle('A1:D10')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F1:F10')->applyFromArray($styleArray);
            //Write cells
            $objWorkSheet->setCellValue('A1', 'INVENTARIO PERMANENTE VALORIZADO')
                         ->setCellValue('A2', 'PERIODO: '.$anio)
                         ->setCellValue('A3', 'RUC: 20101717098')
                         ->setCellValue('A4', 'TEJIDOS JORGITO SRL')
                         ->setCellValue('A5', 'CALLE LOS TELARES No 103-105 URB. VULCANO-ATE')
                         ->setCellValue('A6', 'CÓDIGO: PRD'.$id_pro)
                         ->setCellValue('A7', 'TIPO: 03')
                         ->setCellValue('A8', 'DESCRIPCIÓN: '.$nombre_producto)
                         ->setCellValue('A9', 'UNIDAD DE MEDIDA: '.$id_unidad_medida)
                         ->setCellValue('A10', 'MÉTODO DE EVALUACIÓN: COSTO PROMEDIO');
            $objWorkSheet->setCellValue('F1', 'FT: FACTURA')
                         ->setCellValue('F2', 'GR: GUÍA DE REMISIÓN')
                         ->setCellValue('F3', 'BV: BOLETA DE VENTA')
                         ->setCellValue('F4', 'NC: NOTA DE CRÉDITO')
                         ->setCellValue('F5', 'ND: NOTA DE DÉBITO')
                         ->setCellValue('F6', 'OS: ORDEN DE SALIDA')
                         ->setCellValue('F7', 'OI: ORDEN DE INGRESO')
                         ->setCellValue('F8', 'CU: COSTO UNITARIO (NUEVOS SOLES)')
                         ->setCellValue('F9', 'CT: COSTO TOTAL (NUEVOS SOLES)')
                         ->setCellValue('F10', 'SI: SALDO INICIAL');
            $objWorkSheet->setCellValue('A12', 'DOCUMENTO DE MOVIMIENTO')
                         ->setCellValue('E12', 'ENTRADAS')
                         ->setCellValue('H12', 'SALIDAS')
                         ->setCellValue('K12', 'SALDO FINAL');
            $objWorkSheet->setCellValue('A13', 'FECHA')
                         ->setCellValue('B13', 'TIPO')
                         ->setCellValue('C13', 'SERIE')
                         ->setCellValue('D13', 'NÚMERO')
                         ->setCellValue('E13', 'CANTIDAD')
                         ->setCellValue('F13', 'CU')
                         ->setCellValue('G13', 'CT')
                         ->setCellValue('H13', 'CANTIDAD')
                         ->setCellValue('I13', 'CU')
                         ->setCellValue('J13', 'CT')
                         ->setCellValue('K13', 'CANTIDAD')
                         ->setCellValue('L13', 'CU')
                         ->setCellValue('M13', 'CT');

            /* Formato para la fila 14 */
            $objPHPExcel->getActiveSheet()->getStyle('A14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('B14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('A14')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('B14')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('F14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('G14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('H14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('I14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('J14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('K14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('L14')->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('M14')->applyFromArray($borders);

            /* Traer saldos iniciales de la BD */
            $saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($f_inicial,$id_pro);

            /* varianles para las sumatorias */
            $sumatoria_cantidad_entradas = 0;
            $sumatoria_parciales_entradas = 0;

            $sumatoria_cantidad_salidas = 0;
            $sumatoria_parciales_salidas = 0;

            $sumatoria_cantidad_saldos = 0;
            $sumatoria_parciales_saldos = 0;

            $objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('F14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('G14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('H14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('I14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('J14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('K14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('L14')->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('M14')->applyFromArray($style_2);

            $objPHPExcel->getActiveSheet()->getStyle('E14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('F14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('G14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('H14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('I14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('J14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('K14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('L14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('M14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            if( count($saldos_iniciales) > 0 ){
                foreach ($saldos_iniciales as $result) {
                    $total_saldos_iniciales = $result->stock_inicial + $result->stock_inicial_sta_clara;
                    /* Formato de Fecha */
                    $elementos = explode("-", $result->fecha_cierre);
                    $anio = $elementos[0];
                    $mes = $elementos[1];
                    $dia = $elementos[2];
                    $array = array($dia, $mes, $anio);
                    $fecha_formateada = implode("-", $array);
                    /* Fin */
                    $objWorkSheet->setCellValue('A14', $fecha_formateada)
                                 ->setCellValue('B14', " ")
                                 ->setCellValue('C14', "SI")
                                 ->setCellValue('D14', " ")
                                 ->setCellValue('E14', $total_saldos_iniciales)
                                 ->setCellValue('F14', $result->precio_uni_inicial)
                                 ->setCellValue('G14', $total_saldos_iniciales*$result->precio_uni_inicial)
                                 ->setCellValueExplicit('H14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                 ->setCellValue('I14', $result->precio_uni_inicial)
                                 ->setCellValueExplicit('J14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                 ->setCellValue('K14', $total_saldos_iniciales)
                                 ->setCellValue('L14', $result->precio_uni_inicial)
                                 ->setCellValue('M14', $total_saldos_iniciales*$result->precio_uni_inicial);
                    /* ENTRADAS */
                    $sumatoria_cantidad_entradas = $sumatoria_cantidad_entradas + $total_saldos_iniciales;
                    $sumatoria_parciales_entradas = $sumatoria_parciales_entradas + ($total_saldos_iniciales * $result->precio_uni_inicial);
                    /* SALDOS */
                    $sumatoria_cantidad_saldos = $sumatoria_cantidad_saldos + $total_saldos_iniciales;
                    $sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($total_saldos_iniciales * $result->precio_uni_inicial);
                    // Nuevo - Dejar el saldo inicial para los registros posteriores
                    $stock_inicial_kardex = $total_saldos_iniciales;
                    $precio_unitario_inicial_kardex = $result->precio_uni_inicial;

                }
            }else{
                $objWorkSheet->setCellValueExplicit('A14', $f_inicial)
                             ->setCellValueExplicit('B14', " ")
                             ->setCellValueExplicit('C14', "SI")
                             ->setCellValueExplicit('D14', " ")
                             ->setCellValueExplicit('E14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('F14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('G14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('H14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('I14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('J14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('K14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('L14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                             ->setCellValueExplicit('M14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING);
                // Nuevo - Dejar el saldo inicial para los registros posteriores
                $stock_inicial_kardex = 0;
                $precio_unitario_inicial_kardex = 0;
            }

            // Recorrido del detalle del kardex general por producto
            $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$f_inicial,$f_final);
            $existe = count($detalle_movimientos_kardex);
            $y = 0;
            $contador_kardex = 0;
            if($existe > 0){
                foreach ($detalle_movimientos_kardex as $data) {
                    $p = 15;
                    $p = $p + $y;
                    /* Centrar contenido */
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);

                    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style_2);
                    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style_2);

                    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
                    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);
                    /* formato de variables */
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                    /* Traer ID de salida del producto */
                    if($data->descripcion == "SALIDA"){
                        $fecha_salida = $data->fecha_registro;
                        $detalle_producto = $data->id_detalle_producto;
                        $cantidad_salida = $data->cantidad_salida;
                    }

                    /* Formato de Fecha */
                    $elementos = explode("-", $data->fecha_registro);
                    $anio = $elementos[0];
                    $mes = $elementos[1];
                    $dia = $elementos[2];
                    $array = array($dia, $mes, $anio);
                    $fecha_formateada_2 = implode("-", $array);
                    /* fin de formato */

                    if($data->descripcion == "ENTRADA"){
                        if($contador_kardex == 0){
                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
                            $contador_kardex++;
                        }else{
                            $stock_antes_actualizar = $stock_saldo_final;
                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
                        }
                        $objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
                                     ->setCellValue('B'.$p, "FT")
                                     ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('E'.$p, $data->cantidad_ingreso)
                                     ->setCellValue('F'.$p, $data->precio_unitario_actual)
                                     ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
                                     ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('I'.$p, $data->precio_unitario_actual)
                                     ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('K'.$p, $stock_saldo_final)
                                     ->setCellValue('L'.$p, $precio_unitario_saldo_final)
                                     ->setCellValue('M'.$p, $stock_saldo_final*$precio_unitario_saldo_final);
                    }else if($data->descripcion == "SALIDA"){
                        if($contador_kardex == 0){
                            $stock_saldo_final = $stock_inicial_kardex - $data->cantidad_salida;
                            $precio_unitario_saldo_final = $precio_unitario_inicial_kardex;
                            $contador_kardex++;
                        }else{
                            $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
                            $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                        }
                        $objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
                                     ->setCellValue('B'.$p, "OS")
                                     ->setCellValue('C'.$p, "NIG")
                                     ->setCellValueExplicit('D'.$p, str_pad($data->id_kardex_producto, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValueExplicit('E'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValueExplicit('F'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValueExplicit('G'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('H'.$p, $data->cantidad_salida)
                                     ->setCellValue('I'.$p, $precio_unitario_saldo_final)
                                     ->setCellValue('J'.$p, $data->cantidad_salida*$precio_unitario_saldo_final)
                                     ->setCellValue('K'.$p, $stock_saldo_final)
                                     ->setCellValue('L'.$p, $precio_unitario_saldo_final)
                                     ->setCellValue('M'.$p, $stock_saldo_final*$precio_unitario_saldo_final);
                    }else if($data->descripcion == "IMPORTACION"){
                        if($contador_kardex == 0){
                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
                            $contador_kardex++;
                        }else{
                            $stock_antes_actualizar = $stock_saldo_final;
                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
                        }
                        $objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
                                     ->setCellValue('B'.$p, "IMPORTACION")
                                     ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('E'.$p, $data->cantidad_ingreso)
                                     ->setCellValue('F'.$p, $data->precio_unitario_actual)
                                     ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
                                     ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('I'.$p, $data->precio_unitario_actual)
                                     ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('K'.$p, $stock_saldo_final)
                                     ->setCellValue('L'.$p, $precio_unitario_saldo_final)
                                     ->setCellValue('M'.$p, $stock_saldo_final*$precio_unitario_saldo_final);
                    }else if($data->descripcion == "ORDEN INGRESO"){
                        if($contador_kardex == 0){
                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
                            $contador_kardex++;
                        }else{
                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                            $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                        }
                        $objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
                                     ->setCellValue('B'.$p, "OI")
                                     ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('E'.$p, $data->cantidad_ingreso)
                                     ->setCellValue('F'.$p, $data->precio_unitario_actual)
                                     ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
                                     ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('I'.$p, $data->precio_unitario_actual)
                                     ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
                                     ->setCellValue('K'.$p, $stock_saldo_final)
                                     ->setCellValue('L'.$p, $precio_unitario_saldo_final)
                                     ->setCellValue('M'.$p, $stock_saldo_final*$precio_unitario_saldo_final);
                    }
                    /* ENTRADAS Y ORDEN DE INGRESO*/
                    $sumatoria_cantidad_entradas = $sumatoria_cantidad_entradas + $data->cantidad_ingreso;
                    $sumatoria_parciales_entradas = $sumatoria_parciales_entradas + ($data->cantidad_ingreso * $data->precio_unitario_actual);
                    /* SALIDAS */
                    $sumatoria_cantidad_salidas = $sumatoria_cantidad_salidas + $data->cantidad_salida;
                    $sumatoria_parciales_salidas = $sumatoria_parciales_salidas + ($data->cantidad_salida * $precio_unitario_saldo_final);
                    /* SALDOS */
                    $sumatoria_cantidad_saldos = $sumatoria_cantidad_saldos + $stock_saldo_final;
                    // Sumatoria de saldos parciales caso general
                    $sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($stock_saldo_final * $precio_unitario_saldo_final);
                    /*
                    if($data->descripcion == "SALIDA"){
                        $sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($stock_saldo_final * $precio_unitario_saldo_final);
                    }else if($data->descripcion == "ENTRADA"){
                        $sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($stock_saldo_final * $precio_unitario_saldo_final);
                    }else if($data->descripcion == "ORDEN INGRESO"){
                        $sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($stock_saldo_final * $precio_unitario_saldo_final);
                    }
                    */
                    $y = $y + 1;
                }
            }

            $p = 15 + $y;
            $objWorkSheet->setCellValue('A'.$p, "")
                         ->setCellValue('B'.$p, "")
                         ->setCellValue('C'.$p, "")
                         ->setCellValue('D'.$p, "TOTALES")
                         ->setCellValue('E'.$p, $sumatoria_cantidad_entradas)
                         ->setCellValue('F'.$p, "")
                         ->setCellValue('G'.$p, $sumatoria_parciales_entradas)
                         ->setCellValue('H'.$p, $sumatoria_cantidad_salidas)
                         ->setCellValue('I'.$p, "")
                         ->setCellValue('J'.$p, $sumatoria_parciales_salidas)
                         ->setCellValue('K'.$p, $sumatoria_cantidad_saldos)
                         ->setCellValue('L'.$p, "")
                         ->setCellValue('M'.$p, $sumatoria_parciales_saldos);

            /* Centrar contenido */
            $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);

            /* Dar formato numericos a las celdas */
            $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            /* Alinear el valor de la celda a la derecha */
            $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style_2);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style_2);

            /* Rename sheet */
            $objWorkSheet->setTitle("$nombre_producto");
            $i++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        /* datos de la salida del excel */
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$nombre_producto.xls");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

	public function eliminarsalidaproducto()
	{
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$id_salida_producto = $this->security->xss_clean($this->input->post('id_salida_producto'));
		$result = $this->model_comercial->eliminarSalidaProducto($id_salida_producto,$almacen);
		if($result == 'periodo_cierre'){
            echo 'periodo_cierre';
        }else if($result == 'registro_correcto'){
        	echo 'ok';
        }
	}

	public function procedimiento_eliminacion_salidas()
	{
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$fechainicial = $this->security->xss_clean($this->input->post("fechainicial"));
		$fechafinal = $this->security->xss_clean($this->input->post("fechafinal"));
		// Realizar  la consulta de las salidas a eliminar
		$reg_salidas_eliminadas = $this->model_comercial->get_salidas_eliminar($fechainicial, $fechafinal);
		foreach ($reg_salidas_eliminadas as $row){
			$id_salida_producto = $row->id_salida_producto;
			$fecha = $row->fecha;
			$result = $this->model_comercial->eliminarSalidaProducto($id_salida_producto,$almacen);
			var_dump($id_salida_producto.' ');
		}
		if(!$result){
            echo '<b>--> No puede eliminar Registros de un periodo donde se ya realizo el Cierre Mensual de Almacén.</b>';
        }else{
        	echo '1';
        }
	}

	public function actualizar_saldos_iniciales_controller(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$fechainicial = $this->security->xss_clean($this->input->post("fechainicial"));
		$fechafinal = $this->security->xss_clean($this->input->post("fechafinal"));
		// Formato a la fecha para actualizar los cierre anterior
		$elementos = explode("-", $fechainicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        if($mes == 12){
            $anio = $anio + 1;
            $mes_siguiente = 1;
            $dia = 1;
        }else if($mes <= 11 ){
            $mes_siguiente = $mes;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_anterior = implode("-", $array);
        // Formato a la fecha para actualizar los cierre anterior
		$elementos = explode("-", $fechafinal);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        if($mes == 12){
            $anio = $anio + 1;
            $mes_siguiente = 1;
            $dia = 1;
        }else if($mes <= 11 ){
            $mes_siguiente = $mes + 1;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_posterior = implode("-", $array);
		// Realizar un consulta de todos los productos registrados en el sistema
		// para verificar los movimientos de esos productos en el kardex y seleccionar el ultimo movimiento de ese mes
		// para obtener el stock y el precio final para el cierre del mes
		$data_product = $this->model_comercial->get_all_productos();
		foreach ($data_product as $row){
			$id_detalle_producto = $row->id_detalle_producto;
			$id_pro = $row->id_pro;
			// validacion si existe un registro de este producto en kardex dentro del periodo seleccionado
			$validacion = $this->model_comercial->validar_registros_producto_periodo($fechainicial, $fechafinal, $id_detalle_producto);
			if($validacion == 'no_existe_movimiento'){
				// Verificar si existe saldos iniciales del mes anterior para colocarlos en el saldo inicial actual
				$this->db->select('stock_inicial,precio_uni_inicial,id_saldos_iniciales');
		        $this->db->where('fecha_cierre',date($fecha_formateada_anterior));
		        $this->db->where('id_pro',$id_pro);
		        $query = $this->db->get('saldos_iniciales');
			    if(count($query->result()) > 0){
			        foreach($query->result() as $row){
			            $id_saldos_iniciales = $row->id_saldos_iniciales;
			            $stock_inicial = $row->stock_inicial;
			            $precio_uni_inicial = $row->precio_uni_inicial;
			        }
			        // Actualizar los saldos iniciales del mes que se selecciono
                    $actualizar = array(
                        'precio_uni_inicial'=> $precio_uni_inicial,
                        'stock_inicial' => $stock_inicial
                    );
                    $this->db->where('id_pro',$id_pro);
                    $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
                    $this->db->update('saldos_iniciales', $actualizar);
			    }else{
			    	$actualizar = array(
			    	    'precio_uni_inicial'=> 0,
			    	    'stock_inicial' => 0
			    	);
			    	$this->db->where('id_pro',$id_pro);
			    	$this->db->where('fecha_cierre',date($fecha_formateada_posterior));
			    	$this->db->update('saldos_iniciales', $actualizar);
			    }
			}else{
				// Obtener los ultimos datos nececesarios del kardex para la actualizacion del saldos inicial del producto en el periodo que corresponde
				$this->db->select('stock_actual,precio_unitario_actual_promedio,precio_unitario_anterior,descripcion,precio_unitario_actual,fecha_registro');
				$this->db->where('id_kardex_producto',(int)$validacion);
				$query = $this->db->get('kardex_producto');
				foreach($query->result() as $row){
				    $stock_actual = $row->stock_actual;
				    $precio_unitario_actual_promedio = $row->precio_unitario_actual_promedio;
				    $precio_unitario_anterior = $row->precio_unitario_anterior;
				    $descripcion = $row->descripcion;
				    $precio_unitario_actual = $row->precio_unitario_actual;
				    $fecha_registro = $row->fecha_registro;
				}
				// Considerar el ultimo precio que se manejo dependiente del tipo de movimiento
				if($descripcion == 'SALIDA'){
				    $precio_unitario_anterior_especial = $precio_unitario_anterior;
				}else if($descripcion == 'ENTRADA'){
				    $precio_unitario_anterior_especial = $precio_unitario_actual_promedio;
				}

				// Actualizar el saldo inicial del producto en la fecha que corresponde
				$actualizar = array(
		    	    'precio_uni_inicial'=> $precio_unitario_anterior_especial,
		    	    'stock_inicial' => $stock_actual
		    	);
		    	$this->db->where('id_pro',$id_pro);
		    	$this->db->where('fecha_cierre',date($fecha_formateada_posterior));
		    	$this->db->update('saldos_iniciales', $actualizar);
			}
		}
		echo '1';
	}

	/*
	public function actualizar_saldos_iniciales_controller_version_6(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$fecha_inicial = $this->security->xss_clean($this->input->post("fecha_inicial"));
		$fecha_final = $this->security->xss_clean($this->input->post("fecha_final"));
		$stock_saldo_final = 0;
        $precio_unitario_saldo_final = 0;
        $stock_saldo_final_2 = 0;
        $precio_unitario_saldo_final_2 = 0;
        // fecha inicial del año usado para consulta
        $fecha_inicio_anio = date("Y-m-d");
        $elementos_anio = explode("-", $fecha_inicio_anio);
        $dia = $elementos_anio[2];
        $mes = 1;
        $anio = 1;
        $array = array($anio, $mes, $dia);
        $fecha_inicio_anio = implode("-", $array);
        $fecha_inicio_anio = date("Y-m-d", strtotime($fecha_inicio_anio));
        // Formato de la fecha anterior
		$elementos_f_i = explode("-", $fecha_inicial);
        $anio = $elementos_f_i[0];
        $mes = $elementos_f_i[1];
        $dia = $elementos_f_i[2];
        if($mes == 1){
            $anio = $anio - 1;
            $mes_siguiente = 12;
            $dia = 1;
        }else if($mes > 1 ){
            $mes_siguiente = $mes - 1;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_anterior = implode("-", $array);
        $fecha_formateada_anterior = date("Y-m-d", strtotime($fecha_formateada_anterior));
        // Formato a la fecha posterior
		$elementos_f_f = explode("-", $fecha_inicial);
        $anio = $elementos_f_f[0];
        $mes = $elementos_f_f[1];
        $dia = $elementos_f_f[2];
        if($mes == 12){
            $anio = $anio + 1;
            $mes_siguiente = 1;
            $dia = 1;
        }else if($mes <= 11 ){
            $mes_siguiente = $mes + 1;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_posterior = implode("-", $array);
        $fecha_formateada_posterior = date("Y-m-d", strtotime($fecha_formateada_posterior));

        // validar si ya se realizo un cierre de ese mes
        $validacion_cierre = $this->model_comercial->validar_cierre_duplicado($fecha_formateada_posterior);
        if($validacion_cierre == 'validacion_conforme'){
	        // var_dump($fecha_formateada_anterior);
	        // var_dump($fecha_formateada_posterior);
			// Realizar un consulta de todos los productos registrados en el sistema
			// para verificar los movimientos de esos productos en el kardex y seleccionar el ultimo movimiento de ese mes
			// para obtener el stock y el precio final para el cierre del mes
			$data_product = $this->model_comercial->get_all_productos_v2();
			foreach ($data_product as $row){
				$id_detalle_producto = $row->id_detalle_producto;
				$id_pro = $row->id_pro;
				$stock_sta_anita = $row->stock;
				$stock_sta_clara = $row->stock_sta_clara;

				// Obtener los saldos iniciales del producto para el inicio de los calculos
				$saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($fecha_inicio_anio,$id_pro);
				if( count($saldos_iniciales) > 0 ){
					$stock_saldo_inicial = $result->stock_inicial + $result->stock_inicial_sta_clara;
					$precio_saldo_inicial = $result->precio_uni_inicial;
				}else{
					$stock_saldo_inicial = 0;
					$precio_saldo_inicial = 0;
				}



				// obtener los registros del kardex hasta la fecha en consulta para registrar en la tabla saldos_iniciales
                $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex_saldos_iniciales($id_detalle_producto,$fecha_final,$fecha_inicio_anio);
                $existe = count($detalle_movimientos_kardex);
                $contador_kardex = 0;
                if($existe > 0){
                    foreach ($detalle_movimientos_kardex as $data) {
                        if($data->descripcion == "ENTRADA"){
                            if($contador_kardex == 0){
                                $stock_saldo_final = $stock_saldo_inicial + $data->cantidad_ingreso;
                                $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_saldo_inicial * $stock_saldo_inicial))/($data->cantidad_ingreso + $stock_saldo_inicial);
                                $contador_kardex++;
                            }else{
                                $stock_antes_actualizar = $stock_saldo_final;
                                $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                                $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
                            }
                        }else if($data->descripcion == "SALIDA"){
                        	if($contador_kardex == 0){
	                            $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
	                            $precio_unitario_saldo_final = $precio_saldo_inicial;
	                            $contador_kardex++;
	                        }else{
	                        	$stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
                            	$precio_unitario_saldo_final = $precio_unitario_saldo_final;	
	                        }
                        }else if($data->descripcion == "IMPORTACION"){
                            if($contador_kardex == 0){
                                $stock_saldo_final = $stock_saldo_inicial + $data->cantidad_ingreso;
                                $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_saldo_inicial * $stock_saldo_inicial))/($data->cantidad_ingreso + $stock_saldo_inicial);
                                $contador_kardex++;
                            }else{
                                $stock_antes_actualizar = $stock_saldo_final;
                                $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                                $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
                            }
                        }else if($data->descripcion == "ORDEN INGRESO"){
                            if($contador_kardex == 0){
                                $stock_saldo_final = $stock_saldo_inicial + $data->cantidad_ingreso;
                                $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_saldo_inicial * $stock_saldo_inicial))/($data->cantidad_ingreso + $stock_saldo_inicial);;
                                $contador_kardex++;
                            }else{
                                $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                                $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                            }
                        }
                    }
                    // insertar valores a la tabla saldos_iniciales
                    $datos = array(
                        'id_pro'=> $id_pro,
                        'fecha_cierre'=> $fecha_formateada_posterior,
                        'precio_uni_inicial'=> $precio_unitario_saldo_final,
                        'stock_inicial' => $stock_saldo_final - $stock_sta_clara,
                        'stock_inicial_sta_clara' => $stock_saldo_final - $stock_sta_anita
                    );
                    $this->model_comercial->insert_saldos_iniciales($datos);
                    $stock_saldo_final = 0;
                	$precio_unitario_saldo_final = 0;
                }else{
                    $datos = array(
                        'id_pro'=> $id_pro,
                        'fecha_cierre'=> $fecha_formateada_posterior,
                        'precio_uni_inicial'=> 0,
                        'stock_inicial' => 0,
                        'stock_inicial_sta_clara' => 0
                    );
                    $this->model_comercial->insert_saldos_iniciales($datos);
                    $stock_saldo_final = 0;
                	$precio_unitario_saldo_final = 0;
                }

                // Actualizar el stock y precio unitario de los productos de acuerdo al kardex actual
                $detalle_movimientos_kardex_sin_fecha = $this->model_comercial->traer_movimientos_kardex_saldos_iniciales_sin_filtro_fecha($id_detalle_producto,$fecha_inicio_anio);
                $existe_sin_fecha = count($detalle_movimientos_kardex_sin_fecha);
                $contador_kardex_2 = 0;
                if($existe_sin_fecha > 0){
                    foreach ($detalle_movimientos_kardex_sin_fecha as $data_2) {
                        if($data_2->descripcion == "ENTRADA"){
                            if($contador_kardex_2 == 0){
                                $stock_saldo_final_2 = $stock_saldo_inicial + $data_2->cantidad_ingreso;
                                $precio_unitario_saldo_final_2 = (($data_2->cantidad_ingreso*$data_2->precio_unitario_actual) + ($precio_saldo_inicial * $stock_saldo_inicial))/($data_2->cantidad_ingreso + $stock_saldo_inicial);
                                $contador_kardex_2++;
                            }else{
                                $stock_antes_actualizar = $stock_saldo_final_2;
                                $stock_saldo_final_2 = $stock_saldo_final_2 + $data_2->cantidad_ingreso;
                                $precio_unitario_saldo_final_2 = (($data_2->cantidad_ingreso*$data_2->precio_unitario_actual) + ($precio_unitario_saldo_final_2 * $stock_antes_actualizar))/($data_2->cantidad_ingreso + $stock_antes_actualizar);
                            }
                        }else if($data_2->descripcion == "SALIDA"){
                        	if($contador_kardex_2 == 0){
	                            $stock_saldo_final_2 = $stock_saldo_final - $data_2->cantidad_salida;
	                            $precio_unitario_saldo_final_2 = $precio_saldo_inicial;
	                            $contador_kardex_2++;
	                        }else{
	                            $stock_saldo_final_2 = $stock_saldo_final_2 - $data_2->cantidad_salida;
	                            $precio_unitario_saldo_final_2 = $precio_unitario_saldo_final_2;
                        	}
                        }else if($data_2->descripcion == "IMPORTACION"){
                            if($contador_kardex_2 == 0){
                                $stock_saldo_final_2 = $stock_saldo_inicial + $data_2->cantidad_ingreso;
                                $precio_unitario_saldo_final_2 = (($data_2->cantidad_ingreso*$data_2->precio_unitario_actual) + ($precio_saldo_inicial * $stock_saldo_inicial))/($data_2->cantidad_ingreso + $stock_saldo_inicial);                                
                                $contador_kardex_2++;
                            }else{
                                $stock_antes_actualizar = $stock_saldo_final_2;
                                $stock_saldo_final_2 = $stock_saldo_final_2 + $data_2->cantidad_ingreso;
                                $precio_unitario_saldo_final_2 = (($data_2->cantidad_ingreso*$data_2->precio_unitario_actual) + ($precio_unitario_saldo_final_2 * $stock_antes_actualizar))/($data_2->cantidad_ingreso + $stock_antes_actualizar);
                            }
                        }else if($data_2->descripcion == "ORDEN INGRESO"){
                            if($contador_kardex_2 == 0){
                                $stock_saldo_final_2 = $stock_saldo_inicial + $data_2->cantidad_ingreso;
                                $precio_unitario_saldo_final_2 = (($data_2->cantidad_ingreso*$data_2->precio_unitario_actual) + ($precio_saldo_inicial * $stock_saldo_inicial))/($data_2->cantidad_ingreso + $stock_saldo_inicial);
                                $contador_kardex_2++;
                            }else{
                                $stock_saldo_final_2 = $stock_saldo_final_2 + $data_2->cantidad_ingreso;
                                $precio_unitario_saldo_final_2 = $precio_unitario_saldo_final_2;
                            }
                        }
                    }
                    $actualizar_p_u_2 = array(
                        'precio_unitario'=> $precio_unitario_saldo_final_2,
                        'stock' => $stock_saldo_final_2 - $stock_sta_clara,
                        'stock_sta_clara' => $stock_saldo_final_2 - $stock_sta_anita
                    );
                    $this->db->where('id_detalle_producto',$id_detalle_producto);
                    $this->db->update('detalle_producto', $actualizar_p_u_2);
                    $stock_saldo_final_2 = 0;
                	$precio_unitario_saldo_final_2 = 0;
                }else{
                    $actualizar_p_u_2 = array(
                        'precio_unitario'=> 0,
                        'stock' => 0,
                        'stock_sta_clara' => 0
                    );
                    $this->db->where('id_detalle_producto',$id_detalle_producto);
                    $this->db->update('detalle_producto', $actualizar_p_u_2);
                    $stock_saldo_final_2 = 0;
                	$precio_unitario_saldo_final_2 = 0;
                }

                $id_detalle_producto = "";
				$id_pro = "";
				$stock_sta_anita = "";
				$stock_sta_clara = "";

				/*
				// validacion si existe un registro de este producto en kardex dentro del periodo seleccionado
				$validacion = $this->model_comercial->validar_registros_producto_periodo($fecha_inicial, $fecha_final, $id_detalle_producto);
				if($validacion == 'no_existe_movimiento'){
					// Verificar si existe saldos iniciales del mes anterior para colocarlos en el saldo inicial actual
					$this->db->select('stock_inicial,precio_uni_inicial,id_saldos_iniciales,stock_inicial_sta_clara');
			        $this->db->where('fecha_cierre',date($fecha_formateada_anterior));
			        $this->db->where('id_pro',$id_pro);
			        $query = $this->db->get('saldos_iniciales');
				    if(count($query->result()) > 0){
				    	// Obtengo los saldos iniciales del mes anterior
				    	// osea del mes actual que se esta trabajando
				        foreach($query->result() as $row){
				            $id_saldos_iniciales_anterior = $row->id_saldos_iniciales;
				            $stock_inicial_anterior = $row->stock_inicial;
				            $stock_inicial_sta_clara_anterior = $row->stock_inicial_sta_clara;
				            $precio_uni_inicial_anterior = $row->precio_uni_inicial;
				        }
				        // Actualizar los saldos iniciales del mes que se selecciono
				        $datos = array(
	                        'id_pro'=> $id_pro,
	                        'fecha_cierre'=> $fecha_formateada_posterior,
	                        'precio_uni_inicial'=> $precio_uni_inicial_anterior,
	                        'stock_inicial' => $stock_inicial_anterior,
	                        'stock_inicial_sta_clara' => $stock_inicial_sta_clara_anterior,
	                        'prueba' => 'saldo inicial anterior'
	                    );
	                    $this->model_comercial->insert_saldos_iniciales($datos);
				    }else{
				    	$datos = array(
				    	    'id_pro'=> $id_pro,
	                        'fecha_cierre'=> $fecha_formateada_posterior,
				    	    'precio_uni_inicial'=> 0,
				    	    'stock_inicial' => 0,
				    	    'stock_inicial_sta_clara' => 0,
				    	    'prueba' => 'no tiene saldo inicial'
				    	);
				    	$this->model_comercial->insert_saldos_iniciales($datos);
				    }
				}else{
					// Obtener los ultimos datos nececesarios del kardex para la actualizacion del saldos inicial del producto en el periodo que corresponde
					$this->db->select('stock_actual,precio_unitario_actual_promedio,precio_unitario_anterior,descripcion,precio_unitario_actual,fecha_registro');
					$this->db->where('id_kardex_producto',(int)$validacion);
					$query = $this->db->get('kardex_producto');
					foreach($query->result() as $row){
					    $stock_actual = $row->stock_actual;
					    $precio_unitario_actual_promedio = $row->precio_unitario_actual_promedio;
					    $precio_unitario_anterior = $row->precio_unitario_anterior;
					    $descripcion = $row->descripcion;
					    $precio_unitario_actual = $row->precio_unitario_actual;
					    $fecha_registro = $row->fecha_registro;
					}
					// Considerar el ultimo precio que se manejo dependiente del tipo de movimiento
					if($descripcion == 'SALIDA'){
					    $precio_unitario_anterior_especial = $precio_unitario_anterior;
					}else if($descripcion == 'ENTRADA'  || $descripcion == 'ORDEN INGRESO'){
					    $precio_unitario_anterior_especial = $precio_unitario_actual_promedio;
					}
					// datos los saldos iniciales del mes que se selecciono
					$datos = array(
						'id_pro'=> $id_pro,
	                    'fecha_cierre'=> $fecha_formateada_posterior,
			            'precio_uni_inicial'=> $precio_unitario_anterior_especial,
			            'stock_inicial' => $stock_actual,
			            'stock_inicial_sta_clara' => 0,
			            'prueba' => 'kardex'
			        );
			        $this->model_comercial->insert_saldos_iniciales($datos);
				}
				//
			}
			echo '1';
        }else if($validacion_cierre == 'cierre_duplicado'){
            echo 'cierre_duplicado';
        }
	}
	*/

	public function actualizar_saldos_iniciales_controller_version_6(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$fecha_inicial = $this->security->xss_clean($this->input->post("fecha_inicial"));
		$fecha_final = $this->security->xss_clean($this->input->post("fecha_final"));
        // Formato de la fecha anterior
        /*
		$elementos_f_i = explode("-", $fecha_inicial);
        $anio = $elementos_f_i[0];
        $mes = $elementos_f_i[1];
        $dia = $elementos_f_i[2];
        if($mes == 1){
            $anio = $anio - 1;
            $mes_siguiente = 12;
            $dia = 1;
        }else if($mes > 1 ){
        	$anio = $anio;
            $mes_siguiente = $mes;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_anterior = implode("-", $array);
        */
        $fecha_formateada_anterior = date("Y-m-d", strtotime($fecha_inicial));
        // Formato a la fecha posterior
		$elementos_f_f = explode("-", $fecha_inicial);
        $anio = $elementos_f_f[0];
        $mes = $elementos_f_f[1];
        $dia = $elementos_f_f[2];
        if($mes == 12){
            $anio = $anio + 1;
            $mes_siguiente = 1;
            $dia = 1;
        }else if($mes <= 11 ){
        	$anio = $anio;
            $mes_siguiente = $mes + 1;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_posterior = implode("-", $array);
        $fecha_formateada_posterior = date("Y-m-d", strtotime($fecha_formateada_posterior));
        /*
        var_dump($fecha_formateada_anterior."_");
        var_dump($fecha_formateada_posterior);
        die();
        */
		// Realizar un consulta de todos los productos registrados en el sistema
		// para verificar los movimientos de esos productos en el kardex y seleccionar el ultimo movimiento de ese mes
		// para obtener el stock y el precio final para el cierre del mes
		$validacion_cierre = $this->model_comercial->validar_cierre_duplicado($fecha_formateada_posterior);
        if($validacion_cierre == 'validacion_conforme'){
			$data_product = $this->model_comercial->get_all_productos_v2();
			foreach ($data_product as $row){
				$id_detalle_producto = $row->id_detalle_producto;
				$id_pro = $row->id_pro;
				$stock_sta_anita = $row->stock;
				$stock_sta_clara = $row->stock_sta_clara;
				// validacion si existe un registro de este producto en kardex dentro del periodo seleccionado
				$validacion = $this->model_comercial->validar_registros_producto_periodo($fecha_inicial, $fecha_final, $id_detalle_producto);
				if($validacion == 'no_existe_movimiento'){
					// Verificar si existe saldos iniciales del mes anterior para colocarlos en el saldo inicial actual
					$this->db->select('stock_inicial,precio_uni_inicial,id_saldos_iniciales,stock_inicial_sta_clara');
			        $this->db->where('fecha_cierre',date($fecha_formateada_anterior));
			        $this->db->where('id_pro',$id_pro);
			        $query = $this->db->get('saldos_iniciales');
				    if(count($query->result()) > 0){
				    	// Obtengo los saldos iniciales del mes anterior
				    	// osea del mes actual que se esta trabajando
				        foreach($query->result() as $row){
				            $id_saldos_iniciales_anterior = $row->id_saldos_iniciales;
				            $stock_inicial_anterior = $row->stock_inicial;
				            $stock_inicial_sta_clara_anterior = $row->stock_inicial_sta_clara;
				            $precio_uni_inicial_anterior = $row->precio_uni_inicial;
				        }
				        // actualizar los saldos iniciales del mes que se selecciono
				        $datos = array(
	                        'id_pro'=> $id_pro,
	                        'fecha_cierre'=> $fecha_formateada_posterior,
	                        'precio_uni_inicial'=> $precio_uni_inicial_anterior,
	                        'stock_inicial' => $stock_inicial_anterior,
	                        'stock_inicial_sta_clara' => $stock_inicial_sta_clara_anterior
	                    );
	                    $this->model_comercial->insert_saldos_iniciales($datos);
				    }else{
				    	$datos = array(
				    	    'id_pro'=> $id_pro,
	                        'fecha_cierre'=> $fecha_formateada_posterior,
				    	    'precio_uni_inicial'=> 0,
				    	    'stock_inicial' => 0,
				    	    'stock_inicial_sta_clara' => 0
				    	);
				    	$this->model_comercial->insert_saldos_iniciales($datos);
				    }
				}else{
					$this->db->select('stock_inicial,precio_uni_inicial,id_saldos_iniciales,stock_inicial_sta_clara');
			        $this->db->where('fecha_cierre',date($fecha_formateada_anterior));
			        $this->db->where('id_pro',$id_pro);
			        $query = $this->db->get('saldos_iniciales');
				    if(count($query->result()) > 0){
				    	foreach($query->result() as $row){
					    	$total_saldos_iniciales = $row->stock_inicial + $row->stock_inicial_sta_clara;
					    	$stock_inicial_kardex = $total_saldos_iniciales;
		                    $precio_unitario_inicial_kardex = $row->precio_uni_inicial;
		                }
				    }else{
				    	$stock_inicial_kardex = 0;
	                	$precio_unitario_inicial_kardex = 0;
				    }

				    $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$fecha_inicial,$fecha_final);
				    $existe = count($detalle_movimientos_kardex);
				    $contador_kardex = 0;
		            if($existe > 0){
		                foreach ($detalle_movimientos_kardex as $data) {
		                	if($data->descripcion == "ENTRADA"){
		                        if($contador_kardex == 0){
		                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
		                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
		                            $contador_kardex++;
		                        }else{
		                            $stock_antes_actualizar = $stock_saldo_final;
		                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
		                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
		                        }
		                    }else if($data->descripcion == "SALIDA"){
		                        if($contador_kardex == 0){
		                            $stock_saldo_final = $stock_inicial_kardex - $data->cantidad_salida;
		                            $precio_unitario_saldo_final = $precio_unitario_inicial_kardex;
		                            $contador_kardex++;
		                        }else{
		                            $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
		                            $precio_unitario_saldo_final = $precio_unitario_saldo_final;
		                        }
		                    }else if($data->descripcion == "IMPORTACION"){
		                        if($contador_kardex == 0){
		                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
		                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
		                            $contador_kardex++;
		                        }else{
		                            $stock_antes_actualizar = $stock_saldo_final;
		                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
		                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
		                        }
		                    }else if($data->descripcion == "ORDEN INGRESO"){
		                        if($contador_kardex == 0){
		                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
		                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
		                            $contador_kardex++;
		                        }else{
		                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
		                            $precio_unitario_saldo_final = $precio_unitario_saldo_final;
		                        }
		                    }
		                    // validacion de valores negativos parcial
		                    if($stock_saldo_final < 0 && $precio_unitario_saldo_final < 0){
		                    	echo $id_detalle_producto.'_validacion_parcial_negativos<br>';
		                    }
		                }
		            }else{
		            	echo 'no_hay_kardex_fecha_seleccionada';
		            }

		            // validacion de valores negativos final
		            if($stock_saldo_final >= 0 && $precio_unitario_saldo_final >= 0){
		            	$datos = array(
							'id_pro'=> $id_pro,
		                    'fecha_cierre'=> $fecha_formateada_posterior,
				            'precio_uni_inicial'=> $precio_unitario_saldo_final,
				            'stock_inicial' => $stock_saldo_final,
				            'stock_inicial_sta_clara' => 0
				        );
				        $this->model_comercial->insert_saldos_iniciales($datos);
		            }else{
		            	echo 'validacion_final_negativos';
		            }
				}
			}
			echo '1';
        }else if($validacion_cierre == 'cierre_duplicado'){
            echo 'cierre_duplicado';
        }
	}

	public function actualizar_saldos_iniciales_controller_version_2(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$fechainicial = $this->security->xss_clean($this->input->post("fechainicial"));
		$fechafinal = $this->security->xss_clean($this->input->post("fechafinal"));
		// Formato a la fecha para actualizar los cierre anterior
		/*
		$elementos = explode("-", $fechainicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        if($mes == 12){
            $anio = $anio + 1;
            $mes_siguiente = 1;
            $dia = 1;
        }else if($mes <= 11 ){
            $mes_siguiente = $mes;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_anterior = implode("-", $array);
        */
        $fecha_formateada_anterior = date("Y-m-d", strtotime($fecha_inicial));
        // Formato a la fecha para actualizar los cierre anterior
		$elementos = explode("-", $fechafinal);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        if($mes == 12){
            $anio = $anio + 1;
            $mes_siguiente = 1;
            $dia = 1;
        }else if($mes <= 11 ){
            $mes_siguiente = $mes + 1;
            $dia = 1;
        }
        $array = array($anio, $mes_siguiente, $dia);
        $fecha_formateada_posterior = implode("-", $array);
        $fecha_formateada_posterior = date("Y-m-d", strtotime($fecha_formateada_posterior));
		// Realizar un consulta de todos los productos registrados en el sistema
		// para verificar los movimientos de esos productos en el kardex y seleccionar el ultimo movimiento de ese mes
		// para obtener el stock y el precio final para el cierre del mes

        $validacion_cierre = $this->model_comercial->validar_cierre_duplicado($fecha_formateada_posterior);
        if($validacion_cierre == 'validacion_conforme'){
			$data_product = $this->model_comercial->get_all_productos();
			foreach ($data_product as $row){
				$id_detalle_producto = $row->id_detalle_producto;
				$id_pro = $row->id_pro;
				// validacion si existe un registro de este producto en kardex dentro del periodo seleccionado
				$validacion = $this->model_comercial->validar_registros_producto_periodo($fechainicial, $fechafinal, $id_detalle_producto);
				if($validacion == 'no_existe_movimiento'){
					// Verificar si existe saldos iniciales del mes anterior para colocarlos en el saldo inicial actual
					$this->db->select('stock_inicial,precio_uni_inicial,id_saldos_iniciales,stock_inicial_sta_clara');
			        $this->db->where('fecha_cierre',date($fecha_formateada_anterior));
			        $this->db->where('id_pro',$id_pro);
			        $query = $this->db->get('saldos_iniciales');
				    if(count($query->result()) > 0){
				    	// Obtengo los saldos iniciales del mes anterior
				    	// osea del mes actual que se esta trabajando
				        foreach($query->result() as $row){
				            $id_saldos_iniciales_anterior = $row->id_saldos_iniciales;
				            $stock_inicial_anterior = $row->stock_inicial;
				            $stock_inicial_sta_clara_anterior = $row->stock_inicial_sta_clara;
				            $precio_uni_inicial_anterior = $row->precio_uni_inicial;
				        }
				        $total_saldo_inicial_anterior = $stock_inicial_anterior + $stock_inicial_sta_clara_anterior;
				        // Obtener los saldos iniciales del mes posterior
		        		$this->db->select('stock_inicial,precio_uni_inicial,id_saldos_iniciales,stock_inicial_sta_clara');
		                $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
		                $this->db->where('id_pro',$id_pro);
		                $query = $this->db->get('saldos_iniciales');
		        	    if(count($query->result()) > 0){
		        	    	foreach($query->result() as $row){
		        	    	    $id_saldos_iniciales_posterior = $row->id_saldos_iniciales;
		        	    	    $stock_inicial_posterior = $row->stock_inicial;
		        	    	    $stock_inicial_sta_clara_posterior = $row->stock_inicial_sta_clara;
		        	    	    $precio_uni_inicial_posterior = $row->precio_uni_inicial;
		        	    	}
		        	    }
		        	    // validacion de resultados negativos
		        	    if($stock_inicial_sta_clara_posterior < 0){
		        	    	$stock_inicial_sta_clara_posterior = 0;
		        	    }else if($stock_inicial_posterior < 0 ){
		        	    	$stock_inicial_posterior = 0;
		        	    }
		        	    // totalizar stock's de cierre
		        	    $total_saldo_inicial_posterior = $stock_inicial_posterior + $stock_inicial_sta_clara_posterior;
		        	    // Distribucion de casos
		        	    if($total_saldo_inicial_anterior < $total_saldo_inicial_posterior){
		        	    	$diferencia = $total_saldo_inicial_posterior - $total_saldo_inicial_anterior;
		        	    	// Quitar la diferencia a sta anita
		        	    	$result_posterior_anita = $stock_inicial_posterior - $diferencia;	        	    	
		        	    	if($result_posterior_anita > 0){
				        	    // Validacion por la cantidad en unidades de los saldos iniciales
						        // Actualizar los saldos iniciales del mes que se selecciono
			                    $actualizar = array(
			                        'precio_uni_inicial'=> $precio_uni_inicial_posterior,
			                        'stock_inicial' => $result_posterior_anita
			                    );
			                    $this->db->where('id_pro',$id_pro);
			                    $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
			                    $this->db->update('saldos_iniciales', $actualizar);
		        	    	}else{
		        	    		$result_posterior_clara = $stock_inicial_sta_clara_posterior - $diferencia;
						        // Actualizar los saldos iniciales del mes que se selecciono
			                    $actualizar = array(
			                        'precio_uni_inicial'=> $precio_uni_inicial_posterior,
			                        'stock_inicial_sta_clara' => $result_posterior_clara
			                    );
			                    $this->db->where('id_pro',$id_pro);
			                    $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
			                    $this->db->update('saldos_iniciales', $actualizar);
		        	    	}
		        	    }else if($total_saldo_inicial_anterior > $total_saldo_inicial_posterior){
		        	    	$diferencia = $total_saldo_inicial_anterior - $total_saldo_inicial_posterior;
		        	    	// Aumento la diferencia a sta anita
		        	    	$result_posterior_anita = $stock_inicial_posterior + $diferencia;
					        // Actualizar los saldos iniciales del mes que se selecciono
		                    $actualizar = array(
		                        'precio_uni_inicial'=> $precio_uni_inicial_posterior,
		                        'stock_inicial' => $result_posterior_anita
		                    );
		                    $this->db->where('id_pro',$id_pro);
		                    $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
		                    $this->db->update('saldos_iniciales', $actualizar);
		        	    }
				    }else{
				    	$actualizar = array(
				    	    'precio_uni_inicial'=> 0,
				    	    'stock_inicial' => 0
				    	);
				    	$this->db->where('id_pro',$id_pro);
				    	$this->db->where('fecha_cierre',date($fecha_formateada_posterior));
				    	$this->db->update('saldos_iniciales', $actualizar);
				    }
				}else{
					// Obtener los ultimos datos nececesarios del kardex para la actualizacion del saldos inicial del producto en el periodo que corresponde
					$this->db->select('stock_actual,precio_unitario_actual_promedio,precio_unitario_anterior,descripcion,precio_unitario_actual,fecha_registro');
					$this->db->where('id_kardex_producto',(int)$validacion);
					$query = $this->db->get('kardex_producto');
					foreach($query->result() as $row){
					    $stock_actual = $row->stock_actual;
					    $precio_unitario_actual_promedio = $row->precio_unitario_actual_promedio;
					    $precio_unitario_anterior = $row->precio_unitario_anterior;
					    $descripcion = $row->descripcion;
					    $precio_unitario_actual = $row->precio_unitario_actual;
					    $fecha_registro = $row->fecha_registro;
					}
					// Considerar el ultimo precio que se manejo dependiente del tipo de movimiento
					if($descripcion == 'SALIDA'){
					    $precio_unitario_anterior_especial = $precio_unitario_anterior;
					}else if($descripcion == 'ENTRADA'  || $descripcion == 'ORDEN INGRESO'){
					    $precio_unitario_anterior_especial = $precio_unitario_actual_promedio;
					}
					// Obtener los saldos iniciales de cierre del mes que ya se tiene como registro
	        		$this->db->select('stock_inicial,precio_uni_inicial,id_saldos_iniciales,stock_inicial_sta_clara');
	                $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
	                $this->db->where('id_pro',$id_pro);
	                $query = $this->db->get('saldos_iniciales');
	        	    if(count($query->result()) > 0){
	        	    	foreach($query->result() as $row){
	        	    	    $id_saldos_iniciales_posterior = $row->id_saldos_iniciales;
	        	    	    $stock_inicial_posterior = $row->stock_inicial;
	        	    	    $stock_inicial_sta_clara_posterior = $row->stock_inicial_sta_clara;
	        	    	    $precio_uni_inicial_posterior = $row->precio_uni_inicial;
	        	    	}
	        	    }
	        	    // validacion de resultados negativos
		    	    if($stock_inicial_sta_clara_posterior < 0){
		    	    	$stock_inicial_sta_clara_posterior = 0;
		    	    }else if($stock_inicial_posterior < 0 ){
		    	    	$stock_inicial_posterior = 0;
		    	    }
		    	    // totalizar stock's de cierre
	        	    $total_saldo_inicial_posterior = $stock_inicial_posterior + $stock_inicial_sta_clara_posterior;
	        	    if($stock_actual < $total_saldo_inicial_posterior){
	        	    	$diferencia = $total_saldo_inicial_posterior - $stock_actual;
	        	    	// Quitar la diferencia a sta anita
						$result_posterior_anita = $stock_inicial_posterior - $diferencia;	        	    	
						if($result_posterior_anita > 0){
						    // Validacion por la cantidad en unidades de los saldos iniciales
					        // Actualizar los saldos iniciales del mes que se selecciono
					        $actualizar = array(
					            'precio_uni_inicial'=> $precio_unitario_anterior_especial,
					            'stock_inicial' => $result_posterior_anita
					        );
					        $this->db->where('id_pro',$id_pro);
					        $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
					        $this->db->update('saldos_iniciales', $actualizar);
						}else{
							$result_posterior_clara = $stock_inicial_sta_clara_posterior - $diferencia;
					        // Actualizar los saldos iniciales del mes que se selecciono
					        $actualizar = array(
					            'precio_uni_inicial'=> $precio_unitario_anterior_especial,
					            'stock_inicial_sta_clara' => $result_posterior_clara
					        );
					        $this->db->where('id_pro',$id_pro);
					        $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
					        $this->db->update('saldos_iniciales', $actualizar);
						}
	        	    }else if($stock_actual > $total_saldo_inicial_posterior){
	        	    	$diferencia = $stock_actual - $total_saldo_inicial_posterior;
	        	    	// Aumento la diferencia a sta anita
						$result_posterior_anita = $stock_inicial_posterior + $diferencia;
						// Actualizar los saldos iniciales del mes que se selecciono
					    $actualizar = array(
					        'precio_uni_inicial'=> $precio_unitario_anterior_especial,
					        'stock_inicial' => $result_posterior_anita
					    );
					    $this->db->where('id_pro',$id_pro);
					    $this->db->where('fecha_cierre',date($fecha_formateada_posterior));
					    $this->db->update('saldos_iniciales', $actualizar);
	        	    }
				}
			}
			echo '1';
        }else if($validacion_cierre == 'cierre_duplicado'){
            echo 'cierre_duplicado';
        }

	}

	public function actualizar_saldos_iniciales_controller_version_3(){
		// Realizar un consulta de todos los productos registrados en el sistema
		// para verificar los movimientos de esos productos en el kardex y seleccionar el ultimo movimiento
		// para obtener el stock y el precio final para el cierre del mes
		$data_product = $this->model_comercial->get_all_productos();
		foreach ($data_product as $row){
			$id_detalle_producto = $row->id_detalle_producto;
			$id_pro = $row->id_pro;
			$validacion = $this->model_comercial->validar_registros_producto_kardex($id_detalle_producto);
			if($validacion == 'no_existe_movimiento'){
				$actualizar = array(
		    	    'precio_unitario'=> 0
		    	);
		    	$this->db->where('id_detalle_producto',$id_detalle_producto);
		    	$this->db->update('detalle_producto', $actualizar);
			}else{
				// Obtener los ultimos datos nececesarios del kardex para la actualizacion del saldos inicial del producto en el periodo que corresponde
				$this->db->select('stock_actual,precio_unitario_actual_promedio,precio_unitario_anterior,descripcion,precio_unitario_actual,fecha_registro');
				$this->db->where('id_kardex_producto',(int)$validacion);
				$query = $this->db->get('kardex_producto');
				foreach($query->result() as $row){
				    $stock_actual = $row->stock_actual;
				    $precio_unitario_actual_promedio = $row->precio_unitario_actual_promedio;
				    $precio_unitario_anterior = $row->precio_unitario_anterior;
				    $descripcion = $row->descripcion;
				    $precio_unitario_actual = $row->precio_unitario_actual;
				    $fecha_registro = $row->fecha_registro;
				}
				// Considerar el ultimo precio que se manejo dependiente del tipo de movimiento
				if($descripcion == 'SALIDA' || $descripcion == 'IMPORTACION'){
				    if($precio_unitario_anterior == ""){
						$precio_unitario_anterior_especial = 0;
					}else{
				    	$precio_unitario_anterior_especial = $precio_unitario_anterior;
					}
				}else if($descripcion == 'ENTRADA'){
				    if($precio_unitario_anterior == ""){
						$precio_unitario_anterior_especial = 0;
					}else{
				    	$precio_unitario_anterior_especial = $precio_unitario_actual_promedio;
					}
				}else if($descripcion == 'ORDEN INGRESO'){
				    if($precio_unitario_anterior == ""){
						$precio_unitario_anterior_especial = 0;
					}else{
				    	$precio_unitario_anterior_especial = $precio_unitario_actual;
					}
				}
				$actualizar = array(
		    	    'precio_unitario'=> $precio_unitario_anterior_especial
		    	);
		    	$this->db->where('id_detalle_producto',$id_detalle_producto);
		    	$this->db->update('detalle_producto', $actualizar);
			}
		}
		echo '1';
	}

	public function actualizar_stock_controller_version_4(){
		// Realizar un consulta de todos los productos registrados en el sistema
		// para verificar los movimientos de esos productos en el kardex y seleccionar el ultimo movimiento
		// para obtener el stock y el precio final para el cierre del mes
		$data_product = $this->model_comercial->get_all_productos();
		foreach ($data_product as $row){
			$id_detalle_producto = $row->id_detalle_producto;
			$id_pro = $row->id_pro;
			$validacion = $this->model_comercial->validar_registros_producto_kardex($id_detalle_producto);
			if($validacion == 'no_existe_movimiento'){
				$actualizar = array(
		    	    'stock'=> 0,
		    	    'stock_sta_clara'=> 0
		    	);
		    	$this->db->where('id_detalle_producto',$id_detalle_producto);
		    	$this->db->update('detalle_producto', $actualizar);
			}else{
				// Obtener los ultimos datos nececesarios del kardex para la actualizacion del saldos inicial del producto en el periodo que corresponde
				$this->db->select('stock_actual,precio_unitario_actual_promedio,precio_unitario_anterior,descripcion,precio_unitario_actual,fecha_registro');
				$this->db->where('id_kardex_producto',(int)$validacion);
				$query = $this->db->get('kardex_producto');
				foreach($query->result() as $row){
				    $stock_actual_kardex = $row->stock_actual;
				    $descripcion = $row->descripcion;
				}
				// Obtener el stock actual de la tabla detalle_producto
				$this->db->select('stock,stock_sta_clara');
				$this->db->where('id_detalle_producto',$id_detalle_producto);
				$query = $this->db->get('detalle_producto');
				foreach($query->result() as $row){
				    $stock = $row->stock;
				    $stock_sta_clara = $row->stock_sta_clara;
				}
				$stock_total = $stock + $stock_sta_clara;

				// Validacion de resultados
				if($stock_actual_kardex == 0){
					$actualizar = array(
			    	    'stock'=> 0,
			    	    'stock_sta_clara'=> 0
			    	);
			    	$this->db->where('id_detalle_producto',$id_detalle_producto);
			    	$this->db->update('detalle_producto', $actualizar);
				}else{
					if($stock_total > $stock_actual_kardex){
						$diferencia = $stock_total - $stock_actual_kardex;
						// Validar resultados negativos
						// Sta anita
						$result_sta_anita = $stock - $diferencia;
						// Sta clara
						$result_sta_clara = $stock_sta_clara - $diferencia;
						if($result_sta_anita >= 0){
							$actualizar = array(
					    	    'stock'=> $result_sta_anita
					    	);
					    	$this->db->where('id_detalle_producto',$id_detalle_producto);
					    	$this->db->update('detalle_producto', $actualizar);
						}else if($result_sta_clara >= 0){
							$actualizar = array(
					    	    'stock_sta_clara'=> $result_sta_clara
					    	);
					    	$this->db->where('id_detalle_producto',$id_detalle_producto);
					    	$this->db->update('detalle_producto', $actualizar);
						}else{
							var_dump(' validar manualmente: '.$id_detalle_producto.' ');
						}
					}else if($stock_total < $stock_actual_kardex){
						$diferencia = $stock_actual_kardex - $stock_total;
						if($stock == 0){
							$stock_sta_clara = $stock_sta_clara + $diferencia;
							$actualizar = array(
					    	    'stock_sta_clara'=> $stock_sta_clara
					    	);
					    	$this->db->where('id_detalle_producto',$id_detalle_producto);
					    	$this->db->update('detalle_producto', $actualizar);
						}else{
							$stock = $stock + $diferencia;
							$actualizar = array(
					    	    'stock'=> $stock
					    	);
					    	$this->db->where('id_detalle_producto',$id_detalle_producto);
					    	$this->db->update('detalle_producto', $actualizar);
						}
					}
				}
			}
		}
		echo '1';
	}

	public function actualizar_stock_controller_version_5(){
		// Importante esta funcion me sirve tambien para verificar si existen productos con areas duplicadas
		// Realizar un consulta de todos los productos registrados en el sistema
		// para verificar los movimientos de esos productos en el kardex y seleccionar el ultimo movimiento
		// para obtener el stock y el precio final para el cierre del mes
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$data_product = $this->model_comercial->get_all_productos();
		foreach ($data_product as $row){
			$id_detalle_producto = $row->id_detalle_producto;
			$id_pro = $row->id_pro;
			// Obtener el stock actual de la tabla detalle_producto
			$this->db->select('stock,stock_sta_clara');
			$this->db->where('id_detalle_producto',$id_detalle_producto);
			$query = $this->db->get('detalle_producto');
			foreach($query->result() as $row){
			    $stock = $row->stock;
			    $stock_sta_clara = $row->stock_sta_clara;
			}
			// Identificar si el producto solo tiene un area asignada
			$this->db->select('id_area');
			$this->db->where('id_pro',$id_pro);
			$query = $this->db->get('detalle_producto_area');
			if(count($query->result()) == 1){
				foreach($query->result() as $row){
				    $id_area = $row->id_area;
				}
				if($almacen == 1){
					// Actualizo el stock del area segun el almacen al que pertenece
					$actualizar = array(
			    	    'stock_area_sta_clara'=> $stock_sta_clara
			    	);
			    	$this->db->where('id_area',$id_area);
			    	$this->db->where('id_pro',$id_pro);
			    	$this->db->update('detalle_producto_area', $actualizar);
				}else if($almacen == 2){
					// Actualizo el stock del area segun el almacen al que pertenece
					$actualizar = array(
			    	    'stock_area_sta_anita'=> $stock
			    	);
			    	$this->db->where('id_area',$id_area);
			    	$this->db->where('id_pro',$id_pro);
			    	$this->db->update('detalle_producto_area', $actualizar);
				}
				var_dump('Producto actualizado id_dp '.$id_detalle_producto.' Producto id_pro '.$id_pro);
			}else if(count($query->result()) == 0){
				// var_dump('Evaluar producto id_dp '.$id_detalle_producto.' Evaluar producto id_pro '.$id_pro);
			}else if(count($query->result()) == 2){
				// var_dump('Evaluar producto con 2 id_area id_dp '.$id_detalle_producto.' Evaluar producto id_pro '.$id_pro);
			}
		}
		echo '1';
	}

	public function eliminartrasladoproducto()
	{
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$id_detalle_traslado = $this->input->get('eliminar');
		$result = $this->model_comercial->eliminarTrasladoProducto($id_detalle_traslado,$almacen);
		if(!$result){
            echo '<b>--> No puede eliminar Registros de un periodo donde se ya realizo el Cierre Mensual de Almacén.</b>';
        }else{
        	echo '1';
        }
	}

	/*
	public function eliminarregistrosalida()
	{
		$id_registro_salida = $this->input->get('eliminar');
		$this->model_comercial->eliminarRegistroSalida($id_registro_salida);
	}
	*/

	public function eliminarregistrosalida(){
        $this->db->trans_begin();
        $contador_kardex_v = 0;
        $contador_kardex = 0;
        $aux = 0;
        $almacen = $this->security->xss_clean($this->session->userdata('almacen'));
        $id_salida_producto = $this->security->xss_clean($this->input->post('id_salida_producto'));
        // $id_detalle_producto = $this->security->xss_clean($this->input->post('id_detalle_producto'));
        // validar que la salida a eliminar no corresponde a una fecha en la que ya se realizo un cierre
        $result_fecha_salida = $this->model_comercial->get_fecha_salida_eliminar($id_salida_producto);
        foreach ($result_fecha_salida as $row_fecha){
            $fecha_registro = $row_fecha->fecha;
            $id_detalle_producto = $row_fecha->id_detalle_producto;
            $id_area = $row_fecha->id_area;
            $id_pro = $row_fecha->id_pro;
            $cantidad_salida = $row_fecha->cantidad_salida;
            // formato de fecha para la comparacion
            $elementos = explode("-", $fecha_registro);
            $anio = $elementos[0];
            $mes = $elementos[1];
            $dia = $elementos[2];
            // Validar si el mes es diciembre 12 : sino sale fuera de rango
            if($mes == 12){
                $anio = $anio + 1;
                $mes_siguiente = 1;
                $dia = 1;
            }else if($mes <= 11 ){
                $mes_siguiente = $mes + 1;
                $dia = 1;
            }
            $array = array($anio, $mes_siguiente, $dia);
            $fecha_formateada = implode("-", $array);
            // consulta si la factura corresponde a un periodo que ya cerro
            $this->db->select('id_saldos_iniciales');
            $this->db->where('fecha_cierre',$fecha_formateada);
            $query = $this->db->get('saldos_iniciales');
            if($query->num_rows() > 0){
                echo 'periodo_cerrado';
            }else{
                // Proceso de validacion de resultados
                // Eliminar el kardex de cada producto asociado a la salida e ir actualizando el stock y su precio unitario
                $result_mov_kardex_v = $this->model_comercial->get_salida_producto_eliminar($id_salida_producto, $id_detalle_producto); // trae el producto asociados a la salida
                foreach ($result_mov_kardex_v as $row_mov_v){
                    // iniciar valores
                    $stock_saldo_final = 0;
                    $precio_unitario_saldo_final = 0;
                    // obtener valores de la consulta
                    $id_detalle_producto = $row_mov_v->id_detalle_producto;
                    $fecha_registro = $row_mov_v->fecha;
                    // actualizacion del stock y precio unitario del podructo en funcion del kardex // para lo cual necesitamos obtener el ultimo registro en el kardex de ese producto
                    $detalle_movimientos_kardex_v = $this->model_comercial->traer_movimientos_kardex_eliminar($id_detalle_producto);
                    $existe_v = count($detalle_movimientos_kardex_v);
                    if($existe_v > 0){
                        foreach ($detalle_movimientos_kardex_v as $data_v) {
                            $numero_comprobante_kardex_v = $data_v->num_comprobante;
                            if($id_salida_producto != $numero_comprobante_kardex_v){
                                if($data_v->descripcion == "ENTRADA" || $data_v->descripcion == "IMPORTACION"){
                                    if($contador_kardex_v == 0){
                                        $stock_saldo_final = $data_v->cantidad_ingreso;
                                        $precio_unitario_saldo_final = $data_v->precio_unitario_actual;
                                        $contador_kardex_v++;
                                    }else{
                                        $stock_antes_actualizar = $stock_saldo_final;
                                        $stock_saldo_final = $stock_saldo_final + $data_v->cantidad_ingreso;
                                        $precio_unitario_saldo_final = (($data_v->cantidad_ingreso*$data_v->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data_v->cantidad_ingreso + $stock_antes_actualizar);
                                    }
                                }else if($data_v->descripcion == "SALIDA"){
                                    $stock_saldo_final = $stock_saldo_final - $data_v->cantidad_salida;
                                    $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                                }else if($data_v->descripcion == "ORDEN INGRESO"){
                                    $stock_saldo_final = $stock_saldo_final + $data_v->cantidad_ingreso;
                                    $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                                }
                            }
                        }
                    }else{
                        $stock_saldo_final = 0;
                        $precio_unitario_saldo_final = 0;
                    }

                    if($stock_saldo_final < 0 || $precio_unitario_saldo_final < 0){
                        // echo 'valores_negativos_producto '.$stock_saldo_final." ".$precio_unitario_saldo_final." ";
                        $aux++;
                    }
                }

                if($aux == 0){
                    // Eliminar el kardex de cada producto asociado a la factura e ir actualizando el stock y su precio unitarioc
                    $result_mov_kardex_v = $this->model_comercial->get_salida_producto_eliminar($id_salida_producto, $id_detalle_producto); // trae el producto asociados a la factura, porque pueden ser varios pero en el filtro especifico un producto
                    foreach ($result_mov_kardex_v as $row_mov_v){
                        // iniciar valores
                        $stock_saldo_final = 0;
                        $precio_unitario_saldo_final = 0;
                        // obtener valores de la consulta
                        $id_detalle_producto = $row_mov_v->id_detalle_producto;
                        $fecha_registro = $row_mov_v->fecha;
                        // eliminacion del kardex del producto
                        $sql = "DELETE FROM kardex_producto WHERE id_detalle_producto = " . $id_detalle_producto . " AND DATE(fecha_registro) = '" .$fecha_registro."' AND num_comprobante = '" .$id_salida_producto."'";
                        $query = $this->db->query($sql);
                        // actualizacion del stock y precio unitario del podructo en funcion del kardex // para lo cual necesitamos obtener el ultimo registro en el kardex de ese producto
                        $detalle_movimientos_kardex_v = $this->model_comercial->traer_movimientos_kardex_eliminar($id_detalle_producto);
                        $existe_v = count($detalle_movimientos_kardex_v);
                        if($existe_v > 0){
                            foreach ($detalle_movimientos_kardex_v as $data_v) {
                                $numero_comprobante_kardex_v = $data_v->num_comprobante;
                                if($id_salida_producto != $numero_comprobante_kardex_v){
                                    if($data_v->descripcion == "ENTRADA" || $data_v->descripcion == "IMPORTACION"){
                                        if($contador_kardex_v == 0){
                                            $stock_saldo_final = $data_v->cantidad_ingreso;
                                            $precio_unitario_saldo_final = $data_v->precio_unitario_actual;
                                            $contador_kardex_v++;
                                        }else{
                                            $stock_antes_actualizar = $stock_saldo_final;
                                            $stock_saldo_final = $stock_saldo_final + $data_v->cantidad_ingreso;
                                            $precio_unitario_saldo_final = (($data_v->cantidad_ingreso*$data_v->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data_v->cantidad_ingreso + $stock_antes_actualizar);
                                        }
                                    }else if($data_v->descripcion == "SALIDA"){
                                        $stock_saldo_final = $stock_saldo_final - $data_v->cantidad_salida;
                                        $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                                    }else if($data_v->descripcion == "ORDEN INGRESO"){
                                        $stock_saldo_final = $stock_saldo_final + $data_v->cantidad_ingreso;
                                        $precio_unitario_saldo_final = $precio_unitario_saldo_final;
                                    }
                                }
                            }
                        }else{
                            $stock_saldo_final = 0;
                            $precio_unitario_saldo_final = 0;
                        }
                        // obtener el stock del producto de acuerdo al almacen para descontar en el stock general
                        $this->db->select('stock,stock_sta_clara');
				        $this->db->where('id_detalle_producto',$id_detalle_producto);
				        $query = $this->db->get('detalle_producto');
					    if(count($query->result()) > 0){
					        foreach($query->result() as $row){
					            $stock_sta_anita = $row->stock;
					            $stock_sta_clara = $row->stock_sta_clara;
					        }
					        if($almacen == 1){
					        	$actualizar_p_u_2 = array(
		                            'precio_unitario'=> $precio_unitario_saldo_final,
		                            'stock_sta_clara' => $stock_saldo_final - $stock_sta_anita
		                        );
		                        $this->db->where('id_detalle_producto',$id_detalle_producto);
		                        $this->db->update('detalle_producto', $actualizar_p_u_2);
					        }else if($almacen == 2){
					        	$actualizar_p_u_2 = array(
		                            'precio_unitario'=> $precio_unitario_saldo_final,
		                            'stock' => $stock_saldo_final - $stock_sta_clara
		                        );
		                        $this->db->where('id_detalle_producto',$id_detalle_producto);
		                        $this->db->update('detalle_producto', $actualizar_p_u_2);
					        }
					    }
					    // descontar en el stock de acuerdo al area al que pertenece
					    $this->db->select('stock_area_sta_anita,stock_area_sta_clara');
				        $this->db->where('id_area',$id_area);
				        $this->db->where('id_pro',$id_pro);
				        $query = $this->db->get('detalle_producto_area');
				        if(count($query->result()) > 0){
				        	foreach($query->result() as $row){
					            $stock_area_sta_anita = $row->stock_area_sta_anita;
					            $stock_area_sta_clara = $row->stock_area_sta_clara;
					        }
					        if($almacen == 1){
					        	$actualizar_stock_area = array(
		                            'stock_area_sta_clara' => $stock_area_sta_clara + $cantidad_salida
		                        );
		                        $this->db->where('id_pro',$id_pro);
		                        $this->db->where('id_area',$id_area);
		                        $this->db->update('detalle_producto_area', $actualizar_stock_area);
					        }else if($almacen == 2){
					        	$actualizar_stock_area = array(
		                            'stock_area_sta_anita' => $stock_area_sta_anita + $cantidad_salida
		                        );
		                        $this->db->where('id_pro',$id_pro);
		                        $this->db->where('id_area',$id_area);
		                        $this->db->update('detalle_producto_area', $actualizar_stock_area);
					        }
				        }

                    }
                    // ELIMINAR REGISTROS
                    $sql = "DELETE FROM adm_facturas_asociadas WHERE id_salida_producto = " . $id_salida_producto . "";
                    $query = $this->db->query($sql);

                    $sql = "DELETE FROM salida_producto WHERE id_salida_producto = " . $id_salida_producto . "";
                    $query = $this->db->query($sql);

                    echo 'eliminacion_correcta';
                    $this->db->trans_complete();
                }else{
                    echo 'valores_negativos_producto';
                }
            }
        }
    }

	public function co_exportar_resumen_producto_excel(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		if($almacen == 	1){
			$data['producto'] = $this->model_comercial->listarResumenProductos_report_excel_anita();
			$this->load->view('comercial/reportes/report_excel_resumen_producto_clara',$data);
		}else if($almacen == 2){
			$data['producto'] = $this->model_comercial->listarResumenProductos_report_excel_anita();
			$this->load->view('comercial/reportes/report_excel_resumen_producto_anita',$data);
		}
	}

	public function consolidar_stock(){
		$this->model_comercial->consolidar_stock();
	}

	public function al_exportar_inventario(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$data = json_decode($data, true);
		$f_inicial = $data[0];

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

		// Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
		$objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);

		/* propiedades de la celda */
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

	    /* Traer informacion de la BD */
	    $saldo_inicial = $this->model_comercial->get_info_saldos_iniciales($f_inicial);
	    /* Recorro con todos los nombres seleccionados que tienen una salida/ingreso en el kardex */
	    
	    $sumatoria = 0;
	    $p = 2;

		//Write cells
	    $objWorkSheet->setCellValue('A1', 'FECHA DE CIERRE')
	    			 ->setCellValue('B1', 'NOMBRE DEL PRODUCTO')
	    			 ->setCellValue('C1', 'STOCK DE CIERRE')
	    			 ->setCellValue('D1', 'P. UNITARIO DE CIERRE');

	    foreach ($saldo_inicial as $reg) {

	    	/* Formatos */
    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

    		/* Centrar contenido */
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);

    		/* border */
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);

        	$nombre_producto = $reg->no_producto;
        	$stock_inicial = $reg->stock_inicial;
        	$precio_uni_inicial = $reg->precio_uni_inicial;
        	$fecha_cierre = $reg->fecha_cierre;

        	if($almacen == 1){
			    $objWorkSheet->setCellValue('A'.$p, $reg->fecha_cierre)
	    					 ->setCellValue('B'.$p, $reg->no_producto)
	    					 ->setCellValueExplicit('C'.$p, $reg->stock_inicial_sta_clara)
	    					 ->setCellValueExplicit('D'.$p, $reg->precio_uni_inicial);
        	}else if($almacen == 2){
			    $objWorkSheet->setCellValue('A'.$p, $reg->fecha_cierre)
	    					 ->setCellValue('B'.$p, $reg->no_producto)
	    					 ->setCellValueExplicit('C'.$p, $reg->stock_inicial)
	    					 ->setCellValueExplicit('D'.$p, $reg->precio_uni_inicial);
        	}

		    /* Rename sheet */
		    $objWorkSheet->setTitle("Inventario");
		    $p++;
        }

	    $objPHPExcel->setActiveSheetIndex(0);

		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=inventario.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function al_exportar_report_factura_mensual(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$f_inicial = $data[0];
		$f_final = $data[1];

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		/* Obtener el nombre del mes */
        $elementos = explode("-", $f_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];

        if($mes == 1){
            $nombre_mes = "ENERO";
        }else if($mes == 2){
            $nombre_mes = "FEBRERO";
        }else if($mes == 3){
            $nombre_mes = "MARZO";
        }else if($mes == 4){
            $nombre_mes = "ABRIL";
        }else if($mes == 5){
            $nombre_mes = "MAYO";
        }else if($mes == 6){
            $nombre_mes = "JUNIO";
        }else if($mes == 7){
            $nombre_mes = "JULIO";
        }else if($mes == 8){
            $nombre_mes = "AGOSTO";
        }else if($mes == 9){
            $nombre_mes = "SETIEMBRE";
        }else if($mes == 10){
            $nombre_mes = "OCTUBRE";
        }else if($mes == 11){
            $nombre_mes = "NOVIEMBRE";
        }else if($mes == 12){
            $nombre_mes = "DICIEMBRE";
        }

		/* Here your first sheet */
	    $sheet = $objPHPExcel->getActiveSheet();

	    /* Style - Bordes */
	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $style_2 = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        )
	    );

	    $styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);

		// Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
		$objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:M1');
		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleArray);
		//$objPHPExcel->getActiveSheet()->getRowDimension('A')->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

		// Write cells
		if($almacen == 1){
			$objWorkSheet->setCellValue('A1', 'SALIDA DE PRODUCTOS VALORIZADOS - STA. CLARA                     FECHA: '.$nombre_mes.' '.$anio);
    	}else if($almacen == 2){
    		$objWorkSheet->setCellValue('A1', 'SALIDA DE PRODUCTOS VALORIZADOS - STA. ANITA                     FECHA: '.$nombre_mes.' '.$anio);
    	}
    	$objWorkSheet->setCellValue('K1', ' SALIDAS ');

    	$objWorkSheet->setCellValue('A2', '')
	    			 ->setCellValue('B2', 'MES')
	    			 ->setCellValue('C2', 'TIPO DOC.')
	    			 ->setCellValue('D2', 'SERIE')
	    			 ->setCellValue('E2', 'NUMERO')
	    			 ->setCellValue('F2', 'PROVEEDOR')
	    			 ->setCellValue('G2', 'NOMBRE DEL PRODUCTO')
	    			 ->setCellValue('H2', 'PROCED')
	    			 ->setCellValue('I2', 'SUM/REP')
	    			 ->setCellValue('J2', 'MEDIDA')
	    			 ->setCellValue('K2', 'CANTIDAD')
	    			 ->setCellValue('L2', 'CU')
	    			 ->setCellValue('M2', 'CT');

	    /* Traer informacion de la BD */
	    // Selecciono todos los productos que salieron de almacen dentro de la fecha seleccionada
	    $result = $this->model_comercial->get_info_salidas_report($f_inicial, $f_final, $almacen);
	    // Recorrido
	    $p = 3;
	    if(count($result) > 0){
		    foreach ($result as $reg) {
		    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    	/* Centrar contenido */
		    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style);
	    		/* border */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);

		    	$id_detalle_producto = $reg->id_detalle_producto;
		    	$fecha_salida = $reg->fecha;
		    	$cantidad_salida = $reg->cantidad_salida;
		    	$no_producto = $reg->no_producto;
		    	$no_procedencia = $reg->no_procedencia;
		    	$no_categoria = $reg->no_categoria;
		    	$nom_uni_med = $reg->nom_uni_med;
		    	// Identificando las facturas utilizadas para la salida del producto
		    	$invoice = $this->model_comercial->get_info_facturas_report($id_detalle_producto);
		    	$sumatoria_unidades_factura = 0;
		    	$cant_facturas = 0;
		    	$contador_filas = 1;
		    	$variable_u = FALSE;
		    	$variable_p = FALSE;
		    	if(count($invoice) > 0){
			    	foreach ($invoice as $row) {
			    		if($sumatoria_unidades_factura < $cantidad_salida){
			    			if($cant_facturas == 0){
			    				if($row->serie_comprobante == '000'){
					    			$nombre_comprobante_u = 'INVOICE';
					    			$serie_factura_u = '';
					    		}else{
					    			$nombre_comprobante_u = $row->no_comprobante;
					    			$serie_factura_u = $row->serie_comprobante;
					    		}
					    		$num_factura_u = $row->nro_comprobante;
					    		$serie_factura_u = $row->serie_comprobante;
					    		$razon_social_u = $row->razon_social;
					    		$precio_ingreso_u = $row->precio;
					    		$unidades_ingreso_u = $row->unidades;
					    		// Analisis
					    		if(($cantidad_salida - $unidades_ingreso_u) >= 0){
					    			$unidades_utilizadas_u = $unidades_ingreso_u;
					    		}else if(($cantidad_salida - $unidades_ingreso_u) < 0){
					    			$unidades_utilizadas_u = $cantidad_salida;
					    		}
					    		$cant_facturas++;
					    		// Sumatoria
				    			$sumatoria_unidades_factura = $sumatoria_unidades_factura + $unidades_ingreso_u;
				    			$variable_u = TRUE;
			    			}else if($cant_facturas == 1){
			    				if($row->serie_comprobante == '000'){
					    			$nombre_comprobante_p = 'INVOICE';
					    			$serie_factura_p = '';
					    		}else{
					    			$nombre_comprobante_p = $row->no_comprobante;
					    			$serie_factura_p = $row->serie_comprobante;
					    		}
			    				$num_factura_p = $row->nro_comprobante;
			    				$razon_social_p = $row->razon_social;
			    				$precio_ingreso_p = $row->precio;
			    				$unidades_ingreso_p = $row->unidades;
			    				// Analisis
			    				$unidades_utilizadas_p = $unidades_ingreso_p - ( $cantidad_salida -  $unidades_utilizadas_u );
			    				$cant_facturas++;
			    				// Sumatoria
				    			$sumatoria_unidades_factura = $sumatoria_unidades_factura + $unidades_ingreso_p;
				    			$variable_p = TRUE;
			    			}
			    		}
			    		// Contador de filas
			    	}
			    }
	    		if($variable_p == TRUE){
		    		$objWorkSheet->setCellValue('A'.$p, $contador_filas)
		    					 ->setCellValue('B'.$p, $nombre_mes)
		    					 ->setCellValue('C'.$p, $nombre_comprobante_p)
		    					 ->setCellValueExplicit('D'.$p, $serie_factura_p,PHPExcel_Cell_DataType::TYPE_STRING)
		    					 ->setCellValue('E'.$p, $num_factura_p)
		    					 ->setCellValue('F'.$p, $razon_social_p)
		    					 ->setCellValue('G'.$p, $no_producto)
		    					 ->setCellValue('H'.$p, $no_procedencia)
		    					 ->setCellValue('I'.$p, $no_categoria)
		    					 ->setCellValue('J'.$p, $nom_uni_med)
		    					 ->setCellValue('K'.$p, $unidades_utilizadas_p)
		    					 ->setCellValue('L'.$p, $precio_ingreso_p)
		    					 ->setCellValue('M'.$p, ($unidades_utilizadas_p*$precio_ingreso_p));
		    		$p++;
		    		$contador_filas++;
	    		}
	    		if($variable_u == TRUE){
	    			// Estilos
	    			$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	/* Centrar contenido */
			    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style);
		    		/* border */
		    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);

	    			$objWorkSheet->setCellValue('A'.$p, $contador_filas)
		    					 ->setCellValue('B'.$p, $nombre_mes)
		    					 ->setCellValue('C'.$p, $nombre_comprobante_u)
		    					 ->setCellValueExplicit('D'.$p, $serie_factura_u,PHPExcel_Cell_DataType::TYPE_STRING)
		    					 ->setCellValue('E'.$p, $num_factura_u)
		    					 ->setCellValue('F'.$p, $razon_social_u)
		    					 ->setCellValue('G'.$p, $no_producto)
		    					 ->setCellValue('H'.$p, $no_procedencia)
		    					 ->setCellValue('I'.$p, $no_categoria)
		    					 ->setCellValue('J'.$p, $nom_uni_med)
		    					 ->setCellValue('K'.$p, $unidades_utilizadas_u)
		    					 ->setCellValue('L'.$p, $precio_ingreso_u)
		    					 ->setCellValue('M'.$p, ($unidades_utilizadas_u*$precio_ingreso_u));
	    			$p++;
	    			$contador_filas++;
	    		}
	    		/* Rename sheet */
			    $objWorkSheet->setTitle("reporte_mensual_salidas");
		    }
	    }
    	$objPHPExcel->setActiveSheetIndex(0);
		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=reporte_mensual_salidas.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	// Esta opcion permite identificar el id de la factura que se utilizo para realizar la salida del producto
	public function al_exportar_report_factura_mensual_opcion_2(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$f_inicial = $data[0];
		$f_final = $data[1];

		$this->load->library('pHPExcel');
		// variables de PHPExcel
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		// propiedades de la celda
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		// Obtener el nombre del mes
        $elementos = explode("-", $f_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];

        if($mes == 1){
            $nombre_mes = "ENERO";
        }else if($mes == 2){
            $nombre_mes = "FEBRERO";
        }else if($mes == 3){
            $nombre_mes = "MARZO";
        }else if($mes == 4){
            $nombre_mes = "ABRIL";
        }else if($mes == 5){
            $nombre_mes = "MAYO";
        }else if($mes == 6){
            $nombre_mes = "JUNIO";
        }else if($mes == 7){
            $nombre_mes = "JULIO";
        }else if($mes == 8){
            $nombre_mes = "AGOSTO";
        }else if($mes == 9){
            $nombre_mes = "SETIEMBRE";
        }else if($mes == 10){
            $nombre_mes = "OCTUBRE";
        }else if($mes == 11){
            $nombre_mes = "NOVIEMBRE";
        }else if($mes == 12){
            $nombre_mes = "DICIEMBRE";
        }

		// Here your first sheet
	    $sheet = $objPHPExcel->getActiveSheet();

	    // Style - Bordes
	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $style_2 = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        )
	    );

	    $styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);

		// Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
		$objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:O1');
		$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleArray);
		//$objPHPExcel->getActiveSheet()->getRowDimension('A')->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(55);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(35);
		// Write cells
		if($almacen == 1){
			$objWorkSheet->setCellValue('A1', 'SALIDA DE PRODUCTOS VALORIZADOS - STA. CLARA                     FECHA: '.$nombre_mes.' '.$anio);
    	}else if($almacen == 2){
    		$objWorkSheet->setCellValue('A1', 'SALIDA DE PRODUCTOS VALORIZADOS - STA. ANITA                     FECHA: '.$nombre_mes.' '.$anio);
    	}
    	$objWorkSheet->setCellValue('K1', ' SALIDAS ');

    	$objWorkSheet->setCellValue('A2', '')
	    			 ->setCellValue('B2', 'MES')
	    			 ->setCellValue('C2', 'FECHA')
	    			 ->setCellValue('D2', 'TIPO DOC.')
	    			 ->setCellValue('E2', 'SERIE')
	    			 ->setCellValue('F2', 'NUMERO')
	    			 ->setCellValue('G2', 'PROVEEDOR')
	    			 ->setCellValue('H2', 'NOMBRE DEL PRODUCTO')
	    			 ->setCellValue('I2', 'PROCED')
	    			 ->setCellValue('J2', 'SUM/REP')
	    			 ->setCellValue('K2', 'MEDIDA')
	    			 ->setCellValue('L2', 'CANTIDAD')
	    			 ->setCellValue('M2', 'CU')
	    			 ->setCellValue('N2', 'CT')
	    			 ->setCellValue('O2', 'SOLICITANTE');
	    // Traer informacion de la BD
	    // Selecciono todos los productos que salieron de almacen dentro de la fecha seleccionada
	    $result = $this->model_comercial->get_info_salidas_report($f_inicial, $f_final, $almacen);
	    // Recorrido
	    $p = 3;
		$contador_filas = 1;
		$variable = "";
		$auxiliar = "";
		$suma_cantidades_utilizadas = 0;
		$stock_inicial = 0;
		$precio_uni_inicial = 0;
		$contador_kardex = 0;
	    if(count($result) > 0){
		    foreach ($result as $reg) {
		    	$id_detalle_producto = $reg->id_detalle_producto;
		    	$fecha_salida = $reg->fecha;
		    	$cantidad_salida = $reg->cantidad_salida;
		    	$no_producto = $reg->no_producto;
		    	$no_procedencia = $reg->no_procedencia;
		    	$no_categoria = $reg->no_categoria;
		    	$nom_uni_med = $reg->nom_uni_med;
		    	$id_salida_producto = $reg->id_salida_producto;
		    	$p_u_salida = $reg->p_u_salida;
		    	$solicitante = $reg->solicitante;
		    	$id_pro = $reg->id_pro;
		    	// obtener el precio unitario ponderado del producto en la fecha de salida
		    	$fecha_inicio_anio = explode("-", date('Y-m-d'));
                $anio = $fecha_inicio_anio[0];
                $mes = 1;
                $dia = 1;
                $array = array($anio, $mes, $dia);
                $fecha_inicio_anio = implode("-", $array);
                $fecha_inicio_anio = date("Y-m-d", strtotime($fecha_inicio_anio));
                // consultar en bd por el saldo inicial del producto en dicha fecha
                $this->db->select('stock_inicial,precio_uni_inicial');
                $this->db->where('fecha_cierre',$fecha_inicio_anio);
                $this->db->where('id_pro',$id_pro);
                $query = $this->db->get('saldos_iniciales');
                if(count($query->result()) > 0){
                    foreach($query->result() as $row){
                        $stock_inicial = $row->stock_inicial;
                        $precio_uni_inicial = $row->precio_uni_inicial;
                    }
                }
                // obtener movimientos hasta la fecha de salida
                // consultar por los movimientos del producto en el mes para acumularlo en la variable stock_inicial
                $stock_anterior = 0;
                $precio_unitario_anterior = 0;
                $result_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$fecha_inicio_anio,$fecha_salida);
                $existe_2 = count($result_kardex);
                if($existe_2 > 0){
                    foreach ($result_kardex as $data) {
                        if($data->descripcion == "ENTRADA" || $data->descripcion == "IMPORTACION" || $data->descripcion == "ORDEN INGRESO"){
                            if($contador_kardex == 0){
                                $stock_saldo_final = $stock_inicial + $data->cantidad_ingreso;
                                $precio_unitario_ponderado = (($stock_inicial*$precio_uni_inicial)+($data->cantidad_ingreso*$data->precio_unitario_actual))/($stock_inicial+$data->cantidad_ingreso);
                                $contador_kardex++;
                            }else{
                                $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
                                $precio_unitario_ponderado = (($stock_anterior*$precio_unitario_anterior)+($data->cantidad_ingreso*$data->precio_unitario_actual))/($stock_anterior+$data->cantidad_ingreso);
                            }
                            $stock_anterior = $stock_saldo_final;
                            $precio_unitario_anterior = $precio_unitario_ponderado;
                        }else if($data->descripcion == "SALIDA"){
                            if($contador_kardex == 0){
                                $stock_saldo_final = $stock_inicial - $data->cantidad_salida;
                                $precio_unitario_ponderado = $precio_uni_inicial;
                                $contador_kardex++;
                            }else{
                                $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
                            }
                            $stock_anterior = $stock_saldo_final;
                            $precio_unitario_anterior = $precio_unitario_ponderado;
                        }
                    }
                }else{
                    $stock_saldo_final = $stock_inicial;
                    $precio_unitario_ponderado = $precio_uni_inicial;
                }
		    	// Identificando las facturas utilizadas para la salida del producto
		    	$invoice = $this->model_comercial->get_select_facturas_asociadas($id_salida_producto);
		    	/*
		    	if(count($invoice) == 1){
			    	foreach ($invoice as $row) {
			    		$id_ingreso_producto = $row->id_ingreso_producto;
			    		$cantidad_utilizada = $row->cantidad_utilizada;
			    		// Obtener los datos del detalle de la factura
			    		$data_invoice = $this->model_comercial->get_select_data_invoice($id_ingreso_producto);
			    		foreach ($data_invoice as $data){
			    			$serie = $data->serie_comprobante;
			    			$nro_comprobante = $data->nro_comprobante;
			    			$razon_social = $data->razon_social;
			    			$no_comprobante = $data->no_comprobante;
			    			$precio_entrada = $data->precio;
			    			$fecha_registro = $data->fecha;
			    			$no_moneda = $data->no_moneda;
			    			$id_moneda = $data->id_moneda;
			    		}
			    		// obtener el tipo de cambio del precio de entrada de la factura 
			    		$this->db->select('dolar_venta,euro_venta,fr_venta');
				        $this->db->where('fecha_actual',$fecha_registro);
				        $query = $this->db->get('tipo_cambio');
				        foreach($query->result() as $row){
				            $dolar_venta_fecha = $row->dolar_venta;
				            $euro_venta_fecha = $row->euro_venta;
				            $fr_venta_fecha = $row->fr_venta;
				        }

    			    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    			    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    			    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    			    	/* Centrar contenido
    			    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($style);
    		    		/* border
    		    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($borders);

			    		$objWorkSheet->setCellValue('A'.$p, $contador_filas)
			    					 ->setCellValue('B'.$p, $nombre_mes)
			    					 ->setCellValue('C'.$p, $no_comprobante)
			    					 ->setCellValueExplicit('D'.$p, $serie,PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('E'.$p, $nro_comprobante)
			    					 ->setCellValue('F'.$p, $razon_social)
			    					 ->setCellValue('G'.$p, $no_producto)
			    					 ->setCellValue('H'.$p, $no_procedencia)
			    					 ->setCellValue('I'.$p, $no_categoria)
			    					 ->setCellValue('J'.$p, $nom_uni_med)
			    					 ->setCellValue('K'.$p, $cantidad_salida)
			    					 ->setCellValue('L'.$p, $p_u_salida)
			    					 ->setCellValue('M'.$p, ($cantidad_salida*$p_u_salida))
			    					 ->setCellValue('N'.$p, $solicitante);
			    		$p++;
			    		$contador_filas++;
			    	}
			    }if(count($invoice) == 2){
			    	foreach ($invoice as $row) {
			    		$id_ingreso_producto = $row->id_ingreso_producto;
			    		$cantidad_utilizada = $row->cantidad_utilizada;
			    		// Obtener los datos del detalle de la factura
			    		$data_invoice = $this->model_comercial->get_select_data_invoice($id_ingreso_producto);
			    		foreach ($data_invoice as $data){
			    			$serie = $data->serie_comprobante;
			    			$nro_comprobante = $data->nro_comprobante;
			    			$razon_social = $data->razon_social;
			    			$no_comprobante = $data->no_comprobante;
			    			$precio_entrada = $data->precio;
			    			$fecha_registro = $data->fecha;
			    			$no_moneda = $data->no_moneda;
			    			$id_moneda = $data->id_moneda;
			    		}
			    		// obtener el tipo de cambio del precio de entrada de la factura 
			    		$this->db->select('dolar_venta,euro_venta,fr_venta');
				        $this->db->where('fecha_actual',$fecha_registro);
				        $query = $this->db->get('tipo_cambio');
				        foreach($query->result() as $row){
				            $dolar_venta_fecha = $row->dolar_venta;
				            $euro_venta_fecha = $row->euro_venta;
				            $fr_venta_fecha = $row->fr_venta;
				        }

    			    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    			    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    			    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    			    	// Centrar contenido
    			    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style);
    		    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($style);
    		    		// border
    		    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);
    		    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($borders);

			    		$objWorkSheet->setCellValue('A'.$p, $contador_filas)
			    					 ->setCellValue('B'.$p, $nombre_mes)
			    					 ->setCellValue('C'.$p, $no_comprobante)
			    					 ->setCellValueExplicit('D'.$p, $serie,PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('E'.$p, $nro_comprobante)
			    					 ->setCellValue('F'.$p, $razon_social)
			    					 ->setCellValue('G'.$p, $no_producto)
			    					 ->setCellValue('H'.$p, $no_procedencia)
			    					 ->setCellValue('I'.$p, $no_categoria)
			    					 ->setCellValue('J'.$p, $nom_uni_med)
			    					 ->setCellValue('K'.$p, ($cantidad_salida/2))
			    					 ->setCellValue('L'.$p, $p_u_salida)
			    					 ->setCellValue('M'.$p, (($cantidad_salida/2)*$p_u_salida));
			    		$p++;
			    		$contador_filas++;
			    	}
			    }
			    */
			    if(count($invoice) > 0){
				    foreach ($invoice as $row) {
			    		$id_ingreso_producto = $row->id_ingreso_producto;
			    		$cantidad_utilizada = $row->cantidad_utilizada;
			    		$suma_cantidades_utilizadas = $suma_cantidades_utilizadas + $cantidad_utilizada;
			    		if($cantidad_utilizada < 0){
			    			$auxiliar = "stock_negativo";
			    		}
			    	}
			    }
			    if($auxiliar != "stock_negativo"){
				    if(count($invoice) > 0){
					    foreach ($invoice as $row) {
				    		$id_ingreso_producto = $row->id_ingreso_producto;
				    		$cantidad_utilizada = $row->cantidad_utilizada;
				    		// Obtener los datos del detalle de la factura
				    		$data_invoice = $this->model_comercial->get_select_data_invoice($id_ingreso_producto);
				    		foreach ($data_invoice as $data){
				    			$serie = $data->serie_comprobante;
				    			$nro_comprobante = $data->nro_comprobante;
				    			$razon_social = $data->razon_social;
				    			$no_comprobante = $data->no_comprobante;
				    			$precio_entrada = $data->precio;
				    			$fecha_registro = $data->fecha;
				    			$no_moneda = $data->no_moneda;
				    			$id_moneda = $data->id_moneda;
				    		}
				    		// obtener el tipo de cambio del precio de entrada de la factura 
				    		$this->db->select('dolar_venta,euro_venta,fr_venta');
					        $this->db->where('fecha_actual',$fecha_registro);
					        $query = $this->db->get('tipo_cambio');
					        foreach($query->result() as $row){
					            $dolar_venta_fecha = $row->dolar_venta;
					            $euro_venta_fecha = $row->euro_venta;
					            $fr_venta_fecha = $row->fr_venta;
					        }

					    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    	$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    	/* Centrar contenido */
					    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($style);
				    		$objPHPExcel->getActiveSheet()->getStyle('O'.$p)->applyFromArray($style);
				    		/* border */
				    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($borders);
				    		$objPHPExcel->getActiveSheet()->getStyle('O'.$p)->applyFromArray($borders);

				    		$objWorkSheet->setCellValue('A'.$p, $contador_filas)
				    					 ->setCellValue('B'.$p, $nombre_mes)
				    					 ->setCellValue('C'.$p, $fecha_salida)
				    					 ->setCellValue('D'.$p, $no_comprobante)
				    					 ->setCellValueExplicit('E'.$p, $serie,PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('F'.$p, $nro_comprobante)
				    					 ->setCellValue('G'.$p, $razon_social)
				    					 ->setCellValue('H'.$p, $no_producto)
				    					 ->setCellValue('I'.$p, $no_procedencia)
				    					 ->setCellValue('J'.$p, $no_categoria)
				    					 ->setCellValue('K'.$p, $nom_uni_med)
				    					 ->setCellValue('L'.$p, $cantidad_utilizada)
				    					 ->setCellValue('M'.$p, $precio_unitario_ponderado)
				    					 ->setCellValue('N'.$p, ($cantidad_utilizada*$precio_unitario_ponderado))
				    					 ->setCellValue('O'.$p, $solicitante);
				    		$p++;
				    		$contador_filas++;
				    	}
				    }
			    }else{
		    		// $id_ingreso_producto = $row->id_ingreso_producto;
		    		// Obtener los datos del detalle de la factura
		    		$data_invoice = $this->model_comercial->get_select_data_invoice($id_ingreso_producto);
		    		foreach ($data_invoice as $data){
		    			$serie = $data->serie_comprobante;
		    			$nro_comprobante = $data->nro_comprobante;
		    			$razon_social = $data->razon_social;
		    			$no_comprobante = $data->no_comprobante;
		    			$precio_entrada = $data->precio;
		    			$fecha_registro = $data->fecha;
		    			$no_moneda = $data->no_moneda;
		    			$id_moneda = $data->id_moneda;
		    		}
		    		// obtener el tipo de cambio del precio de entrada de la factura 
		    		$this->db->select('dolar_venta,euro_venta,fr_venta');
			        $this->db->where('fecha_actual',$fecha_registro);
			        $query = $this->db->get('tipo_cambio');
			        foreach($query->result() as $row){
			            $dolar_venta_fecha = $row->dolar_venta;
			            $euro_venta_fecha = $row->euro_venta;
			            $fr_venta_fecha = $row->fr_venta;
			        }

			    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	/* Centrar contenido */
			    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($style);
		    		$objPHPExcel->getActiveSheet()->getStyle('O'.$p)->applyFromArray($style);
		    		/* border */
		    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('N'.$p)->applyFromArray($borders);
		    		$objPHPExcel->getActiveSheet()->getStyle('O'.$p)->applyFromArray($borders);

		    		$objWorkSheet->setCellValue('A'.$p, $contador_filas)
		    					 ->setCellValue('B'.$p, $nombre_mes)
		    					 ->setCellValue('C'.$p, $fecha_salida)
		    					 ->setCellValue('D'.$p, $no_comprobante)
		    					 ->setCellValueExplicit('E'.$p, $serie,PHPExcel_Cell_DataType::TYPE_STRING)
		    					 ->setCellValue('F'.$p, $nro_comprobante)
		    					 ->setCellValue('G'.$p, $razon_social)
		    					 ->setCellValue('H'.$p, $no_producto)
		    					 ->setCellValue('I'.$p, $no_procedencia)
		    					 ->setCellValue('J'.$p, $no_categoria)
		    					 ->setCellValue('K'.$p, $nom_uni_med)
		    					 ->setCellValue('L'.$p, $suma_cantidades_utilizadas)
		    					 ->setCellValue('M'.$p, $precio_unitario_ponderado)
		    					 ->setCellValue('N'.$p, ($suma_cantidades_utilizadas*$precio_unitario_ponderado))
		    					 ->setCellValue('O'.$p, $solicitante);
		    		$p++;
		    		$contador_filas++;
			    }
			    $auxiliar = "";
			    $suma_cantidades_utilizadas = 0;
			    $stock_inicial = 0;
			    $contador_kardex = 0;
	    		/* Rename sheet */
			    $objWorkSheet->setTitle("reporte_mensual_salidas_oficial");
		    }
	    }
    	$objPHPExcel->setActiveSheetIndex(0);
		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=reporte_mensual_salidas_oficial.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function al_exportar_inventario_almacen(){
		$almacen = $this->security->xss_clean($this->session->userdata('almacen'));

		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$area_combo = $data[0];

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		/* Here your first sheet */
	    $sheet = $objPHPExcel->getActiveSheet();

	     /* Style - Bordes */
	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $style_2 = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        )
	    );

	    $styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);

	    // Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
		$objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(13);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);
		//$objPHPExcel->getActiveSheet()->getRowDimension('A')->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		// Write cells
		if($almacen == 1){
			$objWorkSheet->setCellValue('A1', 'INVENTARIO FISICO DE PRODUCTOS - STA. CLARA                     FECHA: '.date('d-m-y'));
    	}else if($almacen == 2){
    		$objWorkSheet->setCellValue('A1', 'INVENTARIO FISICO DE PRODUCTOS - STA. ANITA                     FECHA: '.date('d-m-y'));
    	}
	    $objWorkSheet->setCellValue('A2', 'ID PRODUCTO')
	    			 ->setCellValue('B2', 'NOMBRE O DESCRIPCION')
	    			 ->setCellValue('C2', 'ÁREA')
	    			 ->setCellValue('D2', 'CATEGORIA')
	    			 ->setCellValue('E2', 'TIPO DE PRODUCTO')
	    			 ->setCellValue('F2', 'PROCEDENCIA')
	    			 ->setCellValue('G2', 'U. MEDIDA')
	    			 ->setCellValue('H2', 'STOCK')
	    			 ->setCellValue('I2', 'P. UNITARIO')
	    			 ->setCellValue('J2', 'VALORIZADO S/.')
	    			 ->setCellValue('K2', 'INVENTARIO');
	    /* Traer informacion de la BD */
	    $result = $this->model_comercial->get_info_inventario_actual_V2($area_combo);
	    /* Recorro con todos los nombres seleccionados que tienen una salida/ingreso en el kardex */
	    $i = 0;
	    $sumatoria = 0;
	    $valorizado = 0;
	    $p = 3;
	    foreach ($result as $reg) {
	    	$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    	$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    	$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    	/* Centrar contenido */
	    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
    		/* border */
    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
    		if($reg->estado == 't'){
    			$estado = 'ACTIVO';
    		}else if($reg->estado == 'f'){
    			$estado = 'INACTIVO';
    		}
	    	if($almacen == 1){
	    		$valorizado = $reg->stock_sta_clara*$reg->precio_unitario;
			    $objWorkSheet->setCellValue('A'.$p, $reg->id_producto)
	    					 ->setCellValue('B'.$p, $reg->no_producto)
	    					 ->setCellValue('C'.$p, $reg->no_area)
	    					 ->setCellValue('D'.$p, $reg->no_categoria)
	    					 ->setCellValue('E'.$p, $reg->no_tipo_producto)
	    					 ->setCellValue('F'.$p, $reg->no_procedencia)
	    					 ->setCellValue('G'.$p, $reg->nom_uni_med)
	    					 ->setCellValue('H'.$p, $reg->stock_area_sta_clara)
	    					 ->setCellValue('I'.$p, $reg->precio_unitario)
	    					 ->setCellValue('J'.$p, $valorizado)
	    					 ->setCellValue('K'.$p, "");
	    	}else if($almacen == 2){
	    		$valorizado = $reg->stock*$reg->precio_unitario;
	    		$objWorkSheet->setCellValue('A'.$p, $reg->id_producto)
	    					 ->setCellValue('B'.$p, $reg->no_producto)
	    					 ->setCellValue('C'.$p, $reg->no_area)
	    					 ->setCellValue('D'.$p, $reg->no_categoria)
	    					 ->setCellValue('E'.$p, $reg->no_tipo_producto)
	    					 ->setCellValue('F'.$p, $reg->no_procedencia)
	    					 ->setCellValue('G'.$p, $reg->nom_uni_med)
	    					 ->setCellValue('H'.$p, $reg->stock_area_sta_anita)
	    					 ->setCellValue('I'.$p, $reg->precio_unitario)
	    					 ->setCellValue('J'.$p, $valorizado)
	    					 ->setCellValue('K'.$p, "");
	    	}
	    	$sumatoria = $sumatoria + $valorizado;
		    // Rename sheet
		    $objWorkSheet->setTitle("Inventario_Almacen");
		    $p++;
        }

        // Formatos
	    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    // Centrar contenido
	    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($styleArray);
	    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($styleArray);
	    // borderF
	    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
	    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);

	    $objWorkSheet->setCellValue('A'.$p, "")
		    		 ->setCellValue('B'.$p, "")
		    		 ->setCellValue('C'.$p, "")
		    		 ->setCellValue('D'.$p, "")
		    		 ->setCellValue('E'.$p, "")
		    		 ->setCellValue('F'.$p, "")
		    		 ->setCellValue('G'.$p, "")
		    		 ->setCellValue('H'.$p, "")
		    		 ->setCellValue('I'.$p, "T. EN SOLES")
		    		 ->setCellValue('J'.$p, $sumatoria);


	    $objPHPExcel->setActiveSheetIndex(0);
		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=inventario_almacen.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function al_exportar_kardex_producto_excel(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$id_detalle_producto = $data[0];
		$f_inicial = $data[1];
		$f_final = $data[2];

		(array)$arr = str_split($f_final, 4);
		$anio = $arr[0];

		/* Formato para la fecha inicial */
		$elementos = explode("-", $f_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        $array = array($dia, $mes, $anio);
		$f_inicial = implode("-", $array);
		/* Fin */

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		/* Here your first sheet */
	    $sheet = $objPHPExcel->getActiveSheet();

	    /* Traer informacion de la BD */
	    $nombre_productos_salidas = $this->model_comercial->traer_nombres_kardex_producto($id_detalle_producto);
	    /* Recorro con todos los nombres seleccionados que tienen una salida/ingreso en el kardex */
	    /*  */
	    $i = 0;
	    foreach ($nombre_productos_salidas as $reg) {

        	$nombre_producto = $reg->no_producto;
        	$id_producto = $reg->id_producto;
        	$id_unidad_medida = $reg->id_unidad_medida;
        	$id_detalle_producto = $reg->id_detalle_producto;
        	$id_pro = $reg->id_pro;

        	// Add new sheet
		    $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
		    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('A1:D1');
		    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('A12:D12');
		    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('E12:G12');
		    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('H12:J12');
		    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('K12:M12');

        	/* Style - Bordes */
		    $borders = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('argb' => 'FF000000'),
					)
				),
			);

			$style = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );

		    $style_2 = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		        )
		    );

		    $styleArray = array(
			    'font' => array(
			        'bold' => true
			    )
			);

			$objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($borders);
			$objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($borders);
			$objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($borders);
			$objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($borders);
			$objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($borders);

			$objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($style);

			$objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

			$objPHPExcel->getActiveSheet()->getStyle('A1:D10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F1:F10')->applyFromArray($styleArray);
			//Write cells
		    $objWorkSheet->setCellValue('A1', 'INVENTARIO PERMANENTE VALORIZADO')
		            	 ->setCellValue('A2', 'PERIODO: '.$anio)
		            	 ->setCellValue('A3', 'RUC: 20101717098')
		            	 ->setCellValue('A4', 'TEJIDOS JORGITO SRL')
		            	 ->setCellValue('A5', 'CALLE LOS TELARES No 103-105 URB. VULCANO-ATE')
		            	 ->setCellValue('A6', 'CÓDIGO: '.$id_producto)
		            	 ->setCellValue('A7', 'TIPO: 03')
		            	 ->setCellValue('A8', 'DESCRIPCIÓN: '.$nombre_producto)
		            	 ->setCellValue('A9', 'UNIDAD DE MEDIDA: '.$id_unidad_medida)
		            	 ->setCellValue('A10', 'MÉTODO DE EVALUACIÓN: COSTO PROMEDIO');
		    $objWorkSheet->setCellValue('F1', 'FT: FACTURA')
		            	 ->setCellValue('F2', 'GR: GUÍA DE REMISIÓN')
		            	 ->setCellValue('F3', 'BV: BOLETA DE VENTA')
		            	 ->setCellValue('F4', 'NC: NOTA DE CRÉDITO')
		            	 ->setCellValue('F5', 'ND: NOTA DE DÉBITO')
		            	 ->setCellValue('F6', 'OS: ORDEN DE SALIDA')
		            	 ->setCellValue('F7', 'OI: ORDEN DE INGRESO')
		            	 ->setCellValue('F8', 'CU: COSTO UNITARIO (NUEVOS SOLES)')
		            	 ->setCellValue('F9', 'CT: COSTO TOTAL (NUEVOS SOLES)')
		            	 ->setCellValue('F10', 'SI: SALDO INICIAL');
		    $objWorkSheet->setCellValue('A12', 'DOCUMENTO DE MOVIMIENTO')
		    			 ->setCellValue('E12', 'ENTRADAS')
		    			 ->setCellValue('H12', 'SALIDAS')
		    			 ->setCellValue('K12', 'SALDO FINAL');
		    $objWorkSheet->setCellValue('A13', 'FECHA')
		    			 ->setCellValue('B13', 'TIPO')
		    			 ->setCellValue('C13', 'SERIE')
		    			 ->setCellValue('D13', 'NÚMERO')
		    			 ->setCellValue('E13', 'CANTIDAD')
		    			 ->setCellValue('F13', 'CU')
		    			 ->setCellValue('G13', 'CT')
		    			 ->setCellValue('H13', 'CANTIDAD')
		    			 ->setCellValue('I13', 'CU')
		    			 ->setCellValue('J13', 'CT')
		    			 ->setCellValue('K13', 'CANTIDAD')
		    			 ->setCellValue('L13', 'CU')
		    			 ->setCellValue('M13', 'CT');

		    /* Formato para la fila 14 */
	    	$objPHPExcel->getActiveSheet()->getStyle('A14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('B14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('A14')->applyFromArray($style);
	    	$objPHPExcel->getActiveSheet()->getStyle('B14')->applyFromArray($style);
	    	$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray($style);
	    	$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($style);
	    	$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('F14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('G14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('H14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('I14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('J14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('K14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('L14')->applyFromArray($borders);
	    	$objPHPExcel->getActiveSheet()->getStyle('M14')->applyFromArray($borders);

		    /* Traer saldos iniciales de la BD */
	    	$saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($f_inicial,$id_pro);

	    	/* varianles para las sumatorias */
	    	$sumatoria_cantidad_entradas = 0;
	    	$sumatoria_parciales_entradas = 0;

	    	$sumatoria_cantidad_salidas = 0;
			$sumatoria_parciales_salidas = 0;

	    	$sumatoria_cantidad_saldos = 0;
			$sumatoria_parciales_saldos = 0;

			$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('F14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('G14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('H14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('I14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('J14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('K14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('L14')->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('M14')->applyFromArray($style_2);

		    $objPHPExcel->getActiveSheet()->getStyle('E14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('F14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('G14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('H14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('I14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('J14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('K14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('L14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('M14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

	    	if( count($saldos_iniciales) > 0 ){
	    		foreach ($saldos_iniciales as $result) {
	    			$total_saldos_iniciales = $result->stock_inicial + $result->stock_inicial_sta_clara;
	    			/* Formato de Fecha */
	    			$elementos = explode("-", $result->fecha_cierre);
			        $anio = $elementos[0];
			        $mes = $elementos[1];
			        $dia = $elementos[2];
			        $array = array($dia, $mes, $anio);
        			$fecha_formateada = implode("-", $array);
	    			/* Fin */
		    		$objWorkSheet->setCellValue('A14', $fecha_formateada)
			    			     ->setCellValue('B14', " ")
			    			     ->setCellValue('C14', "SI")
			    			     ->setCellValue('D14', " ")
			    			     ->setCellValue('E14', $total_saldos_iniciales)
			    			     ->setCellValue('F14', $result->precio_uni_inicial)
			    			     ->setCellValue('G14', $total_saldos_iniciales*$result->precio_uni_inicial)
			    			     ->setCellValueExplicit('H14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValue('I14', $result->precio_uni_inicial)
			    			     ->setCellValueExplicit('J14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValue('K14', $total_saldos_iniciales)
			    			     ->setCellValue('L14', $result->precio_uni_inicial)
			    			     ->setCellValue('M14', $total_saldos_iniciales*$result->precio_uni_inicial);
				    /* ENTRADAS */
					$sumatoria_cantidad_entradas = $sumatoria_cantidad_entradas + $total_saldos_iniciales;
					$sumatoria_parciales_entradas = $sumatoria_parciales_entradas + ($total_saldos_iniciales * $result->precio_uni_inicial);
					/* SALDOS */
					$sumatoria_cantidad_saldos = $sumatoria_cantidad_saldos + $total_saldos_iniciales;
					$sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($total_saldos_iniciales * $result->precio_uni_inicial);
		    	}
	    	}else{
	    		$objWorkSheet->setCellValueExplicit('A14', $f_inicial)
		    			     ->setCellValueExplicit('B14', " ")
		    			     ->setCellValueExplicit('C14', "SI")
		    			     ->setCellValueExplicit('D14', " ")
		    			     ->setCellValueExplicit('E14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('F14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('G14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('H14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('I14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('J14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('K14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('L14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
		    			     ->setCellValueExplicit('M14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING);
	    	}

		    /* Recorrido del detalle del kardex general por producto */
		    $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$f_inicial,$f_final);
		    $existe = count($detalle_movimientos_kardex);
		    $y = 0;
		    if($existe > 0){
			    foreach ($detalle_movimientos_kardex as $data) {
			    	$p = 15;
			    	$p = $p + $y;
			    	/* Centrar contenido */
			    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
			    	$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
			    	$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
			    	$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
			    	$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);

			    	$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style_2);
			    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style_2);

			    	$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
			    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);
			    	/* formato de variables */
			    	$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			    	/* Traer ID de salida del producto */
			    	if($data->descripcion == "SALIDA"){
			    		$fecha_salida = $data->fecha_registro;
			    		$detalle_producto = $data->id_detalle_producto;
			    		$cantidad_salida = $data->cantidad_salida;
			    	}

			    	/* Formato de Fecha */
	    			$elementos = explode("-", $data->fecha_registro);
			        $anio = $elementos[0];
			        $mes = $elementos[1];
			        $dia = $elementos[2];
			        $array = array($dia, $mes, $anio);
        			$fecha_formateada_2 = implode("-", $array);

			    	/* fin de formato */
			    	if($data->descripcion == "ENTRADA"){
			    		$objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
			    					 ->setCellValue('B'.$p, "FT")
			    					 ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('E'.$p, $data->cantidad_ingreso)
			    					 ->setCellValue('F'.$p, $data->precio_unitario_actual)
			    					 ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
			    					 ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('I'.$p, $data->precio_unitario_actual)
			    					 ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('K'.$p, $data->stock_actual)
			    					 ->setCellValue('L'.$p, $data->precio_unitario_actual_promedio)
			    					 ->setCellValue('M'.$p, $data->stock_actual*$data->precio_unitario_actual_promedio);
			    	}else if($data->descripcion == "SALIDA"){
			    		$objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
			    					 ->setCellValue('B'.$p, "OS")
			    					 ->setCellValue('C'.$p, "NIG")
			    					 ->setCellValueExplicit('D'.$p, str_pad($data->id_kardex_producto, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValueExplicit('E'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValueExplicit('F'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValueExplicit('G'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('H'.$p, $data->cantidad_salida)
			    					 ->setCellValue('I'.$p, $data->precio_unitario_anterior)
			    					 ->setCellValue('J'.$p, $data->cantidad_salida*$data->precio_unitario_anterior)
			    					 ->setCellValue('K'.$p, $data->stock_actual)
			    					 ->setCellValue('L'.$p, $data->precio_unitario_actual)
			    					 ->setCellValue('M'.$p, $data->stock_actual*$data->precio_unitario_actual);
			    	}else if($data->descripcion == "IMPORTACION"){
			    		$objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
			    					 ->setCellValue('B'.$p, "IMPORTACION")
			    					 ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('E'.$p, $data->cantidad_ingreso)
			    					 ->setCellValue('F'.$p, $data->precio_unitario_actual)
			    					 ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
			    					 ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('I'.$p, $data->precio_unitario_actual)
			    					 ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('K'.$p, $data->stock_actual)
			    					 ->setCellValue('L'.$p, $data->precio_unitario_actual_promedio)
			    					 ->setCellValue('M'.$p, $data->stock_actual*$data->precio_unitario_actual_promedio);
			    	}else if($data->descripcion == "ORDEN INGRESO"){
			    		$objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
			    					 ->setCellValue('B'.$p, "OI")
			    					 ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('E'.$p, $data->cantidad_ingreso)
			    					 ->setCellValue('F'.$p, $data->precio_unitario_actual)
			    					 ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
			    					 ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('I'.$p, $data->precio_unitario_actual)
			    					 ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    					 ->setCellValue('K'.$p, $data->stock_actual)
			    					 ->setCellValue('L'.$p, $data->precio_unitario_actual_promedio)
			    					 ->setCellValue('M'.$p, $data->stock_actual*$data->precio_unitario_actual_promedio);
			    	}	    	
			    	/* ENTRADAS */
					$sumatoria_cantidad_entradas = $sumatoria_cantidad_entradas + $data->cantidad_ingreso;
					$sumatoria_parciales_entradas = $sumatoria_parciales_entradas + ($data->cantidad_ingreso * $data->precio_unitario_actual);
					/* SALIDAS */
					$sumatoria_cantidad_salidas = $sumatoria_cantidad_salidas + $data->cantidad_salida;
					$sumatoria_parciales_salidas = $sumatoria_parciales_salidas + ($data->cantidad_salida * $data->precio_unitario_actual);
					/* SALDOS */
					$sumatoria_cantidad_saldos = $sumatoria_cantidad_saldos + $data->stock_actual;
					if($data->descripcion == "SALIDA"){
			    		$sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($data->precio_unitario_actual * $data->stock_actual);
			    	}else if($data->descripcion == "ENTRADA"){
			    		$sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($data->precio_unitario_actual_promedio * $data->stock_actual);
			    	}
			    	$y = $y + 1;
				}
			}

			$p = 15 + $y;
			$objWorkSheet->setCellValue('A'.$p, "")
		    		     ->setCellValue('B'.$p, "")
		    		     ->setCellValue('C'.$p, "")
		    		     ->setCellValue('D'.$p, "TOTALES")
		    		     ->setCellValue('E'.$p, $sumatoria_cantidad_entradas)
		    		     ->setCellValue('F'.$p, "")
		    		     ->setCellValue('G'.$p, $sumatoria_parciales_entradas)
		    		     ->setCellValue('H'.$p, $sumatoria_cantidad_salidas)
		    		     ->setCellValue('I'.$p, "")
		    		     ->setCellValue('J'.$p, $sumatoria_parciales_salidas)
		    		     ->setCellValue('K'.$p, $sumatoria_cantidad_saldos)
		    		     ->setCellValue('L'.$p, "")
		    		     ->setCellValue('M'.$p, $sumatoria_parciales_saldos);

		    /* Centrar contenido */
		    $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
		    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
		    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);

		    /* Dar formato numericos a las celdas */
		    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		    /* Alinear el valor de la celda a la derecha */
		    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style_2);
		    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style_2);

		    /* Rename sheet */
		    $objWorkSheet->setTitle("$nombre_producto");
		    $i++;
        }

	    $objPHPExcel->setActiveSheetIndex(0);

		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$nombre_producto.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function al_exportar_report_ingresos(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$f_inicial = $data[0];
		$f_final = $data[1];

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	    // Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
		$objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);

		/* propiedades de la celda */

		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

		//Write cells
	    $objWorkSheet->setCellValue('A1', 'ITEM')
	            	 ->setCellValue('B1', 'COMPROBANTE')
	            	 ->setCellValue('C1', 'SERIE - NÚMERO')
	            	 ->setCellValue('D1', 'PROVEEDOR')
	            	 ->setCellValue('E1', 'FECHA DE REGISTRO ')
	            	 ->setCellValue('F1', 'MONEDA')
	            	 ->setCellValue('G1', 'MONTO TOTAL')
	            	 ->setCellValue('H1', 'TOTAL EN SOLES')
	            	 ->setCellValue('I1', 'PROCEDENCIA');

	    /* Traer informacion de la BD */
	    $movimientos_entrada = $this->model_comercial->traer_movimientos_entrada_facturas($f_inicial,$f_final);
	    $existe = count($movimientos_entrada);
	    $sumatoria_totales = 0;
	    $p = 2;
	    $i = 1;
	    $suma_dolares = 0;
	    $suma_euro = 0;
	    $suma_franco = 0;
	    $suma_soles = 0;
	    $suma_total_soles = 0;
	    if($existe > 0){
	    	foreach ($movimientos_entrada as $data) {
	    		/* Formatos */
	    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		/* Centrar contenido */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);

	    		/* border */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);

				/* Obtener el tipo de cambio de la fecha de registro de la factura */
				$this->db->select('dolar_venta,euro_venta,fr_venta');
		        $this->db->where('fecha_actual',$data->fecha);
		        $query = $this->db->get('tipo_cambio');
		        foreach($query->result() as $row){
		            $dolar_venta_fecha = $row->dolar_venta;
		            $euro_venta_fecha = $row->euro_venta;
		            $fr_venta_fecha = $row->fr_venta;
		        }
		        /* Obtener el monto total en soles */
		        if($data->id_agente == 2){
		        	if($data->no_moneda == 'DOLARES'){
		                $convert_soles = $data->total * $dolar_venta_fecha;
		                $suma_dolares = $suma_dolares + $data->total;
		                $suma_total_soles = $suma_total_soles + $convert_soles;
		            }else if($data->no_moneda == 'EURO'){
		                $convert_soles = $data->total * $euro_venta_fecha;
		                $suma_euro = $suma_euro + $data->total;
		                $suma_total_soles = $suma_total_soles + $convert_soles;
		            }else if($data->no_moneda == 'FRANCO SUIZO'){
		                $convert_soles = $data->total * $fr_venta_fecha;
		                $suma_franco = $suma_franco + $data->total;
		                $suma_total_soles = $suma_total_soles + $convert_soles;
		            }else{
		            	$convert_soles = $data->total;
		            	$suma_soles = $suma_soles + $data->total;
		                $suma_total_soles = $suma_total_soles + $data->total;
		            }
		        }else{
		        	$convert_soles = $data->total;
		        	$suma_soles = $suma_soles + $data->total;
		            $suma_total_soles = $suma_total_soles + $data->total;
		        }

		        if($data->id_agente == 2){
		        	$objWorkSheet->setCellValue('A'.$p, $i)
	    					     ->setCellValue('B'.$p, $data->no_comprobante)
	    					     ->setCellValue('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT)." - ".str_pad($data->nro_comprobante, 8, 0, STR_PAD_LEFT))
	    					     ->setCellValue('D'.$p, $data->razon_social)
	    					     ->setCellValue('E'.$p, $data->fecha)
	    					     ->setCellValue('F'.$p, $data->simbolo_mon." ".$data->no_moneda)
	    					     ->setCellValue('G'.$p, $data->total)
	    					     ->setCellValue('H'.$p, $convert_soles)
	    					     ->setCellValue('I'.$p, 'NACIONAL');
		        }else{
		        	$objWorkSheet->setCellValue('A'.$p, $i)
	    					     ->setCellValue('B'.$p, $data->no_comprobante)
	    					     ->setCellValue('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT)." - ".str_pad($data->nro_comprobante, 8, 0, STR_PAD_LEFT))
	    					     ->setCellValue('D'.$p, $data->razon_social)
	    					     ->setCellValue('E'.$p, $data->fecha)
	    					     ->setCellValue('F'.$p, $data->simbolo_mon." ".$data->no_moneda)
	    					     ->setCellValue('G'.$p, $data->total)
	    					     ->setCellValue('H'.$p, $convert_soles)
	    					     ->setCellValue('I'.$p, 'IMPORTADA');
		        }

	    		$p = $p + 1;
	    		$i = $i + 1;
	    	}
	    }
	    /* ---------------------------------------------------------------------- */
	    /* Formatos */
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    /* Centrar contenido */
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($styleArray);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($styleArray);
	    /* border */
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);

	    $objWorkSheet->setCellValue('A'.$p, "")
		    		 ->setCellValue('B'.$p, "")
		    		 ->setCellValue('C'.$p, "")
		    		 ->setCellValue('D'.$p, "")
		    		 ->setCellValue('E'.$p, "")
		    		 ->setCellValue('F'.$p, "T. EN SOLES")
		    		 ->setCellValue('G'.$p, $suma_soles); // colocar lo siguiente me da un error: ->setCellValue('G'.$p, "S/. ".$suma_soles); al insertar el icono de soles, convierte todo los valores en texto y no lo puedo pasar a numerico
		$p = $p + 1;
		/* ---------------------------------------------------------------------- */
		/* formato */
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($styleArray);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($styleArray);
	    /* border */
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
	    $objWorkSheet->setCellValue('A'.$p, "")
		    		 ->setCellValue('B'.$p, "")
		    		 ->setCellValue('C'.$p, "")
		    		 ->setCellValue('D'.$p, "")
		    		 ->setCellValue('E'.$p, "")
		    		 ->setCellValue('F'.$p, "T. EN DOLARES")
		    		 ->setCellValue('G'.$p, $suma_dolares);
		$p = $p + 1;
		/* ---------------------------------------------------------------------- */
		/* formato */
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($styleArray);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($styleArray);
	    /* border */
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
	    $objWorkSheet->setCellValue('A'.$p, "")
		    		 ->setCellValue('B'.$p, "")
		    		 ->setCellValue('C'.$p, "")
		    		 ->setCellValue('D'.$p, "")
		    		 ->setCellValue('E'.$p, "")
		    		 ->setCellValue('F'.$p, "T. EN EUROS")
		    		 ->setCellValue('G'.$p, $suma_euro);
		$p = $p + 1;
		/* ---------------------------------------------------------------------- */
		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($styleArray);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($styleArray);
	    /* border */
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
	    /* formato */
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    $objWorkSheet->setCellValue('A'.$p, "")
		    		 ->setCellValue('B'.$p, "")
		    		 ->setCellValue('C'.$p, "")
		    		 ->setCellValue('D'.$p, "")
		    		 ->setCellValue('E'.$p, "")
		    		 ->setCellValue('F'.$p, "T. EN FRANCOS")
		    		 ->setCellValue('G'.$p, $suma_franco);
		$p = $p + 1;
		/* ---------------------------------------------------------------------- */
		/* formato */
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($styleArray);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($styleArray);
	    /* border */
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);

	    $objWorkSheet->setCellValue('A'.$p, "")
		    		 ->setCellValue('B'.$p, "")
		    		 ->setCellValue('C'.$p, "")
		    		 ->setCellValue('D'.$p, "")
		    		 ->setCellValue('E'.$p, "")
		    		 ->setCellValue('F'.$p, "SUMA TOTAL SOLES")
		    		 ->setCellValue('G'.$p, $suma_total_soles);
		/* ---------------------------------------------------------------------- */
	    /* Rename sheet */
	    $objWorkSheet->setTitle("Reporte de Facturas");
		//->setCellValueExplicit('G'.$p, $data->total,PHPExcel_Cell_DataType::TYPE_STRING);
	    $objPHPExcel->setActiveSheetIndex(0);

		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Reporte_De_Facturas.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function al_exportar_cierre_excel(){
		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	    // Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
		$objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);

		/* propiedades de la celda */
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);

		//Write cells
	    $objWorkSheet->setCellValue('A1', 'ITEM')
	    			 ->setCellValue('B1', 'FECHA DE CIERRE')
	    			 ->setCellValue('C1', 'MES')
	            	 ->setCellValue('D1', 'MONTO DE CIERRE STA. ANITA')
	            	 ->setCellValue('E1', 'MONTO DE CIERRE STA. CLARA')
	            	 ->setCellValue('F1', 'MONTO DE CIERRE GENERAL');

	    /* Traer informacion de la BD */
	    $movimientos_cierre = $this->model_comercial->get_cierre_almacen();
	    $existe = count($movimientos_cierre);
	    $sumatoria_totales = 0;
	    $p = 2; // contador de filas del excel
	    $i = 1; // Este calor es el contador de cuantos registros existen
	    if($existe > 0){
	    	foreach ($movimientos_cierre as $data) {
	    		// $no_producto = htmlentities($data->no_producto, ENT_QUOTES,'UTF-8');
	    		/* Formatos */
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		/* Centrar contenido */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);

	    		/* border */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);

	    		/* Formateando la Fecha */
		        $elementos = explode("-", $data->fecha_cierre);
		        $anio = $elementos[0];
		        $mes = $elementos[1];
		        $dia = $elementos[2];

		        if($mes == "12"){
		        	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($styleArray);
		        	$concat =  "A{$p}:F{$p}";
		        	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($concat);
				    $objWorkSheet->setCellValue('A'.$p, $anio)
					    		 ->setCellValue('B'.$p, "")
					    		 ->setCellValue('C'.$p, "")
					    		 ->setCellValue('D'.$p, "")
					    		 ->setCellValue('E'.$p, "")
					    		 ->setCellValue('F'.$p, $anio);
		        }
		        $p = $p + 1;
	    		$i = $i + 1;

	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		/* Centrar contenido */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);

	    		/* border */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);

	    		$objWorkSheet->setCellValue('A'.$p, str_pad($i, 4, 0, STR_PAD_LEFT))
	    					 ->setCellValue('B'.$p, $data->fecha_cierre)
	    					 ->setCellValue('C'.$p, $data->nombre_mes)
	    					 ->setCellValue('D'.$p, $data->monto_cierre_sta_anita)
	    					 ->setCellValue('E'.$p, $data->monto_cierre_sta_clara)
	    					 ->setCellValue('F'.$p, $data->monto_cierre);
	    		if($mes == "01"){
	    			$p = $p + 1;
	    		}
	    	}
	    }
	    /* Rename sheet */
	    $objWorkSheet->setTitle("Cierre_Almacen");
		//->setCellValueExplicit('G'.$p, $data->total,PHPExcel_Cell_DataType::TYPE_STRING);
	    $objPHPExcel->setActiveSheetIndex(0);
		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Cierre_De_Almacen.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function al_exportar_report_salidas(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$f_inicial = $data[0];
		$f_final = $data[1];

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	    // Add new sheet
		$objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
		$objPHPExcel->setActiveSheetIndex(0); // Esta línea y en esta posición hace que los formatos vayan a la primera hoja

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);

		/* propiedades de la celda */
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray);
		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(55);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);

		//Write cells
	    $objWorkSheet->setCellValue('A1', 'ITEM')
	    			 ->setCellValue('B1', 'FECHA DE REGISTRO')
	    			 ->setCellValue('C1', 'SERIE')
	            	 ->setCellValue('D1', 'NÚMERO')
	            	 ->setCellValue('E1', 'CATEGORÍA')
	            	 ->setCellValue('F1', 'ÁREA')
	            	 ->setCellValue('G1', 'CÓDIGO PRODUCTO')
	            	 ->setCellValue('H1', 'PRODUCTO')
	            	 ->setCellValue('I1', 'UNID. MEDIDA')
	            	 ->setCellValue('J1', 'CANTIDAD SALIDA')
	            	 ->setCellValue('K1', 'VALORIZADO S/.')
	            	 ->setCellValue('L1', 'SOLICITANTE');

	    /* Traer informacion de la BD */
	    $movimientos_salida = $this->model_comercial->traer_movimientos_salidas_facturas($f_inicial,$f_final);
	    $existe = count($movimientos_salida);
	    $sumatoria_totales = 0;
	    $p = 2; // contador de filas del excel
	    $i = 1; // Este calor es el contador de cuantos registros existen
	    if($existe > 0){
	    	foreach ($movimientos_salida as $data) {
	    		/* $no_producto = htmlentities($data->no_producto, ENT_QUOTES,'UTF-8'); */
	    		/* Formatos */
	    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    		/* Centrar contenido */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
	    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style);

	    		/* border */
	    		$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
	    		$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);

	    		$objWorkSheet->setCellValue('A'.$p, $i)
	    					 ->setCellValue('B'.$p, $data->fecha)
	    					 ->setCellValue('C'.$p, "NITS")
	    					 ->setCellValue('D'.$p, str_pad($data->id_salida_producto, 8, 0, STR_PAD_LEFT))
	    					 ->setCellValue('E'.$p, $data->no_categoria)
	    					 ->setCellValue('F'.$p, $data->no_area)
	    					 ->setCellValue('G'.$p, $data->id_producto)
	    					 ->setCellValue('H'.$p, $data->no_producto)
	    					 ->setCellValue('I'.$p, $data->nom_uni_med)
	    					 ->setCellValue('J'.$p, $data->cantidad_salida)
	    					 ->setCellValue('K'.$p, $data->cantidad_salida*$data->p_u_salida)
	    					 ->setCellValue('L'.$p, $data->solicitante);
	    		$p = $p + 1;
	    		$i = $i + 1;
	    		$sumatoria_totales = $sumatoria_totales + ($data->cantidad_salida*$data->p_u_salida);
	    	}
	    }
	    /* ---------------------------------------------------------------------- */
	    /* Formatos */
	    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	    /* Centrar contenido */
	    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style);
	    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($styleArray);
	    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($styleArray);
	    /* border */
	    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
	    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);

	    $objWorkSheet->setCellValue('A'.$p, "")
		    		 ->setCellValue('B'.$p, "")
		    		 ->setCellValue('C'.$p, "")
		    		 ->setCellValue('D'.$p, "")
		    		 ->setCellValue('E'.$p, "")
		    		 ->setCellValue('F'.$p, "")
		    		 ->setCellValue('G'.$p, "")
		    		 ->setCellValue('H'.$p, "")
		    		 ->setCellValue('I'.$p, "")
		    		 ->setCellValue('J'.$p, "TOTALES S/.")
		    		 ->setCellValue('K'.$p, $sumatoria_totales)
		    		 ->setCellValue('L'.$p, ""); // colocar lo siguiente me da un error: ->setCellValue('G'.$p, "S/. ".$suma_soles); al insertar el icono de soles, convierte todo los valores en texto y no lo puedo pasar a numerico
		/* ---------------------------------------------------------------------- */
	    /* Rename sheet */
	    $objWorkSheet->setTitle("Reporte de Salidas");
		//->setCellValueExplicit('G'.$p, $data->total,PHPExcel_Cell_DataType::TYPE_STRING);
	    $objPHPExcel->setActiveSheetIndex(0);

		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Reporte_De_Salidas.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		echo 'ok';
	}
	
	public function al_exportar_kardex_producto_excel_general(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$f_inicial = $data[0];
		$f_final = $data[1];
		$indice = $data[2];

		(array)$arr = str_split($f_final, 4);
		$anio = $arr[0];

		/* Formato para la fecha inicial */
        $elementos = explode("-", $f_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        $array = array($dia, $mes, $anio);
        $f_inicial = implode("-", $array);
        /* Fin */

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		/* Here your first sheet */
	    $sheet = $objPHPExcel->getActiveSheet();

	    /* Style - Bordes */
	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $style_2 = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        )
	    );

	    $styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);
	    // Traer informacion de la BD
	    $nombre_productos_salidas = $this->model_comercial->traer_nombres_kardex($indice);
	    // Recorro con todos los nombres seleccionados que tienen una salida/ingreso en el kardex
	    // Tambien debo considerar los que no han tenido registros en la tabla kardex pero si debe aparece SI o vacio
	    $i = 0;
        foreach ($nombre_productos_salidas as $reg) {
        	$nombre_producto = $reg->no_producto;
        	$id_producto = $reg->id_producto;
        	$id_unidad_medida = $reg->id_unidad_medida;
        	$id_detalle_producto = $reg->id_detalle_producto;
        	$id_pro = $reg->id_pro;
        	// Traer sólo productos que tengan registros en el periodo seleccionado
        	$produtos_con_kardex = $this->model_comercial->traer_producto_con_kardex($id_detalle_producto,$f_inicial,$f_final);
        	if( count($produtos_con_kardex) > 0 ){
        		// Add new sheet
			    $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
			    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('A1:D1');
			    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('A12:D12');
			    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('E12:G12');
			    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('H12:J12');
			    $objPHPExcel->setActiveSheetIndex($i)->mergeCells('K12:M12');

			    $objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($borders);
				$objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($borders);
				$objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($borders);
				$objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($borders);
				$objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($borders);

				$objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($style);
				$objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($style);
				$objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($style);
				$objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($style);
				$objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($style);

				$objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E12:G12')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H12:J12')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('K12:M12')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
				//Write cells
			    $objWorkSheet->setCellValue('A1', 'INVENTARIO PERMANENTE VALORIZADO')
			            	 ->setCellValue('A2', 'PERIODO: '.$anio)
			            	 ->setCellValue('A3', 'RUC: 20101717098')
			            	 ->setCellValue('A4', 'TEJIDOS JORGITO SRL')
			            	 ->setCellValue('A5', 'CALLE LOS TELARES No 103-105 URB. VULCANO-ATE')
			            	 ->setCellValue('A6', 'CÓDIGO: '.$id_producto)
			            	 ->setCellValue('A7', 'TIPO: 05')
			            	 ->setCellValue('A8', 'DESCRIPCIÓN: '.$nombre_producto)
			            	 ->setCellValue('A9', 'UNIDAD DE MEDIDA: '.$id_unidad_medida)
			            	 ->setCellValue('A10', 'MÉTODO DE EVALUACIÓN: COSTO PROMEDIO');
			    $objWorkSheet->setCellValue('F1', 'FT: FACTURA')
			            	 ->setCellValue('F2', 'GR: GUÍA DE REMISIÓN')
			            	 ->setCellValue('F3', 'BV: BOLETA DE VENTA')
			            	 ->setCellValue('F4', 'NC: NOTA DE CRÉDITO')
			            	 ->setCellValue('F5', 'ND: NOTA DE DÉBITO')
			            	 ->setCellValue('F6', 'OS: ORDEN DE SALIDA')
			            	 ->setCellValue('F7', 'OI: ORDEN DE INGRESO')
			            	 ->setCellValue('F8', 'CU: COSTO UNITARIO (NUEVOS SOLES)')
			            	 ->setCellValue('F9', 'CT: COSTO TOTAL (NUEVOS SOLES)')
			            	 ->setCellValue('F10', 'SI: SALDO INICIAL');
			    $objWorkSheet->setCellValue('A12', 'DOCUMENTO DE MOVIMIENTO')
			    			 ->setCellValue('E12', 'ENTRADAS')
			    			 ->setCellValue('H12', 'SALIDAS')
			    			 ->setCellValue('K12', 'SALDO FINAL');
			    $objWorkSheet->setCellValue('A13', 'FECHA')
			    			 ->setCellValue('B13', 'TIPO')
			    			 ->setCellValue('C13', 'SERIE')
			    			 ->setCellValue('D13', 'NÚMERO')
			    			 ->setCellValue('E13', 'CANTIDAD')
			    			 ->setCellValue('F13', 'CU')
			    			 ->setCellValue('G13', 'CT')
			    			 ->setCellValue('H13', 'CANTIDAD')
			    			 ->setCellValue('I13', 'CU')
			    			 ->setCellValue('J13', 'CT')
			    			 ->setCellValue('K13', 'CANTIDAD')
			    			 ->setCellValue('L13', 'CU')
			    			 ->setCellValue('M13', 'CT');
			    // Formato para la fila 14
		    	$objPHPExcel->getActiveSheet()->getStyle('A14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('B14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('A14')->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('B14')->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('F14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('G14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('H14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('I14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('J14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('K14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('L14')->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('M14')->applyFromArray($borders);

		    	/* Traer saldos iniciales de la BD */
		    	$saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($f_inicial,$id_pro);

		    	/* varianles para las sumatorias */
		    	$sumatoria_cantidad_entradas = 0;
		    	$sumatoria_parciales_entradas = 0;

		    	$sumatoria_cantidad_salidas = 0;
				$sumatoria_parciales_salidas = 0;

		    	$sumatoria_cantidad_saldos = 0;
				$sumatoria_parciales_saldos = 0;

				$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('F14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('G14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('H14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('I14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('J14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('K14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('L14')->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('M14')->applyFromArray($style_2);

			    $objPHPExcel->getActiveSheet()->getStyle('E14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('F14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('G14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('H14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('I14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('J14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('K14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('L14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('M14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			    if( count($saldos_iniciales) > 0 ){
		    		foreach ($saldos_iniciales as $result) {
		    			$total_saldos_iniciales = $result->stock_inicial + $result->stock_inicial_sta_clara;
		    			/* Formato de Fecha */
	                    $elementos = explode("-", $result->fecha_cierre);
	                    $anio = $elementos[0];
	                    $mes = $elementos[1];
	                    $dia = $elementos[2];
	                    $array = array($dia, $mes, $anio);
	                    $fecha_formateada = implode("-", $array);
	                    /* Fin */
			    		$objWorkSheet->setCellValue('A14', $fecha_formateada)
				    			     ->setCellValue('B14', " ")
				    			     ->setCellValue('C14', "SI")
				    			     ->setCellValue('D14', " ")
				    			     ->setCellValue('E14', $total_saldos_iniciales)
				    			     ->setCellValue('F14', $result->precio_uni_inicial)
				    			     ->setCellValue('G14', $total_saldos_iniciales*$result->precio_uni_inicial)
				    			     ->setCellValueExplicit('H14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('I14', $result->precio_uni_inicial)
				    			     ->setCellValueExplicit('J14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('K14', $total_saldos_iniciales)
				    			     ->setCellValue('L14', $result->precio_uni_inicial)
				    			     ->setCellValue('M14', $total_saldos_iniciales*$result->precio_uni_inicial);
					    /* ENTRADAS */
						$sumatoria_cantidad_entradas = $sumatoria_cantidad_entradas + $total_saldos_iniciales;
						$sumatoria_parciales_entradas = $sumatoria_parciales_entradas + ($total_saldos_iniciales * $result->precio_uni_inicial);
						/* SALDOS */
						$sumatoria_cantidad_saldos = $sumatoria_cantidad_saldos + $total_saldos_iniciales;
						$sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($total_saldos_iniciales * $result->precio_uni_inicial);
						// Nuevo - Dejar el saldo inicial para los registros posteriores
	                    $stock_inicial_kardex = $total_saldos_iniciales;
	                    $precio_unitario_inicial_kardex = $result->precio_uni_inicial;
			    	}
		    	}else{
		    		$objWorkSheet->setCellValueExplicit('A14', $f_inicial)
			    			     ->setCellValueExplicit('B14', " ")
			    			     ->setCellValueExplicit('C14', "SI")
			    			     ->setCellValueExplicit('D14', " ")
			    			     ->setCellValueExplicit('E14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('F14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('G14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('H14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('I14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('J14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('K14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('L14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('M14', "0.00",PHPExcel_Cell_DataType::TYPE_STRING);
			    	// Nuevo - Dejar el saldo inicial para los registros posteriores
	                $stock_inicial_kardex = 0;
	                $precio_unitario_inicial_kardex = 0;
		    	}

		    	/* Recorrido del detalle del kardex general por producto */
			    $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$f_inicial,$f_final);
			    $y = 0;
			    $contador_kardex = 0;
			    if( count($detalle_movimientos_kardex) > 0 ){
				    foreach ($detalle_movimientos_kardex as $data) {
				    	$p = 15;
				    	$p = $p + $y;
				    	/* Centrar contenido */
				    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('A'.$p)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('B'.$p)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('C'.$p)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);

				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style_2);

				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);
				    	/* formato de variables */
				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

				    	// Formato de Fecha
	                    $elementos = explode("-", $data->fecha_registro);
	                    $anio = $elementos[0];
	                    $mes = $elementos[1];
	                    $dia = $elementos[2];
	                    $array = array($dia, $mes, $anio);
	                    $fecha_formateada_2 = implode("-", $array);
	                    // Fin de formato

				    	if($data->descripcion == "ENTRADA"){
				    		if($contador_kardex == 0){
	                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
	                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
	                            $contador_kardex++;
	                        }else{
	                            $stock_antes_actualizar = $stock_saldo_final;
	                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
	                            if(($data->cantidad_ingreso + $stock_antes_actualizar) == 0){
	                            	var_dump(" ".$id_detalle_producto);
	                            }
	                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_saldo_final * $stock_antes_actualizar))/($data->cantidad_ingreso + $stock_antes_actualizar);
	                        }
				    		$objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
				    					 ->setCellValue('B'.$p, "FT")
				    					 ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
			    					 	 ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('E'.$p, $data->cantidad_ingreso)
				    					 ->setCellValue('F'.$p, $data->precio_unitario_actual)
				    					 ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('I'.$p, $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('K'.$p, $stock_saldo_final)
				    					 ->setCellValue('L'.$p, $precio_unitario_saldo_final)
				    					 ->setCellValue('M'.$p, $stock_saldo_final*$precio_unitario_saldo_final);
				    	}else if($data->descripcion == "SALIDA"){
				    		if($contador_kardex == 0){
	                            $stock_saldo_final = $stock_inicial_kardex - $data->cantidad_salida;
	                            $precio_unitario_saldo_final = $precio_unitario_inicial_kardex;
	                            $contador_kardex++;
	                        }else{
	                            $stock_saldo_final = $stock_saldo_final - $data->cantidad_salida;
	                            $precio_unitario_saldo_final = $precio_unitario_saldo_final;
	                        }
				    		$objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
				    					 ->setCellValue('B'.$p, "OS")
				    					 ->setCellValue('C'.$p, "NIG")
				    					 ->setCellValueExplicit('D'.$p, str_pad($data->id_kardex_producto, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('E'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('F'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('G'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('H'.$p, $data->cantidad_salida)
				    					 ->setCellValue('I'.$p, $precio_unitario_saldo_final)
				    					 ->setCellValue('J'.$p, $data->cantidad_salida*$precio_unitario_saldo_final)
				    					 ->setCellValue('K'.$p, $stock_saldo_final)
				    					 ->setCellValue('L'.$p, $precio_unitario_saldo_final)
				    					 ->setCellValue('M'.$p, $stock_saldo_final*$precio_unitario_saldo_final);
				    	}else if($data->descripcion == "ORDEN INGRESO"){
				    		if($contador_kardex == 0){
	                            $stock_saldo_final = $stock_inicial_kardex + $data->cantidad_ingreso;
	                            $precio_unitario_saldo_final = (($data->cantidad_ingreso*$data->precio_unitario_actual) + ($precio_unitario_inicial_kardex * $stock_inicial_kardex))/($data->cantidad_ingreso + $stock_inicial_kardex);
	                            $contador_kardex++;
	                        }else{
	                            $stock_saldo_final = $stock_saldo_final + $data->cantidad_ingreso;
	                            $precio_unitario_saldo_final = $precio_unitario_saldo_final;
	                        }
				    		$objWorkSheet->setCellValue('A'.$p, $fecha_formateada_2)
				    					 ->setCellValue('B'.$p, "OI")
				    					 ->setCellValueExplicit('C'.$p, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('D'.$p, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('E'.$p, $data->cantidad_ingreso)
				    					 ->setCellValue('F'.$p, $data->precio_unitario_actual)
				    					 ->setCellValue('G'.$p, $data->cantidad_ingreso * $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('H'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('I'.$p, $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('J'.$p, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('K'.$p, $stock_saldo_final)
				    					 ->setCellValue('L'.$p, $precio_unitario_saldo_final)
				    					 ->setCellValue('M'.$p, $stock_saldo_final*$precio_unitario_saldo_final);
				    	}		    	
				    	/* ENTRADAS */
						$sumatoria_cantidad_entradas = $sumatoria_cantidad_entradas + $data->cantidad_ingreso;
						$sumatoria_parciales_entradas = $sumatoria_parciales_entradas + ($data->cantidad_ingreso * $data->precio_unitario_actual);
						/* SALIDAS */
						$sumatoria_cantidad_salidas = $sumatoria_cantidad_salidas + $data->cantidad_salida;
						$sumatoria_parciales_salidas = $sumatoria_parciales_salidas + ($data->cantidad_salida * $precio_unitario_saldo_final);
						/* SALDOS */
                    	$sumatoria_cantidad_saldos = $sumatoria_cantidad_saldos + $stock_saldo_final;
                    	// Sumatoria de saldos parciales caso general
                    	$sumatoria_parciales_saldos = $sumatoria_parciales_saldos + ($stock_saldo_final * $precio_unitario_saldo_final);
				    	$y = $y + 1;
					}
				}

				$p = 15 + $y;
				$objWorkSheet->setCellValue('A'.$p, "")
			    		     ->setCellValue('B'.$p, "")
			    		     ->setCellValue('C'.$p, "")
			    		     ->setCellValue('D'.$p, "TOTALES")
			    		     ->setCellValue('E'.$p, $sumatoria_cantidad_entradas)
			    		     ->setCellValue('F'.$p, "")
			    		     ->setCellValue('G'.$p, $sumatoria_parciales_entradas)
			    		     ->setCellValue('H'.$p, $sumatoria_cantidad_salidas)
			    		     ->setCellValue('I'.$p, "")
			    		     ->setCellValue('J'.$p, $sumatoria_parciales_salidas)
			    		     ->setCellValue('K'.$p, $sumatoria_cantidad_saldos)
			    		     ->setCellValue('L'.$p, "")
			    		     ->setCellValue('M'.$p, $sumatoria_parciales_saldos);

			    /* Centrar contenido */
			    $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('D'.$p)->applyFromArray($style);
			    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($borders);
			    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($borders);

			    /* Dar formato numericos a las celdas */
			    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			    /* Alinear el valor de la celda a la derecha */
			    $objPHPExcel->getActiveSheet()->getStyle('E'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('G'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('H'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('I'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('J'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('K'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('L'.$p)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('M'.$p)->applyFromArray($style_2);

			    /* Rename sheet */
			    $objWorkSheet->setTitle("$nombre_producto");
			    $i++;
        	}
        }

	    $objPHPExcel->setActiveSheetIndex(0);

		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Kardex_General_indice_$indice.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function al_exportar_kardex_sunat_excel(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$f_inicial = $data[0];
		$f_final = $data[1];

		(array)$arr = str_split($f_final, 4);
		$anio = $arr[0];

		/* Formato para la fecha inicial */
        $elementos = explode("-", $f_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        $array = array($dia, $mes, $anio);
        $f_inicial = implode("-", $array);
        /* Fin */

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		/* Here your first sheet */
	    $sheet = $objPHPExcel->getActiveSheet();

	    /* Style - Bordes */
	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $style_2 = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        )
	    );

	    $styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);
		/* Add new sheet */
	    $objWorkSheet = $objPHPExcel->createSheet(0); /* Setting index when creating */
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:G1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:J1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:M1');

	    $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('H1:J1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('K1:M1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($borders);

		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('H1:J1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('K1:M1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($style);

		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H1:J1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K1:M1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);

		/* Cabecera SUNAT */
	    $objWorkSheet->setCellValue('A1', 'DOCUMENTO DE MOVIMIENTO')
	    			 ->setCellValue('E1', 'ENTRADAS')
	    			 ->setCellValue('H1', 'SALIDAS')
	    			 ->setCellValue('K1', 'SALDO FINAL');
	    $objWorkSheet->setCellValue('A2', 'FECHA')
	    			 ->setCellValue('B2', 'TIPO')
	    			 ->setCellValue('C2', 'SERIE')
	    			 ->setCellValue('D2', 'NÚMERO')
	    			 ->setCellValue('E2', 'CANTIDAD')
	    			 ->setCellValue('F2', 'CU')
	    			 ->setCellValue('G2', 'CT')
	    			 ->setCellValue('H2', 'CANTIDAD')
	    			 ->setCellValue('I2', 'CU')
	    			 ->setCellValue('J2', 'CT')
	    			 ->setCellValue('K2', 'CANTIDAD')
	    			 ->setCellValue('L2', 'CU')
	    			 ->setCellValue('M2', 'CT')
	    			 ->setCellValue('O2', 'CODGIO')
	    			 ->setCellValue('P2', 'DESCRIPCION')
	    			 ->setCellValue('Q2', 'UNID DE MEDIDA');
	    /* Traer informacion de la BD */
	    $nombre_productos_salidas = $this->model_comercial->traer_nombres_kardex_sunat();
	    /* Recorro con todos los nombres seleccionados que tienen una salida/ingreso en el kardex */
	    /* Tambien debo considerar los que no han tenido registros en la tabla kardex pero si debe aparece SI o vacio */
	    $i = 3;
        foreach ($nombre_productos_salidas as $reg) {

        	$nombre_producto = $reg->no_producto;
        	$id_producto = $reg->id_producto;
        	$id_unidad_medida = $reg->id_unidad_medida;
        	$id_detalle_producto = $reg->id_detalle_producto;
        	$id_pro = $reg->id_pro;

        	/* Traer sólo productos que tengan registros en el periodo seleccionado */
        	$produtos_con_kardex = $this->model_comercial->traer_producto_con_kardex($id_detalle_producto,$f_inicial,$f_final);
        	if( count($produtos_con_kardex) > 0 ){
        		/* Formato para la filas */
		    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($borders);

			    /* Traer saldos iniciales de la BD */
		    	$saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($f_inicial,$id_pro);

				$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($style_2);


			    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		    	if( count($saldos_iniciales) > 0 ){
		    		foreach ($saldos_iniciales as $result) {
		    			/* Formato de Fecha */
	                    $elementos = explode("-", $result->fecha_cierre);
	                    $anio = $elementos[0];
	                    $mes = $elementos[1];
	                    $dia = $elementos[2];
	                    $array = array($dia, $mes, $anio);
	                    $fecha_formateada = implode("-", $array);
	                    /* Fin */
	                    $stock_cierre_total = $result->stock_inicial + $result->stock_inicial_sta_clara;
			    		$objWorkSheet->setCellValue('A'.$i, $fecha_formateada)
				    			     ->setCellValue('B'.$i, " ")
				    			     ->setCellValue('C'.$i, "SI")
				    			     ->setCellValue('D'.$i, " ")
				    			     ->setCellValue('E'.$i, $stock_cierre_total)
				    			     ->setCellValue('F'.$i, $result->precio_uni_inicial)
				    			     ->setCellValue('G'.$i, $stock_cierre_total*$result->precio_uni_inicial)
				    			     ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('I'.$i, $result->precio_uni_inicial)
				    			     ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('K'.$i, $stock_cierre_total)
				    			     ->setCellValue('L'.$i, $result->precio_uni_inicial)
				    			     ->setCellValue('M'.$i, $stock_cierre_total*$result->precio_uni_inicial)
				    			     ->setCellValue('O'.$i, $id_producto)
				    			     ->setCellValue('P'.$i, $nombre_producto)
				    			     ->setCellValue('Q'.$i, $id_unidad_medida);
				    	$i++;
			    	}
		    	}else{
		    		$objWorkSheet->setCellValueExplicit('A'.$i, $f_inicial)
			    			     ->setCellValueExplicit('B'.$i, " ")
			    			     ->setCellValueExplicit('C'.$i, "SI")
			    			     ->setCellValueExplicit('D'.$i, " ")
			    			     ->setCellValueExplicit('E'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('F'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('G'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('I'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('K'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('L'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('M'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('O'.$i, $id_producto)
			    			     ->setCellValueExplicit('P'.$i, $nombre_producto)
			    			     ->setCellValueExplicit('Q'.$i, $id_unidad_medida);
			    	$i++;
		    	}

			    /* Recorrido del detalle del kardex general por producto */
			    $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$f_inicial,$f_final);
			    if( count($detalle_movimientos_kardex) > 0 ){
				    foreach ($detalle_movimientos_kardex as $data) {
				    	/* Centrar contenido */
				    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($borders);

				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($style_2);

				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($borders);
				    	/* formato de variables */
				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

				    	/* Formato de Fecha */
	                    $elementos = explode("-", $data->fecha_registro);
	                    $anio = $elementos[0];
	                    $mes = $elementos[1];
	                    $dia = $elementos[2];
	                    $array = array($dia, $mes, $anio);
	                    $fecha_formateada_2 = implode("-", $array);
	                    /* fin de formato */
				    	
				    	/* fin de formato */
				    	if($data->descripcion == "ENTRADA"){
				    		$objWorkSheet->setCellValue('A'.$i, $fecha_formateada_2)
				    					 ->setCellValue('B'.$i, "FT")
				    					 ->setCellValueExplicit('C'.$i, $data->serie_comprobante,PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('D'.$i, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('E'.$i, $data->cantidad_ingreso)
				    					 ->setCellValue('F'.$i, $data->precio_unitario_actual)
				    					 ->setCellValue('G'.$i, $data->cantidad_ingreso * $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('I'.$i, $data->precio_unitario_actual_promedio)
				    					 ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('K'.$i, $data->stock_actual)
				    					 ->setCellValue('L'.$i, $data->precio_unitario_actual_promedio)
				    					 ->setCellValue('M'.$i, $data->stock_actual*$data->precio_unitario_actual_promedio)
				    					 ->setCellValue('O'.$i, $data->id_producto)
				    					 ->setCellValue('P'.$i, $data->no_producto)
				    					 ->setCellValue('Q'.$i, $data->id_unidad_medida);
				    		$i++;
				    	}else if($data->descripcion == "SALIDA"){
				    		$objWorkSheet->setCellValue('A'.$i, $fecha_formateada_2)
				    					 ->setCellValue('B'.$i, "OS")
				    					 ->setCellValue('C'.$i, "NIG")
				    					 ->setCellValueExplicit('D'.$i, str_pad($data->id_kardex_producto, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('E'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('F'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('G'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('H'.$i, $data->cantidad_salida)
				    					 ->setCellValue('I'.$i, $data->precio_unitario_anterior)
				    					 ->setCellValue('J'.$i, $data->cantidad_salida*$data->precio_unitario_anterior)
				    					 ->setCellValue('K'.$i, $data->stock_actual)
				    					 ->setCellValue('L'.$i, $data->precio_unitario_actual)
				    					 ->setCellValue('M'.$i, $data->stock_actual*$data->precio_unitario_actual)
				    					 ->setCellValue('O'.$i, $data->id_producto)
				    					 ->setCellValue('P'.$i, $data->no_producto)
				    					 ->setCellValue('Q'.$i, $data->id_unidad_medida);
				    		$i++;
				    	}
					}
				}
			    /* Rename sheet */
			    $objWorkSheet->setTitle("Reporte SUNAT I");
        	}
        	
		    
        }

	    $objPHPExcel->setActiveSheetIndex(0);

		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Kardex_General.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function validar_existencia_saldo_inicial(){
		$id_producto = $this->security->xss_clean($this->input->post("id_producto"));
		$fechainicial = $this->security->xss_clean($this->input->post("fechainicial"));
		$datos = $this->model_comercial->report_saldo_inicial($id_producto,$fechainicial);
		$existe = count($datos);
          if($existe <= 0){
            echo '1';
        }
	}

	public function eliminar_salidas_2014(){
		$result = $this->model_comercial->eliminar_salidas_2014();
        // Verificamos que existan resultados
        if(!$result){
            // Sí no se encotnraron datos.
            echo '<span style="color:red"><b>ERROR: </b>ERROR</span>';
        }else{
        	// Registramos la sesion del usuario
        	echo '1';
        }
	}

	public function actualizar_saldos_iniciales(){
		$result = $this->model_comercial->actualizar_saldos_iniciales();
        // Verificamos que existan resultados
        if(!$result){
            // Sí no se encotnraron datos.
            echo '<span style="color:red"><b>ERROR: </b>ERROR</span>';
        }else{
        	// Registramos la sesion del usuario
        	echo '1';
        }
	}

	public function al_exportar_kardex_sunat_excel_formato_2016(){
		$data = $this->security->xss_clean($this->uri->segment(3));
		$data = json_decode($data, true);
		$f_inicial = $data[0];
		$f_final = $data[1];

		(array)$arr = str_split($f_final, 4);
		$anio = $arr[0];

		/* Formato para la fecha inicial */
        $elementos = explode("-", $f_inicial);
        $anio = $elementos[0];
        $mes = $elementos[1];
        $dia = $elementos[2];
        $array = array($dia, $mes, $anio);
        $f_inicial = implode("-", $array);
        /* Fin */

		$this->load->library('pHPExcel');
		/* variables de PHPExcel */
		$objPHPExcel = new PHPExcel();
		$nombre_archivo = "phpExcel";

		/* propiedades de la celda */
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		/* Here your first sheet */
	    $sheet = $objPHPExcel->getActiveSheet();

	    /* Style - Bordes */
	    $borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);

		$style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        )
	    );

	    $style_2 = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        )
	    );

	    $style_3 = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	        )
	    );

	    $styleArray = array(
		    'font' => array(
		        'bold' => true
		    )
		);
		/* Add new sheet */
	    $objWorkSheet = $objPHPExcel->createSheet(0); /* Setting index when creating */
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:G1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:J1');
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:M1');

	    $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('H1:J1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('K1:M1')->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle('A2:AN2')->applyFromArray($borders);

		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('H1:J1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('K1:M1')->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle('A2:AN2')->applyFromArray($style);

		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H1:J1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K1:M1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A2:AN2')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);

		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(20);

		/* Cabecera SUNAT */
	    $objWorkSheet->setCellValue('A1', 'DOCUMENTO DE MOVIMIENTO')
	    			 ->setCellValue('E1', 'ENTRADAS')
	    			 ->setCellValue('H1', 'SALIDAS')
	    			 ->setCellValue('K1', 'SALDO FINAL');
	    $objWorkSheet->setCellValue('A2', 'FECHA')
	    			 ->setCellValue('B2', 'TIPO')
	    			 ->setCellValue('C2', 'SERIE')
	    			 ->setCellValue('D2', 'NÚMERO')
	    			 ->setCellValue('E2', 'CANTIDAD')
	    			 ->setCellValue('F2', 'CU')
	    			 ->setCellValue('G2', 'CT')
	    			 ->setCellValue('H2', 'CANTIDAD')
	    			 ->setCellValue('I2', 'CU')
	    			 ->setCellValue('J2', 'CT')
	    			 ->setCellValue('K2', 'CANTIDAD')
	    			 ->setCellValue('L2', 'CU')
	    			 ->setCellValue('M2', 'CT')
	    			 ->setCellValue('O2', 'KPERIODO')
	    			 ->setCellValue('P2', 'KANEXO')
	    			 ->setCellValue('Q2', 'KCATALOGO')
	    			 ->setCellValue('R2', 'KTIPEXIST')
	    			 ->setCellValue('S2', 'KCODEXIST')
	    			 ->setCellValue('T2', 'KFECDOC')
	    			 ->setCellValue('U2', 'KTIPODOC')
	    			 ->setCellValue('V2', 'KSERDOC')
	    			 ->setCellValue('W2', 'KNUMDOC')
	    			 ->setCellValue('X2', 'KTIPOPE')
	    			 ->setCellValue('Y2', 'KDESEXIST')
	    			 ->setCellValue('Z2', 'KUNIMED')
	    			 ->setCellValue('AA2', 'KMETVAL')
	    			 ->setCellValue('AB2', 'KUNIING')
	    			 ->setCellValue('AC2', 'KCOSING')
	    			 ->setCellValue('AD2', 'KTOTING')
	    			 ->setCellValue('AE2', 'KUNIRET')
	    			 ->setCellValue('AF2', 'KCOSRET')
	    			 ->setCellValue('AG2', 'KTOTRET')
	    			 ->setCellValue('AH2', 'KSALFIN')
	    			 ->setCellValue('AI2', 'KCOSFIN')
	    			 ->setCellValue('AJ2', 'KTOTFIN')

	    			 ->setCellValue('AK2', 'KESTOPE')
	    			 ->setCellValue('AL2', 'KINTDIAMAY')
	    			 ->setCellValue('AM2', 'KINTVTACOM')
	    			 ->setCellValue('AN2', 'KINTREG');
	    // Traer informacion de la BD
	    $nombre_productos_salidas = $this->model_comercial->traer_nombres_kardex_sunat();
	    // Recorro con todos los nombres seleccionados que tienen una salida/ingreso en el kardex
	    // Tambien debo considerar los que no han tenido registros en la tabla kardex pero si debe aparece SI o vacio
	    $i = 3;
        foreach ($nombre_productos_salidas as $reg) {

        	$nombre_producto = $reg->no_producto;
        	$id_producto = $reg->id_producto;
        	$id_unidad_medida = $reg->id_unidad_medida;
        	$id_detalle_producto = $reg->id_detalle_producto;
        	$id_pro = $reg->id_pro;
        	$id_categoria = $reg->id_categoria;

        	// Asignar codigo de existencia
        	if($id_categoria == 1){
        		$ktipexist = '07';
        	}else if($id_categoria == 2){
        		$ktipexist = '06';
        	}else{
        		$ktipexist = '99';
        	}

        	// Asignar codigo de unidad de medida
        	if($id_unidad_medida == 1){
        		$kunimed = 'KGM';
        	}else if($id_unidad_medida == 7){
        		$kunimed = 'C62';
        	}else if($id_unidad_medida == 8){
        		$kunimed = 'LTR';
        	}else if($id_unidad_medida == 9){
        		$kunimed = 'GLL';
        	}else if($id_unidad_medida == 12){
        		$kunimed = 'BX';
        	}else if($id_unidad_medida == 13){
        		$kunimed = 'MIL';
        	}else if($id_unidad_medida == 15){
        		$kunimed = 'MTR';
        	}else if($id_unidad_medida == 99){
        		$kunimed = 'D44';
        	}

        	/* Traer sólo productos que tengan registros en el periodo seleccionado */
        	$produtos_con_kardex = $this->model_comercial->traer_producto_con_kardex($id_detalle_producto,$f_inicial,$f_final);
        	if( count($produtos_con_kardex) > 0 ){
        		/* Formato para la filas */
		    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style);
		    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('R'.$i)->applyFromArray($borders);

		    	$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('T'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('V'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('X'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->applyFromArray($borders);

		    	$objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AG'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AH'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AI'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AJ'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AK'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AL'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AM'.$i)->applyFromArray($borders);
		    	$objPHPExcel->getActiveSheet()->getStyle('AN'.$i)->applyFromArray($borders);

			    /* Traer saldos iniciales de la BD */
		    	$saldos_iniciales = $this->model_comercial->traer_saldos_iniciales($f_inicial,$id_pro);

		    	$elementos = explode("-", $f_inicial);
                $anio = $elementos[0];
                $mes = $elementos[1];
                $dia = $elementos[2];
                $kperiodo_si = $dia.$mes.'00';

				$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('R'.$i)->applyFromArray($style_2);

			    $objPHPExcel->getActiveSheet()->getStyle('S'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('T'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('U'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('V'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('X'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->applyFromArray($style_2);

			    $objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AG'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AH'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AI'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AJ'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AK'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AL'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AM'.$i)->applyFromArray($style_2);
			    $objPHPExcel->getActiveSheet()->getStyle('AN'.$i)->applyFromArray($style_2);

			    $objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($style_3);

			    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			    $objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AG'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AH'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AI'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AJ'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    /*
			    $objPHPExcel->getActiveSheet()->getStyle('AK'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AL'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AM'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    $objPHPExcel->getActiveSheet()->getStyle('AN'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			    */

		    	if( count($saldos_iniciales) > 0 ){
		    		foreach ($saldos_iniciales as $result) {
		    			/* Formato de Fecha */
	                    $elementos = explode("-", $result->fecha_cierre);
	                    $anio = $elementos[0];
	                    $mes = $elementos[1];
	                    $dia = $elementos[2];
	                    $array = array($dia, $mes, $anio);
	                    $fecha_formateada = implode("-", $array);
	                    /* Fin */
	                    $stock_cierre_total = $result->stock_inicial + $result->stock_inicial_sta_clara;
			    		$objWorkSheet->setCellValue('A'.$i, $fecha_formateada)
				    			     ->setCellValue('B'.$i, " ")
				    			     ->setCellValue('C'.$i, "SI")
				    			     ->setCellValue('D'.$i, " ")
				    			     ->setCellValue('E'.$i, $stock_cierre_total)
				    			     ->setCellValue('F'.$i, $result->precio_uni_inicial)
				    			     ->setCellValue('G'.$i, $stock_cierre_total*$result->precio_uni_inicial)
				    			     ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('I'.$i, $result->precio_uni_inicial)
				    			     ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('K'.$i, $stock_cierre_total)
				    			     ->setCellValue('L'.$i, $result->precio_uni_inicial)
				    			     ->setCellValue('M'.$i, $stock_cierre_total*$result->precio_uni_inicial)
				    			     ->setCellValue('O'.$i, $kperiodo_si)
				    			     ->setCellValue('P'.$i, "2")
				    			     ->setCellValue('Q'.$i, "9")
				    			     ->setCellValueExplicit('R'.$i, $ktipexist,PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('S'.$i, $id_producto)
				    			     ->setCellValue('T'.$i, $fecha_formateada)
				    			     ->setCellValue('U'.$i, "")
				    			     ->setCellValue('V'.$i, "SI")
				    			     ->setCellValue('W'.$i, "")
				    			     ->setCellValue('X'.$i, "16")
				    			     ->setCellValue('Y'.$i, $nombre_producto)
				    			     ->setCellValue('Z'.$i, $kunimed)
				    			     ->setCellValue('AA'.$i, "1")
				    			     ->setCellValue('AB'.$i, $stock_cierre_total)
				    			     ->setCellValue('AC'.$i, $result->precio_uni_inicial)
				    			     ->setCellValue('AD'.$i, $stock_cierre_total*$result->precio_uni_inicial)
				    			     ->setCellValueExplicit('AE'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('AF'.$i, $result->precio_uni_inicial)
				    			     ->setCellValueExplicit('AG'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
				    			     ->setCellValue('AH'.$i, $stock_cierre_total)
				    			     ->setCellValue('AI'.$i, $result->precio_uni_inicial)
				    			     ->setCellValue('AJ'.$i, $stock_cierre_total*$result->precio_uni_inicial)
				    			     ->setCellValue('AK'.$i, "1")
				    			     ->setCellValue('AL'.$i, "0")
				    			     ->setCellValue('AM'.$i, "0")
				    			     ->setCellValue('AN'.$i, "0");
				    	$i++;
			    	}
		    	}else{
		    		$objWorkSheet->setCellValueExplicit('A'.$i, $f_inicial)
			    			     ->setCellValueExplicit('B'.$i, " ")
			    			     ->setCellValueExplicit('C'.$i, "SI")
			    			     ->setCellValueExplicit('D'.$i, " ")
			    			     ->setCellValueExplicit('E'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('F'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('G'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('I'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('K'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('L'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('M'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('O'.$i, $kperiodo_si,PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('P'.$i, "2",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('Q'.$i, "9",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('R'.$i, $ktipexist,PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('S'.$i, $id_producto,PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValue('T'.$i, $f_inicial)
			    			     ->setCellValue('U'.$i, "")
			    			     ->setCellValue('V'.$i, "SI")
			    			     ->setCellValue('W'.$i, "")
			    			     ->setCellValue('X'.$i, "16")
			    			     ->setCellValue('Y'.$i, $nombre_producto)
			    			     ->setCellValue('Z'.$i, $kunimed)
			    			     ->setCellValueExplicit('AA'.$i, "1")
			    			     ->setCellValueExplicit('AB'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AC'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AD'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AE'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AF'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AG'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AH'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AI'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValueExplicit('AJ'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
			    			     ->setCellValue('AK'.$i, "1")
			    			     ->setCellValue('AL'.$i, "0")
			    			     ->setCellValue('AM'.$i, "0")
			    			     ->setCellValue('AN'.$i, "0");
			    	$i++;
		    	}

			    // Recorrido del detalle del kardex general por producto
			    $detalle_movimientos_kardex = $this->model_comercial->traer_movimientos_kardex($id_detalle_producto,$f_inicial,$f_final);
			    if( count($detalle_movimientos_kardex) > 0 ){
				    foreach ($detalle_movimientos_kardex as $data) {
				    	// Centrar contenido
				    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style);
				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($borders);

				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('R'.$i)->applyFromArray($style_2);

				    	$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('T'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('V'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('X'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($style_2);
				    	$objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->applyFromArray($style_2);

				    	$objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AG'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AH'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AI'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AJ'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AK'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AL'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AM'.$i)->applyFromArray($style_2);
					    $objPHPExcel->getActiveSheet()->getStyle('AN'.$i)->applyFromArray($style_2);

				    	$objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($style_3);

				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('R'.$i)->applyFromArray($borders);

				    	$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('T'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('V'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('X'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->applyFromArray($borders);

				    	$objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AG'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AH'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AI'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AJ'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AK'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AL'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AM'.$i)->applyFromArray($borders);
				    	$objPHPExcel->getActiveSheet()->getStyle('AN'.$i)->applyFromArray($borders);

				    	// formato de variables
				    	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				    	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

				    	$objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AG'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AH'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AI'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AJ'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    /*
					    $objPHPExcel->getActiveSheet()->getStyle('AK'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AL'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AM'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    $objPHPExcel->getActiveSheet()->getStyle('AN'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					    */

				    	// Formato de Fecha
	                    $elementos = explode("-", $data->fecha_registro);
	                    $anio = $elementos[0];
	                    $mes = $elementos[1];
	                    $dia = $elementos[2];
	                    $array = array($dia, $mes, $anio);
	                    $fecha_formateada_2 = implode("-", $array);
	                    // fin de formato
				    	$kperiodo_movimiento = $anio.$mes.'00';
				    	// fin de formato
				    	if($data->descripcion == "ENTRADA"){

				    		// verificar si la entrada es una factura importada
				    		$this->db->select('id_agente');
				            $this->db->where('serie_comprobante',$data->serie_comprobante);
				            $this->db->where('nro_comprobante',$data->num_comprobante);
				            $this->db->where('fecha',$data->fecha_registro);
				            $query = $this->db->get('ingreso_producto');
				            foreach($query->result() as $row){
				                $id_agente = $row->id_agente;
				            }

				            if($id_agente == 2){
					    		$objWorkSheet->setCellValue('A'.$i, $fecha_formateada_2)
					    					 ->setCellValue('B'.$i, "FT")
					    					 ->setCellValueExplicit('C'.$i, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('D'.$i, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('E'.$i, $data->cantidad_ingreso)
					    					 ->setCellValue('F'.$i, $data->precio_unitario_actual)
					    					 ->setCellValue('G'.$i, $data->cantidad_ingreso * $data->precio_unitario_actual)
					    					 ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('I'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('K'.$i, $data->stock_actual)
					    					 ->setCellValue('L'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValue('M'.$i, $data->stock_actual*$data->precio_unitario_actual_promedio)
					    					 ->setCellValue('O'.$i, $kperiodo_movimiento)
					    					 ->setCellValue('P'.$i, "2")
					    					 ->setCellValue('Q'.$i, "9")
					    					 ->setCellValueExplicit('R'.$i, $ktipexist,PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('S'.$i, $id_producto,PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('T'.$i, $fecha_formateada_2)
					    					 ->setCellValueExplicit('U'.$i, "01",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('V'.$i, $data->serie_comprobante,PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('W'.$i, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('X'.$i, "02",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('Y'.$i, $nombre_producto)
					    					 ->setCellValue('Z'.$i, $kunimed)
											 ->setCellValue('AA'.$i, "1")
					    					 ->setCellValue('AB'.$i, $data->cantidad_ingreso)
					    					 ->setCellValue('AC'.$i, $data->precio_unitario_actual)
					    					 ->setCellValue('AD'.$i, $data->cantidad_ingreso * $data->precio_unitario_actual)
					    					 ->setCellValueExplicit('AE'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('AF'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValueExplicit('AG'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('AH'.$i, $data->stock_actual)
					    					 ->setCellValue('AI'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValue('AJ'.$i, $data->stock_actual*$data->precio_unitario_actual_promedio)
					    					 ->setCellValue('AK'.$i, "1")
						    			     ->setCellValue('AL'.$i, "0")
						    			     ->setCellValue('AM'.$i, "0")
						    			     ->setCellValue('AN'.$i, "0");
					    		$i++;
				            }else{
				            	$objWorkSheet->setCellValue('A'.$i, $fecha_formateada_2)
					    					 ->setCellValue('B'.$i, "FT")
					    					 ->setCellValueExplicit('C'.$i, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('D'.$i, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('E'.$i, $data->cantidad_ingreso)
					    					 ->setCellValue('F'.$i, $data->precio_unitario_actual)
					    					 ->setCellValue('G'.$i, $data->cantidad_ingreso * $data->precio_unitario_actual)
					    					 ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('I'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('K'.$i, $data->stock_actual)
					    					 ->setCellValue('L'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValue('M'.$i, $data->stock_actual*$data->precio_unitario_actual_promedio)
					    					 ->setCellValue('O'.$i, $kperiodo_movimiento)
					    					 ->setCellValue('P'.$i, "2")
					    					 ->setCellValue('Q'.$i, "9")
					    					 ->setCellValueExplicit('R'.$i, $ktipexist,PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('S'.$i, $id_producto,PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('T'.$i, $fecha_formateada_2)
					    					 ->setCellValueExplicit('U'.$i, "01",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('V'.$i, $data->serie_comprobante,PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('W'.$i, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValueExplicit('X'.$i, "18",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('Y'.$i, $nombre_producto)
					    					 ->setCellValue('Z'.$i, $kunimed)
											 ->setCellValue('AA'.$i, "1")
					    					 ->setCellValue('AB'.$i, $data->cantidad_ingreso)
					    					 ->setCellValue('AC'.$i, $data->precio_unitario_actual)
					    					 ->setCellValue('AD'.$i, $data->cantidad_ingreso * $data->precio_unitario_actual)
					    					 ->setCellValueExplicit('AE'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('AF'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValueExplicit('AG'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
					    					 ->setCellValue('AH'.$i, $data->stock_actual)
					    					 ->setCellValue('AI'.$i, $data->precio_unitario_actual_promedio)
					    					 ->setCellValue('AJ'.$i, $data->stock_actual*$data->precio_unitario_actual_promedio)
					    					 ->setCellValue('AK'.$i, "1")
						    			     ->setCellValue('AL'.$i, "0")
						    			     ->setCellValue('AM'.$i, "0")
						    			     ->setCellValue('AN'.$i, "0");
					    		$i++;
				            }
				    	}else if($data->descripcion == "SALIDA"){
				    		$objWorkSheet->setCellValue('A'.$i, $fecha_formateada_2)
				    					 ->setCellValue('B'.$i, "OS")
				    					 ->setCellValue('C'.$i, "NIG")
				    					 ->setCellValueExplicit('D'.$i, str_pad($data->id_kardex_producto, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('E'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('F'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('G'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('H'.$i, $data->cantidad_salida)
				    					 ->setCellValue('I'.$i, $data->precio_unitario_anterior)
				    					 ->setCellValue('J'.$i, $data->cantidad_salida*$data->precio_unitario_anterior)
				    					 ->setCellValue('K'.$i, $data->stock_actual)
				    					 ->setCellValue('L'.$i, $data->precio_unitario_actual)
				    					 ->setCellValue('M'.$i, $data->stock_actual*$data->precio_unitario_actual)
				    					 ->setCellValue('O'.$i, $kperiodo_movimiento)
				    					 ->setCellValue('P'.$i, "2")
				    					 ->setCellValue('Q'.$i, "9")
				    					 ->setCellValueExplicit('R'.$i, $ktipexist,PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('S'.$i, $id_producto,PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('T'.$i, $fecha_formateada_2)
				    					 ->setCellValueExplicit('U'.$i, "00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('V'.$i, "NIG")
				    					 ->setCellValueExplicit('W'.$i, str_pad($data->id_kardex_producto, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('X'.$i, "10",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('Y'.$i, $nombre_producto)
				    					 ->setCellValue('Z'.$i, $kunimed)
				    					 ->setCellValue('AA'.$i, "1")
				    					 ->setCellValueExplicit('AB'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('AC'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('AD'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('AE'.$i, $data->cantidad_salida)
				    					 ->setCellValue('AF'.$i, $data->precio_unitario_anterior)
				    					 ->setCellValue('AG'.$i, $data->cantidad_salida*$data->precio_unitario_anterior)
				    					 ->setCellValue('AH'.$i, $data->stock_actual)
				    					 ->setCellValue('AI'.$i, $data->precio_unitario_actual)
				    					 ->setCellValue('AJ'.$i, $data->stock_actual*$data->precio_unitario_actual)
				    					 ->setCellValue('AK'.$i, "1")
					    			     ->setCellValue('AL'.$i, "0")
					    			     ->setCellValue('AM'.$i, "0")
					    			     ->setCellValue('AN'.$i, "0");
				    		$i++;
				    	}else if($data->descripcion == "ORDEN INGRESO"){
				    		$objWorkSheet->setCellValue('A'.$i, $fecha_formateada_2)
				    					 ->setCellValue('B'.$i, "OI")
				    					 ->setCellValueExplicit('C'.$i, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('D'.$i, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('E'.$i, $data->cantidad_ingreso)
				    					 ->setCellValue('F'.$i, $data->precio_unitario_actual)
				    					 ->setCellValue('G'.$i, $data->cantidad_ingreso * $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('H'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('I'.$i, $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('J'.$i, "0.00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('K'.$i, $data->stock_actual)
				    					 ->setCellValue('L'.$i, $data->precio_unitario_actual_promedio)
				    					 ->setCellValue('M'.$i, $data->stock_actual*$data->precio_unitario_actual_promedio)
				    					 ->setCellValue('O'.$i, $kperiodo_movimiento)
				    					 ->setCellValue('P'.$i, "2")
				    					 ->setCellValue('Q'.$i, "9")
				    					 ->setCellValueExplicit('R'.$i, $ktipexist,PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('S'.$i, $id_producto,PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('T'.$i, $fecha_formateada_2)
				    					 ->setCellValueExplicit('U'.$i, "00",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('V'.$i, str_pad($data->serie_comprobante, 3, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('W'.$i, str_pad($data->num_comprobante, 8, 0, STR_PAD_LEFT),PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValueExplicit('X'.$i, "21",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('Y'.$i, $nombre_producto)
				    					 ->setCellValue('Z'.$i, $kunimed)
				    					 ->setCellValue('AA'.$i, "1")
				    					 ->setCellValue('AB'.$i, $data->cantidad_ingreso)
				    					 ->setCellValue('AC'.$i, $data->precio_unitario_actual)
				    					 ->setCellValue('AD'.$i, $data->cantidad_ingreso * $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('AE'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('AF'.$i, $data->precio_unitario_actual)
				    					 ->setCellValueExplicit('AG'.$i, "0.0000000000",PHPExcel_Cell_DataType::TYPE_STRING)
				    					 ->setCellValue('AH'.$i, $data->stock_actual)
				    					 ->setCellValue('AI'.$i, $data->precio_unitario_actual_promedio)
				    					 ->setCellValue('AJ'.$i, $data->stock_actual*$data->precio_unitario_actual_promedio)
				    					 ->setCellValue('AK'.$i, "1")
					    			     ->setCellValue('AL'.$i, "0")
					    			     ->setCellValue('AM'.$i, "0")
					    			     ->setCellValue('AN'.$i, "0");
				    		$i++;
				    	}
					}
				}
			    /* Rename sheet */
			    $objWorkSheet->setTitle("Reporte SUNAT I");
        	}
        }

	    $objPHPExcel->setActiveSheetIndex(0);
		/* datos de la salida del excel */
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Kardex_General.xls");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
	
}
?>