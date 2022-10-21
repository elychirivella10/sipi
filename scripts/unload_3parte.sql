-- Script de Migracion 
-- Baja las tablas de Postgres para Archivos Planos --
-- Parte 3/4

-- Llena la tabla de referencia para la relacion (titular-rif-cedula)   --
-- La tabla debe ser creada previamente en la base de datos origen      --
-- TITULARES -> titular: Integer, documento: ch(10), domicilio ch(200), --
--              pais_resid ch(2)                                        --
-- OJO  <<Eliminar la tabla si ya existen en la estructura vieja>> OJO  --
--create table titulares (titular integer, documento character(10), 
--                        domicilio character(200), pais_resid character(2) );
delete from titulares;

copy titulares from '/var/www/sistemas/planos/titulares1.unl' delimiter '|';
copy titulares from '/var/www/sistemas/planos/titulares2.unl' delimiter '|';

--[ Stzevtrd ]
--create sequence secuencia_evtrd;
select setval('secuencia_evtrd',1);
Select Nro_derecho,Evento+1000 as evento,Fecha_event,nextval('secuencia_evtrd')-1 as secuencial,
       Estat_ant+1000 as estat_ant,Fecha_venc,Documento,Fecha_trans,
       Usuario,Desc_evento,Comentario,Hora
  into temp temporal1 from derechomp a, stmevtrd b
 where a.solicitud=b.solicitud and a.tipo='M' and 
       evento is not null and desc_evento is not null and
       evento in (select evento from stmevmar);
update temporal1 set hora='00:00:00 AM' where hora is null;
update temporal1 set estat_ant=1000 where evento=1900;
copy temporal1 to '/var/www/sistemas/planos/stzevtrd1.unl' with delimiter '|';
Select Nro_derecho,Evento+2000 as evento,Fecha_event,nextval('secuencia_evtrd')-1 as secuencial,
       Estat_ant+2000 as estat_ant,Fecha_venc,Documento,Fecha_trans,
       Usuario,Desc_evento,Comentario,Hora
  into temp temporal2 from derechomp a, stpevtrd b
 where a.solicitud=b.solicitud and a.tipo='P' and
       evento is not null and desc_evento is not null and
       evento in (select evento from stpevpar);
update temporal2 set hora='00:00:00 AM' where hora is null;
copy temporal2 to '/var/www/sistemas/planos/stzevtrd2.unl' with delimiter '|';

--[ Stzdaper ]
select titular,fecha_nacim,fecha_defun,estado_civil,profesion,seudonimo
  into temp temporal6 from titulares a, stddaper b
 where a.documento=b.cedula order by 1;
copy temporal6 to '/var/www/sistemas/planos/stzdaper.unl' with delimiter '|';

--[ Stzdajur ]
select titular,datos_registro,cedula_repre
  into temp temporal7 from titulares a, stddajur b 
 where a.documento=b.rif order by 1;
copy temporal7 to '/var/www/sistemas/planos/stzdajur.unl' with delimiter '|';

--[ Stdedici ]
select Nro_derecho,N_edicion,Anno_publica,N_ejemplares,Caracteristicas,Editor_impres,Doc_edimpres,
       titular,c.domicilio,c.pais_resid
  into temp temporal7_1 from derechoda a, stdedici b, titulares c
 where a.solicitud=b.solicitud and
       b.doc_edimpres=c.documento order by 1;
update temporal7_1 set domicilio=' ' where domicilio is null;
update temporal7_1 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal7_1 to '/var/www/sistemas/planos/stdedici.unl' with delimiter '|';

--[ Stdobart ]
select Nro_derecho,Doc_artista,Titular,c.domicilio,c.pais_resid
  into temp temporal21 from derechoda a, stdobart b, titulares c
 where a.solicitud=b.solicitud and
       b.doc_artista=c.documento;
update temporal21 set domicilio=' ' where domicilio is null;
update temporal21 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal21 to '/var/www/sistemas/planos/stdobart.unl' with delimiter '|';

