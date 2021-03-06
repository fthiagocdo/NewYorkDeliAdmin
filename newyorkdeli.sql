-- MySQL dump 10.16  Distrib 10.1.33-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: newyorkdeli
-- ------------------------------------------------------
-- Server version	10.1.33-MariaDB

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
-- Table structure for table `checkout_item_extras`
--

DROP TABLE IF EXISTS `checkout_item_extras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout_item_extras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` double(8,2) NOT NULL,
  `checkoutitem_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `menuextra_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `checkout_item_extras_checkout_item_id_foreign` (`checkoutitem_id`),
  KEY `checkout_item_extras_menuextra_id_foreign` (`menuextra_id`),
  CONSTRAINT `checkout_item_extras_checkout_item_id_foreign` FOREIGN KEY (`checkoutitem_id`) REFERENCES `checkout_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checkout_item_extras_menuextra_id_foreign` FOREIGN KEY (`menuextra_id`) REFERENCES `menu_extras` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout_item_extras`
--

LOCK TABLES `checkout_item_extras` WRITE;
/*!40000 ALTER TABLE `checkout_item_extras` DISABLE KEYS */;
INSERT INTO `checkout_item_extras` VALUES (17,1.00,303,'2019-03-19 12:27:25','2019-03-19 12:27:25',202),(18,0.60,303,'2019-03-19 12:27:25','2019-03-19 12:27:25',210),(19,1.00,303,'2019-03-19 12:27:25','2019-03-19 12:27:25',217),(20,0.60,303,'2019-03-19 12:27:25','2019-03-19 12:27:25',224),(21,0.75,303,'2019-03-19 12:27:25','2019-03-19 12:27:25',231),(22,0.80,305,'2019-03-19 16:23:04','2019-03-19 16:23:04',184),(23,0.80,305,'2019-03-19 16:23:04','2019-03-19 16:23:04',191),(24,1.00,306,'2019-03-19 16:41:26','2019-03-19 16:41:26',322),(25,0.60,308,'2019-03-19 16:46:16','2019-03-19 16:46:16',26),(26,0.80,308,'2019-03-19 16:46:17','2019-03-19 16:46:17',34),(27,1.50,308,'2019-03-19 16:46:17','2019-03-19 16:46:17',239),(28,2.00,308,'2019-03-19 16:46:17','2019-03-19 16:46:17',254),(29,1.00,309,'2019-03-20 12:23:40','2019-03-20 12:23:40',322),(30,1.00,310,'2019-03-20 12:25:27','2019-03-20 12:25:27',322),(31,1.00,311,'2019-03-20 12:39:36','2019-03-20 12:39:36',322),(32,0.80,312,'2019-03-20 12:46:20','2019-03-20 12:46:20',184),(33,0.80,312,'2019-03-20 12:46:20','2019-03-20 12:46:20',191);
/*!40000 ALTER TABLE `checkout_item_extras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkout_items`
--

DROP TABLE IF EXISTS `checkout_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `checkout_id` int(10) unsigned NOT NULL,
  `unitary_price` double(8,2) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `menuitem_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `checkout_items_checkout_id_foreign` (`checkout_id`),
  KEY `checkout_items_menuitem_id_foreign` (`menuitem_id`),
  CONSTRAINT `checkout_items_checkout_id_foreign` FOREIGN KEY (`checkout_id`) REFERENCES `checkouts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checkout_items_menuitem_id_foreign` FOREIGN KEY (`menuitem_id`) REFERENCES `menu_items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=316 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout_items`
--

LOCK TABLES `checkout_items` WRITE;
/*!40000 ALTER TABLE `checkout_items` DISABLE KEYS */;
INSERT INTO `checkout_items` VALUES (302,302,5.45,1,5.45,'2019-03-19 12:20:24','2019-03-19 12:20:24',69),(303,303,6.70,1,6.70,'2019-03-19 12:27:25','2019-03-19 12:27:25',169),(304,304,5.45,1,5.45,'2019-03-19 16:03:37','2019-03-19 16:03:37',16),(305,305,7.05,1,7.05,'2019-03-19 16:23:03','2019-03-19 16:23:04',69),(306,306,2.00,1,2.00,'2019-03-19 16:41:26','2019-03-19 16:41:26',186),(307,307,1.00,1,1.00,'2019-03-19 16:44:09','2019-03-19 16:44:09',186),(308,308,10.35,1,10.35,'2019-03-19 16:46:16','2019-03-19 16:46:17',16),(309,309,2.00,1,2.00,'2019-03-20 12:23:40','2019-03-20 12:23:40',186),(310,309,2.00,1,2.00,'2019-03-20 12:25:27','2019-03-20 12:25:27',186),(311,310,2.00,1,2.00,'2019-03-20 12:39:36','2019-03-20 12:39:36',186),(312,311,7.05,1,7.05,'2019-03-20 12:46:20','2019-03-20 12:46:20',69),(313,312,5.45,1,5.45,'2019-03-20 12:49:57','2019-03-20 12:49:57',69),(314,313,2.75,1,2.75,'2019-03-20 12:51:19','2019-03-20 12:51:19',169),(315,314,4.75,1,4.75,'2019-03-20 12:52:32','2019-03-20 12:52:32',143);
/*!40000 ALTER TABLE `checkout_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkouts`
--

DROP TABLE IF EXISTS `checkouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `partial_value` decimal(8,2) DEFAULT NULL,
  `delivery_fee` decimal(8,2) DEFAULT NULL,
  `rider_tip` decimal(8,2) DEFAULT NULL,
  `total_value` decimal(8,2) DEFAULT NULL,
  `delivery_postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `printed` tinyint(1) NOT NULL DEFAULT '0',
  `new_order` tinyint(1) NOT NULL DEFAULT '0',
  `deliver_or_collect` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'deliver_address',
  `table_number` int(11) DEFAULT NULL,
  `time_delivery_collect` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout_message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `checkouts_user_id_foreign` (`user_id`),
  KEY `checkouts_shop_id_foreign` (`shop_id`),
  CONSTRAINT `checkouts_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checkouts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkouts`
--

LOCK TABLES `checkouts` WRITE;
/*!40000 ALTER TABLE `checkouts` DISABLE KEYS */;
INSERT INTO `checkouts` VALUES (302,12,4,1,'2019-03-19 12:20:24','2019-03-19 12:20:40',5.45,2.00,0.00,7.45,'mk130eb','Friars Square Shopping Centre, Aylesbury','1234567890',0,1,'deliver_address',NULL,'12:50',NULL),(303,12,4,1,'2019-03-19 12:27:24','2019-03-19 12:28:44',6.70,0.00,0.00,6.70,NULL,NULL,'1234567890',0,1,'collect',NULL,'12:43','teste\ncskjlbskjlbvjksfvkjfs\nsdvkjbsdfvlbsflvjlçbfsjvçbjfsçlbvjçlsfbsjwlfçncjçlfscnlwf'),(304,12,4,1,'2019-03-19 16:03:36','2019-03-19 16:03:57',5.45,2.00,0.00,7.45,'mk130eb','Friars Square Shopping Centre, Aylesbury','1234567890',0,1,'deliver_address',NULL,'16:33',NULL),(305,12,4,1,'2019-03-19 16:23:03','2019-03-19 16:29:54',7.05,2.00,0.00,9.05,'mk130eb','Friars Square Shopping Centre, Aylesbury','1234567890',0,1,'deliver_address',NULL,'16:59',NULL),(306,12,5,1,'2019-03-19 16:41:25','2019-03-19 16:43:37',2.00,0.00,0.00,2.00,NULL,NULL,'1234567890',0,1,'deliver_table',NULL,'16:58',NULL),(307,12,5,1,'2019-03-19 16:44:09','2019-03-19 16:44:25',1.00,0.00,0.00,1.00,NULL,NULL,'1234567890',0,1,'collect',NULL,'16:59',NULL),(308,12,4,1,'2019-03-19 16:46:16','2019-03-19 16:46:30',10.35,2.00,0.00,12.35,'mk130eb','Friars Square Shopping Centre, Aylesbury','1234567890',0,1,'deliver_address',NULL,'17:16',NULL),(309,12,5,1,'2019-03-20 12:23:40','2019-03-20 12:37:15',4.00,0.00,0.00,4.00,NULL,NULL,'1234567890',0,1,'deliver_table',NULL,'12:51',NULL),(310,12,5,1,'2019-03-20 12:39:35','2019-03-20 12:44:06',2.00,0.00,0.00,2.00,NULL,NULL,'1234567890',0,1,'deliver_table',NULL,'12:59',NULL),(311,12,4,1,'2019-03-20 12:46:20','2019-03-20 12:46:38',7.05,2.00,0.00,9.05,'mk130eb','Friars Square Shopping Centre, Aylesbury','1234567890',0,1,'deliver_address',NULL,'13:16',NULL),(312,12,4,1,'2019-03-20 12:49:57','2019-03-20 12:51:02',5.45,2.00,0.00,7.45,'mk130eb','Friars Square Shopping Centre, Aylesbury','1234567890',0,1,'deliver_address',NULL,'13:20',NULL),(313,12,4,0,'2019-03-20 12:51:19','2019-03-20 12:51:27',2.75,2.00,0.00,4.75,'mk130eb','Friars Square Shopping Centre, Aylesbury','1234567890',0,0,'deliver_address',NULL,'13:21',NULL),(314,33,4,0,'2019-03-20 12:52:21','2019-03-20 12:52:40',4.75,2.00,0.00,6.75,'mk130eb','12 thompson street, new bradwell','123456789',0,0,'deliver_address',NULL,'13:22',NULL);
/*!40000 ALTER TABLE `checkouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'AF','Afghanistan',NULL,NULL),(2,'AL','Albania',NULL,NULL),(3,'DZ','Algeria',NULL,NULL),(4,'DS','American Samoa',NULL,NULL),(5,'AD','Andorra',NULL,NULL),(6,'AO','Angola',NULL,NULL),(7,'AI','Anguilla',NULL,NULL),(8,'AQ','Antarctica',NULL,NULL),(9,'AG','Antigua and Barbuda',NULL,NULL),(10,'AR','Argentina',NULL,NULL),(11,'AM','Armenia',NULL,NULL),(12,'AW','Aruba',NULL,NULL),(13,'AU','Australia',NULL,NULL),(14,'AT','Austria',NULL,NULL),(15,'AZ','Azerbaijan',NULL,NULL),(16,'BS','Bahamas',NULL,NULL),(17,'BH','Bahrain',NULL,NULL),(18,'BD','Bangladesh',NULL,NULL),(19,'BB','Barbados',NULL,NULL),(20,'BY','Belarus',NULL,NULL),(21,'BE','Belgium',NULL,NULL),(22,'BZ','Belize',NULL,NULL),(23,'BJ','Benin',NULL,NULL),(24,'BM','Bermuda',NULL,NULL),(25,'BT','Bhutan',NULL,NULL),(26,'BO','Bolivia',NULL,NULL),(27,'BA','Bosnia and Herzegovina',NULL,NULL),(28,'BW','Botswana',NULL,NULL),(29,'BV','Bouvet Island',NULL,NULL),(30,'BR','Brazil',NULL,NULL),(31,'IO','British Indian Ocean Territory',NULL,NULL),(32,'BN','Brunei Darussalam',NULL,NULL),(33,'BG','Bulgaria',NULL,NULL),(34,'BF','Burkina Faso',NULL,NULL),(35,'BI','Burundi',NULL,NULL),(36,'KH','Cambodia',NULL,NULL),(37,'CM','Cameroon',NULL,NULL),(38,'CA','Canada',NULL,NULL),(39,'CV','Cape Verde',NULL,NULL),(40,'KY','Cayman Islands',NULL,NULL),(41,'CF','Central African Republic',NULL,NULL),(42,'TD','Chad',NULL,NULL),(43,'CL','Chile',NULL,NULL),(44,'CN','China',NULL,NULL),(45,'CX','Christmas Island',NULL,NULL),(46,'CC','Cocos (Keeling) Islands',NULL,NULL),(47,'CO','Colombia',NULL,NULL),(48,'KM','Comoros',NULL,NULL),(49,'CG','Congo',NULL,NULL),(50,'CK','Cook Islands',NULL,NULL),(51,'CR','Costa Rica',NULL,NULL),(52,'HR','Croatia (Hrvatska)',NULL,NULL),(53,'CU','Cuba',NULL,NULL),(54,'CY','Cyprus',NULL,NULL),(55,'CZ','Czech Republic',NULL,NULL),(56,'DK','Denmark',NULL,NULL),(57,'DJ','Djibouti',NULL,NULL),(58,'DM','Dominica',NULL,NULL),(59,'DO','Dominican Republic',NULL,NULL),(60,'TP','East Timor',NULL,NULL),(61,'EC','Ecuador',NULL,NULL),(62,'EG','Egypt',NULL,NULL),(63,'SV','El Salvador',NULL,NULL),(64,'GQ','Equatorial Guinea',NULL,NULL),(65,'ER','Eritrea',NULL,NULL),(66,'EE','Estonia',NULL,NULL),(67,'ET','Ethiopia',NULL,NULL),(68,'FK','Falkland Islands (Malvinas)',NULL,NULL),(69,'FO','Faroe Islands',NULL,NULL),(70,'FJ','Fiji',NULL,NULL),(71,'FI','Finland',NULL,NULL),(72,'FR','France',NULL,NULL),(73,'FX','France, Metropolitan',NULL,NULL),(74,'GF','French Guiana',NULL,NULL),(75,'PF','French Polynesia',NULL,NULL),(76,'TF','French Southern Territories',NULL,NULL),(77,'GA','Gabon',NULL,NULL),(78,'GM','Gambia',NULL,NULL),(79,'GE','Georgia',NULL,NULL),(80,'DE','Germany',NULL,NULL),(81,'GH','Ghana',NULL,NULL),(82,'GI','Gibraltar',NULL,NULL),(83,'GK','Guernsey',NULL,NULL),(84,'GR','Greece',NULL,NULL),(85,'GL','Greenland',NULL,NULL),(86,'GD','Grenada',NULL,NULL),(87,'GP','Guadeloupe',NULL,NULL),(88,'GU','Guam',NULL,NULL),(89,'GT','Guatemala',NULL,NULL),(90,'GN','Guinea',NULL,NULL),(91,'GW','Guinea-Bissau',NULL,NULL),(92,'GY','Guyana',NULL,NULL),(93,'HT','Haiti',NULL,NULL),(94,'HM','Heard and Mc Donald Islands',NULL,NULL),(95,'HN','Honduras',NULL,NULL),(96,'HK','Hong Kong',NULL,NULL),(97,'HU','Hungary',NULL,NULL),(98,'IS','Iceland',NULL,NULL),(99,'IN','India',NULL,NULL),(100,'IM','Isle of Man',NULL,NULL),(101,'ID','Indonesia',NULL,NULL),(102,'IR','Iran (Islamic Republic of)',NULL,NULL),(103,'IQ','Iraq',NULL,NULL),(104,'IE','Ireland',NULL,NULL),(105,'IL','Israel',NULL,NULL),(106,'IT','Italy',NULL,NULL),(107,'CI','Ivory Coast',NULL,NULL),(108,'JE','Jersey',NULL,NULL),(109,'JM','Jamaica',NULL,NULL),(110,'JP','Japan',NULL,NULL),(111,'JO','Jordan',NULL,NULL),(112,'KZ','Kazakhstan',NULL,NULL),(113,'KE','Kenya',NULL,NULL),(114,'KI','Kiribati',NULL,NULL),(115,'KP','Korea, Democratic People\'s Republic of',NULL,NULL),(116,'KR','Korea, Republic of',NULL,NULL),(117,'XK','Kosovo',NULL,NULL),(118,'KW','Kuwait',NULL,NULL),(119,'KG','Kyrgyzstan',NULL,NULL),(120,'LA','Lao People\'s Democratic Republic',NULL,NULL),(121,'LV','Latvia',NULL,NULL),(122,'LB','Lebanon',NULL,NULL),(123,'LS','Lesotho',NULL,NULL),(124,'LR','Liberia',NULL,NULL),(125,'LY','Libyan Arab Jamahiriya',NULL,NULL),(126,'LI','Liechtenstein',NULL,NULL),(127,'LT','Lithuania',NULL,NULL),(128,'LU','Luxembourg',NULL,NULL),(129,'MO','Macau',NULL,NULL),(130,'MK','Macedonia',NULL,NULL),(131,'MG','Madagascar',NULL,NULL),(132,'MW','Malawi',NULL,NULL),(133,'MY','Malaysia',NULL,NULL),(134,'MV','Maldives',NULL,NULL),(135,'ML','Mali',NULL,NULL),(136,'MT','Malta',NULL,NULL),(137,'MH','Marshall Islands',NULL,NULL),(138,'MQ','Martinique',NULL,NULL),(139,'MR','Mauritania',NULL,NULL),(140,'MU','Mauritius',NULL,NULL),(141,'TY','Mayotte',NULL,NULL),(142,'MX','Mexico',NULL,NULL),(143,'FM','Micronesia, Federated States of',NULL,NULL),(144,'MD','Moldova, Republic of',NULL,NULL),(145,'MC','Monaco',NULL,NULL),(146,'MN','Mongolia',NULL,NULL),(147,'ME','Montenegro',NULL,NULL),(148,'MS','Montserrat',NULL,NULL),(149,'MA','Morocco',NULL,NULL),(150,'MZ','Mozambique',NULL,NULL),(151,'MM','Myanmar',NULL,NULL),(152,'NA','Namibia',NULL,NULL),(153,'NR','Nauru',NULL,NULL),(154,'NP','Nepal',NULL,NULL),(155,'NL','Netherlands',NULL,NULL),(156,'AN','Netherlands Antilles',NULL,NULL),(157,'NC','New Caledonia',NULL,NULL),(158,'NZ','New Zealand',NULL,NULL),(159,'NI','Nicaragua',NULL,NULL),(160,'NE','Niger',NULL,NULL),(161,'NG','Nigeria',NULL,NULL),(162,'NU','Niue',NULL,NULL),(163,'NF','Norfolk Island',NULL,NULL),(164,'MP','Northern Mariana Islands',NULL,NULL),(165,'NO','Norway',NULL,NULL),(166,'OM','Oman',NULL,NULL),(167,'PK','Pakistan',NULL,NULL),(168,'PW','Palau',NULL,NULL),(169,'PS','Palestine',NULL,NULL),(170,'PA','Panama',NULL,NULL),(171,'PG','Papua New Guinea',NULL,NULL),(172,'PY','Paraguay',NULL,NULL),(173,'PE','Peru',NULL,NULL),(174,'PH','Philippines',NULL,NULL),(175,'PN','Pitcairn',NULL,NULL),(176,'PL','Poland',NULL,NULL),(177,'PT','Portugal',NULL,NULL),(178,'PR','Puerto Rico',NULL,NULL),(179,'QA','Qatar',NULL,NULL),(180,'RE','Reunion',NULL,NULL),(181,'RO','Romania',NULL,NULL),(182,'RU','Russian Federation',NULL,NULL),(183,'RW','Rwanda',NULL,NULL),(184,'KN','Saint Kitts and Nevis',NULL,NULL),(185,'LC','Saint Lucia',NULL,NULL),(186,'VC','Saint Vincent and the Grenadines',NULL,NULL),(187,'WS','Samoa',NULL,NULL),(188,'SM','San Marino',NULL,NULL),(189,'ST','Sao Tome and Principe',NULL,NULL),(190,'SA','Saudi Arabia',NULL,NULL),(191,'SN','Senegal',NULL,NULL),(192,'RS','Serbia',NULL,NULL),(193,'SC','Seychelles',NULL,NULL),(194,'SL','Sierra Leone',NULL,NULL),(195,'SG','Singapore',NULL,NULL),(196,'SK','Slovakia',NULL,NULL),(197,'SI','Slovenia',NULL,NULL),(198,'SB','Solomon Islands',NULL,NULL),(199,'SO','Somalia',NULL,NULL),(200,'ZA','South Africa',NULL,NULL),(201,'GS','South Georgia South Sandwich Islands',NULL,NULL),(202,'SS','South Sudan',NULL,NULL),(203,'ES','Spain',NULL,NULL),(204,'LK','Sri Lanka',NULL,NULL),(205,'SH','St. Helena',NULL,NULL),(206,'PM','St. Pierre and Miquelon',NULL,NULL),(207,'SD','Sudan',NULL,NULL),(208,'SR','Suriname',NULL,NULL),(209,'SJ','Svalbard and Jan Mayen Islands',NULL,NULL),(210,'SZ','Swaziland',NULL,NULL),(211,'SE','Sweden',NULL,NULL),(212,'CH','Switzerland',NULL,NULL),(213,'SY','Syrian Arab Republic',NULL,NULL),(214,'TW','Taiwan',NULL,NULL),(215,'TJ','Tajikistan',NULL,NULL),(216,'TZ','Tanzania, United Republic of',NULL,NULL),(217,'TH','Thailand',NULL,NULL),(218,'TG','Togo',NULL,NULL),(219,'TK','Tokelau',NULL,NULL),(220,'TO','Tonga',NULL,NULL),(221,'TT','Trinidad and Tobago',NULL,NULL),(222,'TN','Tunisia',NULL,NULL),(223,'TR','Turkey',NULL,NULL),(224,'TM','Turkmenistan',NULL,NULL),(225,'TC','Turks and Caicos Islands',NULL,NULL),(226,'TV','Tuvalu',NULL,NULL),(227,'UG','Uganda',NULL,NULL),(228,'UA','Ukraine',NULL,NULL),(229,'AE','United Arab Emirates',NULL,NULL),(230,'GB','United Kingdom',NULL,NULL),(231,'US','United States',NULL,NULL),(232,'UM','United States minor outlying islands',NULL,NULL),(233,'UY','Uruguay',NULL,NULL),(234,'UZ','Uzbekistan',NULL,NULL),(235,'VU','Vanuatu',NULL,NULL),(236,'VA','Vatican City State',NULL,NULL),(237,'VE','Venezuela',NULL,NULL),(238,'VN','Vietnam',NULL,NULL),(239,'VG','Virgin Islands (British)',NULL,NULL),(240,'VI','Virgin Islands (U.S.)',NULL,NULL),(241,'WF','Wallis and Futuna Islands',NULL,NULL),(242,'EH','Western Sahara',NULL,NULL),(243,'YE','Yemen',NULL,NULL),(244,'ZR','Zaire',NULL,NULL),(245,'ZM','Zambia',NULL,NULL),(246,'ZW','Zimbabwe',NULL,NULL);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_tokens`
--

DROP TABLE IF EXISTS `login_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `login_tokens_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_tokens`
--

