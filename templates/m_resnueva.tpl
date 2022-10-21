<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
{if $tipo eq ""}
<form name="form" action="m_resnueva.php" method="POST">
  <table>
      <tr>
      <td class="izq-color">{$campo0}</td>
      <td class="der-color">{$campo01}
	<input type="image" width="20px" height="20px" alt="buscar" src="../imagenes/search.png" value="Guardar">
     </td>
     </tr>
    <tr>
 </table>
  <table width="255" >
  <tr>
    <td class="cnt">
	<a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>
 </form>
{/if}
{if $tipo neq ""}
<form name="form" action="m_resnueva2tpl.php" method="POST">
  <table>
      <tr>
      <td class="izq-color">{$campo0}</td>
      <td class="der-color">{$campo01}</td>	
    </tr>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
	<fieldset id="solicitud" style="border:0px">
	    <input type="button" value="Añadir Solicitud" onclick="crear(this)" /><br />
	</fieldset>
      </td>	
    </tr>
    <tr> 
      <td class="izq-color"> {$campo2}</td>
      <td class="der-color">
	<select class="validate-integer required" id="reg_lab" name="reg_lab" value="selected" onchange="VisiblePlantillas(this.value,'ley55','ley344');">
	     <option value="">[Seleccione]</option>        
	     <option value="1"  >Ley de Propiedad Industrial de 1955</option>                 
	     <option value="2"  >Comunidad Andina de Naciones (CAN)</option>					  
	 </select>
      </td>	
    </tr>
    
    <tr> 
     <td class="izq-color">{$campo3}</td>
     <td class="der-color">
     
     	<div id="ley344">
            <label>Ley por La Comunidad Andina de Naciones (CAN)</label><br/>
	    {section name=cont loop=$vnumrows}
 	    <input name="plantilla" id="plantilla" type="radio" value ="{$plantid1[cont]}" /> {$nombre[cont]}<br/>
	    <label>{$descripcion[cont]}</label>
	    <br/>  
	    {/section} 
        </div>

  
     	<div id="ley55">
            <label>Ley de Propiedad Indstrial de 1955</label><br/>
	    {section name=cont loop=$vnumrows2}
 	    <input name="plantilla" id="plantilla" type="radio" value ="{$plantid2[cont]}" /> {$nombre2[cont]}<br/>
	    <label>{$descripcion2[cont]}</label>
	    <br/>  
	    {/section} 
        </div>

	

     </td>        
    </tr>
 </table>

  <table width="255" >

  <tr>
    <td class="cnt">
	<input type="image" src="../imagenes/siguiente.gif" value="Guardar">Siguiente</td> 
    <td class="cnt">
	<a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>

 </form>
{/if}
</div>
</body>
</html>
