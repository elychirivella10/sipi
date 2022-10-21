-- Script de Migracion 
-- Baja las tablas de Postgres para Archivos Planos --
-- Parte 1/4

--[ STZPAISR ]
copy Stzpaisr to '/var/www/sistemas/planos/stzpaisr.unl' with delimiter '|';

--[ STDIDIOM ]
copy Stdidiom to '/var/www/sistemas/planos/stdidiom.unl' with delimiter '|';

--[ STZAGENR ]
select agente,nombre,domicilio,profesion,estatus_age,' ' as c1,' ' as c2,' ' as c3 
       into temp temporal1 from Stzagenr order by 1;
update temporal1 set domicilio='*' where domicilio='' or domicilio is null;
update temporal1 set profesion='O' where profesion='' or profesion is null;
copy temporal1 to '/var/www/sistemas/planos/Stzagenr.unl' with delimiter '|';

--[ STZPODER ]
Select poder,titular,fecha_poder,facultad,fecha_poder as fecha into temp temporal0 from Stzpoder 
 where titular>0 and fecha_poder is not null order by 1; 
copy temporal0 to '/var/www/sistemas/planos/Stzpoder.unl' with delimiter '|';

--[ STZPOHAD ]
select poder,poderhabi into temp temporal2 from Stzpohad 
 where poder<>'' and poderhabi>0 and poderhabi in (select agente from stzagenr) and
       poder in (select poder from stzpoder where titular>0 and fecha_poder is not null)
 order by 1;
copy temporal2 to '/var/www/sistemas/planos/Stzpohad.unl' with delimiter '|';

--[ STZSTDER ]
select estatus+1000 as estatus,descripcion,publicable,'M' into temp temporal3 
  from Stmstmar order by 1;
select estatus+2000 as estatus,descripcion,publicable,'P' into temp temporal4 
  from Stpstpar order by 1;
copy temporal3 to '/var/www/sistemas/planos/Stzstder1.unl' with delimiter '|';
copy temporal4 to '/var/www/sistemas/planos/Stzstder2.unl' with delimiter '|';

--[ STDSTOBR ]
copy Stdstobr to '/var/www/sistemas/planos/Stdstobr.unl' with delimiter '|';

--[ STZEVDER ]
select Evento+1000 as evento,Descripcion,Tipo_evento,Inf_adicional,Mensa_automatico,Plazo_ley,
       Tipo_Plazo,Tit_comenta,Tit_nro_doc,Aplica,'M' into temp temporal5 
  from Stmevmar order by 1;
select Evento+2000 as evento,Descripcion,Tipo_evento,Inf_adicional,Mensa_automatico,Plazo_ley,
       Tipo_Plazo,Tit_comenta,Tit_nro_doc,Aplica,'P' into temp temporal6 
  from Stpevpar order by 1;
update temporal5 set tipo_plazo='N' where tipo_plazo is null or tipo_plazo='' or tipo_plazo='V';
update temporal5 set inf_adicional='N' where inf_adicional is null or inf_adicional='';
copy temporal5 to '/var/www/sistemas/planos/Stzevder1.unl' with delimiter '|';
update temporal6 set tipo_plazo='N' where tipo_plazo is null or tipo_plazo='' or tipo_plazo='V';
update temporal6 set inf_adicional='N' where inf_adicional is null or inf_adicional='';
copy temporal6 to '/var/www/sistemas/planos/Stzevder2.unl' with delimiter '|';

--[ STDEVOBR ]
copy Stdevobr to '/var/www/sistemas/planos/Stdevobr.unl' with delimiter '|';

--[ STMVIENA ]
copy Stmviena to '/var/www/sistemas/planos/Stmviena.unl' with delimiter '|';

--[ STMCLBUS ]
copy Stmclbus to '/var/www/sistemas/planos/Stmclbus.unl' with delimiter '|';

--[ STPLOCAR ]
select subclase,descripcion into temp temporal7 from Stplocar;
copy temporal7 to '/var/www/sistemas/planos/Stplocar.unl' with delimiter '|';

--[ STPTESAR ]
copy Stptesar to '/var/www/sistemas/planos/Stptesar.unl' with delimiter '|';

--[ STZFERIR ]
select fecha_fer into temp temporal8 from Stzferir;
copy temporal8 to '/var/www/sistemas/planos/Stzferir.unl' with delimiter '|';

--[ STZMIGRR ]
select distinct on (evento,estatus_ini,estatus_fin)
       Evento+1000 as ev1,Estatus_ini+1000 as ev2,Estatus_fin+1000 as ev3,'M' 
       into temp temporal9 from Stmmigrr;
select distinct on (evento,estatus_ini,estatus_fin)
       Evento+2000 as ev1,Estatus_ini+2000 as ev2,Estatus_fin+2000 as ev3,'P' 
       into temp temporal10 from Stpmigrr;
copy temporal9 to '/var/www/sistemas/planos/Stzmigrr1.unl' with delimiter '|';
copy temporal10 to '/var/www/sistemas/planos/Stzmigrr2.unl' with delimiter '|';

--[ STDMIGRR ]
copy Stdmigrr to '/var/www/sistemas/planos/Stdmigrr.unl' with delimiter '|';

--[ STDGENER ]
copy Stdgener to '/var/www/sistemas/planos/Stdgener.unl' with delimiter '|';

--[ STDCODED ]
copy Stdcoded to '/var/www/sistemas/planos/Stdcoded.unl' with delimiter '|';

--[ STZDEPTO ]
copy Stzdepto to '/var/www/sistemas/planos/Stzdepto.unl' with delimiter '|';

