-- MySQL dump 10.13  Distrib 5.7.44, for Linux (x86_64)
--
-- Host: localhost    Database: 110
-- ------------------------------------------------------
-- Server version	5.7.44-log

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
-- Table structure for table `buyer_accounts`
--

DROP TABLE IF EXISTS `buyer_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buyer_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `real_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '买家真实姓名',
  `status` tinyint(4) DEFAULT '1' COMMENT '账号状态：1=正常，0=禁用',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `last_login` timestamp NULL DEFAULT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buyer_accounts`
--

LOCK TABLES `buyer_accounts` WRITE;
/*!40000 ALTER TABLE `buyer_accounts` DISABLE KEYS */;
INSERT INTO `buyer_accounts` VALUES (1,'09a6a592dea91bcf7d4dd53e47a5a','09a6a592dea91bcf7d4dd53e47a5a',NULL,NULL,'测试买家',1,'2025-06-29 14:11:17','2025-07-02 01:36:33');
/*!40000 ALTER TABLE `buyer_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_admins`
--

DROP TABLE IF EXISTS `chatroom_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员ID',
  `room_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '聊天室ID',
  `permission_level` enum('owner','admin','moderator') COLLATE utf8mb4_unicode_ci DEFAULT 'admin' COMMENT '权限级别',
  `assigned_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '分配时间',
  `assigned_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '分配者',
  `status` enum('active','disabled') COLLATE utf8mb4_unicode_ci DEFAULT 'active' COMMENT '状态',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_admin_room` (`admin_id`,`room_id`),
  KEY `idx_room_id` (`room_id`),
  KEY `idx_admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天室管理员关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_admins`
--

