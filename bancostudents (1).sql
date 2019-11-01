-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: alunos
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

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
-- Table structure for table `tb_adm`
--

DROP TABLE IF EXISTS `tb_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_adm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desnome` varchar(80) NOT NULL,
  `deslogin` varchar(45) NOT NULL,
  `despassword` varchar(80) NOT NULL,
  `desemail` varchar(100) NOT NULL,
  `dessession` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_adm`
--

LOCK TABLES `tb_adm` WRITE;
/*!40000 ALTER TABLE `tb_adm` DISABLE KEYS */;
INSERT INTO `tb_adm` VALUES (1,'Mauricio','MauricioAdmin','$2y$10$GHWbC8Pgtnq30EQsc1ya5.uF6KqFHYBea1m0T5.MCHBxJ3GHvyiBS','arlindomauricio2013sk8@gmail.com',1);
/*!40000 ALTER TABLE `tb_adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_logins`
--

DROP TABLE IF EXISTS `tb_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_logins` (
  `idlogin` int(11) NOT NULL AUTO_INCREMENT,
  `desnome` varchar(45) NOT NULL,
  `deslogin` varchar(45) NOT NULL,
  `desaddress` varchar(80) NOT NULL,
  `despassword` varchar(100) NOT NULL,
  `desturma` varchar(45) NOT NULL,
  PRIMARY KEY (`idlogin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_logins`
--

LOCK TABLES `tb_logins` WRITE;
/*!40000 ALTER TABLE `tb_logins` DISABLE KEYS */;
INSERT INTO `tb_logins` VALUES (1,'Mauricio','Mauricio1','joao2013@gmail.com','$2y$10$sC979GgTJS99kAA5HXrdBOPeUToEOLVjR9Q8iDIDLFRAPhG/iCYHW','2am'),(2,'Mauricio','12312','3123213','$2y$10$.42Te.yQHcO0GAWIJ9Z0Y.0VzNDr7Rp8ZRkq6w1O9KKydahQKJxcK','3cm'),(3,'teste','teste','teste','$2y$10$JkLXmQERGSTfVzDCDvhvE.3Z4piNHQStnjBrMRgJuuvqZb5Oq.WLy','3em'),(4,'teste','teste','teste','$2y$10$UJ.sQIHt5MgPbDbk6RfNSeMnbMJn2bBA7wqWO2pbRW.Uy/YeHuSwK','3em');
/*!40000 ALTER TABLE `tb_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_noticias`
--

DROP TABLE IF EXISTS `tb_noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_noticias` (
  `idnoticia` int(11) NOT NULL AUTO_INCREMENT,
  `desautor` varchar(80) NOT NULL,
  `destitulo` varchar(200) NOT NULL,
  `desdetails` varchar(5000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idnoticia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_noticias`
--

LOCK TABLES `tb_noticias` WRITE;
/*!40000 ALTER TABLE `tb_noticias` DISABLE KEYS */;
INSERT INTO `tb_noticias` VALUES (1,'Mauricio','Novos Horáriros','Horário Novo. Horário Novo. Horário Novo. Horário Novo. Horário Novo. Horário Novo. Horário Novo. Horário Novo. Horário Novo.','2019-10-30 19:42:55'),(2,'Carlos Andrade','Noticia teste',' O petroleiro é do tipo Suezmax, que tem capacidade de carregar 1,1 milhão de barris. Depois de sair do Porto de José, em 18 de julho, o petroleiro Bouboulina chegou à Cidade do Cabo, na costa da África do Sul, em 9 de agosto. Ele navegou pela costa por menos de um dia, depois continuou a jornada em direção ao estreito de Malaca, na Malásia.\r\n\r\nEm 3 de setembro, chegou à costa da Malásia. Durante todo este trajeto, o petroleiro estava com \"Automatic Identification System\" (AIS) ligado.\r\n\r\nEntre 3 e 13 de setembro, o navio Bouboulina transferiu a carga para outra embarcação, no sistema \"ship-to-ship\", com o AIS desligado. A Kpler informou que a embarcação que recebeu a carga é desconhecida.\r\n\r\nDepois, o Bouboulina partiu rumo à Nigéria, para atracar no terminal Qua Iboe, e carregou novamente no dia 20 de outubro, e agora navega rumo à Balikpapan, na Indonésia.\r\n\r\nNome Bouboulina\r\nLaskarina \"Bouboulina\" Pinotsis foi uma marinheira grega que comandou diversos navios durante a guerra da independência da Grécia, no século 19.\r\n\r\nBouboulina é considerada uma heroína de guerra e participou ativamente do movimento pela independência do país, levando secretamente carregamentos de munições e armamentos para os soldados, usando seus próprios recursos.\r\n\r\n','2019-11-01 17:47:23'),(3,'Carlos Andrade','Noticia teste',' aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','2019-11-01 17:54:52');
/*!40000 ALTER TABLE `tb_noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_professores`
--

DROP TABLE IF EXISTS `tb_professores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_professores` (
  `idprof` int(11) NOT NULL AUTO_INCREMENT,
  `desnome` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descpf` varchar(45) NOT NULL,
  `descodigo` varchar(45) NOT NULL,
  PRIMARY KEY (`idprof`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_professores`
--

LOCK TABLES `tb_professores` WRITE;
/*!40000 ALTER TABLE `tb_professores` DISABLE KEYS */;
INSERT INTO `tb_professores` VALUES (11,'Andréia Ramos','123143423-55','JDK920KK');
/*!40000 ALTER TABLE `tb_professores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_students`
--

DROP TABLE IF EXISTS `tb_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_students` (
  `idstudent` int(11) NOT NULL AUTO_INCREMENT,
  `desnome` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descpf` varchar(45) NOT NULL,
  `desturma` varchar(45) NOT NULL,
  PRIMARY KEY (`idstudent`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_students`
--

LOCK TABLES `tb_students` WRITE;
/*!40000 ALTER TABLE `tb_students` DISABLE KEYS */;
INSERT INTO `tb_students` VALUES (1,'Arlindo Mauricio Saraiva de Souza','06071567-55','2am'),(2,'João da Cruz Lima','7660891-55','2aN'),(3,'Andréia Ramos','17899423-55','3fm'),(4,'Carlos Santos Araújo','123143423-55','3bm'),(5,'Ramos Silva Santos','17899423-55',''),(6,'Andréia Ramos','234232323','3cm'),(7,'Andréia Ramos','06071567-55','3em'),(8,'Andréia Ramos','06071567-55','3cm');
/*!40000 ALTER TABLE `tb_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'alunos'
--

--
-- Dumping routines for database 'alunos'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-01 17:17:14
