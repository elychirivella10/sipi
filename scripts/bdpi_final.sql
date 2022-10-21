-- comando pgdump
-- Para respaldar solo la estructura     : pg_dump -sv bdpi -O > bdpi_stru.pgdump
-- Para respaldar solo los datos         : pg_dump -a bdpi > bdpi_data.pgdump
-- Para respaldar todo (estructura+datos): pg_dump bdpi > bdpi.pgdump
--
-- Para restaurar un archivo pg_dump     : cat [bdpi_stru,bdpi_data,bdpi].pgdump | psql bdpi
--
-- ------------------------------------------------------------
-- Tabla Principal de Paises.
-- ------------------------------------------------------------
CREATE TABLE Stzpaisr (
  Pais CHARACTER(2) NOT NULL PRIMARY KEY,
  Nombre CHARACTER VARYING(30) NOT NULL,
  Nacionalidad CHARACTER(30) 
);
-- ------------------------------------------------------------
-- Tabla Principal de Idiomas.
-- ------------------------------------------------------------
CREATE TABLE Stdidiom (
  Cod_idioma CHARACTER(2) NOT NULL PRIMARY KEY,
  Idioma CHARACTER(30) NOT NULL 
);
-- ------------------------------------------------------------
-- Tabla Principal del Solicitante Natural o Juridico.
-- ------------------------------------------------------------
CREATE TABLE Stzsolic (
  Titular SERIAL NOT NULL,
  Identificacion CHARACTER(10) NULL,
  Nombre CHARACTER VARYING(200) NOT NULL,
  Indole CHARACTER(1) NOT NULL CHECK(indole='G' OR indole='C' OR indole='O' OR
                      indole='P' OR indole='N' OR indole=' '),
  Telefono1 CHARACTER(15) NULL,
  Telefono2 CHARACTER(15) NULL,
  Fax CHARACTER(15) NULL,
  Email CHARACTER(30) NULL,
  PRIMARY KEY(Titular)
);
-- ------------------------------------------------------------
-- Detalle de los Solicitantes o Personas Naturales.
-- ------------------------------------------------------------
CREATE TABLE Stzdaper (
  Titular INTEGER NOT NULL,
  Fecha_nacim DATE NULL,
  Fecha_Defun DATE NULL,
  Estado_Civil CHARACTER(1) NOT NULL CHECK(estado_civil='S' OR estado_civil='C' OR estado_civil='D' OR estado_civil='V'),
  Profesion CHARACTER VARYING(40) NULL,
  Seudonimo CHARACTER VARYING(30) NULL,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Detalle de los Solicitantes Juridicos.
-- ------------------------------------------------------------
CREATE TABLE Stzdajur (
  Titular INTEGER NOT NULL,
  Datos_registro CHARACTER VARYING(300) NOT NULL,
  Cedula_repre CHARACTER(10) NOT NULL,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Tabla Principal de los Agentes de la Propiedad Industrial inscrito.
-- ------------------------------------------------------------
CREATE TABLE Stzagenr (
  Agente INTEGER NOT NULL PRIMARY KEY,
  Nombre CHARACTER VARYING(120) NOT NULL,
  Domicilio CHARACTER VARYING(150) NOT NULL,
  Profesion CHARACTER(1) NOT NULL,
  Estatus_age CHARACTER(1) NOT NULL,
  Telefono1 CHARACTER(15) NULL,
  Telefono2 CHARACTER(15) NULL,
  Email CHARACTER VARYING(50) NULL 
);
-- ------------------------------------------------------------
-- Tabla Principal de los Poderes.
-- ------------------------------------------------------------
CREATE TABLE Stzpoder (
  Poder CHARACTER(9) NOT NULL,
  Titular INTEGER NOT NULL,
  Fecha_poder DATE NOT NULL,
  Facultad CHARACTER(1) NOT NULL CHECK(facultad='M' OR facultad='P' OR facultad='A'),
  Fecha_trans DATE NOT NULL,
  CONSTRAINT id_poder PRIMARY KEY(Poder,Titular)
  --FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Detalle de Poderes
-- ------------------------------------------------------------
CREATE TABLE Stzpohad (
  Poder CHARACTER(9) NOT NULL,
  Poderhabi INTEGER NOT NULL,
  --FOREIGN KEY(Poder) REFERENCES Stzpoder(Poder) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Poderhabi) REFERENCES Stzagenr(Agente) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_pohad PRIMARY KEY(Poder,Poderhabi) 
);

-- ------------------------------------------------------------
-- temporal de Poderes
-- ------------------------------------------------------------
CREATE TABLE tmppohad (
  Poder CHARACTER(9) NOT NULL,
  Poderhabi INTEGER NOT NULL,
  nombre character(120)
);

-- ------------------------------------------------------------
-- Tabla Principal de Codigos de Estatus.
-- ------------------------------------------------------------
CREATE TABLE Stzstder (
  Estatus INTEGER NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(100) NOT NULL,
  Publicable CHARACTER(1) NOT NULL,
  Tipo_mp CHARACTER(1) NOT NULL CHECK(Tipo_mp='M' OR Tipo_mp='P') 
);
-- Solo para Obras 
CREATE TABLE Stdstobr (
  Estatus INTEGER NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(100) NOT NULL 
);
-- ------------------------------------------------------------
-- Tabla principal de Eventos.
-- ------------------------------------------------------------
CREATE TABLE Stzevder (
  Evento SMALLINT NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(120) NOT NULL,
  Tipo_evento CHARACTER(1) NOT NULL CHECK(Tipo_evento='M' OR Tipo_evento='N' OR Tipo_evento='C'),
  Inf_adicional CHARACTER(1) NOT NULL CHECK(Inf_adicional='D' OR Inf_adicional='C' OR Inf_adicional='A' OR Inf_adicional='N'),
  Mensa_automatico CHARACTER VARYING(120),
  Plazo_ley SMALLINT,
  Tipo_Plazo CHARACTER(1) NOT NULL CHECK(Tipo_plazo='H' OR Tipo_plazo='M' OR Tipo_plazo='A' OR Tipo_plazo='N'),
  Tit_comenta CHARACTER VARYING(40) NULL,
  Tit_nro_doc CHARACTER VARYING(20) NULL,
  Aplica CHARACTER(1) NOT NULL,
  Tipo_mp CHARACTER(1) NOT NULL CHECK(Tipo_mp='M' OR Tipo_mp='P') 
);
-- Eventos de Derecho de Autor 
CREATE TABLE Stdevobr (
  Evento SMALLINT NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(120) NOT NULL,
  Tipo_evento CHARACTER(1) NOT NULL CHECK(Tipo_evento='M' OR Tipo_evento='N' OR Tipo_evento='C'),
  Inf_adicional CHARACTER(1) NOT NULL CHECK(Inf_adicional='D' OR Inf_adicional='C' OR Inf_adicional='A' OR Inf_adicional='N'),
  Mensa_automatico CHARACTER VARYING(120) NOT NULL,
  Plazo_ley SMALLINT NOT NULL,
  Tipo_Plazo CHARACTER(1) NOT NULL CHECK(Tipo_plazo='H' OR Tipo_plazo='M' OR Tipo_plazo='A' OR Tipo_plazo='N'),
  Tit_comenta CHARACTER VARYING(50) NULL,
  Tit_nro_doc CHARACTER VARYING(20) NULL,
  Aplica CHARACTER(1) NOT NULL 
);
-- ------------------------------------------------------------
-- Maestra de Sistemas.
-- ------------------------------------------------------------
CREATE TABLE stzsystem (
    Nro_derecho  SERIAL NOT NULL, 
    msolicitud   SERIAL NOT NULL, 
    psolicitud   SERIAL NOT NULL, 
    npoder       SERIAL NOT NULL, 
    nagente      SERIAL NOT NULL, 
    nproducto    SERIAL NOT NULL, 
    nservicios   SERIAL NOT NULL, 
    nnombres     SERIAL NOT NULL, 
    nlemas       SERIAL NOT NULL, 
    ncolectivas  SERIAL NOT NULL, 
    ndorigen     SERIAL NOT NULL, 
    nbusqext     SERIAL NOT NULL, 
    mbusqpet     SERIAL NOT NULL, 
    pbusqpet     SERIAL NOT NULL, 
    nbitaco      SERIAL NOT NULL, 
    msecuencial  SERIAL NOT NULL, 
    psecuencial  SERIAL NOT NULL, 
    nanota       SERIAL NOT NULL, 
    expsecuen    SERIAL NOT NULL, 
    secuencial   SERIAL NOT NULL, 
    mescritos    SERIAL NOT NULL, 
    mcertificado SERIAL NOT NULL,  
    ninvencion   SERIAL NOT NULL,  
    ndiseno      SERIAL NOT NULL, 
    nutilidad    SERIAL NOT NULL,  
    secuendisind SERIAL NOT NULL, 
    ntitular     SERIAL NOT NULL, 
    devolucion   SERIAL NOT NULL, 
    orden_dev    SERIAL NOT NULL 
);
-- ------------------------------------------------------------
-- Maestra de Marcas y Patentes.
-- ------------------------------------------------------------
CREATE TABLE Stzderec (
  Nro_derecho INTEGER NOT NULL PRIMARY KEY,   
  Tipo_derecho CHARACTER(1) NOT NULL CHECK(Tipo_derecho='M' OR Tipo_derecho='N' OR Tipo_derecho='L' OR Tipo_derecho='S' OR Tipo_derecho='C' OR Tipo_derecho='D' OR Tipo_derecho='A' OR Tipo_derecho='G' OR Tipo_derecho='F' OR Tipo_derecho='V' OR Tipo_derecho='E' OR Tipo_derecho='B'),
  Solicitud CHARACTER(11) NOT NULL,
  Fecha_solic DATE NOT NULL,
  Tipo_mp CHARACTER(1) NOT NULL CHECK(Tipo_mp='M' OR Tipo_mp='P'),
  Nombre CHARACTER VARYING(500) NULL,
  Estatus INTEGER NOT NULL,
  Registro CHARACTER(8) NULL,
  Fecha_regis DATE NULL,
  Fecha_publi DATE NULL,
  Fecha_venc DATE NULL,
  Pais_resid CHARACTER(2) NOT NULL,
  Poder CHAR(9) NULL,
  Tramitante CHARACTER VARYING(120) NULL,
  Agente INTEGER NULL,
  FOREIGN KEY(Pais_resid) REFERENCES Stzpaisr(Pais) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Estatus) REFERENCES Stzstder(Estatus) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Maestra de Derecho de Autor.
-- ------------------------------------------------------------
CREATE TABLE Stdobras (
  Nro_derecho INTEGER NOT NULL PRIMARY KEY,
  Solicitud CHARACTER(6) NOT NULL,
  Fecha_solic DATE NOT NULL,
  Tipo_obra CHARACTER(2) NOT NULL CHECK(tipo_obra='OL' OR tipo_obra='AV' OR tipo_obra='OE' OR tipo_obra='OM' OR tipo_obra='AR' OR tipo_obra='PC' OR tipo_obra='PF' OR tipo_obra='IE' OR tipo_obra='AC'),
  Titulo_obra CHARACTER VARYING(300) NULL,
  Descrip_obra CHARACTER VARYING(2000) NULL,
  Cod_idioma CHARACTER(2) NOT NULL,
  Traduccion CHARACTER VARYING(300) NULL,
  Clase CHARACTER(1) NOT NULL CHECK(clase='I' OR clase='P' OR clase='N'),
  Origen CHARACTER(1) NOT NULL CHECK(origen='D' OR origen='O' OR origen='N'),
  Forma CHARACTER(1) NOT NULL CHECK(forma='I' OR forma='E' OR forma='C' OR forma='N'),
  Estatus INTEGER NOT NULL,
  Registro CHARACTER(6) NULL,
  Fecha_regis DATE NULL,
  Anno_realiza SMALLINT NULL,
  Anno_1publica SMALLINT NULL,
  Pais_origen CHARACTER(2) NOT NULL,
  N_ejemplares SMALLINT NOT NULL,
  Tipo_soporte CHARACTER VARYING(100) NOT NULL,
  Observacion CHARACTER VARYING(300) NULL,
  N_hojas_adic SMALLINT NOT NULL,
  Datos_ampli CHARACTER VARYING(300) NULL,
  Datos_adicio TEXT NULL,
  Obradrivada BOOL NULL,
  Nplanilla CHARACTER(6) NULL,
  FOREIGN KEY(Cod_idioma) REFERENCES Stdidiom(Cod_idioma) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY(Estatus) REFERENCES Stdstobr(Estatus) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY(Pais_origen) REFERENCES Stzpaisr(Pais) ON UPDATE CASCADE ON DELETE RESTRICT 
);
-- ------------------------------------------------------------
-- Representante de la Persona Juridica.
-- ------------------------------------------------------------
CREATE TABLE Stdrepre (
  Nro_derecho INTEGER NOT NULL,
  Cedula_repre CHARACTER(10) NOT NULL,
  Nombre_repre CHARACTER VARYING(100) NOT NULL,
  Cualidad_repre CHARACTER VARYING(40) NOT NULL,
  Prueba CHARACTER VARYING(200) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Tablas asociadas a MARCAS.
-- ------------------------------------------------------------
-- Tabla principal de Codigos de Viena.
-- ------------------------------------------------------------
CREATE TABLE Stmviena (
  Ccv CHARACTER(6) NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(1000) NOT NULL,
  Frecuencia INTEGER NOT NULL 
);
-- ------------------------------------------------------------
-- Tabla Relacion de Clases Internacionales y Nacionales.
-- ------------------------------------------------------------
CREATE TABLE Stmclbus (
  Clase_inter INTEGER NOT NULL,
  Clase_asoc INTEGER NOT NULL 
);
-- ------------------------------------------------------------
-- Tabla Principal de Marcas.
-- ------------------------------------------------------------
CREATE TABLE Stmmarce (
  Nro_derecho INTEGER NOT NULL,
  Clase INTEGER NOT NULL,
  Ind_claseni CHARACTER(1) NOT NULL CHECK(Ind_claseni='I' OR Ind_claseni='N'),
  Modalidad CHARACTER(1) NOT NULL CHECK(Modalidad='D' OR Modalidad='G' OR Modalidad='M'),
  Distingue TEXT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Tabla de asociacion de Lemas Comerciales.
-- ------------------------------------------------------------
CREATE TABLE Stmlemad (
  Nro_derecho INTEGER NOT NULL,
  Solicitud_aso CHARACTER(11) NULL,
  Registro_aso CHARACTER(8) NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Detalles de la Descripcion del Logotipo o imagen de Marcas.
-- ------------------------------------------------------------
CREATE TABLE Stmlogos (
  Nro_derecho INTEGER NOT NULL,
  Descripcion TEXT NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Tabla del basamento legal para las Negadas.
-- ------------------------------------------------------------
CREATE TABLE Stmliaor (
  Nro_derecho INTEGER NOT NULL,
  Articulo CHARACTER(3) NOT NULL,
  Literal CHARACTER(2),
  reg_base CHARACTER(7),
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_liaor PRIMARY KEY(Nro_derecho,Articulo) 
);
-- ------------------------------------------------------------
-- Detalle de Codigos de Viena asociados a la Solicitud.
-- ------------------------------------------------------------
CREATE TABLE Stmccvma (
  Nro_derecho INTEGER NOT NULL,
  Ccv CHARACTER(6) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Ccv) REFERENCES Stmviena(Ccv) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_ccvma PRIMARY KEY(Nro_derecho,Ccv) 
);
-- ------------------------------------------------------------
-- Tablas asociadas a PATENTES.
-- ------------------------------------------------------------
-- Tabla principal de Codigos Locarno.
-- ------------------------------------------------------------
CREATE TABLE Stplocar (
  Subclase CHARACTER(5) NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(1000) NOT NULL 
);
-- ------------------------------------------------------------
-- Tabla Principal de Palabras Claves.
-- ------------------------------------------------------------
CREATE TABLE Stptesar (
  Palabra CHARACTER(40) NOT NULL,
  Apuntador SERIAL,
  PRIMARY KEY(Apuntador) 
);
-- ------------------------------------------------------------
-- Maestra de Patente
-- ------------------------------------------------------------
CREATE TABLE Stppatee (
  Nro_derecho INTEGER NOT NULL,
  Edicion SMALLINT NOT NULL,
  Anualidad SMALLINT NULL,
  Resumen TEXT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE 
);
-- ------------------------------------------------------------
-- Detalle de la Clasificacion Locarno de Diseño Industrial
-- ------------------------------------------------------------
CREATE TABLE Stplocad (
  Nro_derecho INTEGER NOT NULL,
  Clasi_locarno CHARACTER(5) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Clasi_locarno) REFERENCES Stplocar(Subclase) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_locad PRIMARY KEY(Nro_derecho,Clasi_locarno) 
);
-- ------------------------------------------------------------
-- Detalle de Palabras Claves asociadas a Solicitud de Patentes.
-- ------------------------------------------------------------
CREATE TABLE Stppacld (
  Nro_derecho INTEGER NOT NULL,
  Apuntador INTEGER NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Apuntador) REFERENCES Stptesar(Apuntador) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_pacld PRIMARY KEY(Nro_derecho,Apuntador) 
);
-- ------------------------------------------------------------
-- Detalle de la Clasificacion de las Patentes.
-- ------------------------------------------------------------
CREATE TABLE Stpclsfd (
  Nro_derecho INTEGER NOT NULL,
  Clasificacion CHARACTER(15) NOT NULL,
  Tipo_clas CHARACTER(1) NOT NULL CHECK(Tipo_clas='P' OR Tipo_clas='S'),
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_clsfd PRIMARY KEY(Nro_derecho,Clasificacion) 
);
-- ------------------------------------------------------------
-- Detalle de las Equivalentes a la Solicitud de Patente.
-- ------------------------------------------------------------
CREATE TABLE Stpequiv (
  nro_derecho INTEGER NOT NULL,
  equivalente CHARACTER(15)
);
-- ------------------------------------------------------------
-- Detalle de las Anualidades Pagadas de Patentes.
-- ------------------------------------------------------------
CREATE TABLE Stpanual (
  Nro_derecho INTEGER NOT NULL,
  Fecha_anual DATE NOT NULL,
  Nro_anualidad INTEGER NOT NULL,
  Monto NUMERIC NOT NULL,
  Observacion CHARACTER VARYING(1000) NULL,
  Nro_control INTEGER NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);
-- ------------------------------------------------------------
-- Tablas COMUNES asociadas a MARCAS y PATENTES.
-- ------------------------------------------------------------
-- Tabla de Feriados para Vencimientos.
-- ------------------------------------------------------------
CREATE TABLE Stzferir (
  Fecha_fer DATE
);
-- ------------------------------------------------------------
-- Detalle de los Titulares asociados a la Solicitud.
-- ------------------------------------------------------------
CREATE TABLE Stzottid (
  Nro_derecho INTEGER NOT NULL,
  Titular INTEGER NOT NULL,
  Nacionalidad CHARACTER(2) NOT NULL,
  Domicilio CHARACTER VARYING(200) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Nacionalidad) REFERENCES Stzpaisr(Pais) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT id_ottid PRIMARY KEY(Nro_derecho,Titular)
);
-- ------------------------------------------------------------
-- Detalle Historico de los Titulares asociados a la Solicitud.
-- ------------------------------------------------------------
CREATE TABLE Stzhotid (
  Nro_derecho INTEGER NOT NULL,
  Titular INTEGER NOT NULL,
  Nacionalidad CHARACTER(2) NOT NULL,
  Domicilio CHARACTER VARYING(200) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Nacionalidad) REFERENCES Stzpaisr(Pais) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT id_hotid PRIMARY KEY(Nro_derecho,Titular)
);
-- ------------------------------------------------------------
-- Descripcion de Agentes por Solicitud
-- ------------------------------------------------------------
CREATE TABLE Stzautod (
  Nro_derecho INTEGER NOT NULL,
  Agente INTEGER NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Agente) REFERENCES Stzagenr(Agente) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_autod PRIMARY KEY(Nro_derecho,Agente)
);
-- ------------------------------------------------------------
-- Detalle de las Licencias de Uso de las Solicitudes.
-- ------------------------------------------------------------
CREATE TABLE Stzliced (
  Nro_derecho INTEGER NOT NULL,
  Licencia INTEGER NOT NULL,
  Nombre_licen CHARACTER VARYING(120) NOT NULL,
  Fecha_licen DATE NOT NULL,
  Fecha_Venc DATE NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_liced PRIMARY KEY(Nro_derecho,Licencia)
);
-- ------------------------------------------------------------
-- Detalle de la Prioridad
-- ------------------------------------------------------------
CREATE TABLE Stzpriod (
  Nro_derecho INTEGER NOT NULL,
  Prioridad CHARACTER(15) NOT NULL,
  Pais_priori CHARACTER(2) NOT NULL,
  Fecha_priori DATE NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_priod PRIMARY KEY(Nro_derecho,Prioridad)
);
-- ------------------------------------------------------------
-- Tabla de Migraciones.
-- ------------------------------------------------------------
CREATE TABLE Stzmigrr (
  Evento SMALLINT NOT NULL,
  Estatus_ini SMALLINT NOT NULL,
  Estatus_fin SMALLINT NOT NULL,
  Tipo_mp CHARACTER(1) NOT NULL CHECK(Tipo_mp='M' OR Tipo_mp='P'),
  FOREIGN KEY(Evento) REFERENCES Stzevder(Evento) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Estatus_ini) REFERENCES Stzstder(Estatus) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Estatus_fin) REFERENCES Stzstder(Estatus) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_migrr PRIMARY KEY(Evento,Estatus_ini,Estatus_fin)
);
-- Migracion de Derecho de Autor 
CREATE TABLE Stdmigrr (
  Evento SMALLINT NOT NULL,
  Estatus_ini SMALLINT NOT NULL,
  Estatus_fin SMALLINT NOT NULL,
  FOREIGN KEY(Evento) REFERENCES Stdevobr(Evento) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Estatus_ini) REFERENCES Stdstobr(Estatus) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Estatus_fin) REFERENCES Stdstobr(Estatus) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_dmigrr PRIMARY KEY(Evento,Estatus_ini,Estatus_fin)
);
-- ------------------------------------------------------------
-- Detalle de historico de Eventos de Tramite Marcas y Patentes.
-- ------------------------------------------------------------

