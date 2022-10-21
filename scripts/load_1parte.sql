-- Script de Migracion 
-- Monta los archivos planos en las tablas de Postgres
-- Parte: 1/4
copy Stzpaisr   from '/var/www/sistemas/planos/stzpaisr.unl'   delimiter '|';
copy Stdidiom   from '/var/www/sistemas/planos/stdidiom.unl'   delimiter '|';
copy Stzagenr   from '/var/www/sistemas/planos/Stzagenr.unl'   delimiter '|';
copy Stzpoder   from '/var/www/sistemas/planos/Stzpoder.unl'   delimiter '|';
copy Stzpohad   from '/var/www/sistemas/planos/Stzpohad.unl'   delimiter '|';
copy Stzstder   from '/var/www/sistemas/planos/Stzstder1.unl'  delimiter '|';
copy Stzstder   from '/var/www/sistemas/planos/Stzstder2.unl'  delimiter '|';
copy Stdstobr   from '/var/www/sistemas/planos/Stdstobr.unl'   delimiter '|';
copy Stzevder   from '/var/www/sistemas/planos/Stzevder1.unl'  delimiter '|';
copy Stzevder   from '/var/www/sistemas/planos/Stzevder2.unl'  delimiter '|';
copy Stdevobr   from '/var/www/sistemas/planos/Stdevobr.unl'   delimiter '|';
copy Stmviena   from '/var/www/sistemas/planos/Stmviena.unl'   delimiter '|';
copy Stmclbus   from '/var/www/sistemas/planos/Stmclbus.unl'   delimiter '|';
copy Stplocar   from '/var/www/sistemas/planos/Stplocar.unl'   delimiter '|';
copy Stptesar   from '/var/www/sistemas/planos/Stptesar.unl'   delimiter '|';
copy Stzferir   from '/var/www/sistemas/planos/Stzferir.unl'   delimiter '|';
copy Stzmigrr   from '/var/www/sistemas/planos/Stzmigrr1.unl'  delimiter '|';
copy Stzmigrr   from '/var/www/sistemas/planos/Stzmigrr2.unl'  delimiter '|';
copy Stdmigrr   from '/var/www/sistemas/planos/Stdmigrr.unl'   delimiter '|';
copy Stdgener   from '/var/www/sistemas/planos/Stdgener.unl'   delimiter '|';
copy Stdcoded   from '/var/www/sistemas/planos/Stdcoded.unl'   delimiter '|';
copy Stzdepto   from '/var/www/sistemas/planos/Stzdepto.unl'   delimiter '|';
copy Stzroles   from '/var/www/sistemas/planos/Stzroles.unl'   delimiter '|';
copy Stzmenu    from '/var/www/sistemas/planos/Stzmenu.unl'    delimiter '|';
copy Stzusuar   from '/var/www/sistemas/planos/Stzusuar.unl'   delimiter '|';
copy Stzroleve  from '/var/www/sistemas/planos/Stzroleve.unl'  delimiter '|';
copy Stzrolmenu from '/var/www/sistemas/planos/Stzrolmenu.unl' delimiter '|';
copy Stzuserol  from '/var/www/sistemas/planos/Stzuserol.unl'  delimiter '|';
copy Stzconex   from '/var/www/sistemas/planos/Stzconex.unl'   delimiter '|';
copy Stzhispw   from '/var/www/sistemas/planos/Stzhispw.unl'   delimiter '|';
copy Stzedobd   from '/var/www/sistemas/planos/Stzedobd.unl'   delimiter '|';
copy Stzphpman  from '/var/www/sistemas/planos/Stzphpman.unl'  delimiter '|';
copy Stmcntrl   from '/var/www/sistemas/planos/Stmcntrl.unl'   delimiter '|';
copy Stmctrec   from '/var/www/sistemas/planos/Stmctrec.unl'   delimiter '|';
copy Stmverif   from '/var/www/sistemas/planos/Stmverif.unl'   delimiter '|';
copy Stmaudef   from '/var/www/sistemas/planos/Stmaudef.unl'   delimiter '|';
copy Stmpsovi   from '/var/www/sistemas/planos/Stmpsovi.unl'   delimiter '|';
copy Stzpetit   from '/var/www/sistemas/planos/Stzpetit.unl'   delimiter '|';
copy Wordbusq   from '/var/www/sistemas/planos/Wordbusq.unl'   delimiter '|';
copy Wordtitu   from '/var/www/sistemas/planos/Wordtitu.unl'   delimiter '|';
copy Stmclinr   from '/var/www/sistemas/planos/Stmclinr.unl'   delimiter '|';
copy Stmclnar   from '/var/www/sistemas/planos/Stmclnar.unl'   delimiter '|';
copy stzderec   from '/var/www/sistemas/planos/stzderec1.unl'  delimiter '|';
copy stzderec   from '/var/www/sistemas/planos/stzderec2.unl'  delimiter '|';
copy stdobras   from '/var/www/sistemas/planos/stdobras.unl'   delimiter '|';
copy stzutilr   from '/var/www/sistemas/planos/stzutilr.unl'   delimiter '|';

--Genera el archivo plano que servira de referencia (solicitud-nro_derecho)
--para la segunda parte de la migracion
select nro_derecho,tipo_mp,solicitud
       into temp temporal1 from stzderec order by 1;
copy temporal1 to '/var/www/sistemas/planos/derechomp.unl' with delimiter '|';
select nro_derecho,solicitud
       into temp temporal2 from stdobras order by 1;
copy temporal2 to '/var/www/sistemas/planos/derechoda.unl' with delimiter '|';
-- End Script --

