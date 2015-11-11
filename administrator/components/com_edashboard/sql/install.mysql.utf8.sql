DROP TABLE IF EXISTS `#__edashboard`;

CREATE TABLE `#__edashboard` (
  `catid` integer NOT NULL default '0',
  `id` integer(10) UNSIGNED NOT NULL auto_increment,
  -- ABP:
  `document_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `document_number` varchar(200) DEFAULT NULL,
  `official_number` varchar(200) NOT NULL,
  `name`  varchar(200) NOT NULL DEFAULT '',
  `description`  mediumtext DEFAULT NULL,
  `hide` tinyint(1) NOT NULL default '0',

  `alias` varchar(100) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` integer(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` integer NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  `access` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',

  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`),
  -- ABP
  KEY `idx_name` (`name`),
  KEY `idx_document_date` (`document_date`),
  KEY `idx_document_number` (`document_number`),
  KEY `idx_official_number` (`official_number`)


)  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__edashboard_attachments`;

CREATE TABLE `#__edashboard_attachments` (
  `id` integer(10) UNSIGNED NOT NULL auto_increment,
  `edashboard_id` integer NOT NULL default '0',
  `file` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)  DEFAULT CHARSET=utf8;

