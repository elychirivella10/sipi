-- ------------------------------------------------------------
-- Archivos Indices
-- 
-- Nota: cuando se crean las tablas y se le indica "Primary Key"
--       a un campo; por defecto se crea un archivo Indice.
--       Aqui se crean los indices adicionales a los Primary Key
-- ------------------------------------------------------------
--[STZSOLIC]
CREATE INDEX stzsolic_nombre      ON stzsolic USING btree (nombre);

--[Stzdaper]
CREATE INDEX stzdaper_titular     ON stzdaper USING btree (titular);

--[Stzdajur]
CREATE INDEX stzdajur_titular     ON stzdajur USING btree (titular);

--[STZAGENR]
CREATE INDEX stzagenr_nombre      ON stzagenr USING btree (nombre);

--[STZPODER]
CREATE INDEX stzpoder_poder       ON stzpoder USING btree (poder);
CREATE INDEX stzpoder_titular     ON stzpoder USING btree (titular);
CREATE INDEX stzpoder_fecha_poder ON stzpoder USING btree (fecha_poder);

--[STZPOHAD]
CREATE INDEX stzpohad_poder       ON stzpohad USING btree (poder);
CREATE INDEX stzpohad_poderhabi   ON stzpohad USING btree (poderhabi);

--[STZDEREC]
CREATE INDEX stzderec_solicitud   ON stzderec USING btree (solicitud);
CREATE INDEX stzderec_fecha_solic ON stzderec USING btree (fecha_solic);
CREATE INDEX stzderec_tipo_mp     ON stzderec USING btree (tipo_mp);
CREATE INDEX stzderec_nombre      ON stzderec USING btree (nombre);
CREATE INDEX stzderec_estatus     ON stzderec USING btree (estatus);
CREATE INDEX stzderec_registro    ON stzderec USING btree (registro);
CREATE INDEX stzderec_pais_resid  ON stzderec USING btree (pais_resid);
CREATE INDEX stzderec_poder       ON stzderec USING btree (poder);
CREATE INDEX stzderec_tramitante  ON stzderec USING btree (tramitante);
CREATE INDEX stzderec_agente      ON stzderec USING btree (agente);

--[Stdobras]
CREATE INDEX stdobras_solicitud   ON stdobras USING btree (solicitud);
CREATE INDEX stdobras_fecha_solic ON stdobras USING btree (fecha_solic);
CREATE INDEX stdobras_tipo_obra   ON stdobras USING btree (tipo_obra);
CREATE INDEX stdobras_titulo_obra ON stdobras USING btree (titulo_obra);
CREATE INDEX stdobras_estatus     ON stdobras USING btree (estatus);
CREATE INDEX stdobras_registro    ON stdobras USING btree (registro);
CREATE INDEX stdobras_pais_origen ON stdobras USING btree (pais_origen);

--[Stdrepre]
CREATE INDEX stdrepre_nro_derecho ON stdrepre USING btree (nro_derecho);

--[STMMARCE]
CREATE INDEX stmmarce_nro_derecho ON stmmarce USING btree (nro_derecho);
CREATE INDEX stmmarce_clase       ON stmmarce USING btree (clase);
CREATE INDEX stmmarce_ind_claseni ON stmmarce USING btree (ind_claseni);
CREATE INDEX stmmarce_modalidad   ON stmmarce USING btree (modalidad);

--[Stmlemad]
CREATE INDEX stmlemad_nro_derecho ON stmlemad USING btree (nro_derecho);

--[Stmlogos]
CREATE INDEX stmlogos_nro_derecho ON stmlogos USING btree (nro_derecho);

--[Stmliaor]
CREATE INDEX stmliaor_nro_derecho ON stmliaor USING btree (nro_derecho);

--[Stmccvma]
CREATE INDEX stmccvma_nro_derecho ON stmccvma USING btree (nro_derecho);

--[Stppatee]
CREATE INDEX stppatee_nro_derecho ON stppatee USING btree (nro_derecho);

