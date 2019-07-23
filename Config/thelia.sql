
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- robots
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `robots`;

CREATE TABLE `robots`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `domain_name` VARCHAR(255) NOT NULL,
    `robots_content` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
