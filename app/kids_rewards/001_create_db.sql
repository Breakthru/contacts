CREATE TABLE IF NOT EXISTS `toy_bank_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_from` varchar(255) NOT NULL,
  `account_to` varchar(255) NOT NULL,
  `amount` int NOT NULL,
  `reference` varchar(1024) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;