--[Stplocad]
CREATE INDEX stplocad_nro_derecho ON stplocad USING btree (nro_derecho);

--[Stppacld]
CREATE INDEX stppacld_nro_derecho ON stppacld USING btree (nro_derecho);

--[Stpclsfd]
CREATE INDEX stpclsfd_nro_derecho ON stpclsfd USING btree (nro_derecho);

--[Stpequiv]
CREATE INDEX stpequiv_nro_derecho ON stpequiv USING btree (nro_derecho);

--[Stpanual]
CREATE INDEX stpanual_nro_derecho ON stpanual USING btree (nro_derecho);

--[Stzottid]
CREATE INDEX stzottid_nro_derecho ON stzottid USING btree (nro_derecho);
CREATE INDEX stzottid_titular     ON stzottid USING btree (titular);

--[Stzhotid]
CREATE INDEX stzhotid_nro_derecho ON stzhotid USING btree (nro_derecho);
CREATE INDEX stzhotid_titular     ON stzhotid USING btree (titular);

--[Stzautod]
CREATE INDEX stzautod_nro_derecho ON stzautod USING btree (nro_derecho);
CREATE INDEX stzautod_agente      ON stzautod USING btree (agente);

--[Stzliced]
CREATE INDEX stzliced_nro_derecho ON stzliced USING btree (nro_derecho);

--[Stzpriod]
CREATE INDEX stzpriod_nro_derecho ON stzpriod USING btree (nro_derecho);

--[Stzmigrr]
CREATE INDEX stzmigrr_evento      ON stzmigrr USING btree (evento);
CREATE INDEX stzmigrr_estatus_ini ON stzmigrr USING btree (estatus_ini);
CREATE INDEX stzmigrr_estatus_fin ON stzmigrr USING btree (estatus_fin);
CREATE INDEX stzmigrr_tipo_mp     ON stzmigrr USING btree (tipo_mp);

--[Stdmigrr]
CREATE INDEX stdmigrr_evento      ON stdmigrr USING btree (evento);
CREATE INDEX stdmigrr_estatus_ini ON stdmigrr USING btree (estatus_ini);
CREATE INDEX stdmigrr_estatus_fin ON stdmigrr USING btree (estatus_fin);

--[STZEVTRD]
CREATE INDEX stzevtrd_nro_derecho ON stzevtrd USING btree (nro_derecho);
CREATE INDEX stzevtrd_evento      ON stzevtrd USING btree (evento);        
CREATE INDEX stzevtrd_fecha_event ON stzevtrd USING btree (fecha_event);
CREATE INDEX stzevtrd_fecha_trans ON stzevtrd USING btree (fecha_trans);
CREATE INDEX stzevtrd_documento   ON stzevtrd USING btree (documento);    
CREATE INDEX stzevtrd_usuario     ON stzevtrd USING btree (usuario);
CREATE INDEX stzevtrd_estat_ant   ON stzevtrd USING btree (estat_ant);    

--[STDEVTRD]
CREATE INDEX stdevtrd_nro_derecho ON stdevtrd USING btree (nro_derecho);
CREATE INDEX stdevtrd_evento      ON stdevtrd USING btree (evento);        
CREATE INDEX stdevtrd_fecha_event ON stdevtrd USING btree (fecha_event);
CREATE INDEX stdevtrd_fecha_trans ON stdevtrd USING btree (fecha_trans);
CREATE INDEX stdevtrd_documento   ON stdevtrd USING btree (documento);    
CREATE INDEX stdevtrd_usuario     ON stdevtrd USING btree (usuario);
CREATE INDEX stdevtrd_estat_ant   ON stdevtrd USING btree (estat_ant);    

--[STZTMPBO]
CREATE INDEX stztmpbo_nro_derecho ON stztmpbo USING btree (nro_derecho);
CREATE INDEX stztmpbo_solicitud   ON stztmpbo USING btree (solicitud);
CREATE INDEX stztmpbo_boletin     ON stztmpbo USING btree (boletin);
CREATE INDEX stztmpbo_estatus     ON stztmpbo USING btree (estatus);
CREATE INDEX stztmpbo_tipo        ON stztmpbo USING btree (tipo);
CREATE INDEX stztmpbo_nanota      ON stztmpbo USING btree (nanota);

