<?php

class PacienteModel extends Mysql
{
	private $intIdUsuario;
	private $intIdPaciente;
	private $strIdentificacion;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strDireccion;
	private $intTipoId;
	private $intStatus;
	private $strNit;
	private $strNomFiscal;
	private $strDirFiscal;

	public function __construct()
	{
		parent::__construct();
	}


	public function selectPacientes()
	{

		$sql = "SELECT pac_id, pac_cedula, pac_nombre,pac_apellido ,CONCAT(pac_nombre, ' ', pac_apellido) AS nombre_completo,
       pac_correo_electronico, pac_telefono, pac_direccion, status

		 FROM pacientes WHERE status != 0 ";
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertpacientes(
		string $identificacion,
		string $nombre,
		string $apellido,
		int $telefono,
		string $email,
		string $direccion,
		int $status
	) {

		//echo "Valor de status recibido: " . $status . "\n";
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strDireccion = $direccion;
		$this->intStatus = $status;
		$return = 0;

		// Verificar el valor de intStatus
		//error_log("Valor de intStatus: " . $this->intStatus);
		//exit;

		$sql = "SELECT * FROM pacientes WHERE 
					pac_correo_electronico = '{$this->strEmail}' or pac_cedula = '{$this->strIdentificacion}' ";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$query_insert  = "INSERT INTO pacientes(
													pac_cedula,
													pac_nombre,
													pac_apellido,
													pac_telefono,
													pac_correo_electronico,
													pac_direccion,
													status) 
								  VALUES(?,?,?,?,?,?,?)";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
				$this->strEmail,
				$this->strDireccion,
				$this->intStatus
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}
		return $return;
	}




	public function selectPaciente(int $idpacientes)
	{
		$this->intIdPaciente = $idpacientes;
		$sql = "SELECT pac_id, pac_cedula, pac_nombre,pac_apellido ,CONCAT(pac_nombre, ' ', pac_apellido) AS nombre_completo,
       pac_correo_electronico, pac_telefono, pac_direccion,pac_fecharegistro, status
	   	FROM pacientes 
					WHERE pac_id = $this->intIdPaciente";
		$request = $this->select($sql);
		return $request;
	}

	public function updatePaciente(
		int $idPaciente,
		string $identificacion,
		string $nombre,
		string $apellido,
		int $telefono,
		string $email,
		string $direccion,
		int $status
	) {

		$this->intIdPaciente = $idPaciente;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strDireccion = $direccion;
		$this->intStatus = $status;

		$sql = "SELECT * FROM pacientes WHERE 
					pac_correo_electronico = '{$this->strEmail}' or pac_cedula = '{$this->strIdentificacion}' ";
		$request = $this->select_all($sql);

		if (empty($request)) {
			if ($this->strPassword  != "") {
				$sql = "UPDATE pacientes SET pac_cedula=?,
													 pac_nombre=?,
													  pac_apellido=?,
													    pac_correo_electronico=?,
														pac_direccion=?,
													   pac_telefono=?,
														  status=? 
							WHERE pac_id = $this->intIdUsuario ";
				$arrData = array(
					$this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->intTelefono,
					$this->strEmail,
					$this->strDireccion,
					$this->intStatus
				);
			} else {
				$sql = "UPDATE pacientes SET pac_cedula=?,
													 pac_nombre=?,
													  pac_apellido=?,
													    pac_correo_electronico=?,
														pac_direccion=?,
													   pac_telefono=?,
														  status=? 
							WHERE pac_id = $this->intIdUsuario ";
				$arrData = array(
					$this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->intTelefono,
					$this->strEmail,
					$this->strDireccion,
					$this->intStatus
				);
			}
			$request = $this->update($sql, $arrData);
		} else {
			$request = "exist";
		}
		return $request;
	}
	public function deletePaciente(int $intIdpacientes)
	{
		$this->intIdPaciente = $intIdpacientes;
		$sql = "UPDATE pacientes SET status = ? WHERE pac_id  = $this->intIdPaciente ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $password)
	{
		$this->intIdUsuario = $idUsuario;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strPassword = $password;

		if ($this->strPassword != "") {
			$sql = "UPDATE pacientes SET identificacion=?, nombres=?, apellidos=?, telefono=?, password=? 
						WHERE idpacientes = $this->intIdUsuario ";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
				$this->strPassword
			);
		} else {
			$sql = "UPDATE pacientes SET identificacion=?, nombres=?, apellidos=?, telefono=? 
						WHERE idpacientes = $this->intIdUsuario ";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono
			);
		}
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function updateDataFiscal(int $idUsuario, string $strNit, string $strNomFiscal, string $strDirFiscal)
	{
		$this->intIdUsuario = $idUsuario;
		$this->strNit = $strNit;
		$this->strNomFiscal = $strNomFiscal;
		$this->strDirFiscal = $strDirFiscal;
		$sql = "UPDATE pacientes SET nit=?, nombrefiscal=?, direccionfiscal=? 
						WHERE idpacientes = $this->intIdUsuario ";
		$arrData = array(
			$this->strNit,
			$this->strNomFiscal,
			$this->strDirFiscal
		);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
