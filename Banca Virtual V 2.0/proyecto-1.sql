-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2015 at 06:01 PM
-- Server version: 5.6.24-0ubuntu2
-- PHP Version: 5.6.4-4ubuntu6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `proyecto`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `aprobarPrestamo`(id int,  saldo float)
begin
insert into prestamos (saldo, fechaAprobacion, idCliente) values (saldo, now(), id); 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `aprobarServicio`(id int, valor float,concepto varchar (40),fechaLimite date)
begin
insert into servicios(concepto, fechaLimite,valor,idcliente) values ( concepto, fechaLimite,valor,id); 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `aprobarTarjeta`(id int,  cupo float)
begin
insert into tarjeta (cupo, idCliente) values ( cupo, id); 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cambiarClave2`(id int,  clave varchar(40))
begin
update cliente set claveInternet = clave where idCliente = id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarCliente`(in nombre varchar (40), in apellido varchar(40), in clave1 varchar(40), in claveInternet varchar(40),
in email varchar(40), in idPregunta1 integer, in respuesta1In varchar(40), in idPregunta2 integer, in respuesta2In varchar(40))
begin
insert into cliente (nombre, apellido, clave1, claveInternet,email) values (nombre, apellido, clave1,claveInternet,email);
insert into restablecer (pregunta1, respuesta1,pregunta2, respuesta2) values (idPregunta1,respuesta1In,idPregunta2,respuesta2In);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarCuenta`(in tipo varchar(20), in titular varchar(40), in clienteId int)
begin
declare a integer;
insert into cuenta(saldo, tipo, titular) values (0, tipo, titular);
select numeroCuenta into a from cuenta order by numeroCuenta desc limit 1 ;
insert into cuenta_cliente (idCliente, numeroCuenta) values (clienteId,a);  
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logCuenta`(in numeroCuenta integer, in concepto varchar (50), in saldoAnterior float , in monto float, in cuentaDestino integer)
Begin
insert into logCuenta(numeroCuenta,concepto,saldoAnterior,monto,cuentaOrigen,cuentaDestino)values(numeroCuenta,concepto,saldoAnterior,monto,numeroCuenta,cuentaDestino);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pagarPrestamo`( in idPrestamo integer, in fuente varchar(25), in idFuente integer, in montoPago float)
Begin


declare saldoA float;
select saldo into saldoA from cuenta where numeroCuenta=idFuente;
update prestamos set saldo = saldo - montoPago where prestamos.idprestamos = idPrestamo;

if fuente = "cuenta" then 
call logCuenta(idFuente,"Pago Prestamo",saldoA,montoPago,idprestamo);
update cuenta set saldo = saldo - montoPago where numeroCuenta = idFuente;
else
update tarjeta set saldo = saldo + montoPago where idtarjeta = idFuente;
end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pagarServicio`(in idServicio integer, in fuente varchar(25), in idFuente integer)
Begin

declare a float;
declare saldoA float;
select servicios.valor into a from servicios where servicios.idservicios = idServicio;
select saldo into saldoA from cuenta where numeroCuenta=idFuente;
update servicios set valor = 0 where servicios.idservicios = idServicio;

