<!-- Tipos de Usuarios:              -->
<!-- 1.- Administradores             -->
<!-- 2.- Finanza                     -->
<!-- 3.- Todos los Usuarios Externos -->
<!-- 4.- Taquillero SAPI             -->
<!-- 5.- Castiella Velazquez         -->
<!-- 6.- Propuesta Usuarios Externos -->
<!-- 9.- Tipo Usuario 3 con Estadisticas -->

<table border="0" celspadding="0" collspadding="0" aling="center" class="cuerpo">
<tr>
<td>

   <table class="adminform">

    <tr >
      <td width="690px" class="nombreusr" >
        <p align="left">Usuaria(o):&nbsp;{$login}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {$fechahoy}</p>
      </td>
    </tr>

    <tr>
      <td width="68%" valign="top">
        <!-- =================================================================================================== -->
        <!-- MENU DE MARCAS -->
        <!-- &nbsp;<a href="../ayuda/concedidas_550.pdf" target="blank"><img src="imagenes/topewebbol.png" border="0"></a> -->
        &nbsp;<img src="imagenes/itemmarcas_03.png" border="0">

        <div id="cpanel">
          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
		<div class="icon">
		  <a href="comun/calculadora.php" title="C&aacute;lculo de Costo Servicio(s)">
		    <!-- <img src="imagenes/calculator_edit.png" align="middle" border="0" /> 
		    <img src="imagenes/botonmarcasroll_03.png" width="130px" align="middle" border="0" /> -->
                    <img src="imagenes/calculo.png" width="26px" align="middle" border="0" />
                    <span><font face="Arial" color="#000000" size=2><u><b>C&aacute;lculo de Costo Servicio(s)</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
		<div class="icon">
		  <a href="consulta/indexbt_n.php">
		    <!--<img src="imagenes/report_magnify.png" width="35%" align="middle" border="0" />
                    <img src="imagenes/botonmarcasroll_05.png" width="112px" align="middle" border="0" /> -->
                    <img src="imagenes/busqueda1.png" width="42px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><b><u>B&uacute;squeda Gramatical</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}
	    
          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
		<div class="icon">
		  <a href="comun/m_busclase.php?vopc=1" title="B&uacute;squeda de Clase(s) seg&uacute;n palabra">
		    <!--<img src="imagenes/busqueda.png" width="35%" align="middle" border="0" />
		    <img src="imagenes/botonmarcasroll_07.png" width="112px" align="middle" border="0" /> -->
		    <img src="imagenes/ubicar.png" width="40px" align="middle" border="0" />
                    <span><font face="Arial" color="#000000" size=2><u><b>Ubique la Clase de su Marca</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

      <!-- {if $nivel eq 1 || $nivel eq 3}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_enviodoc.php">
			  <img src="imagenes/printmgr.png" align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2>Envio de Documentos Marcas</font></span>
			 </a>
			</div>
		  </div>
          {/if} --> 

       <!-- {if $nivel eq 1 || $nivel eq 3}
	    <div style="float:left;">
		<div class="icon">
		  <a href="comun/z_servicios.php">
		    <img src="imagenes/consulta.png" width="48px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Consulta de Servicios</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if} -->

          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
	        <div class="icon">
		  <a href="consulta/m_consulta.php">
		    <!-- <img src="imagenes/book_open.png" width="35%" align="middle" border="0" />
		    <img src="imagenes/botonmarcasroll_24.png" width="162px" align="middle" border="0" /> -->
		    <img src="imagenes/computadora.png" width="50px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
		<div class="icon">
		  <a href="certificado/indexc.php">
		    <img src="imagenes/certifyelectronic2.png" width="26%" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Certificado Electr&oacute;nico Marcas</u></b></font><span>
		  </a>
		</div>
	    </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
		<div class="icon">
		  <a href="comun/z_tramibusq.php?vopc=1">
          <img src="imagenes/solibusq.png" width="38px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Informaci&oacute;n sobre B&uacute;squeda Fon&eacute;tica/Gr&aacute;fica</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
		<div class="icon">
		  <a href="comun/z_ingdepbus.php?vopc=1">
          <img src="imagenes/solibusq.png" width="38px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Solicite su B&uacute;squeda Fon&eacute;tica/Gr&aacute;fica</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 6}
	    <div style="float:left;">
		<div class="icon">
		  <a href="comun/z_updtramite.php?vopc=1">
		    <img src="imagenes/solibusq.png" width="38px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Modificaci&oacute;n Solicitud B&uacute;squeda</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if} 

          {if $nivel eq 1 || $nivel eq 4 || $nivel eq 6}
		  <div style="float:left;">
			<div class="icon">
			  <a href="comun/z_reenvioweb.php?vopc=1">
				<img src="imagenes/sendenvio01.png" width="32%" align="middle" border="0" />
				<span><font face="Arial" color="#000000" size=2><u><b>Re Envio de Datos Solicitud B&uacute;squeda</u></b></font></span>
			  </a>
			</div>
		  </div>
        {/if} 

          {if $nivel eq 1 || $nivel eq 4 || $nivel eq 6}
		  <div style="float:left;">
			<div class="icon">
			  <a href="comun/z_prensaweb.php?vopc=1">
				<img src="imagenes/publiprensa.png" width="32%" align="middle" border="0" />
				<span><font face="Arial" color="#000000" size=2><u><b>Solicite su Publicaci&oacute;n en Prensa</u></b></font></span>
			  </a>
			</div>
		  </div>
        {/if} 

          {if $nivel eq 1 || $nivel eq 4 || $nivel eq 6}
		  <div style="float:left;">
			<div class="icon">
			  <a href="comun/z_solmarweb.php?vopc=5">
				<img src="imagenes/publiprensa.png" width="32%" align="middle" border="0" />
				<span><font face="Arial" color="#000000" size=2><u><b>Solicitud de Marcas</u></b></font></span>
			  </a>
			</div>
		  </div>
        {/if} 
		
        {if $nivel eq 1 || $nivel eq 4 || $nivel eq 6}
		  <div style="float:left;">
			<div class="icon">
			  <a href="comun/z_solmarweb_mod.php?vopc=0">
				<img src="imagenes/application_form.png" align="middle" border="0" />
				<span><font face="Arial" color="#000000" size=2><u><b>Modificaci&oacute;n Solicitud de Marcas</u></b></font></span>
			  </a>
			</div>
		  </div>
        {/if} 
  
         {if $nivel eq 1 || $nivel eq 4 || $nivel eq 6}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/m_enviofor.php">
			  <img src="imagenes/imprimirprint.png" width="28%" align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2><u><b>Imprimir Formulario de Marcas</u></b></font></span>
			 </a>
			</div>
		  </div>
          {/if}

        {if $nivel eq 1 }
		  <div style="float:left;">
			<div class="icon">
			  <a href="comun/m_eveserv.php?vopc=1">
				<img src="imagenes/iconosolnueva.png" width="30%" align="middle" border="0" />
				<span><font face="Arial" color="#000000" size=2><u><b>PreCarga de Escritos</u></b></font></span>
			  </a>
			</div>
		  </div>
        {/if}

          {if $nivel eq 1 }
	    <div style="float:left;">
		<div class="icon">
		  <a href="comun/m_controlcert.php?vopc=3">
		    <img src="imagenes/certifyelectronic2.png" width="30%" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Tr&aacute;mite Certificado(s)</u></b></font><span>
		  </a>
		</div>
	    </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 5}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/m_rptpclase.php">
			  <img src="imagenes/imprimirprint.png" width="30%" align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2><u><b>Listado de Productos</u></b></font></span>
			 </a>
			</div>
		  </div>
          {/if}

        </div>

        <!-- =================================================================================================== -->
        <!-- MENU DE PATENTES -->
        &nbsp;<img src="imagenes/itempatentes_03.png" border="0">

        <div id="cpanel">
          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
		<div class="icon">
		  <a href="vpat/index_patentec_n.php">
		    <!-- <img src="imagenes/find.png" width="25%" align="middle" border="0" />
		    <img src="imagenes/patentesbus_roll.png" width="175px" align="middle" border="0" /> -->
		    <img src="imagenes/busqpat.png" width="26px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>B&uacute;squeda Avanzada de Patente</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
	        <div class="icon">
		  <a href="consulta/p_consulta.php">
		    <!-- <img src="imagenes/book_open.png" width="35%" align="middle" border="0" />
		    <img src="imagenes/botonmarcasroll_24.png" width="162px" align="middle" border="0" /> -->
		    <img src="imagenes/computadora.png" width="50px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

        </div>

        <!-- =================================================================================================== -->
        <!-- MENU DE DERECHO DEAUTOR -->
        &nbsp;<img src="imagenes/itemderechodeautor_03.png" border="0">

        <div id="cpanel">
          {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
	    <div style="float:left;">
	        <div class="icon">
		  <a href="consulta/a_consulta.php">
		    <!-- <img src="imagenes/book_open.png" width="35%" align="middle" border="0" />
		    <img src="imagenes/botonmarcasroll_24.png" width="162px" align="middle" border="0" /> -->
		    <img src="imagenes/computadora.png" width="50px" align="middle" border="0" />
		    <span><font face="Arial" color="#000000" size=2><u><b>Consulte su Solicitud</u></b></font></span>
		  </a>
		</div>
	    </div>
          {/if}

        <!--  {if $nivel eq 1 || $nivel eq 3 || $nivel eq 4 || $nivel eq 5 || $nivel eq 6 || $nivel eq 9}
		  <div style="float:left;">
			<div class="icon">
			  <a href="certificado/index_dnda.php">
				<img src="imagenes/certifyelectronic2.png" width="26%" align="middle" border="0" />
				<span><font face="Arial" color="#000000" size=2><u><b>Certificado Electr&oacute;nico de Obras</u></b></font></span>
			  </a>
			</div>
		  </div>
          {/if} -->

        </div>

        <!-- =================================================================================================== -->

        <!-- MENU DE FINANZAS -->
        {if $nivel eq 1 || $nivel eq 2 || $nivel eq 9}
         <img src="imagenes/admin_webpi_11.png" border="0">
        {/if}

        <div id="cpanel">
          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
  			 <a href="comun/z_rptverifica.php">
			  <img src="imagenes/verificaciondepagos.png" width="38%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Verificaci&oacute;n de Pagos</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/m_enviobus.php">
			  <img src="imagenes/generacionyenviodedatosdebusquedas.png" width="31%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Generaci&oacute;n y Env&iacute;o de Datos B&uacute;squedas</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/m_enviobus2.php">
			  <img src="imagenes/generacionyenviodedatosdebusquedas.png" width="31%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Generaci&oacute;n TXT de Datos B&uacute;squedas</font></span>
			 </a>
			</div>
		  </div>
          {/if}
		  
          {if $nivel eq 1 || $nivel eq 2}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/m_enviofac.php">
			  <img src="imagenes/sendenvio01.png" width="26%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Generaci&oacute;n y Env&iacute;o de Datos a Facturaci&oacute;n</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1  || $nivel eq 2}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_rptbancario.php">
			  <img src="imagenes/boton_ingresosbancarios.png"  width="28%" align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2>Ingresos Bancarios</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 9}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_estadisticas.php">
			  <img src="imagenes/estadisticaswebpi.png"  width="28%" align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2>Estadisticas Portal Webpi</font></span>
			 </a>
			</div>
		  </div>
          {/if}

        </div>

        <!-- =================================================================================================== -->
        <!-- MENU DE ADMINISTRACION GENERAL -->
        {if $nivel eq 1}
        &nbsp;<img src="imagenes/618_11.png" border="0">
        {/if}

        <div id="cpanel">
          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_bancos.php">
			  <img src="imagenes/boton_banco2.png" width="44%" align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2>Bancos</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_tarifas.php">
			  <img src="imagenes/boton_tarifas.png" width="44%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Tarifas</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_plazos.php">
			  <img src="imagenes/boton_plazos.png" width="42%" align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2>Plazos  Vencimientos</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_venctra.php?vopc=1">
			  <img src="imagenes/boton_cancelacionservicios.png" width="44%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Cancelaci&oacute;n de Servicios</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1 || $nivel eq 2}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_rptservi.php">
			  <img src="imagenes/boton_serviciossolicitados.png" width="28%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Reporte de Servicios Solicitados</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_usuario.php?vopc=1">
			  <img src="imagenes/boton_usuarios.png" width="45%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Usuarios</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          {if $nivel eq 1}
		  <div style="float:left;">
			<div class="icon">
			 <a href="comun/z_rptuser.php">
			  <img src="imagenes/boton_listadousuarios.png" width="32%" align="middle" border="0" /><span><font face="Arial" color="#000000" size=2>Listado de Usuarios</font></span>
			 </a>
			</div>
		  </div>
          {/if}

          <!-- {if $nivel eq 1 || $nivel eq 2 || $nivel eq 3}
		  <div style="float:left;">
			<div class="icon">
			 <a href="index.php">
			  <img src="imagenes/salir_f2.png"  align="middle" border="0" />
			  <span><font face="Arial" color="#000000" size=2>Salir de la Aplicaci&oacute;n</font></span>
			 </a>
			</div>
		  </div>
          {/if} -->

        </div>

      </td>

      <td width="47%" valign="top">

        <table border="0" cellpadding="0" cellspacing="0">
          <td width="282px" height='170px' class="bienvenido">
            &nbsp;&nbsp;<b><font face="Verdana" size="2" >{$nombre}</font></b>
            <p></p>
            &nbsp;&nbsp;<font face="Arial" size="2" >El Webpi es la Oficina Virtual de <br/></font>
            &nbsp;&nbsp;<font face="Arial" size="2" >Propiedad Intelectual.</font>
            <p></p>
            <a href="comun/z_actregistro.php?vcuenta={$login}&vopc=1">
	      &nbsp;<img src="imagenes/datosuser_03.png" border="0">
	    </a>
            <p></p>
            <a href="comun/z_actclave.php?vcuenta={$login}">
	      &nbsp;<img src="imagenes/datosuser_08.png" border="0">
	    </a>
            <p></p>
            <p></p>
            <p></p>
         </td>
        </table> 

      <p></p>
      <table border="0" cellpadding="0" cellspacing="0" aling="center">
        <td width="280px" height='170px' >
          <img src="../imagenes/boletinweb.png" width="286px" height="200px">
        </td>
      </table> 

      <p></p>
      <table border="0" cellpadding="0" cellspacing="0" aling="center">
        <td width="280px" height='170px' >
          <a href="../ayuda/concedidas_553.pdf" target="blank"><img src="../imagenes/marcasconcedidas.png" width="286px" height="200px"></a>
        </td>
      </table> 

      <p></p>
      <table border="0" cellpadding="0" cellspacing="0" aling="center">
        <td width="280px" height='135px' >
          <a href="../imagenes/ayudamainmenu_03.png" target="blank"><img src="../imagenes/nuevocardenalestoyaqui.png" width="286px" height="144px"></a>
        </td>
      </table> 

      <!-- <p></p> class="ayuda"
      <table border="0" cellpadding="0" cellspacing="0">
        <td width="282px" height='170px' class="recuerde"></td>
      </table> --> 

    </td>
  </tr>
 </table>