--[ Stdobpro ]
select Nro_derecho,Doc_productor,Titular,c.domicilio,c.pais_resid
  into temp temporal22 from derechoda a, stdobpro b, titulares c
 where a.solicitud=b.solicitud and
       b.doc_productor=c.documento;
update temporal22 set domicilio=' ' where domicilio is null;
update temporal22 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal22 to '/var/www/sistemas/planos/stdobpro.unl' with delimiter '|';

--[ Stdobaut ]
select Nro_derecho,Doc_autor,Tipo_autor,Titular,c.domicilio,c.pais_resid
  into temp temporal23 from derechoda a, stdobaut b, titulares c
 where a.solicitud=b.solicitud and
       b.doc_autor=c.documento;
update temporal23 set domicilio=' ' where domicilio is null;
update temporal23 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal23 to '/var/www/sistemas/planos/stdobaut.unl' with delimiter '|';

--[ Stdobsol ]
select Nro_derecho,Caracter,Otro_caracter,Prueba_repres,Titular,
       c.domicilio,c.pais_resid
  into temp temporal24 from derechoda a, stdobsol b, titulares c
 where a.solicitud=b.solicitud and
       b.doc_solicita=c.documento;
update temporal24 set domicilio=' ' where domicilio is null;
update temporal24 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal24 to '/var/www/sistemas/planos/stdobsol.unl' with delimiter '|';

--[ Stdobtit ]
select Nro_derecho,Doc_titular,Titulo_presun,Doc_transfer,Titular,
       c.domicilio,c.pais_resid
  into temp temporal25 from derechoda a, stdobtit b, titulares c
 where a.solicitud=b.solicitud and
       b.doc_titular=c.documento;
update temporal25 set domicilio=' ' where domicilio is null;
update temporal25 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal25 to '/var/www/sistemas/planos/stdobtit.unl' with delimiter '|';

--[ Stdgrupo ]
select Nro_derecho,Nombre_grupo,Tipo_agrupa,Doc_director,titular,
       c.domicilio,c.pais_resid
  into temp temporal26 from derechoda a, stdgrupo b, titulares c
 where a.solicitud=b.solicitud and
       b.doc_director=c.documento;
update temporal26 set domicilio=' ' where domicilio is null;
update temporal26 set pais_resid='SP' where pais_resid not in (select pais from stzpaisr);
copy temporal26 to '/var/www/sistemas/planos/stdgrupo.unl' with delimiter '|';

--[ Stzottid ]
select distinct on (b.solicitud,titular) Nro_derecho,titular,nacionalidad,domicilio
  into temp temporal27 from derechomp a, stmottid b
 where a.solicitud=b.solicitud and tipo='M';
update temporal27 set domicilio=' ' where domicilio is null;
update temporal27 set nacionalidad='SP' where nacionalidad not in (select pais from stzpaisr); 
copy temporal27 to '/var/www/sistemas/planos/stzottid1.unl' with delimiter '|';
select distinct on (b.solicitud,titular) Nro_derecho,titular,nacionalidad,domicilio
  into temp temporal28 from derechomp a, stpottid b
 where a.solicitud=b.solicitud and tipo='P';
update temporal28 set nacionalidad='SP' where nacionalidad not in (select pais from stzpaisr); 
copy temporal28 to '/var/www/sistemas/planos/stzottid2.unl' with delimiter '|';

--[ Stzhotid ]
select distinct on (b.solicitud,titular) Nro_derecho,titular,nacionalidad,domicilio
  into temp temporal29 from derechomp a, stmotold b
 where a.solicitud=b.solicitud and tipo='M';
update temporal29 set domicilio=' ' where domicilio is null;
update temporal29 set nacionalidad='SP' where nacionalidad not in (select pais from stzpaisr); 
copy temporal29 to '/var/www/sistemas/planos/stzhotid1.unl' with delimiter '|';
select distinct on (b.solicitud,titular) Nro_derecho,titular,nacionalidad,domicilio
  into temp temporal30 from derechomp a, stpotold b
 where a.solicitud=b.solicitud and tipo='P';
update temporal30 set nacionalidad='SP' where nacionalidad not in (select pais from stzpaisr); 
copy temporal30 to '/var/www/sistemas/planos/stzhotid2.unl' with delimiter '|';

