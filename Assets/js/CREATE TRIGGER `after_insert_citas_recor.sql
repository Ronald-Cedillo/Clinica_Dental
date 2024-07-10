CREATE TRIGGER `after_insert_citas_recordatorios` AFTER INSERT ON `citas`
 FOR EACH ROW BEGIN
    DECLARE v_correo VARCHAR(100);

    -- Obtener el correo electrónico del paciente
    SELECT pac_correo_electronico INTO v_correo
    FROM pacientes
    WHERE pac_id = NEW.cit_pac_id;

    -- Insertar en la tabla de recordatorios
    INSERT INTO recordatorios (rec_id_pac, rec_cit_id, rec_fecha_envio, rec_correo, rec_metodo)
    VALUES (NEW.cit_pac_id, NEW.cit_id, CONCAT(NEW.cit_fecha, ' ', NEW.cit_hora), v_correo, 'correo_electronico');
END