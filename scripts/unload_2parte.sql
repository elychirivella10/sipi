-- Script de Migracion 
-- Baja las tablas de Postgres para Archivos Planos --
-- Parte 2/4

-- Llena las tablas de referencia para la relacion (nro_derecho-solicitud) --
-- Las tablas deben ser creadas previamente en la base de datos origen     --
-- DERECHOMP -> nro_derecho: Integer, tipo: ch(1), solicitud: Ch(11)       --
-- DERECHODA -> nro_derecho: Integer, solicitud: Ch(6)                     --
-- OJO  <<Eliminar ambas tablas si ya existen en la estructura vieja>> OJO --
--create table derechomp (nro_derecho integer, tipo character(2), solicitud character(11) );
--create table derechoda (nro_derecho integer, solicitud character(6) );
delete from derechomp;
delete from derechoda;

copy derechomp from '/var/www/sistemas/planos/derechomp.unl' delimiter '|';
copy derechoda from '/var/www/sistemas/planos/derechoda.unl' delimiter '|';

--[ STMMARCE ]
select nro_derecho,clase,ind_claseni,modalidad,' ' as distingue
  into temp temporal from derechomp a, stmmarce b
 where a.solicitud=b.solicitud and tipo='M' order by 1 ;
copy temporal to '/var/www/sistemas/planos/stmmarce.unl' with delimiter '|';

--[ STPPATEE ]
select nro_derecho,edicion,anualidad,' ' as resumen
  into temp temporal0 from derechomp a, stppatee b
 where a.solicitud=b.solicitud and tipo='P' order by 1 ;
update temporal0 set edicion=0 where edicion is null;
update temporal0 set anualidad=0 where anualidad is null;
copy temporal0 to '/var/www/sistemas/planos/stppatee.unl' with delimiter '|';

--[ STDREPRE ]
select nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba
  into temp temporal1 from derechoda a, stdrepre b
 where a.solicitud=b.solicitud order by 1;
copy temporal1 to '/var/www/sistemas/planos/stdrepre.unl' with delimiter '|';

--[ Stdescen ]
select Nro_derecho,Tipoobraesc,Otraobraesc,Argumento,Musica,Movimiento
  into temp temporal2 from derechoda a, stdescen b
 where a.solicitud=b.solicitud order by 1;
copy temporal2 to '/var/www/sistemas/planos/stdescen.unl' with delimiter '|';

--[ stdartar ]
select Nro_derecho,Artista
  into temp temporal4 from derechoda a, stdartar b
 where a.solicitud=b.solicitud order by 1;
copy temporal4 to '/var/www/sistemas/planos/stdartar.unl' with delimiter '|';

--[ Stdfijin ]
select Nro_derecho,Cod_obfinej,Titulo_obfija,Nombre_autor,Arreglista,Interprete,Tipo_obfija
  into temp temporal9 from derechoda a, stdfijin b
 where a.solicitud=b.solicitud order by 1;
copy temporal9 to '/var/www/sistemas/planos/stdfijin.unl' with delimiter '|';

--[ Stdactos ]
select Nro_derecho,Partes,Naturaleza,Objeto,Derechos,Tipo_cuantia,Espec_cuantia,Duracion,
  Domicilio,Fecha_firma,Datosregistro
  into temp temporal10 from derechoda a, stdactos b
 where a.solicitud=b.solicitud order by 1;
copy temporal10 to '/var/www/sistemas/planos/stdactos.unl' with delimiter '|';

--[ Stdtrans ]
select Nro_derecho,Transferencia
  into temp temporal11 from derechoda a, stdtrans b
 where a.solicitud=b.solicitud order by 1;
copy temporal11 to '/var/www/sistemas/planos/stdtrans.unl' with delimiter '|';

--[ Stdvisua ]
select Nro_derecho,Cod_genero,Exhibida,Ubica_exhibi,Publicada,Datos_public,Edificada,Ubica_edifica
  into temp temporal12 from derechoda a, stdvisua b
 where a.solicitud=b.solicitud order by 1;
copy temporal12 to '/var/www/sistemas/planos/stdvisua.unl' with delimiter '|';

--[ Stdmusic ]
select Nro_derecho,Cod_genero,Letra,Ritmo,Dat_produ_fon,Fin_comercial,Anno_fija_sono
  into temp temporal13 from derechoda a, stdmusic b
 where a.solicitud=b.solicitud order by 1;
copy temporal13 to '/var/www/sistemas/planos/stdmusic.unl' with delimiter '|';

