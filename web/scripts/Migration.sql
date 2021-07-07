ALTER TABLE `missions`.`missionitems`
CHANGE COLUMN `description` `report` VARCHAR(1000) NULL DEFAULT NULL ;

'07/08/2021
DROP TABLE `missions`.`mission_fact`;

ALTER TABLE `missions`.`missionitems`
ADD COLUMN `status` INT NOT NULL DEFAULT 1011 AFTER `missionuid`;
  
