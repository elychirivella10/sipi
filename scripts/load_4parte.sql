-- Script de Migracion 
-- Monta los archivos planos en las tablas de Postgres
-- Parte: 4/4

copy Stmottid   from '/var/www/sistemas/planos/stmottid.unl'   delimiter '|';
copy Stmdistd   from '/var/www/sistemas/planos/stmdistd.unl'   delimiter '|';
copy Stpottid   from '/var/www/sistemas/planos/stpottid.unl'   delimiter '|';
copy Stpresud   from '/var/www/sistemas/planos/stpresud.unl'   delimiter '|';

-- STMDISTD <-> STMMARCE  (distingue)
select distinct on (a.solicitud) b.nro_derecho,a.distingue 
  into temp temporal60 from stmdistd a, stzderec b
 where a.solicitud=b.solicitud and b.tipo_mp='M';

select a.nro_derecho,a.clase,a.ind_claseni,a.modalidad,b.distingue
  into temp temporal61 from stmmarce a, temporal60 b
 where a.nro_derecho=b.nro_derecho;
copy temporal61 to   '/var/www/sistemas/planos/stmmarce2.unl' with delimiter '|';

delete from stmmarce2;
copy stmmarce2  from '/var/www/sistemas/planos/stmmarce2.unl' delimiter '|';
delete from stmmarce where nro_derecho in (select nro_derecho from stmmarce2);
copy stmmarce  from '/var/www/sistemas/planos/stmmarce2.unl' delimiter '|';

-- STPRESUD <-> STPPATEE  (resumen)
select distinct on (a.solicitud) b.nro_derecho,a.resumen 
  into temp temporal62 from stpresud a, stzderec b
 where a.solicitud=b.solicitud and b.tipo_mp='P';

select a.nro_derecho,a.edicion,a.anualidad,b.resumen
  into temp temporal63 from stppatee a, temporal62 b
 where a.nro_derecho=b.nro_derecho;
copy temporal63 to   '/var/www/sistemas/planos/stppatee2.unl' with delimiter '|';

delete from stppatee2;
copy stppatee2  from '/var/www/sistemas/planos/stppatee2.unl' delimiter '|';
delete from stppatee where nro_derecho in (select nro_derecho from stppatee2);
copy stppatee  from '/var/www/sistemas/planos/stppatee2.unl' delimiter '|';

-- STZSOLIC <-> STMOTTID/STPOTTID  (domicilio)
select distinct on (a.solicitud) b.nro_derecho,a.resumen 
  into temp temporal64 from stpresud a, stzderec b
 where a.solicitud=b.solicitud and b.tipo_mp='P';

select a.nro_derecho,a.edicion,a.anualidad,b.resumen
  into temp temporal65 from stppatee a, temporal64 b
 where a.nro_derecho=b.nro_derecho;
copy temporal65 to   '/var/www/sistemas/planos/stppatee2.unl' with delimiter '|';

delete from stppatee2;
copy stppatee2  from '/var/www/sistemas/planos/stppatee2.unl' delimiter '|';
delete from stppatee where nro_derecho in (select nro_derecho from stppatee2);
copy stppatee  from '/var/www/sistemas/planos/stppatee2.unl' delimiter '|';

-- Eliminar tablas utilizadas solo para la migración
drop table stmottid;
drop table stmdistd;
drop table stpottid;
drop table stpresud;
drop table stmmarce2;
drop table stppatee2;

-- Actualizar valor inicial de las secuencias
select setval('stzsolic_titular_seq',(select max(titular) from stzsolic));
select setval('stzevtrd_secuencial_seq',(select max(secuencial) from stzevtrd));
--
select setval('stzsystem_nro_derecho_seq',(select max(nro_derecho) from stdobras));
select setval('stzsystem_nproducto_seq',(select int8(substr(max(registro),2,6))-1 
  from stzderec where substr(registro,1,1)='P'));
select setval('stzsystem_nservicios_seq',(select int8(substr(max(registro),2,6))-1 
  from stzderec where substr(registro,1,1)='S'));
select setval('stzsystem_nlemas_seq',(select int8(substr(max(registro),2,6))-1 
  from stzderec where substr(registro,1,1)='L'));
select setval('stzsystem_nnombres_seq',(select int8(substr(max(registro),2,6))-1 
  from stzderec where substr(registro,1,1)='N'));
insert into stzsystem (secuencial) values (1);

-- End Script --
