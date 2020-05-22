-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: projeto-social-covid19
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `business`
--

DROP TABLE IF EXISTS `business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `site` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business`
--

LOCK TABLES `business` WRITE;
/*!40000 ALTER TABLE `business` DISABLE KEYS */;
INSERT INTO `business` VALUES (1,'Nome da empresa','https://www.youtube.com/watch?v=fMt3FxYiHVo',NULL,'testeuser@teste.com',NULL,NULL),(2,'Making Pie','makingpie.cm.vr',NULL,'iranjosealves@gmail.com',NULL,NULL),(3,'MakingPie','https://www.com.br',NULL,'',NULL,NULL),(4,'MakingPie','https://www.com.br',NULL,'iranjosealves@gmail.com',NULL,NULL),(5,'MakingPie','https://www.com.br',NULL,'iranjosealves@gmail.com',NULL,NULL),(6,'MakingPie','https://www.makingpie.com.br',NULL,'iranjosealves@gmail.com',NULL,NULL),(7,'MP','wwww.google.com.br',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(8,'MP','wwww.google.com.br',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(9,'MP','wwww.google.com.br',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(10,'MP','wwww.google.com.br',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(11,'MP','wwww.google.com.br',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(12,'MP','wwww.google.com.br',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(13,'MP','https://www.google.com',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(14,'KP','https://www.facebook.com',NULL,'makingpie.mkt@gmail.com',NULL,NULL),(15,'Google','https://google.com',NULL,'google@google.com',NULL,NULL),(16,'Facebook','https://www.facebook.com/',NULL,'iranjosealves@gmail.com',NULL,NULL),(17,'Uol','https://conteudo.imguol.com.br','https://conteudo.imguol.com.br/c/_layout/v2/components/header/logo_uol_1x.png','jose.pedro@atletasnow.com',NULL,NULL),(18,'Teste de empresa','https://www.google.com','https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png','marcio.domingues@atletasnow.com',NULL,NULL),(19,'Teste de empresa','https://www.google.com','https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png','marcio.domingues@atletasnow.com',NULL,NULL),(20,'Google','https://google.com','https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png','google@google.com',NULL,NULL);
/*!40000 ALTER TABLE `business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `unity_id` int(11) NOT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`,`unity_id`),
  UNIQUE KEY `solicitante_token_UNIQUE` (`token`),
  KEY `unity_idx` (`unity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
INSERT INTO `requests` VALUES (1,1,'8e14694afaaaba82124fb814140625ac',NULL,NULL),(2,1,'aad571be27a702a9ddaca1f3467e7154',NULL,NULL),(14,1,'4faf785e15a37c3de38a5434db3c9193',NULL,NULL),(15,2,'62d1fcd6e3348dd5abb70d3ae28c0d10',NULL,NULL),(16,1,'fc334ecc85a2727dc9d6e07a44be041b',NULL,NULL),(17,1,'3930795c2b1a8e6e8a3cfa92efef5987',NULL,NULL),(18,1,'c5029076369e6a603b96bacef6f65cd0',NULL,NULL),(19,1,'11c5ebc2425e575c9fbcfca1d9ac830a',NULL,NULL),(20,1,'22c7ddd559e5c321aa6ee1447a498ea3',NULL,NULL),(21,1,'5e320836830d89e28fc3e9dfd07db210',NULL,NULL),(22,1,'8a45652fca773049055c7b1be84da539',NULL,NULL),(23,2,'1b6fa769d3a4c36f682a802a54cf4f1b',NULL,NULL),(24,1,'aaeefb95648db760e8d2a2dff2031e1d',NULL,NULL),(25,1,'c3eec2f95706e701bc64538fb2d87cc0',NULL,NULL),(26,1,'cb96eac6561d27f704495b2a5d84bba9',NULL,NULL),(27,2,'d92e118850b5a55b75839d109975f655',NULL,NULL),(28,2,'2b9175d182f5d097a543e73a963b7da5',NULL,NULL),(29,1,'6f48235e63fb2d28fd33bd8983209dec',NULL,NULL);
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `request_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
INSERT INTO `resources` VALUES (1,'cachorro',1,NULL,NULL),(2,'leão',2,NULL,NULL),(3,'macaco',2,NULL,NULL),(4,'LUVAS',1,NULL,NULL),(5,'TOUCAS',1,NULL,NULL),(6,'SAPATOS',1,NULL,NULL),(7,'LUVAS',14,NULL,NULL),(8,'NOVA MASCARA',17,NULL,NULL),(9,'LUVAS',18,NULL,NULL),(10,'NOVO TESTE',19,NULL,NULL),(11,'TELEFONE',20,NULL,NULL),(12,'VOLUME',21,NULL,NULL),(13,'MACACO',22,NULL,NULL),(14,'LUVAS',23,NULL,NULL),(15,'MASCARáS',23,NULL,NULL),(16,'PAPEL HIGIêNICO',23,NULL,'2020-05-08 17:59:49'),(17,'LUVAS',24,NULL,NULL),(18,'FLAMENGO',24,NULL,NULL),(19,'LUVAS',25,NULL,NULL),(20,'VALUE',26,NULL,'2020-05-08 03:55:06'),(21,'VALUE',27,NULL,NULL),(22,'RESPIRADORES',28,NULL,NULL),(23,'MASCARáS',28,NULL,NULL),(24,'LUVAS',28,NULL,NULL),(25,'teste1',29,NULL,NULL);
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support`
--

DROP TABLE IF EXISTS `support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support`
--

LOCK TABLES `support` WRITE;
/*!40000 ALTER TABLE `support` DISABLE KEYS */;
INSERT INTO `support` VALUES (1,1,1,NULL,NULL),(2,1,3,NULL,NULL),(3,1,13,NULL,NULL),(4,15,16,NULL,NULL),(5,14,20,NULL,NULL),(6,6,1,NULL,NULL),(7,16,21,NULL,NULL),(8,17,24,NULL,NULL),(9,18,25,NULL,NULL),(10,19,25,NULL,NULL),(11,20,25,NULL,NULL);
/*!40000 ALTER TABLE `support` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unity`
--

DROP TABLE IF EXISTS `unity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unity` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(11) NOT NULL,
  `neighborhood` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unity`
--

LOCK TABLES `unity` WRITE;
/*!40000 ALTER TABLE `unity` DISABLE KEYS */;
INSERT INTO `unity` VALUES (1,'Hospital Pirituba','Av Raiumundo Pereira',100,'Pirituba','São Paulo','SP','05187010',NULL,NULL),(2,'Hospital Liberdade','Av Cruzeiro do Sul',200,'Liberdade','São Paulo','SP','05165320',NULL,NULL);
/*!40000 ALTER TABLE `unity` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-22 19:01:43
