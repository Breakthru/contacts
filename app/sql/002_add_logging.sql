CREATE TABLE IF NOT EXISTS `brm_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_agent` varchar(255),
  `ip_address` varchar(255),
  `referrer` varchar(255),
  `url` varchar(255),
  `timestamp` DATETIME,
  PRIMARY KEY (`id`)
)