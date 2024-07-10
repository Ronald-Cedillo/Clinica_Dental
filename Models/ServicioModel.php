<?php

class ServicioModel extends Mysql
{
	private $intIdServicio;
	private $strIdentificacion;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
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


	public function selectServicios()
	{

		$sql = "SELECT 
		ser_id,
		ser_nombre,
		ser_descripcion,
		status

		 FROM servicios WHERE status != 0 ";
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertServicio(
		string $nombre,
		string $descripcion,
		int $status
	) {

		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intStatus = $status;
		$return = 0;

		$sql = "SELECT * FROM servicios	 WHERE  ser_nombre = '{$this->strIdentificacion}' ";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$query_insert  = "INSERT INTO servicios(ser_nombre,ser_descripcion,status) 
								  VALUES(?,?,?)";
			$arrData = array(
				$this->strNombre,
				$this->strDescripcion,
				$this->intStatus
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}
		return $return;
	}



	public function selectServicio(int $idservicios)
	{
		$this->intIdServicio = $idservicios;
		$sql = "SELECT 
		ser_id,
		ser_nombre,
		ser_descripcion,
		status
		FROM servicios
		WHERE ser_id  = $this->intIdServicio";
		$request = $this->select($sql);
		return $request;
	}

	public function updateservicio(
		int $idUsuario,
		string $nombre,
		string $descripcion,
		int $status
	) {

		$this->intIdServicio = $idUsuario;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intStatus = $status;

		$sql = "SELECT * FROM servicios WHERE (ser_nombre = '{$this->strNombre}' AND ser_id != $this->intIdServicio) ";
		$request = $this->select_all($sql);

		if (empty($request)) {

			$sql = "UPDATE servicios SET ser_nombre=?, ser_descripcion=?, status=? 
							WHERE ser_id = $this->intIdServicio ";
			$arrData = array(
				$this->strNombre,
				$this->strDescripcion,
				$this->intStatus
			);

			$request = $this->update($sql, $arrData);
		} else {
			$request = "exist";
		}
		return $request;
	}


	public function deleteservicio(int $intIdservicios)
	{
		$this->intIdServicio = $intIdservicios;
		$sql = "UPDATE servicios SET status = ? WHERE ser_id = $this->intIdServicio ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
