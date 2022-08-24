CREATE TABLE IF NOT EXISTS `data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` timestamp DEFAULT CURRENT_TIMESTAMP,
  `device_name` varchar(255) NOT NULL,
  'location' varchar(255) NOT NULL,
  'floor' varchar(255) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE `device_name` (`device_name`),
  UNIQUE `user_name` (`user_name)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;