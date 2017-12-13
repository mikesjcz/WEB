-- MySQL Script pro databazi semestralni prace

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Tabulka tab_prava
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tab_prava` ;

CREATE TABLE IF NOT EXISTS `tab_prava` (
  `idprava` INT NOT NULL,
  `nazev` VARCHAR(20) NOT NULL,
  `vaha` INT(2) NOT NULL,
  PRIMARY KEY (`idprava`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8 COLLATE = utf8_czech_ci;

-- -----------------------------------------------------
-- Tabulka tab_licence
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tab_licence` ;

CREATE TABLE IF NOT EXISTS `tab_licence` (
  `idlicence` INT NOT NULL,
  `nazevL` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idlicence`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8 COLLATE = utf8_czech_ci;

-- -----------------------------------------------------
-- Tabulka tab_uzivatele
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tab_uzivatele` ;

CREATE TABLE IF NOT EXISTS `tab_uzivatele` (
  `iduzivatel` INT NOT NULL AUTO_INCREMENT,
  `jmeno` VARCHAR(60) NOT NULL,
  `login` VARCHAR(30) NOT NULL,
  `heslo` VARCHAR(40) NOT NULL,
  `email` VARCHAR(35) NOT NULL,
  `idlicence` INT NOT NULL DEFAULT 4,
  `adresa` VARCHAR(45) NOT NULL,
  `mesto` VARCHAR(45) NOT NULL,
  `idprava` INT NOT NULL DEFAULT 4,
  PRIMARY KEY (`iduzivatel`),
  INDEX `fk_uzivatele_prava_idx` (`idprava` ASC),
  CONSTRAINT `fk_uzivatele_prava`
    FOREIGN KEY (`idprava`)
    REFERENCES `tab_prava` (`idprava`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,  
  INDEX `fk_uzivatele_licence_idx` (`idlicence` ASC),
  CONSTRAINT `fk_uzivatele_licence`
    FOREIGN KEY (`idlicence`)
    REFERENCES `tab_licence` (`idlicence`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8 COLLATE = utf8_czech_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Tabulka tab_clanky
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tab_clanky` ;

CREATE TABLE IF NOT EXISTS `tab_clanky` (
  `idclanek` INT NOT NULL AUTO_INCREMENT,
  `nazev` VARCHAR(30) NOT NULL,
  `autori` VARCHAR(30) NOT NULL,
  `clanek` VARCHAR(500) NOT NULL,
  `pdf` VARCHAR(30) NOT NULL,
  `schvaleno` INT(1) NULL DEFAULT '0',
  PRIMARY KEY (`idclanek`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8 COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Tabulka tab_hodnoceni
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tab_hodnoceni` ;

CREATE TABLE IF NOT EXISTS `tab_hodnoceni` (
  `idhodnoceni` INT NOT NULL AUTO_INCREMENT,
  `idclanek` INT(11) NOT NULL,
  `iduzivatele` INT(11) NOT NULL,
  `originalita` INT(11) NOT NULL,
  `tema` INT(11) NOT NULL,
  `techkvalita` INT(11) NOT NULL,
  `jazykkvalita` INT(11) NOT NULL,
  `doporuceni` INT(11) NOT NULL,
  `poznamky` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`idhodnoceni`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8 COLLATE = utf8_czech_ci;

-- -----------------------------------------------------
-- Tabulka tab_znamky
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tab_znamky` ;

CREATE TABLE IF NOT EXISTS `tab_znamky` (
  `idznamky` INT NOT NULL AUTO_INCREMENT,
  `znamka` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`idznamky`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8 COLLATE = utf8_czech_ci;

-- -----------------------------------------------------
-- pridani zakladnich dat do tabulky tab-prava `
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `tab_prava` (`idprava`, `nazev`, `vaha`) VALUES (1, 'Administrator', 10);
INSERT INTO `tab_prava` (`idprava`, `nazev`, `vaha`) VALUES (2, 'Skolitel', 5);
INSERT INTO `tab_prava` (`idprava`, `nazev`, `vaha`) VALUES (3, 'Rozhodci', 3);
INSERT INTO `tab_prava` (`idprava`, `nazev`, `vaha`) VALUES (4, 'Navstevnik', 2);

COMMIT;

-- -----------------------------------------------------
-- pridani zakladnich dat do tabulky tab-licence`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `tab_licence` (`idlicence`, `nazevL`) VALUES (1, 'A');
INSERT INTO `tab_licence` (`idlicence`, `nazevL`) VALUES (2, 'B');
INSERT INTO `tab_licence` (`idlicence`, `nazevL`) VALUES (3, 'C');
INSERT INTO `tab_licence` (`idlicence`, `nazevL`) VALUES (4, 'bez');

COMMIT;


-- -----------------------------------------------------
-- pridani zakladnich dat do tabulky tab-uzivatele `
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `tab_uzivatele` (`iduzivatel`, `jmeno`, `login`, `heslo`, `email`, `idlicence`, `adresa`, `mesto`, `idprava`) VALUES (1, 'Administrator', 'admin', 'admin', '---', 4, '---' , '---', 1);

COMMIT;

-- -----------------------------------------------------
-- pridani zakladnich dat do tabulky tab-znamky`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `tab_znamky` (`idznamky`, `znamka`) VALUES (1, 'vyborny');
INSERT INTO `tab_znamky` (`idznamky`, `znamka`) VALUES (2, 'chvalitebny');
INSERT INTO `tab_znamky` (`idznamky`, `znamka`) VALUES (3, 'dobry');
INSERT INTO `tab_znamky` (`idznamky`, `znamka`) VALUES (4, 'dostatecny');
INSERT INTO `tab_znamky` (`idznamky`, `znamka`) VALUES (5, 'nedostatecny');

COMMIT;

-- -----------------------------------------------------
-- pridani ukazkoveho clanku
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `tab_clanky` (`idclanek`, `nazev`, `autori`, `clanek`, `pdf`, `schvaleno`) VALUES (1, 'pokus', 'admin', 'abstract.', 'bez pdf' , 0);


COMMIT;