-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: carrental
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','5c428d8875d2948607f3e3fe134d71b4','2024-05-01 12:22:38');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbooking`
--

DROP TABLE IF EXISTS `tblbooking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblbooking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BookingNumber` bigint(12) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `GuestName` varchar(120) DEFAULT NULL,
  `VehicleId` int(11) DEFAULT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbooking`
--

LOCK TABLES `tblbooking` WRITE;
/*!40000 ALTER TABLE `tblbooking` DISABLE KEYS */;
INSERT INTO `tblbooking` VALUES (2,364957087,'slowdsports@gmail.com',NULL,7,'2026-03-09','2026-03-11','klnkjln klkl kj kj j',2,'2026-03-09 03:03:40','2026-03-09 03:06:45'),(3,891231130,'slowdsports@gmail.com',NULL,7,'2026-03-24','2026-03-28','mmmmmmm',1,'2026-03-09 03:06:21','2026-03-09 03:06:58'),(4,343176834,'slowdsports@gmail.com',NULL,7,'2026-03-09','2026-03-12','abchb',0,'2026-03-09 03:17:15',NULL),(5,776010205,'resevayest@gmai.c.om','Rserva de Prueba',2,'2026-05-08','2026-05-08','abc',0,'2026-05-08 16:47:20',NULL);
/*!40000 ALTER TABLE `tblbooking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbrands`
--

DROP TABLE IF EXISTS `tblbrands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblbrands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BrandName` varchar(120) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbrands`
--

