<?php

class Paciente extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MDPACIENTE);
	}

	public function Paciente()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_tag'] = "Paciente - Clínica Dental";
		$data['page_title'] = "Paciente <small>Clínica Dental</small>";
		$data['page_name'] = "Paciente";
		$data['page_functions_js'] = "functions_paciente.js";
		$this->views->getView($this, "paciente", $data);
	}


	public function getPacientes()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectPacientes();
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
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewPaciente(' . $arrData[$i]['pac_id'] . ')" title="Ver Paciente"><i class="far fa-eye"></i></button>';
				}
				if ($_SESSION['permisosMod']['u']) {
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditPaciente(this,' . $arrData[$i]['pac_id'] . ')" title="Editar Paciente"><i class="fas fa-pencil-alt"></i></button>';
				}
				if ($_SESSION['permisosMod']['d']) {
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelPaciente(' . $arrData[$i]['pac_id'] . ')" title="Eliminar Paciente"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">' . $btnAsi . ' ' . $btnProTodos . '  ' . $btnPro . ' ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function setPaciente()
	{
		if ($_POST) {
			//dep($_POST);
			//exit;
			if (
				empty($_POST['txtCedula']) ||
				empty($_POST['txtNombre']) ||
				empty($_POST['txtApellido']) ||
				empty($_POST['txtTelefono']) ||
				empty($_POST['txtEmail']) ||
				empty($_POST['txtDireccion']) ||
				empty($_POST['listStatus'])
			) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idPaciente = intval($_POST['idPaciente']);
				$strIdentificacion = strClean($_POST['txtCedula']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strApellido = ucwords(strClean($_POST['txtApellido']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmail']));
				$strDireccion = strtolower(strClean($_POST['txtDireccion']));
				$intStatus = intval(strClean($_POST['listStatus']));
				//dep($intStatus);
				//exit;
				$request_user = "";
				if ($idPaciente == 0) {
					$option = 1;

					if ($_SESSION['permisosMod']['w']) {
						$request_user = $this->model->insertPacientes(
							$strIdentificacion,
							$strNombre,
							$strApellido,
							$intTelefono,
							$strEmail,
							$strDireccion,
							$intStatus
						);
					}
				} else {
					$option = 2;
					if ($_SESSION['permisosMod']['u']) {
						$request_user = $this->model->updatePaciente(
							$idPaciente,
							$strIdentificacion,
							$strNombre,
							$strApellido,
							$intTelefono,
							$strEmail,
							$strDireccion,
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



	public function getPaciente($idpacientes)
	{
		if ($_SESSION['permisosMod']['r']) {
			$idPaciente = intval($idpacientes);
			if ($idPaciente > 0) {
				$arrData = $this->model->selectPaciente($idPaciente);
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



	public function getSelectPaciente()
	{
		$htmlOptions = '<option value="">SELECCIONE UN PACIENTE</option>'; // Opción inicial por defecto

		$arrData = $this->model->selectPacientes();

		if (count($arrData) > 0) {
			foreach ($arrData as $servicio) {
				if ($servicio['status'] == 1) {
					$htmlOptions .= '<option value="' . $servicio['pac_id'] . '">' . $servicio['nombre_completo'] . '</option>';
				}
			}
		} else {
			$htmlOptions = '<option value="">NO HAY DATOS</option>'; // Si no hay datos disponibles
		}

		echo $htmlOptions;
		die();
	}



	public function delPaciente()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intIdpacientes = intval($_POST['idPaciente']);
				$requestDelete = $this->model->deletePaciente($intIdpacientes);
				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Paciente');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Paciente.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function perfil()
	{
		$data['page_tag'] = "Perfil";
		$data['page_title'] = "Perfil de Paciente";
		$data['page_name'] = "perfil";
		$data['page_functions_js'] = "functions_Paciente.js";
		$this->views->getView($this, "perfil", $data);
	}

	public function putPerfil()
	{
		if ($_POST) {
			if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idPaciente = $_SESSION['idUser'];
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = strClean($_POST['txtNombre']);
				$strApellido = strClean($_POST['txtApellido']);
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strPassword = "";
				if (!empty($_POST['txtPassword'])) {
					$strPassword = hash("SHA256", $_POST['txtPassword']);
				}
				$request_user = $this->model->updatePerfil(
					$idPaciente,
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
				$idPaciente = $_SESSION['idUser'];
				$strNit = strClean($_POST['txtNit']);
				$strNomFiscal = strClean($_POST['txtNombreFiscal']);
				$strDirFiscal = strClean($_POST['txtDirFiscal']);
				$request_datafiscal = $this->model->updateDataFiscal(
					$idPaciente,
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
