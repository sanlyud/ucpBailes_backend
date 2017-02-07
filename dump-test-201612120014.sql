-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	10.1.10-MariaDB

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
-- Table structure for table `mtssformmaster`
--

DROP TABLE IF EXISTS `mtssformmaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtssformmaster` (
  `formMasterID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`formMasterID`),
  KEY `mtssformmaster_studentnumber_foreign` (`studentNumber`),
  CONSTRAINT `mtssformmaster_studentnumber_foreign` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtssformmaster`
--

LOCK TABLES `mtssformmaster` WRITE;
/*!40000 ALTER TABLE `mtssformmaster` DISABLE KEYS */;
INSERT INTO `mtssformmaster` VALUES (1,'STU1','2016-11-19 17:45:15','2016-11-19 17:45:15'),(3,'3','2016-12-05 06:37:01','2016-12-05 06:37:01');
/*!40000 ALTER TABLE `mtssformmaster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtsslistofinterventions`
--

DROP TABLE IF EXISTS `mtsslistofinterventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtsslistofinterventions` (
  `listOfInterventionsID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `listOfInterventionsFrmID` int(10) unsigned NOT NULL,
  `subjectOrIssue` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subjectIssueNotes` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `interventionSupportTier1` tinyint(1) DEFAULT '0',
  `interventionSupportInterv` tinyint(1) DEFAULT '0',
  `interventionSupportSupport` tinyint(1) DEFAULT '0',
  `interventionSupportChosenItem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interventionSupportNotes` text COLLATE utf8_unicode_ci,
  `personRespName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personResPosition` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `frequencyDays` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `frequencyMinutes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateIntervStarted` date DEFAULT NULL,
  `outcome` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`listOfInterventionsID`),
  KEY `mtsslistofinterventions_listofinterventionsfrmid_foreign` (`listOfInterventionsFrmID`),
  CONSTRAINT `mtsslistofinterventions_listofinterventionsfrmid_foreign` FOREIGN KEY (`listOfInterventionsFrmID`) REFERENCES `mtsslistofinterventionsform` (`listOfInterventionsFrmID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtsslistofinterventions`
--

LOCK TABLES `mtsslistofinterventions` WRITE;
/*!40000 ALTER TABLE `mtsslistofinterventions` DISABLE KEYS */;
INSERT INTO `mtsslistofinterventions` VALUES (1,4,'Reading','Slow',NULL,1,0,1,'AM Tutoring','testing testing','Mila Sando','teacher','3','45','2016-10-01','geting better'),(2,4,'Math','Slow',NULL,1,0,1,'PM Tutoring','testing testing testing','Nick Peterson','teacher','7','45','2016-11-01','geting better'),(3,10,'Reading','',NULL,1,0,0,'','','Maria Davis','teacher','14','30','2016-11-06','some progress'),(4,10,'Math','hw help',NULL,0,1,0,'PM Tutoring','','Paul Statson','teacher','7','25','2016-11-27','effective'),(5,15,'Reading',NULL,NULL,1,0,0,NULL,NULL,'Maria Davis','teacher','7','20','2016-11-27','some porgress'),(6,15,'Math','hw assistance',NULL,0,1,0,'PM Tutoring',NULL,'Paul Stetson','teacher','14','30','2016-12-02','very effective');
/*!40000 ALTER TABLE `mtsslistofinterventions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignment`
--

DROP TABLE IF EXISTS `assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignment` (
  `assignmentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeID` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `courseID` int(10) unsigned NOT NULL,
  `sourceID` int(10) unsigned NOT NULL,
  `assignmentName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`assignmentID`),
  KEY `typeID` (`typeID`),
  KEY `courseID` (`courseID`),
  KEY `sourceID` (`sourceID`),
  CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`typeID`) REFERENCES `assignmenttype` (`typeID`),
  CONSTRAINT `assignment_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  CONSTRAINT `assignment_ibfk_4` FOREIGN KEY (`sourceID`) REFERENCES `datasource` (`sourceID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignment`
--

LOCK TABLES `assignment` WRITE;
/*!40000 ALTER TABLE `assignment` DISABLE KEYS */;
INSERT INTO `assignment` VALUES (1,3,'2016-12-04 00:00:00','2016-12-04 00:00:00',0.2,1,1,'Test1'),(2,2,'2016-12-04 15:50:00','2016-12-04 15:50:00',0.05,1,1,'Quiz1'),(3,1,'2016-12-04 12:43:53','2016-12-04 12:43:53',0.1,3,1,'Test1');
/*!40000 ALTER TABLE `assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtssdatabaseddecisiontoolform`
--

DROP TABLE IF EXISTS `mtssdatabaseddecisiontoolform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtssdatabaseddecisiontoolform` (
  `dataBasedDecisionToolFrmID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `masterFormID` int(10) unsigned NOT NULL,
  `meetingDate` date NOT NULL,
  `AYPsubgroups` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `IDnumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Retentions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `A1` tinyint(1) NOT NULL,
  `A2` tinyint(1) NOT NULL,
  `B1` tinyint(1) NOT NULL,
  `B2` tinyint(1) NOT NULL,
  `B4` tinyint(1) NOT NULL,
  `stateLevelAssesments` text COLLATE utf8_unicode_ci NOT NULL,
  `stateLevelStudentScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stateLevelAgeGroupScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `districtLevelAssesments` text COLLATE utf8_unicode_ci NOT NULL,
  `districtLevelStudentScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `districtLevelAgeGroupScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `schoolLevelAssesments` text COLLATE utf8_unicode_ci NOT NULL,
  `schoolLevelStudentScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `schoolLevelAgeGroupScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `classLevelAssesments` text COLLATE utf8_unicode_ci NOT NULL,
  `classLevelStudentScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `classLevelAgeGroupScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subgroupLevelAssesments` text COLLATE utf8_unicode_ci NOT NULL,
  `subgroupLevelStudentScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subgroupLevelAgeGroupScore` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cultureEthnFactors` tinyint(1) NOT NULL,
  `irregAttendanceHighMobilFactors` tinyint(1) NOT NULL,
  `limitedEnglishFactors` tinyint(1) NOT NULL,
  `chronologicalAgeFactors` tinyint(1) NOT NULL,
  `genderFactors` tinyint(1) NOT NULL,
  PRIMARY KEY (`dataBasedDecisionToolFrmID`),
  KEY `mtssdatabaseddecisiontoolform_masterformid_foreign` (`masterFormID`),
  CONSTRAINT `mtssdatabaseddecisiontoolform_masterformid_foreign` FOREIGN KEY (`masterFormID`) REFERENCES `mtssformmaster` (`formMasterID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtssdatabaseddecisiontoolform`
--

LOCK TABLES `mtssdatabaseddecisiontoolform` WRITE;
/*!40000 ALTER TABLE `mtssdatabaseddecisiontoolform` DISABLE KEYS */;
INSERT INTO `mtssdatabaseddecisiontoolform` VALUES (1,3,'2016-12-13','123','15353','testing',1,0,1,1,1,'FCAT','80','85','Reading','90','85','Math','85','85','Science','80','85','Writing','80','80',1,0,1,0,0);
/*!40000 ALTER TABLE `mtssdatabaseddecisiontoolform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtssmeetingrequestform`
--

DROP TABLE IF EXISTS `mtssmeetingrequestform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtssmeetingrequestform` (
  `meetingRequestFrmID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `masterFormID` int(10) unsigned NOT NULL,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `teacherFName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `teacherLName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateFrmSubmitted` date NOT NULL,
  `concernAreaAcademic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `concernAreaBehaviour` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `concernAreaHealthCondtns` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collabAddCurricResourcesIndiv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collabAddCurricResourcesOutcome` text COLLATE utf8_unicode_ci NOT NULL,
  `collabBehavConcernsIndiv` text COLLATE utf8_unicode_ci NOT NULL,
  `collabBehavConcernsOutcome` text COLLATE utf8_unicode_ci NOT NULL,
  `collabESOLConcernsIndiv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collabESOLConcernsOutcome` text COLLATE utf8_unicode_ci NOT NULL,
  `collabHealthIssuesIndiv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collabHealthIssuesOutcome` text COLLATE utf8_unicode_ci NOT NULL,
  `collabPossibleIntervIndiv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collabPossibleIntervOutcome` text COLLATE utf8_unicode_ci NOT NULL,
  `collabReadingMathRecommIndiv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collabReadingMathReccomOutcome` text COLLATE utf8_unicode_ci NOT NULL,
  `collabSpeechLangIndiv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collabSpeechLangOutcome` text COLLATE utf8_unicode_ci NOT NULL,
  `collabOtherIndiv` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `collabOtherOutcome` text COLLATE utf8_unicode_ci,
  `dateCumReviewed` date NOT NULL,
  `studentPassVisionTest` tinyint(1) NOT NULL,
  `studentVisionTestCmnts` text COLLATE utf8_unicode_ci,
  `studentPassHearnigTest` tinyint(1) NOT NULL,
  `studentHearingTestCmnts` text COLLATE utf8_unicode_ci,
  `studentMobConcern` tinyint(1) NOT NULL,
  `studentMobConcernCmnts` text COLLATE utf8_unicode_ci,
  `studentAttendConcern` tinyint(1) NOT NULL,
  `studentAttendConcernCmnts` text COLLATE utf8_unicode_ci,
  `studentIsESOL` tinyint(1) NOT NULL,
  `studentIsESOLCmnts` text COLLATE utf8_unicode_ci,
  `studentIsESE` tinyint(1) NOT NULL,
  `studentIsESECmnts` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`meetingRequestFrmID`),
  KEY `mtssmeetingrequestform_studentnumber_foreign` (`studentNumber`),
  KEY `mtssmeetingrequestform_masterformid_foreign` (`masterFormID`),
  CONSTRAINT `mtssmeetingrequestform_masterformid_foreign` FOREIGN KEY (`masterFormID`) REFERENCES `mtssformmaster` (`formMasterID`),
  CONSTRAINT `mtssmeetingrequestform_studentnumber_foreign` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtssmeetingrequestform`
--

LOCK TABLES `mtssmeetingrequestform` WRITE;
/*!40000 ALTER TABLE `mtssmeetingrequestform` DISABLE KEYS */;
INSERT INTO `mtssmeetingrequestform` VALUES (1,1,'STU1','Mary','Doe','2016-11-19','testing testing','testing','testing','testing','blah blah','testing 12 3','testing 34545','aha aha','good good','weak','normal','testing','not bad','goood','average','normal','pass','working hard','okay','2016-11-01',1,'did well',1,'good',1,'okay',1,'alright',1,'doing good',1,'okay'),(2,23,'STU1','Emily','Wen','2016-11-07','unsatis','satisf','none','Emily Wen','needs imp','Emily Wen','needs imp','Emily Wen','needs imp','Emily Wen','needs imp','Emily Wen','needs imp','Emily Wen','needs imp','Emily Wen','needs imp','Emily Wen','needs imp','2016-11-09',1,'passed',1,'passed',0,'passed',0,'passed',0,'passed',1,'passed'),(3,3,'3','Maria','Davis','2016-11-27','poor','acceptable','none','Maria Davis','needs improvement','Maria Davis','needs improvement','Maria Davis','needs improvement','Maria Davis','needs improvement','Maria Davis','needs improvement','Maria Davis','needs improvement','Maria Davis','needs improvement',NULL,NULL,'2016-11-08',1,NULL,1,NULL,0,NULL,0,NULL,1,NULL,1,NULL);
/*!40000 ALTER TABLE `mtssmeetingrequestform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spellingcity_student_activity`
--

DROP TABLE IF EXISTS `spellingcity_student_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spellingcity_student_activity` (
  `student_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `list` varchar(100) DEFAULT NULL,
  `activity` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `time_on_task` varchar(30) DEFAULT NULL,
  `score` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `studentNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `courseID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`student_activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spellingcity_student_activity`
--

LOCK TABLES `spellingcity_student_activity` WRITE;
/*!40000 ALTER TABLE `spellingcity_student_activity` DISABLE KEYS */;
INSERT INTO `spellingcity_student_activity` VALUES (136,'Long -u Patterns in Accented Syllables','Practice Spelling Test','2016-03-04 21:46:00','11 mins','78','6',5),(137,'Long -u Patterns in Accented Syllables','Practice Spelling Test','2016-02-26 09:58:00','8 mins','57','6',5),(138,'Long -u Patterns in Accented Syllables','Spelling TestMe','2016-02-26 09:50:00','7 mins','57','6',5),(139,'Long -u Patterns in Accented Syllables','Audio Word Match','2016-02-26 09:39:00','9 mins','','6',5),(140,'Final e','Audio Word Match','2016-02-25 09:53:00','4 mins','','6',5),(141,'Hard and Soft c and g','Spelling TestMe','2016-02-19 09:52:00','6 mins','100','6',5),(142,'Hard and Soft c and g','Practice Spelling Test','2016-02-19 09:41:00','8 mins','83','6',5),(143,'Triple Blends','Spelling TestMe','2016-02-05 09:51:00','4 mins','100','6',5),(144,'kn/wr/gn','Spelling TestMe','2016-01-27 10:05:00','19 mins','42','6',5),(145,'ou, ow','Spelling TestMe','2016-01-08 10:17:00','4 mins','96','6',5),(146,'wa, al, ou','Spelling TestMe','2015-12-11 09:35:00','5 mins','100','6',5),(147,'aw, au, o','Spelling TestMe','2015-12-04 09:39:00','6 mins','100','6',5),(148,'R-controlled Review','Spelling TestMe','2015-11-09 09:39:00','4 mins','74','6',5),(149,'ur/ure/ur-e','Spelling TestMe','2015-11-03 09:44:00','9 mins','87','6',5),(150,'ir/ire/ier','Spelling TestMe','2015-10-22 08:46:00','11 mins','71','6',5),(151,'or/ore/oar','Spelling TestMe','2015-10-19 09:57:00','5 mins','96','6',5),(152,'er/ear/eer','Practice Spelling Test','2015-10-12 09:53:00','2 mins','91','6',5),(153,'ar/are/air','Practice Spelling Test','2015-10-08 09:45:00','7 mins','96','6',5),(154,'Long Vowel Patterns','Spelling TestMe','2015-09-25 09:42:00','4 mins','100','6',5),(155,'Warriors','Spelling TestMe','2015-09-18 09:44:00','5 mins','85','6',5),(156,'WW 28 ( Green 24)','Spelling TestMe','2015-02-20 09:52:00','9 mins','92','6',5),(157,'WW27 ( Yellow 29 )','Spelling TestMe','2015-02-13 10:17:00','7 mins','100','6',5),(158,'WW25 ( Green 21 )','Spelling TestMe','2015-02-06 10:03:00','5 mins','92','6',5),(159,'WW23 ( Green 19 )','Spelling TestMe','2015-01-15 09:29:00','7 mins','92','6',5),(160,'WW22 ( Green 18 )','Spelling TestMe','2015-01-09 09:39:00','6 mins','100','6',5),(161,'WW21 ( Green 16 )','Spelling TestMe','2014-12-12 09:54:00','8 mins','57','6',5),(162,'WW 19A [ Green 14 ]','Spelling TestMe','2014-11-21 09:54:00','3 mins','90','6',5),(163,'WW17 [ Green 12]','Spelling TestMe','2014-11-07 10:00:00','4 mins','100','6',5),(164,'WW14 [ Green 8 ]','Spelling TestMe','2014-10-10 10:24:00','6 mins','71','6',5),(165,'WW13 ( Green 7 )','Spelling TestMe','2014-10-03 09:19:00','7 mins','85','6',5),(166,'WW12A [ Green 9/22]','Spelling TestMe','2014-09-26 09:27:00','4 mins','100','6',5),(167,'WW11A [Yellow 12 ]','Assignment - Spelling TestMe','2014-09-19 09:29:00','3 mins','100','6',5),(168,'Green 9/2 [WW7A]','Spelling TestMe','2014-09-05 09:26:00','3 mins','100','6',5),(169,'Long -u Patterns in Accented Syllables','Practice Spelling Test','2016-03-04 09:46:00','11 mins','78','3',3),(170,'Long -u Patterns in Accented Syllables','Practice Spelling Test','2016-02-26 09:58:00','8 mins','57','3',3),(171,'Long -u Patterns in Accented Syllables','Spelling TestMe','2016-02-26 09:50:00','7 mins','57','3',3),(172,'Long -u Patterns in Accented Syllables','Audio Word Match','2016-02-26 09:39:00','9 mins','','3',3),(173,'Final e','Audio Word Match','2016-02-25 09:53:00','4 mins','','3',3),(174,'Hard and Soft c and g','Spelling TestMe','2016-02-19 09:52:00','6 mins','100','3',3),(175,'Hard and Soft c and g','Practice Spelling Test','2016-02-19 09:41:00','8 mins','83','3',3),(176,'Triple Blends','Spelling TestMe','2016-02-05 09:51:00','4 mins','100','3',3),(177,'kn/wr/gn','Spelling TestMe','2016-01-27 10:05:00','19 mins','42','3',3),(178,'ou, ow','Spelling TestMe','2016-01-08 10:17:00','4 mins','96','3',3),(179,'wa, al, ou','Spelling TestMe','2015-12-11 09:35:00','5 mins','100','3',3),(180,'aw, au, o','Spelling TestMe','2015-12-04 09:39:00','6 mins','100','3',3),(181,'R-controlled Review','Spelling TestMe','2015-11-09 09:39:00','4 mins','74','3',3),(182,'ur/ure/ur-e','Spelling TestMe','2015-11-03 09:44:00','9 mins','87','3',3),(183,'ir/ire/ier','Spelling TestMe','2015-10-22 08:46:00','11 mins','71','3',3),(184,'or/ore/oar','Spelling TestMe','2015-10-19 09:57:00','5 mins','96','3',3),(185,'er/ear/eer','Practice Spelling Test','2015-10-12 09:53:00','2 mins','91','3',3),(186,'ar/are/air','Practice Spelling Test','2015-10-08 09:45:00','7 mins','96','3',3),(187,'Long Vowel Patterns','Spelling TestMe','2015-09-25 09:42:00','4 mins','100','3',3),(188,'Warriors','Spelling TestMe','2015-09-18 09:44:00','5 mins','85','3',3),(189,'WW 28 ( Green 24)','Spelling TestMe','2015-02-20 09:52:00','9 mins','92','3',3),(190,'WW27 ( Yellow 29 )','Spelling TestMe','2015-02-13 10:17:00','7 mins','100','3',3),(191,'WW25 ( Green 21 )','Spelling TestMe','2015-02-06 10:03:00','5 mins','92','3',3),(192,'WW23 ( Green 19 )','Spelling TestMe','2015-01-15 09:29:00','7 mins','92','3',3),(193,'WW22 ( Green 18 )','Spelling TestMe','2015-01-09 09:39:00','6 mins','100','3',3),(194,'WW21 ( Green 16 )','Spelling TestMe','2014-12-12 09:54:00','8 mins','57','3',3),(195,'WW 19A [ Green 14 ]','Spelling TestMe','2014-11-21 09:54:00','3 mins','90','3',3),(196,'WW17 [ Green 12]','Spelling TestMe','2014-11-07 10:00:00','4 mins','100','3',3),(197,'WW14 [ Green 8 ]','Spelling TestMe','2014-10-10 10:24:00','6 mins','71','3',3),(198,'WW13 ( Green 7 )','Spelling TestMe','2014-10-03 09:19:00','7 mins','85','3',3),(199,'WW12A [ Green 9/22]','Spelling TestMe','2014-09-26 09:27:00','4 mins','100','3',3),(200,'WW11A [Yellow 12 ]','Assignment - Spelling TestMe','2014-09-19 09:29:00','3 mins','100','3',3),(201,'Green 9/2 [WW7A]','Spelling TestMe','2014-09-05 09:26:00','3 mins','100','3',3),(202,'Long -u Patterns in Accented Syllables','Practice Spelling Test','2016-03-04 09:46:00','11 mins','78','3',3),(203,'Long -u Patterns in Accented Syllables','Practice Spelling Test','2016-02-26 09:58:00','8 mins','57','3',3),(204,'Long -u Patterns in Accented Syllables','Spelling TestMe','2016-02-26 09:50:00','7 mins','57','3',3),(205,'Long -u Patterns in Accented Syllables','Audio Word Match','2016-02-26 09:39:00','9 mins','','3',3),(206,'Final e','Audio Word Match','2016-02-25 09:53:00','4 mins','','3',3),(207,'Hard and Soft c and g','Spelling TestMe','2016-02-19 09:52:00','6 mins','100','3',3),(208,'Hard and Soft c and g','Practice Spelling Test','2016-02-19 09:41:00','8 mins','83','3',3),(209,'Triple Blends','Spelling TestMe','2016-02-05 09:51:00','4 mins','100','3',3),(210,'kn/wr/gn','Spelling TestMe','2016-01-27 10:05:00','19 mins','42','3',3),(211,'ou, ow','Spelling TestMe','2016-01-08 10:17:00','4 mins','96','3',3),(212,'wa, al, ou','Spelling TestMe','2015-12-11 09:35:00','5 mins','100','3',3),(213,'aw, au, o','Spelling TestMe','2015-12-04 09:39:00','6 mins','100','3',3),(214,'R-controlled Review','Spelling TestMe','2015-11-09 09:39:00','4 mins','74','3',3),(215,'ur/ure/ur-e','Spelling TestMe','2015-11-03 09:44:00','9 mins','87','3',3),(216,'ir/ire/ier','Spelling TestMe','2015-10-22 08:46:00','11 mins','71','3',3),(217,'or/ore/oar','Spelling TestMe','2015-10-19 09:57:00','5 mins','96','3',3),(218,'er/ear/eer','Practice Spelling Test','2015-10-12 09:53:00','2 mins','91','3',3),(219,'ar/are/air','Practice Spelling Test','2015-10-08 09:45:00','7 mins','96','3',3),(220,'Long Vowel Patterns','Spelling TestMe','2015-09-25 09:42:00','4 mins','100','3',3),(221,'Warriors','Spelling TestMe','2015-09-18 09:44:00','5 mins','85','3',3),(222,'WW 28 ( Green 24)','Spelling TestMe','2015-02-20 09:52:00','9 mins','92','3',3),(223,'WW27 ( Yellow 29 )','Spelling TestMe','2015-02-13 10:17:00','7 mins','100','3',3),(224,'WW25 ( Green 21 )','Spelling TestMe','2015-02-06 10:03:00','5 mins','92','3',3),(225,'WW23 ( Green 19 )','Spelling TestMe','2015-01-15 09:29:00','7 mins','92','3',3),(226,'WW22 ( Green 18 )','Spelling TestMe','2015-01-09 09:39:00','6 mins','100','3',3),(227,'WW21 ( Green 16 )','Spelling TestMe','2014-12-12 09:54:00','8 mins','57','3',3),(228,'WW 19A [ Green 14 ]','Spelling TestMe','2014-11-21 09:54:00','3 mins','90','3',3),(229,'WW17 [ Green 12]','Spelling TestMe','2014-11-07 10:00:00','4 mins','100','3',3),(230,'WW14 [ Green 8 ]','Spelling TestMe','2014-10-10 10:24:00','6 mins','71','3',3),(231,'WW13 ( Green 7 )','Spelling TestMe','2014-10-03 09:19:00','7 mins','85','3',3),(232,'WW12A [ Green 9/22]','Spelling TestMe','2014-09-26 09:27:00','4 mins','100','3',3),(233,'WW11A [Yellow 12 ]','Assignment - Spelling TestMe','2014-09-19 09:29:00','3 mins','100','3',3),(234,'Green 9/2 [WW7A]','Spelling TestMe','2014-09-05 09:26:00','3 mins','100','3',3);
/*!40000 ALTER TABLE `spellingcity_student_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_student`
--

DROP TABLE IF EXISTS `course_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `courseID` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_student_studentnumber_foreign` (`studentNumber`),
  KEY `course_student_courseid_foreign` (`courseID`),
  CONSTRAINT `course_student_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  CONSTRAINT `course_student_studentnumber_foreign` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_student`
--

LOCK TABLES `course_student` WRITE;
/*!40000 ALTER TABLE `course_student` DISABLE KEYS */;
INSERT INTO `course_student` VALUES (1,'3',1,'2016-12-05 14:43:42','2016-12-05 14:43:42'),(2,'4',1,'2016-12-05 14:43:42','2016-12-05 14:43:42'),(3,'7',1,'2016-12-05 14:43:42','2016-12-05 14:43:42'),(4,'3',3,'2016-12-05 06:36:43','2016-12-05 06:36:43'),(6,'4',3,'2016-12-05 06:36:43','2016-12-05 06:36:43'),(7,'7',3,'2016-12-05 06:36:43','2016-12-05 06:36:43');
/*!40000 ALTER TABLE `course_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datasource`
--

DROP TABLE IF EXISTS `datasource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datasource` (
  `sourceID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`sourceID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datasource`
--

LOCK TABLES `datasource` WRITE;
/*!40000 ALTER TABLE `datasource` DISABLE KEYS */;
INSERT INTO `datasource` VALUES (1,'Manual');
/*!40000 ALTER TABLE `datasource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `firstName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schoolID` int(10) unsigned NOT NULL,
  `isActive` tinyint(4) DEFAULT '1',
  `isAdmin` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'khanhbui@gmail.com','$2y$10$yMCrBTJ0JVZ/m7KAyXajLOA2Ds/naMi//Ne5vmyn/ZjX8I66Bd6M6',NULL,'2016-11-19 17:35:43','2016-11-19 17:35:43','Khanh','Bui',1,1,0),(2,'mila@gmail.com','$2y$10$4ZDhp5Q.SaxTtILh5D8HvO9fgohuGkeafnZVwgP.GV8KfgK.gR0se',NULL,'2016-11-21 05:18:36','2016-11-21 05:18:36','Mila','Sando',1,1,1),(3,'mariadavis@gmail.com','$2y$10$Sn5Wtm4RdH.b2FPzIiAHQuu.Tc2eBE.uEELmMyrcB4eJbfpBWddvi',NULL,'2016-12-04 19:37:43','2016-12-04 19:37:43','Maria','Davis',1,1,0),(4,'emilyswan@gmail.com','$2y$10$VWn/BR.gKFQQIQ3mXlVtbu6uiIouXGx9dZa1pzjgSLrYFS/ppoLny',NULL,'2016-12-08 02:33:34','2016-12-08 02:33:34','Emily','Swan',1,1,0),(5,'jamesharris@gmail.com','$2y$10$BtLhv9t2j18yIziJ5j9No.yYcxfTyrTCnP44v3laXqCel5j56J8xu',NULL,'2016-12-11 03:55:21','2016-12-11 03:55:21','James','Harris',1,1,0),(6,'mariocarasco@gmail.com','$2y$10$9qTnDs3mIT713sxSDKI5hOgDpjmovMyF9n.hdecNoX7H5rImmE7HG',NULL,'2016-12-11 04:01:11','2016-12-11 04:01:11','Mario','Carasco',1,1,0),(7,'marinacarso@gmail.com','$2y$10$dKZsi1c8U2D1Czi3qLKwVeFWD4LMlyZQebc7rH6aBBvomp/o5Prm2',NULL,'2016-12-11 04:05:05','2016-12-11 04:05:05','Marina','Carso',1,1,0),(8,'helenapplegate@gmail.com','$2y$10$g3Z4Y7QE8fs0XpJTfNxQ3ODddpH4U7sjtMBjdZ123iCj24j52FVcW',NULL,'2016-12-11 04:07:21','2016-12-11 04:07:21','Helen','Applegate',1,1,0),(9,'dianestein@gmail.com','$2y$10$NFkJTgI6m2hZ3757WMxZf.ADaaMbOGt6L.nUzfdxvN6XQdUdZHTxK',NULL,'2016-12-11 04:09:55','2016-12-11 04:09:55','Diane','Stein',1,1,0),(10,'admin@gmail.com','$2y$10$J/TGNSt7/bTntsgvsODUgORBZHifeIjYN7Q.UcdEsrxernT9N59za',NULL,'2016-12-12 09:32:18','2016-12-12 09:32:18','Admin','Admin',1,1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignmentscore`
--

DROP TABLE IF EXISTS `assignmentscore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignmentscore` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `assignmentID` int(10) unsigned NOT NULL,
  `studentNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `score` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignmentID` (`assignmentID`),
  KEY `studentNumber` (`studentNumber`),
  CONSTRAINT `assignmentscore_Fk_2` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`),
  CONSTRAINT `assignmentscore_ibfk_1` FOREIGN KEY (`assignmentID`) REFERENCES `assignment` (`assignmentID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignmentscore`
--

LOCK TABLES `assignmentscore` WRITE;
/*!40000 ALTER TABLE `assignmentscore` DISABLE KEYS */;
INSERT INTO `assignmentscore` VALUES (1,1,'3',90),(2,1,'4',90),(3,1,'7',95),(4,2,'3',90),(5,2,'4',95),(7,2,'7',90),(8,3,'3',100),(9,3,'4',97),(10,3,'7',90);
/*!40000 ALTER TABLE `assignmentscore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parser_config`
--

DROP TABLE IF EXISTS `parser_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parser_config` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `parser_type` int(11) DEFAULT NULL,
  `data_table_name` varchar(30) DEFAULT NULL,
  `login_URL` varchar(100) DEFAULT NULL,
  `data_URL` varchar(100) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `class_name` varchar(30) DEFAULT NULL,
  `subject_name` varchar(30) DEFAULT NULL,
  `start_date` varchar(8) DEFAULT NULL,
  `end_date` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parser_config`
--

LOCK TABLES `parser_config` WRITE;
/*!40000 ALTER TABLE `parser_config` DISABLE KEYS */;
INSERT INTO `parser_config` VALUES (4,4,'spellingcity_student_activity',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `parser_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_teacher`
--

DROP TABLE IF EXISTS `course_teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_teacher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `teacherID` int(10) unsigned NOT NULL,
  `courseID` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_teacher_teacherid_foreign` (`teacherID`),
  KEY `course_teacher_courseid_foreign` (`courseID`),
  CONSTRAINT `course_teacher_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  CONSTRAINT `course_teacher_teacherid_foreign` FOREIGN KEY (`teacherID`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_teacher`
--

LOCK TABLES `course_teacher` WRITE;
/*!40000 ALTER TABLE `course_teacher` DISABLE KEYS */;
INSERT INTO `course_teacher` VALUES (1,1,1,NULL,NULL),(2,2,2,NULL,NULL),(3,1,2,NULL,NULL),(4,2,1,NULL,NULL),(5,2,3,NULL,NULL);
/*!40000 ALTER TABLE `course_teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtssmeetinglogform`
--

DROP TABLE IF EXISTS `mtssmeetinglogform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtssmeetinglogform` (
  `meetingLogFrmID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `masterFormID` int(10) unsigned NOT NULL,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`meetingLogFrmID`),
  KEY `mtssmeetinglogform_masterformid_foreign` (`masterFormID`),
  KEY `mtssmeetinglogform_student_fk` (`studentNumber`),
  CONSTRAINT `mtssmeetinglogform_masterformid_foreign` FOREIGN KEY (`masterFormID`) REFERENCES `mtssformmaster` (`formMasterID`),
  CONSTRAINT `mtssmeetinglogform_student_fk` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtssmeetinglogform`
--

LOCK TABLES `mtssmeetinglogform` WRITE;
/*!40000 ALTER TABLE `mtssmeetinglogform` DISABLE KEYS */;
INSERT INTO `mtssmeetinglogform` VALUES (6,3,'3'),(7,3,'3'),(8,3,'3');
/*!40000 ALTER TABLE `mtssmeetinglogform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `missed_words`
--

DROP TABLE IF EXISTS `missed_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `missed_words` (
  `missed_words_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_activity_id` int(11) DEFAULT NULL,
  `missed_word` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`missed_words_id`),
  KEY `student_activity_id` (`student_activity_id`),
  CONSTRAINT `missed_words_ibfk_1` FOREIGN KEY (`student_activity_id`) REFERENCES `spellingcity_student_activity` (`student_activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `missed_words`
--

LOCK TABLES `missed_words` WRITE;
/*!40000 ALTER TABLE `missed_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `missed_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_student`
--

DROP TABLE IF EXISTS `teacher_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher_student` (
  `teacher_id` int(10) unsigned NOT NULL,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  KEY `teacher_student_teacher_id_foreign` (`teacher_id`),
  KEY `teacher_student_studentnumber_foreign` (`studentNumber`),
  CONSTRAINT `teacher_student_studentnumber_foreign` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`),
  CONSTRAINT `teacher_student_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_student`
--

LOCK TABLES `teacher_student` WRITE;
/*!40000 ALTER TABLE `teacher_student` DISABLE KEYS */;
INSERT INTO `teacher_student` VALUES (1,'STU1'),(2,'3'),(2,'4');
/*!40000 ALTER TABLE `teacher_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade` (
  `gradeID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`gradeID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade`
--

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
INSERT INTO `grade` VALUES (1,'Kindergarten'),(2,'1'),(3,'2'),(4,'3'),(5,'4'),(6,'5'),(7,'6'),(8,'7'),(9,'8'),(10,'9'),(11,'10'),(12,'11'),(13,'12');
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_category`
--

DROP TABLE IF EXISTS `course_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_category` (
  `categoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_category`
--

LOCK TABLES `course_category` WRITE;
/*!40000 ALTER TABLE `course_category` DISABLE KEYS */;
INSERT INTO `course_category` VALUES (1,'Math'),(2,'Reading'),(4,'Science'),(5,'Social Science');
/*!40000 ALTER TABLE `course_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `schoolID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`schoolID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

LOCK TABLES `school` WRITE;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` VALUES (1,'UCPBalies Elementary');
/*!40000 ALTER TABLE `school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtssmembersattended`
--

DROP TABLE IF EXISTS `mtssmembersattended`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtssmembersattended` (
  `membAttendedID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mtssMeetingLogID` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`membAttendedID`),
  KEY `mtssmembersattended_mtssmeetinglogid_foreign` (`mtssMeetingLogID`),
  CONSTRAINT `mtssmembersattended_mtssmeetinglogid_foreign` FOREIGN KEY (`mtssMeetingLogID`) REFERENCES `mtssmeetinglog` (`mtssMeetingLogID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtssmembersattended`
--

LOCK TABLES `mtssmembersattended` WRITE;
/*!40000 ALTER TABLE `mtssmembersattended` DISABLE KEYS */;
INSERT INTO `mtssmembersattended` VALUES (11,7,'Maria Davis','teacher'),(12,7,'Mark Patterson','teacher'),(13,8,'Maria Davis','teacher'),(14,8,'Mark Patterson','teacher'),(15,9,'Maria Davis','teacher');
/*!40000 ALTER TABLE `mtssmembersattended` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `schoolID` int(10) unsigned NOT NULL,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `studentDOB` date NOT NULL,
  `studentFName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `studentLName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `studentMName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gradeID` tinyint(4) NOT NULL,
  `isActive` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`studentNumber`),
  KEY `student_studentnumber_unique` (`studentNumber`) USING BTREE,
  KEY `student_schoolid_foreign` (`schoolID`),
  KEY `gradeID` (`gradeID`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`gradeID`) REFERENCES `grade` (`gradeID`),
  CONSTRAINT `student_schoolid_foreign` FOREIGN KEY (`schoolID`) REFERENCES `school` (`schoolID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'10','2006-10-29','Daniel','Vazquez',NULL,5,1),(1,'11','2006-10-29','Emmaline','Dunham',NULL,5,1),(1,'12','2006-10-27','Ethan','Fowler',NULL,5,1),(1,'13','2006-05-07','Ryan','Chambers',NULL,5,1),(1,'14','2006-05-06','Emmaline','Dunham',NULL,5,1),(1,'15','2007-01-16','Mayreliz','Flaquer',NULL,5,1),(1,'16','2006-03-23','Zora','Franklin',NULL,5,1),(1,'17','2006-01-31','Teairra-Marie','Gomez',NULL,5,1),(1,'18','2006-07-10','Madisyn','Guerrier',NULL,5,1),(1,'19','2006-09-14','Shomari','Jones',NULL,5,1),(1,'20','2006-09-14','Lestat','Lecusay',NULL,5,1),(1,'21','2006-10-17','Maria','MacInnes',NULL,5,1),(1,'3','2008-06-15','Aiden','Enright','Alan',4,1),(1,'4','2008-05-15','Gracen','Kinsey','',5,1),(1,'7','2006-12-14','aron','Fowler',NULL,5,1),(1,'8','2006-12-18','Adam','Kane',NULL,5,1),(1,'9','2006-11-27','Chase','McConkey',NULL,5,1),(1,'STU1','2015-01-10',NULL,NULL,NULL,4,1);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `courseID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `courseName` varchar(50) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT '1',
  `gradeID` tinyint(4) NOT NULL,
  `categoryID` int(10) unsigned NOT NULL,
  `schoolYearID` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`courseID`),
  KEY `gradeID` (`gradeID`),
  KEY `categoryID` (`categoryID`),
  KEY `schoolYearID` (`schoolYearID`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`gradeID`) REFERENCES `grade` (`gradeID`),
  CONSTRAINT `course_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `course_category` (`categoryID`),
  CONSTRAINT `course_ibfk_3` FOREIGN KEY (`schoolYearID`) REFERENCES `schoolyear` (`schoolYearID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Math',1,3,1,1,'2016-12-03 17:14:52','2016-12-03 17:14:52'),(2,'MathA',1,4,1,1,'2016-12-03 23:23:25','2016-12-03 23:23:25'),(3,'ReadingA',1,5,2,1,'2016-12-04 16:19:45','2016-12-04 16:19:45'),(4,'ReadingB',1,4,2,1,'2016-12-04 16:22:08','2016-12-04 16:22:08'),(5,'Science16_17',1,5,4,1,'2016-12-07 22:32:30','2016-12-07 22:32:30');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignmenttype`
--

DROP TABLE IF EXISTS `assignmenttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignmenttype` (
  `typeID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`typeID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignmenttype`
--

LOCK TABLES `assignmenttype` WRITE;
/*!40000 ALTER TABLE `assignmenttype` DISABLE KEYS */;
INSERT INTO `assignmenttype` VALUES (3,'Assignment'),(2,'Quiz'),(1,'Test');
/*!40000 ALTER TABLE `assignmenttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateTaken` datetime DEFAULT NULL,
  `student_present` tinyint(4) DEFAULT NULL,
  `student_absent` tinyint(4) DEFAULT NULL,
  `student_tardy` tinyint(4) DEFAULT NULL,
  `courseID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `studentNumber` (`studentNumber`),
  KEY `courseID` (`courseID`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`),
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'3','2016-12-05 00:00:00',1,0,0,3),(2,'3','2016-11-28 00:00:00',1,0,0,3),(3,'4','2016-11-28 00:00:00',0,0,1,3),(4,'7','2016-11-28 00:00:00',0,1,0,3);
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtssmeetingnotesform`
--

DROP TABLE IF EXISTS `mtssmeetingnotesform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtssmeetingnotesform` (
  `mtssMeetingNotesFrmID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `masterFormID` int(10) unsigned NOT NULL,
  `teachersNames` text COLLATE utf8_unicode_ci NOT NULL,
  `meetingDate` date NOT NULL,
  `meetingType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `graphsNA` tinyint(1) DEFAULT NULL,
  `NA` tinyint(1) DEFAULT NULL,
  `graphsAvailable` tinyint(1) DEFAULT NULL,
  `notesFromDiscussion` text COLLATE utf8_unicode_ci NOT NULL,
  `nextStep` text COLLATE utf8_unicode_ci,
  `nextMeetingDate` date NOT NULL,
  `timeframe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nextNotes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participatedParent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateParentParticipated` date DEFAULT NULL,
  `participatedTeacher` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateTeacherParticipated` date NOT NULL,
  `participatedMTSSCoachLiason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateMTSSCoachLiasonParticipated` date DEFAULT NULL,
  `participatedSchoolPsychologist` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateSchoolPsychologistParticipated` date DEFAULT NULL,
  `participatedEseTeacher` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateEseTeacherParticipated` date DEFAULT NULL,
  `participatedAdmin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateAdminParticipated` date DEFAULT NULL,
  `participatedSocialWorker` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateSocialWorkerParticipate` date DEFAULT NULL,
  `participatedOther1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateOther1Participated` date DEFAULT NULL,
  `participatedOther2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateOther2Participated` date DEFAULT NULL,
  `participatedOther3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateOther3Participated` date DEFAULT NULL,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mtssMeetingNotesFrmID`),
  KEY `mtssmeetingnotesform_masterformid_foreign` (`masterFormID`),
  KEY `studentNumber` (`studentNumber`),
  CONSTRAINT `mtssmeetingnotesform_ibfk_1` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`),
  CONSTRAINT `mtssmeetingnotesform_masterformid_foreign` FOREIGN KEY (`masterFormID`) REFERENCES `mtssformmaster` (`formMasterID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtssmeetingnotesform`
--

LOCK TABLES `mtssmeetingnotesform` WRITE;
/*!40000 ALTER TABLE `mtssmeetingnotesform` DISABLE KEYS */;
INSERT INTO `mtssmeetingnotesform` VALUES (11,3,'Mila Sando','2016-11-12','review',NULL,1,NULL,'review the performance of student','assess the progress of the student','2016-12-12','1:00 PM','summary report','Maria Pike','2016-11-12','Mila Sando','2016-11-12','','2016-12-11','','2016-12-11','','2016-12-11','','2016-12-11','','2016-12-11','','2016-12-11','','2016-12-11','','2016-12-11','3'),(12,3,'Maria Davis','2016-11-07','MTSS meeting with team',NULL,1,NULL,'academic progress','Maria Davis will allocate extra hours for student\'s homework','2016-12-07','1 month',NULL,'Martha Enright','2016-12-11','Maria Davis','2016-12-11','Anna Smith','2016-12-11','Alice Walker','2016-12-11','Andrew Lee','2016-11-07','Daniel Swan','2016-11-07','Angela Davis','2016-11-07',NULL,'2016-12-11',NULL,'2016-12-11',NULL,'2016-12-11','3');
/*!40000 ALTER TABLE `mtssmeetingnotesform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolyear`
--

DROP TABLE IF EXISTS `schoolyear`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolyear` (
  `schoolYearID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `startYear` int(11) NOT NULL,
  `endYear` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`schoolYearID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolyear`
--

LOCK TABLES `schoolyear` WRITE;
/*!40000 ALTER TABLE `schoolyear` DISABLE KEYS */;
INSERT INTO `schoolyear` VALUES (1,2016,2017,'2016-11-30 05:00:00',NULL);
/*!40000 ALTER TABLE `schoolyear` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtssmeetinglog`
--

DROP TABLE IF EXISTS `mtssmeetinglog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtssmeetinglog` (
  `mtssMeetingLogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meetingLogFrmID` int(10) unsigned NOT NULL,
  `teacherName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` int(11) NOT NULL,
  `meetingDate` date NOT NULL,
  `meetingType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mtssMeetingLogID`),
  KEY `mtssmeetinglog_meetinglogfrmid_foreign` (`meetingLogFrmID`),
  CONSTRAINT `mtssmeetinglog_meetinglogfrmid_foreign` FOREIGN KEY (`meetingLogFrmID`) REFERENCES `mtssmeetinglogform` (`meetingLogFrmID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtssmeetinglog`
--

LOCK TABLES `mtssmeetinglog` WRITE;
/*!40000 ALTER TABLE `mtssmeetinglog` DISABLE KEYS */;
INSERT INTO `mtssmeetinglog` VALUES (7,7,'Maria Davis',4,'2016-11-29','team meeting'),(8,8,'Maria Davis',4,'2016-11-29','team meeting'),(9,8,'Maria Davis',4,'2016-12-05','meeting with parent');
/*!40000 ALTER TABLE `mtssmeetinglog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtsslistofinterventionsform`
--

DROP TABLE IF EXISTS `mtsslistofinterventionsform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtsslistofinterventionsform` (
  `listOfInterventionsFrmID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `masterFormID` int(10) unsigned NOT NULL,
  `teacherName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `studentNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` int(11) NOT NULL,
  `date` date NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`listOfInterventionsFrmID`),
  KEY `mtsslistofinterventionsform_studentnumber_foreign` (`studentNumber`),
  KEY `mtsslistofinterventionsform_masterformid_foreign` (`masterFormID`),
  CONSTRAINT `mtsslistofinterventionsform_masterformid_foreign` FOREIGN KEY (`masterFormID`) REFERENCES `mtssformmaster` (`formMasterID`),
  CONSTRAINT `mtsslistofinterventionsform_studentnumber_foreign` FOREIGN KEY (`studentNumber`) REFERENCES `student` (`studentNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtsslistofinterventionsform`
--

LOCK TABLES `mtsslistofinterventionsform` WRITE;
/*!40000 ALTER TABLE `mtsslistofinterventionsform` DISABLE KEYS */;
INSERT INTO `mtsslistofinterventionsform` VALUES (3,3,'Mila Sando','4',4,'2016-12-01','this is a test note'),(4,3,'Mila Sando','4',4,'2016-12-01','this is a test note'),(5,3,'Maria Davis','3',4,'2016-12-11',''),(6,3,'Maria Davis','3',4,'2016-12-11',''),(7,3,'Maria Davis','3',4,'2016-12-11',''),(8,3,'Maria Davis','3',4,'2016-12-11',''),(9,3,'Maria Davis','3',4,'2016-12-11',''),(10,3,'Maria Davis','3',4,'2016-12-11',''),(11,3,'Maria Davis','3',4,'2016-12-12',''),(12,3,'Maria Davis','3',4,'2016-12-12',NULL),(13,3,'Maria Davis','3',4,'2016-12-12',NULL),(14,3,'Mila Sando','4',4,'2016-12-01','this is a test note'),(15,3,'Maria Davis','3',4,'2016-12-12',NULL);
/*!40000 ALTER TABLE `mtsslistofinterventionsform` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-12  0:14:33