LOCK TABLES `login_tokens` WRITE;
/*!40000 ALTER TABLE `login_tokens` DISABLE KEYS */;
INSERT INTO `login_tokens` VALUES ('admin@mail.com','eyJhbGciOiJSUzI1NiIsImtpZCI6Ijk4Njk0NWJmMWIwNDYxZjBiZDViNTRhZWQ0YzQ1ZWU0ODMzMjgxOWEifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vbmV3LXlvcmstZGVsaS1tb2JpbGUtOWRjYzUiLCJhdWQiOiJuZXcteW9yay1kZWxpLW1vYmlsZS05ZGNjNSIsImF1dGhfdGltZSI6MTU0MDQ4MjkwOCwidXNlcl9pZCI6ImRUWWxCNVhhQ1ZWZ1RxWVhiYTRwYW85a1FyQjIiLCJzdWIiOiJkVFlsQjVYYUNWVmdUcVlYYmE0cGFvOWtRckIyIiwiaWF0IjoxNTQwNDgyOTA4LCJleHAiOjE1NDA0ODY1MDgsImVtYWlsIjoiYWRtaW5AbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsImZpcmViYXNlIjp7ImlkZW50aXRpZXMiOnsiZW1haWwiOlsiYWRtaW5AbWFpbC5jb20iXX0sInNpZ25faW5fcHJvdmlkZXIiOiJwYXNzd29yZCJ9fQ.i22DrdJucEG0fifhWWXAVwLwAF2FRZ_suK4pEgP8t5keZwoCG9A4HdoH9CH2igjVO7_MvFk530tprTFaxKlgAwz5cW0XyITXxx1nvc-syxk4RD9fRMoI8_wKNkaEmu_VV7DQYyM5Gnn_7L7Ihhhsx4U39OT_CvEFnb6S38aeklJwFSPGBGyrYrqtTxMoManS0D_nzxVujF6ZnHiTP_DFIyj1mYpEGD_X6tNKzePJEIuo03X83T1zAroiELQR5f9221vWWfmHsQddYt7PHcTcAvtnOLkq_Ugao8JoQvjlkj3gFZwGO9mmA-8sI4Omf-aF0Uhzzct__esNPhZz3Fty2w','2018-10-25 14:55:08','2018-10-25 14:55:08'),('fthiagocdo@gmail.com','0dd728311b648fb3af19facba23086457c73b8339028aa7c46','2018-11-12 16:35:04','2018-11-12 16:35:04'),('thiago@mail.com','eyJhbGciOiJSUzI1NiIsImtpZCI6ImZkZjY0MWJmNDY3MTA1YzMyYWRkMDI3MGIyZTEyZDJiZTJhYmNjY2IiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vbmV3LXlvcmstZGVsaS1tb2JpbGUtOWRjYzUiLCJhdWQiOiJuZXcteW9yay1kZWxpLW1vYmlsZS05ZGNjNSIsImF1dGhfdGltZSI6MTU0MTYxNDc5NCwidXNlcl9pZCI6ImdWVzBUM0RjTG5XU3lqVzlyUTBJekpGTHdlOTIiLCJzdWIiOiJnVlcwVDNEY0xuV1N5alc5clEwSXpKRkx3ZTkyIiwiaWF0IjoxNTQxNjE0Nzk0LCJleHAiOjE1NDE2MTgzOTQsImVtYWlsIjoidGhpYWdvQG1haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJmaXJlYmFzZSI6eyJpZGVudGl0aWVzIjp7ImVtYWlsIjpbInRoaWFnb0BtYWlsLmNvbSJdfSwic2lnbl9pbl9wcm92aWRlciI6InBhc3N3b3JkIn19.MkT40ydjh3l99tc3GwfGLkXO4eNNfyIWaOjqRPbqOVDD3ToFFhEfF6XvXVmkX7KFj93zvfrUBLRA7J78i-DMM5ox0B226wskfMRYP_GLql86q-pdyjyapbDqacHC1kArRIYIsKT9l8bAk6y-oD49QQr_ic70f35Gcy6rV6Nz7Qr2aH2bBmGZ1iIKjeoSfD2qXbYuNI952vOHcLHkxIdAKdQxfO_EglKAJ43gDTQhl9QOXkrNkTnFZVbhCAC0Z09o_i1HgyJpLGUwPZB0x1c0U1ek2NadM6QUODHKoaQhIyjJHnq6nsgj0IrUx6gZ6C_H3SkuLMe3bN-1cbvdEYjiLA','2018-11-07 18:19:57','2018-11-07 18:19:57'),('thiago2@mail.com','eyJhbGciOiJSUzI1NiIsImtpZCI6Ijk4Njk0NWJmMWIwNDYxZjBiZDViNTRhZWQ0YzQ1ZWU0ODMzMjgxOWEiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vbmV3LXlvcmstZGVsaS1tb2JpbGUtOWRjYzUiLCJhdWQiOiJuZXcteW9yay1kZWxpLW1vYmlsZS05ZGNjNSIsImF1dGhfdGltZSI6MTU0MTM0NjcyOCwidXNlcl9pZCI6Im41c3k1OGZmMTJlbUVpS3dwanI2Zjd6OEZqbjEiLCJzdWIiOiJuNXN5NThmZjEyZW1FaUt3cGpyNmY3ejhGam4xIiwiaWF0IjoxNTQxMzQ2NzI4LCJleHAiOjE1NDEzNTAzMjgsImVtYWlsIjoidGhpYWdvMkBtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJlbWFpbCI6WyJ0aGlhZ28yQG1haWwuY29tIl19LCJzaWduX2luX3Byb3ZpZGVyIjoicGFzc3dvcmQifX0.bXsTNEM6Me3mRrP8lWbUCVs3cmLdOvBGDN-ZMSl7t_APV67r48l-k2C-2TOFIN2wseHV0deMj23Jq7wVYelOn9jNoWMqvhMgfQuS-7gZYG0Z6zKKKefJRQ_cFJl_PPnnIHGKvbE6vLF-LqUfgNz66FK0ec5olg0uyA_g_yiI9M5f_b0R89UrmNbQvW19Hra9dIAmjce8f-r-0Z4DyNAPfp6xaS6DK8-ohHBq2IMctUa80U9Qld8CDG5yFSCiODX542c62MzthDZ7KnaKsmcygdcN_IM_PUPNnpXVgjlNokTCKvdTG3MSEDr_PuYeTB3MEy77pgMX8FJZg45cOrw96Q','2018-11-04 15:52:07','2018-11-04 15:52:07');
/*!40000 ALTER TABLE `login_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_extras`
--

DROP TABLE IF EXISTS `menu_extras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_extras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `menuitem_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_extras_menuitem_id_foreign` (`menuitem_id`),
  CONSTRAINT `menu_extras_menuitem_id_foreign` FOREIGN KEY (`menuitem_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=323 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_extras`
--

LOCK TABLES `menu_extras` WRITE;
/*!40000 ALTER TABLE `menu_extras` DISABLE KEYS */;
INSERT INTO `menu_extras` VALUES (26,'Side Salad',0.60,16,'2018-07-19 04:24:43','2018-07-19 04:27:05'),(27,'Side Salad',0.60,17,'2018-07-19 04:24:55','2018-07-19 04:27:26'),(28,'Side Salad',0.60,18,'2018-07-19 04:25:07','2018-07-19 04:27:49'),(29,'Side Salad',0.60,19,'2018-07-19 04:25:21','2018-07-19 04:28:28'),(30,'Side Salad',0.60,20,'2018-07-19 04:25:35','2018-07-19 04:28:50'),(31,'Side Salad',0.60,21,'2018-07-19 04:26:01','2018-07-19 04:29:12'),(33,'Side Salad',0.60,23,'2018-07-19 04:26:30','2018-07-19 04:29:57'),(34,'Coleslaw',0.80,16,'2018-07-19 04:27:13','2018-07-30 17:50:32'),(35,'Coleslaw',0.80,17,'2018-07-19 04:27:34','2018-07-30 17:51:13'),(36,'Coleslaw',0.80,18,'2018-07-19 04:28:16','2018-07-30 17:51:43'),(37,'Coleslaw',0.80,19,'2018-07-19 04:28:35','2018-07-30 17:52:08'),(38,'Coleslaw',0.80,20,'2018-07-19 04:28:59','2018-07-30 17:52:35'),(39,'Coleslaw',0.80,21,'2018-07-19 04:29:19','2018-07-30 17:53:01'),(41,'Coleslaw',0.80,23,'2018-07-19 04:30:07','2018-07-30 17:53:30'),(58,'Caesar French Dressing',0.00,52,'2018-07-26 14:24:01','2018-07-26 14:24:18'),(59,'Honey Mustard',0.00,52,'2018-07-26 14:24:29','2018-07-26 14:24:29'),(60,'Cilantro and Avocado',0.00,52,'2018-07-26 14:24:44','2018-07-26 14:24:44'),(61,'Olive Oil',0.00,52,'2018-07-26 14:25:01','2018-07-26 14:25:01'),(62,'Chipotle',0.00,52,'2018-07-26 14:25:13','2018-07-26 14:25:13'),(63,'Bacon Bits',0.60,52,'2018-07-26 14:25:28','2018-07-26 14:25:28'),(64,'Chicken',1.00,52,'2018-07-26 14:25:42','2018-07-26 14:25:42'),(65,'Avocado',0.80,52,'2018-07-26 14:25:56','2018-07-26 14:25:56'),(66,'Cheese',0.60,52,'2018-07-26 14:26:11','2018-07-26 14:26:11'),(67,'Coleslaw',0.80,52,'2018-07-26 14:26:24','2018-07-26 14:26:40'),(68,'Egg',0.60,52,'2018-07-26 14:26:49','2018-07-26 14:26:49'),(69,'Caesar French Dressing',0.00,53,'2018-07-26 14:28:28','2018-07-26 14:28:28'),(70,'Honey Mustard',0.00,53,'2018-07-26 14:28:38','2018-07-26 14:28:38'),(71,'Cilantro and Avocado',0.00,53,'2018-07-26 14:28:47','2018-07-26 14:28:47'),(72,'Olive Oil',0.00,53,'2018-07-26 14:28:56','2018-07-26 14:28:56'),(73,'Chipotle',0.00,53,'2018-07-26 14:29:04','2018-07-26 14:29:04'),(74,'Bacon Bits',0.60,53,'2018-07-26 14:29:30','2018-07-26 14:29:30'),(75,'Chicken',1.00,53,'2018-07-26 14:29:43','2018-07-26 14:29:43'),(76,'Avocado',0.80,53,'2018-07-26 14:29:56','2018-07-26 14:29:56'),(77,'Cheese',0.60,53,'2018-07-26 14:30:06','2018-07-26 14:30:06'),(78,'Coleslaw',0.80,53,'2018-07-26 14:30:17','2018-07-26 14:30:17'),(79,'Egg',0.60,53,'2018-07-26 14:30:27','2018-07-26 14:30:27'),(80,'Caesar French Dressing',0.00,56,'2018-07-26 14:30:47','2018-07-26 14:30:47'),(81,'Honey Mustard',0.00,56,'2018-07-26 14:30:56','2018-07-26 14:30:56'),(82,'Cilantro and Avocado',0.00,56,'2018-07-26 14:31:06','2018-07-26 14:31:06'),(83,'Olive Oil',0.00,56,'2018-07-26 14:31:17','2018-07-26 14:31:17'),(84,'Chipotle',0.00,56,'2018-07-26 14:31:27','2018-07-26 14:31:27'),(85,'Bacon Bits',0.60,56,'2018-07-26 14:31:39','2018-07-26 14:31:39'),(86,'Chicken',1.00,56,'2018-07-26 14:31:49','2018-07-26 14:31:49'),(87,'Avocado',0.80,56,'2018-07-26 14:32:01','2018-07-26 14:32:01'),(88,'Cheese',0.60,56,'2018-07-26 14:32:11','2018-07-26 14:32:11'),(89,'Coleslaw',0.80,56,'2018-07-26 14:32:22','2018-07-26 14:32:22'),(90,'Egg',0.60,56,'2018-07-26 14:32:31','2018-07-26 14:32:31'),(91,'Caesar French Dressing',0.00,57,'2018-07-26 14:32:50','2018-07-26 14:32:50'),(92,'Honey Mustard',0.00,57,'2018-07-26 14:32:59','2018-07-26 14:32:59'),(93,'Cilantro and Avocado',0.00,57,'2018-07-26 14:33:08','2018-07-26 14:33:08'),(94,'Olive Oil',0.00,57,'2018-07-26 14:33:17','2018-07-26 14:33:17'),(95,'Chipotle',0.00,57,'2018-07-26 14:33:26','2018-07-26 14:33:26'),(96,'Bacon Bits',0.60,57,'2018-07-26 14:33:40','2018-07-26 14:33:40'),(97,'Chicken',1.00,57,'2018-07-26 14:33:50','2018-07-26 14:33:50'),(98,'Avocado',0.80,57,'2018-07-26 14:33:59','2018-07-26 14:33:59'),(99,'Cheese',0.60,57,'2018-07-26 14:34:09','2018-07-26 14:34:09'),(100,'Coleslaw',0.80,57,'2018-07-26 14:34:23','2018-07-26 14:34:23'),(101,'Egg',0.60,57,'2018-07-26 14:34:33','2018-07-26 14:34:33'),(102,'Caesar French Dressing',0.00,60,'2018-07-26 14:34:57','2018-07-26 14:34:57'),(103,'Honey Mustard',0.00,60,'2018-07-26 14:35:08','2018-07-26 14:35:08'),(104,'Cilantro and Avocado',0.00,60,'2018-07-26 14:35:16','2018-07-26 14:35:16'),(105,'Olive Oil',0.00,60,'2018-07-26 14:35:25','2018-07-26 14:35:25'),(106,'Chipotle',0.00,60,'2018-07-26 14:35:34','2018-07-26 14:35:34'),(107,'Bacon Bits',0.60,60,'2018-07-26 14:35:47','2018-07-26 14:35:47'),(108,'Chicken',1.00,60,'2018-07-26 14:35:56','2018-07-26 14:35:56'),(109,'Avocado',0.80,60,'2018-07-26 14:36:06','2018-07-26 14:36:06'),(110,'Cheese',0.60,60,'2018-07-26 14:36:16','2018-07-26 14:36:16'),(111,'Coleslaw',0.80,60,'2018-07-26 14:36:26','2018-07-26 14:36:26'),(112,'Egg',0.60,60,'2018-07-26 14:36:36','2018-07-26 14:36:36'),(113,'Caesar French Dressing',0.00,61,'2018-07-26 14:36:57','2018-07-26 14:36:57'),(114,'Honey Mustard',0.00,61,'2018-07-26 14:37:05','2018-07-26 14:37:05'),(115,'Cilantro and Avocado',0.00,61,'2018-07-26 14:37:32','2018-07-26 14:37:32'),(116,'Olive Oil',0.00,61,'2018-07-26 14:37:40','2018-07-26 14:37:40'),(117,'Chipotle',0.00,61,'2018-07-26 14:37:48','2018-07-26 14:37:48'),(118,'Bacon Bits',0.60,61,'2018-07-26 14:37:59','2018-07-26 14:37:59'),(119,'Chicken',1.00,61,'2018-07-26 14:38:09','2018-07-26 14:38:09'),(120,'Avocado',0.80,61,'2018-07-26 14:38:24','2018-07-26 14:38:24'),(121,'Cheese',0.60,61,'2018-07-26 14:38:34','2018-07-26 14:38:34'),(122,'Coleslaw',0.80,61,'2018-07-26 14:38:44','2018-07-26 14:38:44'),(123,'Egg',0.60,61,'2018-07-26 14:38:54','2018-07-26 14:38:54'),(124,'Caesar French Dressing',0.00,134,'2018-07-26 14:39:15','2018-07-26 14:39:15'),(125,'Honey Mustard',0.00,134,'2018-07-26 14:39:25','2018-07-26 14:39:25'),(126,'Cilantro and Avocado',0.00,134,'2018-07-26 14:39:34','2018-07-26 14:39:34'),(127,'Olive Oil',0.00,134,'2018-07-26 14:39:42','2018-07-26 14:39:42'),(128,'Chipotle',0.00,134,'2018-07-26 14:39:51','2018-07-26 14:39:51'),(129,'Bacon Bits',0.60,134,'2018-07-26 14:40:04','2018-07-26 14:40:04'),(130,'Chicken',1.00,134,'2018-07-26 14:40:12','2018-07-26 14:40:12'),(131,'Avocado',0.80,134,'2018-07-26 14:40:24','2018-07-26 14:40:24'),(132,'Cheese',0.60,134,'2018-07-26 14:40:34','2018-07-26 14:40:34'),(133,'Coleslaw',0.80,134,'2018-07-26 14:40:44','2018-07-26 14:40:44'),(134,'Egg',0.60,134,'2018-07-26 14:40:53','2018-07-26 14:40:53'),(135,'Caesar French Dressing',0.00,135,'2018-07-26 14:41:16','2018-07-26 14:41:16'),(136,'Honey Mustard',0.00,135,'2018-07-26 14:41:26','2018-07-26 14:41:26'),(137,'Cilantro and Avocado',0.00,135,'2018-07-26 14:41:34','2018-07-26 14:41:34'),(138,'Olive Oil',0.00,135,'2018-07-26 14:41:46','2018-07-26 14:41:46'),(139,'Chipotle',0.00,135,'2018-07-26 14:42:01','2018-07-26 14:42:01'),(140,'Bacon Bits',0.60,135,'2018-07-26 14:42:15','2018-07-26 14:42:15'),(141,'Chicken',1.00,135,'2018-07-26 14:42:25','2018-07-26 14:42:25'),(142,'Avocado',0.80,135,'2018-07-26 14:42:36','2018-07-26 14:42:36'),(143,'Cheese',0.60,135,'2018-07-26 14:42:49','2018-07-26 14:42:49'),(144,'Coleslaw',0.80,135,'2018-07-26 14:43:01','2018-07-26 14:43:01'),(145,'Egg',0.60,135,'2018-07-26 14:43:14','2018-07-26 14:43:14'),(146,'Caesar French Dressing',0.00,136,'2018-07-26 14:43:32','2018-07-26 14:43:32'),(147,'Honey Mustard',0.00,136,'2018-07-26 14:43:40','2018-07-26 14:43:40'),(148,'Cilantro and Avocado',0.00,136,'2018-07-26 14:43:48','2018-07-26 14:43:48'),(149,'Olive Oil',0.00,136,'2018-07-26 14:43:58','2018-07-26 14:43:58'),(150,'Chipotle',0.00,136,'2018-07-26 14:44:06','2018-07-26 14:44:06'),(151,'Bacon Bits',0.60,136,'2018-07-26 14:44:22','2018-07-26 14:44:22'),(152,'Chicken',1.00,136,'2018-07-26 14:44:32','2018-07-26 14:44:32'),(153,'Avocado',0.80,136,'2018-07-26 14:44:42','2018-07-26 14:44:42'),(154,'Cheese',0.60,136,'2018-07-26 14:44:51','2018-07-26 14:44:51'),(155,'Coleslaw',0.80,136,'2018-07-26 14:45:01','2018-07-26 14:45:01'),(156,'Egg',0.60,136,'2018-07-26 14:45:13','2018-07-26 14:45:13'),(157,'Caesar French Dressing',0.00,137,'2018-07-26 14:45:29','2018-07-26 14:45:29'),(158,'Honey Mustard',0.00,137,'2018-07-26 14:45:36','2018-07-26 14:45:36'),(159,'Cilantro and Avocado',0.00,137,'2018-07-26 14:45:45','2018-07-26 14:45:45'),(160,'Olive Oil',0.00,137,'2018-07-26 14:46:52','2018-07-26 14:46:52'),(161,'Chipotle',0.00,137,'2018-07-26 14:47:03','2018-07-26 14:47:03'),(162,'Bacon Bits',0.60,137,'2018-07-26 14:47:15','2018-07-26 14:47:24'),(163,'Chicken',1.00,137,'2018-07-26 14:47:35','2018-07-26 14:47:35'),(164,'Avocado',0.80,137,'2018-07-26 14:47:44','2018-07-26 14:47:44'),(165,'Cheese',0.60,137,'2018-07-26 14:47:54','2018-07-26 14:47:54'),(166,'Coleslaw',0.80,137,'2018-07-26 14:48:05','2018-07-26 14:48:05'),(167,'Egg',0.60,137,'2018-07-26 14:48:15','2018-07-26 14:48:15'),(168,'Chicken',1.00,27,'2018-07-26 20:55:18','2018-07-26 20:55:18'),(169,'Chicken',1.00,28,'2018-07-26 21:28:11','2018-07-26 21:28:11'),(170,'Chicken',1.00,29,'2018-07-26 21:28:30','2018-07-26 21:28:30'),(171,'Chicken',1.00,30,'2018-07-26 21:28:45','2018-07-26 21:28:45'),(172,'Chicken',1.00,138,'2018-07-26 21:29:15','2018-07-26 21:29:15'),(173,'Chicken',1.00,139,'2018-07-26 21:29:31','2018-07-26 21:29:31'),(174,'Chicken',1.00,102,'2018-07-26 21:34:17','2018-07-26 21:34:17'),(175,'Chicken',1.00,103,'2018-07-26 21:34:44','2018-07-26 21:34:44'),(176,'Chicken',1.00,104,'2018-07-26 21:34:58','2018-07-26 21:34:58'),(177,'Chicken',1.00,140,'2018-07-26 21:35:16','2018-07-26 21:35:16'),(178,'Chicken',1.00,141,'2018-07-26 21:35:31','2018-07-26 21:35:31'),(179,'Foot long (all foot longs served in large baguettes)',2.00,62,'2018-07-26 21:52:27','2018-07-26 21:52:27'),(180,'Foot long (all foot longs served in large baguettes)',2.00,65,'2018-07-26 21:52:44','2018-07-26 21:52:44'),(181,'Foot long (all foot longs served in large baguettes)',2.00,152,'2018-07-26 21:52:59','2018-07-26 21:52:59'),(182,'Foot long (all foot longs served in large baguettes)',2.00,153,'2018-07-26 21:53:20','2018-07-26 21:53:20'),(183,'Foot long (all foot longs served in large baguettes)',2.00,154,'2018-07-26 21:53:36','2018-07-26 21:53:36'),(184,'Coleslaw',0.80,69,'2018-07-26 22:01:10','2018-07-26 22:01:10'),(185,'Coleslaw',0.80,72,'2018-07-26 22:01:23','2018-07-26 22:01:23'),(186,'Coleslaw',0.80,74,'2018-07-26 22:01:38','2018-07-26 22:01:38'),(187,'Coleslaw',0.80,75,'2018-07-26 22:01:53','2018-07-26 22:01:53'),(188,'Coleslaw',0.80,76,'2018-07-26 22:02:08','2018-07-26 22:02:08'),(189,'Coleslaw',0.80,155,'2018-07-26 22:02:22','2018-07-26 22:02:22'),(190,'Avocado',0.80,155,'2018-07-26 22:02:34','2018-07-26 22:02:34'),(191,'Avocado',0.80,69,'2018-07-26 22:02:47','2018-07-26 22:02:47'),(192,'Avocado',0.80,72,'2018-07-26 22:03:00','2018-07-26 22:03:00'),(193,'Avocado',0.80,74,'2018-07-26 22:03:16','2018-07-26 22:03:16'),(194,'Avocado',0.80,75,'2018-07-26 22:03:31','2018-07-26 22:03:31'),(195,'Avocado',0.80,76,'2018-07-26 22:03:45','2018-07-26 22:03:45'),(196,'Bacon',1.00,80,'2018-07-26 22:08:24','2018-07-26 22:08:24'),(197,'Bacon',1.00,81,'2018-07-26 22:08:40','2018-07-26 22:08:40'),(198,'Bacon',1.00,82,'2018-07-26 22:08:53','2018-07-26 22:08:53'),(199,'Bacon',1.00,156,'2018-07-26 22:09:07','2018-07-26 22:09:07'),(200,'Bacon',1.00,157,'2018-07-26 22:09:22','2018-07-26 22:09:22'),(201,'Bacon',1.00,158,'2018-07-26 22:09:49','2018-07-26 22:09:49'),(202,'Hash Browns',1.00,169,'2018-07-30 17:34:14','2018-07-30 17:34:14'),(203,'Hash Browns',1.00,170,'2018-07-30 17:34:26','2018-07-30 17:34:26'),(204,'Hash Browns',1.00,171,'2018-07-30 17:34:37','2018-07-30 17:34:37'),(205,'Hash Browns',1.00,172,'2018-07-30 17:34:52','2018-07-30 17:34:52'),(206,'Hash Browns',1.00,173,'2018-07-30 17:35:04','2018-07-30 17:35:04'),(207,'Hash Browns',1.00,174,'2018-07-30 17:35:16','2018-07-30 17:35:16'),(208,'Hash Browns',1.00,175,'2018-07-30 17:35:28','2018-07-30 17:35:28'),(209,'Baked Beans',0.60,175,'2018-07-30 17:35:45','2018-07-30 17:35:45'),(210,'Baked Beans',0.60,169,'2018-07-30 17:35:57','2018-07-30 17:35:57'),(211,'Baked Beans',0.60,170,'2018-07-30 17:36:09','2018-07-30 17:36:09'),(212,'Baked Beans',0.60,171,'2018-07-30 17:36:20','2018-07-30 17:36:20'),(213,'Baked Beans',0.60,172,'2018-07-30 17:36:32','2018-07-30 17:36:32'),(214,'Baked Beans',0.60,173,'2018-07-30 17:36:46','2018-07-30 17:36:46'),(215,'Baked Beans',0.60,174,'2018-07-30 17:36:58','2018-07-30 17:36:58'),(216,'Bacon',1.00,175,'2018-07-30 17:37:26','2018-07-30 17:37:26'),(217,'Bacon',1.00,169,'2018-07-30 17:37:37','2018-07-30 17:37:37'),(218,'Bacon',1.00,170,'2018-07-30 17:37:48','2018-07-30 17:37:48'),(219,'Bacon',1.00,171,'2018-07-30 17:38:01','2018-07-30 17:38:01'),(220,'Bacon',1.00,172,'2018-07-30 17:38:13','2018-07-30 17:38:13'),(221,'Bacon',1.00,173,'2018-07-30 17:38:24','2018-07-30 17:38:24'),(222,'Bacon',1.00,174,'2018-07-30 17:38:35','2018-07-30 17:38:35'),(223,'Cheese',0.60,175,'2018-07-30 17:38:51','2018-07-30 17:38:51'),(224,'Cheese',0.60,169,'2018-07-30 17:39:02','2018-07-30 17:39:02'),(225,'Cheese',0.60,170,'2018-07-30 17:39:13','2018-07-30 17:39:13'),(226,'Cheese',0.60,171,'2018-07-30 17:39:25','2018-07-30 17:39:25'),(227,'Cheese',0.60,172,'2018-07-30 17:39:37','2018-07-30 17:39:37'),(228,'Cheese',0.60,173,'2018-07-30 17:39:51','2018-07-30 17:39:51'),(229,'Cheese',0.60,174,'2018-07-30 17:40:03','2018-07-30 17:40:03'),(230,'Toast',0.75,175,'2018-07-30 17:40:26','2018-07-30 17:40:26'),(231,'Toast',0.75,169,'2018-07-30 17:40:39','2018-07-30 17:40:39'),(232,'Toast',0.75,170,'2018-07-30 17:40:54','2018-07-30 17:40:54'),(233,'Toast',0.75,171,'2018-07-30 17:41:05','2018-07-30 17:41:05'),(234,'Toast',0.75,172,'2018-07-30 17:41:17','2018-07-30 17:41:17'),(235,'Toast',0.75,173,'2018-07-30 17:41:29','2018-07-30 17:41:29'),(236,'Toast',0.75,174,'2018-07-30 17:41:42','2018-07-30 17:41:42'),(237,'Ketchup',0.00,180,'2018-07-30 17:47:29','2018-07-30 17:47:29'),(238,'Brown Sauce',0.00,180,'2018-07-30 17:47:39','2018-07-30 17:47:39'),(239,'Hummus',1.50,16,'2018-07-30 17:51:01','2018-07-30 17:51:01'),(240,'Hummus',1.50,17,'2018-07-30 17:51:25','2018-07-30 17:51:25'),(241,'Hummus',1.50,18,'2018-07-30 17:51:55','2018-07-30 17:51:55'),(242,'Hummus',1.50,19,'2018-07-30 17:52:21','2018-07-30 17:52:21'),(243,'Hummus',1.50,20,'2018-07-30 17:52:47','2018-07-30 17:52:47'),(244,'Hummus',1.50,21,'2018-07-30 17:53:16','2018-07-30 17:53:16'),(245,'Hummus',1.50,23,'2018-07-30 17:53:43','2018-07-30 17:53:43'),(246,'Hummus',1.50,132,'2018-07-30 17:54:07','2018-07-30 17:54:07'),(247,'Hummus',1.50,133,'2018-07-30 17:54:19','2018-07-30 17:54:19'),(248,'Coleslaw',0.80,133,'2018-07-30 17:54:36','2018-07-30 17:54:36'),(249,'Olives',2.00,133,'2018-07-30 17:54:47','2018-07-30 17:54:47'),(250,'Side Salad',0.60,133,'2018-07-30 17:55:01','2018-07-30 17:55:01'),(251,'Side Salad',0.60,132,'2018-07-30 17:55:48','2018-07-30 17:55:48'),(252,'Coleslaw',0.80,132,'2018-07-30 17:55:59','2018-07-30 17:55:59'),(253,'Olives',2.00,132,'2018-07-30 17:56:07','2018-07-30 17:56:07'),(254,'Olives',2.00,16,'2018-07-30 17:56:20','2018-07-30 17:56:20'),(255,'Olives',2.00,17,'2018-07-30 17:56:30','2018-07-30 17:56:30'),(256,'Olives',2.00,18,'2018-07-30 17:56:42','2018-07-30 17:56:42'),(257,'Olives',2.00,19,'2018-07-30 17:56:53','2018-07-30 17:56:53'),(258,'Olives',2.00,20,'2018-07-30 17:57:05','2018-07-30 17:57:05'),(259,'Olives',2.00,21,'2018-07-30 17:57:17','2018-07-30 17:57:17'),(260,'Olives',2.00,23,'2018-07-30 17:57:31','2018-07-30 17:57:31'),(264,'Hummus',1.50,143,'2018-07-30 20:32:49','2018-07-30 20:32:49'),(265,'Hummus',1.50,144,'2018-07-30 20:33:04','2018-07-30 20:33:04'),(266,'Hummus',1.50,145,'2018-07-30 20:33:22','2018-07-30 20:33:22'),(270,'Olives',2.00,143,'2018-07-30 20:34:34','2018-07-30 20:34:34'),(271,'Olives',2.00,144,'2018-07-30 20:34:50','2018-07-30 20:34:50'),(272,'Olives',2.00,145,'2018-07-30 20:35:05','2018-07-30 20:35:05'),(273,'Coleslaw',0.80,145,'2018-07-30 20:35:18','2018-07-30 20:35:18'),(274,'Coleslaw',0.80,143,'2018-07-30 20:35:33','2018-07-30 20:35:33'),(275,'Coleslaw',0.80,144,'2018-07-30 20:35:45','2018-07-30 20:35:45'),(276,'Side Salad',0.60,145,'2018-07-30 20:36:20','2018-07-30 20:36:20'),(277,'Side Salad',0.60,143,'2018-07-30 20:36:37','2018-07-30 20:36:37'),(278,'Side Salad',0.60,144,'2018-07-30 20:36:52','2018-07-30 20:36:52'),(279,'Coleslaw',0.80,146,'2018-07-30 20:38:37','2018-07-30 20:38:37'),(280,'Coleslaw',0.80,147,'2018-07-30 20:38:48','2018-07-30 20:38:48'),(281,'Coleslaw',0.80,148,'2018-07-30 20:39:00','2018-07-30 20:39:00'),(282,'Coleslaw',0.80,149,'2018-07-30 20:39:11','2018-07-30 20:39:11'),(283,'Coleslaw',0.80,150,'2018-07-30 20:39:23','2018-07-30 20:39:23'),(284,'Coleslaw',0.80,151,'2018-07-30 20:39:37','2018-07-30 20:39:37'),(285,'Hummus',1.50,146,'2018-07-30 20:40:06','2018-07-30 20:40:06'),(286,'Hummus',1.50,147,'2018-07-30 20:40:19','2018-07-30 20:40:19'),(287,'Hummus',1.50,148,'2018-07-30 20:40:33','2018-07-30 20:40:33'),(288,'Hummus',1.50,149,'2018-07-30 20:40:45','2018-07-30 20:40:45'),(289,'Hummus',1.50,150,'2018-07-30 20:41:06','2018-07-30 20:41:06'),(290,'Hummus',1.50,151,'2018-07-30 20:41:20','2018-07-30 20:41:20'),(291,'Olives',2.00,146,'2018-07-30 20:41:38','2018-07-30 20:41:38'),(292,'Olives',2.00,147,'2018-07-30 20:41:50','2018-07-30 20:41:50'),(293,'Olives',2.00,148,'2018-07-30 20:42:03','2018-07-30 20:42:03'),(294,'Olives',2.00,149,'2018-07-30 20:42:16','2018-07-30 20:42:16'),(295,'Olives',2.00,150,'2018-07-30 20:42:31','2018-07-30 20:42:31'),(296,'Olives',2.00,151,'2018-07-30 20:42:46','2018-07-30 20:43:01'),(297,'Side Salad',0.60,151,'2018-07-30 20:43:14','2018-07-30 20:43:14'),(298,'Side Salad',0.60,146,'2018-07-30 20:43:27','2018-07-30 20:43:27'),(299,'Side Salad',0.60,148,'2018-07-30 20:43:40','2018-07-30 20:43:40'),(300,'Side Salad',0.60,149,'2018-07-30 20:43:53','2018-07-30 20:43:53'),(301,'Side Salad',0.60,150,'2018-07-30 20:44:05','2018-07-30 20:44:05'),(302,'Coleslaw',0.80,62,'2018-07-30 20:45:44','2018-07-30 20:45:44'),(303,'Hummus',1.50,62,'2018-07-30 20:45:57','2018-07-30 20:45:57'),(304,'Coleslaw',0.80,65,'2018-07-30 20:46:25','2018-07-30 20:46:25'),(305,'Coleslaw',0.80,152,'2018-07-30 20:46:42','2018-07-30 20:46:42'),(306,'Coleslaw',0.80,153,'2018-07-30 20:46:54','2018-07-30 20:46:54'),(307,'Coleslaw',0.80,154,'2018-07-30 20:47:08','2018-07-30 20:47:08'),(308,'Hummus',1.50,154,'2018-07-30 20:47:22','2018-07-30 20:47:22'),(309,'Hummus',1.50,65,'2018-07-30 20:47:47','2018-07-30 20:47:47'),(310,'Hummus',1.50,152,'2018-07-30 20:47:57','2018-07-30 20:47:57'),(311,'Hummus',1.50,153,'2018-07-30 20:48:09','2018-07-30 20:48:09'),(312,'Olives',2.00,154,'2018-07-30 20:48:35','2018-07-30 20:48:35'),(313,'Olives',2.00,62,'2018-07-30 20:48:46','2018-07-30 20:48:46'),(314,'Olives',2.00,65,'2018-07-30 20:48:58','2018-07-30 20:48:58'),(315,'Olives',2.00,152,'2018-07-30 20:49:11','2018-07-30 20:49:11'),(316,'Olives',2.00,153,'2018-07-30 20:49:24','2018-07-30 20:49:24'),(317,'Side Salad',0.60,154,'2018-07-30 20:49:47','2018-07-30 20:49:47'),(318,'Side Salad',0.60,62,'2018-07-30 20:49:58','2018-07-30 20:49:58'),(319,'Side Salad',0.60,65,'2018-07-30 20:50:10','2018-07-30 20:50:10'),(320,'Side Salad',0.60,152,'2018-07-30 20:50:26','2018-07-30 20:50:26'),(321,'Side Salad',0.60,153,'2018-07-30 20:50:43','2018-07-30 20:50:43'),(322,'Teste Extra',1.00,186,'2019-02-17 16:50:31','2019-02-17 16:50:31');
/*!40000 ALTER TABLE `menu_extras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `menutype_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_menutype_id_foreign` (`menutype_id`),
  CONSTRAINT `menu_items_menutype_id_foreign` FOREIGN KEY (`menutype_id`) REFERENCES `menu_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (16,'Manhattan','Smoked bockwurst sausage, bacon, peppers, onions, dill pickle, chilli relish and mild American mustard.','http://localhost:8000/img/menu/ciabattas.jpg',5.45,3,'2018-07-18 03:26:13','2018-07-26 14:11:59'),(17,'Queens','Chicken, chorizo, mozzarella, lettuce, tomato, jalapenos & spicy chipotle sauce.','http://localhost:8000/img/menu/ciabattas.jpg',5.45,3,'2018-07-18 03:27:27','2018-07-26 14:10:20'),(18,'Brooklyn','Pastrami, aged cheddar cheese sauce, lettuce, tomato, gherkins and honey mustard.','http://localhost:8000/img/menu/ciabattas.jpg',4.95,3,'2018-07-18 03:27:59','2018-07-26 14:12:24'),(19,'Smokey Jo','Streaky bacon, smoked bockwurst sausage, aged cheddar cheese sauce, BBQ sauce, lettuce and tomato.','http://localhost:8000/img/menu/ciabattas.jpg',5.45,3,'2018-07-18 03:28:27','2018-07-26 14:11:29'),(20,'Philly Beef','Sliced roast beef, mozzarella, cheddar, peppers, onions, ranched dressing, lettuce and tomato.','http://localhost:8000/img/menu/ciabattas.jpg',4.95,3,'2018-07-18 03:28:59','2018-07-26 14:10:52'),(21,'New York BLT','Streaky bacon, aged cheddar sauce, lettuce, tomato and mayo.','http://localhost:8000/img/menu/ciabattas.jpg',4.95,3,'2018-07-18 03:29:34','2018-07-26 14:09:00'),(23,'Frankie\'s All Italian','Pepperoni, salami, ham, mozzarella, Italian pizza sauce, garlic mayo, tomato and lettuce.','http://localhost:8000/img/menu/ciabattas.jpg',5.95,3,'2018-07-18 03:30:49','2018-07-26 14:13:51'),(27,'Hummus and Avocado','With lettuce, tomato, cucumber and roasted pepper.','http://localhost:8000/img/menu/cold%20wraps.jpg',4.45,4,'2018-07-18 05:12:18','2018-07-26 20:54:14'),(28,'Prawn Mayo and Avocado','With lettuce, tomato and cucumber.','http://localhost:8000/img/menu/cold%20wraps.jpg',4.95,4,'2018-07-18 05:12:53','2018-07-26 20:51:14'),(29,'Turkey, Bacon and Ranch',NULL,'http://localhost:8000/img/menu/cold%20wraps.jpg',4.75,4,'2018-07-18 05:13:23','2018-07-26 20:49:59'),(30,'Harlem Special','Turkey, chorizo, cream cheese and chipotle sauce.','http://localhost:8000/img/menu/cold%20wraps.jpg',4.95,4,'2018-07-18 05:13:48','2018-07-26 20:54:24'),(42,'Water',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.20,7,'2018-07-18 05:29:11','2018-07-18 05:29:11'),(43,'Sparkling Water',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.40,7,'2018-07-18 05:29:30','2018-07-18 05:29:30'),(44,'Coke',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.65,7,'2018-07-18 05:29:45','2018-07-18 05:29:45'),(45,'Diet Coke',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.65,7,'2018-07-18 05:30:02','2018-07-18 05:30:02'),(46,'Sprite',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.65,7,'2018-07-18 05:30:18','2018-07-18 05:30:18'),(47,'Snapple','Fruit punch','http://localhost:8000/img/menu/drinks.jpg',1.95,7,'2018-07-18 05:30:47','2018-07-18 05:30:47'),(48,'San Pellegrino Lemon',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.45,7,'2018-07-18 05:31:08','2018-07-18 05:31:08'),(49,'San Pellegrino Orange',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.45,7,'2018-07-18 05:31:24','2018-07-18 05:31:24'),(50,'Lipton Iced Tea Lemon',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.80,7,'2018-07-18 05:31:45','2018-07-18 05:31:45'),(51,'Lipton Iced Tea Peach',NULL,'http://localhost:8000/img/menu/drinks.jpg',1.80,7,'2018-07-18 05:32:02','2018-07-18 05:32:02'),(52,'Chicken Caesar Salad (Reg)','With Romaine lettuce, red onions, home-made Caesar dressing, parmesan cheese, olives and croutons.','http://localhost:8000/img/menu/fresh%20salads.jpg',4.75,8,'2018-07-18 05:33:20','2018-07-26 14:18:47'),(53,'Chicken Caesar Salad (Lrg)','With Romaine lettuce, red onions, home-made Caesar dressing, parmesan cheese, olives and croutons.','http://localhost:8000/img/menu/fresh%20salads.jpg',5.25,8,'2018-07-18 05:34:00','2018-07-26 14:19:00'),(56,'Prawn and Avocado Salad (Reg)','With Romaine lettuce, tomato, cucumber, sweetcorn peppers and sweet chilli dressing.','http://localhost:8000/img/menu/fresh%20salads.jpg',5.45,8,'2018-07-18 05:35:39','2018-07-26 14:18:38'),(57,'Prawn and Avocado Salad (Lrg)','With Romaine lettuce, tomato, cucumber, sweetcorn peppers and sweet chilli dressing.','http://localhost:8000/img/menu/fresh%20salads.jpg',5.95,8,'2018-07-18 05:37:16','2018-07-26 14:19:28'),(60,'Quinoa Greek Feta Salad (Reg)','With Romaine lettuce, tomato, cucumber, spinach, onions, olives, roasted peppers  and a drizzle of olive oil.','http://localhost:8000/img/menu/fresh%20salads.jpg',4.45,8,'2018-07-18 05:38:54','2018-07-26 14:19:45'),(61,'Quinoa Greek Feta Salad (Lrg)','With Romaine lettuce, tomato, cucumber, spinach, onions, olives, roasted peppers  and a drizzle of olive oil.','http://localhost:8000/img/menu/fresh%20salads.jpg',4.95,8,'2018-07-18 05:39:18','2018-07-26 14:19:58'),(62,'Classic American','Bockwurst sausage, onions, ketchup and mustard.','http://localhost:8000/img/menu/hotdogs.jpg',4.25,9,'2018-07-18 05:40:32','2018-07-26 21:47:55'),(65,'New Yorker','Bockwurst sausage, gherkins, coleslaw and mustard.','http://localhost:8000/img/menu/hotdogs.jpg',4.75,9,'2018-07-18 05:41:52','2018-07-26 21:54:06'),(69,'Cheese and Bean','Side salad included.','http://localhost:8000/img/menu/baked%20potatoes.jpg',5.45,10,'2018-07-18 05:44:39','2018-07-26 21:59:57'),(72,'Prawn Mayo','Side salad included.','http://localhost:8000/img/menu/baked%20potatoes.jpg',6.25,10,'2018-07-18 05:45:36','2018-07-26 22:00:12'),(74,'Chicken, Pesto and Parmesan','Side salad included.','http://localhost:8000/img/menu/baked%20potatoes.jpg',5.95,10,'2018-07-18 05:46:07','2018-07-26 22:00:19'),(75,'Chicken, Caesar and Bacon','Side salad included.','http://localhost:8000/img/menu/baked%20potatoes.jpg',5.95,10,'2018-07-18 05:46:24','2018-07-26 22:00:27'),(76,'Bacon and Sour Cream','Side salad included.','http://localhost:8000/img/menu/baked%20potatoes.jpg',5.95,10,'2018-07-18 05:46:41','2018-07-26 22:00:35'),(80,'Mozzarela, Pesto and Pepper','With spinach.','http://localhost:8000/img/menu/paninis.jpg',4.75,11,'2018-07-18 05:55:11','2018-07-26 22:06:55'),(81,'BBQ Chicken and Cheese',NULL,'http://localhost:8000/img/menu/paninis.jpg',4.75,11,'2018-07-18 05:55:41','2018-07-26 22:07:29'),(82,'Brie, Bacon and Cranberry',NULL,'http://localhost:8000/img/menu/paninis.jpg',4.75,11,'2018-07-18 05:55:59','2018-07-26 22:05:47'),(102,'Falafel and Hummus','Falafel, hummus, spinach and mango chutney.','http://localhost:8000/img/menu/toasted%20wraps.jpg',4.75,13,'2018-07-18 06:07:35','2018-07-26 21:33:53'),(103,'Quesadilla','Salsa, sour cream, cheddar cheese, onions and jalapeno peppers.','http://localhost:8000/img/menu/toasted%20wraps.jpg',4.75,13,'2018-07-18 06:07:59','2018-07-26 21:31:01'),(104,'Fetadilla','Spinach, pesto, sun dried tomato and feta.','http://localhost:8000/img/menu/toasted%20wraps.jpg',4.75,13,'2018-07-18 06:08:22','2018-07-26 21:30:51'),(111,'Banana','Banana, low fat yogurt, cinnamon, almond milk and whey protein.','http://localhost:8000/img/menu/protein%20shakes.jpg',3.75,15,'2018-07-26 13:45:56','2018-07-26 14:04:15'),(112,'Strawberries','Strawberries, low fat yogurt, almond milk and whey protein.','http://localhost:8000/img/menu/protein%20shakes.jpg',3.75,15,'2018-07-26 13:46:15','2018-07-26 14:04:31'),(113,'Fruits of the Forest','Fruits of the forest, low fat yogurt, almond milk and whey protein.','http://localhost:8000/img/menu/protein%20shakes.jpg',3.75,15,'2018-07-26 13:47:52','2018-07-26 14:04:49'),(114,'Peanut butter and Banana','Peanut butter, banana and almond milk.','http://localhost:8000/img/menu/protein%20shakes.jpg',3.00,15,'2018-07-26 13:49:14','2018-07-26 14:05:16'),(115,'Oreo Cookies and Cream (Reg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',3.75,16,'2018-07-26 13:51:32','2018-07-26 13:51:50'),(116,'Oreo Cookies and Cream (Lrg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',4.75,16,'2018-07-26 13:52:07','2018-07-26 13:52:07'),(117,'Nutella Brownie (Reg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',3.75,16,'2018-07-26 13:52:29','2018-07-26 13:52:29'),(118,'Nutella Brownie (Lrg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',4.75,16,'2018-07-26 13:52:42','2018-07-26 13:52:42'),(119,'Chocolate Brownie (Reg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',3.75,16,'2018-07-26 13:53:09','2018-07-26 13:53:09'),(120,'Chocolate Brownie (Lrg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',4.75,16,'2018-07-26 13:53:22','2018-07-26 13:53:22'),(121,'Caramel and Toffee Crunch Brownie (Reg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',3.75,16,'2018-07-26 13:53:50','2018-07-26 13:53:50'),(122,'Caramel and Toffee Crunch Brownie (Lrg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',4.75,16,'2018-07-26 13:54:03','2018-07-26 13:54:03'),(123,'Strawberries and Cream (Reg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',3.75,16,'2018-07-26 13:54:28','2018-07-26 13:54:28'),(124,'Strawberries and Cream (Lrg)',NULL,'http://localhost:8000/img/menu/heavenly%20ice-cream%20shakes.jpg',4.75,16,'2018-07-26 13:54:40','2018-07-26 13:54:40'),(125,'Tropical Breeze (Reg)','Pineapple, mango, banana and orange juice.','http://localhost:8000/img/menu/fruit%20smoothies.jpg',3.75,17,'2018-07-26 13:57:34','2018-07-26 13:57:34'),(126,'Tropical Breeze (Lrg)','Pineapple, mango, banana and orange juice.','http://localhost:8000/img/menu/fruit%20smoothies.jpg',4.75,17,'2018-07-26 13:57:56','2018-07-26 13:57:56'),(127,'California (Reg)','Strawberries, orange juice and honey.','http://localhost:8000/img/menu/fruit%20smoothies.jpg',3.75,17,'2018-07-26 13:58:24','2018-07-26 13:58:24'),(128,'California (Lrg)','Strawberries, orange juice and honey.','http://localhost:8000/img/menu/fruit%20smoothies.jpg',4.75,17,'2018-07-26 13:58:45','2018-07-26 13:58:45'),(129,'Banana Blitz (Reg)','Banana, honey and cinnamon.','http://localhost:8000/img/menu/fruit%20smoothies.jpg',3.75,17,'2018-07-26 13:59:25','2018-07-26 14:00:01'),(130,'Banana Blitz (Lrg)','Banana, honey and cinnamon.','http://localhost:8000/img/menu/fruit%20smoothies.jpg',4.75,17,'2018-07-26 13:59:48','2018-07-26 14:00:20'),(131,'All Berry (Reg)','Apple juice and honey.','http://localhost:8000/img/menu/fruit%20smoothies.jpg',4.75,17,'2018-07-26 14:02:29','2018-07-26 14:02:29'),(132,'Meatball Marinara','Meatballs in a rich Italian sauce topped with mozzarella.','http://localhost:8000/img/menu/ciabattas.jpg',4.95,3,'2018-07-26 14:09:51','2018-07-26 14:09:51'),(133,'All Day Breakfast','Cumberland sausage, bacon, sliced egg, cheddar cheese and ketchup.','http://localhost:8000/img/menu/ciabattas.jpg',5.45,3,'2018-07-26 14:13:00','2018-07-26 14:13:00'),(134,'Moroccan Couscous Salad (Reg)','With Sun dried tomatoes, olives, feta, spinach and roasted red peppers.','http://localhost:8000/img/menu/fresh%20salads.jpg',4.75,8,'2018-07-26 14:20:43','2018-07-26 14:20:43'),(135,'Moroccan Couscous Salad (Lrg)','With sun dried tomatoes, olives, feta, spinach and roasted red peppers.','http://localhost:8000/img/menu/fresh%20salads.jpg',5.25,8,'2018-07-26 14:21:14','2018-07-26 14:21:14'),(136,'Mexican Wedge Salad (Reg)','Romaine lettuce, tortilla chips, sweetcorn, mixed peppers, five beans, red onion, cilantro and avocado dressing.','http://localhost:8000/img/menu/fresh%20salads.jpg',4.45,8,'2018-07-26 14:22:25','2018-07-26 14:22:25'),(137,'Mexican Wedge Salad (Lrg)','Romaine lettuce, tortilla chips, sweetcorn, mixed peppers, five beans, red onion, cilantro and avocado dressing.','http://localhost:8000/img/menu/fresh%20salads.jpg',4.95,8,'2018-07-26 14:22:59','2018-07-26 14:22:59'),(138,'Chicken Caesar and Bacon',NULL,'http://localhost:8000/img/menu/cold%20wraps.jpg',4.75,4,'2018-07-26 20:48:22','2018-07-26 20:51:39'),(139,'Falafel and Coriander','With tomato, cucumber and sweet chilli dressing.','http://localhost:8000/img/menu/cold%20wraps.jpg',4.45,4,'2018-07-26 20:52:46','2018-07-26 20:54:32'),(140,'Chicken Fajita','Chicken, salsa relish, sour cream, peppers and onions.','http://localhost:8000/img/menu/toasted%20wraps.jpg',4.75,13,'2018-07-26 21:31:32','2018-07-26 21:31:32'),(141,'Burrito','Beef chilli, sour cream, salsa, rice and cheddar.','http://localhost:8000/img/menu/toasted%20wraps.jpg',5.45,13,'2018-07-26 21:32:05','2018-07-26 21:32:05'),(143,'Chicken, Chorizo and Avocado','With chipotle sauce.','http://localhost:8000/img/menu/cold%20bagels.jpg',4.75,2,'2018-07-26 21:38:51','2018-07-26 21:38:51'),(144,'All Italian','Pepperoni, salami, mozzarella, ranch dressing, lettuce and tomato.','http://localhost:8000/img/menu/cold%20bagels.jpg',4.75,2,'2018-07-26 21:39:56','2018-07-26 21:39:56'),(145,'South Street','Seafood cocktail in a marie rose sauce, avocado, lettuce and tomato.','http://localhost:8000/img/menu/cold%20bagels.jpg',4.75,2,'2018-07-26 21:40:33','2018-07-26 21:40:33'),(146,'Bacon and Cheese',NULL,'http://localhost:8000/img/menu/hot%20bagels.jpg',4.25,18,'2018-07-26 21:43:40','2018-07-26 21:43:40'),(147,'Ham and Cheese',NULL,'http://localhost:8000/img/menu/hot%20bagels.jpg',4.25,18,'2018-07-26 21:43:56','2018-07-26 21:43:56'),(148,'Chorizo, Cheese and Jalapenos','With chipotle sauce.','http://localhost:8000/img/menu/hot%20bagels.jpg',4.75,18,'2018-07-26 21:44:35','2018-07-26 21:44:35'),(149,'Pepperoni Mix','Pepperoni, ham, mozzarella and sun dried tomato.','http://localhost:8000/img/menu/hot%20bagels.jpg',4.75,18,'2018-07-26 21:45:08','2018-07-26 21:45:08'),(150,'BLT',NULL,'http://localhost:8000/img/menu/hot%20bagels.jpg',3.95,18,'2018-07-26 21:45:22','2018-07-26 21:45:22'),(151,'Roast Beef and Mozzarella','With garlic mayo, lettuce and tomato.','http://localhost:8000/img/menu/hot%20bagels.jpg',4.45,18,'2018-07-26 21:45:56','2018-07-30 20:39:51'),(152,'Beef Chilli Dog','Borkwurst sausage topped with beef chilli, jalapeno and salsa.','http://localhost:8000/img/menu/hotdogs.jpg',5.45,9,'2018-07-26 21:48:43','2018-07-26 21:48:43'),(153,'Uptown','Bockwurst sausage, sauerkraut and mustard.','http://localhost:8000/img/menu/hotdogs.jpg',4.45,9,'2018-07-26 21:50:41','2018-07-26 21:54:19'),(154,'Bacon and Cheese Dog','With bockwurst sausage.','http://localhost:8000/img/menu/hotdogs.jpg',5.75,9,'2018-07-26 21:51:18','2018-07-26 21:54:42'),(155,'Beef Chilli','Topped with sour cream and jalapenos. Side salad included.','http://localhost:8000/img/menu/baked%20potatoes.jpg',5.95,10,'2018-07-26 21:57:54','2018-07-26 22:00:43'),(156,'Sriracha Tuna and Cheese','With peppers and onions.','http://localhost:8000/img/menu/paninis.jpg',4.75,11,'2018-07-26 22:04:49','2018-07-26 22:04:49'),(157,'Tikka Cheese and Jalapenos',NULL,'http://localhost:8000/img/menu/paninis.jpg',4.75,11,'2018-07-26 22:05:22','2018-07-26 22:05:22'),(158,'Roast Beef and Mozzarella','With mushrooms, onions and garlic mayo.','http://localhost:8000/img/menu/paninis.jpg',4.75,11,'2018-07-26 22:06:21','2018-07-26 22:06:21'),(159,'Iced Latte',NULL,'http://localhost:8000/img/menu/iced%20beverages.jpg',2.95,19,'2018-07-30 17:17:16','2018-07-30 17:17:16'),(160,'Iced Mocha',NULL,'http://localhost:8000/img/menu/iced%20beverages.jpg',2.95,19,'2018-07-30 17:17:33','2018-07-30 17:17:33'),(161,'Mocha',NULL,'http://localhost:8000/img/menu/frappes.jpg',3.75,20,'2018-07-30 17:19:03','2018-07-30 17:19:03'),(162,'Vanilla',NULL,'http://localhost:8000/img/menu/frappes.jpg',3.75,20,'2018-07-30 17:19:24','2018-07-30 17:19:24'),(163,'Caramel',NULL,'http://localhost:8000/img/menu/frappes.jpg',3.75,20,'2018-07-30 17:19:35','2018-07-30 17:19:35'),(164,'Espresso',NULL,'http://localhost:8000/img/menu/frappes.jpg',3.75,20,'2018-07-30 17:19:46','2018-07-30 17:19:46'),(165,'Matcha',NULL,'http://localhost:8000/img/menu/frappes.jpg',3.75,20,'2018-07-30 17:19:57','2018-07-30 17:19:57'),(166,'Nacho Chips','With salsa, cheddar, jalapeno and sour cream.','http://localhost:8000/img/menu/snacks.jpg',2.75,21,'2018-07-30 17:27:37','2018-07-30 17:27:37'),(167,'Tortilla Chips','With hummus.','http://localhost:8000/img/menu/snacks.jpg',2.75,21,'2018-07-30 17:28:00','2018-07-30 17:28:00'),(168,'Meatballs Marinara','With parmesan cheese.','http://localhost:8000/img/menu/snacks.jpg',2.95,21,'2018-07-30 17:28:23','2018-07-30 17:28:23'),(169,'Bacon Bagel',NULL,'http://localhost:8000/img/menu/breakfast.jpg',2.75,22,'2018-07-30 17:29:53','2018-07-30 17:30:01'),(170,'Poached Egg and Bacon',NULL,'http://localhost:8000/img/menu/breakfast.jpg',2.95,22,'2018-07-30 17:30:23','2018-07-30 17:30:23'),(171,'Breakfast Bagel','Scrambled egg, bacon, poached egg and cheddar.','http://localhost:8000/img/menu/breakfast.jpg',3.75,22,'2018-07-30 17:30:51','2018-07-30 17:30:51'),(172,'Breakfast Quesadilla','Scrambled egg, sausage, cheddar, tomatoes, chilli relish and onions, served with sliced avocado and sour cream.','http://localhost:8000/img/menu/breakfast.jpg',4.75,22,'2018-07-30 17:31:21','2018-07-30 17:31:21'),(173,'Avocado and Toast','x2 on brown bread with poached egg and crispy bacon.','http://localhost:8000/img/menu/breakfast.jpg',4.75,22,'2018-07-30 17:32:08','2018-07-30 17:32:08'),(174,'Poached egg, Bacon and Avocado','With Hollandaise sauce served on brown toast. Comes with free refill of coffee or tea.','http://localhost:8000/img/menu/breakfast.jpg',5.95,22,'2018-07-30 17:33:17','2018-07-30 17:33:17'),(175,'Smoked Salmon and Poached Egg Bagel',NULL,'http://localhost:8000/img/menu/breakfast.jpg',4.45,22,'2018-07-30 17:33:52','2018-07-30 17:33:52'),(176,'Eggs Benedict','Smoked ham, spinach, poached egg and Hollandaise sauce.','http://localhost:8000/img/menu/protein%20pots.jpg',3.25,23,'2018-07-30 17:44:00','2018-07-30 17:44:00'),(177,'Spinach, Avocado and Mushroom','With bean sauce and poached egg.','http://localhost:8000/img/menu/protein%20pots.jpg',3.75,23,'2018-07-30 17:44:29','2018-07-30 17:44:29'),(178,'Spinach and Chorizo','Chorizo, spinach, bean sauce and poached egg.','http://localhost:8000/img/menu/protein%20pots.jpg',3.75,23,'2018-07-30 17:44:58','2018-07-30 17:44:58'),(179,'Eggs Royale',NULL,'http://localhost:8000/img/menu/protein%20pots.jpg',3.75,23,'2018-07-30 17:46:39','2018-07-30 17:46:39'),(180,'Full English','Sausages, bacon, bean sauce, poached egg  and either ketchup or brown sauce.','http://localhost:8000/img/menu/protein%20pots.jpg',3.75,23,'2018-07-30 17:47:15','2018-07-30 17:47:15'),(181,'Homemade Chocolate Brownie','With ice-cream and chocolate sauce.','http://localhost:8000/img/menu/desserts.jpg',3.75,6,'2018-07-30 17:48:32','2018-07-30 17:48:32'),(182,'Caramel and Toffee','With ice-cream','http://localhost:8000/img/menu/desserts.jpg',3.75,6,'2018-07-30 17:48:55','2018-07-30 17:48:55'),(183,'Smoked Salmon and Cream Cheese',NULL,'http://localhost:8000/img/menu/cold%20bagels.jpg',4.75,2,'2018-07-30 20:57:06','2018-07-30 20:57:06'),(184,'Ruben','Pastrami, coleslaw, gherkins, lettuce, tomato and mild American mustard.','http://localhost:8000/img/menu/cold%20bagels.jpg',4.75,2,'2018-07-30 20:57:42','2018-07-30 20:57:42'),(185,'The Bronx','Turkey, salami, mozzarella, lettuce, tomato and ranch dressing.','http://localhost:8000/img/menu/cold%20bagels.jpg',4.75,2,'2018-07-30 20:58:19','2018-07-30 20:58:19'),(186,'teste item','teste item','img/menu/Teste/_img_teste_item_29377.png',1.00,25,'2019-02-12 10:32:37','2019-02-12 10:32:37');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_types`
--

DROP TABLE IF EXISTS `menu_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_id` int(11) NOT NULL DEFAULT '4',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_types`
--

LOCK TABLES `menu_types` WRITE;
/*!40000 ALTER TABLE `menu_types` DISABLE KEYS */;
INSERT INTO `menu_types` VALUES (2,'Cold Bagels','2018-07-17 09:19:16','2018-07-26 21:35:56',4),(3,'Ciabattas','2018-07-17 09:19:32','2018-07-18 05:07:19',4),(4,'Cold Wraps','2018-07-17 09:19:41','2018-07-17 09:19:41',4),(6,'Desserts','2018-07-17 09:20:04','2018-07-17 09:20:04',4),(7,'Drinks','2018-07-17 09:20:15','2018-07-17 09:20:15',4),(8,'Fresh Salads','2018-07-17 09:20:24','2018-07-17 09:20:24',4),(9,'Hotdogs','2018-07-17 09:20:33','2018-07-17 09:20:33',4),(10,'Baked Potatoes','2018-07-17 09:20:42','2018-07-26 21:55:20',4),(11,'Paninis','2018-07-17 09:20:51','2018-07-17 09:20:51',4),(13,'Toasted Wraps','2018-07-17 09:21:12','2018-07-17 09:21:12',4),(15,'Protein Shakes','2018-07-26 13:40:57','2018-07-26 13:41:11',4),(16,'Heavenly Ice-cream Shakes','2018-07-26 13:50:12','2018-07-26 13:50:12',4),(17,'Fruit Smoothies','2018-07-26 13:56:49','2018-07-26 13:56:49',4),(18,'Hot Bagels','2018-07-26 21:37:32','2018-07-26 21:37:32',4),(19,'Iced Beverages','2018-07-30 17:16:51','2018-07-30 17:16:51',4),(20,'Frappes','2018-07-30 17:18:43','2018-07-30 17:18:43',4),(21,'Snacks','2018-07-30 17:26:55','2018-07-30 17:26:55',4),(22,'Breakfast','2018-07-30 17:29:30','2018-07-30 17:29:30',4),(23,'Protein Pots','2018-07-30 17:43:13','2018-07-30 17:43:13',4),(25,'Teste','2019-02-11 15:39:35','2019-02-12 10:14:17',5);
/*!40000 ALTER TABLE `menu_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (24,'2018_07_13_235326_create_papers_table',2),(46,'2014_10_12_000000_create_users_table',3),(47,'2014_10_12_100000_create_password_resets_table',3),(48,'2018_07_17_031547_create_permissions_table',4),(51,'2018_07_14_013544_create_roles_table',5),(52,'2018_07_17_045349_create_menu_items_table',6),(53,'2018_07_17_051316_create_menu_types_table',7),(54,'2018_07_17_054631_create_menu_items_table',7),(55,'2018_07_18_052100_create_menu_extras_table',8),(56,'2018_07_19_030858_create_shops_table',9),(57,'2018_07_19_032101_create_checkouts_table',10),(58,'2018_07_19_032657_create_checkout_items_table',11),(59,'2018_07_19_033011_create_checkout_item_extras_table',12),(81,'2018_07_21_053535_alter_users_add_foreign_key_shop',13),(82,'2018_07_31_203746_alter_checkouts_add_address',13),(84,'2018_10_25_150911_alter_logintoken_alter_column',14),(85,'2019_02_03_160458_alter_menuitems_add_column',15),(86,'2019_02_05_135612_alter_menutypes_addcolumn',16),(87,'2019_02_11_152339_alter_menutypes_add_column',17),(88,'2019_02_12_101014_alter_menutypes_drop_column',18),(89,'2019_02_12_102918_alter_menuitems_drop_column',19),(90,'2019_02_13_115645_alter_checkouts_add_column',20),(91,'2019_02_13_144341_alter_checkouts_add_column',21),(92,'2019_02_16_143337_alter_shops_add_column',22),(93,'2019_02_22_135339_alter_checkouts_add_column',23),(95,'2019_02_23_134113_alter_checkouts_add_column',24),(96,'2019_02_27_104451_create_countries_table',25),(100,'2019_03_01_122913_create_payment_confirmation_table',26),(103,'2019_03_20_111356_alter_shops_add_column',27);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_confirmations`
--

DROP TABLE IF EXISTS `payment_confirmations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retrieval_reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_confirmations_checkout_id_foreign` (`checkout_id`),
  CONSTRAINT `payment_confirmations_checkout_id_foreign` FOREIGN KEY (`checkout_id`) REFERENCES `checkouts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_confirmations`
--

LOCK TABLES `payment_confirmations` WRITE;
/*!40000 ALTER TABLE `payment_confirmations` DISABLE KEYS */;
INSERT INTO `payment_confirmations` VALUES (55,'07AE7A16-9E91-BE96-6467-3293FFC7C579','1151577','12302',302,'2019-03-19 12:20:41','2019-03-19 12:20:41'),(56,'749ED6DF-9541-9BE4-3E88-FBAA86750B27','1151643','12303',303,'2019-03-19 12:28:44','2019-03-19 12:28:44'),(57,'83C2A537-544C-D601-6024-12C4C8AC9712','1153765','12304',304,'2019-03-19 16:03:57','2019-03-19 16:03:57'),(58,'50DBDE96-E9EC-82A7-3608-E0AA93EA7D3D','1154093','12305',305,'2019-03-19 16:29:54','2019-03-19 16:29:54'),(59,'53AE06EF-CFC6-C036-ADB6-AA4230DD1A4D','1154200','12306',306,'2019-03-19 16:43:37','2019-03-19 16:43:37'),(60,'E813D42B-B44D-B70A-0846-EA1166D098F3','1154206','12307',307,'2019-03-19 16:44:25','2019-03-19 16:44:25'),(61,'3764181E-90E0-49D0-5976-A9F6DFC7E61B','1154230','12308',308,'2019-03-19 16:46:30','2019-03-19 16:46:30'),(62,'B9229521-D62C-EF13-62B5-E3D6EEC927D2','1160808','12309',309,'2019-03-20 12:37:15','2019-03-20 12:37:15'),(63,'B40D62D8-6B97-E563-1385-FDB2A726EE04','1160846','12310',310,'2019-03-20 12:44:06','2019-03-20 12:44:06'),(64,'C6D493FD-94B5-9994-2191-470C33D56BCB','1160877','12311',311,'2019-03-20 12:46:38','2019-03-20 12:46:38'),(65,'F20A69DC-9507-3D7C-F285-F24F85F446E2','1160951','12312',312,'2019-03-20 12:51:02','2019-03-20 12:51:02');
/*!40000 ALTER TABLE `payment_confirmations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (8,34),(8,35),(8,41),(8,42),(8,43),(8,44),(8,46),(8,47),(8,48),(8,49),(8,50),(8,51),(9,50),(9,51);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (34,'users_list','List Users','2018-07-17 09:00:31','2018-07-17 09:00:31'),(35,'users_search','Search Users','2018-07-17 09:00:31','2018-07-17 09:00:31'),(36,'user_edit','Edit User','2018-07-17 09:00:31','2018-07-17 09:00:31'),(37,'roles_list','List Roles','2018-07-17 09:00:31','2018-07-17 09:00:31'),(38,'role_add','Add Role','2018-07-17 09:00:31','2018-07-17 09:00:31'),(39,'role_edit','Edit Role','2018-07-17 09:00:31','2018-07-17 09:00:31'),(40,'role_delete','Delete Role','2018-07-17 09:00:31','2018-07-17 09:00:31'),(41,'menu_list','List Menu','2018-07-17 09:00:31','2018-07-17 09:00:31'),(42,'menu_add','Add Menu','2018-07-17 09:00:31','2018-07-17 09:00:31'),(43,'menu_edit','Edit Menu','2018-07-17 09:00:31','2018-07-17 09:00:31'),(44,'menu_delete','Delete Menu','2018-07-17 09:00:31','2018-07-17 09:00:31'),(46,'shop_add','Add Shop','2018-07-19 06:41:59','2018-07-19 06:41:59'),(47,'shop_edit','Edit Shop','2018-07-19 06:41:59','2018-07-19 06:41:59'),(48,'shop_delete','Delete Shop','2018-07-19 06:41:59','2018-07-19 06:41:59'),(49,'shops_list','List Shops','2018-07-19 06:53:25','2018-07-19 06:53:25'),(50,'orders_list','List Orders','2018-08-02 05:48:36','2018-08-02 05:48:36'),(51,'order_print','Print Order','2018-08-02 05:48:36','2018-08-02 05:48:36'),(52,'user_add','Add Users','2019-02-20 11:21:24','2019-02-20 11:21:24');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (12,7),(36,9),(37,8),(38,11);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (7,'ADMIN','System Administrator','2018-07-17 06:56:26','2018-07-17 06:56:26'),(8,'MANAGER','Manager','2018-07-17 06:56:27','2018-07-17 06:56:27'),(9,'EMPLOYEE','Employee','2018-07-17 06:56:27','2018-07-17 06:56:27'),(11,'CUSTOMER','Customer','2019-02-20 13:16:15','2019-02-20 13:16:15');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_schedules`
--

DROP TABLE IF EXISTS `shop_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_schedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day_week` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opening_time` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closing_time` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_schedules_shop_id_foreign` (`shop_id`),
  CONSTRAINT `shop_schedules_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_schedules`
--

LOCK TABLES `shop_schedules` WRITE;
/*!40000 ALTER TABLE `shop_schedules` DISABLE KEYS */;
INSERT INTO `shop_schedules` VALUES (13,'monday','07:30','17:30',5,'2018-07-19 11:22:36','2018-07-19 11:22:36',2),(14,'tuesday','07:30','17:30',5,'2018-07-19 11:22:48','2018-07-31 06:46:51',3),(15,'wednesday','07:30','17:30',5,'2018-07-19 11:22:59','2018-07-19 11:22:59',4),(16,'thursday','07:30','17:30',5,'2018-07-19 11:23:13','2018-08-02 20:56:21',5),(17,'friday','07:30','17:30',5,'2018-07-19 11:23:25','2018-07-19 11:23:25',6),(18,'saturday','10:00','17:30',5,'2018-07-19 11:23:44','2018-07-19 11:23:44',7),(20,'sunday','10:00','23:30',5,'2018-07-19 11:27:46','2019-02-03 16:40:08',1),(22,'sunday','10:00','23:30',4,'2018-07-19 11:28:32','2019-02-03 16:39:43',1),(23,'monday','07:30','17:30',4,'2018-07-19 11:28:53','2018-07-19 11:28:53',2),(24,'tuesday','07:30','17:30',4,'2018-07-19 11:29:03','2019-02-19 11:36:49',3),(25,'wednesday','07:30','17:30',4,'2018-07-19 11:29:16','2018-08-02 20:55:49',4),(26,'thursday','01:00','17:30',4,'2018-07-19 11:29:27','2018-08-23 07:30:21',5),(27,'friday','01:00','17:30',4,'2018-07-19 11:29:39','2018-08-24 08:36:19',6),(28,'saturday','09:00','17:30',4,'2018-07-19 11:29:52','2019-03-02 09:12:09',7);
/*!40000 ALTER TABLE `shop_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivery` tinyint(1) NOT NULL DEFAULT '0',
  `vendor_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `integration_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `integration_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES (4,'New York Deli Aylesbury','4 Friars Square Shopping Centre, Aylesbury HP20 2SP',1,'2018-07-19 09:45:35','2019-03-20 12:04:45',1,'newyorkdeliayle','DHOkf07razYvhqdU61Mel76fzZt1KUrEsyPhZuPy280KCDOzCv','nYPgCLEFYfAlM21b4AH9kzyq86wuFSffyo6OBzfBMK6zT6urpViSdmAD0NCpgQGzT'),(5,'New York Deli Maidenhead','Nicholsons Shopping Centre, Maidenhead SL6 1LJ',1,'2018-07-19 11:16:03','2019-03-20 12:05:40',0,'newyorkdelimaid','pr78smjLFPgKvxekkYNG97pIZ2axCkDMwS5WNbyW4sFi4489wc','FbN86044C9jXCUlCQVAxu94ydEcZKI2k1RrN3E55bgzurMWnFyJ4HqphvF0TQEGio');
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `nu_error_login` int(10) unsigned NOT NULL DEFAULT '0',
  `receive_notifications` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (12,'System Administrator','admin@mail.com','$2y$10$Ghw27FY/ZokeUEOLWdAyN.cnJWCWAAg8EBvqwcy.4wVSBiJMEhdi.','z3FzKtu9Nq4e7GkuRtwcUQGmW3lAKXQNTmTdG6ib0boQ7vwjYvZsZnd3E48P','2018-07-17 03:25:50','2018-09-09 00:24:15',NULL,NULL,NULL,0,'yes','1234567890','mk130eb','Friars Square Shopping Centre, Aylesbury',4),(21,'Thiago Chaves','thiago@mail.com','$2y$10$FXdIxPlW6222sLiufLIXnORgILj28iarUgRuz7PNYe3T4BEgXEkfC','ne0UQ1JcQNiWm1loMAciuWEOaStzAU3d0e6tC2Dffgv9GY3D95b35T7r2ZQY','2018-11-07 18:19:02','2018-11-07 18:19:02','email',NULL,'V1yKpLApZvN5c4z09UfuVn37n2et8Qe949fwbnkS.jpeg',0,'yes',NULL,NULL,NULL,4),(22,'Thiago Chaves','thiagodev@mail.com','$2y$10$bjud2PCf66D/sCK/flLMWeVZV4jYFhLCsww2OdJ4hQWe3r3YwpCLm',NULL,'2018-11-09 18:11:52','2018-11-09 18:11:52','email',NULL,'JIA8IjbzBwC6tZ3mhXPtPxdQDYVlDjrZIAukqD13.jpeg',0,'yes',NULL,NULL,NULL,4),(32,'Thiago Chaves','teste@mail.com','$2y$10$k5NppHPzRBnDp8/33YWwzuN5D6fkM3BbuG5lsZQE.3/.h3IKss9Fy','p986pjkj62nKtbxm0LZBbZSSl8q0agAeuhUiHrBT0BU1ictC18Sgy1RJ0hi4','2018-11-11 16:29:06','2018-11-11 16:29:06','email',NULL,'AlBlAb1dnYWAnRxXA0pd9F1Wv9uUGNy6IAizQuLb.jpeg',0,'yes',NULL,NULL,NULL,4),(33,'Thiago Chaves','fthiagocdo@gmail.com','$2y$10$KVMOi.Hf2iYxCbD./QTO0.OPtnstlvaz2wsQA4BkbTVLv.OvN4vyK','hVDCc89DFVGwmrMOavxuIkkynjgLg02lE4WW2bV6ZXSXkRGQyfDSLrqDhSjt','2018-11-11 16:34:35','2019-03-18 16:56:40','email',NULL,'https://lh3.googleusercontent.com/-__VHoWgoAeM/AAAAAAAAAAI/AAAAAAAADXw/jpOQDazgY4E/s96-c/photo.jpg',0,'yes','123456789','mk130eb','12 thompson street, new bradwell',4),(34,'testet1','teste1@mail.com','$2y$10$JLGW9wcBtbqThKxZtVmIDu5FS3PiEvjQocqHn7Ob1W304mx4WKbFi',NULL,'2019-02-20 10:47:12','2019-02-20 10:47:12','email',NULL,'http://localhost:8000/img/user-avatar.png',0,'no','',NULL,NULL,4),(35,'Teste10','teste10@mail.com','teste123',NULL,'2019-02-20 11:37:58','2019-02-20 11:37:58','email',NULL,'eMxeYtCwc1mroicyy0oX2VBn4SV8tauDO2LgqI5L.jpeg',0,'yes',NULL,NULL,NULL,4),(36,'teste14','teste14@mail.com','teste123',NULL,'2019-02-20 13:04:57','2019-02-20 13:04:57','email',NULL,'WzCE4fTGKRA7oYQxXX12IIo2fzgWa8wo4iBiS8Mr.jpeg',0,'yes',NULL,NULL,NULL,4),(37,'teste15','teste15@mail.com','teste123','BMDGLp12mkmE3tNYNHNhpw1XPsUwlUG25jwwRJRybxCCBkWjaPfN9nX7ylmR','2019-02-20 13:05:52','2019-02-20 13:05:52','email',NULL,'gNbNZBWalfFJu36CokFuSm6mlD6F8R1AsvUDhlGy.jpeg',0,'yes',NULL,NULL,NULL,4),(38,'teste16','teste16@mail.com','teste123','16vlsCKUUaCmsZkipec4cuWS0Msnc5pyuRlOZzBzdNOhPqGHcIh8Rnf8qB9h','2019-02-20 13:18:18','2019-02-20 13:18:18','email',NULL,'BJNvdVz1RhsAYCsYfKZ6pyEWBo6oeHIE4lq4dy8T.jpeg',0,'yes',NULL,NULL,NULL,4);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-20 12:59:16
