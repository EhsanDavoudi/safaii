CREATE TABLE `admin` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `name` varchar(100) NOT NULL,
                         `lastname` varchar(100) NOT NULL,
                         `username` varchar(50) NOT NULL,
                         `email` varchar(100) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `permission` char(1) NOT NULL CHECK (`permission` in ('A','B','C')),
                         `created_at` timestamp NULL DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `username` (`username`),
                         UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `analyzes` (
                            `id` varchar(225) NOT NULL,
                            `symbol` varchar(50) NOT NULL,
                            `sentiment` varchar(50) DEFAULT NULL,
                            `confidence` decimal(5,2) DEFAULT NULL,
                            `sentiment_intensity` decimal(5,2) DEFAULT NULL,
                            `importance` tinyint(4) DEFAULT NULL,
                            `explanation` text DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `blog` (
                        `id` varchar(32) NOT NULL,
                        `title` varchar(255) NOT NULL,
                        `date` date NOT NULL,
                        `article` text DEFAULT NULL,
                        `symbols` varchar(255) DEFAULT NULL,
                        `sentiment` text DEFAULT NULL,
                        `explanation` text DEFAULT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `deals` (
                         `id` int(10) NOT NULL AUTO_INCREMENT,
                         `user_id` int(10) NOT NULL,
                         `news_signal` int(2) DEFAULT NULL,
                         `trading_signal` float DEFAULT NULL,
                         `tether_amount` decimal(10,2) DEFAULT NULL,
                         `status` tinyint(1) DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         KEY `user_id` (`user_id`),
                         CONSTRAINT `fk_custom_field_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1676 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `news` (
                        `id` varchar(255) NOT NULL,
                        `title` varchar(255) NOT NULL,
                        `date` date NOT NULL,
                        `link` varchar(255) DEFAULT NULL,
                        `article_text` text DEFAULT NULL,
                        `translated_title` varchar(255) DEFAULT NULL,
                        `translated_text` text DEFAULT NULL,
                        `translated_text_summarized` text DEFAULT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
                         `id` int(10) NOT NULL AUTO_INCREMENT,
                         `name` varchar(100) NOT NULL,
                         `last_name` varchar(100) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `nobitex_token` varchar(255) DEFAULT NULL,
                         `credit` decimal(10,0) DEFAULT 50,
                         `created_at` timestamp NULL DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE news (
                      id VARCHAR(32) PRIMARY KEY,
                      title VARCHAR(255),
                      date DATE,
                      link TEXT,
                      article_text TEXT,
                      translated_title TEXT,
                      translated_text TEXT,
                      translated_text_summarzied TEXT
);

CREATE TABLE analyze (
                         id VARCHAR(32),
                         symbol VARCHAR(10),
                         sentiment VARCHAR(50),
                         confidence DECIMAL(5,2),
                         sentiment_intensity DECIMAL(5,2),
                         importance DECIMAL(5,2),
                         explanation TEXT
);

CREATE TABLE blog (
                      id VARCHAR(32),
                      title VARCHAR(255),
                      date DATE,
                      article TEXT,
                      symbols TEXT,
                      sentiment TEXT,
                      explanation TEXT
);
