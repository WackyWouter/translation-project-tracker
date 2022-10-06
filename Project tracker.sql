CREATE TABLE `users` (
  `id` int AUTO_INCREMENT,
  `uuid` varchar(255) UNIQUE PRIMARY KEY,
  `username` varchar(255) UNIQUE NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password` varbinary NOT NULL,
  `adddate` datetime,
  `moddate` datetime
);

CREATE TABLE `projects` (
  `id` int AUTO_INCREMENT,
  `uuid` varchar(255) UNIQUE,
  `user_uuid` varchar(255),
  `title` varchar(255) NOT NULL,
  `source_language` varchar(255),
  `target_language` varchar(255),
  `planned_date` datetime, -- This will determine on which day the task is shown
  `start_date` datetime,
  `due_date` datetime,
  `word_count` int,
  `adddate` datetime,
  `moddate` datetime
);

ALTER TABLE `projects` ADD FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`);
