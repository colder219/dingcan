CREATE TABLE `dingcan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `love` varchar(100) DEFAULT NULL,
  `shijian` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shijian` (`shijian`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8
