<?php

class CitaModel extends Mysql
{

	private $intIdCitas;
	private $intIdUsuario;
	private $intIdDentista;
	private $intIdPaciente;
	private $intIdServicio;
	private $strFechaAsignacion;
	private $strHoraAsignacion;
	private $strDescripcion;
	private $intTipoId;
	private $intStatus;
	private $strNit;
	private $strNomFiscal;
	private $strDirFiscal;

	public function __construct()
	{
		parent::__construct();
	}


	public function selectCitas()
	{
		$sql = "SELECT c.cit_id, c.cit_pac_id, c.cit_per_id, c.cit_ser_id, c.cit_descripcion,
                   c.cit_fecha, c.cit_hora, c.cit_estado, c.cit_tipo, c.status,
                   p.pac_cedula, CONCAT(p.pac_nombre, ' ', p.pac_apellido) AS pac_nombre_completo, p.pac_correo_electronico,
                   CONCAT(per.nombres, ' ', per.apellidos) AS per_nombre_completo,
                   s.ser_nombre, s.ser_descripcion, s.ser_duracion
            FROM citas c
            INNER JOIN pacientes p ON c.cit_pac_id = p.pac_id
            INNER JOIN persona per ON c.cit_per_id = per.idpersona
            INNER JOIN servicios s ON c.cit_ser_id = s.ser_id
            WHERE c.status != 0";
		$request = $this->select_all($sql);
		return $request;
	}




	public function insertCita(
		int $dentista,
		int $paciente,
		int $servicio,
		string $descripcion,
		string $fecha,
		string $hora,
		int $status
	) {
		// Asignar valores a las propiedades de la clase
		$this->intIdDentista = $dentista;
		$this->intIdPaciente = $paciente;
		$this->intIdServicio = $servicio;
		$this->strDescripcion = $descripcion;
		$this->strFechaAsignacion = $fecha;
		$this->strHoraAsignacion = $hora;
		$this->intStatus = $status;

		// Calcular la fecha y hora del recordatorio (2 horas antes de la cita)
		$fecha_cita = "$fecha";

		$recordatorio = date('Y-m-d H:i:s', strtotime('-2 hours', strtotime($fecha_cita)));

		// Inicializar el valor de retorno
		$return = 0;

		// Query de inserción
		$query_insert  = "INSERT INTO citas (
								cit_pac_id,
								cit_per_id,
								cit_ser_id,
								cit_descripcion,
								cit_fecha,
								cit_hora,
								status,
								cit_recordatorio
						  ) 
						  VALUES (?,?,?,?,?,?,?,?)";

		// Datos para la inserción
		$arrData = array(
			$this->intIdPaciente,
			$this->intIdDentista,
			$this->intIdServicio,
			$this->strDescripcion,
			$this->strFechaAsignacion,
			$this->strHoraAsignacion,
			$this->intStatus,
			$recordatorio
		);

		// Ejecutar la inserción y obtener el resultado
		$request_insert = $this->insert($query_insert, $arrData);

		// Asignar el resultado al valor de retorno
		$return = $request_insert;

		return $return;
	}




	public function selectCita(int $idCitas)
	{
		$this->intIdCitas = $idCitas;
		$sql = "SELECT c.cit_id, c.cit_pac_id, c.cit_per_id, c.cit_ser_id, c.cit_descripcion,
                   c.cit_fecha, c.cit_hora, c.cit_estado, c.cit_tipo, c.status,
                   p.pac_cedula, CONCAT(p.pac_nombre, ' ', p.pac_apellido) AS pac_nombre_completo, p.pac_correo_electronico,
                   CONCAT(per.nombres, ' ', per.apellidos) AS per_nombre_completo,
                   s.ser_nombre, s.ser_descripcion, s.ser_duracion, s.status
            FROM citas c
            INNER JOIN pacientes p ON c.cit_pac_id = p.pac_id
            INNER JOIN persona per ON c.cit_per_id = per.idpersona
            INNER JOIN servicios s ON c.cit_ser_id = s.ser_id
					WHERE c.cit_id  = $this->intIdCitas";
		$request = $this->select($sql);
		return $request;
	}

	public function updateCita(
		int $idCita,
		int $dentista,
		int $paciente,
		int $servicio,
		string $descripcion,
		string $fecha,
		string $hora,
		int $status
	) {
		// Asignación de propiedades de la clase con los parámetros recibidos
		$this->intIdCitas = $idCita;
		$this->intIdDentista = $dentista;
		$this->intIdPaciente = $paciente;
		$this->intIdServicio = $servicio;
		$this->strDescripcion = $descripcion;
		$this->strFechaAsignacion = $fecha;
		$this->strHoraAsignacion = $hora;
		$this->intStatus = $status;

		// Consulta SQL con marcadores de posición (?)
		$sql = "UPDATE citas SET cit_pac_id = ?, 
								 cit_per_id = ?, 
								 cit_ser_id = ?, 
								 cit_descripcion = ?, 
								 cit_fecha = ?, 
								 cit_hora = ?, 
								 status = ? 
				WHERE cit_id = ?";

		// Array de datos para la consulta preparada
		$arrData = [
			$this->intIdPaciente,
			$this->intIdDentista,
			$this->intIdServicio,
			$this->strDescripcion,
			$this->strFechaAsignacion,
			$this->strHoraAsignacion,
			$this->intStatus,
			$this->intIdCitas // Utilizando $this->intIdCitas como identificador de la cita a actualizar
		];

		// Llamada al método update con la consulta y los datos
		$request = $this->update($sql, $arrData);

		return $request; // Devuelve el resultado de la operación de actualización
	}



	public function deleteCita(int $intIdCitas)
	{
		$this->intIdCitas = $intIdCitas;
		$sql = "UPDATE citas SET status = ? WHERE cit_id  = $this->intIdCitas ";
		$arrData = array(2);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
