-- Script de Migracion 
-- Monta los archivos planos en las tablas de Postgres
-- Parte: 3/4
copy stdedici from '/var/www/sistemas/planos/stdedici.unl'  delimiter '|';
copy stzevtrd from '/var/www/sistemas/planos/stzevtrd1.unl' delimiter '|';
copy stzevtrd from '/var/www/sistemas/planos/stzevtrd2.unl' delimiter '|';
copy stzdaper from '/var/www/sistemas/planos/stzdaper.unl'  delimiter '|';
copy stzdajur from '/var/www/sistemas/planos/stzdajur.unl'  delimiter '|';
copy stdobart from '/var/www/sistemas/planos/stdobart.unl'  delimiter '|';
copy stdobpro from '/var/www/sistemas/planos/stdobpro.unl'  delimiter '|';
copy stdobaut from '/var/www/sistemas/planos/stdobaut.unl'  delimiter '|';
copy stdobsol from '/var/www/sistemas/planos/stdobsol.unl'  delimiter '|';
copy stdobtit from '/var/www/sistemas/planos/stdobtit.unl'  delimiter '|';
copy stdgrupo from '/var/www/sistemas/planos/stdgrupo.unl'  delimiter '|';
copy stzottid from '/var/www/sistemas/planos/stzottid1.unl' delimiter '|';
copy stzottid from '/var/www/sistemas/planos/stzottid2.unl' delimiter '|';
copy stzhotid from '/var/www/sistemas/planos/stzhotid1.unl' delimiter '|';
copy stzhotid from '/var/www/sistemas/planos/stzhotid2.unl' delimiter '|';
--[ Stzcaded ]
copy stzcaded from '/var/www/sistemas/planos/stzcaded1.unl' delimiter '|';
copy stzcaded from '/var/www/sistemas/planos/stzcaded2.unl' delimiter '|';
copy stzcaded from '/var/www/sistemas/planos/stzcaded3.unl' delimiter '|';
copy stzotrde from '/var/www/sistemas/planos/stzotrde2.unl' delimiter '|';
--[ Stzbitac ]
--[ Stzbitex ]
--[ Stzsystem ]
-- Esta tabla se llenara con los valores iniciales al finalizar la migracion --
-- End Script --

