<?php

class Mysql extends Conexion
{
	private $conexion;
	private $strquery;
	private $arrValues;

	function __construct()
	{
		$this->conexion = new Conexion();
		$this->conexion = $this->conexion->conect();
	}

	//Insertar un registro
	public function insert(string $query, array $arrValues)
	{
		$this->strquery = $query;
		$this->arrVAlues = $arrValues;
		$insert = $this->conexion->prepare($this->strquery);
		$resInsert = $insert->execute($this->arrVAlues);
		if ($resInsert) {
			$lastInsert = $this->conexion->lastInsertId();
		} else {
			$lastInsert = 0;
		}
		return $lastInsert;
	}
	//Busca un registro
	public function select(string $query)
	{
		$this->strquery = $query;
		$result = $this->conexion->prepare($this->strquery);
		$result->execute();
		$data = $result->fetch(PDO::FETCH_ASSOC);
		return $data;
	}


	public function selectCedula(string $query, array $params = [])
	{
		$this->strquery = $query;
		$result = $this->conexion->prepare($this->strquery);
		// Bind the parameters to the query
		foreach ($params as $key => $value) {
			$result->bindValue($key, $value);
		}
		$result->execute();
		$data = $result->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	public function selectIDServicio(string $query, array $params = [])
	{
		$this->strquery = $query;
		$result = $this->conexion->prepare($this->strquery);

		// Bind the parameters to the query
		foreach ($params as $key => $value) {
			// Bind parameters, ensuring keys start at 1
			$result->bindValue($key + 1, $value);
		}

		$result->execute();
		$data = $result->fetch(PDO::FETCH_ASSOC);

		return $data;
	}

	//Devuelve todos los registros
	public function select_all(string $query, array $arrValues = [])
	{
		$this->strquery = $query;
		$stmt = $this->conexion->prepare($this->strquery);

		// Bind parameters if any
		if (!empty($arrValues)) {
			foreach ($arrValues as $key => $value) {
				$stmt->bindValue($key + 1, $value);
			}
		}

		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	//Actualiza registros
	public function update(string $query, array $arrValues)
	{
		$this->strquery = $query;
		$this->arrVAlues = $arrValues;
		$update = $this->conexion->prepare($this->strquery);
		$resExecute = $update->execute($this->arrVAlues);
		return $resExecute;
	}
	//Eliminar un registros
	public function delete(string $query)
	{
		$this->strquery = $query;
		$result = $this->conexion->prepare($this->strquery);
		$del = $result->execute();
		return $del;
	}
}
