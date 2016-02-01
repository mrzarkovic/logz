CREATE SCHEMA `logz` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE `logz`.`logs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `date_added` DATETIME NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `logz`.`log_entries` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date_added` DATETIME NULL,
  `text` TEXT NULL,
  `parent_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `logs_entries_idx` (`parent_id` ASC),
  CONSTRAINT `logs_entries`
    FOREIGN KEY (`parent_id`)
    REFERENCES `logz`.`logs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
