-- Script de Migracion 
-- Monta los archivos planos en las tablas de Postgres
-- Parte: 2/4
copy stmmarce  from '/var/www/sistemas/planos/stmmarce.unl'   delimiter '|';
copy stppatee  from '/var/www/sistemas/planos/stppatee.unl'   delimiter '|';
copy stdrepre  from '/var/www/sistemas/planos/stdrepre.unl'   delimiter '|';
copy stdescen  from '/var/www/sistemas/planos/stdescen.unl'   delimiter '|';
copy stdartar  from '/var/www/sistemas/planos/stdartar.unl'   delimiter '|';
copy stdfijin  from '/var/www/sistemas/planos/stdfijin.unl'   delimiter '|';
copy stdactos  from '/var/www/sistemas/planos/stdactos.unl'   delimiter '|';
copy stdtrans  from '/var/www/sistemas/planos/stdtrans.unl'   delimiter '|';
copy stdvisua  from '/var/www/sistemas/planos/stdvisua.unl'   delimiter '|';
copy stdmusic  from '/var/www/sistemas/planos/stdmusic.unl'   delimiter '|';
copy stdfijac  from '/var/www/sistemas/planos/stdfijac.unl'   delimiter '|';
copy stdderiv  from '/var/www/sistemas/planos/stdderiv.unl'   delimiter '|';
copy stmlemad  from '/var/www/sistemas/planos/stmlemad.unl'   delimiter '|';
copy stmlogos  from '/var/www/sistemas/planos/stmlogos.unl'   delimiter '|';
copy stmliaor  from '/var/www/sistemas/planos/stmliaor.unl'   delimiter '|';
copy stmccvma  from '/var/www/sistemas/planos/stmccvma.unl'   delimiter '|';
copy stplocad  from '/var/www/sistemas/planos/stplocad.unl'   delimiter '|';
copy stppacld  from '/var/www/sistemas/planos/stppacld.unl'   delimiter '|';
copy stpclsfd  from '/var/www/sistemas/planos/stpclsfd.unl'   delimiter '|';
copy stzliced  from '/var/www/sistemas/planos/stzliced1.unl'  delimiter '|';
copy stzliced  from '/var/www/sistemas/planos/stzliced2.unl'  delimiter '|';
copy stzpriod  from '/var/www/sistemas/planos/stzpriod1.unl'  delimiter '|';
copy stzpriod  from '/var/www/sistemas/planos/stzpriod2.unl'  delimiter '|';
copy stztmpbo  from '/var/www/sistemas/planos/stztmpbo.unl'   delimiter '|';
copy stzantma  from '/var/www/sistemas/planos/stzantma.unl'   delimiter '|';
copy stzautod  from '/var/www/sistemas/planos/stzautod1.unl'  delimiter '|';
copy stzautod  from '/var/www/sistemas/planos/stzautod2.unl'  delimiter '|';
copy stdevtrd  from '/var/www/sistemas/planos/stdevtrd.unl'   delimiter '|';
copy stdcaded  from '/var/www/sistemas/planos/stdcaded.unl'   delimiter '|';
copy stdotrde  from '/var/www/sistemas/planos/stdotrde.unl'   delimiter '|';
copy stzsolic  from '/var/www/sistemas/planos/stzsolic1.unl'  delimiter '|';
copy stzsolic  from '/var/www/sistemas/planos/stzsolic2.unl'  delimiter '|';
copy stzsolic  from '/var/www/sistemas/planos/stzsolic3.unl'  delimiter '|';
copy stzcoded  from '/var/www/sistemas/planos/stzcoded.unl'  delimiter '|';
copy stzcaded  from '/var/www/sistemas/planos/stzcaded.unl'  delimiter '|';
copy stzotrde  from '/var/www/sistemas/planos/stzotrde.unl'  delimiter '|';
--
copy stpinved  from '/var/www/sistemas/planos/stpinved.unl'  delimiter '|';
copy stmofdev  from '/var/www/sistemas/planos/stmofdev.unl'  delimiter '|';
copy stmtmpam  from '/var/www/sistemas/planos/stmtmpam.unl'  delimiter '|';
copy stpequiv  from '/var/www/sistemas/planos/stpequiv.unl'  delimiter '|';
copy stmtmpef  from '/var/www/sistemas/planos/stmtmpef.unl'  delimiter '|';
copy stmrecla  from '/var/www/sistemas/planos/stmrecla.unl'  delimiter '|';
copy stzmargi  from '/var/www/sistemas/planos/stzmargi.unl'  delimiter '|';

-- End Script --

