<html>
<head>
  <LINK REL='STYLESHEET' TYPE='text/css' HREF='../main.css'>  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
  <title>menu acordeon con CSS3</title>
  <link rel="stylesheet" href="../comun/stylemenu.css" type="text/css" > 
  <link rel="stylesheet" href="../comun/estilo1.css" type="text/css" > 
</head>

<body>

<div align="center">

<table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
<tr>
<td>

   <table class="adminform">

    <tr>
      <td width="68%" valign="top">


<ul class="menu">

   <li><a href="#">Ayuda</a>
     <ul>
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>

<ul class="nav">
    <li>
        <a href="#">Home<span class="flecha">&#9660;</span></a>
    </li>
    <li>
        <a href="#">Servicios<span class="flecha">&#9660</span></a>
        <ul>
            <li><a href="#">Diseno grafico<span class="flecha">&#9660</span></a></li>
            <li>
                <a href="#">Diseno web<span class="flecha">&#9660</span></a>
                <ul>
                    <li><a href="#">Submenu 1<span class="flecha">&#9660</span></a></li>
                    <li><a href="#">Submenu 2<span class="flecha">&#9660</span></a></li>
                    <li><a href="#">Submenu 3<span class="flecha">&#9660</span></a></li>
                    <li><a href="#">Submenu 4<span class="flecha">&#9660</span></a></li>
                    <li><a href="#">Submenu 5<span class="flecha">&#9660</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#">Marketing<span class="flecha">&#9660</span></a>
                <ul>
                    <li><a href="#">Submenu 1<span class="flecha">&#9660</span></a></li>
                    <li><a href="#">Submenu 2<span class="flecha">&#9660</span></a></li>
                    <li>
                        <a href="#">Submenu 3<span class="flecha">&#9660</span></a>
                        <ul>
                            <li><a href="#">Submenu 1<span class="flecha">&#9660</span></a></li>
                            <li><a href="#">Submenu 2<span class="flecha">&#9660</span></a></li>
                            <li><a href="#">Submenu 3<span class="flecha">&#9660</span></a></li>
                            <li><a href="#">Submenu 4<span class="flecha">&#9660</span></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="#">SEO<span class="flecha">&#9660</span></a></li>
        </ul>
    </li>
    <li>
        <a href="#">Acerca<span class="flecha">&#9660</span></a>
        <ul>
            <li><a href="#">Historia<span class="flecha">&#9660</span></a></li>
            <li><a href="#">Mision<span class="flecha">&#9660</span></a></li>
            <li><a href="#">Vision<span class="flecha">&#9660</span></a></li>
        </ul>
    </li>
    <li>
        <a href="#">Contacto<span class="flecha">&#9660</span></a>
    </li>
