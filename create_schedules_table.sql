CREATE TABLE `schedules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slack_id` varchar(30) NOT NULL,
  `schedule_1` varchar(30) DEFAULT NULL,
  `schedule_2` varchar(30) DEFAULT NULL,
  `schedule_3` varchar(30) DEFAULT NULL,
  `schedule_4` varchar(30) DEFAULT NULL,
  `schedule_5` varchar(30) DEFAULT NULL,
  `delete_flag` int(11) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;