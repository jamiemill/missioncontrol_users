DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `slug` varchar(255) default NULL,
  `parent_id` int(10) default '0',
  `lft` int(10) unsigned NOT NULL default '0',
  `rght` int(10) unsigned NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deleted` int(1) default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


INSERT INTO `groups` VALUES (1, 'Guests', 'guests', NULL, 1, 12, '2008-11-25 16:23:50', '2008-11-25 16:23:50', 0, NULL);
INSERT INTO `groups` VALUES (2, 'Users', 'users', 1, 2, 11, '2008-11-25 16:23:57', '2008-11-25 16:23:57', 0, NULL);
INSERT INTO `groups` VALUES (3, 'Contributors', 'contributors', 2, 3, 10, '2008-11-25 16:24:15', '2008-11-25 16:24:15', 0, NULL);
INSERT INTO `groups` VALUES (4, 'Editors', 'editors', 3, 4, 9, '2008-11-25 16:24:21', '2008-11-25 16:24:21', 0, NULL);
INSERT INTO `groups` VALUES (5, 'Administrators', 'administrators', 4, 5, 8, '2008-11-25 16:24:34', '2008-11-25 16:24:34', 0, NULL);
INSERT INTO `groups` VALUES (6, 'Super Administrators', 'super_administrators', 5, 6, 7, '2008-11-25 16:24:43', '2008-11-25 16:24:43', 0, NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `email` varchar(255) default NULL,
  `password` varchar(50) default NULL,
  `first_name` varchar(255) default NULL,
  `last_name` varchar(255) default NULL,
  `group_id` int(8) default NULL,
  `last_login` datetime default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `activated` tinyint(1) default '0',
  `enabled` tinyint(1) default '1',
  `deleted` int(1) default '0',
  `deleted_date` datetime default NULL,
  `activation_sent` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `user_id` int(8) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