CREATE TABLE Stzevtrd (
  Nro_derecho INTEGER NOT NULL,
  Evento SMALLINT NOT NULL,
  Fecha_event DATE NOT NULL,
  Secuencial SERIAL,
  Estat_ant SMALLINT NOT NULL,
  Fecha_venc DATE NULL,
  Documento INTEGER NULL,
  Fecha_trans DATE NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Desc_evento CHARACTER VARYING(120) NOT NULL,
  Comentario CHARACTER VARYING(600) NULL,
  Hora CHARACTER(11) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Evento) REFERENCES Stzevder(Evento) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Estat_ant) REFERENCES Stzstder(Estatus) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_evtrd PRIMARY KEY(Nro_derecho,Secuencial)
);

-- Tramites de Derecho de Autor 

CREATE TABLE stdevtrd (
  Nro_derecho INTEGER NOT NULL,
  Evento SMALLINT NOT NULL,
  Fecha_event DATE NOT NULL,
  Secuencial SERIAL,
  Estat_ant SMALLINT NOT NULL,
  Fecha_venc DATE,
  Documento INTEGER,
  Fecha_trans DATE NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Desc_evento CHARACTER(120) NOT NULL,
  Comentario CHARACTER(300),
  Hora CHARACTER(11) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Evento) REFERENCES Stdevobr(Evento) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY(Estat_ant) REFERENCES Stdstobr(Estatus) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Tabla Detalle con las Solicitudes a ser publicadas en un boletin.