if fuente = "cuenta" then 
call logCuenta(idFuente,"Pago servicios",saldoA,a,idServicio);
update cuenta set saldo = saldo - a where numeroCuenta = idFuente;
else
update tarjeta set saldo = saldo + a where idtarjeta = idFuente;
end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pagarTarjeta`(in idTarjeta integer, in fuente varchar(25), in idFuente integer, in montoPago float)
Begin

declare a float;
declare saldoA float;
select saldo into saldoA from cuenta where numeroCuenta=idFuente;
update tarjeta set saldo = saldo - montoPago where tarjeta.idtarjeta = idTarjeta;
if fuente = "cuenta" then 
call logCuenta(idFuente,"Pago Tarjeta",saldoA,montoPago,idTarjeta);
update cuenta set saldo = saldo - montoPago where numeroCuenta = idFuente;
else
update tarjeta set saldo = saldo + montoPago where idtarjeta = idFuente;
end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `transferencia`(in cuentaOrigen integer, in cuentaDestino integer, in monto float)
Begin
declare saldoA float;
declare saldoB float;
select saldo into saldoA from cuenta where numeroCuenta=cuentaOrigen;

select saldo into saldoB from cuenta where numeroCuenta=cuentaDestino;
insert into logCuenta(numeroCuenta,concepto,saldoAnterior,monto,cuentaOrigen,cuentaDestino)values(cuentaOrigen,"Tranferencia",saldoA,monto,cuentaOrigen,cuentaDestino);
insert into logCuenta(numeroCuenta,concepto,saldoAnterior,monto,cuentaOrigen,cuentaDestino)values(cuentaDestino,"Tranferencia",saldoB,monto,cuentaOrigen,cuentaDestino);
update cuenta set saldo = saldo - monto where numeroCuenta = cuentaOrigen;
update cuenta set saldo = saldo + monto where numeroCuenta = cuentaDestino;

end$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `recuperarTransferencia`(idUsuario integer, nuevaClave varchar (50), respuestaIn1 varchar (50), respuestaIn2 varchar (50)) RETURNS tinyint(1)
Begin

declare r boolean default false;
declare a integer;
set a = 0;
select count(*) into a from restablecer where idcliente = idUsuario and respuestaIn1 = respuesta1 and respuestaIn2 = respuesta2;
if a = 1 then
set r = true;
update cliente set clave1 = nuevaClave where idcliente = idUsuario;

end if; 
return r;




end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `verificarClave`(id int,  clave varchar(40)) RETURNS tinyint(1)
begin
declare r boolean default false;
declare a integer;
set a = 0;
select count(*) into a from cliente where idCliente = id and clave1 = clave;
if a>0 then
set r = true;
end if; 
return r;

end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `verificarClave1`(id int,  clave varchar(40)) RETURNS tinyint(1)
begin
declare r boolean default false;
declare a integer;
set a = 0;
select count(*) into a from cliente where idCliente = id and clave1 = clave;
if a>0 then
set r = true;
end if; 
return r;

end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `verificarClave2`(id int,  clave varchar(40)) RETURNS tinyint(1)
begin
declare r boolean default false;
declare a integer;
set a = 0;
select count(*) into a from cliente where idCliente = id and claveInternet = clave;
if a>0 then
set r = true;
end if; 
return r;

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
`idcliente` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `clave1` varchar(20) NOT NULL,
  `claveInternet` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombre`, `apellido`, `clave1`, `claveInternet`, `email`) VALUES
