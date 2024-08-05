

CREATE TABLE `action` (
  `action_id` int NOT NULL AUTO_INCREMENT,
  `om_out` int DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `om_arrive` int DEFAULT NULL,
  `time_arrive` time DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `om_in` int DEFAULT NULL,
  `people_incharge` varchar(100) DEFAULT NULL,
  `time_done` time DEFAULT NULL,
  `done_action` varchar(100) DEFAULT NULL,
  `driver` varchar(45) DEFAULT NULL,
  `staff_id` varchar(45) DEFAULT NULL,
  `case_id` int DEFAULT NULL,
  `car_id` int DEFAULT NULL,
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO action VALUES("52","67544","04:34:00","654","15:33:00","03:16:00","3442","0","","","","M(S)000947","2","3");
INSERT INTO action VALUES("53","","","","","","","","","","","","0","");
INSERT INTO action VALUES("54","3344","12:03:00","","","","","0","","","","","38","3");
INSERT INTO action VALUES("55","3224","09:09:00","","","","","1","","","M(S)61721","","42","3");
INSERT INTO action VALUES("56","3224","09:09:00","","","","","1","","","M(S)61721","","42","3");



CREATE TABLE `admin` (
  `admin_id` varchar(10) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO admin VALUES("M(S)000945","NORFAZIRA HANOOM","12345678","2001-03-08","PBT(PA)","hanoomfazira@gmail.com");



CREATE TABLE `astp` (
  `astp_id` varchar(15) NOT NULL,
  `name` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `no_ic` varchar(45) DEFAULT NULL,
  `phone_num` varchar(11) DEFAULT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `bank_account` bigint NOT NULL,
  `position` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `branch` varchar(45) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`astp_id`),
  UNIQUE KEY `bank_account_UNIQUE` (`bank_account`),
  UNIQUE KEY `no_ic_UNIQUE` (`no_ic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO astp VALUES("M(S)000912","AZIM BIN KAMSANI","#astp123","2024-06-11","928378191919","01293838919","public_bank","5267278","PBT(PA)","azim@gmail.com","PKOD Alor Gajah","download (6).jpeg");
INSERT INTO astp VALUES("M(S)000943","SYAHIRAH HUSNA BINTI HUSAIRI","#astp123","2024-05-16","010308123934","01282822223","Maybank","93766667899","PBT(PA)","syahirahusairii@gmail.com","PKOD Jasin","VIOS BROWN.jpeg");
INSERT INTO astp VALUES("M(S)000946","AFIFAH BINTI RAMLI","$2y$10$o6Mo7NJXi5ZlyVd/ikZW5OyqB/0CMQWySXiz28Ad5fsVm3YBwoyf2","2024-06-06","011492827112","0182722333","UOB","322222221","LTM(PA)","afifah@gmail.com","PKOD Jasin","WhatsApp Image 2024-06-14 at 22.06.54_2c84b1d4.jpg");
INSERT INTO astp VALUES("M1273651","LINDA RAFAR BINTI AKIM","#astp123","1990-02-04","901827661551","0192762662","hong_leong","771625255252","LTM(PA)","linda@gmail.com","PKOD Perlis Kangar","ALMERA ORANGE.jpeg");
INSERT INTO astp VALUES("M7831717","HARITH ISKANDAR BINTI NAWI","#astp123","1992-07-03","920703299292","0182828222","ocbc","1827626277282","SJN(PA)","harith@gmail.com","PKOD Alor Gajah","666e6a1f931db.jpeg");
INSERT INTO astp VALUES("M9283838","SHAHRIL BIN RIDZUAN TEO","$2y$10$l/1Vb2QdP/f2Rc4IZnFbIutfavAePaEUib9DcruQPG4DZu0zJTEMu","1998-02-20","980220838388","01265252442","hong_leong","72625254244222","SJN(PA)","shahril@gmail.com","PKOD Melaka Tengah","66730c097bdd8.jpeg");



CREATE TABLE `case` (
  `case_id` int NOT NULL AUTO_INCREMENT,
  `complainant_name` varchar(45) DEFAULT NULL,
  `no_phonecomp` varchar(45) DEFAULT NULL,
  `incident_location` varchar(200) DEFAULT NULL,
  `case_source` varchar(45) DEFAULT NULL,
  `case_date` date DEFAULT NULL,
  `receivecase_time` time DEFAULT NULL,
  `case_status` varchar(7) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `staff_id` varchar(16) DEFAULT NULL,
  `casetype_id` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`case_id`),
  KEY `casetype_id_idx` (`casetype_id`),
  KEY `casetype_id` (`casetype_id`),
  KEY `casetype_id_2` (`casetype_id`) /*!80000 INVISIBLE */,
  KEY `staff_id_idx` (`staff_id`),
  KEY `casetypee_id_idx` (`casetype_id`),
  CONSTRAINT `casetype_id` FOREIGN KEY (`casetype_id`) REFERENCES `case_type` (`casetype_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO case VALUES("38","NANA","01763553522","Durian Tunggal","LAIN-LAIN","2024-06-12","22:03:00","Keluar","Menghalang jalan","M2728181","C10");
INSERT INTO case VALUES("39","HANI","01662662622","2.2295157377027683, 102.29953229427339","HOSPITAL","2024-06-26","06:19:00","Terima","Lemas","M2377733","C08");
INSERT INTO case VALUES("40","NANA","01722727727","JALAN TU23","PDRM","2024-06-19","19:22:00","Terima","LAMA","M2377733","C05");
INSERT INTO case VALUES("41","HHR","01722727727","Durian Tunggal","HOSPITAL","2024-06-27","06:25:00","Terima","WEEE","M2377733","C03");
INSERT INTO case VALUES("42","HAIZAM","01727272772","Jalan TU 3, Taman Tasik Utama, Ayer Keroh, Hang Tuah Jaya Municipal Council, Central Malacca, Malacca, 75450, Malaysia","TMRC","2024-06-10","11:06:00","Terima","Lebah lalat","M12882822","C03");



CREATE TABLE `case_type` (
  `casetype_id` varchar(3) NOT NULL,
  `case_name` varchar(45) NOT NULL,
  PRIMARY KEY (`casetype_id`),
  UNIQUE KEY `case_name_UNIQUE` (`case_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO case_type VALUES("C01","KEMALANGAN JALAN RAYA");
INSERT INTO case_type VALUES("C04","KEMALANGAN TEMPAT KERJA");
INSERT INTO case_type VALUES("C07","KES BERGADUH");
INSERT INTO case_type VALUES("C06","KES BUNUH DIRI");
INSERT INTO case_type VALUES("C09","KES MENANGKAP ULAR");
INSERT INTO case_type VALUES("C12","KHIDMAT KHAS");
INSERT INTO case_type VALUES("C08","MANGSA LEMAS");
INSERT INTO case_type VALUES("C05","MANGSA TERPERANGKAP");
INSERT INTO case_type VALUES("C03","MEMUSNAHKAN SARANG SERANGGA");
INSERT INTO case_type VALUES("C11","MENANGKAP HAIWAN LIAR");
INSERT INTO case_type VALUES("C10","POKOK TUMBANG");
INSERT INTO case_type VALUES("C02","SAKIT");



CREATE TABLE `equipment` (
  `equipment_id` int NOT NULL AUTO_INCREMENT,
  `equipment_name` varchar(255) NOT NULL,
  PRIMARY KEY (`equipment_id`),
  UNIQUE KEY `equipment_name_UNIQUE` (`equipment_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO equipment VALUES("22","AED");
INSERT INTO equipment VALUES("26","AIR");
INSERT INTO equipment VALUES("27","ANGIN TAYAR");
INSERT INTO equipment VALUES("25","CERVICAL COLLAR");
INSERT INTO equipment VALUES("24","PENCAHAYAAN");
INSERT INTO equipment VALUES("23","SELIAAN MINYAK HITAM");
INSERT INTO equipment VALUES("28","SOCKET PLUG");
INSERT INTO equipment VALUES("21","WINCH");



CREATE TABLE `staff` (
  `staff_id` varchar(16) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dob` varchar(32) NOT NULL,
  `no_ic` varchar(45) DEFAULT NULL,
  `no_phone` varchar(11) DEFAULT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `bank_account` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `shift` varchar(45) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `astp_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `no_ic_UNIQUE` (`no_ic`),
  KEY `astp_id_idx` (`astp_id`),
  CONSTRAINT `astpp_id` FOREIGN KEY (`astp_id`) REFERENCES `astp` (`astp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO staff VALUES("M(S)61721","SARAH NAZIHA BINTI AHMAD","$2y$10$3jppPe/suUSP3/exx8gvyuvfsBaX6vhNUowotP6cajpPAG3nrdT8i","2002-06-13","022812771972","01129391919","Maybank","88277363636","KPL(PA)","sarah@gmail.com","Pagi","667344aa6d42f.jpeg","M(S)000946");
INSERT INTO staff VALUES("M12882822","SHARIFAH JUMIKA","$2y$10$di0vTZecvM6ber5bGqCZ1OV0XB3/b1cpUcfeP6bqG.5luUpiNnlVW","2024-06-19","996251771717","0122413167","cimb","92876524444444444","KPL(PA)","jumika@gmail.com","Petang","6673461fb885c.jpeg","M(S)000946");
INSERT INTO staff VALUES("M2377733","AH CHAN ","$2y$10$CCBS5rOeDJVGI91MX5jyde.dJwHGuqgu1Q34wE6bnBRCS4rqTAjv6","1990-06-11","012777288282","01727723773","ocbc","88277363636","PBT(PA)","ahchan@gmail.com","Malam","66730ea1e1a33.jpeg","M9283838");
INSERT INTO staff VALUES("M2728181","ALANG BIN KHAMIS","#staff123","2024-06-14","017226366366","01727383333","rhb","287373733","KPL(PA)","alang@gmail.com","Pagi","VIVA BLACK.jpeg","M1273651");



CREATE TABLE `transportation` (
  `car_id` int NOT NULL AUTO_INCREMENT,
  `car_name` varchar(45) DEFAULT NULL,
  `code_name` varchar(45) DEFAULT NULL,
  `roadtax_expirydate` date DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `no_plate` varchar(45) DEFAULT NULL,
  `astp_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`car_id`),
  UNIQUE KEY `code_name_UNIQUE` (`code_name`),
  UNIQUE KEY `no_plate_UNIQUE` (`no_plate`),
  KEY `astp_id_idx` (`astp_id`),
  CONSTRAINT `astp_id` FOREIGN KEY (`astp_id`) REFERENCES `astp` (`astp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO transportation VALUES("3","HILUX","CM012","2024-06-25","Penyelamat Ringan","MALAYSIA 1347","M(S)000946");
INSERT INTO transportation VALUES("9","AMBULANS","CM204","2024-06-27","Ambulans","WQM1929","M1273651");



CREATE TABLE `transportation_equipment_check` (
  `check_id` int NOT NULL AUTO_INCREMENT,
  `branch` varchar(255) NOT NULL,
  `date_check` date NOT NULL,
  `no_plate` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `equipment_id` int NOT NULL,
  `status` enum('BAIK','ROSAK','TIADA') NOT NULL,
  `staff_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`check_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `staff_id_idx` (`staff_id`),
  CONSTRAINT `stap_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  CONSTRAINT `transportation_equipment_check_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