-- ------------------------------------------------------------

CREATE TABLE Stztmpbo (
  Nro_derecho INTEGER NOT NULL,
  Solicitud CHARACTER(11) NOT NULL,
  Boletin INTEGER NOT NULL,
  Estatus SMALLINT NOT NULL,
  Tipo CHARACTER(1) NOT NULL CHECK(Tipo='M' OR Tipo='P'),
  Nanota INTEGER,
  Usuario CHARACTER(10) NOT NULL,
  Fecha_carga DATE NOT NULL,
  Hora_carga CHARACTER(11) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_tmpbo PRIMARY KEY(Nro_derecho,Boletin,Estatus,nanota)
);

-- ------------------------------------------------------------
-- Detalle de las Anotaciones Marginales a Publicar.
-- ------------------------------------------------------------

CREATE TABLE Stzantma (
  Nro_derecho INTEGER NOT NULL,
  Nanota INTEGER NULL,
  Solicitud CHARACTER(11) NOT NULL,
  Tipo CHAR(1) NOT NULL CHECK(Tipo='M' OR Tipo='P'),
  Evento SMALLINT NOT NULL,
  Cod_tit_1 INTEGER NULL,
  Nom_tit_1 CHARACTER VARYING(150) NULL,
  Cod_tit_2 INTEGER NULL,
  Nom_tit_2 CHARACTER VARYING(150) NULL,
  Domicilio CHARACTER VARYING(200) NULL,
  Pais CHARACTER(2) NULL,
  Tramitante CHARACTER VARYING(100) NULL,
  Vencimiento DATE NULL,
  Verificado CHARACTER(1) NULL,
  Inf_adicional CHARACTER VARYING(3000) NULL,
  Agente INTEGER NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_antma PRIMARY KEY(Nro_derecho,Nanota,cod_tit_1,cod_tit_2)
);

-- ------------------------------------------------------------
-- Tabla Principal de Causales de Devolucion.
-- ------------------------------------------------------------

CREATE TABLE Stzcoded (
  Cod_causa INTEGER NOT NULL,
  Desc_causa CHARACTER VARYING(200) NOT NULL,
  Derecho CHARACTER(1) NOT NULL CHECK(Derecho='M' OR Derecho='P'),
  Grupo CHARACTER(1) NOT NULL CHECK(Grupo='M' OR Grupo='D' OR Grupo='A'),
  CONSTRAINT id_coded PRIMARY KEY(Cod_causa,Derecho,Grupo)
);

-- ------------------------------------------------------------
-- Detalle de Causales de Devolucion por Solicitud.
-- ------------------------------------------------------------

