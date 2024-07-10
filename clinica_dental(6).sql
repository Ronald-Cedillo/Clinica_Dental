-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-07-2024 a las 10:22:58
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinica_dental`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `cit_id` int(11) NOT NULL,
  `cit_pac_id` int(11) NOT NULL,
  `cit_per_id` int(11) DEFAULT NULL,
  `cit_ser_id` int(11) NOT NULL,
  `cit_descripcion` varchar(700) NOT NULL,
  `cit_fecha` date NOT NULL,
  `cit_hora` time NOT NULL,
  `cit_tipo` int(11) NOT NULL DEFAULT 1,
  `cit_estado` enum('programada','cancelada','realizada') DEFAULT 'programada',
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`cit_id`, `cit_pac_id`, `cit_per_id`, `cit_ser_id`, `cit_descripcion`, `cit_fecha`, `cit_hora`, `cit_tipo`, `cit_estado`, `status`) VALUES
(3, 2, 1, 1, 'Prueba de cita', '2024-07-02', '15:00:00', 1, 'programada', 3),
(4, 1, 3, 1, 'Prueba 2', '2024-07-02', '20:00:00', 1, 'programada', 3),
(5, 1, 2, 1, 'Prueba', '2024-07-02', '18:00:00', 1, 'programada', 3),
(6, 1, 1, 1, 'Prueba De Historial Medico', '2024-07-02', '13:00:00', 1, 'programada', 3),
(7, 1, 3, 1, 'Limpieza dental', '2024-07-02', '16:00:00', 1, 'programada', 3),
(9, 1, 2, 10, 'NUevos Dientes', '2024-07-03', '11:00:00', 1, 'programada', 3),
(10, 1, 2, 9, 'CAlsa De MUela', '2024-07-05', '14:00:00', 2, 'programada', 2),
(20, 4, 2, 7, 'Pppp', '2024-07-04', '08:00:00', 2, 'programada', 2),
(21, 2, 3, 8, 'Asdasdasdadas', '2024-07-03', '16:00:00', 2, 'programada', 2),
(22, 2, 3, 8, 'Asdasdasdadas', '2024-07-03', '16:00:00', 2, 'programada', 2),
(23, 3, 2, 5, 'Asdf', '2024-07-03', '19:00:00', 2, 'programada', 2),
(24, 2, 2, 8, 'Colocar Nuevos', '2024-07-05', '08:00:00', 2, 'programada', 1),
(25, 2, 1, 4, 'D', '2024-07-04', '08:00:00', 1, 'programada', 2),
(26, 1, 2, 5, 'Prueba', '2024-07-04', '08:00:00', 1, 'programada', 1),
(27, 2, 2, 8, 'Prueba De Recordatorio Y Disponibilida Del Dentista', '2024-07-04', '08:00:00', 1, 'programada', 1),
(28, 8, 5, 7, 'NUevas Coronas', '2024-07-04', '09:00:00', 1, 'programada', 1),
(29, 2, 3, 6, 'Prueba Cedula', '2024-07-04', '10:00:00', 1, 'programada', 1);

--
-- Disparadores `citas`
--
DELIMITER $$
CREATE TRIGGER `after_insert_citas` AFTER INSERT ON `citas` FOR EACH ROW BEGIN
    DECLARE per_id INT;
    DECLARE fecha DATE;
    DECLARE hora TIME;
    
    -- Obtener los datos de la cita insertada
    SET per_id = NEW.cit_per_id;
    SET fecha = DATE(NEW.cit_fecha);
    SET hora = TIME(NEW.cit_hora);

    -- Insertar en disponibilidad_dentista
    INSERT INTO disponibilidad_dentista (disp_per_id, disp_fecha, disp_hora_inicio, disp_hora_fin)
    VALUES (per_id, fecha, hora, ADDTIME(hora, '00:59:00'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_citas_recordatorios` AFTER INSERT ON `citas` FOR EACH ROW BEGIN
    DECLARE v_correo VARCHAR(100);

    -- Obtener el correo electrónico del paciente
    SELECT pac_correo_electronico INTO v_correo
    FROM pacientes
    WHERE pac_id = NEW.cit_pac_id;

    -- Insertar en la tabla de recordatorios solo si el correo no es NULL
    IF v_correo IS NOT NULL THEN
        INSERT INTO recordatorios (rec_id_pac, rec_cit_id, rec_fecha_envio, rec_correo, rec_metodo)
        VALUES (NEW.cit_pac_id, NEW.cit_id, CONCAT(NEW.cit_fecha, ' ', NEW.cit_hora), v_correo, 'correo_electronico');
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_insert_citas` AFTER INSERT ON `citas` FOR EACH ROW BEGIN
    DECLARE v_pac_cedula VARCHAR(13);
    DECLARE v_pac_id INT;
    DECLARE v_hist_descripcion TEXT;

    -- Obtener la cédula del paciente desde la tabla pacientes
    SELECT pac_cedula, pac_id INTO v_pac_cedula, v_pac_id
    FROM pacientes
    WHERE pac_id = NEW.cit_pac_id;

    -- Si no se encuentra el paciente, salir del trigger
    IF v_pac_id IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se encontró el paciente asociado a la cita.';
    END IF;

    -- Construir la descripción para el historial médico
    SET v_hist_descripcion = CONCAT(
        'Cita programada para el paciente con cédula ',
        v_pac_cedula,
        ' el día ',
        DATE_FORMAT(NEW.cit_fecha, '%d/%m/%Y'),
        ' a las ',
        TIME_FORMAT(NEW.cit_hora, '%H:%i')
    );

    -- Insertar registro en historial_medico
    INSERT INTO historial_medico (hist_cita_id, hist_pac_id, hist_fecha, hist_descripcion)
    VALUES (NEW.cit_id, v_pac_id, NEW.cit_fecha, v_hist_descripcion);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad_dentista`
