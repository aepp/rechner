ALTER TABLE `produkt_kredit`
	ADD COLUMN `produkt_interest` TINYINT(1) NULL DEFAULT '1' AFTER `produkt_is_active`;
ALTER TABLE `produkt_geldanlage`
	ADD COLUMN `produkt_interest` TINYINT(1) NULL DEFAULT '1' AFTER `produkt_is_active`;	

update produkt_geldanlage set produkt_geldanlage.produkt_interest = 1;
update produkt_kredit set produkt_kredit.produkt_interest = 1;