CREATE TABLE `schedules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `plan1` varchar(30) DEFAULT NULL,
  `plan2` varchar(30) DEFAULT NULL,
  `plan3` varchar(30) DEFAULT NULL,
  `plan4` varchar(30) DEFAULT NULL,
  `plan5` varchar(30) DEFAULT NULL,
  `delete_flag` int(11) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;