CREATE TABLE Stzcaded (
  Nro_derecho INTEGER NOT NULL,
  Cod_causa INTEGER NOT NULL,
  Derecho CHARACTER(1) NOT NULL CHECK(Derecho='M' OR Derecho='P'),
  Grupo CHARACTER(1) NOT NULL CHECK(Grupo='M' OR Grupo='D' OR Grupo='A'),
  Tipo_Dev CHARACTER(1) NOT NULL CHECK(Tipo_Dev='M' OR Tipo_Dev='D' OR Tipo_Dev='L' OR Tipo_Dev='C' OR Tipo_Dev='F' OR Tipo_Dev='R' OR Tipo_Dev='N' OR Tipo_Dev='O'),
  Fecha_Dev DATE,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_caded PRIMARY KEY(Nro_derecho,Cod_causa,Derecho,Grupo,Tipo_Dev,fecha_dev)
);

-- ------------------------------------------------------------
-- Detalle de Otra Causal de Devolucion a la Solicitud.
-- ------------------------------------------------------------

CREATE TABLE Stzotrde (
  Nro_derecho INTEGER NOT NULL,
  Otros CHARACTER VARYING(500) NOT NULL,
  Derecho CHARACTER(1) NOT NULL CHECK(Derecho='M' OR Derecho='P'),
  Grupo CHARACTER(1) NOT NULL CHECK(Grupo='M' OR Grupo='D' OR Grupo='A'),
  Tipo_Dev CHARACTER(1) NOT NULL CHECK(Tipo_Dev='M' OR Tipo_Dev='D' OR Tipo_Dev='L' OR Tipo_Dev='C' OR Tipo_Dev='F' OR Tipo_Dev='R' OR Tipo_Dev='N' OR Tipo_Dev='O'),
  Fecha_Dev DATE,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_otrde PRIMARY KEY(Nro_derecho,Derecho,Grupo,Tipo_Dev,fecha_dev)
);

-- ------------------------------------------------------------
-- Tablas asociadas a DERECHO DE AUTOR.
-- ------------------------------------------------------------
-- ------------------------------------------------------------
-- Tabla principal de Generos.
-- ------------------------------------------------------------

CREATE TABLE Stdgener (
  Cod_genero CHARACTER(6) NOT NULL PRIMARY KEY,
  Desc_genero CHARACTER VARYING(40) NOT NULL
);

-- ------------------------------------------------------------
-- Tabla principal de la Obra Escenica.
-- ------------------------------------------------------------

CREATE TABLE Stdescen (
  Nro_derecho INTEGER NOT NULL,
  Tipoobraesc CHARACTER(1) NOT NULL CHECK(Tipoobraesc='D' OR Tipoobraesc='C' OR Tipoobraesc='M' OR Tipoobraesc='O'),
  Otraobraesc CHARACTER VARYING(60) NULL,
  Argumento CHARACTER VARYING(600) NOT NULL,
  Musica CHARACTER VARYING(600) NULL,
  Movimiento CHARACTER VARYING(600) NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_escen PRIMARY KEY(Nro_derecho,Tipoobraesc)
);

-- ------------------------------------------------------------
-- Detalle de los Artistas asociados a las Obras.
-- ------------------------------------------------------------

CREATE TABLE Stdobart (
  Nro_derecho INTEGER NOT NULL,
  Doc_artista CHARACTER(10) NOT NULL,
  Titular INTEGER NOT NULL,
  Domicilio CHARACTER VARYING(200) NULL,
  Pais_resid CHARACTER(2) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(pais_resid) REFERENCES stzpaisr(pais) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT id_obart PRIMARY KEY(Nro_derecho,Doc_artista)
);

CREATE TABLE stdartar (
  Nro_derecho INTEGER NOT NULL,
  Artista CHARACTER VARYING(300),
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT
);

-- ------------------------------------------------------------
-- Detalle de los productores asociados a las Obras.
-- ------------------------------------------------------------

CREATE TABLE Stdobpro (
  Nro_derecho INTEGER NOT NULL,
  Doc_productor CHARACTER(10) NOT NULL,
  Titular INTEGER NOT NULL,
  Domicilio CHARACTER VARYING(200) NULL,
  Pais_resid CHARACTER(2) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(pais_resid) REFERENCES stzpaisr(pais) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT id_obpro PRIMARY KEY(Nro_derecho,Doc_productor)
);

-- ------------------------------------------------------------
-- Detalles del o los Autor(es) asociados a las Obras.
-- ------------------------------------------------------------

CREATE TABLE Stdobaut (
  Nro_derecho INTEGER NOT NULL,
  Doc_autor CHARACTER(10) NOT NULL,
  Tipo_autor CHARACTER(2) NOT NULL,
  Titular INTEGER NOT NULL,
  Domicilio CHARACTER VARYING(200) NULL,
  Pais_resid CHARACTER(2) NOT NULL, 
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(pais_resid) REFERENCES stzpaisr(pais) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT id_obaut PRIMARY KEY(Nro_derecho,Doc_autor,Tipo_autor)
);

-- ------------------------------------------------------------
-- Detalle del Solicitante de las Obras.
-- ------------------------------------------------------------

CREATE TABLE Stdobsol (
  Nro_derecho INTEGER NOT NULL,
  Caracter CHARACTER(1) NOT NULL,
  Otro_caracter CHARACTER VARYING(100) NULL,
  Prueba_repres CHARACTER VARYING(500) NULL,
  Titular INTEGER NOT NULL,
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais_resid CHARACTER(2) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(pais_resid) REFERENCES stzpaisr(pais) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT id_obsol PRIMARY KEY(Nro_derecho,titular)
);

-- ------------------------------------------------------------
-- Detalles de los Titulares asociados a las Obras.
-- ------------------------------------------------------------

CREATE TABLE Stdobtit (
  Nro_derecho INTEGER NOT NULL,
  Doc_titular CHARACTER(10) NOT NULL,
  Titulo_presun CHARACTER VARYING(120) NOT NULL,
  Doc_transfer CHARACTER VARYING(120) NOT NULL,
  Titular INTEGER NOT NULL,
  Domicilio CHARACTER VARYING(200) NULL,
  Pais_resid CHARACTER(2) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(pais_resid) REFERENCES stzpaisr(pais) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT id_obtit PRIMARY KEY(Nro_derecho,Doc_titular)
);

-- ------------------------------------------------------------
-- Detalle de las Obras Fijadas.
-- ------------------------------------------------------------

CREATE TABLE Stdfijin (
  Nro_derecho INTEGER NOT NULL,
  Cod_obfinej CHARACTER(7) NOT NULL,
  Titulo_obfija CHARACTER VARYING(300) NOT NULL,
  Nombre_autor CHARACTER VARYING(100) NOT NULL,
  Arreglista CHARACTER VARYING(100) NULL,
  Interprete CHARACTER VARYING(100) NOT NULL,
  Tipo_obfija CHARACTER VARYING(6) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_obfie PRIMARY KEY(Nro_derecho,Cod_obfinej)
);

-- ------------------------------------------------------------
-- Tabla principal de Actos y Contratos.
-- ------------------------------------------------------------

