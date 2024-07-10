<?php

class RecordatorioModel extends Mysql
{

    public function __construct()
    {
        parent::__construct();
    }


    public function selectRecordatorios()
    {
        $sql = "SELECT 
                r.rec_id,
                r.rec_id_pac,
                r.rec_cit_id,
                r.rec_fecha_envio,
                r.rec_correo,
                r.rec_metodo,
                r.status,
                CONCAT(p.pac_nombre, ' ', p.pac_apellido) AS pac_nombre_completo
            FROM 
                recordatorios r
            INNER JOIN
                pacientes p ON r.rec_id_pac = p.pac_id
            WHERE 
                r.status != 0";

        $request = $this->select_all($sql);
        return $request;
    }


    public function obtenerUltimaCitaYRecordatorio()
    {
        $sql = "SELECT cit_fecha, cit_hora, cit_recordatorio
            FROM citas
            WHERE status = 1
            ORDER BY cit_fecha DESC, cit_hora DESC
            LIMIT 1";

        $request = $this->select($sql);

        if (!empty($request)) {
            return $request[0]; // Retorna el primer resultado (la última cita y su recordatorio)
        } else {
            return false; // Si no se encontraron resultados
        }
    }
}