</ul>





        
        </td>
       </tr>
      </table>
     </ul>
    </li> 


   <li><a href="#">Marcas</a>
    <ul> 
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>
         <table class="adminform">
          <tr>
           <td width="100%" valign="top">
             <div id="cpanel">

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
      	     <div style="float:left;">
		         <div class="icon">
		          <a href="../comun/calculadora.php" title="C&aacute;lculo de Costo Servicio(s)">
                 <img src="../imagenes/calculo.png" width="26px" align="middle" border="0" />
                 <span><font face="Arial" color="#000000" size=2><u><b>C&aacute;lculo de Costo Servicio(s)</u></b></font></span>
		          </a>
		         </div>
	           </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../consulta/indexbt_n.php">
                 <img src="../imagenes/busqueda1.png" width="42px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><b><u>B&uacute;squeda Gramatical</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../comun/m_busclase.php?vopc=1" title="B&uacute;squeda de Clase(s) seg&uacute;n palabra">
		           <img src="../imagenes/ubicar.png" width="40px" align="middle" border="0" />
                 <span><font face="Arial" color="#000000" size=2><u><b>Ubique la Clase de su Marca</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../consulta/m_consulta.php">
		           <img src="../imagenes/computadora.png" width="50px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../certificado/indexc.php">
		           <img src="../imagenes/certifyelectronic2.png" width="26%" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Certificado Electr&oacute;nico Marcas</u></b></font><span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../comun/z_tramibusq.php?vopc=1">
                 <img src="../imagenes/solibusq.png" width="34px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=1><u><b>Informaci&oacute;n sobre B&uacute;squeda de Antecedentes Fon&eacute;tico/
		          </a>
		         </div>
              </div>
              {/if}
    
              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../comun/z_updtramite.php?vopc=1">
		           <img src="../imagenes/solibusq.png" width="38px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=1><u><b>Modificaci&oacute;n Solicitud B&uacute;squeda de Antecedentes</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../comun/z_ingdepbus2d.php?vopc=1">
                 <img src="../imagenes/solibusq.png" width="38px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=1><u><b>Solicite su B&uacute;squeda de Antecedentes Fon&eacute;tico/Gr&aacute;fico</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 4}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../comun/z_ingdepbus2dp.php?vopc=1">
                 <img src="../imagenes/solibusq.png" width="38px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=1><u><b>Prueba de B&uacute;squeda de Antecedentes Fon&eacute;tico/Gr&aacute;fico</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_reenvioweb.php?vopc=1">
				     <img src="../imagenes/sendenvio01.png" width="32%" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>Re Envio de Datos Solicitud B&uacute;squeda</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_consultra.php">
			       <img src="../imagenes/consulta.png" width="38%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2><u><b>Consulta de Tr&aacute;mite</b></u></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_contrarenv.php?vopc=1">
				     <img src="../imagenes/ubicar.png" width="30%" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Tr&aacute;mite y Reenvielo</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../comun/z_tramifm02.php?vopc=1">
                 <img src="../imagenes/iconosolnueva.png" width="26px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Informaci&oacute;n de Solicitud de Marcas o FM02</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}
 
              {if $nivel eq 1 || $nivel eq 4}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_solmarweb_deprueba.php?vopc=5">
				     <img src="../imagenes/iconosolnueva.png" width="28px" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>Prueba Llenado Planilla FM-02</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}
 
              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_solmarweb.php?vopc=5">
				     <img src="../imagenes/iconosolnueva.png" width="28px" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>Pre-carga Planilla FM-02</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_solmarweb2.php?vopc=5">
				     <img src="../imagenes/iconosolnueva.png" width="28px" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>Pre-carga Planilla FM-02 con 2 Depositos</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_solrenfm04.php?vopc=5">
				     <img src="../imagenes/iconosolnueva.png" width="28px" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>Pre-carga Renovaciones FM-04</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_solmarweb_mod.php?vopc=0">
				     <img src="../imagenes/iconosolnueva.png" width="28px" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>Modificar Pre-carga FM-02</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/m_enviofor.php">
			        <img src="../imagenes/imprimir.png" width="38px" align="middle" border="0" />
			        <span><font face="Arial" color="#000000" size=2><u><b>Imprimir FM-02 Pre-cargada</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 }
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/m_eveserv.php?vopc=1">
				     <img src="../imagenes/iconosolnueva.png" width="30%" align="middle" border="0" />
				     <span><font face="Arial" color="#000000" size=2><u><b>PreCarga de Escritos</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1 }
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../comun/m_controlcert.php?vopc=3">
		           <img src="../imagenes/certifyelectronic2.png" width="30%" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Tr&aacute;mite Certificado(s)</u></b></font><span>
		          </a>
		         </div>
              </div>
              {/if}

             </div>
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
    </ul>
   </li> 

   <li><a href="#">Patentes</a>
     <ul>
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>
         <table class="adminform">
          <tr>
           <td width="100%" valign="top">
             <div id="cpanel">

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
      	     <div style="float:left;">
		         <div class="icon">
		          <a href="../vpat/index_patentec_n.php">
		           <img src="../imagenes/busqpat.png" width="26px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>B&uacute;squeda Avanzada</u></b></font></span>
		          </a>
		         </div>
	           </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../consulta/p_consulta.php">
		           <img src="../imagenes/computadora.png" width="50px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}
       
             </div>
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
     </ul>
    </li> 

   <li><a href="#">Boletin</a>
     <ul>
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>


        </td>
       </tr>
      </table>
     </ul>
    </li> 

   <li><a href="#">Via Webpi</a>
     <ul>
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>
         <table class="adminform">
          <tr>
           <td width="100%" valign="top">
             <div id="cpanel">

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
      	     <div style="float:left;">
		         <div class="icon">
		          <a href="../vpat/index_patentec_n.php">
		           <img src="../imagenes/busqpat.png" width="26px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>B&uacute;squeda Avanzada</u></b></font></span>
		          </a>
		         </div>
	           </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../consulta/p_consulta.php">
		           <img src="../imagenes/computadora.png" width="50px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}
       
             </div>
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
     </ul>
    </li> 

    <li><a href="#">Derecho de Autor</a>
     <ul>
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>
         <table class="adminform">
          <tr>
           <td width="100%" valign="top">
             <div id="cpanel">

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../consulta/a_consulta.php">
		           <img src="../imagenes/computadora.png" width="50px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}
       
             </div>
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
     </ul>
   </li> 

   {if $nivel eq 1 || $nivel eq 2 || $nivel eq 5}
   <li><a href="#">Finanzas</a>
    <ul> 
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>
         <table class="adminform">
          <tr>
           <td width="100%" valign="top">
             <div id="cpanel">
    
              {if $nivel eq 1 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/m_enviobus.php">
			        <img src="../imagenes/generacionyenviodedatosdebusquedas.png" width="31%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2><u><b>Generaci&oacute;n y Env&iacute;o de Datos B&uacute;squedas</b></u></font></span>
		          </a>
		         </div>
              </div>
              {/if}
    
              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/m_enviobus2.php">
			        <img src="../imagenes/generacionyenviodedatosdebusquedas.png" width="31%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2><u><b>Re-Generaci&oacute;n TXT de Datos B&uacute;squedas</b><u></font></span>
		          </a>
		         </div>
              </div>
              {/if}
    
              {if $nivel eq 1 || $nivel eq 2}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/m_enviofac.php">
			        <img src="../imagenes/sendenvio01.png" width="26%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2><u><b>Generaci&oacute;n y Env&iacute;o de Datos a Facturaci&oacute;n</b></u></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1  || $nivel eq 2 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_rptbancario.php">
			        <img src="../imagenes/boton_ingresosbancarios.png"  width="28%" align="middle" border="0" />
			        <span><font face="Arial" color="#000000" size=2><b>Ingresos Bancarios</b></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1  || $nivel eq 2 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_rptservi.php">
			        <img src="../imagenes/boton_serviciossolicitados.png" width="28%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2><u><b>Reporte de Servicios Solicitados</b></u></font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_estadisticas.php">
			        <img src="../imagenes/estadisticaswebpi.png"  width="28%" align="middle" border="0" />
			        <span><font face="Arial" color="#000000" size=2>Estadisticas Portal Webpi</font></span>
		          </a>
		         </div>
              </div>
              {/if}
       
             </div>
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
    </ul>
   </li> 
   {/if}

   {if $nivel eq 1}
   <li><a href="#">Administrativos</a>
    <ul> 
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>
         <table class="adminform">
          <tr>
           <td width="100%" valign="top">
             <div id="cpanel">

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_bancos.php">
			        <img src="../imagenes/boton_banco2.png" width="44%" align="middle" border="0" />
			        <span><font face="Arial" color="#000000" size=2>Bancos</font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_tarifas.php">
			        <img src="../imagenes/boton_tarifas.png" width="44%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Tarifas</font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_plazos.php">
			        <img src="../imagenes/boton_plazos.png" width="42%" align="middle" border="0" />
			        <span><font face="Arial" color="#000000" size=2>Plazos  Vencimientos</font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_venctra.php?vopc=1">
			        <img src="../imagenes/boton_cancelacionservicios.png" width="44%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Cancelaci&oacute;n de Servicios</font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
			       <a href="../comun/z_usuario.php?vopc=1">
			        <img src="../imagenes/boton_usuarios.png" width="45%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Usuarios</font></span>
		          </a>
		         </div>
              </div>
              {/if}

              {if $nivel eq 1}
	           <div style="float:left;">
	            <div class="icon">
                <a href="../comun/z_rptuser.php">
			        <img src="../imagenes/boton_listadousuarios.png" width="32%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Listado de Usuarios</font></span>
		          </a>
		         </div>
              </div>
              {/if}
       
             </div>
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
    </ul>
   </li> 
   {/if}

   <li><a href="#">Mantenimiento</a>
     <ul>
      <table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
       <tr>
        <td>
         <table class="adminform">
          <tr>
           <td width="100%" valign="top">
             <div id="cpanel">

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
      	     <div style="float:left;">
		         <div class="icon">
		          <a href="../vpat/index_patentec_n.php">
		           <img src="../imagenes/busqpat.png" width="26px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>B&uacute;squeda Avanzada</u></b></font></span>
		          </a>
		         </div>
	           </div>
              {/if}

              {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5}
	           <div style="float:left;">
	            <div class="icon">
		          <a href="../consulta/p_consulta.php">
		           <img src="../imagenes/computadora.png" width="50px" align="middle" border="0" />
		           <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		          </a>
		         </div>
              </div>
              {/if}
       
             </div>
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
     </ul>
    </li> 

   <li><a href="../index.php">Salir</a>
   </li> 

 </ul>
 
 <p></p>

 
      </td>

      <td width="47%" valign="top">

        <table border="0" cellpadding="0" cellspacing="0">
          <td width="282px" height='170px' class="bienvenido">
            &nbsp;&nbsp;<b><font face="Verdana" size="2" >{$nombre}</font></b>
            <p></p>
            &nbsp;&nbsp;<font face="Arial" size="2" >El Webpi es la Oficina Virtual de <br/></font>
            &nbsp;&nbsp;<font face="Arial" size="2" >Propiedad Intelectual.</font>
            <p></p>
            <a href="../comun/z_actregistro.php?vcuenta={$login}&vopc=1">
	      &nbsp;<img src="../imagenes/datosuser_03.png" border="0">
	    </a>
            <p></p>
            <a href="../comun/z_actclave.php?vcuenta={$login}">
	      &nbsp;<img src="../imagenes/datosuser_08.png" border="0">
	    </a>
            <p></p>
            <p></p>
            <p></p>
         </td>
        </table> 

    </td>
  </tr>
 </table>

</div>

 
 
</body>
</html>