--[ Stdfijac ]
select Nro_derecho,Anno_fijacion,Tipo_fijacion,Ficha_datos
  into temp temporal14 from derechoda a, stdfijac b
 where a.solicitud=b.solicitud order by 1;
copy temporal14 to '/var/www/sistemas/planos/stdfijac.unl' with delimiter '|';

--[ Stdderiv ]
select Nro_derecho,Titulo_original,Datos_autor,Tipo_obra_deri,Anno_pub_orig,N_versiones_aut
  into temp temporal16 from derechoda a, stdderiv b
 where a.solicitud=b.solicitud order by 1;
copy temporal16 to '/var/www/sistemas/planos/stdderiv.unl' with delimiter '|';

-- MARCAS --

--[ Stmlemad ]
select Nro_derecho,solicitud_aso,registro_aso
  into temp temporal17 from derechomp a, stmlemad b
 where a.solicitud=b.solicitud and tipo='M' order by 1;
copy temporal17 to '/var/www/sistemas/planos/stmlemad.unl' with delimiter '|';

--[ Stmlogos ]
select Nro_derecho,descripcion
  into temp temporal18 from derechomp a, stmlogos b
 where a.solicitud=b.solicitud and tipo='M' order by 1;
copy temporal18 to '/var/www/sistemas/planos/stmlogos.unl' with delimiter '|';

--[ Stmliaor ]
select distinct on (b.solicitud,b.articulo) Nro_derecho,articulo,literal,reg_base
  into temp temporal19 from derechomp a, stmliaor b
 where a.solicitud=b.solicitud and tipo='M' and articulo is not null;
copy temporal19 to '/var/www/sistemas/planos/stmliaor.unl' with delimiter '|';

--[ Stmccvma ]
select distinct on (b.solicitud,b.ccv) Nro_derecho,ccv
  into temp temporal20 from derechomp a, stmccvma b
 where a.solicitud=b.solicitud and tipo='M' and ccv is not null and
       b.ccv in (select ccv from stmviena);
copy temporal20 to '/var/www/sistemas/planos/stmccvma.unl' with delimiter '|';

-- PATENTES --
--[ Stplocad ]
select distinct on (b.solicitud,b.clasi_locarno) Nro_derecho,clasi_locarno
  into temp temporal21 from derechomp a, stplocad b
 where a.solicitud=b.solicitud and tipo='P' and clasi_locarno is not null and
       b.clasi_locarno in (select subclase from stplocar);
copy temporal21 to '/var/www/sistemas/planos/stplocad.unl' with delimiter '|';

--[ Stppacld ]
select distinct on (b.solicitud,b.apuntador) Nro_derecho,apuntador
  into temp temporal22 from derechomp a, stppacld b
 where a.solicitud=b.solicitud and tipo='P' and b.apuntador is not null and
       apuntador in (select apuntador from stptesar);
copy temporal22 to '/var/www/sistemas/planos/stppacld.unl' with delimiter '|';

--[ Stpclsfd ]
select distinct on (b.solicitud,b.clasificacion) Nro_derecho,clasificacion,tipo_clas
  into temp temporal23 from derechomp a, stpclsfd b
 where a.solicitud=b.solicitud and tipo='P' and tipo_clas in ('P','S') and
       clasificacion is not null;
copy temporal23 to '/var/www/sistemas/planos/stpclsfd.unl' with delimiter '|';

-- COMUNES --
--[ Stzliced ]
select Nro_derecho,licencia,nombre_licen,fecha_licen,fecha_venc
  into temp temporal24 from derechomp a, stmliced b
 where a.solicitud=b.solicitud and tipo='M' order by 1;
copy temporal24 to '/var/www/sistemas/planos/stzliced1.unl' with delimiter '|';
select Nro_derecho,licencia,nombre_licen,fecha_licen,fecha_venc
  into temp temporal25 from derechomp a, stpliced b
 where a.solicitud=b.solicitud and tipo='P' order by 1;
copy temporal25 to '/var/www/sistemas/planos/stzliced2.unl' with delimiter '|';

--[ Stzpriod ]
select distinct on (b.solicitud,b.prioridad) Nro_derecho,prioridad,pais_priori,fecha_priori
  into temp temporal26 from derechomp a, stmpriod b
 where a.solicitud=b.solicitud and tipo='M' and prioridad is not null and
       pais_priori is not null and fecha_priori is not null;
copy temporal26 to '/var/www/sistemas/planos/stzpriod1.unl' with delimiter '|';
select distinct on (b.solicitud,b.prioridad) Nro_derecho,prioridad,pais_priori,fecha_priori
  into temp temporal27 from derechomp a, stppriod b
 where a.solicitud=b.solicitud and tipo='P' and prioridad is not null and
       pais_priori is not null and fecha_priori is not null;