LOCK TABLES `tblbrands` WRITE;
/*!40000 ALTER TABLE `tblbrands` DISABLE KEYS */;
INSERT INTO `tblbrands` VALUES (1,'Kia','2024-05-01 16:24:34','2026-02-02 00:15:15'),(2,'Chery','2024-05-01 16:24:34','2026-02-02 00:46:56'),(3,'Suzuki','2024-05-01 16:24:34','2026-02-02 00:50:37'),(4,'Nissan','2024-05-01 16:24:34','2024-06-05 05:26:34'),(5,'Toyota','2024-05-01 16:24:34','2024-06-05 05:26:34'),(7,'Ford','2024-05-01 16:24:34','2026-02-02 01:04:25');
/*!40000 ALTER TABLE `tblbrands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcontactusinfo`
--

DROP TABLE IF EXISTS `tblcontactusinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcontactusinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Address` tinytext DEFAULT NULL,
  `EmailId` varchar(255) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcontactusinfo`
--

LOCK TABLES `tblcontactusinfo` WRITE;
/*!40000 ALTER TABLE `tblcontactusinfo` DISABLE KEYS */;
INSERT INTO `tblcontactusinfo` VALUES (1,'Aeropuerto Ramon Villeda Morales, San Pedro Sula, Cortes','service_destiny@icloud.com','97990336');
/*!40000 ALTER TABLE `tblcontactusinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcontactusquery`
--

DROP TABLE IF EXISTS `tblcontactusquery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcontactusquery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `ContactNumber` char(11) DEFAULT NULL,
  `Message` longtext DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcontactusquery`
--

LOCK TABLES `tblcontactusquery` WRITE;
/*!40000 ALTER TABLE `tblcontactusquery` DISABLE KEYS */;
INSERT INTO `tblcontactusquery` VALUES (1,'Kunal ','kunal@gmail.com','7977779798','I want to know you brach in Chandigarh?','2024-06-04 09:34:51',1);
/*!40000 ALTER TABLE `tblcontactusquery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpages`
--

DROP TABLE IF EXISTS `tblpages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PageName` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpages`
--

LOCK TABLES `tblpages` WRITE;
/*!40000 ALTER TABLE `tblpages` DISABLE KEYS */;
INSERT INTO `tblpages` VALUES (1,'Términos y Condiciones','terms','<P align=justify><FONT size=2><STRONG><FONT color=#990000>(1) ACCEPTANCE OF TERMS</FONT><BR><BR></STRONG>Welcome to Yahoo! India. 1Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: <A href=\"http://in.docs.yahoo.com/info/terms/\">http://in.docs.yahoo.com/info/terms/</A>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>\r\n<P align=justify><FONT size=2>Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </FONT><A href=\"http://in.docs.yahoo.com/info/terms/\"><FONT size=2>http://in.docs.yahoo.com/info/terms/</FONT></A><FONT size=2>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>\r\n<P align=justify><FONT size=2>Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </FONT><A href=\"http://in.docs.yahoo.com/info/terms/\"><FONT size=2>http://in.docs.yahoo.com/info/terms/</FONT></A><FONT size=2>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </FONT></P>'),(2,'Privacidad y Política','privacy','<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</span>'),(3,'Acerca de','aboutus','<span style=\"color: rgb(51, 51, 51); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13.3333px;\">We offer a varied fleet of cars, ranging from the compact. All our vehicles have air conditioning, &nbsp;power steering, electric windows. All our vehicles are bought and maintained at official dealerships only. Automatic transmission cars are available in every booking class.&nbsp;</span><span style=\"color: rgb(52, 52, 52); font-family: Arial, Helvetica, sans-serif;\">As we are not affiliated with any specific automaker, we are able to provide a variety of vehicle makes and models for customers to rent.</span><div><span style=\"color: rgb(62, 62, 62); font-family: &quot;Lucida Sans Unicode&quot;, &quot;Lucida Grande&quot;, sans-serif; font-size: 11px;\">ur mission is to be recognised as the global leader in Car Rental for companies and the public and private sector by partnering with our clients to provide the best and most efficient Cab Rental solutions and to achieve service excellence.</span><span style=\"color: rgb(52, 52, 52); font-family: Arial, Helvetica, sans-serif;\"><br></span></div>'),(11,'Preguntas Frecuentes','faqs','<p align=\"justify\" style=\"font-size: 14px;\"><font size=\"2\"><strong><font color=\"#990000\">(1) ACCEPTANCE OF TERMS</font><br><br></strong>Welcome to Yahoo! India. 1Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at:&nbsp;<a href=\"http://in.docs.yahoo.com/info/terms/\">http://in.docs.yahoo.com/info/terms/</a>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service.</font></p><p align=\"justify\" style=\"font-size: 14px;\"><font size=\"2\">Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at:&nbsp;</font><a href=\"http://in.docs.yahoo.com/info/terms/\"><font size=\"2\">http://in.docs.yahoo.com/info/terms/</font></a><font size=\"2\">. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service.</font></p><p align=\"justify\" style=\"font-size: 14px;\"><font size=\"2\">Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at:&nbsp;</font><a href=\"http://in.docs.yahoo.com/info/terms/\"><font size=\"2\">http://in.docs.yahoo.com/info/terms/</font></a><font size=\"2\">. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service.</font></p>');
/*!40000 ALTER TABLE `tblpages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsubscribers`
--

DROP TABLE IF EXISTS `tblsubscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsubscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SubscriberEmail` varchar(120) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsubscribers`
--

LOCK TABLES `tblsubscribers` WRITE;
/*!40000 ALTER TABLE `tblsubscribers` DISABLE KEYS */;
INSERT INTO `tblsubscribers` VALUES (4,'harish@gmail.com','2024-06-01 09:26:21'),(5,'kunal@gmail.com','2024-05-31 09:35:07');
/*!40000 ALTER TABLE `tblsubscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbltestimonial`
--

DROP TABLE IF EXISTS `tbltestimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbltestimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserEmail` varchar(100) NOT NULL,
  `Testimonial` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltestimonial`
--

LOCK TABLES `tbltestimonial` WRITE;
/*!40000 ALTER TABLE `tbltestimonial` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbltestimonial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblusers`
--

DROP TABLE IF EXISTS `tblusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `EmailId` (`EmailId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblusers`
--

LOCK TABLES `tblusers` WRITE;
/*!40000 ALTER TABLE `tblusers` DISABLE KEYS */;
INSERT INTO `tblusers` VALUES (1,'Test','test@gmail.com','f925916e2754e5e03f75dd58a5733251','6465465465','','L-890, Gaur City Ghaziabad','Ghaziabad','India','2024-05-01 14:00:49','2024-06-05 05:27:37'),(2,'Amit','amikt12@gmail.com','f925916e2754e5e03f75dd58a5733251','1425365214',NULL,NULL,NULL,NULL,'2024-06-05 05:31:05',NULL),(3,'Alexander Melendez','slowdsports@gmail.com','11ad53e4ceb2761482c6a4d4154bd6bf','97990336','05/03/2000','Col Rubén Darío, casa 3384','Tegucigalpa','Honduras','2026-03-09 01:06:49','2026-03-09 01:37:09');
/*!40000 ALTER TABLE `tblusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblvehicles`
--

DROP TABLE IF EXISTS `tblvehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblvehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VehiclesTitle` varchar(150) DEFAULT NULL,
  `VehiclesBrand` int(11) DEFAULT NULL,
  `VehiclesOverview` longtext DEFAULT NULL,
  `PricePerDay` int(11) DEFAULT NULL,
  `FuelType` varchar(100) DEFAULT NULL,
  `ModelYear` int(6) DEFAULT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `TransmissionType` varchar(50) DEFAULT 'Automatico',
  `Vimage1` varchar(120) DEFAULT NULL,
  `Vimage2` varchar(120) DEFAULT NULL,
  `Vimage3` varchar(120) DEFAULT NULL,
  `Vimage4` varchar(120) DEFAULT NULL,
  `Vimage5` varchar(120) DEFAULT NULL,
  `AirConditioner` int(11) DEFAULT NULL,
  `PowerDoorLocks` int(11) DEFAULT NULL,
  `AntiLockBrakingSystem` int(11) DEFAULT NULL,
  `BrakeAssist` int(11) DEFAULT NULL,
  `PowerSteering` int(11) DEFAULT NULL,
  `DriverAirbag` int(11) DEFAULT NULL,
  `PassengerAirbag` int(11) DEFAULT NULL,
  `PowerWindows` int(11) DEFAULT NULL,
  `CDPlayer` int(11) DEFAULT NULL,
  `CentralLocking` int(11) DEFAULT NULL,
  `CrashSensor` int(11) DEFAULT NULL,
  `LeatherSeats` int(11) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblvehicles`
--

LOCK TABLES `tblvehicles` WRITE;
/*!40000 ALTER TABLE `tblvehicles` DISABLE KEYS */;
INSERT INTO `tblvehicles` VALUES (1,'Río',1,'El Kia Río es un sedán subcompacto de entrada, fabricado en China, que destaca por su diseño funcional, amplio espacio interior y un maletero de 475 litros. Equipado con un motor de 1.4L (94 hp) y opciones manuales o automáticas, es una opción económica enfocada en la eficiencia, seguridad básica (doble airbag, ABS) y conectividad (Android Auto/Apple CarPlay). ',500,'Gasolina',2019,5,'Automatico','kiario.jpeg','kiario.jpeg','kiario.jpeg','kiario.jpeg','kiario.jpeg',1,1,1,1,1,1,1,1,1,1,1,1,'2024-05-10 07:04:35','2026-02-02 00:37:48'),(2,'Tiggo 8 Pro',2,'El Chery Tiggo 8 Pro es un SUV mediano premium de tres filas, conocido por su diseño moderno, tecnología avanzada (pantallas, Sony audio, techo panorámico), acabados interiores de lujo, y opciones de motorización turbo, ofreciendo gran espacio y comodidad para familias, compitiendo en el segmento con un enfoque en la relación calidad-precio. Destaca por su equipamiento de asistencia al conductor y la disponibilidad de versiones PHEV (híbridas enchufables), proporcionando una experiencia premium y eficiente.',1000,'Gasolina',2023,7,'Automatico','tiggo8pro.jpeg','tiggo8pro.jpeg','tiggo8pro.jpeg','tiggo8pro.jpeg','tiggo8pro.jpeg',1,1,1,1,1,1,1,1,NULL,1,1,1,'2024-05-10 07:04:35','2026-02-02 00:49:29'),(3,'Dzire',3,'El Dzire es tan irresistible como parece. Este sedán auténtico viene en el tamaño perfecto y rezuma un estilo exquisito, que llama la atención. Convierte su manejo diario en una experiencia extraordinaria, gracias a su interior espacioso y confortable que lo hace ideal para usted y su familia. No es de extrañar, te darás por vencido.',500,'Gasolina',2019,5,'Automatico','dzire.jpeg','dzire.jpeg','dzire.jpeg','dzire.jpeg','dzire.jpeg',1,1,1,1,1,1,1,1,1,1,1,1,'2024-05-10 07:04:35','2026-02-02 00:53:33'),(4,'Frontier (NP300)',4,'La Nissan NP300 Frontier es una pickup robusta y versátil, conocida por su durabilidad y capacidad de carga para trabajo pesado, con versiones que ofrecen un motor de gasolina de 2.5L y opciones diésel, enfocada en la funcionalidad y un buen rendimiento para jornadas laborales en mercados como México y Centroamérica. Se destaca por su diseño resistente, capacidad de hasta 1.4 toneladas de carga y tecnologías de seguridad como ABS y EBD, siendo una herramienta confiable para negocios y uso diario. ',800,'Diesel',2024,5,'Manual','frontier.jpeg','frontier.jpeg','frontier.jpeg','frontier.jpeg','frontier.jpeg',1,1,1,1,1,1,1,1,1,1,1,1,'2024-05-10 07:04:35','2026-05-08 05:24:21'),(5,'Land Cruiser Prado',5,'La Toyota Land Cruiser Prado, especialmente en su nueva generación (serie 250), es una SUV todoterreno de lujo de tamaño completo que combina un diseño retro/robusto con tecnología moderna. Destaca por su chasis de largueros, motor diésel de 2.8L (aprox. 201-204 HP, 500 Nm), tracción 4x4, capacidad para hasta 7 pasajeros y gran capacidad de arrastre, orientada a la durabilidad y confort. ',2000,'Diesel',2022,7,'Automatico','landcruiserprado.jpeg','landcruiserprado.jpeg','landcruiserprado.jpeg','2020-nissan-gtr-rakuda-tan-semi-aniline-leather-interior.jpglandcruiserprado.jpeg','landcruiserprado.jpeg',1,1,1,1,1,1,1,1,1,1,1,1,'2024-05-10 07:04:35','2026-02-02 01:02:42'),(6,'Raize',5,'La Toyota Raize es una SUV subcompacta diseñada para el entorno urbano, caracterizada por su tamaño compacto (4.03 m de largo), motor eficiente (1.0L Turbo o 1.2L) y alta agilidad. Ofrece un diseño moderno con iluminación LED, buen espacio interior, conectividad avanzada (Apple CarPlay/Android Auto) y un consumo eficiente de combustible.',400,'Gasolina',2018,5,'Automatico','raize.jpeg','raize.jpeg','raize.jpeg','raize.jpeg','raize.jpeg',1,1,NULL,1,1,1,1,1,1,1,1,1,'2024-05-10 07:04:35','2026-02-02 01:03:57'),(7,'Escape',7,'El Ford Escape es un automóvil del segmento C producido por el fabricante estadounidense Ford Motor Company desde fines del año 2000. Es un cinco plazas con carrocería de cinco puertas que se ubica en la gama media de Ford ofreciendo un volumen entre el Ford EcoSport y el Ford Edge. Compite con modelos como los Jeep Compass, Honda CR-V, Hyundai Tucson, Nissan X-Trail, Kia Sportage, Toyota RAV4 y Mazda CX-5.',800,'Gasolina',2017,5,'Automatico','escape.jpeg','escape.jpeg','escape.jpeg','escape.jpeg','escape.jpeg',NULL,NULL,NULL,NULL,NULL,1,1,1,NULL,1,1,1,'2024-05-10 07:04:35','2026-03-09 01:13:00'),(8,'Rush',5,'El Toyota Rush es un SUV compacto familiar con capacidad para 7 pasajeros y tracción trasera (RWD), destacando por su robustez, altura al suelo de \\(220\\text{mm}\\) y versatilidad para uso citadino y en carretera. Equipado con un motor 1.5L Dual VVT-i (102 HP), ofrece un consumo eficiente, 6 airbags y control de estabilidad (VSC). Es conocido como un vehículo fiable y de bajo mantenimiento, ideal para familias que buscan espacio sin el tamaño de un SUV mediano. ',600,'Gasolina',2018,5,'Automatico','rush.jpeg','rush.jpeg','rush.jpeg','rush.jpeg','rush.jpeg',1,1,1,1,1,1,1,1,1,1,1,1,'2024-05-10 07:04:35','2026-05-08 05:24:21');
/*!40000 ALTER TABLE `tblvehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-08 10:48:38
