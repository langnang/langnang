-- metas
CREATE ALGORITHM = UNDEFINED DEFINER = `:user` @`%` SQL SECURITY DEFINER VIEW `preview`.`typecho_%_metas` AS SELECT
`typecho__metas`.`mid` AS `mid`,
`typecho__metas`.`name` AS `name`,
`typecho__metas`.`slug` AS `slug`,
`typecho__metas`.`type` AS `type`,
`typecho__metas`.`description` AS `description`,
`typecho__metas`.`count` AS `count`,
`typecho__metas`.`order` AS `order`,
`typecho__metas`.`parent` AS `parent`
FROM
	`typecho__metas`
WHERE
	( `typecho__metas`.`mid` = :mid ) UNION
SELECT
	`typecho__metas`.`mid` AS `mid`,
	`typecho__metas`.`name` AS `name`,
	`typecho__metas`.`slug` AS `slug`,
	`typecho__metas`.`type` AS `type`,
	`typecho__metas`.`description` AS `description`,
	`typecho__metas`.`count` AS `count`,
	`typecho__metas`.`order` AS `order`,
	`typecho__metas`.`parent` AS `parent`
FROM
	`typecho__metas`
WHERE
	(
		0 <> find_in_set(
		`typecho__metas`.`mid`,
	`getAllSubNodes` ( :mid )));
-- relationships
CREATE ALGORITHM = UNDEFINED DEFINER = `:user` @`%` SQL SECURITY DEFINER VIEW `preview`.`typecho_%_relationships` AS SELECT
`typecho__relationships`.`cid` AS `cid`,
`typecho__relationships`.`mid` AS `mid`
FROM
	( `typecho__relationships` JOIN `typecho_%_metas` )
WHERE
	( `typecho_%_metas`.`mid` = `typecho__relationships`.`mid` );
-- contents
CREATE ALGORITHM = UNDEFINED DEFINER = `:user` @`%` SQL SECURITY DEFINER VIEW `preview`.`typecho_%_contents` AS SELECT
`typecho__contents`.`cid` AS `cid`,
`typecho__contents`.`title` AS `title`,
`typecho__contents`.`slug` AS `slug`,
`typecho__contents`.`created` AS `created`,
`typecho__contents`.`modified` AS `modified`,
`typecho__contents`.`text` AS `text`,
`typecho__contents`.`order` AS `order`,
`typecho__contents`.`authorId` AS `authorId`,
`typecho__contents`.`template` AS `template`,
`typecho__contents`.`type` AS `type`,
`typecho__contents`.`status` AS `status`,
`typecho__contents`.`password` AS `password`,
`typecho__contents`.`commentsNum` AS `commentsNum`,
`typecho__contents`.`allowComment` AS `allowComment`,
`typecho__contents`.`allowPing` AS `allowPing`,
`typecho__contents`.`allowFeed` AS `allowFeed`,
`typecho__contents`.`parent` AS `parent`
FROM
	( `typecho__contents` JOIN `typecho_%_relationships` )
WHERE
	( `typecho__contents`.`cid` = `typecho_%_relationships`.`cid` );
-- fields
CREATE ALGORITHM = UNDEFINED DEFINER = `:user` @`%` SQL SECURITY DEFINER VIEW `preview`.`typecho_%_fields` AS SELECT
`typecho__fields`.`cid` AS `cid`,
`typecho__fields`.`name` AS `name`,
`typecho__fields`.`type` AS `type`,
`typecho__fields`.`str_value` AS `str_value`,
`typecho__fields`.`int_value` AS `int_value`,
`typecho__fields`.`float_value` AS `float_value`
FROM
	( `typecho__fields` JOIN `typecho_%_contents` )
WHERE
	( `typecho_%_contents`.`cid` = `typecho__fields`.`cid` );
-- comments
CREATE ALGORITHM = UNDEFINED DEFINER = `:user`@`%` SQL SECURITY DEFINER VIEW `preview`.`typecho_%_comments` AS SELECT
	`typecho__comments`.`coid` AS `coid`,
	`typecho__comments`.`cid` AS `cid`,
	`typecho__comments`.`created` AS `created`,
	`typecho__comments`.`author` AS `author`,
	`typecho__comments`.`authorId` AS `authorId`,
	`typecho__comments`.`ownerId` AS `ownerId`,
	`typecho__comments`.`mail` AS `mail`,
	`typecho__comments`.`url` AS `url`,
	`typecho__comments`.`ip` AS `ip`,
	`typecho__comments`.`agent` AS `agent`,
	`typecho__comments`.`text` AS `text`,
	`typecho__comments`.`type` AS `type`,
	`typecho__comments`.`status` AS `status`,
	`typecho__comments`.`parent` AS `parent`
FROM
	`typecho__comments`;
-- users
CREATE ALGORITHM = UNDEFINED DEFINER = `:user` @`%` SQL SECURITY DEFINER VIEW `preview`.`typecho_%_comments` AS SELECT
`typecho__users`.`uid` AS `uid`,
`typecho__users`.`name` AS `name`,
`typecho__users`.`password` AS `password`,
`typecho__users`.`mail` AS `mail`,
`typecho__users`.`url` AS `url`,
`typecho__users`.`screenName` AS `screenName`,
`typecho__users`.`created` AS `created`,
`typecho__users`.`activated` AS `activated`,
`typecho__users`.`logged` AS `logged`,
`typecho__users`.`group` AS `group`,
`typecho__users`.`authCode` AS `authCode`
FROM
	`typecho__users`;
-- options
CREATE ALGORITHM = UNDEFINED DEFINER = `:user` @`%` SQL SECURITY DEFINER VIEW `preview`.`typecho_%_comments` AS SELECT
`typecho__options`.`name` AS `name`,
`typecho__options`.`user` AS `user`,
`typecho__options`.`value` AS `value`
FROM
	`typecho__options`;