(1, 'York', 'Gutierrez', 'frbs1996', 'soloJunior', 'frbs1996@gmail.com'),
(2, 'Sergio', 'Romero', '1qa2w3ed', '1234', 'sergiorom92@gmail.com'),
(3, 'mario', 'ortega', 'mario123', '1234', 'mario@gmail.com'),
(4, 'admin', 'istrador', '1qa2w3ed', '1qa2w3ed', 'admin@identy.com'),
(5, 'Juan David', 'Coronado Duzanpta', '12345', 'lol', '234567uhgf');

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE IF NOT EXISTS `cuenta` (
`numeroCuenta` int(11) NOT NULL,
  `saldo` float NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `titular` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuenta`
--

INSERT INTO `cuenta` (`numeroCuenta`, `saldo`, `tipo`, `titular`, `activo`) VALUES
(1, 41001, 'Ahorros', 'York Gutierrez', 0),
(2, 0, 'Ahorros', 'Sergio Romero', 0),
(4, 38559400, 'Cuenta ahorros', 'Sergio David Romero', 0),
(5, -260000, 'Cuenta corriente', 'Sergio David Romero', 1),
(6, 0, 'Cuenta ahorros', 'Sergio David Romero', 0),
(7, 0, 'Cuenta corriente', 'York Gutierrez', 1),
(8, 0, 'Cuenta corriente', 'sergio', 1),
(9, 0, 'Cuenta ahorros', 'Mario ', 0),
(10, 0, 'Cuenta ahorros', 'Gaytorade', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuenta_cliente`
--

CREATE TABLE IF NOT EXISTS `cuenta_cliente` (
  `idcliente` int(11) NOT NULL,
  `numeroCuenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuenta_cliente`
--

INSERT INTO `cuenta_cliente` (`idcliente`, `numeroCuenta`) VALUES
(1, 1),
(1, 2),
(2, 4),
(3, 5),
(3, 6),
(3, 7),
(2, 8),
(2, 9),
(3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `logCuenta`
--

CREATE TABLE IF NOT EXISTS `logCuenta` (
`idlogCuenta` int(11) NOT NULL,
  `numeroCuenta` int(11) NOT NULL,
  `concepto` varchar(50) DEFAULT NULL,
  `saldoAnterior` float NOT NULL,
  `monto` float NOT NULL,
  `cuentaOrigen` int(11) NOT NULL,
  `cuentaDestino` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logCuenta`
--

INSERT INTO `logCuenta` (`idlogCuenta`, `numeroCuenta`, `concepto`, `saldoAnterior`, `monto`, `cuentaOrigen`, `cuentaDestino`) VALUES
(1, 4, '', 9700, 2000, 4, 2),
(2, 4, '', 7700, 1500, 4, 3),
(3, 4, 'Pago servicios', 6200, 1200, 4, 4),
(4, 4, 'Pago Tarjeta', 3500, 1100, 4, 2),
(5, 4, 'Pago Tarjeta', 3900, 100, 4, 2),
(6, 4, 'Pago Tarjeta', 3800, 2300, 4, 2),
(7, 4, 'Pago Prestamo', 40000000, 12000, 4, 2),
(8, 4, 'Tranferencia', 39988000, 1, 4, 1),
(9, 1, 'Tranferencia', 31000, 1, 4, 1),
(10, 4, 'Tranferencia', 39988000, 10000, 4, 1),
(11, 1, 'Tranferencia', 31001, 10000, 4, 1),
(12, 5, 'Pago Prestamo', 0, 10000, 5, 3),
(13, 5, 'Pago Tarjeta', -10000, 20000, 5, 5),
(14, 5, 'Pago Prestamo', -30000, 20000, 5, 4),
(15, 5, 'Pago Prestamo', -50000, 30000, 5, 4),
(16, 5, 'Pago Prestamo', -80000, 30000, 5, 4),
(17, 5, 'Pago servicios', -110000, 150000, 5, 5),
(18, 4, 'Pago servicios', 39978000, 1234570, 4, 6),
(19, 4, 'Pago servicios', 38743400, 0, 4, 6),
(20, 4, 'Pago servicios', 38743400, 0, 4, 6),
(21, 4, 'Pago servicios', 38743400, 0, 4, 6),
(22, 4, 'Pago servicios', 38743400, 0, 4, 6),
(23, 4, 'Pago servicios', 38743400, 0, 4, 6),
(24, 4, 'Pago servicios', 38743400, 50000, 4, 8),
(25, 4, 'Pago servicios', 38693400, 0, 4, 6),
(26, 4, 'Pago servicios', 38693400, 0, 4, 6),
(27, 4, 'Pago servicios', 38693400, 0, 4, 6),
(28, 4, 'Pago servicios', 38693400, 0, 4, 6),
(29, 4, 'Pago servicios', 38693400, 0, 4, 8),
(30, 4, 'Pago servicios', 38693400, 34000, 4, 10),
(31, 4, 'Pago servicios', 38659400, 0, 4, 9),
(32, 4, 'Pago servicios', 38659400, 0, 4, 10),
(33, 4, 'Pago Prestamo', 38659400, 50000, 4, 6),
(34, 4, 'Pago Prestamo', 38609400, 50000, 4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `logPrestamos`
--

CREATE TABLE IF NOT EXISTS `logPrestamos` (
`idlogPrestamos` int(11) NOT NULL,
  `monto` float NOT NULL,
  `saldoAnterior` float NOT NULL,
  `fecha` date NOT NULL,
  `idprestamos` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logPrestamos`
--

INSERT INTO `logPrestamos` (`idlogPrestamos`, `monto`, `saldoAnterior`, `fecha`, `idprestamos`) VALUES
(1, 600, 1000, '2015-05-07', 1),
(2, 300, 400, '2015-05-07', 1),
(3, 12000, 40000, '2015-05-07', 2),
(4, 10000, 20000, '2015-05-11', 3),
(5, 20000, 80000, '2015-05-11', 4),
(6, 30000, 60000, '2015-05-11', 4),
(7, 30000, 30000, '2015-05-11', 4),
(8, 10000, 70000, '2015-05-11', 6),
(9, 1234, 60000, '2015-05-11', 6),
(10, 58766, 58766, '2015-05-11', 6),
(11, 50000, 0, '2015-05-11', 6),
(12, 50000, 55000, '2015-05-11', 7),
(13, 5000, 5000, '2015-05-11', 7);

-- --------------------------------------------------------

--
-- Table structure for table `logServicios`
--

CREATE TABLE IF NOT EXISTS `logServicios` (
`idlogServicios` int(11) NOT NULL,
  `monto` float NOT NULL,
  `idservicios` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logServicios`
--

INSERT INTO `logServicios` (`idlogServicios`, `monto`, `idservicios`, `fecha`) VALUES
(1, 45000, 1, '0000-00-00'),
(2, 50000, 1, '0000-00-00'),
(3, 2000, 2, '0000-00-00'),
(4, 1500, 3, '0000-00-00'),
(5, 1200, 4, '0000-00-00'),
(6, 150000, 5, '0000-00-00'),
(7, 1234570, 6, '0000-00-00'),
(8, 0, 6, '0000-00-00'),
(9, 0, 6, '0000-00-00'),
(10, 0, 6, '0000-00-00'),
(11, 0, 6, '0000-00-00'),
(12, 0, 6, '0000-00-00'),
(13, 0, 6, '0000-00-00'),
(14, 0, 6, '0000-00-00'),
(15, 0, 6, '0000-00-00'),
(16, 0, 6, '0000-00-00'),
(17, 50000, 8, '0000-00-00'),
(18, 0, 6, '0000-00-00'),
(19, 0, 6, '0000-00-00'),
(20, 0, 6, '0000-00-00'),
(21, 0, 6, '0000-00-00'),
(22, 0, 6, '0000-00-00'),
(23, 0, 6, '0000-00-00'),
(24, 45000, 9, '0000-00-00'),
(25, 1234, 7, '0000-00-00'),
(26, 0, 8, '0000-00-00'),
(27, 34000, 10, '0000-00-00'),
(28, 0, 9, '0000-00-00'),
(29, 0, 10, '0000-00-00'),
(30, 0, 6, '0000-00-00'),
(31, 0, 6, '0000-00-00'),
(32, 45000, 11, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `logTarjeta`
--

CREATE TABLE IF NOT EXISTS `logTarjeta` (
`idlogTarjeta` int(11) NOT NULL,
  `saldoAnterior` float NOT NULL,
  `monto` float NOT NULL,
  `fecha` date NOT NULL,
  `idtarjeta` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logTarjeta`
--

INSERT INTO `logTarjeta` (`idlogTarjeta`, `saldoAnterior`, `monto`, `fecha`, `idtarjeta`) VALUES
(1, 0, -20000, '2015-05-07', 1),
(2, 20000, 20000, '2015-05-07', 1),
(3, 0, -3500, '2015-05-07', 2),
(4, 3500, 1100, '2015-05-07', 2),
(5, 2400, 100, '2015-05-07', 2),
(6, 2300, 2300, '2015-05-07', 2),
(7, 0, 20000, '2015-05-11', 5),
(8, 0, -10000, '2015-05-11', 8),
(9, 0, 0, '2015-05-11', 9),
(10, 10000, 0, '2015-05-11', 8),
(11, 10000, 0, '2015-05-11', 8),
(12, 10000, 0, '2015-05-11', 8),
(13, 10000, 0, '2015-05-11', 8),
(14, 10000, 0, '2015-05-11', 8),
(15, 10000, -45000, '2015-05-11', 8),
(16, 0, -1234, '2015-05-11', 9),
(17, 1234, 0, '2015-05-11', 9),
(18, 55000, 0, '2015-05-11', 8),
(19, 0, -45000, '2015-05-11', 10),
(20, 55000, -1234, '2015-05-11', 8),
(21, 56234, -58766, '2015-05-11', 8),
(22, 0, -5000, '2015-05-11', 11);

-- --------------------------------------------------------

--
-- Table structure for table `preguntas`
--

CREATE TABLE IF NOT EXISTS `preguntas` (
`idpreguntas` int(11) NOT NULL,
  `pregunta` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preguntas`
--

INSERT INTO `preguntas` (`idpreguntas`, `pregunta`) VALUES
(1, '¿Cómo se llama su primer mascota?'),
(2, '¿Cómo se llama su primer perro?'),
(3, '¿Lugar de nacimiento de su madre?'),
(4, '¿Comida Favorita?');

-- --------------------------------------------------------

--
-- Table structure for table `prestamos`
--

CREATE TABLE IF NOT EXISTS `prestamos` (
`idprestamos` int(11) NOT NULL,
  `saldo` float NOT NULL,
  `fechaAprobacion` date NOT NULL,
  `idcliente` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prestamos`
--

INSERT INTO `prestamos` (`idprestamos`, `saldo`, `fechaAprobacion`, `idcliente`) VALUES
(1, 100, '2015-05-07', 1),
(2, 28000, '2015-05-07', 1),
(3, 10000, '2015-05-11', 3),
(4, 0, '2015-05-11', 3),
(5, 800000, '2015-05-11', 3),
(6, -50000, '2015-05-11', 2),
(7, 0, '2015-05-11', 2);

--
-- Triggers `prestamos`
--
DELIMITER //
CREATE TRIGGER `logPrestamos` AFTER UPDATE ON `prestamos`
 FOR EACH ROW begin
	insert into logPrestamos(monto,saldoAnterior,fecha,idprestamos)  values ((old.saldo-new.saldo),old.saldo,now(),old.idprestamos);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `restablecer`
--

CREATE TABLE IF NOT EXISTS `restablecer` (
`idcliente` int(11) NOT NULL,
  `pregunta1` int(11) NOT NULL,
  `respuesta1` varchar(45) DEFAULT NULL,
  `pregunta2` int(11) NOT NULL,
  `respuesta2` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restablecer`
--

INSERT INTO `restablecer` (`idcliente`, `pregunta1`, `respuesta1`, `pregunta2`, `respuesta2`) VALUES
(4, 1, '1', 1, '1'),
(5, 2, 'daniel', 1, 'ronald');

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE IF NOT EXISTS `servicios` (
`idservicios` int(11) NOT NULL,
  `concepto` varchar(45) NOT NULL,
  `fechaLimite` date NOT NULL,
  `valor` float NOT NULL,
  `idcliente` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `servicios`
--

INSERT INTO `servicios` (`idservicios`, `concepto`, `fechaLimite`, `valor`, `idcliente`) VALUES
(1, 'Luz', '2015-06-30', 0, 1),
(2, 'PayPal', '2016-10-12', 0, 1),
(3, 'PayPal2', '2016-10-13', 0, 1),
(4, 'PayPal3', '2016-10-13', 0, 1),
(5, 'Agua', '1016-03-02', 0, 3),
(6, '23456', '2015-01-01', 0, 2),
(7, 'paypal final', '2015-01-01', 0, 2),
(8, 'lalala', '2015-01-01', 0, 2),
(9, 'sergio mk no funciona', '2015-01-01', 0, 2),
(10, 'sergio loca', '2015-01-01', 0, 2),
(11, 'gaseosa', '2015-01-01', 0, 2),
(12, 'lslsdldk', '2015-01-01', 1500, 2);

--
-- Triggers `servicios`
--
DELIMITER //
CREATE TRIGGER `logServicios` AFTER UPDATE ON `servicios`
 FOR EACH ROW begin
	insert into logServicios(monto,idservicios)  values (old.valor,old.idservicios);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tarjeta`
--

CREATE TABLE IF NOT EXISTS `tarjeta` (
`idtarjeta` int(11) NOT NULL,
  `saldo` float NOT NULL,
  `cupo` float NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `idcliente` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tarjeta`
--

INSERT INTO `tarjeta` (`idtarjeta`, `saldo`, `cupo`, `activo`, `idcliente`) VALUES
(1, 0, 50000, 0, 1),
(2, 0, 40000, 0, 1),
(5, -20000, 5000000, 0, 3),
(6, 0, 90000000, 0, 3),
(7, 0, 500000, 0, 3),
(8, 115000, 70000, 0, 2),
(9, 1234, 20000, 0, 2),
(10, 45000, 45000, 0, 2),
(11, 5000, 55000, 0, 2),
(12, 0, 5000000, 0, 2);

--
-- Triggers `tarjeta`
--
DELIMITER //
CREATE TRIGGER `logTarjeta` AFTER UPDATE ON `tarjeta`
 FOR EACH ROW begin
	insert into logTarjeta(saldoAnterior,monto,fecha,idtarjeta)  values (old.saldo,(old.saldo-new.saldo),now(),old.idtarjeta);
end
//
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
 ADD PRIMARY KEY (`idcliente`);

--
-- Indexes for table `cuenta`
--
ALTER TABLE `cuenta`
 ADD PRIMARY KEY (`numeroCuenta`);

--
-- Indexes for table `cuenta_cliente`
--
ALTER TABLE `cuenta_cliente`
 ADD KEY `idcliente` (`idcliente`), ADD KEY `numeroCuenta` (`numeroCuenta`);

--
-- Indexes for table `logCuenta`
--
ALTER TABLE `logCuenta`
 ADD PRIMARY KEY (`idlogCuenta`), ADD KEY `numeroCuenta` (`numeroCuenta`);

--
-- Indexes for table `logPrestamos`
--
ALTER TABLE `logPrestamos`
 ADD PRIMARY KEY (`idlogPrestamos`), ADD KEY `idprestamos` (`idprestamos`);

--
-- Indexes for table `logServicios`
--
ALTER TABLE `logServicios`
 ADD PRIMARY KEY (`idlogServicios`), ADD KEY `idservicios` (`idservicios`);

--
-- Indexes for table `logTarjeta`
--
ALTER TABLE `logTarjeta`
 ADD PRIMARY KEY (`idlogTarjeta`), ADD KEY `idtarjeta` (`idtarjeta`);

--
-- Indexes for table `preguntas`
--
ALTER TABLE `preguntas`
 ADD PRIMARY KEY (`idpreguntas`);

--
-- Indexes for table `prestamos`
--
ALTER TABLE `prestamos`
 ADD PRIMARY KEY (`idprestamos`), ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `restablecer`
--
ALTER TABLE `restablecer`
 ADD PRIMARY KEY (`idcliente`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
 ADD PRIMARY KEY (`idservicios`), ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `tarjeta`
--
ALTER TABLE `tarjeta`
 ADD PRIMARY KEY (`idtarjeta`), ADD KEY `idcliente` (`idcliente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
MODIFY `numeroCuenta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `logCuenta`
--
ALTER TABLE `logCuenta`
MODIFY `idlogCuenta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `logPrestamos`
--
ALTER TABLE `logPrestamos`
MODIFY `idlogPrestamos` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `logServicios`
--
ALTER TABLE `logServicios`
MODIFY `idlogServicios` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `logTarjeta`
--
ALTER TABLE `logTarjeta`
MODIFY `idlogTarjeta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `preguntas`
--
ALTER TABLE `preguntas`
MODIFY `idpreguntas` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
MODIFY `idprestamos` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `restablecer`
--
ALTER TABLE `restablecer`
MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
MODIFY `idservicios` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tarjeta`
--
ALTER TABLE `tarjeta`
MODIFY `idtarjeta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cuenta_cliente`
--
ALTER TABLE `cuenta_cliente`
ADD CONSTRAINT `cuenta_cliente_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
ADD CONSTRAINT `cuenta_cliente_ibfk_2` FOREIGN KEY (`numeroCuenta`) REFERENCES `cuenta` (`numeroCuenta`);

--
-- Constraints for table `logCuenta`
--
ALTER TABLE `logCuenta`
ADD CONSTRAINT `logCuenta_ibfk_1` FOREIGN KEY (`numeroCuenta`) REFERENCES `cuenta` (`numeroCuenta`);

--
-- Constraints for table `logPrestamos`
--
ALTER TABLE `logPrestamos`
ADD CONSTRAINT `logPrestamos_ibfk_1` FOREIGN KEY (`idprestamos`) REFERENCES `prestamos` (`idprestamos`);

--
-- Constraints for table `logServicios`
--
ALTER TABLE `logServicios`
ADD CONSTRAINT `logServicios_ibfk_1` FOREIGN KEY (`idservicios`) REFERENCES `servicios` (`idservicios`);

--
-- Constraints for table `logTarjeta`
--
ALTER TABLE `logTarjeta`
ADD CONSTRAINT `logTarjeta_ibfk_1` FOREIGN KEY (`idtarjeta`) REFERENCES `tarjeta` (`idtarjeta`);

--
-- Constraints for table `prestamos`
--
ALTER TABLE `prestamos`
ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Constraints for table `servicios`
--
ALTER TABLE `servicios`
ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Constraints for table `tarjeta`
--
ALTER TABLE `tarjeta`
ADD CONSTRAINT `tarjeta_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
