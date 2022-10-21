<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">
<form name="frmstatus1" action="busqpdf.php?vopc=2" method="POST">
  <table>
   <tr><td class="izq-color">IP Maquina Local: </td>
       <td class="der-color"><select size=1 name="vtip">
	        {html_options values=$vtip selected=1 output=$vtip}
       </select></td>
       {if $vopc eq 1}
       <td class="cnt"><input type="image" src="../imagenes/file_f2.png" 
            value="Buscar">Convertir Archivos a PDF</td> 
       {/if}
   </tr>
  </table> 
  
</form>
<form name="frmstatus2" action="busqpdf.php?vopc=3" method="POST">
  {if $vopc eq 2}
  <input type="hidden" name="iploc" value="{$iploc}">  
  <table><tr><td>Directorio: <b>{$dir_local}</b></td></tr></table>
  <table><tr><td>Total de Archivos Transformados a PDF: <b>{$total_file}</b></td></tr></table>
  &nbsp;&nbsp;
  <table border='2'>
    <tr>
    {section name=numloop loop=$elementos}
        <td width="25%">{$elementos[numloop]}</td>
        {if not ($smarty.section.numloop.rownum mod $cols)}
                {if not $smarty.section.numloop.last}
                        </tr><tr>
                {/if}
        {/if}
        {if $smarty.section.numloop.last}
                {* creamos las celdas vacias que toquen *}
                {math equation = "n - a % n" n=$cols a=$elementos|@count
assign="cells"}
                {if $cells ne $cols}
                {section name=pad loop=$cells}
                        <td width="25%"> </td>
                {/section}
                {/if}
                </tr>
        {/if}
    {/section}
  </table>
  {/if}
  &nbsp;
     <table width="50%">
        <tr>
        {if $vopc eq 2 and $total_file>0}
   <!--     <td class="cnt"><input type="image" src="../imagenes/reload_f2.png" 
            value="Guardar">Transferir Archivos</td> > -->
        {/if}
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
            </a>Salir</td>
	</tr>
     </table>
</form>				  
</div>  
</body>
</html>
