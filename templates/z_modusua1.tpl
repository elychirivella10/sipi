<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forusing1" action="z_modusua1.php?vopc=2" method="POST" onsubmit="return pregunta();">  
  <input type='hidden' name='idvalor' value='{$idvalor}'> 
  <input type='hidden' name='vstring' value='{$vstring}'>
  <input type='hidden' name='usuario' value='{$login}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='na_conex' value='{$na_conex}'>
  <input type='hidden' name='conx' value=0>
  <input type='hidden' name='salir' value=0> 

  <div align="center">
    
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='cedula' value='{$cedula}' size="8" maxlength="8" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,8,document.forusing1.nombre)" {$modo2} >&nbsp;
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' {$modo2} size='60' maxlength="60" onKeyPress="return acceptChar(event,0, this)" onkeyup="checkLength(event,this,60,document.forusing1.email)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type='text' name='email' value='{$email}' {$modo2} size='50' maxlength="50"></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type='text' name='usuario' value='{$usuario}' {$modo2} size="12" maxlength="12" onKeyPress="return acceptChar(event,3, this)">
      </td>
    </tr>
    <td class="izq-color" >{$campo7}</td>
      <td class="der-color" >
        <select size='1' name='depto_id' '{$modo2}'>
          {html_options values=$arraydepto selected=$depto_id output=$arraynombre}
        </select>
    </td>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
         <select size='1' name='sede'>
          {html_options values=$vcodsede selected=$sede output=$vnomsede}
         </select>
      </td>
    </tr>          
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" >
        {html_radios name="estado" values=$est_ids selected=$estado output=$est_def separator="<br />"}
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table width="350" >
  <tr>
    <td class="cnt">
      <a href="../comun/z_genpaswd.php?ced={$cedula}&nom={$nombre}&usr={$usuario}&email={$email}"><img src="../imagenes/security_f2.png" border="0" /></a>Generar Password</td>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td>
    <td class="cnt">
      <a href="../comun/z_usuarios.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
  
</div>  
</form>

</body>
</html>
