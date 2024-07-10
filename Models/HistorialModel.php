<?php

class HistorialModel extends Mysql
{
    private $intIdHistorial;


    public function __construct()
    {
        parent::__construct();
    }


    public function selectHistoriales()
    {
        $sql = "SELECT 
                    h.hist_id,
                    h.hist_cedula,
                    h.hist_cita_id,
                    CONCAT(p.pac_nombre, ' ', p.pac_apellido) AS pac_nombre_completo,
                    h.hist_fecha,
                    h.hist_descripcion,
                    h.status
                FROM historial_medico h
                INNER JOIN pacientes p ON h.hist_pac_id = p.pac_id
                WHERE h.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectHsitorial(int $idhistorial)
    {
        $this->intIdHistorial = $idhistorial;
        $sql = "SELECT 
            h.hist_id,
            h.hist_cedula,
            h.hist_cita_id,
            CONCAT(p.pac_nombre, ' ', p.pac_apellido) AS pac_nombre_completo,
            CONCAT(per.nombres, ' ', per.apellidos) AS persona_nombre_completo,
            s.ser_nombre AS servicio_nombre,
            c.cit_descripcion AS cita_descripcion,
            c.cit_fecha AS cita_fecha,
            c.cit_hora AS cita_hora,
            c.cit_estado AS cita_estado,
            h.hist_fecha AS fecha_historial,
            h.hist_descripcion AS descripcion_historial,
            h.status AS status_historial
        FROM historial_medico h
        INNER JOIN pacientes p ON h.hist_pac_id = p.pac_id
        LEFT JOIN persona per ON p.pac_cedula = per.identificacion
        LEFT JOIN servicios s ON h.hist_cita_id = s.ser_id
        LEFT JOIN citas c ON h.hist_cita_id = c.cit_id
        WHERE h.hist_id = $this->intIdHistorial";
        $request = $this->select($sql);
        return $request;
    }
}
