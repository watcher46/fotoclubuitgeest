<?php
$all = '
ALTER TABLE `galerij` ADD `status` varchar(20) NOT NULL;
ALTER TABLE `images` ADD `status` varchar(20) NOT NULL;
ALTER TABLE `items` ADD `status` varchar(20) NOT NULL;
ALTER TABLE `leden` ADD `status` varchar(20) NOT NULL;

UPDATE `galerij` SET status="actief" where actief="1"; UPDATE `galerij` SET status="inactief" where actief="0";
UPDATE `images` SET status="actief" where actief="1"; UPDATE `images` SET status="inactief" where actief="0";
UPDATE `items` SET status="actief" where actief="1"; UPDATE `items` SET status="inactief" where actief="0";
UPDATE `leden` SET status="actief" where actief="1"; UPDATE `leden` SET status="inactief" where actief="0";

ALTER TABLE `galerij` DROP `actief`;
ALTER TABLE `images` DROP `actief`;
ALTER TABLE `items` DROP `actief`;
ALTER TABLE `leden` DROP `actief`;
';