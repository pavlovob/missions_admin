ALTER TABLE `missions`.`missionitems`
CHANGE COLUMN `description` `report` VARCHAR(1000) NULL DEFAULT NULL ;

-- 07/08/2021
DROP TABLE `missions`.`mission_fact`;
ALTER TABLE `missions`.`missionitems`
ADD COLUMN `status` INT NOT NULL DEFAULT 1011 AFTER `missionuid`;

-- 13/07/21
ALTER TABLE `missions`.`missionitems`
CHANGE COLUMN `date_created` `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `date_changed` `changed` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ;

-- 21/07/2021
ALTER TABLE `missions`.`executers`
ADD COLUMN `personname` VARCHAR(100) NULL AFTER `name`;
