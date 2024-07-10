<?php

class Cita extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MDCITA);
	}

	public function Cita()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_tag'] = "Cita - Clínica Dental";
		$data['page_title'] = "Cita <small>Clínica Dental</small>";
		$data['page_name'] = "Cita";
		$data['page_functions_js'] = "functions_cita.js";
		$this->views->getView($this, "cita", $data);
	}


	public function getCitas()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectCitas();

			foreach ($arrData as &$row) {
				// Cambio en la visualización del status
				if ($row['status'] == 1) {
					$row['status'] = '<span class="badge badge-success">Activo</span>';
				} elseif ($row['status'] == 2) {
					$row['status'] = '<span class="badge badge-danger">Cancelado</span>';
				} elseif ($row['status'] == 3) {
					$row['status'] = '<span class="badge badge-warning">Reservado</span>';
				}

				// Convertir cit_tipo a cadena con etiquetas span
				if ($row['cit_tipo'] == 2) {
					$row['cit_tipo'] = '<span class="badge badge-secondary">Chatbot</span>';
				} elseif ($row['cit_tipo'] == 1) {
					$row['cit_tipo'] = '<span class="badge badge-primary">Reserva Manual</span>';
				} else {
					$row['cit_tipo'] = ''; // Manejar cualquier otro caso según sea necesario
				}

				// Agregar botones de acciones (opciones)
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if ($_SESSION['permisosMod']['r']) {
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewCita(' . $row['cit_id'] . ')" title="Ver Cita"><i class="far fa-eye"></i></button>';
				}
				if ($_SESSION['permisosMod']['u']) {
					$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditCita(this,' . $row['cit_id'] . ')" title="Editar Cita"><i class="fas fa-pencil-alt"></i></button>';
				}
				if ($_SESSION['permisosMod']['d']) {
					if ($row['status'] == '<span class="badge badge-danger">Cancelado</span>') {
						$btnDelete = '<button class="btn btn-danger btn-sm" disabled onClick="fntDelCita(' . $row['cit_id'] . ')" title="Cancelar Cita"><i class="fas fa-ban"></i></button>';
					} else {
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelCita(' . $row['cit_id'] . ')" title="Cancelar Cita"><i class="fas fa-ban"></i></button>';
					}
				}

				// Construir opciones HTML
				$row['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}

			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
	}



	public function setCita()
	{
		if ($_POST) {
			if (
				empty($_POST['listDentistaid']) ||
				empty($_POST['listClienteid']) ||
				empty($_POST['listServicioid']) ||
				empty($_POST['txtDescripcion']) ||
				empty($_POST['fechaSeleccionada']) ||
				empty($_POST['horaSeleccionada']) ||

				empty($_POST['listStatus'])
			) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idCita = intval($_POST['idCita']);
				$intDentista = intval(strClean($_POST['listDentistaid']));
				$intPaciente = intval(strClean($_POST['listClienteid']));
				$intServicio = intval(strClean($_POST['listServicioid']));
				$strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
				$strFecha = strClean($_POST['fechaSeleccionada']);
				$strHora = strClean($_POST['horaSeleccionada']);
				$intStatus = intval(strClean($_POST['listStatus']));
				$request_user = "";
				if ($idCita == 0) {
					$option = 1;

					if ($_SESSION['permisosMod']['w']) {
						$request_user = $this->model->insertCita(
							$intDentista,
							$intPaciente,
							$intServicio,
							$strDescripcion,
							$strFecha,
							$strHora,
							$intStatus
						);
					}
				} else {
					$option = 2;
					$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);
					if ($_SESSION['permisosMod']['u']) {
						$request_user = $this->model->updateCita(
							$idCita,
							$intDentista,
							$intPaciente,
							$intServicio,
							$strDescripcion,
							$strFecha,
							$strHora,
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
					$arrResponse = array('status' => false, 'msg' => '¡Atención! Cita ya existe, ingrese otro.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}



	public function getCita($idCitas)
	{
		if ($_SESSION['permisosMod']['r']) {
			$idCita = intval($idCitas);
			if ($idCita > 0) {
				$arrData = $this->model->selectCita($idCita);
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

	public function delCita()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intIdCitas = intval($_POST['idCita']);
				$requestDelete = $this->model->deleteCita($intIdCitas);
				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Se ha cancelado la Cita');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Cita.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
}