LOCK TABLES `chatroom_admins` WRITE;
/*!40000 ALTER TABLE `chatroom_admins` DISABLE KEYS */;
INSERT INTO `chatroom_admins` VALUES (31,'admin_backend','room_68648acb4a212','owner','2025-07-02 01:26:35',NULL,'active','2025-07-02 01:26:35'),(32,'admin_backend','room_68648b22650ce','owner','2025-07-02 01:28:02',NULL,'active','2025-07-02 01:28:02'),(33,'admin_backend','room_6864b8db22b08','owner','2025-07-02 04:43:07',NULL,'active','2025-07-02 04:43:07');
/*!40000 ALTER TABLE `chatroom_admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_config`
--

DROP TABLE IF EXISTS `chatroom_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天室配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_config`
--

LOCK TABLES `chatroom_config` WRITE;
/*!40000 ALTER TABLE `chatroom_config` DISABLE KEYS */;
INSERT INTO `chatroom_config` VALUES (1,'max_users','5','聊天室最大用户数'),(2,'admin_username','admin','管理员用户名'),(3,'admin_password','09a6a592dea91bcf7d4dd53e47a5a','管理员密码（加密后）'),(4,'welcome_message','欢迎来到聊天室！请遵守聊天规则，友好交流。','欢迎消息'),(5,'file_upload_max_size','104857600','文件上传最大大小（100MB）'),(6,'allowed_file_types','jpg,jpeg,png,gif,mp4,webm,mov,avi','允许的文件类型');
/*!40000 ALTER TABLE `chatroom_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_list`
--

DROP TABLE IF EXISTS `chatroom_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '聊天室唯一标识符',
  `room_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '聊天室名称',
  `room_description` text COLLATE utf8mb4_unicode_ci COMMENT '聊天室描述',
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '创建者ID',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `last_activity` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后活跃时间',
  `status` enum('active','disabled','deleted') COLLATE utf8mb4_unicode_ci DEFAULT 'active' COMMENT '状态：激活/禁用/删除',
  `max_users` int(11) DEFAULT '50' COMMENT '最大用户数',
  `settings` text COLLATE utf8mb4_unicode_ci COMMENT '聊天室设置（JSON格式）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_id` (`room_id`),
  KEY `idx_room_id` (`room_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天室列表管理表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_list`
--

LOCK TABLES `chatroom_list` WRITE;
/*!40000 ALTER TABLE `chatroom_list` DISABLE KEYS */;
INSERT INTO `chatroom_list` VALUES (47,'room_68648acb4a212','知意','v','admin_backend','2025-07-02 01:26:35','2025-07-02 01:38:31','active',5,NULL),(48,'room_68648b22650ce','v','v','admin_backend','2025-07-02 01:28:02','2025-07-02 04:42:56','active',5,NULL),(49,'room_6864b8db22b08','你好呀','知意','admin_backend','2025-07-02 04:43:07','2025-07-02 04:43:41','active',5,NULL);
/*!40000 ALTER TABLE `chatroom_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_message_reads`
--

DROP TABLE IF EXISTS `chatroom_message_reads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_message_reads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '所属聊天室ID',
  `message_id` int(11) NOT NULL COMMENT '消息ID',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `read_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `message_user` (`message_id`,`user_id`),
  KEY `message_id` (`message_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1783 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='消息已读状态表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_message_reads`
--

LOCK TABLES `chatroom_message_reads` WRITE;
/*!40000 ALTER TABLE `chatroom_message_reads` DISABLE KEYS */;
INSERT INTO `chatroom_message_reads` VALUES (1768,'room_68648acb4a212',557,'admin_bf5bc45e0d8c28242cd8a782907a3f24','2025-07-02 09:27:00','螃蟹客服-知意'),(1769,'room_68648acb4a212',556,'admin_bf5bc45e0d8c28242cd8a782907a3f24','2025-07-02 09:27:00','螃蟹客服-知意'),(1770,'room_68648b22650ce',559,'admin_c9144b5fa901017d97ef7730b000b507','2025-07-02 09:33:48','螃蟹客服-知意'),(1771,'room_68648b22650ce',560,'admin_c9144b5fa901017d97ef7730b000b507','2025-07-02 09:33:48','螃蟹客服-知意'),(1772,'room_68648b22650ce',560,'guest_8c19234c747b91ac69412532a91a80c5','2025-07-02 09:40:33','用户_44e82c2d89'),(1773,'room_68648b22650ce',561,'guest_8c19234c747b91ac69412532a91a80c5','2025-07-02 09:40:33','用户_44e82c2d89'),(1774,'room_68648b22650ce',562,'guest_8c19234c747b91ac69412532a91a80c5','2025-07-02 09:40:33','用户_44e82c2d89'),(1775,'room_68648b22650ce',559,'guest_8c19234c747b91ac69412532a91a80c5','2025-07-02 09:40:33','用户_44e82c2d89'),(1776,'room_68648b22650ce',564,'guest_8c19234c747b91ac69412532a91a80c5','2025-07-02 09:40:33','用户_44e82c2d89'),(1777,'room_68648b22650ce',565,'guest_8c19234c747b91ac69412532a91a80c5','2025-07-02 09:40:33','用户_44e82c2d89'),(1778,'room_68648b22650ce',568,'admin_c9144b5fa901017d97ef7730b000b507','2025-07-02 09:41:42','螃蟹客服-知意'),(1779,'room_68648b22650ce',567,'admin_c9144b5fa901017d97ef7730b000b507','2025-07-02 09:41:42','螃蟹客服-知意'),(1780,'room_68648b22650ce',566,'admin_c9144b5fa901017d97ef7730b000b507','2025-07-02 09:41:42','螃蟹客服-知意'),(1781,'room_6864b8db22b08',572,'admin_e4684d552dfe0e7cac839354ceb4eb63','2025-07-02 12:43:11','螃蟹客服-知意'),(1782,'room_6864b8db22b08',573,'admin_e4684d552dfe0e7cac839354ceb4eb63','2025-07-02 12:43:11','螃蟹客服-知意');
/*!40000 ALTER TABLE `chatroom_message_reads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_messages`
--

DROP TABLE IF EXISTS `chatroom_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message_type` enum('text','image','video','file','system') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text' COMMENT '消息类型',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '消息内容',
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '文件名（适用于文件消息）',
  `file_size` int(11) DEFAULT NULL COMMENT '文件大小（字节）',
  `file_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '文件URL',
  `send_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  `room_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_type` enum('admin','buyer','seller','guest','system') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guest',
  `nickname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `send_time` (`send_time`),
  KEY `message_type` (`message_type`)
) ENGINE=InnoDB AUTO_INCREMENT=575 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天室消息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_messages`
--

LOCK TABLES `chatroom_messages` WRITE;
/*!40000 ALTER TABLE `chatroom_messages` DISABLE KEYS */;
INSERT INTO `chatroom_messages` VALUES (556,'','text','螃蟹交付专员-知意创建了该聊天',NULL,NULL,NULL,'2025-07-02 09:26:35',0,'room_68648acb4a212','system','system',''),(557,'','text','温馨小贴士\n1、买家已付款，请卖家等待客服指令发号（死绑/DSP提前告知，客服确认后卖家再发号）。\n2、买家验号，验号同时，卖家不准登陆等其他行为\n3、验号不能进行游戏哦，否则产生的后果买家承担。\n4、换绑需要客服通知，客服群内通知过后再开始换绑。\n5、群内禁止提供联系方式，私下交易有风险，损失自行承担。\n6、代售交易禁止联系走中介，发现则拉黑处理',NULL,NULL,NULL,'2025-07-02 09:26:35',0,'room_68648acb4a212','螃蟹在线客服-知意','admin',''),(558,'admin_bf5bc45e0d8c28242cd8a782907a3f24','text','你好',NULL,NULL,NULL,'2025-07-02 09:27:03',0,'room_68648acb4a212','螃蟹客服-知意','admin',''),(559,'','text','螃蟹交付专员-知意创建了该聊天',NULL,NULL,NULL,'2025-07-02 09:28:02',0,'room_68648b22650ce','system','system',''),(560,'','text','温馨小贴士\n1、买家已付款，请卖家等待客服指令发号（死绑/DSP提前告知，客服确认后卖家再发号）。\n2、买家验号，验号同时，卖家不准登陆等其他行为\n3、验号不能进行游戏哦，否则产生的后果买家承担。\n4、换绑需要客服通知，客服群内通知过后再开始换绑。\n5、群内禁止提供联系方式，私下交易有风险，损失自行承担。\n6、代售交易禁止联系走中介，发现则拉黑处理',NULL,NULL,NULL,'2025-07-02 09:28:02',0,'room_68648b22650ce','螃蟹在线客服-知意','admin',''),(561,'admin_c9144b5fa901017d97ef7730b000b507','text','cnm',NULL,NULL,NULL,'2025-07-02 09:33:50',0,'room_68648b22650ce','螃蟹客服-知意','admin',''),(562,'admin_c9144b5fa901017d97ef7730b000b507','system','您已催一催客服，正在加急处理中~',NULL,NULL,NULL,'2025-07-02 09:33:55',0,'room_68648b22650ce','螃蟹客服-知意','admin',''),(563,'admin_bf5bc45e0d8c28242cd8a782907a3f24','text','你好',NULL,NULL,NULL,'2025-07-02 09:36:37',0,'room_68648acb4a212','螃蟹客服-知意','admin',''),(564,'admin_c9144b5fa901017d97ef7730b000b507','text','不会',NULL,NULL,NULL,'2025-07-02 09:40:13',0,'room_68648b22650ce','螃蟹客服-知意','admin',''),(565,'admin_c9144b5fa901017d97ef7730b000b507','text','😎',NULL,NULL,NULL,'2025-07-02 09:40:25',0,'room_68648b22650ce','螃蟹客服-知意','admin',''),(566,'guest_8c19234c747b91ac69412532a91a80c5','text','不会',NULL,NULL,NULL,'2025-07-02 09:40:37',0,'room_68648b22650ce','用户_44e82c2d89','guest',''),(567,'guest_8c19234c747b91ac69412532a91a80c5','text','在吗',NULL,NULL,NULL,'2025-07-02 09:40:42',0,'room_68648b22650ce','用户_44e82c2d89','guest',''),(568,'guest_8c19234c747b91ac69412532a91a80c5','text','你好',NULL,NULL,NULL,'2025-07-02 09:41:22',0,'room_68648b22650ce','用户_44e82c2d89','guest',''),(569,'admin_c9144b5fa901017d97ef7730b000b507','system','您已催一催客服，正在加急处理中~',NULL,NULL,NULL,'2025-07-02 09:48:01',0,'room_68648b22650ce','螃蟹客服-知意','admin',''),(570,'admin_c9144b5fa901017d97ef7730b000b507','text','知意',NULL,NULL,NULL,'2025-07-02 10:20:41',0,'room_68648b22650ce','螃蟹客服-知意','admin',''),(571,'admin_c9144b5fa901017d97ef7730b000b507','text','垃圾',NULL,NULL,NULL,'2025-07-02 12:42:56',0,'room_68648b22650ce','螃蟹客服-知意','admin',''),(572,'','text','螃蟹交付专员-知意创建了该聊天',NULL,NULL,NULL,'2025-07-02 12:43:07',0,'room_6864b8db22b08','system','system',''),(573,'','text','温馨小贴士\n1、买家已付款，请卖家等待客服指令发号（死绑/DSP提前告知，客服确认后卖家再发号）。\n2、买家验号，验号同时，卖家不准登陆等其他行为\n3、验号不能进行游戏哦，否则产生的后果买家承担。\n4、换绑需要客服通知，客服群内通知过后再开始换绑。\n5、群内禁止提供联系方式，私下交易有风险，损失自行承担。\n6、代售交易禁止联系走中介，发现则拉黑处理',NULL,NULL,NULL,'2025-07-02 12:43:07',0,'room_6864b8db22b08','螃蟹在线客服-知意','admin',''),(574,'admin_e4684d552dfe0e7cac839354ceb4eb63','text','你好啊',NULL,NULL,NULL,'2025-07-02 12:43:13',0,'room_6864b8db22b08','螃蟹客服-知意','admin','');
/*!40000 ALTER TABLE `chatroom_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_rooms`
--

DROP TABLE IF EXISTS `chatroom_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_rooms` (
  `room_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `room_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `status` enum('active','disabled') COLLATE utf8_unicode_ci DEFAULT 'active',
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_rooms`
--

LOCK TABLES `chatroom_rooms` WRITE;
/*!40000 ALTER TABLE `chatroom_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `chatroom_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_stats`
--

DROP TABLE IF EXISTS `chatroom_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '聊天室ID',
  `total_messages` int(11) DEFAULT '0' COMMENT '总消息数',
  `total_users` int(11) DEFAULT '0' COMMENT '总用户数',
  `active_users_today` int(11) DEFAULT '0' COMMENT '今日活跃用户',
  `peak_online_users` int(11) DEFAULT '0' COMMENT '峰值在线用户数',
  `last_message_time` timestamp NULL DEFAULT NULL COMMENT '最后消息时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `active_users` int(11) DEFAULT '0',
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_id` (`room_id`),
  KEY `idx_room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5445 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天室统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_stats`
--

LOCK TABLES `chatroom_stats` WRITE;
/*!40000 ALTER TABLE `chatroom_stats` DISABLE KEYS */;
INSERT INTO `chatroom_stats` VALUES (5349,'room_68648acb4a212',4,0,0,0,NULL,'2025-07-02 01:38:31',1,'2025-07-02 01:38:31'),(5356,'room_68648b22650ce',12,0,0,0,NULL,'2025-07-02 04:42:56',1,'2025-07-02 04:42:56'),(5439,'room_6864b8db22b08',3,0,0,0,NULL,'2025-07-02 04:43:41',1,'2025-07-02 04:43:41');
/*!40000 ALTER TABLE `chatroom_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatroom_users`
--

DROP TABLE IF EXISTS `chatroom_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatroom_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_type` enum('admin','buyer','seller','guest') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guest',
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户昵称',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户头像',
  `last_active` datetime DEFAULT CURRENT_TIMESTAMP,
  `join_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_online` tinyint(1) DEFAULT '1' COMMENT '是否在线',
  `room_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `user_type` (`user_type`),
  KEY `is_online` (`is_online`)
) ENGINE=InnoDB AUTO_INCREMENT=7859 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天室用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatroom_users`
--

LOCK TABLES `chatroom_users` WRITE;
/*!40000 ALTER TABLE `chatroom_users` DISABLE KEYS */;
INSERT INTO `chatroom_users` VALUES (7796,'admin_bf5bc45e0d8c28242cd8a782907a3f24','admin','螃蟹客服-知意',NULL,'2025-07-02 09:38:31','2025-07-02 09:26:59',0,'room_68648acb4a212','螃蟹客服-知意'),(7800,'admin_c9144b5fa901017d97ef7730b000b507','admin','螃蟹客服-知意',NULL,'2025-07-02 12:42:56','2025-07-02 09:33:47',0,'room_68648b22650ce','螃蟹客服-知意'),(7819,'guest_8c19234c747b91ac69412532a91a80c5','guest','用户_3d74_9049',NULL,'2025-07-02 09:41:48','2025-07-02 09:40:31',0,'room_68648b22650ce','用户_44e82c2d89'),(7855,'admin_e4684d552dfe0e7cac839354ceb4eb63','admin','螃蟹客服-知意',NULL,'2025-07-02 12:43:41','2025-07-02 12:43:10',1,'room_6864b8db22b08','螃蟹客服-知意');
/*!40000 ALTER TABLE `chatroom_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_custom_emojis`
--

DROP TABLE IF EXISTS `h_custom_emojis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_custom_emojis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户账号',
  `emoji_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '表情图片URL',
  `add_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user` (`h_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_custom_emojis`
--

LOCK TABLES `h_custom_emojis` WRITE;
/*!40000 ALTER TABLE `h_custom_emojis` DISABLE KEYS */;
INSERT INTO `h_custom_emojis` VALUES (6,'185.244.208.225','uploads/emojis/20241123031147_6740d773e4205.jpeg','2024-11-23 03:11:47');
/*!40000 ALTER TABLE `h_custom_emojis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_emojis`
--

DROP TABLE IF EXISTS `h_emojis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_emojis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_emojis`
--

LOCK TABLES `h_emojis` WRITE;
/*!40000 ALTER TABLE `h_emojis` DISABLE KEYS */;
/*!40000 ALTER TABLE `h_emojis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_form_submissions`
--

DROP TABLE IF EXISTS `h_form_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_form_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_form_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_form_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_addTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_form_submissions`
--

LOCK TABLES `h_form_submissions` WRITE;
/*!40000 ALTER TABLE `h_form_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `h_form_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_kefu`
--

DROP TABLE IF EXISTS `h_kefu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_kefu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_user` varchar(30) NOT NULL COMMENT '会员',
  `h_who` int(1) NOT NULL COMMENT '谁的信息1-会员2-客服',
  `h_content` text NOT NULL COMMENT '内容',
  `h_isread` int(1) NOT NULL DEFAULT '0' COMMENT '是否已读',
  `h_actIP` varchar(30) DEFAULT NULL,
  `h_addTime` datetime NOT NULL COMMENT '信息时间',
  `read_status` tinyint(1) DEFAULT '0' COMMENT '0:未读 1:已读',
  `audio_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1789 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_kefu`
--

LOCK TABLES `h_kefu` WRITE;
/*!40000 ALTER TABLE `h_kefu` DISABLE KEYS */;
INSERT INTO `h_kefu` VALUES (1786,'117.179.36.105',1,'知意集团✈️jintiao789 每一个疲惫的瞬间，我想的只是好好的挣钱，好好的生活！致敬每一个杀鱼的兄弟，都是为了生活而努力的艰辛者。别让生活的压力挤走快乐，祝愿我们都能在杀鱼的过程享受快乐，大家一起加油！！！\r\n \r\n \r\n \r\n \r\n \r\n ',1,'117.179.36.105','2024-11-24 22:43:51',0,NULL),(1788,'127.0.0.1',1,'你好',1,'127.0.0.1','2025-06-26 20:18:24',0,NULL);
/*!40000 ALTER TABLE `h_kefu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_kefu_config`
--

DROP TABLE IF EXISTS `h_kefu_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_kefu_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_sound` int(1) NOT NULL DEFAULT '1' COMMENT '是否关闭会员列表声音',
  `h_robot` int(1) NOT NULL DEFAULT '0' COMMENT '是否关闭机器人',
  `h_admin` varchar(50) DEFAULT NULL,
  `h_pass` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_kefu_config`
--

LOCK TABLES `h_kefu_config` WRITE;
/*!40000 ALTER TABLE `h_kefu_config` DISABLE KEYS */;
INSERT INTO `h_kefu_config` VALUES (1,0,1,'09a6a592dea91bcf7d4dd53e47a5a','09a6a592dea91bcf7d4dd53e47a5a');
/*!40000 ALTER TABLE `h_kefu_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_kefu_login`
--

DROP TABLE IF EXISTS `h_kefu_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_kefu_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_user` varchar(30) DEFAULT NULL,
  `h_ip` char(39) DEFAULT NULL,
  `h_addTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_kefu_login`
--

LOCK TABLES `h_kefu_login` WRITE;
/*!40000 ALTER TABLE `h_kefu_login` DISABLE KEYS */;
INSERT INTO `h_kefu_login` VALUES (52,'65567cedbc743bda3417fb813b9ba','112.49.149.11','2024-11-22 18:23:20'),(53,'65567cedbc743bda3417fb813b9ba','112.49.149.11','2024-11-22 18:24:46'),(54,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 18:26:53'),(55,'65567cedbc743bda3417fb813b9ba','185.244.208.225','2024-11-22 18:27:37'),(56,'65567cedbc743bda3417fb813b9ba','185.244.208.225','2024-11-22 18:28:07'),(57,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 18:32:03'),(58,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 18:39:11'),(59,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 18:53:35'),(60,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 19:30:50'),(61,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 19:39:38'),(62,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 19:49:29'),(63,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 20:06:54'),(64,'65567cedbc743bda3417fb813b9ba','185.244.208.141','2024-11-22 20:11:21'),(65,'65567cedbc743bda3417fb813b9ba','185.244.208.225','2024-11-22 20:13:16'),(66,'65567cedbc743bda3417fb813b9ba','185.244.208.225','2024-11-22 20:13:51'),(67,'65567cedbc743bda3417fb813b9ba','185.244.208.225','2024-11-22 20:14:51'),(68,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.141','2024-11-22 20:42:47'),(69,'f3ac3d36051dc79a42b8b06f3259e','112.49.149.11','2024-11-22 20:43:23'),(70,'f3ac3d36051dc79a42b8b06f3259e','112.49.149.11','2024-11-22 20:43:34'),(71,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.141','2024-11-22 20:47:25'),(72,'f3ac3d36051dc79a42b8b06f3259e','116.210.125.161','2024-11-22 21:22:30'),(73,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.141','2024-11-22 21:22:34'),(74,'f3ac3d36051dc79a42b8b06f3259e','116.210.125.161','2024-11-22 21:40:14'),(75,'f3ac3d36051dc79a42b8b06f3259e','112.49.149.11','2024-11-22 23:26:32'),(76,'f3ac3d36051dc79a42b8b06f3259e','112.49.149.11','2024-11-22 23:31:33'),(77,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-22 23:48:35'),(78,'f3ac3d36051dc79a42b8b06f3259e','116.210.125.161','2024-11-22 23:48:40'),(79,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-23 00:00:19'),(80,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-23 00:48:13'),(81,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-23 01:39:20'),(82,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-23 01:42:09'),(83,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-23 01:49:50'),(84,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-23 02:22:55'),(85,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.225','2024-11-23 02:51:15'),(86,'f3ac3d36051dc79a42b8b06f3259e','116.210.125.161','2024-11-23 09:05:13'),(87,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.141','2024-11-23 12:41:38'),(88,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.141','2024-11-23 14:41:59'),(89,'f3ac3d36051dc79a42b8b06f3259e','185.244.208.141','2024-11-23 16:12:29'),(90,'f3ac3d36051dc79a42b8b06f3259e','117.177.95.145','2024-11-23 16:35:12'),(91,'09a6a592dea91bcf7d4dd53e47a5a','117.177.95.145','2024-11-23 16:46:06'),(92,'09a6a592dea91bcf7d4dd53e47a5a','116.169.10.149','2024-11-23 16:48:17'),(93,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.141','2024-11-23 16:52:59'),(94,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.141','2024-11-23 17:01:17'),(95,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-23 17:51:53'),(96,'09a6a592dea91bcf7d4dd53e47a5a','116.210.125.161','2024-11-23 18:13:57'),(97,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-23 21:17:22'),(98,'09a6a592dea91bcf7d4dd53e47a5a','111.181.141.118','2024-11-23 21:54:36'),(99,'09a6a592dea91bcf7d4dd53e47a5a','116.210.126.228','2024-11-23 22:40:36'),(100,'09a6a592dea91bcf7d4dd53e47a5a','117.177.95.145','2024-11-23 22:44:30'),(101,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-23 22:53:53'),(102,'09a6a592dea91bcf7d4dd53e47a5a','116.210.126.228','2024-11-23 23:12:35'),(103,'09a6a592dea91bcf7d4dd53e47a5a','116.210.126.228','2024-11-24 00:01:27'),(104,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.141','2024-11-24 00:07:01'),(105,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 00:49:08'),(106,'09a6a592dea91bcf7d4dd53e47a5a','116.210.126.228','2024-11-24 01:13:11'),(107,'09a6a592dea91bcf7d4dd53e47a5a','116.210.126.228','2024-11-24 09:11:47'),(108,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.141','2024-11-24 11:12:42'),(109,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.141','2024-11-24 11:25:53'),(110,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.141','2024-11-24 11:29:50'),(111,'09a6a592dea91bcf7d4dd53e47a5a','168.235.104.212','2024-11-24 11:30:14'),(112,'09a6a592dea91bcf7d4dd53e47a5a','216.98.3.239','2024-11-24 11:33:13'),(113,'09a6a592dea91bcf7d4dd53e47a5a','172.234.90.229','2024-11-24 11:34:44'),(114,'09a6a592dea91bcf7d4dd53e47a5a','216.98.3.239','2024-11-24 11:37:50'),(115,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.141','2024-11-24 12:40:37'),(116,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 14:04:13'),(117,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 14:06:38'),(118,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 14:14:44'),(119,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 14:17:55'),(120,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 17:13:04'),(121,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 17:27:01'),(122,'09a6a592dea91bcf7d4dd53e47a5a','185.244.208.225','2024-11-24 20:32:11'),(123,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-26 20:05:16'),(124,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-27 21:04:16'),(125,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-27 21:28:08'),(126,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-27 21:40:16'),(127,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-28 09:44:04'),(128,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-28 10:14:16'),(129,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-28 20:18:51'),(130,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-28 23:54:35'),(131,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 11:11:05'),(132,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 11:11:10'),(133,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 11:19:47'),(134,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 12:52:35'),(135,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 13:05:26'),(136,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 13:15:35'),(137,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 13:36:33'),(138,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 16:10:04'),(139,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 16:22:47'),(140,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 18:08:37'),(141,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 21:56:47'),(142,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-29 23:39:47'),(143,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 14:54:07'),(144,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 15:02:01'),(145,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 16:13:37'),(146,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 16:22:31'),(147,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 16:30:47'),(148,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 16:41:14'),(149,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 16:47:01'),(150,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-06-30 21:05:35'),(151,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-07-01 00:20:22'),(152,'09a6a592dea91bcf7d4dd53e47a5a','127.0.0.1','2025-07-01 00:28:11'),(153,'09a6a592dea91bcf7d4dd53e47a5a','1.57.233.44','2025-07-02 09:30:56');
/*!40000 ALTER TABLE `h_kefu_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_kefu_status`
--

DROP TABLE IF EXISTS `h_kefu_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_kefu_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_user` varchar(30) NOT NULL COMMENT '会员',
  `h_status` int(1) NOT NULL COMMENT '状态',
  `h_logins` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `h_actIP` varchar(30) DEFAULT NULL,
  `h_address` varchar(30) NOT NULL COMMENT '地址',
  `h_online` varchar(20) NOT NULL COMMENT '设备',
  `h_addTime` datetime NOT NULL COMMENT '信息时间',
  `h_remark` varchar(255) DEFAULT NULL COMMENT '用户备注',
  `h_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶 0否 1是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=513 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_kefu_status`
--

LOCK TABLES `h_kefu_status` WRITE;
/*!40000 ALTER TABLE `h_kefu_status` DISABLE KEYS */;
INSERT INTO `h_kefu_status` VALUES (495,'112.49.149.11',1,9,'112.49.149.11','','手机','2024-11-22 23:41:43','',0),(496,'116.210.125.161',1,7,'116.210.125.161','','手机','2024-11-23 18:14:23','',0),(497,'185.244.208.141',1,104,'185.244.208.141','罗马尼亚','手机','2024-11-24 15:29:15','',0),(498,'185.244.208.225',2,203,'185.244.208.225','罗马尼亚','手机','2024-11-24 20:22:00','还是',0),(499,'117.177.95.145',1,20,'117.177.95.145','','手机','2024-11-23 17:12:51',NULL,0),(500,'180.95.148.79',2,2,'180.95.148.79','','手机','2024-11-23 16:50:08',NULL,0),(501,'116.169.10.149',2,0,'116.169.10.149','','手机','2024-11-23 16:48:44',NULL,0),(502,'8.142.167.31',1,1,'8.142.167.31','中国阿里云','手机','2024-11-23 17:42:24',NULL,0),(503,'111.181.141.118',2,7,'111.181.141.118','','手机','2024-11-24 10:34:46',NULL,0),(505,'116.210.126.228',1,41,'116.210.126.228','湖北省恩施州 电信','手机','2024-11-24 11:10:26',NULL,0),(506,'168.235.104.212',1,2,'168.235.104.212','','手机','2024-11-24 11:31:30',NULL,0),(507,'27.149.81.209',2,0,'27.149.81.209','福建省福州市 电信','手机','2024-11-24 11:31:33',NULL,0),(508,'216.98.3.239',1,4,'216.98.3.239','','手机','2024-11-24 11:37:40',NULL,0),(509,'172.234.90.229',1,3,'172.234.90.229','美国Akamai科技公司CDN网络节点','手机','2024-11-24 11:35:41',NULL,0),(510,'117.179.36.105',2,14,'117.179.36.105','','手机','2024-11-24 22:46:14',NULL,0),(511,'42.102.214.4',2,6,'42.102.214.4','','手机','2024-11-24 22:44:14',NULL,0),(512,'127.0.0.1',2,8,'127.0.0.1','本机地址','手机','2025-06-29 16:08:19',NULL,0);
/*!40000 ALTER TABLE `h_kefu_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_ratings`
--

DROP TABLE IF EXISTS `h_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_user` varchar(255) NOT NULL,
  `h_score` int(11) NOT NULL,
  `h_addTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_ratings`
--

LOCK TABLES `h_ratings` WRITE;
/*!40000 ALTER TABLE `h_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `h_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_service_rate`
--

DROP TABLE IF EXISTS `h_service_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_service_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_user` varchar(255) NOT NULL,
  `h_rate` int(11) NOT NULL,
  `h_timestamp` varchar(255) NOT NULL,
  `h_addTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_service_rate`
--

LOCK TABLES `h_service_rate` WRITE;
/*!40000 ALTER TABLE `h_service_rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `h_service_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_system_messages`
--

DROP TABLE IF EXISTS `h_system_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_system_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'normal',
  `delay` int(11) DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_system_messages`
--

LOCK TABLES `h_system_messages` WRITE;
/*!40000 ALTER TABLE `h_system_messages` DISABLE KEYS */;
INSERT INTO `h_system_messages` VALUES (1,'正在为您转接人工客服，请稍候...','transfer',500,'2024-11-23 17:16:26'),(2,'当前正在排队的人数较多，请您耐心等待。\n排队期间您可以先描述遇到的问题，人工客服会优先查看。','queue',2000,'2024-11-23 17:16:26'),(3,'正在为您转接人工客服，请稍候...','transfer',500,'2024-11-23 17:33:22'),(4,'当前正在排队的人数较多，请您耐心等待。\n排队期间您可以先描述遇到的问题，人工客服会优先查看。','queue',2000,'2024-11-23 17:33:22'),(5,'欢迎使用在线客服系统，请问有什么可以帮您？','welcome',0,'2024-11-23 17:33:22'),(6,'抱歉，当前无人工客服在线，请您稍后再试。','offline',1000,'2024-11-23 17:33:22'),(7,'您的问题已收到，客服将尽快为您处理。','received',0,'2024-11-23 17:33:22'),(8,'由于您长时间未回复，系统将自动结束本次会话。如需帮助请重新发起对话。','timeout',1000,'2024-11-23 17:33:22'),(9,'网络连接不稳定，请检查您的网络设置。','network_error',0,'2024-11-23 17:33:22'),(10,'正在连接中，请稍候...','connecting',500,'2024-11-23 17:33:22'),(11,'会话已结束，感谢您的使用。','end',1000,'2024-11-23 17:33:22'),(12,'系统正在维护中，请稍后再试。','maintenance',0,'2024-11-23 17:33:22');
/*!40000 ALTER TABLE `h_system_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ip_user_binding`
--

DROP TABLE IF EXISTS `ip_user_binding`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_user_binding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` varchar(100) NOT NULL COMMENT '房间ID',
  `ip_address` varchar(45) NOT NULL COMMENT 'IP地址',
  `device_fingerprint` varchar(32) NOT NULL DEFAULT '' COMMENT '设备指纹',
  `user_name` varchar(100) NOT NULL COMMENT '绑定的用户名',
  `user_type` enum('guest','buyer','admin') NOT NULL DEFAULT 'guest' COMMENT '用户类型',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `last_access_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后访问时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unique_room_ip_device` (`room_id`,`ip_address`,`device_fingerprint`) USING BTREE,
  KEY `idx_room_id` (`room_id`) USING BTREE,
  KEY `idx_ip_address` (`ip_address`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='IP用户绑定表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_user_binding`
--

LOCK TABLES `ip_user_binding` WRITE;
/*!40000 ALTER TABLE `ip_user_binding` DISABLE KEYS */;
INSERT INTO `ip_user_binding` VALUES (1,'room_test_001','','','访客_fa9d','guest','2025-06-30 15:18:23','2025-06-30 15:18:23'),(2,'room_test_002','','','访客_e6f9','guest','2025-06-30 15:18:23','2025-06-30 15:18:23'),(3,'room_test_001','127.0.0.1','','访客1_fa9d','guest','2025-06-30 15:19:14','2025-06-30 15:20:34'),(4,'room_test_002','127.0.0.1','','访客1_e6f9','guest','2025-06-30 15:19:14','2025-06-30 15:20:34'),(5,'room_enhanced_001','127.0.0.1','2edf2958','访客1_2edf_26c1','guest','2025-06-30 15:29:14','2025-06-30 15:39:21'),(6,'room_enhanced_002','127.0.0.1','2edf2958','访客1_2edf_ffcb','guest','2025-06-30 15:29:15','2025-06-30 15:39:21'),(7,'room_enhanced_003','127.0.0.1','2edf2958','访客1_2edf_05ba','guest','2025-06-30 15:29:15','2025-06-30 15:39:21'),(8,'room_enhanced_003','192.168.1.5','6810dfcb','访客5_6810_05ba','guest','2025-06-30 15:31:24','2025-06-30 15:31:24'),(9,'room_6862324b5703e','192.168.1.5','6810dfcb','访客5_6810_3aa3','guest','2025-06-30 15:41:29','2025-06-30 15:41:29'),(10,'room_686240055fca7','127.0.0.1','3d743eb4','访客1_3d74_c632','guest','2025-06-30 15:43:31','2025-06-30 15:43:31'),(11,'room_68624275bf042','127.0.0.1','b1501187','访客1_b150_c954','guest','2025-06-30 16:01:17','2025-06-30 16:01:17'),(12,'room_686244824909b','127.0.0.1','3d743eb4','访客1_3d74_cbcb','guest','2025-06-30 16:03:16','2025-06-30 16:08:47'),(13,'room_68624f2158b92','127.0.0.1','3d743eb4','访客1_3d74_d7cc','guest','2025-06-30 16:48:02','2025-06-30 21:05:46'),(14,'room_68624f2158b92','192.168.1.5','6810dfcb','访客5_6810_d7cc','guest','2025-06-30 16:50:31','2025-06-30 18:55:24'),(15,'room_68629ed0d7e06','127.0.0.1','b117c87a','访客1_b117_75bf','guest','2025-06-30 23:36:13','2025-06-30 23:36:13'),(16,'room_68629ed0d7e06','127.0.0.1','3d743eb4','访客1_3d74_75bf','guest','2025-07-01 00:20:36','2025-07-01 00:28:46'),(17,'room_68629e9e83a43','127.0.0.1','b1501187','访客1_b150_c1f6','guest','2025-07-01 00:27:59','2025-07-01 00:27:59'),(18,'room_68648b22650ce','1.57.233.44','e82ced8e','用户_44e82c2d89','guest','2025-07-02 09:40:30','2025-07-02 09:41:19');
/*!40000 ALTER TABLE `ip_user_binding` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database '110'
--

--
-- Dumping routines for database '110'
--
/*!50003 DROP PROCEDURE IF EXISTS `get_grade` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_grade`(in score int)
begin
declare result varchar(20);
set result = if(score >= 85,"优秀",
if(score > 60 and score < 85,"及格","不及格"
));
select result;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_month` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_month`(in month int)
begin
declare result varchar(20);
case
when month between 1 and 3 then
set result = "第一季度";
when month between 4 and 6 then
set result = "第二季度";
when month between 7 and 9 then
set result = "第三季度";
when month between 10 and 12 then
set result = "第四季度";
else
set result = "非法参数";
end case;
select result;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `month` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `month`(in month int)
begin
declare result varchar(20);
case
when month between 1 and 3 then
set result = "第一季度";
when month between 4 and 6 then
set result = "第二季度";
when month between 7 and 9 then
set result = "第三季度";
when month between 10 and 12 then
set result = "第四季度";
else
set result = "非法参数";
end case;
select resurl;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sum_to_n` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sum_to_n`(IN n INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE total INT DEFAULT 0;

    REPEAT
        SET total = total + i;
        SET i = i + 1;
    UNTIL i > n
    END REPEAT;

    SELECT total AS sum_result;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-02 12:48:16
