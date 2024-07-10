<?php

class Historial extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MDHISTORIAL);
	}

	public function Historial()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_tag'] = "Historial - Clínica Dental";
		$data['page_title'] = "Historial <small>Clínica Dental</small>";
		$data['page_name'] = "Historial";
		$data['page_functions_js'] = "functions_historial.js";
		$this->views->getView($this, "historial", $data);
	}


	public function getHistoriaales()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectHistoriales();
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
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewHistorial(' . $arrData[$i]['hist_id'] . ')" title="Ver Historial"><i class="far fa-eye"></i></button>';
				}

				$arrData[$i]['options'] = '<div class="text-center">' . $btnAsi . ' ' . $btnProTodos . '  ' . $btnPro . ' ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
	}




	public function getHistorial($idHistorials)
	{
		if ($_SESSION['permisosMod']['r']) {
			$iDHistorial = intval($idHistorials);
			if ($iDHistorial > 0) {
				$arrData = $this->model->selectHsitorial($iDHistorial);
				//dep($arrData);
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



	public function getSelectHistorial()
	{
		$htmlOptions = '<option value="">SELECCIONE UN Historial</option>'; // Opción inicial por defecto

		$arrData = $this->model->selectHistorials();

		if (count($arrData) > 0) {
			foreach ($arrData as $Historial) {
				if ($Historial['status'] == 1) {
					$htmlOptions .= '<option value="' . $Historial['ser_id'] . '">' . $Historial['ser_nombre'] . '</option>';
				}
			}
		} else {
			$htmlOptions = '<option value="">NO HAY DATOS</option>'; // Si no hay datos disponibles
		}

		echo $htmlOptions;
		die();
	}


	public function delHistorial()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intIdHistorials = intval($_POST['idHistorial']);
				$requestDelete = $this->model->deleteHistorial($intIdHistorials);
				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Historial');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Historial.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function perfil()
	{
		$data['page_tag'] = "Perfil";
		$data['page_title'] = "Perfil de Historial";
		$data['page_name'] = "perfil";
		$data['page_functions_js'] = "functions_Historial.js";
		$this->views->getView($this, "perfil", $data);
	}

	public function putPerfil()
	{
		if ($_POST) {
			if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idHistorial = $_SESSION['idUser'];
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = strClean($_POST['txtNombre']);
				$strApellido = strClean($_POST['txtApellido']);
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strPassword = "";
				if (!empty($_POST['txtPassword'])) {
					$strPassword = hash("SHA256", $_POST['txtPassword']);
				}
				$request_user = $this->model->updatePerfil(
					$idHistorial,
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
				$idHistorial = $_SESSION['idUser'];
				$strNit = strClean($_POST['txtNit']);
				$strNomFiscal = strClean($_POST['txtNombreFiscal']);
				$strDirFiscal = strClean($_POST['txtDirFiscal']);
				$request_datafiscal = $this->model->updateDataFiscal(
					$idHistorial,
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