CREATE TABLE Stdactos (
  Nro_derecho INTEGER NOT NULL,
  Partes TEXT NOT NULL,
  Naturaleza TEXT NOT NULL,
  Objeto TEXT NOT NULL,
  Derechos TEXT NOT NULL,
  Tipo_cuantia CHARACTER(1) NOT NULL CHECK(Tipo_cuantia='G' OR Tipo_cuantia='O'),
  Espec_cuantia CHARACTER VARYING(300) NOT NULL,
  Duracion CHARACTER VARYING(200) NOT NULL,
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Fecha_firma DATE NOT NULL,
  Datosregistro CHARACTER VARYING(300) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Detalle de Transferencias.
-- ------------------------------------------------------------

CREATE TABLE Stdtrans (
  Nro_derecho INTEGER NOT NULL,
  Transferencia CHARACTER VARYING(500) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Datos correspondientes a las Obras de Arte Visual.
-- ------------------------------------------------------------

CREATE TABLE Stdvisua (
  Nro_derecho INTEGER NOT NULL,
  Cod_genero CHARACTER VARYING(30) NOT NULL,
  Exhibida BOOL NULL,
  Ubica_exhibi CHARACTER VARYING(120) NULL,
  Publicada BOOL NULL,
  Datos_public CHARACTER VARYING(150) NULL,
  Edificada BOOL NULL,
  Ubica_edifica CHARACTER VARYING(150) NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_genvis PRIMARY KEY(Nro_derecho,Cod_genero)
);

-- ------------------------------------------------------------
-- Tabla Principal de Obras Musicales.
-- ------------------------------------------------------------

CREATE TABLE Stdmusic (
  Nro_derecho INTEGER NOT NULL,
  Cod_genero CHARACTER(6) NOT NULL,
  Letra BOOL NOT NULL,
  Ritmo CHARACTER VARYING(30) NOT NULL,
  Dat_produ_fon CHARACTER VARYING(300) NULL,
  Fin_comercial BOOL NOT NULL,
  Anno_fija_sono SMALLINT NULL,
  FOREIGN KEY(Cod_genero) REFERENCES Stdgener(Cod_genero) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_genmus PRIMARY KEY(Nro_derecho,Cod_genero)
);

-- ------------------------------------------------------------
-- Datos de Fijacion.
-- ------------------------------------------------------------

CREATE TABLE Stdfijac (
  Nro_derecho INTEGER NOT NULL,
  Anno_fijacion SMALLINT NOT NULL,
  Tipo_fijacion CHARACTER(1) NOT NULL,
  Ficha_datos CHARACTER VARYING(500),
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Detalles de la Edicion.
-- ------------------------------------------------------------

CREATE TABLE Stdedici (
  Nro_derecho INTEGER NOT NULL,
  N_edicion SMALLINT NOT NULL,
  Anno_publica SMALLINT NOT NULL,
  N_ejemplares SMALLINT NOT NULL,
  Caracteristicas CHARACTER VARYING(300) NOT NULL,
  Editor_impres CHARACTER(1) NOT NULL,
  Doc_edimpres CHARACTER(10) NOT NULL,
  Titular INTEGER NOT NULL,
  Domicilio CHARACTER VARYING(200) NULL,
  Pais_resid CHARACTER(2) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Titular) REFERENCES Stzsolic(Titular) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(pais_resid) REFERENCES stzpaisr(pais) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- ------------------------------------------------------------
-- Datos de las Obras Derivadas.
-- ------------------------------------------------------------

CREATE TABLE Stdderiv (
  Nro_derecho INTEGER NOT NULL,
  Titulo_original CHARACTER VARYING(300) NOT NULL,
  Datos_autor CHARACTER VARYING(300) NOT NULL,
  Tipo_obra_deri CHARACTER(2) NOT NULL,
  Anno_pub_orig SMALLINT NOT NULL,
  N_versiones_aut SMALLINT NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Detalle sobre Orquestas, Grupos Musicales, Vocales y Otros.
-- ------------------------------------------------------------

CREATE TABLE Stdgrupo (
  Nro_derecho INTEGER NOT NULL,
  Nombre_grupo CHARACTER VARYING(200) NOT NULL,
  Tipo_agrupa CHARACTER(6) NOT NULL,
  Doc_director CHARACTER(10) NOT NULL,
  Titular INTEGER NOT NULL,
  Domicilio CHARACTER VARYING(200) NULL,
  Pais_resid CHARACTER(2) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_grupo PRIMARY KEY(Nro_derecho,Doc_director)
);

-- ------------------------------------------------------------
-- Tabla Principal de Causales de Devolucion.
-- ------------------------------------------------------------

CREATE TABLE Stdcoded (
  Cod_causa INTEGER NOT NULL PRIMARY KEY,
  Desc_causa CHARACTER VARYING(200) NOT NULL
);

-- ------------------------------------------------------------
-- Detalle de Causales de Devolucion por Solicitud.
-- ------------------------------------------------------------

CREATE TABLE Stdcaded (
  Nro_derecho INTEGER NOT NULL,
  Cod_causa INTEGER NOT NULL,
  fecha_dev date,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Cod_causa) REFERENCES Stdcoded(Cod_causa) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_dcaded PRIMARY KEY(Nro_derecho,Cod_causa)
);

-- ------------------------------------------------------------
-- Detalle de Otra Causal de Devolucion a la Solicitud.
-- ------------------------------------------------------------

CREATE TABLE Stdotrde (
  Nro_derecho INTEGER NOT NULL,
  Otros CHARACTER VARYING(300) NOT NULL,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Tablas asociadas al Control de ACCESO a USUARIOS.
-- ------------------------------------------------------------
-- ------------------------------------------------------------
-- Tabla Principal de Departamentos o Unidades.
-- ------------------------------------------------------------

CREATE TABLE Stzdepto (
  Cod_depto CHARACTER(2) NOT NULL PRIMARY KEY,
  Nombre CHARACTER VARYING(70) NOT NULL
);

-- ------------------------------------------------------------
-- Tabla principal de los Roles.
-- ------------------------------------------------------------

CREATE TABLE Stzroles (
  Role CHARACTER(8) NOT NULL PRIMARY KEY,
  Nombre CHARACTER VARYING(80) NOT NULL,
  Estado CHARACTER(1) NOT NULL,
  Fecha_elim DATE NULL,
  Descripcion CHARACTER VARYING(500) NULL,
  Fecha_crea DATE NOT NULL,
  Hora_crea CHARACTER(11) NOT NULL,
  Hora_elim CHARACTER(11) NULL
);

-- ------------------------------------------------------------
-- Detalles de las opciones del Menu.
-- ------------------------------------------------------------

CREATE TABLE Stzmenu (
  Codmenu CHARACTER(4) NOT NULL PRIMARY KEY,
  Nombre CHARACTER VARYING(80) NOT NULL,
  Nivel CHARACTER(2) NOT NULL,
  Nomenclatura CHARACTER VARYING(80) NOT NULL,
  Estado CHARACTER(1) NOT NULL,
  Fecha_elim DATE NULL,
  Hora_elim CHARACTER(11) NULL
);

-- ------------------------------------------------------------
-- Tabla principal de Usuarios.
-- ------------------------------------------------------------

CREATE TABLE Stzusuar (
  Id SERIAL,
  Cedula CHARACTER(10) NOT NULL,
  Nombre CHARACTER(40) NOT NULL,
  Cod_depto CHARACTER(2) NOT NULL,
  Usuario CHARACTER(10) NOT NULL PRIMARY KEY,
  Pass CHARACTER VARYING(50) NOT NULL,
  Role CHARACTER(8) NULL,
  Fecha_ing DATE NOT NULL,
  Hora_ing CHARACTER(11) NOT NULL,
  Estatus CHARACTER(1) NOT NULL,
  Nivel_acceso CHARACTER(1) NULL,
  Email CHARACTER VARYING(80) NULL,
  Fecha_elim DATE NULL,
  Hora_elim CHARACTER(11) NULL,
  Fecha_pass DATE NULL,
  hora_pass CHARACTER(11) NULL,
  fecha_expi DATE NULL,
  FOREIGN KEY(Cod_depto) REFERENCES Stzdepto(Cod_depto) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Detalle de los Eventos asociados o asignados a un Rol.
-- ------------------------------------------------------------

CREATE TABLE Stzroleve (
  Role CHARACTER(8) NOT NULL,
  Evento SMALLINT NOT NULL,
  Tip_derecho CHARACTER(1) NOT NULL CHECK(Tip_derecho='M' OR Tip_derecho='P' OR Tip_derecho='A'),
  Fecha_asig DATE NOT NULL,
  Estado CHARACTER(1) NOT NULL CHECK(Estado='A' OR Estado='E'),
  Fecha_elim DATE NULL,
  Hora_asig CHARACTER(11) NOT NULL,
  Hora_elim CHARACTER(11) NULL,
  FOREIGN KEY(Role) REFERENCES Stzroles(Role) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_roleve PRIMARY KEY(Role,Evento,tip_derecho)
);

-- ------------------------------------------------------------
-- Detalle de asociacion de Opciones del Menu al Rol.
-- ------------------------------------------------------------

CREATE TABLE Stzrolmenu (
  Role CHARACTER(8) NOT NULL,
  Codmenu CHARACTER(4) NOT NULL,
  Fecha_asig DATE NOT NULL,
  Estado CHARACTER(1) NOT NULL,
  Fecha_elim DATE NULL,
  Hora_elim CHARACTER(11) NULL,
  FOREIGN KEY(Role) REFERENCES Stzroles(Role) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Codmenu) REFERENCES Stzmenu(Codmenu) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_rolmenu PRIMARY KEY(Role,Codmenu)
);

-- ------------------------------------------------------------
-- Detalle de historico de Roles asignados al Usuario.
-- ------------------------------------------------------------

CREATE TABLE Stzuserol (
  Usuario CHARACTER(10) NOT NULL,
  Fecha_role DATE NOT NULL,
  Role CHARACTER(8) NOT NULL,
  Estado CHARACTER(1) NOT NULL,
  Fecha_elim DATE NULL,
  Hora_asig CHARACTER(11) NOT NULL,
  Hora_elim CHARACTER(11) NULL,
  FOREIGN KEY(Role) REFERENCES Stzroles(Role) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Usuario) REFERENCES Stzusuar(Usuario) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT id_userol PRIMARY KEY(Usuario,Role,Fecha_role)
);

-- ------------------------------------------------------------
-- Detalle de historico de Conexiones y Cambio de Claves.
-- ------------------------------------------------------------

CREATE TABLE Stzconex (
  Conex SERIAL NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Fecha_conex DATE NOT NULL,
  Modulo CHARACTER VARYING(20) NOT NULL,
  Oper CHARACTER(1) NOT NULL,
  Hora_entrada CHARACTER(11) NOT NULL,
  Hora_salida CHARACTER(11)
);

CREATE TABLE Stzhispw (
  Cntrlpwd SERIAL NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Pass CHARACTER VARYING(50) NOT NULL,
  Fecha_pass DATE NOT NULL
);

-- ------------------------------------------------------------
-- Tabla de Acceso a la Base de Datos y Modulos.
-- ------------------------------------------------------------

CREATE TABLE Stzedobd (
  Estado CHARACTER(1)
);

CREATE TABLE Stzphpman (
  Fecha DATE NOT NULL,
  Hora CHARACTER(11) NOT NULL,
  Modulo CHARACTER(20) NOT NULL,
  Estado CHARACTER(1) NOT NULL,
  Derecho CHARACTER(1) NOT NULL
);

-- ------------------------------------------------------------
-- Tabla Bitacora para el registro de cambios.
-- ------------------------------------------------------------

CREATE TABLE Stzbitac (
  Numbit INTEGER NOT NULL PRIMARY KEY,
  Nro_derecho INTEGER NOT NULL,
  Expediente CHARACTER(11) NOT NULL,
  Tipoder CHARACTER(1) NOT NULL CHECK(Tipoder='M' OR Tipoder='P' OR Tipoder='A'),
  Tipomov CHARACTER(1) NOT NULL CHECK(Tipomov='M' OR Tipomov='E'),
  Tabla CHARACTER(11) NOT NULL,
  Campos CHARACTER VARYING(1000) NOT NULL,
  Regorig CHARACTER VARYING(15000) NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Fecha DATE NOT NULL,
  Hora CHARACTER(11) NOT NULL,
  FOREIGN KEY(Usuario) REFERENCES Stzusuar(Usuario) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Tabla Bitacora para el registro de cambios en campos Text.
-- ------------------------------------------------------------

CREATE TABLE Stzbitex (
  Numbit INTEGER NOT NULL PRIMARY KEY,
  Nro_derecho INTEGER NOT NULL,
  Expediente CHARACTER(11) NOT NULL,
  Tipoder CHARACTER(1) NOT NULL CHECK(Tipoder='M' OR Tipoder='P' OR Tipoder='A'),
  Tipomov CHARACTER(1) NOT NULL CHECK(Tipomov='M' OR Tipomov='E'),
  Tabla CHARACTER(10) NOT NULL,
  Regorig TEXT NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Fecha DATE NOT NULL,
  Hora CHARACTER(11) NOT NULL,
  FOREIGN KEY(Usuario) REFERENCES Stzusuar(Usuario) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Nro_derecho) REFERENCES Stzderec(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(Nro_derecho) REFERENCES Stdobras(Nro_derecho) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ------------------------------------------------------------
-- Tablas Relacionadas a Elemento Figurativo.
-- ------------------------------------------------------------

CREATE TABLE Stmcntrl (
  Pedido SERIAL,
  Recibo CHARACTER(6) NOT NULL,
  Fecharec DATE NOT NULL,
  Hora CHARACTER(11) NOT NULL,
  Solicitant CHARACTER VARYING(90) NOT NULL,
  Fechaing DATE NOT NULL,
  Estatus CHARACTER(1) NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Imagfile CHARACTER(254),
  Prioridad CHARACTER(1) NOT NULL,
  PRIMARY KEY(Pedido),
  FOREIGN KEY(Usuario) REFERENCES Stzusuar(Usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE Stmctrec (
  Recibo CHARACTER(6) NOT NULL,
  Clase SMALLINT NOT NULL,
  Estatus CHARACTER(1) NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Fechatrans DATE NOT NULL,
  Hora CHARACTER(11),
  FOREIGN KEY(Usuario) REFERENCES Stzusuar(Usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE Stmverif (
  Fecha_proc DATE NOT NULL,
  Hora CHARACTER(11) NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Solicitud CHARACTER(11) NOT NULL,
  Modificado CHARACTER(1),
  FOREIGN KEY(Usuario) REFERENCES Stzusuar(Usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE Stmaudef (
  Fecha DATE NOT NULL,
  Hora CHARACTER(11) NOT NULL,
  Usuario CHARACTER(10) NOT NULL,
  Pedido CHARACTER(11) NOT NULL,
  Clase SMALLINT NOT NULL,
  Vc1 CHARACTER(6),
  Vc2 CHARACTER(6),
  Vc3 CHARACTER(6),
  Vc4 CHARACTER(6),
  Vc5 CHARACTER(6),
  Vc6 CHARACTER(6),
  Vc7 CHARACTER(6),
  Vc8 CHARACTER(6),
  Total INTEGER,
  Estatus CHARACTER(1),
  Tipo CHARACTER(1),
  FOREIGN KEY(Usuario) REFERENCES Stzusuar(Usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE Stmpsovi (
  Pedido CHARACTER(11) NOT NULL,
  Solicitud CHARACTER(11) NOT NULL,
  Estatus CHARACTER(1) NOT NULL
);

-- ------------------------------------------------------------
-- Tablas relacionadas a la Busqueda de Peticionario.
-- ------------------------------------------------------------

CREATE TABLE Stzpetit (
  Pedido INTEGER,
  F_carga date,
  Hora CHARACTER(11),
  Solicitante CHARACTER(100),
  Denominacion CHARACTER(100),
  Recibo CHARACTER(6),
  Tipo CHARACTER(1),
  F_recibo date,
  Monto INTEGER,
  Modo CHARACTER(1),
  F_proceso date,
  Usuario CHARACTER(10)
);

CREATE TABLE Wordbusq (
  Codigo INTEGER NOT NULL,
  Palabra CHARACTER(8) NOT NULL,
  Fecha_trans date,
  Fecha_proc date,
  Hora_c CHARACTER(11),
  Estatus CHARACTER(1),
  Tipo CHARACTER(1) NOT NULL,
  Nombre CHARACTER(150)
);

CREATE TABLE Wordtitu (
  Codigo INTEGER NOT NULL,
  Titular INTEGER NOT NULL,
  Palabra CHARACTER(20)
);

-- ------------------------------------------------------------
-- Posibles Tablas a Eliminar por Javascript.
-- ------------------------------------------------------------

CREATE TABLE Stmclinr (
  Clase_inter INTEGER NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(200) NOT NULL,
  Productos CHARACTER VARYING(1000)
);

CREATE TABLE Stmclnar (
  Clase_nacion INTEGER NOT NULL PRIMARY KEY,
  Descripcion CHARACTER VARYING(200)
);

-- ------------------------------------------------------------
-- Tablas Fijas pero de Contenido Temporal.
-- ------------------------------------------------------------

CREATE TABLE Temviena (
  Solicitud CHARACTER(11),
  Ccv CHARACTER(6)
);

CREATE TABLE Temptitu (
  Solicitud CHARACTER(11),
  identificacion CHARACTER(10),
  Titular INTEGER,
  Nacionalidad CHARACTER(2),
  Domicilio CHARACTER(160),
  Nombre CHARACTER(150),
  Tipo_mp CHARACTER(1),
  Indole CHARACTER(1),
  Telefono1 CHARACTER(15),
  Telefono2 CHARACTER(15),
  Fax CHARACTER(15),
  Email CHARACTER(30)
);

CREATE TABLE tmpagenr (
  solicitud character(11),
  agente integer,
  nombre character varying(150),
  tipo_mp character(1)
);

CREATE TABLE Temptitam (
  Solicitud CHARACTER(11),
  Titular INTEGER,
  Nombre CHARACTER(150)
);

CREATE TABLE Stmtmpef (
  Fecha DATE,
  Hora CHARACTER(11),
  Usuario CHARACTER(10),
  Tabla CHARACTER(12),
  Tipo CHARACTER(1)
);

CREATE TABLE Tmppacla (
  Solicitud CHARACTER(11),
  Apuntador INTEGER,
  Palabra CHARACTER(40)
);

CREATE TABLE Tmpptitu (
  Solicitud CHARACTER(11),
  Titular INTEGER,
  Nacionalidad CHARACTER(2),
  Domicilio CHARACTER(160),
  Nombre CHARACTER(150),
  Pais_resid CHARACTER(2)
);

CREATE TABLE Tablavenci (
  Solicitud CHARACTER(11),
  Registro CHARACTER(7),
  Fechavenc date
);

CREATE TABLE Tempinven (
  Nroinv SMALLINT,
  Solicitud CHARACTER(11),
  Nombre CHARACTER(100),
  Nacionalidad CHARACTER(2)
);

CREATE TABLE Stdtmpfi (
  Solicitud CHARACTER(6) NOT NULL,
  Titulo_fijada CHARACTER VARYING(300) NOT NULL,
  Autor CHARACTER VARYING(100) NOT NULL,
  Interprete CHARACTER VARYING(100) NOT NULL,
  Arreglista CHARACTER VARYING(100)
);

CREATE TABLE Stdtmpfie (
  Solicitud CHARACTER(6) NOT NULL,
  Nro_obfinej CHARACTER(7) NOT NULL,
  Titulo_obfie CHARACTER VARYING(300) NOT NULL,
  Nombre_autor CHARACTER VARYING(100) NOT NULL,
  Arreglista CHARACTER VARYING(100),
  Interprete CHARACTER VARYING(100),
  Tipo_obfie CHARACTER VARYING(6)
);

CREATE TABLE Stdtmpso (
  Solicitud CHARACTER(6) NOT NULL,
  Tipo_persona CHARACTER(1) NOT NULL,
  Codigo CHARACTER(10) NOT NULL,
  Nombre CHARACTER VARYING(150) NOT NULL,
  Fecha_nacim DATE,
  Fecha_defun DATE,
  Estado_civil CHARACTER(1),
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais CHARACTER(2) NOT NULL,
  Indole CHARACTER(1),
  Telefono1 CHARACTER VARYING(15),
  Telefono2 CHARACTER VARYING(15),
  Fax CHARACTER VARYING(15),
  Profesion CHARACTER(40),
  Seudonimo CHARACTER(30),
  Datos_registro CHARACTER VARYING(300),
  Cedula_repre CHARACTER(10),
  Nombre_repre CHARACTER VARYING(80),
  Cualidad_repre CHARACTER VARYING(40),
  Prueba CHARACTER VARYING(200),
  Titulo_legal CHARACTER VARYING(120),
  Doc_trans CHARACTER VARYING(100),
  Tipo_autor CHARACTER(2),
  Email CHARACTER varying(80),
  CONSTRAINT stdtmpso_estado_civil CHECK (((((estado_civil = 'S'::bpchar) OR (estado_civil = 'C'::bpchar)) OR (estado_civil = 'D'::bpchar)) OR (estado_civil = 'V'::bpchar))),
  CONSTRAINT stdtmpso_tipo_persona CHECK (((tipo_persona = 'N'::bpchar) OR (tipo_persona = 'J'::bpchar)))
);

CREATE TABLE Stdtmppt (
  Solicitud CHARACTER(6) NOT NULL,
  Tipo_persona CHARACTER(1) NOT NULL,
  Codigo CHARACTER(10) NOT NULL,
  Nombre CHARACTER VARYING(150) NOT NULL,
  Fecha_nacim DATE,
  Fecha_defun DATE,
  Estado_civil CHARACTER(1),
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais CHARACTER(2) NOT NULL,
  Indole CHARACTER(1),
  Telefono1 CHARACTER VARYING(15),
  Telefono2 CHARACTER VARYING(15),
  Fax CHARACTER VARYING(15),
  Profesion CHARACTER(40),
  Seudonimo CHARACTER(30),
  Datos_registro CHARACTER VARYING(300),
  Cedula_repre CHARACTER(10),
  Nombre_repre CHARACTER VARYING(80),
  Cualidad_repre CHARACTER VARYING(40),
  Prueba CHARACTER VARYING(200),
  Titulo_legal CHARACTER VARYING(120),
  Doc_trans CHARACTER VARYING(100),
  Tipo_autor CHARACTER(2),
  Email CHARACTER VARYING(80),
  CONSTRAINT stdtmppt_estado_civil CHECK (((((estado_civil = 'S'::bpchar) OR (estado_civil = 'C'::bpchar)) OR (estado_civil = 'D'::bpchar)) OR (estado_civil = 'V'::bpchar))),
  CONSTRAINT stdtmppt_tipo_persona CHECK (((tipo_persona = 'N'::bpchar) OR (tipo_persona = 'J'::bpchar)))
);

CREATE TABLE Stdtmpau (
  Solicitud CHARACTER(6) NOT NULL,
  Tipo_persona CHARACTER(1) NOT NULL,
  Codigo CHARACTER(10) NOT NULL,
  Nombre CHARACTER VARYING(150) NOT NULL,
  Fecha_nacim DATE,
  Fecha_defun DATE,
  Estado_civil CHARACTER(1),
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais CHARACTER(2) NOT NULL,
  Indole CHARACTER(1),
  Telefono1 CHARACTER VARYING(15),
  Telefono2 CHARACTER VARYING(15),
  Fax CHARACTER VARYING(15),
  Profesion CHARACTER(40),
  Seudonimo CHARACTER(30),
  Datos_registro CHARACTER VARYING(300),
  Cedula_repre CHARACTER(10),
  Nombre_repre CHARACTER VARYING(80),
  Cualidad_repre CHARACTER VARYING(40),
  Prueba CHARACTER VARYING(200),
  Titulo_legal CHARACTER VARYING(120),
  Doc_trans CHARACTER VARYING(100),
  Tipo_autor CHARACTER(2),
  Email CHARACTER VARYING(80),
  CONSTRAINT stdtmpau_estado_civil CHECK (((((estado_civil = 'S'::bpchar) OR (estado_civil = 'C'::bpchar)) OR (estado_civil = 'D'::bpchar)) OR (estado_civil = 'V'::bpchar))),
  CONSTRAINT stdtmpau_tipo_persona CHECK (((tipo_persona = 'N'::bpchar) OR (tipo_persona = 'J'::bpchar)))
);

CREATE TABLE Stdtmpco (
  Solicitud CHARACTER(6) NOT NULL,
  Tipo_persona CHARACTER(1) NOT NULL,
  Codigo CHARACTER(10) NOT NULL,
  Nombre CHARACTER VARYING(150) NOT NULL,
  Fecha_nacim DATE,
  Fecha_defun DATE,
  Estado_civil CHARACTER(1),
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais CHARACTER(2) NOT NULL,
  Indole CHARACTER(1),
  Telefono1 CHARACTER VARYING(15),
  Telefono2 CHARACTER VARYING(15),
  Fax CHARACTER VARYING(15),
  Profesion CHARACTER(40),
  Seudonimo CHARACTER(30),
  Datos_registro CHARACTER VARYING(300),
  Cedula_repre CHARACTER(10),
  Nombre_repre CHARACTER VARYING(80),
  Cualidad_repre CHARACTER VARYING(40),
  Prueba CHARACTER VARYING(200),
  Titulo_legal CHARACTER VARYING(120),
  Doc_trans CHARACTER VARYING(100),
  Tipo_autor CHARACTER(2),
  Email CHARACTER VARYING(80),
  CONSTRAINT stdtmpco_estado_civil CHECK (((((estado_civil = 'S'::bpchar) OR (estado_civil = 'C'::bpchar)) OR (estado_civil = 'D'::bpchar)) OR (estado_civil = 'V'::bpchar))),
  CONSTRAINT stdtmpco_tipo_persona CHECK (((tipo_persona = 'N'::bpchar) OR (tipo_persona = 'J'::bpchar)))
);

CREATE TABLE Stdtmpar (
  Solicitud CHARACTER(6) NOT NULL,
  Tipo_persona CHARACTER(1) NOT NULL,
  Codigo CHARACTER(10) NOT NULL,
  Nombre CHARACTER VARYING(150) NOT NULL,
  Fecha_nacim DATE,
  Fecha_defun DATE,
  Estado_civil CHARACTER(1),
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais CHARACTER(2) NOT NULL,
  Indole CHARACTER(1),
  Telefono1 CHARACTER VARYING(15),
  Telefono2 CHARACTER VARYING(15),
  Fax CHARACTER VARYING(15),
  Profesion CHARACTER(40),
  Seudonimo CHARACTER(30),
  Datos_registro CHARACTER VARYING(300),
  Cedula_repre CHARACTER(10),
  Nombre_repre CHARACTER VARYING(80),
  Cualidad_repre CHARACTER VARYING(40),
  Prueba CHARACTER VARYING(200),
  Titulo_legal CHARACTER VARYING(120),
  Doc_trans CHARACTER VARYING(100),
  Tipo_autor CHARACTER(2),
  Email CHARACTER VARYING(80),
  CONSTRAINT stdtmpar_estado_civil CHECK (((((estado_civil = 'S'::bpchar) OR (estado_civil = 'C'::bpchar)) OR (estado_civil = 'D'::bpchar)) OR (estado_civil = 'V'::bpchar))),
  CONSTRAINT stdtmpar_tipo_persona CHECK (((tipo_persona = 'N'::bpchar) OR (tipo_persona = 'J'::bpchar)))
);

CREATE TABLE Stdtmped (
  Solicitud CHARACTER(6) NOT NULL,
  Tipo_persona CHARACTER(1) NOT NULL,
  Codigo CHARACTER(10) NOT NULL,
  Nombre CHARACTER VARYING(150) NOT NULL,
  Fecha_nacim DATE,
  Fecha_defun DATE,
  Estado_civil CHARACTER(1),
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais CHARACTER(2) NOT NULL,
  Indole CHARACTER(1),
  Telefono1 CHARACTER VARYING(15),
  Telefono2 CHARACTER VARYING(15),
  Fax CHARACTER VARYING(15),
  Profesion CHARACTER(40),
  Seudonimo CHARACTER(30),
  Datos_registro CHARACTER VARYING(300),
  Cedula_repre CHARACTER(10),
  Nombre_repre CHARACTER VARYING(80),
  Cualidad_repre CHARACTER VARYING(40),
  Prueba CHARACTER VARYING(200),
  Titulo_legal CHARACTER VARYING(120),
  Doc_trans CHARACTER VARYING(100),
  Tipo_autor CHARACTER(2),
  Email CHARACTER VARYING(80),
  CONSTRAINT stdtmped_estado_civil CHECK (((((estado_civil = 'S'::bpchar) OR (estado_civil = 'C'::bpchar)) OR (estado_civil = 'D'::bpchar)) OR (estado_civil = 'V'::bpchar))),
  CONSTRAINT stdtmped_tipo_persona CHECK (((tipo_persona = 'N'::bpchar) OR (tipo_persona = 'J'::bpchar)))
);

CREATE TABLE Stdtmpti (
  Solicitud CHARACTER(6) NOT NULL,
  Tipo_persona CHARACTER(1) NOT NULL,
  Codigo CHARACTER(10) NOT NULL,
  Nombre CHARACTER VARYING(150) NOT NULL,
  Fecha_nacim DATE,
  Fecha_defun DATE,
  Estado_civil CHARACTER(1),
  Domicilio CHARACTER VARYING(200) NOT NULL,
  Pais CHARACTER(2) NOT NULL,
  Indole CHARACTER(1),
  Telefono1 CHARACTER VARYING(15),
  Telefono2 CHARACTER VARYING(15),
  Fax CHARACTER VARYING(15),
  Profesion CHARACTER(40),
  Seudonimo CHARACTER(30),
  Datos_registro CHARACTER VARYING(300),
  Cedula_repre CHARACTER(10),
  Nombre_repre CHARACTER VARYING(80),
  Cualidad_repre CHARACTER VARYING(40),
  Prueba CHARACTER VARYING(200),
  Titulo_legal CHARACTER VARYING(120),
  Doc_trans CHARACTER VARYING(100),
  Tipo_autor CHARACTER(2),
  Email CHARACTER VARYING(80),
  CONSTRAINT stdtmpti_estado_civil CHECK (((((estado_civil = 'S'::bpchar) OR (estado_civil = 'C'::bpchar)) OR (estado_civil = 'D'::bpchar)) OR (estado_civil = 'V'::bpchar))),
  CONSTRAINT stdtmpti_tipo_persona CHECK (((tipo_persona = 'N'::bpchar) OR (tipo_persona = 'J'::bpchar)))
);

CREATE TABLE Stdtmpat (
  Solicitud CHARACTER(6) NOT NULL,
  Nombre CHARACTER VARYING(300)
);

CREATE TABLE Stptmpinv (
  Solicitud CHARACTER(11) NOT NULL,
  Nombre_inv CHARACTER(120) NOT NULL,
  Nacionalidad CHARACTER(2) NOT NULL,
  Numero INTEGER
);

CREATE TABLE Stptmpipc (
  Solicitud CHARACTER(11) NOT NULL,
  Clasificacion CHARACTER(15) NOT NULL,
  Tipo_clas CHARACTER(1) NOT NULL,
  Numero INTEGER
);

CREATE TABLE Stptmpeq (
  Solicitud CHARACTER(11) NOT NULL,
  Equivalente CHARACTER(15) NOT NULL,
  Fecha_trans date NOT NULL,
  Numero INTEGER
);

-- Estas tablas se saltaron en el proceso de migracion inicial; otras 
-- fueron recien creadas por Romulo Mendoza

CREATE TABLE Stzutilr (
  grupo INTEGER,
  orden INTEGER,
  codigo CHARACTER(10),
  elemento CHARACTER(40)
);

CREATE TABLE stpinved (
    nro_derecho integer NOT NULL,
    nombre_inv character(100) NOT NULL,
    nacionalidad character(2) NOT NULL
);

CREATE TABLE stmofdev (
    orden integer NOT NULL,
    nro_derecho integer NOT NULL,
    documento integer NOT NULL,
    estatus character(1) NOT NULL
);
 
CREATE TABLE stmtmpam (
    nro_derecho integer NOT NULL,
    registro character(7),
    nombre character(200),
    clase smallint,
    ind_claseni character(1),
    evento smallint,
    fecha_event date,
    documento integer,
    comentario character(300),
    usuario character(10)
);

CREATE TABLE stztmptit (
    solicitud character(11) NOT NULL,
    titular integer NOT NULL,
    identificacion character(10),
    nombre character varying(200) NOT NULL,
    domicilio character varying(200) NOT NULL,
    nacionalidad character(2) NOT NULL,
    indole character(1) NOT NULL,
    telefono1 character varying(15),
    telefono2 character varying(15),
    fax character varying(15),
    email character varying(50),
    tipo_mp character(1) NOT NULL
);

CREATE TABLE stztmpage (
    solicitud character(11) NOT NULL,
    agente integer NOT NULL,
    nombre character varying(120) NOT NULL,
    domicilio character varying(150) NOT NULL,
    tipo_mp character(1)
);

CREATE TABLE stztmprio (
    solicitud character(11) NOT NULL,
    prioridad character(10) NOT NULL, 
    pais_priori character(2),
    fecha_priori date,
    tipo_mp character(1) NOT NULL
);

CREATE TABLE stmtmpccv (
    solicitud character(11) NOT NULL,
    ccv character(6),
    descripcion character varying(1000)
);

CREATE TABLE stmtmpcvs (
    solicitud character(11) NOT NULL,
    ccv character(6)
);

CREATE TABLE stmtmprec (
    nro_derecho integer NOT NULL,
    clase_nac smallint,
    productos text 
);

CREATE TABLE stmbatfon (
    solicitud character(11)
);

CREATE TABLE stmrecla (
    nro_derecho integer NOT NULL,
    clase_nac smallint,
    productos text,
    verificado character(1)
);

CREATE TABLE stzmargi (
    nro_derecho integer NOT NULL,
    solicitud character(11) NOT NULL,
    documento character(1) NOT NULL,
    nro_docum character(11) NOT NULL,
    vencimiento date,
    tramitante character(120) NOT NULL,
    agente integer NOT NULL,
    codtit1 integer,
    titular1 character varying(1000) NOT NULL,
    codtit2 integer NOT NULL,
    titular2 character(200) NOT NULL,
    domicilio_ant character(200) NOT NULL,
    domicilio character(200) NOT NULL,
    pais character(2) NOT NULL,
    tipo_tramite character(1) NOT NULL,
    publicado character(1) NOT NULL,
    boletin integer,
    tipo_derecho character(1) NOT NULL,
    usuario character(12) NOT NULL,
    fecha_trans date NOT NULL,
    hora character(11) NOT NULL,
    verificado character(1) NOT NULL
);

-- Estas tablas son solo utilizadas para el proceso de Migracion
-- al final del proceso seran eliminadas
CREATE TABLE stmottid (
    solicitud character(11),
    titular integer NOT NULL,
    nacionalidad character(2) NOT NULL,
    domicilio character(160)
);

CREATE TABLE stmdistd (
    solicitud character(11),
    distingue text
);

CREATE TABLE stpottid (
    solicitud character(11) NOT NULL,
    titular integer NOT NULL,
    nacionalidad character(2) NOT NULL,
    domicilio character(160) NOT NULL
);

CREATE TABLE stpresud (
    solicitud character(11) NOT NULL,
    resumen character varying(12000),
    dummy1 character(1)
);

CREATE TABLE Stppatee2 (
  Nro_derecho INTEGER NOT NULL,
  Edicion SMALLINT NOT NULL,
  Anualidad SMALLINT NULL,
  Resumen TEXT NULL
);

CREATE TABLE Stmmarce2 (
  Nro_derecho INTEGER NOT NULL,
  Clase INTEGER NOT NULL,
  Ind_claseni CHARACTER(1) NOT NULL CHECK(Ind_claseni='I' OR Ind_claseni='N'),
  Modalidad CHARACTER(1) NOT NULL CHECK(Modalidad='D' OR Modalidad='G' OR Modalidad='M'),
  Distingue TEXT NULL
);

-- Modificacion de los temporales de derecho de autor (CAMBIO DE CHARACTER A ENTERO)
ALTER TABLE stdtmpso drop codigo;
ALTER TABLE stdtmpso add codigo integer;
ALTER TABLE stdtmpti drop codigo;
ALTER TABLE stdtmpti add codigo integer;
ALTER TABLE stdtmpau drop codigo;
ALTER TABLE stdtmpau add codigo integer;
ALTER TABLE stdtmped drop codigo;
ALTER TABLE stdtmped add codigo integer;
ALTER TABLE stdtmppt drop codigo;
ALTER TABLE stdtmppt add codigo integer;
ALTER TABLE stdtmpar drop codigo;
ALTER TABLE stdtmpar add codigo integer;
ALTER TABLE stdtmpco drop codigo;
ALTER TABLE stdtmpco add codigo integer;
--
ALTER TABLE stdtmpso add ced_rif character(10);
ALTER TABLE stdtmpti add ced_rif character(10);
ALTER TABLE stdtmpau add ced_rif character(10);
ALTER TABLE stdtmped add ced_rif character(10);
ALTER TABLE stdtmppt add ced_rif character(10);
ALTER TABLE stdtmpar add ced_rif character(10);
ALTER TABLE stdtmpco add ced_rif character(10);

