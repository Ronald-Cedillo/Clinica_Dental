<?php

class Servicio extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MDSERVICIO);
	}

	public function Servicio()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_tag'] = "servicio - Clínica Dental";
		$data['page_title'] = "servicio <small>Clínica Dental</small>";
		$data['page_name'] = "servicio";
		$data['page_functions_js'] = "functions_servicio.js";
		$this->views->getView($this, "servicio", $data);
	}


	public function getServicios()
	{
		if ($_SESSION['permisosMod']['r']) {

			$arrData = $this->model->selectServicios();
			//dep($arrData);
			for ($i = 0; $i < count($arrData); $i++) {
				$btnAsi = '';
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$btnPro = '';
				$btnProTodos = '';
				if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}


				if ($_SESSION['permisosMod']['r']) {
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewServicio(' . $arrData[$i]['ser_id'] . ')" title="Ver servicio"><i class="far fa-eye"></i></button>';
				}
				if ($_SESSION['permisosMod']['u']) {
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditServicio(this,' . $arrData[$i]['ser_id'] . ')" title="Editar servicio"><i class="fas fa-pencil-alt"></i></button>';
				}
				if ($_SESSION['permisosMod']['d']) {
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelServicio(' . $arrData[$i]['ser_id'] . ')" title="Eliminar servicio"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">' . $btnAsi . ' ' . $btnProTodos . '  ' . $btnPro . ' ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
	}



	public function setServicio()
	{
		if ($_POST) {
			if (
				empty($_POST['txtNombreServicio']) ||
				empty($_POST['txtDescripcion']) ||
				empty($_POST['listStatus'])
			) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idservicio = intval($_POST['idServicio']);
				$strNombre = strClean($_POST['txtNombreServicio']);
				$strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
				$intStatus = intval(strClean($_POST['listStatus']));
				$request_user = "";
				if ($idservicio == 0) {
					$option = 1;

					if ($_SESSION['permisosMod']['w']) {
						$request_user = $this->model->insertServicio(
							$strNombre,
							$strDescripcion,
							$intStatus
						);
					}
				} else {
					$option = 2;
					if ($_SESSION['permisosMod']['u']) {
						$request_user = $this->model->updateservicio(
							$idservicio,
							$strNombre,
							$strDescripcion,
							$intStatus
						);
					}
				}

				if ($request_user > 0) {
					if ($option == 1) {
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					} else {
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				} else if ($request_user == 'exist') {
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}



	public function getServicio($idservicios)
	{
		if ($_SESSION['permisosMod']['r']) {
			$iDServicio = intval($idservicios);
			if ($iDServicio > 0) {
				$arrData = $this->model->selectServicio($iDServicio);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}



	public function getSelectServicio()
	{
		$htmlOptions = '<option value="">SELECCIONE UN SERVICIO</option>'; // Opción inicial por defecto

		$arrData = $this->model->selectServicios();

		if (count($arrData) > 0) {
			foreach ($arrData as $servicio) {
				if ($servicio['status'] == 1) {
					$htmlOptions .= '<option value="' . $servicio['ser_id'] . '">' . $servicio['ser_nombre'] . '</option>';
				}
			}
		} else {
			$htmlOptions = '<option value="">NO HAY DATOS</option>'; // Si no hay datos disponibles
		}

		echo $htmlOptions;
		die();
	}


	public function delservicio()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intIdservicios = intval($_POST['idServicio']);
				$requestDelete = $this->model->deleteservicio($intIdservicios);
				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el servicio');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el servicio.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function perfil()
	{
		$data['page_tag'] = "Perfil";
		$data['page_title'] = "Perfil de servicio";
		$data['page_name'] = "perfil";
		$data['page_functions_js'] = "functions_servicio.js";
		$this->views->getView($this, "perfil", $data);
	}

	public function putPerfil()
	{
		if ($_POST) {
			if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idservicio = $_SESSION['idUser'];
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = strClean($_POST['txtNombre']);
				$strApellido = strClean($_POST['txtApellido']);
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strPassword = "";
				if (!empty($_POST['txtPassword'])) {
					$strPassword = hash("SHA256", $_POST['txtPassword']);
				}
				$request_user = $this->model->updatePerfil(
					$idservicio,
					$strIdentificacion,
					$strNombre,
					$strApellido,
					$intTelefono,
					$strPassword
				);
				if ($request_user) {
					sessionUser($_SESSION['idUser']);
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function putDFical()
	{
		if ($_POST) {
			if (empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idservicio = $_SESSION['idUser'];
				$strNit = strClean($_POST['txtNit']);
				$strNomFiscal = strClean($_POST['txtNombreFiscal']);
				$strDirFiscal = strClean($_POST['txtDirFiscal']);
				$request_datafiscal = $this->model->updateDataFiscal(
					$idservicio,
					$strNit,
					$strNomFiscal,
					$strDirFiscal
				);
				if ($request_datafiscal) {
					sessionUser($_SESSION['idUser']);
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}
