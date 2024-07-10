<?php
require_once("ChatModel.php");
require_once("Libraries/Core/Mysql.php");
class HomeModel extends Mysql
{
	private $objChat;
	private $con;
	public function __construct()
	{
		parent::__construct();
		$this->objChat = new ChatModel();
	}

	public function getAllServices()
	{
		$sql = "SELECT ser_id, ser_nombre, ser_descripcion, ser_duracion FROM servicios WHERE status = 1";
		return $this->select_all($sql);
	}

	// En tu modelo (HomeModel.php) o donde tengas la función getScheduledAppointmentsForDate

	public function getScheduledAppointmentsForDate($date)
	{
		$sql = "SELECT c.cit_per_id, c.cit_fecha, c.cit_hora, CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo
            FROM citas c
            INNER JOIN persona p ON c.cit_per_id = p.idpersona
            WHERE c.cit_fecha = ? AND c.cit_estado = 'programada' AND c.status = 1";
		$arrData = array($date);
		return $this->select_all($sql, $arrData);
	}


	public function getPatientByCedula($cedula)
	{
		$sql = "SELECT * FROM pacientes WHERE pac_cedula = ?";
		$arrData = array($cedula);
		return $this->select_all($sql, $arrData);
	}


	public function getHistorialClinicoPorCedula($cedula)
	{
		$sql = "SELECT * FROM historial_medico WHERE hist_cedula = :cedula AND status = 1";
		$arrData = array(':cedula' => $cedula);
		return $this->selectCedula($sql, $arrData);
	}

	public function getServiceById($id)
	{
		$sql = "SELECT * FROM servicios WHERE ser_id = ?";
		$arrParams = array($id);
		$request = $this->selectIDServicio($sql, $arrParams);
		return $request;
	}

	public function getTraerDentistaDisponible()
	{
		$sql = "SELECT idpersona, nombres, apellidos
				FROM persona
				WHERE idpersona NOT IN (
					SELECT disp_per_id
					FROM disponibilidad_dentista
				)";
		$request = $this->select($sql);
		return $request;
	}
}