copy temporal27 to '/var/www/sistemas/planos/stzpriod2.unl' with delimiter '|';

--[ Stztmpbo ]
select distinct on (nro_derecho,boletin,estatus) 
  Nro_derecho,b.solicitud,boletin,estatus,b.tipo,nanota,usuario,fecha_carga,hora_carga
  into temp temporal28 from derechomp a, stztmpbo b
 where a.solicitud=b.solicitud and a.tipo=b.tipo order by 1;
update temporal28 set estatus=estatus+1000 where tipo='M';
update temporal28 set estatus=estatus+2000 where tipo='P';
update temporal28 set nanota=0 where nanota is null;
copy temporal28 to '/var/www/sistemas/planos/stztmpbo.unl' with delimiter '|';

--[ Stzantma ]
select distinct on (b.solicitud,b.nanota) Nro_derecho,Nanota,b.Solicitud,b.Tipo,
       Evento+1000 as evento,Cod_tit_1,Nom_tit_1,Cod_tit_2,Nom_tit_2,Domicilio,Pais,Tramitante,
       Vencimiento,Verificado,Inf_adicional,Agente
  into temp temporal29 from derechomp a, stzantma b
 where a.solicitud=b.solicitud and a.tipo=b.tipo;
update temporal29 set nanota=0 where nanota is null;
update temporal29 set cod_tit_1=0 where cod_tit_1 is null;
update temporal29 set cod_tit_2=0 where cod_tit_2 is null;
copy temporal29 to '/var/www/sistemas/planos/stzantma.unl' with delimiter '|';

--[ Stzautod ]
Select distinct on (b.solicitud,b.agente) Nro_derecho,agente
  into temp temporal30 from derechomp a, stmautod b
 where a.solicitud=b.solicitud and a.tipo='M' and agente>0 and 
       agente is not null and agente in (select agente from stzagenr);
copy temporal30 to '/var/www/sistemas/planos/stzautod1.unl' with delimiter '|';
Select distinct on (b.solicitud,b.agente) Nro_derecho,agente
  into temp temporal31 from derechomp a, stpautod b
 where a.solicitud=b.solicitud and a.tipo='P' and agente>0 and 
       agente is not null and agente in (select agente from stzagenr);
copy temporal31 to '/var/www/sistemas/planos/stzautod2.unl' with delimiter '|';

--[ Stdevtrd ]
Select Nro_derecho,Evento,Fecha_event,Secuencial,Estat_ant,Fecha_venc,Documento,
       Fecha_trans,Usuario,Desc_evento,Comentario,Hora
  into temp temporal32 from derechoda a, stdevtrd b
 where a.solicitud=b.solicitud order by 1;
copy temporal32 to '/var/www/sistemas/planos/stdevtrd.unl' with delimiter '|';

--[ Stdcaded ]
Select distinct on (b.solicitud,b.cod_causa) nro_derecho,cod_causa,'01-01-01' as fecha_dev
  into temp temporal33 from derechoda a, stdcaded b
 where a.solicitud=b.solicitud;
copy temporal33 to '/var/www/sistemas/planos/stdcaded.unl' with delimiter '|';

--[ Stdotrde ]
Select nro_derecho,otros
  into temp temporal34 from derechoda a, stdotrde b
 where a.solicitud=b.solicitud order by 1;
copy temporal34 to '/var/www/sistemas/planos/stdotrde.unl' with delimiter '|';

--[ Stzsolic ]
--  cambio del 11/03/2009  (se quito domicilio y pais_resid) ---
--  select distinct on (titular) titular,' ' as identificacion,nombre,' ' as domicilio,
--         pais_resid,' ' as indole,' ' as telefono1,' ' as telefono2,' ' as fax,' ' as email
  select distinct on (titular) titular,' ' as identificacion,nombre,
         ' ' as indole,' ' as telefono1,' ' as telefono2,' ' as fax,' ' as email
    into temp temporal35 from stztitur order by 1;
  update temporal35 set nombre='*' where nombre is null or nombre=' ';
