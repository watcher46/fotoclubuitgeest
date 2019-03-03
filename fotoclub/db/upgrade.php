<?php

//add proper columns
$alterQuery1 = "ALTER TABLE `galerij` ADD `status` varchar(20) NOT NULL;";
$alterQuery2 = "ALTER TABLE `images` ADD `status` varchar(20) NOT NULL;";
$alterQuery3 = "ALTER TABLE `items` ADD `status` varchar(20) NOT NULL;";
$alterQuery4 = "ALTER TABLE `leden` ADD `status` varchar(20) NOT NULL;";

//update new column
$updateQuery1 = 'UPDATE `galerij` SET status="actief" where actief="1"; UPDATE `galerij` SET status="inactief" where actief="0";';
$updateQuery2 = 'UPDATE `images` SET status="actief" where actief="1"; UPDATE `images` SET status="inactief" where actief="0";';
$updateQuery3 = 'UPDATE `items` SET status="actief" where actief="1"; UPDATE `items` SET status="inactief" where actief="0";';
$updateQuery4 = 'UPDATE `leden` SET status="actief" where actief="1"; UPDATE `leden` SET status="inactief" where actief="0";';

//remove old column
$removeQuery1 = 'ALTER TABLE `galerij` DROP `actief`;';
$removeQuery2 = 'ALTER TABLE `images` DROP `actief`;';
$removeQuery3 = 'ALTER TABLE `items` DROP `actief`;';
$removeQuery4 = 'ALTER TABLE `leden` DROP `actief`;';