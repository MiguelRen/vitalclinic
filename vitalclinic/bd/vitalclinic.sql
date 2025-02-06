-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-10-2024 a las 17:29:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vitalclinic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounts`
--

CREATE TABLE `accounts` (
  `id_account` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('1','2','','') NOT NULL COMMENT '1-Habilitado,2-Inhabilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `art` bigint(20) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `departamento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `departamento`) VALUES
(1, 'Almacén'),
(2, 'Depósito'),
(3, 'Devoluciones'),
(4, 'Recepción');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1-habilitdo,2-inhabilitado',
  `departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `cedula`, `nombre`, `apellido`, `status`, `departamento`) VALUES
(8, 'cedula', 'nombre', 'apellido', '1', 0),
(9, '30537905', 'RAMIREZ', 'ROSMARVIS', '1', 0),
(10, '25576833', 'FARIAS', 'JOSE', '1', 0),
(11, '30563807', 'MARCANO', 'LOREN', '1', 0),
(12, '15633017', 'SEQUEA', 'ZAYLETT', '1', 0),
(13, '27946909', 'VELASQUEZ', 'ENMANUEL', '1', 0),
(14, '20139224', 'RODRIGUEZ', 'GUSTAVO', '1', 0),
(15, '31511191', 'GARCIA', 'LEONARDO', '1', 0),
(16, '28198149', 'SALGADO', 'JESUS', '1', 0),
(17, '27478807', 'CARMONA', 'JESUS', '1', 0),
(18, '28429561', 'GASPAR', 'MARCELO', '1', 0),
(19, '23534300', 'RODRIGUEZ', 'OMAR', '1', 0),
(20, '25581123', 'RONDON', 'JESUS', '1', 0),
(21, '30982507', 'RONDON', 'MICHELLE', '1', 0),
(22, '26157491', 'CARABALLO', 'ERIKA', '1', 0),
(23, '16517257', 'MARTINEZ', 'ALEXANDER', '1', 0),
(24, '24503943', 'ALCALA', 'DARWIN', '1', 0),
(25, '15903308', 'SALAZAR', 'YORMIS', '1', 0),
(26, '28544551', 'SUBERO', 'ISABELLA', '1', 0),
(27, '28599775', 'MONAGAS', 'DISANNY', '1', 0),
(28, '31303400', 'QUIJADA', 'MARITZABETH', '1', 0),
(29, '27325137', 'CORO', 'ELY SAUL', '1', 0),
(30, '17405013', 'ALVAREZ', 'ALMIRA', '1', 0),
(31, '25431302', 'LIRA', 'ROSIBEL', '1', 0),
(32, '24865739', 'GARCIA', 'JORGE', '1', 0),
(33, '29735524', 'MEDINA', 'ANGEL', '1', 0),
(34, '24511617', 'LOPEZ', 'EDZABETH', '1', 0),
(35, '29843827', 'BARRIOS', 'ROBERTO', '1', 0),
(36, '17708432', 'JARAMILLO', 'ANGELIS', '1', 0),
(37, '26061445', 'MATOS', 'ELIANNY', '1', 0),
(38, '27719813', 'BRITO', 'FELCRIZE', '1', 0),
(39, '25753475', 'RODRIGUEZ', 'DANIEL', '1', 0),
(40, '31625332', 'RAMIREZ', 'VICTOR', '1', 0),
(41, '29914065', 'GONZALEZ', 'MANUEL', '1', 0),
(42, '20312562', 'CABELLO', 'JOSE', '1', 0),
(43, '16516149', 'ALVAREZ', 'JOSE', '1', 0),
(44, '26157804', 'BERMUDEZ', 'YAMIL', '1', 0),
(45, '18825576', 'RODRIGUEZ', 'ALVIN', '1', 0),
(46, '30784517', 'ORTIZ', 'FRANKLIN', '1', 0),
(47, '22966872', 'BOLIVAR', 'ISAIC', '1', 0),
(48, '22714197', 'VILLAHERMOSA', 'ROGER', '1', 0),
(49, '27710312', 'RODRIGUEZ', 'JORGE', '1', 0),
(50, '18236222', 'GONZALEZ', 'LUIS ', '1', 0),
(51, '20140822', 'GUERRA', 'JOSE', '1', 0),
(52, '29735742', 'MEDINA', 'JOSE', '1', 0),
(53, '23534480', 'RODRIGUEZ', 'PEDRO', '1', 0),
(54, '30386615', 'LEON ', 'SEBASTIAN', '1', 0),
(55, '30198536', 'SEQUEA', 'KENYERSON', '1', 0),
(56, '18826648', 'ROJAS', 'JOSE', '1', 0),
(57, '22722906', 'BOLIVAR', 'DENYS', '1', 0),
(58, '23534649', 'PALMA', 'NERIELIS', '1', 0),
(59, '30367839', 'CA?A', 'LUIS', '1', 0),
(60, '21349873', 'TRUJILLO', 'PABLO', '1', 0),
(61, '27946636', 'TRUJILLO', 'SAMUEL', '1', 0),
(62, '24864437', 'ROJAS', 'MARIO', '1', 0),
(63, '25568479', 'ASTUDILLO', 'FIDEL', '1', 0),
(64, '26531656', 'BOLIVAR', 'LUIS', '1', 0),
(65, '30744649', 'LICETT', 'YORDANNY', '1', 0),
(66, '26865440', 'MAESTRE', 'MAYLIS', '1', 0),
(67, '21381040', 'LEZAMA', 'JOSE', '1', 0),
(68, '28608667', 'CASTILLO', 'DEIVIS', '1', 0),
(69, '22618623', 'RIVERO', 'HENDER', '1', 0),
(70, '23818085', 'RAMOS', 'GENESIS', '1', 0),
(71, '26101881', 'LA ROSA', 'RICARDO', '1', 0),
(72, '25428342', 'RIOS', 'ANTHONY', '1', 0),
(73, '25898123', 'BRAVO', 'ELIANY', '1', 0),
(74, '29974595', 'RODRIGUEZ', 'BRYANT', '1', 0),
(75, '31315468', 'LEONETT', 'LEANDRYS', '1', 0),
(76, '26291741', 'VALERA', 'ANDRES', '1', 0),
(77, '26532923', 'ZAMORA', 'JUAN', '1', 0),
(78, '25930478', 'BOUTTO', 'DIEGO', '1', 0),
(79, '30843160', 'DUARTE', 'CARLOS', '1', 0),
(80, '30487691', 'GUERRA', 'HERMES', '1', 0),
(81, '27767449', 'SANZONETTI', 'ROBERT', '1', 0),
(82, '30794761', 'LOPEZ', 'NELSON', '1', 0),
(83, '29642940', 'PEREZ', 'JESUS', '1', 0),
(84, '26212748', 'CHIGUITA', 'ELIEZER', '1', 0),
(85, '16062678', 'VILLARROEL', 'EDGAR', '1', 0),
(86, '19663519', 'MAITA', 'MAITA DANIEL', '1', 0),
(87, '26532072', 'LUNA', 'ANIBAL', '1', 0),
(88, '22722391', 'RODRIGUEZ', 'DENNYS', '1', 0),
(89, '21050078', 'D?ARTHENAY ', 'CARLOS', '1', 0),
(90, '20140012', 'RODRIGUEZ', 'ANTHONY', '1', 0),
(91, '18652530', 'RONDON', 'JESUS', '1', 0),
(92, '30340898', 'HERNANDEZ', 'MIGUEL', '1', 0),
(93, '32051041', 'RODRIGUEZ', 'JORGE', '1', 0),
(94, '16176887', 'MARCANO', 'COLUMBA', '1', 0),
(95, '30274774', 'GIL', 'ADELIANNY', '1', 0),
(96, '16174078', 'CHACON', 'JOSE', '1', 0),
(97, '24864537', 'HERNANDEZ', 'MOISES', '1', 0),
(98, '28216052', 'ANTUAREZ', 'GABRIEL', '1', 0),
(99, '14423623', 'SUAREZ', 'MARIANGELA', '1', 0),
(100, '25909211', 'BOLIVAR', 'YENFRINSO', '1', 0),
(101, '27001065', 'RODRIGUEZ', 'JOEL', '1', 0),
(102, '31649963', 'SALAZAR', 'MANUEL', '1', 0),
(103, '19875984', 'BLANCO', 'ALEJANDRO', '1', 0),
(104, '31532286', 'GUERRA', 'ALFREDO', '1', 0),
(105, '30564549', 'BELISARIO', 'DANIELA', '1', 0),
(106, '25049902', 'SCHOLTZ', 'GERALD', '1', 0),
(107, '29974593', 'BRITO', 'ANGELICA', '1', 0),
(108, '26517350', 'RODRIGUEZ', 'STHEFANI', '1', 0),
(109, '28366574', 'GUZMAN', 'CARELYS', '1', 0),
(110, '20919843', 'COLINA', 'BRYAN', '1', 0),
(111, '31419072', 'CARRABS', 'GERARDO', '1', 0),
(112, '30776375', 'PALACIOS', 'JESUS', '1', 0),
(113, '21123356', 'RAMOS', 'CARLOS', '1', 0),
(114, '31532416', 'SANCLER', 'NICOLE', '1', 0),
(115, '25612658', 'RAMIREZ', 'ROSMARIANT', '1', 0),
(116, '17933428', 'DIAZ', 'NORELIS', '1', 0),
(117, '20918219', 'RODRIGUEZ', 'ANGEL', '1', 0),
(118, '29700203', 'VALLENILLA', 'JOSE', '1', 0),
(119, '21689435', 'HERNANDEZ', 'LEANDRO', '1', 0),
(120, '31733641', 'RAMOS', 'LUIS', '1', 0),
(121, '28274888', 'BASILE ', 'RINO', '1', 0),
(122, '31675876', 'CAMACHO', 'MIGUEL', '1', 0),
(123, '26695018', 'SANTA ROSA ', 'EDINSON', '1', 0),
(124, '27559508', 'IDROGO BRITO', 'ERWIN', '1', 0),
(125, '30117905', 'CONTRERAS', 'FERNANDO', '1', 0),
(126, '12538556', 'HERRERA ', 'ARISTIDES', '1', 0),
(127, '29549086', 'ZARAGOZA', 'JOSE', '1', 0),
(128, '25026142', 'SALAZAR', 'JOSE', '1', 0),
(129, '26650214', 'PEREZ', 'LUIS', '1', 0),
(130, '25282878', 'CEDE?O', 'CARLOS', '1', 0),
(131, '25452974', 'CORTEZ', 'DANIEL', '1', 0),
(132, '27325306', 'AGUILAR', 'IVAN', '1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_existencia_lotes_productos`
--