--[ STZROLES ]
select * into temp temporal50 from Stzroles;
update temporal50 set hora_crea='00:00:00 AM' where hora_crea is null;
copy temporal50 to '/var/www/sistemas/planos/Stzroles.unl' with delimiter '|';

--[ STZMENU ]
select Codmenu,Nombre,Nivel,Nomenclatura,Estado,Fecha_elim,' '
       into temp temporal11 from Stzmenu;
copy temporal11 to '/var/www/sistemas/planos/Stzmenu.unl' with delimiter '|';

--[ STZUSUAR ]
copy Stzusuar to '/var/www/sistemas/planos/Stzusuar.unl' with delimiter '|';

--[ STZROLEVE ]
select * into temp temporal51 from Stzroleve
 where role in (select role from stzroles);
update temporal51 set hora_asig='00:00:00 AM' where hora_asig is null;
update temporal51 set evento=evento+1000 where tip_derecho='M';
update temporal51 set evento=evento+2000 where tip_derecho='P';
copy temporal51 to '/var/www/sistemas/planos/Stzroleve.unl' with delimiter '|';

--[ STZROLES ]
select Role,Codmenu,Fecha_asig,Estado,Fecha_elim,' '
       into temp temporal12 from Stzrolmenu
 where role in (select role from stzroles) and
       codmenu in (select codmenu from stzmenu);
copy temporal12 to '/var/www/sistemas/planos/Stzrolmenu.unl' with delimiter '|';

--[ STZUSEROL ]
select * into temp temporal52 from Stzuserol
 where role in (select role from stzroles) and
       usuario in (select usuario from stzusuar);
update temporal52 set hora_asig='00:00:00 AM' where hora_asig is null;
copy temporal52 to '/var/www/sistemas/planos/Stzuserol.unl' with delimiter '|';

--[ STZCONEX ]
copy Stzconex to '/var/www/sistemas/planos/Stzconex.unl' with delimiter '|';

--[ STZHISPW ]
copy Stzhispw to '/var/www/sistemas/planos/Stzhispw.unl' with delimiter '|';

--[ STZEDOBD ]
copy Stzedobd to '/var/www/sistemas/planos/Stzedobd.unl' with delimiter '|';

--[ STZPHPMAN ]
copy Stzphpman to '/var/www/sistemas/planos/Stzphpman.unl' with delimiter '|';

--[ STMCNTRL ]
copy Stmcntrl to '/var/www/sistemas/planos/Stmcntrl.unl' with delimiter '|';

--[ STMCTREC ]
select Recibo,Clase,Estatus,Usuario,Fechatrans,Hora
       into temp temporal13 from Stmctrec;
copy temporal13 to '/var/www/sistemas/planos/Stmctrec.unl' with delimiter '|';

--[ STMVERIF ]
select Fecha_proc,Hora,Usuario,Solicitud,Modificado
       into temp temporal14 from Stmverif;
copy temporal14 to '/var/www/sistemas/planos/Stmverif.unl' with delimiter '|';

--[ STMAUDEF ]
copy Stmaudef to '/var/www/sistemas/planos/Stmaudef.unl' with delimiter '|';

--[ STMPSOVI ]
copy Stmpsovi to '/var/www/sistemas/planos/Stmpsovi.unl' with delimiter '|';

--[ STZPETIT ]
copy Stzpetit to '/var/www/sistemas/planos/Stzpetit.unl' with delimiter '|';

--[ WORDBUSQ ]
copy Wordbusq to '/var/www/sistemas/planos/Wordbusq.unl' with delimiter '|';

--[ WORDTITU ]
copy Wordtitu to '/var/www/sistemas/planos/Wordtitu.unl' with delimiter '|';

--[ STMCLINR ]
copy Stmclinr to '/var/www/sistemas/planos/Stmclinr.unl' with delimiter '|';

--[ STMCLNAR ]
select clase_nacion,descripcion into temp temporal15 from Stmclnar;
copy temporal15 to '/var/www/sistemas/planos/Stmclnar.unl' with delimiter '|';

--[ STZDEREC ]
--create sequence secuencia;
select setval('secuencia',1);
select nextval('secuencia')-1 as derecho,tipo_marca,solicitud,fecha_solic,'M',
       Nombre,Estatus+1000 as estat,Registro,Fecha_regis,Fecha_publi,Fecha_venc,
       Pais_resid,Poder,Tramitante,agente
       into temp temporal61 from stmmarce order by solicitud;
select nextval('secuencia')-1 as derecho,tipo_paten,solicitud,fecha_solic,'P',
       Nombre,Estatus+2000 as estat,Registro,Fecha_regis,Fecha_publi,Fecha_venc,
       Pais_resid,Poder,Tramitante,agente
       into temp temporal62 from stppatee order by solicitud;
update temporal61 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal61 to '/var/www/sistemas/planos/stzderec1.unl' with delimiter '|';
update temporal62 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal62 to '/var/www/sistemas/planos/stzderec2.unl' with delimiter '|';

--[ STDOBRAS ]
select nextval('secuencia')-1 as derecho,Solicitud,Fecha_solic,Tipo_obra,Titulo_obra,
       Descrip_obra,Cod_idioma,Traduccion,Clase,Origen,Forma,Estatus,Registro,Fecha_regis,
       Anno_realiza,Anno_1publica,Pais_origen,N_ejemplares,Tipo_soporte,Observacion,
       N_hojas_adic,Datos_ampli,Datos_adicio,Obradrivada,Nplanilla
       into temp temporal63 from stdobras order by solicitud;
copy temporal63 to '/var/www/sistemas/planos/stdobras.unl' with delimiter '|';

--[ STZUTILR ]
copy stzutilr to '/var/www/sistemas/planos/stzutilr.unl' with delimiter '|';

-- Fin script --