--[ Stzcaded ]
select distinct on (b.solicitud,cod_causa) nro_derecho,1 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev 
  into temp temporal31 from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_01='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,2 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_02='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,3 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_03='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,4 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_04='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,5 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_05='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,6 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_06='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,7 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_07='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,8 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_08='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,9 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_09='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,10 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_10='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,11 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_11='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,12 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_12='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,13 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_13='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,14 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_14='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,15 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_15='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,16 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_16='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,17 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_17='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,18 as cod_causa,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_18='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null);
copy temporal31 to '/var/www/sistemas/planos/stzcaded1.unl' with delimiter '|';

select distinct on (b.solicitud,cod_causa) nro_derecho,1 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev 
  into temp temporal32 from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_01='X' and tipo_dev='2'
union 
select nro_derecho,2 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_02='X' and tipo_dev='2'
union 
select nro_derecho,3 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_03='X' and tipo_dev='2'
union 
select nro_derecho,4 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_04='X' and tipo_dev='2'
union 
select nro_derecho,5 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_05='X' and tipo_dev='2'
union 
select nro_derecho,6 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_06='X' and tipo_dev='2'
union 
select nro_derecho,7 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_07='X' and tipo_dev='2'
union 
select nro_derecho,8 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_08='X' and tipo_dev='2'
union 
select nro_derecho,9 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_09='X' and tipo_dev='2'
union 
select nro_derecho,10 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_10='X' and tipo_dev='2'
union 
select nro_derecho,11 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_11='X' and tipo_dev='2'
union 
select nro_derecho,12 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_12='X' and tipo_dev='2'
union 
select nro_derecho,13 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_13='X' and tipo_dev='2'
union 
select nro_derecho,14 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_14='X' and tipo_dev='2'
union 
select nro_derecho,15 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_15='X' and tipo_dev='2'
union 
select nro_derecho,16 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_16='X' and tipo_dev='2'
union 
select nro_derecho,17 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_17='X' and tipo_dev='2'
union 
select nro_derecho,18 as cod_causa,'M' as derecho,
       'D' as grupo,'D' as tipod,fecha_dev  
  from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and causa_18='X' and tipo_dev='2';
copy temporal32 to '/var/www/sistemas/planos/stzcaded2.unl' with delimiter '|';

select distinct on (b.solicitud,cod_causa) nro_derecho,1 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev 
  into temp temporal33 from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_01='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,2 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_02='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,3 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_03='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,4 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_04='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,5 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_05='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,6 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_06='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,7 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_07='X' and
      (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,8 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_08='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,9 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_09='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,10 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_10='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,11 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_11='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,12 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_12='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,13 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_13='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,14 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_14='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,15 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
 from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_15='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,16 as cod_causa,'P' as derecho,
      'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_16='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,17 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_17='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union 
select nro_derecho,18 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_18='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null)
union
select nro_derecho,19 as cod_causa,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and causa_19='X' and
       (tipo_dev='1' or tipo_dev='' or tipo_dev is null);
copy temporal33 to '/var/www/sistemas/planos/stzcaded3.unl' with delimiter '|';


--[ Stzotrde ]
select distinct on (Nro_derecho,Derecho,Grupo,Tipod,Fecha_Dev) nro_derecho,otros,'M' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  into temp temporal34 from derechomp a, stmcaded b
 where a.solicitud=b.solicitud and tipo='M' and 
       otros<>'' and otros is not null
union
select distinct on (Nro_derecho,Derecho,Grupo,Tipod,Fecha_Dev) nro_derecho,otros,'P' as derecho,
       'M' as grupo,'M' as tipod,fecha_dev  
  from derechomp a, stpcaded b
 where a.solicitud=b.solicitud and tipo='P' and
       otros<>'' and otros is not null;
copy temporal34 to '/var/www/sistemas/planos/stzotrde2.unl' with delimiter '|';

--[ Stzsystem ]
-- Esta tabla se llenara con los valores iniciales al finalizar la migracion --

-- Fin script --