--

CREATE TABLE `disponibilidad_dentista` (
  `disp_id` int(11) NOT NULL,
  `disp_per_id` bigint(20) NOT NULL,
  `disp_fecha` date NOT NULL,
  `disp_hora_inicio` time NOT NULL,
  `disp_hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `disponibilidad_dentista`
--

INSERT INTO `disponibilidad_dentista` (`disp_id`, `disp_per_id`, `disp_fecha`, `disp_hora_inicio`, `disp_hora_fin`) VALUES
(1, 2, '2024-07-02', '18:00:00', '18:59:00'),
(2, 1, '2024-07-02', '13:00:00', '13:59:00'),
(3, 3, '2024-07-02', '16:00:00', '16:59:00'),
(5, 2, '2024-07-03', '11:00:00', '11:59:00'),
(6, 2, '2024-07-05', '14:00:00', '14:59:00'),
(16, 2, '2024-07-04', '08:00:00', '08:59:00'),
(17, 3, '2024-07-03', '16:00:00', '16:59:00'),
(18, 3, '2024-07-03', '16:00:00', '16:59:00'),
(19, 2, '2024-07-03', '19:00:00', '19:59:00'),
(20, 2, '2024-07-03', '17:00:00', '17:59:00'),
(21, 2, '2024-07-04', '08:00:00', '08:59:00'),
(22, 5, '2024-07-04', '09:00:00', '09:59:00'),
(23, 3, '2024-07-04', '10:00:00', '10:59:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `fac_id` int(11) NOT NULL,
  `fac_cit_id` int(11) NOT NULL,
  `fac_monto` decimal(10,2) NOT NULL,
  `fac_fecha_pago` date NOT NULL,
  `fac_metodo_pago` enum('efectivo','tarjeta','transferencia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_medico`
--

CREATE TABLE `historial_medico` (
  `hist_id` int(11) NOT NULL,
  `hist_cedula` varchar(12) NOT NULL,
  `hist_cita_id` int(11) NOT NULL,
  `hist_pac_id` int(11) NOT NULL,
  `hist_fecha` date NOT NULL,
  `hist_descripcion` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historial_medico`
--

INSERT INTO `historial_medico` (`hist_id`, `hist_cedula`, `hist_cita_id`, `hist_pac_id`, `hist_fecha`, `hist_descripcion`, `status`) VALUES
(1, '1720643442', 1, 1, '2024-07-02', 'Prueba De Historial Medico', 1),
(2, '2520643442', 2, 1, '2024-07-02', 'Cambio de Brackets', 1),
(4, '1720643442', 3, 1, '2024-07-03', 'Ortodoncia de los Dientes frontales', 1),
(5, '2520643442', 10, 1, '2024-07-05', 'Calsa De Muela', 1),
(6, '', 28, 8, '2024-07-04', 'Cita programada para el paciente con cédula 179865232 el día 04/07/2024 a las 09:00', 1),
(7, '', 29, 2, '2024-07-04', 'Cita programada para el paciente con cédula 2520643442 el día 04/07/2024 a las 10:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` bigint(20) NOT NULL,
  `titulo` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Dashboard', 'Dashboard', 1),
(2, 'Usuarios', 'Usuarios del sistema', 1),
(3, 'Clientes', 'Clientes de tienda', 1),
(4, 'Productos', 'Todos los productos', 1),
(10, 'paciente', 'Pacientes', 1),
(11, 'Citas', 'Citas', 1),
(12, 'Servicios', 'Servicios', 1),
(13, 'Historial', 'Historial', 1),
(14, 'Recordatorios', 'Recordatorios', 1),
(15, 'Servicios', 'Tipo de servicio que da la CLinica', 1),
(16, 'Citas', 'Modulo de registro de Citas Dental', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `pac_id` int(11) NOT NULL,
  `pac_cedula` varchar(13) NOT NULL,
  `pac_nombre` varchar(100) NOT NULL,
  `pac_apellido` varchar(100) NOT NULL,
  `pac_correo_electronico` varchar(100) NOT NULL,
  `pac_telefono` varchar(20) DEFAULT NULL,
  `pac_direccion` varchar(255) DEFAULT NULL,
  `pac_fecharegistro` date DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`pac_id`, `pac_cedula`, `pac_nombre`, `pac_apellido`, `pac_correo_electronico`, `pac_telefono`, `pac_direccion`, `pac_fecharegistro`, `status`) VALUES
(1, '1720643442', 'WILLIAM', 'Cuenca', '123123123', 'prueba@gmail.com', '5a4a0b60347ec7f71abf5bdcd770f98f17c10e12b94178c7635075aa61d02c2d', '2024-07-02', 1),
(2, '2520643442', 'KARLA', 'PAREDES', 'pedro@gmail.com', '123333333', '13d2d377ae476ab92ff42766c5fbb4f043ffdc860db203e24b5ec74d396e6587', '2024-07-02', 1),
(3, '1720643444', 'Qwe', 'Qwe', 'm@gmail.com', '987654', '455d3af9c0740b5c48fbd1b406642141f57b06c0d97a5b5c8e7d2337b4549048', '2024-07-03', 1),
(4, '1720643445', 'Qweqwe', 'Qweqwe', 'mcc@gmail.com', '23123123', '8a8f9e2038532b7a836f28c73f6a1515d6d8af319fc0c4206bed19002a4c3369', '2024-07-03', 1),
(5, '123123', 'Qweqwe', 'Qwe', 'o@gmail.com', '123123', 'ccb75c48d725ef713997e6a2b3459b9be48399e4c5d2d9a352d2a4453bc7ed09', '2024-07-03', 0),
(6, '121212', 'Qweqw', 'Eqweqwe', 'l@gmail.com', '23234', '1dcb456db7c209ae78e89173b0484b3fb649593954b608125ca3b7d1093e32c5', '2024-07-03', 0),
(7, 'q132423423', 'Werwer', 'Werwer', 'lp@gmail.com', '987', '03ba544127ca4afb08a7539c3fddee5215ea965cffcdec3a48449a4092a99469', '2024-07-03', 0),
(8, '179865232', 'Miguel', 'Paredes', 'mig@gmail.com', '82223245', 'san roque', '2024-07-03', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` bigint(20) NOT NULL,
  `rolid` bigint(20) NOT NULL,
  `moduloid` bigint(20) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(12, 2, 1, 1, 1, 1, 1),
(13, 2, 2, 0, 0, 0, 0),
(14, 2, 3, 1, 1, 1, 0),
(15, 2, 4, 1, 1, 1, 0),
(16, 2, 5, 1, 1, 1, 0),
(17, 2, 6, 1, 1, 1, 0),
(18, 2, 7, 1, 0, 0, 0),
(19, 2, 8, 1, 0, 0, 0),
(20, 2, 9, 1, 1, 1, 1),
(21, 3, 1, 0, 0, 0, 0),
(22, 3, 2, 0, 0, 0, 0),
(23, 3, 3, 0, 0, 0, 0),
(24, 3, 4, 0, 0, 0, 0),
(25, 3, 5, 1, 0, 0, 0),
(26, 3, 6, 0, 0, 0, 0),
(27, 3, 7, 0, 0, 0, 0),
(28, 3, 8, 0, 0, 0, 0),
(29, 3, 9, 0, 0, 0, 0),
(30, 4, 1, 1, 0, 0, 0),
(31, 4, 2, 0, 0, 0, 0),
(32, 4, 3, 1, 1, 1, 0),
(33, 4, 4, 1, 0, 0, 0),
(34, 4, 5, 1, 0, 1, 0),
(35, 4, 6, 0, 0, 0, 0),
(36, 4, 7, 1, 0, 0, 0),
(37, 4, 8, 1, 0, 0, 0),
(38, 4, 9, 0, 0, 0, 0),
(59, 1, 1, 1, 1, 1, 1),
(60, 1, 2, 1, 1, 1, 1),
(61, 1, 3, 1, 1, 1, 1),
(62, 1, 4, 1, 1, 1, 1),
(63, 1, 10, 1, 1, 1, 1),
(64, 1, 11, 1, 1, 1, 1),
(65, 1, 12, 1, 1, 1, 1),
(66, 1, 13, 1, 1, 1, 1),
(67, 1, 14, 1, 1, 1, 1),
(68, 1, 15, 1, 1, 1, 1),
(69, 1, 16, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` bigint(20) NOT NULL,
  `identificacion` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `nombres` varchar(80) CHARACTER SET utf8mb4 DEFAULT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `telefono` bigint(20) NOT NULL,
  `email_user` varchar(100) COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(75) COLLATE utf8mb4_swedish_ci NOT NULL,
  `nit` varchar(20) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `nombrefiscal` varchar(80) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `direccionfiscal` varchar(100) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `token` varchar(100) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `rolid` bigint(20) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `identificacion`, `nombres`, `apellidos`, `telefono`, `email_user`, `password`, `nit`, `nombrefiscal`, `direccionfiscal`, `token`, `rolid`, `datecreated`, `status`) VALUES
(1, '24091989', 'Juan', 'Castro', 123456, 'info@prueba.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'CF', 'Abel OSH', 'Ciudad', NULL, 1, '2021-08-20 01:34:15', 1),
(2, '24091990', 'Alex', 'Arana', 456878977, 'alex@info.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, NULL, NULL, 2, '2021-08-20 02:58:47', 1),
(3, '84654864', 'Ricardo', 'Hernández Pérez', 4687987, 'hr@info.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '468798', 'Ricardo HP', 'Ciudad de Guatemala', NULL, 3, '2021-08-20 03:41:28', 1),
(4, '798465877', 'Fernando', 'Guerra', 468498, 'fer@info.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, NULL, NULL, 4, '2021-08-21 18:07:00', 1),
(5, '1719690487', 'Maria Veronica', 'Barragan Carrion', 987548544, 'vero@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, NULL, NULL, 4, '2024-07-02 17:34:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorios`
--

CREATE TABLE `recordatorios` (
  `rec_id` int(11) NOT NULL,
  `rec_id_pac` int(11) NOT NULL,
  `rec_cit_id` int(11) NOT NULL,
  `rec_fecha_envio` datetime NOT NULL,
  `rec_correo` varchar(100) NOT NULL,
  `rec_metodo` enum('correo_electronico','SMS') NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recordatorios`
--

INSERT INTO `recordatorios` (`rec_id`, `rec_id_pac`, `rec_cit_id`, `rec_fecha_envio`, `rec_correo`, `rec_metodo`, `status`) VALUES
(1, 1, 7, '2024-07-02 09:00:00', '123123123', 'correo_electronico', 1),
(2, 1, 9, '2024-07-03 11:00:00', '123123123', 'correo_electronico', 1),
(3, 1, 10, '2024-07-05 14:00:00', '123123123', 'correo_electronico', 1),
(4, 2, 21, '2024-07-03 16:00:00', 'pedro@gmail.com', 'correo_electronico', 1),
(5, 2, 22, '2024-07-03 16:00:00', 'pedro@gmail.com', 'correo_electronico', 1),
(6, 2, 27, '2024-07-04 08:00:00', 'pedro@gmail.com', 'correo_electronico', 1),
(7, 8, 28, '2024-07-04 09:00:00', 'mig@gmail.com', 'correo_electronico', 1),
(8, 2, 29, '2024-07-04 10:00:00', 'pedro@gmail.com', 'correo_electronico', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `nombrerol` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Acceso a todo el sistema', 1),
(2, 'Supervisor', 'Supervisor de tiendas', 1),
(3, 'Cliente', 'Clientes en general', 1),
(4, 'Dentista', 'Operador de tienda', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `ser_id` int(11) NOT NULL,
  `ser_nombre` varchar(100) NOT NULL,
  `ser_descripcion` text DEFAULT NULL,
  `ser_duracion` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`ser_id`, `ser_nombre`, `ser_descripcion`, `ser_duracion`, `status`) VALUES
(1, 'prueba', 'Prueba', NULL, 0),
(2, 'Limpieza Dental:', 'Remoción De Placa, Sarro Y Manchas De Los Dientes Para Mantener La Higiene Oral Y Prevenir Enfermedades.', NULL, 0),
(3, 'Exámenes y Diagnósticos:', 'Revisión Regular Para Detectar Caries, Enfermedades De Las Encías Y Otras Condiciones De Salud Bucal.', NULL, 1),
(4, 'Obturaciones (Empastes):', 'Reparación De Dientes Dañados Por Caries Mediante La Colocación De Materiales De Restauración.', NULL, 1),
(5, 'Extracciones Dentales:', 'Remoción De Dientes Que Están Dañados O Que No Tienen Suficiente Espacio Para Crecer Correctamente.', NULL, 1),
(6, 'Tratamiento de Conducto (Endodoncia):', 'Procedimiento Para Tratar Infecciones En El Interior Del Diente, Removiendo El Nervio Y La Pulpa.', NULL, 1),
(7, 'Coronas y Puentes:', 'Restauraciones Dentales Para Reemplazar Dientes Dañados O Perdidos, Proporcionando Una Apariencia Y Función Natural.', NULL, 1),
(8, 'Implantes Dentales', 'Reemplazo De Dientes Perdidos Con Raíces Artificiales De Titanio Que Se Integran En El Hueso De La Mandíbula.', NULL, 1),
(9, 'Ortodoncia:', 'Tratamientos Para Corregir La Alineación De Los Dientes Y La Mandíbula, Utilizando Aparatos Como Brackets Y Alineadores Invisibles.', NULL, 1),
(10, 'Prótesis Dentales:', 'Reemplazo De Dientes Perdidos Mediante Prótesis Removibles Como Dentaduras Completas O Parciales.', NULL, 1),
(11, 'Blanqueamiento Dental:', 'Tratamientos Para Aclarar El Color De Los Dientes Y Mejorar La Estética De La Sonrisa.', NULL, 1),
(12, 'Cuidado de las Encías (Periodoncia):', 'Tratamientos Para Prevenir Y Tratar Enfermedades De Las Encías Y Del Hueso Que Sostiene Los Dientes.', NULL, 1),
(13, 'Cirugía Oral:', 'Procedimientos Quirúrgicos En La Boca Y La Mandíbula, Como La Extracción De Muelas Del Juicio.', NULL, 1),
(14, 'Odontología Estética:', 'Procedimientos Para Mejorar La Apariencia De Los Dientes, Incluyendo Carillas, Contorneado Dental Y Adhesiones.', NULL, 1),
(15, 'Selladores Dentales:', 'Aplicación De Una Capa Protectora En Las Superficies De Masticación De Los Dientes Posteriores Para Prevenir Caries.', NULL, 1),
(16, 'Tratamientos para la Sensibilidad Dental:', 'Procedimientos Para Reducir La Sensibilidad De Los Dientes A Estímulos Como El Calor, El Frío Y Los Dulces.', NULL, 1),
(17, 'Educación y Prevención:.......', 'Consejos Y Técnicas Para El Cuidado Oral Adecuado, Incluyendo La Instrucción Sobre El Cepillado Y El Uso Del Hilo Dental.........', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`cit_id`),
  ADD KEY `cit_pac_id` (`cit_pac_id`),
  ADD KEY `cit_per_id` (`cit_per_id`),
  ADD KEY `cit_ser_id` (`cit_ser_id`);

--
-- Indices de la tabla `disponibilidad_dentista`
--
ALTER TABLE `disponibilidad_dentista`
  ADD PRIMARY KEY (`disp_id`),
  ADD KEY `disp_per_id` (`disp_per_id`);

--
-- Indices de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD PRIMARY KEY (`fac_id`),
  ADD KEY `fac_cit_id` (`fac_cit_id`);

--
-- Indices de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD PRIMARY KEY (`hist_id`),
  ADD KEY `hist_pac_id` (`hist_pac_id`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`pac_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermiso`),
  ADD KEY `rolid` (`rolid`),
  ADD KEY `moduloid` (`moduloid`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`),
  ADD KEY `rolid` (`rolid`);

--
-- Indices de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD PRIMARY KEY (`rec_id`),
  ADD KEY `rec_cit_id` (`rec_cit_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`ser_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `cit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `disponibilidad_dentista`
--
ALTER TABLE `disponibilidad_dentista`
  MODIFY `disp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  MODIFY `fac_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  MODIFY `hist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `pac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `ser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `disponibilidad_dentista`
--
ALTER TABLE `disponibilidad_dentista`
  ADD CONSTRAINT `disponibilidad_dentista_ibfk_1` FOREIGN KEY (`disp_per_id`) REFERENCES `persona` (`idpersona`);

--
-- Filtros para la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD CONSTRAINT `facturacion_ibfk_1` FOREIGN KEY (`fac_cit_id`) REFERENCES `citas` (`cit_id`);

--
-- Filtros para la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD CONSTRAINT `historial_medico_ibfk_1` FOREIGN KEY (`hist_pac_id`) REFERENCES `pacientes` (`pac_id`);

--
-- Filtros para la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD CONSTRAINT `recordatorios_ibfk_1` FOREIGN KEY (`rec_cit_id`) REFERENCES `citas` (`cit_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
