<?php

//require_once 'Libraries/Core/Controllers.php'; // Ajusta la ruta según la ubicación de tu clase base Controllers


class Recordatorio extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MDRECORDATORIO);
	}

	public function Recordatorio()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_tag'] = "Recordatorio - Clínica Dental";
		$data['page_title'] = "Recordatorio <small>Clínica Dental</small>";
		$data['page_name'] = "Recordatorio";
		$data['page_functions_js'] = "functions_recordatorio.js";
		$this->views->getView($this, "recordatorio", $data);
	}


	public function getRecordatorios()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectRecordatorios();
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


				/*if ($_SESSION['permisosMod']['r']) {
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['rec_id'] . ')" title="Ver Recordatorio"><i class="far fa-eye"></i></button>';
				}*/

				$arrData[$i]['options'] = '<div class="text-center">' . $btnAsi . ' ' . $btnProTodos . '  ' . $btnPro . ' ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function setRecordatorio()
	{
		if ($_POST) {
			if (
				empty($_POST['txtNombreRecordatorio']) ||
				empty($_POST['txtDescripcion']) ||

				empty($_POST['listStatus'])
			) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$idRecordatorio = intval($_POST['idRecordatorio']);
				$strNombre = strClean($_POST['txtNombreRecordatorio']);
				$strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
				$intStatus = intval(strClean($_POST['listStatus']));
				$request_user = "";
				if ($idRecordatorio == 0) {
					$option = 1;

					if ($_SESSION['permisosMod']['w']) {
						$request_user = $this->model->insertRecordatorio(
							$strNombre,
							$strDescripcion,
							$intStatus
						);
					}
				} else {
					$option = 2;
					$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);
					if ($_SESSION['permisosMod']['u']) {
						$request_user = $this->model->updateRecordatorio(
							$idRecordatorio,
							$strIdentificacion,
							$strNombre,
							$strApellido,
							$intTelefono,
							$strEmail,
							$strPassword,
							$intTipoId,
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



	public function getSelectRecordatorios($idRecordatorios)
	{
		if ($_SESSION['permisosMod']['r']) {
			$iDRecordatorio = intval($idRecordatorios);
			if ($iDRecordatorio > 0) {
				$arrData = $this->model->selectRecordatorioss($iDRecordatorio);
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



	public function getSelectRecordatorio()
	{
		$htmlOptions = '<option value="">SELECCIONE UN Recordatorio</option>'; // Opción inicial por defecto

		$arrData = $this->model->selectRecordatorios();

		if (count($arrData) > 0) {
			foreach ($arrData as $Recordatorio) {
				if ($Recordatorio['status'] == 1) {
					$htmlOptions .= '<option value="' . $Recordatorio['ser_id'] . '">' . $Recordatorio['ser_nombre'] . '</option>';
				}
			}
		} else {
			$htmlOptions = '<option value="">NO HAY DATOS</option>'; // Si no hay datos disponibles
		}

		echo $htmlOptions;
		die();
	}


	public function delRecordatorio()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intIdRecordatorios = intval($_POST['idRecordatorio']);
				$requestDelete = $this->model->deleteRecordatorio($intIdRecordatorios);
				if ($requestDelete) {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Recordatorio');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Recordatorio.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}


	public function enviarRecordatorioPorCorreo()
	{
		if ($_SESSION['permisosMod']['r']) {
			// Obtener la última cita y su hora de recordatorio
			$ultimaCita = $this->model->obtenerUltimaCitaYRecordatorio();
			dep();
			exit;

			if ($ultimaCita !== false) {
				// Obtener la fecha y hora del recordatorio
				$recordatorio = $ultimaCita['cit_recordatorio'];

				// Envío del correo electrónico
				$to = 'destinatario@example.com'; // Cambia por la dirección de correo a la que deseas enviar el recordatorio
				$subject = 'Recordatorio de cita';
				$message = "Este es un recordatorio para tu cita el día {$ultimaCita['cit_fecha']} a las {$ultimaCita['cit_hora']}.";
				$headers = 'From: tuemail@example.com' . "\r\n" .
					'Reply-To: tuemail@example.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				// Envía el correo electrónico
				$mailSent = mail($to, $subject, $message, $headers);

				if ($mailSent) {
					$response = array('status' => true, 'msg' => 'Recordatorio enviado correctamente.');
				} else {
					$response = array('status' => false, 'msg' => 'Error al enviar el recordatorio por correo.');
				}
			} else {
				$response = array('status' => false, 'msg' => 'No se encontró la última cita para enviar el recordatorio.');
			}

			// Devolver la respuesta en formato JSON
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}
