--
-- Table structure for table `project_statusses`
--
DROP TABLE IF EXISTS `project_statusses`;
CREATE TABLE `project_statusses` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(70) NOT NULL,
    `sort` int NOT NULL,
    `class` varchar(45) NOT NULL,
    PRIMARY KEY (`id`)
);
--
-- Table structure for table `projects`
--
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
    `id` int NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `user_uuid` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    `source_language` varchar(255) DEFAULT NULL,
    `target_language` varchar(255) DEFAULT NULL,
    `planned_date` datetime NOT NULL COMMENT 'This will determine on which day the task is shownb',
    `start_date` datetime NOT NULL,
    `due_date` datetime NOT NULL,
    `word_count` int DEFAULT NULL,
    `adddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `moddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `project_status` int NOT NULL,
    `test` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`uuid`),
    UNIQUE KEY `id` (`id`),
    KEY `FK_p_project_status_ps_id_idx` (`project_status`),
    CONSTRAINT `FK_p_project_status_ps_id` FOREIGN KEY (`project_status`) REFERENCES `project_statusses` (`id`)
);
--
-- Table structure for table `todo_lists`
--
DROP TABLE IF EXISTS `todo_lists`;
CREATE TABLE `todo_lists` (
    `id` int NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `user_uuid` varchar(255) NOT NULL,
    `date` datetime NOT NULL,
    `name` varchar(255) NOT NULL,
    `done` tinyint DEFAULT '0',
    `sort` int DEFAULT '0',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uuid_UNIQUE` (`uuid`)
);
--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `username` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varbinary(255) NOT NULL,
    `reset_pw_token` longtext,
    `token_expire` datetime DEFAULT NULL,
    `adddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `moddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `last_login` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uuid` (`uuid`),
    UNIQUE KEY `id` (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
);