--[STZANTMA]
CREATE INDEX stzantma_nro_derecho ON stzantma USING btree (nro_derecho);
CREATE INDEX stzantma_solicitud   ON stzantma USING btree (solicitud);
CREATE INDEX stzantma_tipo        ON stzantma USING btree (tipo);
CREATE INDEX stzantma_nanota      ON stzantma USING btree (nanota);
CREATE INDEX stzantma_evento      ON stzantma USING btree (evento);

--[STZCODED]
CREATE INDEX stzcoded_cod_causa ON stzcoded USING btree (cod_causa);

--[STZCADED]
CREATE INDEX stzcaded_nro_derecho ON stzcaded USING btree (nro_derecho);
CREATE INDEX stzcaded_cod_causa   ON stzcaded USING btree (cod_causa);

--[STZOTRDE]
CREATE INDEX stzotrde_nro_derecho ON stzotrde USING btree (nro_derecho);

--[STDESCEN]
CREATE INDEX stdescen_nro_derecho ON stdescen USING btree (nro_derecho);

--[STDOBART]
CREATE INDEX stdobart_nro_derecho ON stdobart USING btree (nro_derecho);

--[STDARTAR]
CREATE INDEX stdartar_nro_derecho ON stdartar USING btree (nro_derecho);

--[STDOBPRO]
CREATE INDEX stdobpro_nro_derecho ON stdobpro USING btree (nro_derecho);

--[STDOBAUT]
CREATE INDEX stdobaut_nro_derecho ON stdobaut USING btree (nro_derecho);

--[STDOBSOL]
CREATE INDEX stdobsol_nro_derecho ON stdobsol USING btree (nro_derecho);

--[STDOBTIT]
CREATE INDEX stdobtit_nro_derecho ON stdobtit USING btree (nro_derecho);

--[STDFIJIN]
CREATE INDEX stdfijin_nro_derecho ON stdfijin USING btree (nro_derecho);

--[STDACTOS]
CREATE INDEX stdactos_nro_derecho ON stdactos USING btree (nro_derecho);

--[STDtrans]
CREATE INDEX stdtrans_nro_derecho ON stdtrans USING btree (nro_derecho);

--[STDvisua]
CREATE INDEX stdvisua_nro_derecho ON stdvisua USING btree (nro_derecho);

--[STDmusic]
CREATE INDEX stdmusic_nro_derecho ON stdmusic USING btree (nro_derecho);

--[STDFIJAC]
CREATE INDEX stdfijac_nro_derecho ON stdfijac USING btree (nro_derecho);

--[STDedici]
CREATE INDEX stdedici_nro_derecho ON stdedici USING btree (nro_derecho);

--[STDderiv]
CREATE INDEX stdderiv_nro_derecho ON stdderiv USING btree (nro_derecho);

--[STDgrupo]
CREATE INDEX stdgrupo_nro_derecho ON stdgrupo USING btree (nro_derecho);

--[STDcaded]
CREATE INDEX stdcaded_nro_derecho ON stdcaded USING btree (nro_derecho);

--[STDotrde]
CREATE INDEX stdotrde_nro_derecho ON stdotrde USING btree (nro_derecho);

--[STpinved]
CREATE INDEX stpinved_nro_derecho ON stpinved USING btree (nro_derecho);

--[STmofdev]
CREATE INDEX stmofdev_nro_derecho ON stmofdev USING btree (nro_derecho);

--[STmrecla]
CREATE INDEX stmrecla_nro_derecho ON stmrecla USING btree (nro_derecho);

--[STzmargi]
CREATE INDEX stzmargi_nro_derecho ON stzmargi USING btree (nro_derecho);

-- Fin Script --
