-- Script de Migracion 
-- Baja las tablas de Postgres para Archivos Planos --
-- Parte 4/4

copy Stmottid to '/var/www/sistemas/planos/stmottid.unl' with delimiter '|';
copy Stmdistd to '/var/www/sistemas/planos/stmdistd.unl' with delimiter '|';
copy Stpottid to '/var/www/sistemas/planos/stpottid.unl' with delimiter '|';
copy Stpresud to '/var/www/sistemas/planos/stpresud.unl' with delimiter '|';

-- Fin script --
