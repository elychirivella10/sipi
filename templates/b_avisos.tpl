<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<script type="text/javascript" src="../fckeditor/fckeditor.js"></script>


</script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
      
{if $vopc eq 3}
  <form name="forboletin1" id="forboletin1" action="b_avisosing.php?vopc=4" method="post">
 
{/if}
{if $vopc eq 5}
  <form name="forboletin1" id="forboletin1" action="b_avisomod.php" method="post">
{/if} 

  

  <table>
    {if $vopc eq 5}
      <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color" >
        <select size='1' name='titulo'>
          {html_options values=$arrayestatus selected=$titulo output=$arraydescri1}
        </select>

   {/if}
   {if $vopc eq 3}
  <tr>  
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="titulo" size="60" maxlength="300" value='{$titulo}' {$modo} >
       
      {/if}
      
      {if $vopc eq 3}
        <td class="cnt">
          <input type="image" src="../imagenes/note_f2.png" width="32" height="24" value="Crear Documento">Ingresar </td>   
        </form>
      {/if}
      {if $vopc eq 5}
        <td class="cnt">
  	<input type='image' src="../imagenes/search_f2.png" width="32" height="26" value="Buscar">  Buscar          </td>
        </form>
      {/if} 		  
      
      
      </td>
    </tr>
  </tr>
  </table>
  <br >
   <br >
  <br >
    <table width="200">
        <tr>
  {if $vopc eq 3}
        <td class="cnt"><a href="b_avisos.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
  {/if}
    {if $vopc eq 5}
        <td class="cnt"><a href="b_avisos.php?vopc=5&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
  {/if}
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
            </a>Salir</td>
	</tr>
     </table>

&nbsp;
</body>
</html>