CREATE TABLE `entrada_existencia_lotes_productos` (
  `id` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_accounts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fallas_despachador`
--

CREATE TABLE `fallas_despachador` (
  `id` bigint(20) NOT NULL,
  `despachador` int(11) NOT NULL,
  `id_pedido_d_r_e` bigint(20) NOT NULL,
  `motivo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `id` int(11) NOT NULL,
  `descripcion_lote` text NOT NULL,
  `art` bigint(20) NOT NULL,
  `fecha_venc` date NOT NULL,
  `existencia_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas_rechequeadoras`
--

CREATE TABLE `mesas_rechequeadoras` (
  `id` int(11) NOT NULL,
  `num_mesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mesas_rechequeadoras`
--

INSERT INTO `mesas_rechequeadoras` (`id`, `num_mesa`) VALUES
(2, 1),
(3, 2),
(4, 3),
(5, 4),
(6, 5),
(7, 6),
(8, 7),
(9, 8),
(10, 9),
(11, 10),
(12, 11),
(13, 12),
(14, 13),
(15, 14),
(16, 15),
(17, 16),
(18, 17),
(19, 18),
(20, 19),
(21, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_fallas`
--

CREATE TABLE `motivo_fallas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `motivo_fallas`
--

INSERT INTO `motivo_fallas` (`id`, `descripcion`) VALUES
(1, 'Faltante'),
(2, 'Sobrante'),
(3, 'Invertido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pareja_rechequeadores_embaladores`
--

CREATE TABLE `pareja_rechequeadores_embaladores` (
  `id` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_rechequeador` int(11) DEFAULT NULL,
  `id_embalador` int(11) DEFAULT NULL,
  `turno` enum('1','2') NOT NULL COMMENT '1-Mañana,2-Tarde'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pareja_rechequeadores_embaladores`
--

INSERT INTO `pareja_rechequeadores_embaladores` (`id`, `id_mesa`, `id_rechequeador`, `id_embalador`, `turno`) VALUES
(21, 2, NULL, NULL, '1'),
(22, 3, NULL, NULL, '1'),
(23, 4, NULL, NULL, '1'),
(24, 5, NULL, NULL, '1'),
(25, 6, NULL, NULL, '1'),
(26, 7, NULL, NULL, '1'),
(27, 8, NULL, NULL, '1'),
(28, 9, NULL, NULL, '1'),
(29, 10, NULL, NULL, '1'),
(30, 11, NULL, NULL, '1'),
(31, 12, NULL, NULL, '1'),
(32, 13, NULL, NULL, '1'),
(33, 14, NULL, NULL, '1'),
(34, 15, NULL, NULL, '1'),
(35, 16, NULL, NULL, '1'),
(36, 17, NULL, NULL, '1'),
(37, 18, NULL, NULL, '1'),
(38, 19, NULL, NULL, '1'),
(39, 20, NULL, NULL, '1'),
(40, 21, NULL, NULL, '1'),
(41, 2, NULL, NULL, '2'),
(42, 3, NULL, NULL, '2'),
(43, 4, NULL, NULL, '2'),
(44, 5, NULL, NULL, '2'),
(45, 6, NULL, NULL, '2'),
(46, 7, NULL, NULL, '2'),
(47, 8, NULL, NULL, '2'),
(48, 9, NULL, NULL, '2'),
(49, 10, NULL, NULL, '2'),
(50, 11, NULL, NULL, '2'),
(51, 12, NULL, NULL, '2'),
(52, 13, NULL, NULL, '2'),
(53, 14, NULL, NULL, '2'),
(54, 15, NULL, NULL, '2'),
(55, 16, NULL, NULL, '2'),
(56, 17, NULL, NULL, '2'),
(57, 18, NULL, NULL, '2'),
(58, 19, NULL, NULL, '2'),
(59, 20, NULL, NULL, '2'),
(60, 21, NULL, NULL, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` bigint(20) NOT NULL,
  `numero_pedido` varchar(100) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad_unidades` int(11) NOT NULL,
  `distribuidor_pedidos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_d_r_e`
--

CREATE TABLE `pedidos_d_r_e` (
  `id` bigint(20) NOT NULL,
  `id_pedido` bigint(20) NOT NULL,
  `id_despachador` int(11) NOT NULL,
  `id_rechequeador` int(11) DEFAULT NULL,
  `id_embalador` int(11) DEFAULT NULL,
  `fecha_rechequeado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegios`
--

CREATE TABLE `privilegios` (
  `id` int(11) NOT NULL,
  `accion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `privilegios`
--

INSERT INTO `privilegios` (`id`, `accion`) VALUES
(23, 'asignar_mesa'),
(5, 'consultar_pedido'),
(12, 'eliminar_fallas_pedido'),
(4, 'eliminar_pedido'),
(21, 'modificar_cuenta_sistema'),
(20, 'modificar_empleado'),
(3, 'modificar_pedido'),
(18, 'pedidos_por_despachador'),
(17, 'pedidos_por_fecha'),
(13, 'rechequear'),
(7, 'registar_lote'),
(6, 'registrar_articulo'),
(14, 'registrar_cuenta_sistema'),
(2, 'registrar_empleado'),
(8, 'registrar_entrada_articulo'),
(11, 'registrar_fallas_pedido'),
(1, 'registrar_pedido'),
(15, 'registrar_ruta'),
(9, 'registrar_salida_articulo'),
(10, 'registrar_salida_excepcional_articulos'),
(16, 'visualizar_estadisticas'),
(19, 'visualizar_estadisticas_fallas_despachador'),
(22, 'visualizar_total_pedidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Super'),
(2, 'Supervisor de almacen'),
(3, 'Supervisor de inventario'),
(4, 'Rechequeador'),
(5, 'Inventario'),
(6, 'Entrega de pedidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_privilegios`
--

CREATE TABLE `roles_privilegios` (
  `id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_privilegio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles_privilegios`
--

INSERT INTO `roles_privilegios` (`id`, `id_role`, `id_privilegio`) VALUES
(1, 3, 14),
(2, 3, 9),
(3, 3, 10),
(4, 3, 7),
(5, 3, 8),
(6, 3, 6),
(7, 5, 6),
(8, 5, 7),
(9, 5, 8),
(10, 5, 9),
(11, 6, 2),
(12, 6, 1),
(13, 6, 3),
(14, 6, 4),
(15, 6, 5),
(16, 4, 13),
(17, 4, 11),
(18, 4, 12),
(19, 2, 14),
(20, 2, 15),
(21, 2, 16),
(22, 2, 17),
(25, 2, 2),
(26, 2, 18),
(27, 2, 19),
(28, 1, 1),
(29, 1, 2),
(30, 1, 3),
(31, 1, 4),
(32, 1, 5),
(33, 1, 6),
(34, 1, 7),
(35, 1, 8),
(36, 1, 9),
(37, 1, 10),
(38, 1, 11),
(39, 1, 12),
(40, 1, 13),
(41, 1, 14),
(42, 1, 15),
(43, 1, 17),
(44, 1, 18),
(45, 1, 19),
(46, 1, 16),
(47, 2, 13),
(48, 1, 20),
(49, 2, 20),
(50, 3, 20),
(51, 6, 20),
(52, 1, 21),
(53, 2, 21),
(54, 3, 21),
(55, 1, 22),
(56, 1, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`id`, `name`) VALUES
(5, 'ACHAGUAS'),
(6, 'AGUASAY'),
(7, 'AMAZONAS'),
(8, 'ANACO'),
(9, 'APURE'),
(10, 'ARAGUA DE BARCELONA'),
(11, 'BARCELONA'),
(12, 'BARINAS'),
(13, 'BARQUISIMETO'),
(14, 'BARRANCAS'),
(15, 'BOCA DE UCHIRE'),
(16, 'BOLIVAR'),
(17, 'CAICARA'),
(18, 'CALABOZO'),
(19, 'CALLAO'),
(20, 'CAMAGUAN'),
(21, 'CANTAURA'),
(22, 'CARABOBO'),
(23, 'CARIACO'),
(24, 'CARIPE'),
(25, 'CARIPITO'),
(26, 'CARUPANO'),
(27, 'CASANAY'),
(28, 'CAUCAGUA'),
(29, 'CHAGUARAMAS'),
(30, 'CIUDAD BOLIVAR'),
(31, 'CIUDAD PIAR'),
(32, 'CLARINES'),
(33, 'COJEDES'),
(34, 'CUMANA'),
(35, 'DISTRITO CAPITAL'),
(36, 'EL CHAPARRO'),
(37, 'EL DORADO'),
(38, 'EL FURRIAL'),
(39, 'EL MANTECO'),
(40, 'EL PALMAR'),
(41, 'EL SOCORRO'),
(42, 'EL SOMBRERO'),
(43, 'EL TEJERO'),
(44, 'EL TIGRE'),
(45, 'FALCON'),
(46, 'GUARENAS'),
(47, 'GUASIPATI'),
(48, 'GUATIRE'),
(49, 'JUSEPIN'),
(50, 'LA GUAIRA'),
(51, 'LA TOSCANA'),
(52, 'LAS CLARITAS'),
(53, 'LECHERIAS'),
(54, 'MARACAY'),
(55, 'MARGARITA'),
(56, 'MATURIN'),
(57, 'MERCEDES DEL LLANO'),
(58, 'MERIDA'),
(59, 'MIRANDA'),
(60, 'PARIAGUAN'),
(61, 'PORTUGUESA'),
(62, 'PUERTO CABELLO'),
(63, 'PUERTO LA CRUZ'),
(64, 'PUERTO ORDAZ'),
(65, 'PUERTO PIRITU'),
(66, 'PUNTA DE MATA'),
(67, 'SAN ANTONIO'),
(68, 'SAN FELIX'),
(69, 'SANTA BARBARA'),
(70, 'SANTA ELENA DE UAIREN'),
(71, 'TACHIRA'),
(72, 'TEMBLADOR'),
(73, 'TIGRITO'),
(74, 'TUCUPIDO'),
(75, 'TUCUPITA'),
(76, 'TUMEREMO'),
(77, 'UPATA'),
(78, 'URACOA'),
(79, 'VALENCIA'),
(80, 'VALLE DE LA PASCUA'),
(81, 'YARACUY'),
(82, 'ZARAZA'),
(83, 'ZULIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_excepcional_articulos`
--

CREATE TABLE `salida_excepcional_articulos` (
  `id` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `id_accounts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_existencia_lotes_productos`
--

CREATE TABLE `salida_existencia_lotes_productos` (
  `id` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_accounts` int(11) NOT NULL,
  `pasillero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id_account`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `role_id` (`role_id`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`art`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departamento` (`departamento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD KEY `departamento` (`departamento`);

--
-- Indices de la tabla `entrada_existencia_lotes_productos`
--
ALTER TABLE `entrada_existencia_lotes_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_accounts` (`id_accounts`);

--
-- Indices de la tabla `fallas_despachador`
--
ALTER TABLE `fallas_despachador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motivo` (`motivo`),
  ADD KEY `id_pedido_d_r_e` (`id_pedido_d_r_e`),
  ADD KEY `despachador` (`despachador`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `art` (`art`);

--
-- Indices de la tabla `mesas_rechequeadoras`
--
ALTER TABLE `mesas_rechequeadoras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_mesa` (`num_mesa`);

--
-- Indices de la tabla `motivo_fallas`
--
ALTER TABLE `motivo_fallas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pareja_rechequeadores_embaladores`
--
ALTER TABLE `pareja_rechequeadores_embaladores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_rechequeador` (`id_rechequeador`),
  ADD KEY `id_embalador` (`id_embalador`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD UNIQUE KEY `numero_pedido` (`numero_pedido`),
  ADD KEY `id_ruta` (`id_ruta`),
  ADD KEY `distribuidor_pedidos` (`distribuidor_pedidos`);

--
-- Indices de la tabla `pedidos_d_r_e`
--
ALTER TABLE `pedidos_d_r_e`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_despachador` (`id_despachador`),
  ADD KEY `id_rechequeador` (`id_rechequeador`),
  ADD KEY `id_embalador` (`id_embalador`);

--
-- Indices de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accion` (`accion`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles_privilegios`
--
ALTER TABLE `roles_privilegios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_priveilegio` (`id_privilegio`),
  ADD KEY `id_role` (`id_role`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `salida_excepcional_articulos`
--
ALTER TABLE `salida_excepcional_articulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_accounts` (`id_accounts`);

--
-- Indices de la tabla `salida_existencia_lotes_productos`
--
ALTER TABLE `salida_existencia_lotes_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_accounts` (`id_accounts`),
  ADD KEY `pasillero` (`pasillero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `art` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `entrada_existencia_lotes_productos`
--
ALTER TABLE `entrada_existencia_lotes_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fallas_despachador`
--
ALTER TABLE `fallas_despachador`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mesas_rechequeadoras`
--
ALTER TABLE `mesas_rechequeadoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `motivo_fallas`
--
ALTER TABLE `motivo_fallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pareja_rechequeadores_embaladores`
--
ALTER TABLE `pareja_rechequeadores_embaladores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `pedidos_d_r_e`
--
ALTER TABLE `pedidos_d_r_e`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles_privilegios`
--
ALTER TABLE `roles_privilegios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `salida_excepcional_articulos`
--
ALTER TABLE `salida_excepcional_articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salida_existencia_lotes_productos`
--
ALTER TABLE `salida_existencia_lotes_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `entrada_existencia_lotes_productos`
--
ALTER TABLE `entrada_existencia_lotes_productos`
  ADD CONSTRAINT `entrada_existencia_lotes_productos_ibfk_1` FOREIGN KEY (`id_accounts`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `entrada_existencia_lotes_productos_ibfk_2` FOREIGN KEY (`id_lote`) REFERENCES `lotes` (`id`);

--
-- Filtros para la tabla `fallas_despachador`
--
ALTER TABLE `fallas_despachador`
  ADD CONSTRAINT `fallas_despachador_ibfk_1` FOREIGN KEY (`motivo`) REFERENCES `motivo_fallas` (`id`),
  ADD CONSTRAINT `fallas_despachador_ibfk_2` FOREIGN KEY (`despachador`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `fallas_despachador_ibfk_3` FOREIGN KEY (`id_pedido_d_r_e`) REFERENCES `pedidos_d_r_e` (`id`);

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `lotes_ibfk_1` FOREIGN KEY (`art`) REFERENCES `articulos` (`art`);

--
-- Filtros para la tabla `pareja_rechequeadores_embaladores`
--
ALTER TABLE `pareja_rechequeadores_embaladores`
  ADD CONSTRAINT `pareja_rechequeadores_embaladores_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesas_rechequeadoras` (`id`),
  ADD CONSTRAINT `pareja_rechequeadores_embaladores_ibfk_2` FOREIGN KEY (`id_rechequeador`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `pareja_rechequeadores_embaladores_ibfk_3` FOREIGN KEY (`id_embalador`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_5` FOREIGN KEY (`distribuidor_pedidos`) REFERENCES `accounts` (`id_account`);

--
-- Filtros para la tabla `pedidos_d_r_e`
--
ALTER TABLE `pedidos_d_r_e`
  ADD CONSTRAINT `pedidos_d_r_e_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `pedidos_d_r_e_ibfk_2` FOREIGN KEY (`id_despachador`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `pedidos_d_r_e_ibfk_3` FOREIGN KEY (`id_rechequeador`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `pedidos_d_r_e_ibfk_4` FOREIGN KEY (`id_embalador`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `roles_privilegios`
--
ALTER TABLE `roles_privilegios`
  ADD CONSTRAINT `roles_privilegios_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `roles_privilegios_ibfk_2` FOREIGN KEY (`id_privilegio`) REFERENCES `privilegios` (`id`);

--
-- Filtros para la tabla `salida_excepcional_articulos`
--
ALTER TABLE `salida_excepcional_articulos`
  ADD CONSTRAINT `salida_excepcional_articulos_ibfk_1` FOREIGN KEY (`id_lote`) REFERENCES `lotes` (`id`);

--
-- Filtros para la tabla `salida_existencia_lotes_productos`
--
ALTER TABLE `salida_existencia_lotes_productos`
  ADD CONSTRAINT `salida_existencia_lotes_productos_ibfk_1` FOREIGN KEY (`id_accounts`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `salida_existencia_lotes_productos_ibfk_2` FOREIGN KEY (`id_lote`) REFERENCES `lotes` (`id`),
  ADD CONSTRAINT `salida_existencia_lotes_productos_ibfk_3` FOREIGN KEY (`pasillero`) REFERENCES `empleados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