--  update temporal35 set pais_resid='SP' where pais_resid is null or pais_resid='  ' or
--         pais_resid not in (select pais from stzpaisr);
  copy temporal35 to '/var/www/sistemas/planos/stzsolic1.unl' with delimiter '|';
  -- DNDA --
  select setval('secuencia',777777);
  select nextval('secuencia')-1 as titular,cedula,nombre_p,domicilio_p,
         pais_p,' ' as indole,telefono_p,' ' as telefono2,fax_p,email
    into temp temporal36 from stddaper order by 1;
  select titular,cedula,nombre_p,indole,telefono_p,telefono2,fax_p,email
    into temp temporal36ng from temporal36;
  copy temporal36ng to '/var/www/sistemas/planos/stzsolic2.unl' with delimiter '|';
  --
  select nextval('secuencia')-1 as titular,rif,razon_social,domicilio_j,
         pais_j,' ' as indole,telefono_j,' ' as telefono2,fax_j,email
    into temp temporal37 from stddajur order by 1;
  select titular,rif,razon_social,indole,telefono_j,telefono2,fax_j,email
    into temp temporal37ng from temporal37;
  copy temporal37ng to '/var/www/sistemas/planos/stzsolic3.unl' with delimiter '|';
  -- Titulares --
  select titular,cedula,domicilio_p,pais_p into temp temporal36a from temporal36;
  copy temporal36a to '/var/www/sistemas/planos/titulares1.unl' with delimiter '|';
  select titular,rif,domicilio_j,pais_j    into temp temporal37a from temporal37;
  copy temporal37a to '/var/www/sistemas/planos/titulares2.unl' with delimiter '|';

--[ STZCODED ]
copy Stzcoded to '/var/www/sistemas/planos/stzcoded.unl' with delimiter '|';

--[ STZCADED ]
select distinct on (b.solicitud,Cod_causa,Derecho,Grupo,Tipo_Dev) 
       Nro_derecho,cod_causa,derecho,grupo,tipo_dev,'01-01-01' as fecha_dev
  into temp temporal40 from derechomp a, stzcaded b
 where a.solicitud=b.solicitud;
copy temporal40 to '/var/www/sistemas/planos/stzcaded.unl' with delimiter '|';

--[ STZOTRDE ]
select distinct on (b.solicitud,Derecho,Grupo,Tipo_Dev) 
       Nro_derecho,otros,derecho,grupo,tipo_dev,'01-01-01' as fecha_dev
  into temp temporal41 from derechomp a, stzotrde b
 where a.solicitud=b.solicitud;
copy temporal41 to '/var/www/sistemas/planos/stzotrde.unl' with delimiter '|';

--[ STPINVED ]
select nro_derecho,nombre_inv,nacionalidad 
  into temp temporal42 from derechomp a, stpinved b
 where a.solicitud=b.solicitud and a.tipo='P' and nombre_inv is not null;
update temporal42 set nacionalidad='SP' where nacionalidad is null 
       or nacionalidad not in (select pais from stzpaisr);
copy temporal42 to '/var/www/sistemas/planos/stpinved.unl' with delimiter '|';

--[ STMOFDEV ]
select orden,nro_derecho,documento,estatus 
  into temp temporal43 from derechomp a, stmofdev b
 where a.solicitud=b.solicitud and a.tipo='M';
copy temporal43 to '/var/www/sistemas/planos/stmofdev.unl' with delimiter '|';

--[ STMTMPAM ]
select nro_derecho,registro,nombre,clase,ind_claseni,evento+1000,fecha_event,
       documento,comentario,usuario 
  into temp temporal44 from derechomp a, stmtmpam b
 where a.solicitud=b.solicitud and a.tipo='M';
copy temporal44 to '/var/www/sistemas/planos/stmtmpam.unl' with delimiter '|';

--[ STPEQUIV ]
select nro_derecho,equivalente 
  into temp temporal45 from derechomp a, stpequiv b
 where a.solicitud=b.solicitud and a.tipo='P';
copy temporal45 to '/var/www/sistemas/planos/stpequiv.unl' with delimiter '|';

--[ STMRECLA ]
select nro_derecho,clase_nac,productos,verificado
  into temp temporal46 from derechomp a, stmrecla b
 where a.solicitud=b.solicitud and a.tipo='M';
copy temporal46 to '/var/www/sistemas/planos/stmrecla.unl' with delimiter '|';

--[ STZMARGI ]
select nro_derecho,b.solicitud,documento,nro_docum,vencimiento,tramitante,agente,codtit1,
       titular1,codtit2,titular2,domicilio_ant,domicilio,pais,tipo_tramite,publicado,boletin,
       tipo_derecho,usuario,fecha_trans,hora,verificado 
  into temp temporal47 from derechomp a, stzmargi b
 where a.solicitud=b.solicitud and a.tipo=b.tipo_derecho;
copy temporal47 to '/var/www/sistemas/planos/stzmargi.unl' with delimiter '|';

--[ STMTMPEF]
copy Stmtmpef to '/var/www/sistemas/planos/stmtmpef.unl' with delimiter '|';

-- End Script --








