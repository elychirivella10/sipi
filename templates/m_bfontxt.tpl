<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<form name="formarcas1" action="m_bfontxt2.php?cmd=scp -P 3535 /apl/pedidosexternos/pedidos_tu1.txt tunica@192.8.18.70:/home/tunica/" method="POST">
  <table>
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input class="required" type="text" name="pedido1" size="6" maxlength="6"> y 
        <input class="required" type="text" name="pedido2" size="6" maxlength="6">
        </td>	
      <td class="cnt">
      &nbsp;&nbsp;<input type="image" src="../imagenes/search_f2.png" width="32" height="24" value="Nueva Solicitud">Buscar  
      </td>
    </tr>
  </tr>
  </table>
 </form>
</div>
<div align="center">
<form name="formarcas2" enctype="multipart/form-data"  action="m_bfontxt2.php?cmd=scp /apl/pedidosexternos/pedidos_tu1.txt tunica@192.8.18.70:/home/tunica/" method="POST">
  <table>
    <tr>
      <td class="izq5-color">{$campo2}</td>
      <td class="der-color">
        
         <input class="required"  tabindex="3" type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar53');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>         
        </td>	
      <td class="cnt">
       &nbsp;&nbsp;<input type="image" src="../imagenes/search_f2.png" width="32" height="24" value="Nueva Solicitud">Buscar  
      </td>
    </tr>
  </tr>
  </table>
 </form>
</div>
<div align="center">
<form name="formarcas1" action="m_bfontxt2.php?cmd=scp /apl/pedidosexternos/pedidos_tu1.txt tunica@192.8.18.70:/home/tunica/" method="POST">
  <table>
    <tr>
      <td class="izq5-color">{$campo3}</td>
      <td class="der-color">    
         <select size="1" name="options">
          {html_options values=$vcodsede selected=$vsede output=$vnomsede|truncate:15}
         </select>                
        </td>	
      <td class="cnt">
       &nbsp;&nbsp;<input type="image" src="../imagenes/search_f2.png" width="32" height="24" value="Nueva Solicitud">Buscar  
      </td>
    </tr>
  </tr>
  </table>
 </form>
</div>
<div align="center">
<a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir 
</div>
</body>
</html>
