<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.close();
 }

function ayudaclase(var1) {
  open("ayuda_clase.php?vclas="+var1.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no","replace=false"); }

function gestionviena(var1,var2,var3,var4) {
  open("adm_codviena.php?vfac="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vimg="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function trim1(cad)  
{  
  return cad.replace(/^\s+|\s+$/g,"");  
}  

function ltrim(cad)  
{  
  return cad.replace(/^\s+/,"");  
}  

function rtrim(cad)  
{  
  return cad.replace(/\s+$/,"");  
}  

function trim(myString)
{
  return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

</script>

<script LANGUAGE="JavaScript">

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

function checkAll() {
for (var j = 1; j <= 47; j++) {
box = eval("document.formclase.clase" + j); 
if (box.checked == false) box.checked = true;
   }
document.formclase.incluir.disabled=false
}

function uncheckAll() {
contador=0;
for (var j = 1; j <= 47; j++) {
box = eval("document.formclase.clase" + j); 
if (box.checked == true) box.checked = false;
   }
document.formclase.incluir.disabled=true
}

function switchAll() {
for (var j = 1; j <= 47; j++) {
box = eval("document.formclase.clase" + j); 
box.checked = !box.checked;
   }
}

function RecorrerForm(){
  var frm=document.formclase;
  for (i=0;i<document.formclase.elements.length;i++)
  {
    tipo = frm.elements[i].type;  
    nombre = frm.elements[i].name;
    if ((tipo=='text') && (nombre!='factura') && (nombre!='vtex') && (nombre!='vclas')) {
      frm.elements[i].value = '';
      frm.elements[i].style.backgroundColor="#DCDCDC";
    }
    if ((tipo=='button') && (nombre!='todos2') && (nombre!='incluir') && (nombre!='salir')) {
      frm.elements[i].style.backgroundColor="#DCDCDC";
      frm.elements[i].style.color="#000000";
    }
  }
}


function activar(formulario) {  
     formulario.archivo.disabled = false  
} 


function desactivar(formulario) {  
     formulario.archivo.disabled = true  
} 

function ayudaclas(claseval) {
  if(claseval.value=='01') {
    alert("CLASE 1: Productos químicos para la industria, la ciencia y la fotografía, así como para la agricultura, la horticultura y la silvicultura; resinas artificiales en bruto, materias plásticas en bruto; abonos para el suelo; composiciones extintoras; preparaciones para templar y soldar metales; productos químicos para conservar alimentos; materias curtientes; adhesivos (pegamentos) para la industria."); }
  else if(claseval.value=='02') {
    alert("CLASE 2: Pinturas, barnices, lacas; productos antioxidantes y productos para conservar la madera; materias tintóreas; mordientes; resinas naturales en bruto; metales en hojas y en polvo para pintores, decoradores, impresores y artistas."); }
  else if(claseval.value=='03') {
    alert("CLASE 3: Preparaciones para blanquear y otras sustancias para lavar la ropa; preparaciones para limpiar, pulir, desengrasar y raspar; jabones; productos de perfumería, aceites esenciales, cosméticos, lociones capilares; dentífricos."); }
  else if(claseval.value=='04') {
    alert("CLASE 4: Aceites y grasas para uso industrial; lubricantes; productos para absorber, rociar y asentar el polvo; combustibles (incluida la gasolina para motores) y materiales de alumbrado; velas y mechas de iluminación."); }
  else if(claseval.value=='05') {
    alert("CLASE 5: Productos farmacéuticos y veterinarios; productos higiénicos y sanitarios para uso médico; sustancias dietéticas para uso médico, alimentos para bebés; emplastos, material para apósitos; material para empastes e improntas dentales; desinfectantes; productos para eliminar animales dañinos; fungicidas, herbicidas."); }
  else if(claseval.value=='06') {
    alert("CLASE 6: Metales comunes y sus aleaciones; materiales de construcción metálicos; construcciones transportables metálicas; materiales metálicos para vías férreas; cables e hilos metálicos no eléctricos; artículos de cerrajería y ferretería metálicos; tubos y tuberías metálicos; cajas de caudales; productos metálicos no comprendidos en otras clases; minerales metalíferos."); }
  else if(claseval.value=='07') {
    alert("CLASE 7: Máquinas y máquinas herramientas; motores (excepto motores para vehículos terrestres); acoplamientos y elementos de transmisión (excepto para vehículos terrestres); instrumentos agrícolas que no sean accionados manualmente; incubadoras de huevos."); }
  else if(claseval.value=='08') {
    alert("CLASE 8: Herramientas e instrumentos de mano accionados manualmente; artículos de cuchillería, tenedores y cucharas; armas blancas; navajas y maquinillas de afeitar."); }
  else if(claseval.value=='09') {
    alert("CLASE 9: Aparatos e instrumentos científicos, náuticos, geodésicos, fotográficos, cinematográficos, ópticos, de pesaje, de medición, de señalización, de control (inspección), de salvamento y de enseñanza; aparatos e instrumentos de conducción, distribución, transformación, acumulación, regulación o control de la electricidad; aparatos de grabación, transmisión o reproducción de sonido o imágenes; soportes de registro magnéticos, discos acústicos; distribuidores automáticos y mecanismos para aparatos de previo pago; cajas registradoras, máquinas de calcular, equipos de procesamiento de datos y ordenadores; extintores."); }
  else if(claseval.value=='10') {
    alert("CLASE 10: Aparatos e instrumentos quirúrgicos, médicos, odontológicos y veterinarios, así como miembros, ojos y dientes artificiales; artículos ortopédicos; material de sutura."); }
  else if(claseval.value=='11') {
    alert("CLASE 11: Aparatos de alumbrado, calefacción, producción de vapor, cocción, refrigeración, secado, ventilación y distribución de agua, así como instalaciones sanitarias."); }
  else if(claseval.value=='12') {
    alert("CLASE 12: Vehículos; aparatos de locomoción terrestre, aérea o acuática."); }
  else if(claseval.value=='13') {
    alert("CLASE 13: Armas de fuego; municiones y proyectiles; explosivos; fuegos artificiales."); }
  else if(claseval.value=='14') {
    alert("CLASE 14: Metales preciosos y sus aleaciones, así como productos de estas materias o chapados no comprendidos en otras clases; artículos de joyería, bisutería, piedras preciosas; artículos de relojería e instrumentos cronométricos."); }
  else if(claseval.value=='15') {
    alert("CLASE 15: Instrumentos musicales."); }
  else if(claseval.value=='16') {
    alert("CLASE 16: Papel, cartón y artículos de estas materias no comprendidos en otras clases; productos de imprenta; material de encuadernación; fotografías; artículos de papelería; adhesivos (pegamentos) de papelería o para uso doméstico; material para artistas; pinceles; máquinas de escribir y artículos de oficina (excepto muebles); material de instrucción o material didáctico (excepto aparatos); materias plásticas para embalar (no comprendidas en otras clases); caracteres de imprenta; clichés de imprenta."); }
  else if(claseval.value=='17') {
    alert("CLASE 17: Caucho, gutapercha, goma, amianto, mica y productos de estas materias no comprendidos en otras clases; productos de materias plásticas semielaborados; materiales para calafatear, estopar y aislar; tubos flexibles no metálicos."); }
  else if(claseval.value=='18') {
    alert("CLASE 18: Cuero y cuero de imitación, productos de estas materias no comprendidos en otras clases; pieles de animales; baúles y maletas; paraguas, sombrillas y bastones; fustas y artículos de guarnicionería."); }
  else if(claseval.value=='19') {
    alert("CLASE 19: Materiales de construcción no metálicos; tubos rígidos no metálicos para la construcción; asfalto, pez y betún; construcciones transportables no metálicas; monumentos no metálicos."); }
  else if(claseval.value=='20') {
    alert("CLASE 20: Muebles, espejos, marcos; productos de madera, corcho, caña, junco, mimbre, cuerno, hueso, marfil, ballena, concha, ámbar, nácar, espuma de mar, sucedáneos de todos estos materiales o de materias plásticas, no comprendidos en otras clases."); }
  else if(claseval.value=='21') {
    alert("CLASE 21: Utensilios y recipientes para uso doméstico y culinario; peines y esponjas; cepillos; materiales para fabricar cepillos; material de limpieza; lana de acero; vidrio en bruto o semielaborado (excepto el vidrio de construcción); artículos de cristalería, porcelana y loza no comprendidos en otras clases."); }
  else if(claseval.value=='22') {
    alert("CLASE 22: Cuerdas, cordeles, redes, tiendas de campaña, lonas, velas de navegación, sacos y bolsas (no comprendidos en otras clases); materiales de acolchado y relleno (excepto elcaucho o las materias plásticas); materias textiles fibrosas en bruto."); } 
  else if(claseval.value=='23') {
    alert("CLASE 23: Hilos para uso textil."); }
  else if(claseval.value=='24') {
    alert("CLASE 24: Tejidos y productos textiles no comprendidos en otras clases; ropa de cama y de mesa."); }
  else if(claseval.value=='25') {
    alert("CLASE 25: Prendas de vestir, calzado, artículos de sombrerería."); }
  else if(claseval.value=='26') {
    alert("CLASE 26: Encajes y bordados, cintas y cordones; botones, ganchos y ojetes, alfileres y agujas; flores artificiales."); }
  else if(claseval.value=='27') {
    alert("CLASE 27: Alfombras, felpudos, esteras, linóleo y otros revestimientos de suelos; tapices murales que no sean de materias textiles."); }
  else if(claseval.value=='28') {
    alert("CLASE 28: Juegos y juguetes; artículos de gimnasia y deporte no comprendidos en otras clases; adornos para árboles de Navidad."); }
  else if(claseval.value=='29') {
    alert("CLASE 29: Carne, pescado, carne de ave y carne de caza; extractos de carne; frutas y verduras, hortalizas y legumbres en conserva, congeladas, secas y cocidas; jaleas, confituras, compotas; huevos, leche y productos lácteos; aceites y grasas comestibles."); }
  else if(claseval.value=='30') {
    alert("CLASE 30: Café, té, cacao, azúcar, arroz, tapioca, sagú, sucedáneos del café; harinas y preparaciones a base de cereales, pan, productos de pastelería y de confitería, helados; miel, jarabe de melaza; levadura, polvos de hornear; sal, mostaza; vinagre, salsas (condimentos); especias; hielo."); }
  else if(claseval.value=='31') {
    alert("CLASE 31: Productos agrícolas, hortícolas, forestales y granos, no comprendidos en otras clases; animales vivos; frutas y verduras, hortalizas y legumbres frescas; semillas, plantas y flores naturales; alimentos para animales; malta."); }
  else if(claseval.value=='32') {
    alert("CLASE 32: Cerveza; aguas minerales y gaseosas, y otras bebidas sin alcohol; bebidas de frutas y zumos de frutas; siropes y otras preparaciones para elaborar bebidas."); }
  else if(claseval.value=='33') {
    alert("CLASE 33: Bebidas alcohólicas (excepto cerveza)."); }
  else if(claseval.value=='34') {
    alert("CLASE 34: Tabaco; artículos para fumadores; cerillas."); }
  else if(claseval.value=='35') {
    alert("CLASE 35: Publicidad; gestión de negocios comerciales; administración comercial; trabajos de oficina."); }
  else if(claseval.value=='36') {
    alert("CLASE 36: Seguros; operaciones financieras; operaciones monetarias; negocios inmobiliarios."); }
  else if(claseval.value=='37') {
    alert("CLASE 37: Servicios de construcción; servicios de reparación; servicios de instalación."); }
  else if(claseval.value=='38') {
    alert("CLASE 38: Telecomunicaciones."); }
  else if(claseval.value=='39') {
    alert("CLASE 39: Transporte; embalaje y almacenamiento de mercancías; organización de viajes."); }
  else if(claseval.value=='40') {
    alert("CLASE 40: Tratamiento de materiales."); }
  else if(claseval.value=='41') {
    alert("CLASE 41: Educación; formación; servicios de entretenimiento; actividades deportivas y culturales."); }
  else if(claseval.value=='42') {
    alert("CLASE 42: Servicios científicos y tecnológicos, así como servicios de investigación y diseño en estos ámbitos; servicios de análisis e investigación industriales; diseño y desarrollo de equipos informáticos y de software."); }
  else if(claseval.value=='43') {
    alert("CLASE 43: Servicios de restauración (alimentación); hospedaje temporal."); }
  else if(claseval.value=='44') {
    alert("CLASE 44: Servicios médicos; servicios veterinarios; tratamientos de higiene y de belleza para personas o animales; servicios de agricultura, horticultura y silvicultura."); }
  else if(claseval.value=='45') {
    alert("CLASE 45: Servicios jurídicos; servicios de seguridad para la protección de bienes y personas; servicios personales y sociales prestados por terceros para satisfacer necesidades individuales."); }
  else if(claseval.value=='NC') {
    alert("CLASE NC: Nombre Comercial"); }
  else if(claseval.value=='LC') {
    alert("CLASE LC: Lema Comercial"); }
}

function checkplan(check,box,boton) {
  if (check.checked==true){
    boton.style.backgroundColor="#800000";
    boton.style.color="#FFFFFF";
    box.style.backgroundColor="#33CCFF";
    box.disabled = false;
    box.focus(); }
  else {  
    boton.style.backgroundColor="#DCDCDC";
    boton.style.color="#000000";
    box.style.backgroundColor="#DCDCDC";
    box.disabled = true; 
    box.value = ""; }
}  

  
function validarimg(f)	{
				enviar = /\.(gif|jpg|png|ico|bmp)$/i.test(f.archivo.value);
				if (!enviar)	alert("seleccione imagen");
				return enviar;
			}

function limpiar()	{
				f = document.getElementById("ubicacion");
				nuevoFile = document.createElement("input");
				nuevoFile.id = f.id;
				nuevoFile.type = "file";
				nuevoFile.size="60";
				nuevoFile.name = "ubicacion";
				nuevoFile.value = "";
				nuevoFile.onchange = f.onchange;
				nodoPadre = f.parentNode;
				nodoSiguiente = f.nextSibling;
				nodoPadre.removeChild(f);
				(nodoSiguiente == null) ? nodoPadre.appendChild(nuevoFile):
					nodoPadre.insertBefore(nuevoFile, nodoSiguiente);
			}

	function checkear(f)	{
				function no_prever() {
					alert("El archivo buscado y seleccionado no es válido, el formato de la imagen debe ser JPG ...!!!");
					limpiar();
				}
				function prever() {
					var campos = new Array("maxpeso", "maxalto", "maxancho");
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = false;
					actionActual = f.form.action;
					targetActual = f.form.target;
					f.form.action = "previsor.php";
					f.form.target = "ver";
					f.form.submit();
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = true;
					f.form.action = actionActual;
					f.form.target = targetActual;
				}

				(/\.(jpg)$/i.test(f.value)) ? prever() : no_prever();
			}

</script>

<script>
//El contador es un arrayo de forma que cada posición del array es una linea del formulario
var contador = 0;

function validar(check,maxi,formulario) {
	//Compruebo si la casilla está marcada
	if (check.checked==true){
		//está marcada, entonces aumento en uno el contador del grupo
		if (formulario.vtip.value=='D') {
                  formulario.vtex.value = trim(formulario.vtex.value);
		  if (formulario.vtex.value=='') {
		    alert('Aviso: No ha ingresado el Nombre o la Denominacion a buscar ...!!!');
		    //desmarco la casilla, porque no se puede permitir marcar
		    check.checked=false;
		    contador = 0;
                    formulario.vtex.focus();
		    return
		  }
                  if (formulario.vtex.value.length < 1) {
		    alert('Aviso: La Denominacion a buscar no puede ser menor o igual a cero caracter ...!!!');
		    //desmarco la casilla, porque no se puede permitir marcar
                    formulario.vtex.value = '';
		    check.checked=false;
		    contador = 0;
                    formulario.vtex.focus();
		    return
                  }
		}
	   if (formulario.vtip.value=='G') {
		  if (formulario.ubicacion.value=='') {
		    alert('Aviso: No ha ingresado la Imagen o Logotipo a buscar ...!!!');
		    //desmarco la casilla, porque no se puede permitir marcar
		    check.checked=false;
		    contador = 0;
		    return
		  }
		}
		contador++;
		//compruebo si el contador ha llegado al maximo permitido
		if (contador>maxi.value) {
			//si ha llegado al máximo, muestro mensaje de error
			alert('Aviso: No puedes elegir más de '+maxi.value+' clases a seleccionar.');
			//desmarco la casilla, porque no se puede permitir marcar
			check.checked=false;
			//resto una unidad al contador de grupo, porque he desmarcado una casilla
			contador--;
		}
	}else {
		//si la casilla no estaba marcada, resto uno al contador de grupo
		contador--;
	}
	if (contador > 0) { formulario.incluir.disabled=false }
	else { formulario.incluir.disabled=true }
}


function validarviena(formulario) {
   if (formulario.vtip.value=='G') {
     if (formulario.ubicacion.value=='') {
	alert('Aviso: No ha ingresado la Imagen o Logotipo a buscar ...!!!');
	return
     }
   }
}


function valtodos(maxi,formulario) {
	//Coloco el contador del grupo en 47
   contador = 47;
	if (formulario.vtip.value=='D') {
     formulario.vtex.value = trim(formulario.vtex.value);
	  if (formulario.vtex.value=='') {
          contador=0;
          for (var j = 1; j <= 47; j++) {
            box = eval("document.formclase.clase" + j); 
            if (box.checked == true) box.checked = false; }
          document.formclase.incluir.disabled=true;
		    alert('Aviso: No ha ingresado el Nombre o la Denominacion a buscar ...!!!');
          formulario.vtex.focus();
		    return
	  }
     if (formulario.vtex.value.length < 4) {
          contador=0;
          for (var j = 1; j <= 47; j++) {
            box = eval("document.formclase.clase" + j); 
            if (box.checked == true) box.checked = false; }
          document.formclase.incluir.disabled=true;
	       alert('Aviso: La Denominacion a buscar no puede ser menor o igual a tres caracteres ...!!!');
          formulario.vtex.value = '';
          formulario.vtex.focus();
		    return
     }
	}
   if (formulario.vtip.value=='G') {
		  if (formulario.ubicacion.value=='') {
          contador=0;
          for (var j = 1; j <= 47; j++) {
            box = eval("document.formclase.clase" + j); 
            if (box.checked == true) box.checked = false; }
          document.formclase.incluir.disabled=true;
		    alert('Aviso: No ha ingresado la Imagen o Logotipo a buscar ...!!!');
		    return
		  }
	}
	if (contador > 0) { 
	      formulario.incluir.disabled=false; }
	else { formulario.incluir.disabled=true; }
}

</script>

<script type="text/javascript">
String.prototype.reverse=function(){return this.split('').reverse().join('');};
function number_condec(e){
function f(){
var v=this.value;
var pos=v.indexOf('.');
var vdec=v.substring(pos+1,pos+3);
var vent=v.substring(0,pos);
if (pos>0) {this.value=vent.concat('.').concat(vdec);}
this.value=this.value.reverse().replace(/[^0-9.]/g,'').replace(/\.(?=\d*[.]\d*)/g,'').reverse();
}
e.onkeyup=f
e.onkeydown=f
e.onkeypress=f
e.onmousedown=f
e.onmouseup=f
e.onclick=f
e.onchange=t
e.onblur=f
}

function number_sindec(e){
function f(){
this.value=this.value.reverse().replace(/[^0-9]/g,'').replace(/\.(?=\d*[.]\d*)/g,'').reverse();
}
e.onkeyup=f
e.onkeydown=f
e.onkeypress=f
e.onmousedown=f
e.onmouseup=f
e.onclick=f
e.onchange=t
e.onblur=f
}

function solo2dec(n) {
   var v=n.value;
   var pos=v.indexOf('.');
   var vdec=v.substring(pos+1,pos+3);
   var vent=v.substring(0,pos);
   var vfin=vent.concat('.').concat(vdec);
   if (pos>0) {n.value=vfin;}
}

</script>

<?php
  //include ("../setting.inc.php");
  //require ("../include.php");
  //include ("/apl/librerias/library.php");
  include ("../z_includes.php");
  // ************************************************************************************* 
  // Programa: adm_clases.php SIPI 
  // Realizado por el Analista de Sistema Romulo Mendoza 
  // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
  // Año: 2012 BD - Relacional 
  // *************************************************************************************
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Sistema de Informaci&oacute;n de Propiedad Intelectual SIPI</title>
</head>
<body onload="centrarwindows();this.document.formclase.incluir.disabled=true;this.document.formclase.vtex.focus()" bgcolor="#FFFFFF">   

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//<input type="text" name="textfield" onmouseover="this.style.backgroundColor='#FF3333'" style="background-color:#FF9900" onmouseout="this.style.backgroundColor='#FF9900'" />

//Variable
$login     = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$subtitulo = "Solicitud(es) de B&uacute;squeda(s) Fonetica y/o Graficas";
$sql = new mod_db();
$vfac=$_GET['vfac'];
$vmod=$_GET['vmod'];
$vfon=$_GET['vfon'];
$vgra=$_GET['vgra'];
$vtip=$_GET['vtip'];
//$vtip="D";

echo "<table align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>"; 
echo " <tr>";
echo "  <td width='88%' align='left'>";

if (empty($vtip) and $vmod=='Incluir/Busqueda') { 
  $smarty->assign('titulo',$titulo);
  $smarty->assign('subtitulo',$subtitulo);
  $smarty->assign('login',$login);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  echo "<br><br>";
  echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
  echo "   <tr>";
  echo "     <td colspan='2' height='60'>";
  echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
  echo "     </td>";
  echo "     <td colspan='2' height='60'>";
  echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>Por favor debe seleccionar el Tipo de B&uacute;squeda a realizar ...!!!<br><br><font color='#FFFF00'></b></font>";
  echo "       </div>";
  echo "     </td>";
  echo "   </tr>";
  echo "</table>";
  echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
  echo "<div align='center'>";
  echo "<tr><td>&nbsp;</td></tr>";
  $smarty->display('pie_pag.tpl');   
  echo "</div>";
  exit();
}

//Verificando conexion
$sql->connection();

//echo "$vfac, $vtip, $vmod, ";

//Verificacion de Cantidad de Busquedas ya cargadas
$resultado=pg_exec("SELECT * FROM stmtmpbus WHERE nro_factura='$vfac' AND tipo_bus='F'");
$nfon=pg_numrows($resultado);
$resultado=pg_exec("SELECT * FROM stmtmpbus WHERE nro_factura='$vfac' AND tipo_bus='G'");
$ngra=pg_numrows($resultado);
if ($vmod=='Incluir/Busqueda') {
 if ($vtip=="D") { 
  if (($nfon>=$vfon) AND ($vfon!=0)) {
    $smarty->assign('subtitulo',$subtitulo);
    $smarty->assign('login',$login);
    $smarty->assign('fechahoy',$fecha);
    $smarty->display('encabezado1.tpl');
    //echo "<br>";
    echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
    echo "   <tr>";
    echo "     <td colspan='2' height='60'>";
    echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
    echo "     </td>";
    echo "     <td colspan='2' height='60'>";
    echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>Ya llego al tope de B&uacute;squedas Foneticas solicitadas ...!!!<br><font color='#FFFF00'></b></font>";
    echo "       </div>";
    echo "     </td>";
    echo "   </tr>";
    echo "</table>";
    echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
    echo "<div align='center'>";
    $smarty->display('pie_pag.tpl');   
    echo "</div>";
    exit();
  }
 }

 if ($vtip=="G") { 
  if (($ngra>=$vgra) AND ($vgra!=0)) {
    $smarty->assign('subtitulo',$subtitulo);
    $smarty->assign('login',$login);
    $smarty->assign('fechahoy',$fecha);
    $smarty->display('encabezado1.tpl');
    echo "<br>";
    echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
    echo "   <tr>";
    echo "     <td colspan='2' height='60'>";
    echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
    echo "     </td>";
    echo "     <td colspan='2' height='60'>";
    echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>Ya llego al tope de B&uacute;squedas Gr&aacute;ficas a solicitar ...!!!<br><br><font color='#FFFF00'></b></font>";
    echo "       </div>";
    echo "     </td>";
    echo "   </tr>";
    echo "</table>";
    echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
    echo "<div align='center'>";
    $smarty->display('pie_pag.tpl');   
    echo "</div>";
    exit();
  }
 }
}

//Verificando conexion
$sql->connection();

//Paginacion
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total = $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 12;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['vfac']=$vfac;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vtex']=$vtex;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;
$hiddenvars['vfon']=$vfon;
$hiddenvars['vgra']=$vgra;

$nclases = $vfon;

if ($nclases<47) { $modo1="disabled"; } 
else { $modo1="";} 

 if ($vmod=='Incluir/Busqueda' || $vmod=='Buscar')
  {
   $totclases =0;
   $vanclases =0;
   $filas_resultado=0;
   $totclases=($vfon+$vgra);
   //Verificacion de que no haya cargado las clases antes.....
   $vanclases = ($nfon + $ngra);
  
   $nclases = $totclases-$vanclases;
   if ($vtip=="D") { $nclases = ($vfon-$nfon); }

   if (($nfon==$vfon) AND ($ngra==$vgra)) {
     $smarty->assign('subtitulo',$subtitulo);
     $smarty->assign('login',$login);
     $smarty->assign('fechahoy',$fecha);
     $smarty->display('encabezado1.tpl');
     echo "<br>";
     echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
     echo "   <tr>";
     echo "     <td colspan='2' height='60'>";
     echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
     echo "     </td>";
     echo "     <td colspan='2' height='60'>";
     echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>AVISO: Ya selecciono la Cantidad de B&uacute;squedas permitidas ...!!!<br><br><font color='#FFFF00'></b></font>";
     echo "       </div>";
     echo "     </td>";
     echo "   </tr>";
     echo "</table>";
     echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
     echo "<div align='center'>";
     $smarty->display('pie_pag.tpl');   
     echo "</div>";
     exit();
   }

echo "<table width='89%' align='center' border='0' cellpadding='0' cellspacing='1' bgcolor='#800000'>";
echo "  <tr>";
echo "    <td>";
echo "     <div align='center'>";
echo "     <font class='titulo1' size='1'><b>Solicitud(es) de B&uacute;squeda(s) Fonetica y/o Gr&aacute;ficas</b></font><br />";
echo "     </div>";
echo "    </td>";
echo "  </tr>";
echo "</table>";

   
   if ($filas_resultado==0){
      echo "<div align='center'>";
      echo "<table  border='0' cellpadding='0' cellspacing='1' bgcolor='#FFFFFF'>";
      echo "<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>";
      echo "<tr>";
      echo "<td>";
      echo "<fieldset>";
      echo "<h5>";
      echo "<legend align='left' class='Estilo4'><strong><span>  Selecci&oacute;n de Clase(s) Internacional de Niza </span><br /></strong></legend>";
      echo "</h5>";

       ?>
       <form action="../marcas/m_gbclases1.php" name="formclase" enctype="multipart/form-data" method="POST" >
       <?php
       echo "<input type='hidden' name='vfac' value='$vfac'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vusuario' value='$login'>";
       echo "<input type='hidden' name='vtip' value='$vtip'>";
       echo "<input type='hidden' name='vfil' value='0'>";

       $caracter='.';
       //$posicion = strpos($vmon, $caracter);
       //if ($posicion === false) { $vmon = $vmon.".00"; } 
       echo "<p class='texto_bold_r'><strong><font size='2'>Factura Nro.:&nbsp;&nbsp;<input type='text' name='factura' value='$vfac' size='8' maxlength='8' readonly='readonly' style='text-align: right'></font></strong></p>";

       if ($vtip=="D") {
         echo "<font class='texto_bold_l' size='2'>Denominaci&oacute;n o Nombre de la Marca:</font><input type='text' name='vtex' value='$vtex' size='98' maxlength='120' onkeyup='this.value=this.value.toUpperCase()' class='celda7'></p>"; }
       else {
       	 //$del_datos = $sql->del("stmtmpcvfac","factura='$vfac'");
         echo "<font class='texto_bold_l' size='2'>Ubicaci&oacute;n de Logotipo:&nbsp;&nbsp;</font>";
         echo "<input id='ubicacion' name='ubicacion' type='file' size='60' onchange='checkear(this)' ><br>";  
         echo "<font face='Arial' color='#800000' size='2'>La imagen a usar debe estar en formato JPG (Joint Photographic Experts Group) de tamaño 4x4cms.</font></p>"; 


         echo "<table width='85%' cellspacing='0' border='1'>";
         echo "<tr><td class='izq2-color' colspan='2'>Codigos de Viena:</td></tr>";
         echo "<tr><td>";    
         echo "<iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src='m_vercvfac.php?nfac={$vfac}'></iframe>";
         echo "</td></tr>";
         echo "<tr><td class='der-color'>";
         echo " <input type='text' name='vviena' size='20' onkeyup='this.value=this.value.toUpperCase()'>";
         echo " <input type='button' class='boton_blue' value='Buscar/Incluir'  name='vvienai' onclick='gestionviena(document.formclase.factura,document.formclase.vviena,document.formclase.vvienai,document.formclase.ubicacion)'>";
         echo " <input type='button' class='boton_blue' value='Buscar/Eliminar' name='vvienae' onclick='gestionviena(document.formclase.factura,document.formclase.vviena,document.formclase.vvienae,document.formclase.ubicacion)'>";
         echo "</td></tr>";
         echo "</table>";
       }

       echo "<strong><font class='texto_normal_l' size='3'>Cantidad de Clases a Seleccionar:&nbsp;&nbsp;<input type='text' name='vclas' value=$nclases size='2' maxlength='2' readonly='readonly' style='text-align: right'></font></strong>";
       echo "<br><br>";
       echo "<small><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N Planilla</b></small>";
       echo "<small><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N Planilla</b></small>"; 
       echo "<small><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N Planilla</b></small>"; 
       echo "<small><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N Planilla</b></small>"; 
       echo "<small><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N Planilla</b></small>";
       echo "<small><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N Planilla</b></small>";
              
       echo "<div align='center'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='110%'>";
       echo "<tr>";

       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase1' onclick='validar(document.formclase.clase1,document.formclase.vclas,this.form);checkplan(document.formclase.clase1,document.formclase.planilla1,document.formclase.b01)'>";
       echo "<input type='button' name='b01' value='01' align='middle' border='0' onclick='ayudaclas(document.formclase.b01);' title='Productos químicos para la industria, la ciencia y la fotografía, así como para la agricultura, la horticultura y la silvicultura; resinas artificiales en bruto, materias plásticas en bruto; abonos para el suelo; composiciones extintoras; preparaciones para templar y soldar metales; productos químicos para conservar alimentos; materias curtientes; adhesivos (pegamentos) para la industria.'  />&nbsp;"; 
       echo "<input type='text' name='planilla1' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";  
       
       echo "<input type='checkbox' name='clase2' onclick='validar(document.formclase.clase2,document.formclase.vclas,this.form);checkplan(document.formclase.clase2,document.formclase.planilla2,document.formclase.b02)'>";
       echo "<input type='button' name='b02' value='02' align='middle' border='0' onclick='ayudaclas(document.formclase.b02);' title='Pinturas, barnices, lacas; productos antioxidantes y productos para conservar la madera; materias tintóreas; mordientes; resinas naturales en bruto; metales en hojas y en polvo para pintores, decoradores, impresores y artistas.' class='inputbox' />&nbsp;"; 
       echo "<input type='text' name='planilla2' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase3' onclick='validar(document.formclase.clase3,document.formclase.vclas,this.form);checkplan(document.formclase.clase3,document.formclase.planilla3,document.formclase.b03)'>";
       echo "<input type='button' name='b03' value='03' align='middle' border='0' onclick='ayudaclas(document.formclase.b03);' title='Preparaciones para blanquear y otras sustancias para lavar la ropa; preparaciones para limpiar, pulir, desengrasar y raspar; jabones; productos de perfumería, aceites esenciales, cosméticos, lociones capilares; dentífricos.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla3' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
              
       echo "<input type='checkbox' name='clase4' onclick='validar(document.formclase.clase4,document.formclase.vclas,this.form);checkplan(document.formclase.clase4,document.formclase.planilla4,document.formclase.b04)'>";
       echo "<input type='button' name='b04' value='04' align='middle' border='0' onclick='ayudaclas(document.formclase.b04);' title='Aceites y grasas para uso industrial; lubricantes; productos para absorber, rociar y asentar el polvo; combustibles (incluida la gasolina para motores) y materiales de alumbrado; velas y mechas de iluminación.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla4' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
              
       echo "<input type='checkbox' name='clase5' onclick='validar(document.formclase.clase5,document.formclase.vclas,this.form);checkplan(document.formclase.clase5,document.formclase.planilla5,document.formclase.b05)'>";
       echo "<input type='button' name='b05' value='05' align='middle' border='0' onclick='ayudaclas(document.formclase.b05);' title='Productos farmacéuticos y veterinarios; productos higiénicos y sanitarios para uso médico; sustancias dietéticas para uso médico, alimentos para bebés; emplastos, material para apósitos; material para empastes e improntas dentales; desinfectantes;
  productos para eliminar animales dañinos; fungicidas, herbicidas.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla5' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase6' onclick='validar(document.formclase.clase6,document.formclase.vclas,this.form);checkplan(document.formclase.clase6,document.formclase.planilla6,document.formclase.b06)'>";
       echo "<input type='button' name='b06' value='06' align='middle' border='0' onclick='ayudaclas(document.formclase.b06);' title='Metales comunes y sus aleaciones; materiales de construcción metálicos; construcciones transportables metálicas; materiales metálicos para vías férreas; cables e hilos metálicos no eléctricos; artículos de cerrajería y ferretería metálicos; tubos y
  tuberías metálicos; cajas de caudales; productos metálicos no comprendidos en otras clases; minerales metalíferos.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla6' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";
       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase7' onclick='validar(document.formclase.clase7,document.formclase.vclas,this.form);checkplan(document.formclase.clase7,document.formclase.planilla7,document.formclase.b07)'>";
       echo "<input type='button' name='b07' value='07' align='middle' border='0' onclick='ayudaclas(document.formclase.b07);' title='Máquinas y máquinas herramientas; motores (excepto motores para vehículos terrestres); acoplamientos y elementos de transmisión (excepto para vehículos terrestres); instrumentos agrícolas que no sean accionados manualmente; incubadoras de huevos.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla7' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase8' onclick='validar(document.formclase.clase8,document.formclase.vclas,this.form);checkplan(document.formclase.clase8,document.formclase.planilla8,document.formclase.b08)'>";
       echo "<input type='button' name='b08' value='08' align='middle' border='0' onclick='ayudaclas(document.formclase.b08);' title='Herramientas e instrumentos de mano accionados manualmente; artículos de cuchillería, tenedores y cucharas; armas blancas; navajas y maquinillas de afeitar.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla8' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase9' onclick='validar(document.formclase.clase9,document.formclase.vclas,this.form);checkplan(document.formclase.clase9,document.formclase.planilla9,document.formclase.b09)'>";
       echo "<input type='button' name='b09' value='09' align='middle' border='0' onclick='ayudaclas(document.formclase.b09);' title='Aparatos e instrumentos científicos, náuticos, geodésicos, fotográficos, cinematográficos, ópticos, de pesaje, de medición, de señalización, de control (inspección), de salvamento y de enseñanza; aparatos e instrumentos de conducción, distribución, transformación, acumulación, regulación o control de la electricidad; aparatos de grabación, transmisión o reproducción de sonido o imágenes; soportes de
  registro magnéticos, discos acústicos; distribuidores automáticos y mecanismos para aparatos de previo pago; cajas registradoras, máquinas de calcular, equipos de
  procesamiento de datos y ordenadores; extintores.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla9' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase10' onclick='validar(document.formclase.clase10,document.formclase.vclas,this.form);checkplan(document.formclase.clase10,document.formclase.planilla10,document.formclase.b10)'>";
       echo "<input type='button' name='b10' value='10' align='middle' border='0' onclick='ayudaclas(document.formclase.b10);' title='Aparatos e instrumentos quirúrgicos, médicos, odontológicos y veterinarios, así como miembros, ojos y dientes artificiales; artículos ortopédicos; material de sutura.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla10' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase11' onclick='validar(document.formclase.clase11,document.formclase.vclas,this.form);checkplan(document.formclase.clase11,document.formclase.planilla11,document.formclase.b11)'>";
       echo "<input type='button' name='b11' value='11' align='middle' border='0' onclick='ayudaclas(document.formclase.b11);' title='Aparatos de alumbrado, calefacción, producción de vapor, cocción, refrigeración, secado, ventilación y distribución de agua, así como instalaciones sanitarias.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla11' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase12' onclick='validar(document.formclase.clase12,document.formclase.vclas,this.form);checkplan(document.formclase.clase12,document.formclase.planilla12,document.formclase.b12)'>";
       echo "<input type='button' name='b12' value='12' align='middle' border='0' onclick='ayudaclas(document.formclase.b12);' title='Vehículos; aparatos de locomoción terrestre, aérea o acuática.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla12' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";
       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase13' onclick='validar(document.formclase.clase13,document.formclase.vclas,this.form);checkplan(document.formclase.clase13,document.formclase.planilla13,document.formclase.b13)'>";
       echo "<input type='button' name='b13' value='13' align='middle' border='0' onclick='ayudaclas(document.formclase.b13);' title='Armas de fuego; municiones y proyectiles; explosivos; fuegos artificiales.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla13' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase14' onclick='validar(document.formclase.clase14,document.formclase.vclas,this.form);checkplan(document.formclase.clase14,document.formclase.planilla14,document.formclase.b14)'>";
       echo "<input type='button' name='b14' value='14' align='middle' border='0' onclick='ayudaclas(document.formclase.b14);' title='Metales preciosos y sus aleaciones, así como productos de estas materias o chapados no comprendidos en otras clases; artículos de joyería, bisutería, piedras preciosas; artículos de relojería e instrumentos cronométricos.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla14' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
   
       echo "<input type='checkbox' name='clase15' onclick='validar(document.formclase.clase15,document.formclase.vclas,this.form);checkplan(document.formclase.clase15,document.formclase.planilla15,document.formclase.b15)'>";
       echo "<input type='button' name='b15' value='15' align='middle' border='0' onclick='ayudaclas(document.formclase.b15);' title='Instrumentos musicales.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla15' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase16' onclick='validar(document.formclase.clase16,document.formclase.vclas,this.form);checkplan(document.formclase.clase16,document.formclase.planilla16,document.formclase.b16)'>";
       echo "<input type='button' name='b16' value='16' align='middle' border='0' onclick='ayudaclas(document.formclase.b16);' title='Papel, cartón y artículos de estas materias no comprendidos en otras clases; productos de imprenta; material de encuadernación; fotografías; artículos de papelería; adhesivos(pegamentos) de papelería o para uso doméstico; material para artistas; pinceles; máquinas de escribir y artículos de oficina (excepto muebles); material de instrucción o material didáctico (excepto aparatos); materias plásticas para embalar (no comprendidas en otras clases); caracteres de imprenta; clichés de imprenta.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla16' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase17' onclick='validar(document.formclase.clase17,document.formclase.vclas,this.form);checkplan(document.formclase.clase17,document.formclase.planilla17,document.formclase.b17)'>"; 
       echo "<input type='button' name='b17' value='17' align='middle' border='0' onclick='ayudaclas(document.formclase.b17);' title='Caucho, gutapercha, goma, amianto, mica y productos de estas materias no comprendidos en otras clases; productos de materias plásticas semielaborados; materiales para calafatear, estopar y aislar; tubos flexibles no metálicos.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla17' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase18' onclick='validar(document.formclase.clase18,document.formclase.vclas,this.form);checkplan(document.formclase.clase18,document.formclase.planilla18,document.formclase.b18)'>";
       echo "<input type='button' name='b18' value='18' align='middle' border='0' onclick='ayudaclas(document.formclase.b18);' title='Cuero y cuero de imitación, productos de estas materias no comprendidos en otras clases; pieles de animales; baúles y maletas; paraguas, sombrillas y bastones; fustas y artículos de guarnicionería.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla18' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";
       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";


       echo "<input type='checkbox' name='clase19' onclick='validar(document.formclase.clase19,document.formclase.vclas,this.form);checkplan(document.formclase.clase19,document.formclase.planilla19,document.formclase.b19)'>";
       echo "<input type='button' name='b19' value='19' align='middle' border='0' onclick='ayudaclas(document.formclase.b19);' title='Materiales de construcción no metálicos; tubos rígidos no metálicos para la construcción; asfalto, pez y betún; construcciones transportables no metálicas; monumentos no metálicos.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla19' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase20' onclick='validar(document.formclase.clase20,document.formclase.vclas,this.form);checkplan(document.formclase.clase20,document.formclase.planilla20,document.formclase.b20)'>";
       echo "<input type='button' name='b20' value='20' align='middle' border='0' onclick='ayudaclas(document.formclase.b20);' title='Muebles, espejos, marcos; productos de madera, corcho, caña, junco, mimbre, cuerno, hueso, marfil, ballena, concha, ámbar, nácar, espuma de mar, sucedáneos de todos estos materiales o de materias plásticas, no comprendidos en otras clases.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla20' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase21' onclick='validar(document.formclase.clase21,document.formclase.vclas,this.form);checkplan(document.formclase.clase21,document.formclase.planilla21,document.formclase.b21)'>";
       echo "<input type='button' name='b21' value='21' align='middle' border='0' onclick='ayudaclas(document.formclase.b21);' title='Utensilios y recipientes para uso doméstico y culinario; peines y esponjas; cepillos; materiales para fabricar cepillos; material de limpieza; lana de acero; vidrio en bruto o semielaborado (excepto el vidrio de construcción); artículos de cristalería, porcelana y loza no comprendidos en otras clases.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla21' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase22' onclick='validar(document.formclase.clase22,document.formclase.vclas,this.form);checkplan(document.formclase.clase22,document.formclase.planilla22,document.formclase.b22)'>";
       echo "<input type='button' name='b22' value='22' align='middle' border='0' onclick='ayudaclas(document.formclase.b22);' title='22 Cuerdas, cordeles, redes, tiendas de campaña, lonas, velas de navegación, sacos y bolsas (no comprendidos en otras clases); materiales de acolchado y relleno (excepto el caucho o las materias plásticas); materias textiles fibrosas en bruto.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla22' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
          
       echo "<input type='checkbox' name='clase23' onclick='validar(document.formclase.clase23,document.formclase.vclas,this.form);checkplan(document.formclase.clase23,document.formclase.planilla23,document.formclase.b23)'>";
       echo "<input type='button' name='b23' value='23' align='middle' border='0' onclick='ayudaclas(document.formclase.b23);' title='Hilos para uso textil.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla23' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase24' onclick='validar(document.formclase.clase24,document.formclase.vclas,this.form);checkplan(document.formclase.clase24,document.formclase.planilla24,document.formclase.b24)'>";
       echo "<input type='button' name='b24' value='24' align='middle' border='0' onclick='ayudaclas(document.formclase.b24);' title='Tejidos y productos textiles no comprendidos en otras clases; ropa de cama y de mesa.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla24' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";
       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase25' onclick='validar(document.formclase.clase25,document.formclase.vclas,this.form);checkplan(document.formclase.clase25,document.formclase.planilla25,document.formclase.b25)'>";
       echo "<input type='button' name='b25' value='25' align='middle' border='0' onclick='ayudaclas(document.formclase.b25);' title='Prendas de vestir, calzado, artículos de sombrerería.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla25' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase26' onclick='validar(document.formclase.clase26,document.formclase.vclas,this.form);checkplan(document.formclase.clase26,document.formclase.planilla26,document.formclase.b26)'>";
       echo "<input type='button' name='b26' value='26' align='middle' border='0' onclick='ayudaclas(document.formclase.b26);' title='Encajes y bordados, cintas y cordones; botones, ganchos y ojetes, alfileres y agujas; flores artificiales.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla26' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase27' onclick='validar(document.formclase.clase27,document.formclase.vclas,this.form);checkplan(document.formclase.clase27,document.formclase.planilla27,document.formclase.b27)'>";
       echo "<input type='button' name='b27' value='27' align='middle' border='0' onclick='ayudaclas(document.formclase.b27);' title='Alfombras, felpudos, esteras, linóleo y otros revestimientos de suelos; tapices murales que no sean de materias textiles.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla27' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase28' onclick='validar(document.formclase.clase28,document.formclase.vclas,this.form);checkplan(document.formclase.clase28,document.formclase.planilla28,document.formclase.b28)'>";
       echo "<input type='button' name='b28' value='28' align='middle' border='0' onclick='ayudaclas(document.formclase.b28);' title='Juegos y juguetes; artículos de gimnasia y deporte no comprendidos en otras clases; adornos para árboles de Navidad.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla28' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase29' onclick='validar(document.formclase.clase29,document.formclase.vclas,this.form);checkplan(document.formclase.clase29,document.formclase.planilla29,document.formclase.b29)'>";
       echo "<input type='button' name='b29' value='29' align='middle' border='0' onclick='ayudaclas(document.formclase.b29);' title='Carne, pescado, carne de ave y carne de caza; extractos de carne; frutas y verduras, hortalizas y legumbres en conserva, congeladas, secas y cocidas; jaleas, confituras, compotas; huevos, leche y productos lácteos; aceites y grasas comestibles.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla29' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase30' onclick='validar(document.formclase.clase30,document.formclase.vclas,this.form);checkplan(document.formclase.clase30,document.formclase.planilla30,document.formclase.b30)'>";
       echo "<input type='button' name='b30' value='30' align='middle' border='0' onclick='ayudaclas(document.formclase.b30);' title='Café, té, cacao, azúcar, arroz, tapioca, sagú, sucedáneos del café; harinas y preparaciones a base de cereales, pan, productos de pastelería y de confitería, helados; miel, jarabe de melaza; levadura, polvos de hornear; sal, mostaza; vinagre, salsas (condimentos); especias; hielo.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla30' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";
       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase31' onclick='validar(document.formclase.clase31,document.formclase.vclas,this.form);checkplan(document.formclase.clase31,document.formclase.planilla31,document.formclase.b31)'>"; 
       echo "<input type='button' name='b31' value='31' align='middle' border='0' onclick='ayudaclas(document.formclase.b31);' title='31 Productos agrícolas, hortícolas, forestales y granos, no comprendidos en otras clases; animales vivos; frutas y verduras, hortalizas y legumbres frescas; semillas, plantas y flores naturales; alimentos para animales; malta.' class='inputbox' />&nbsp;"; 
       echo "<input type='text' name='planilla31' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase32' onclick='validar(document.formclase.clase32,document.formclase.vclas,this.form);checkplan(document.formclase.clase32,document.formclase.planilla32,document.formclase.b32)'>";
       echo "<input type='button' name='b32' value='32' align='middle' border='0' onclick='ayudaclas(document.formclase.b32);' title='Cerveza; aguas minerales y gaseosas, y otras bebidas sin alcohol; bebidas de frutas y zumos de frutas; siropes y otras preparaciones para elaborar bebidas.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla32' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase33' onclick='validar(document.formclase.clase33,document.formclase.vclas,this.form);checkplan(document.formclase.clase33,document.formclase.planilla33,document.formclase.b33)'>";
       echo "<input type='button' name='b33' value='33' align='middle' border='0' onclick='ayudaclas(document.formclase.b33);' title='Bebidas alcohólicas (excepto cerveza).' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla33' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase34' onclick='validar(document.formclase.clase34,document.formclase.vclas,this.form);checkplan(document.formclase.clase34,document.formclase.planilla34,document.formclase.b34)'>";
       echo "<input type='button' name='b34' value='34' align='middle' border='0' onclick='ayudaclas(document.formclase.b34);' title='Tabaco; artículos para fumadores; cerillas.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla34' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase35' onclick='validar(document.formclase.clase35,document.formclase.vclas,this.form);checkplan(document.formclase.clase35,document.formclase.planilla35,document.formclase.b35)'>";
       echo "<input type='button' name='b35' value='35' align='middle' border='0' onclick='ayudaclas(document.formclase.b35);' title='Publicidad; gestión de negocios comerciales; administración comercial; trabajos de oficina.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla35' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase36' onclick='validar(document.formclase.clase36,document.formclase.vclas,this.form);checkplan(document.formclase.clase36,document.formclase.planilla36,document.formclase.b36)'>";
       echo "<input type='button' name='b36' value='36' align='middle' border='0' onclick='ayudaclas(document.formclase.b36);' title='Seguros; operaciones financieras; operaciones monetarias; negocios inmobiliarios.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla36' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";
       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase37' onclick='validar(document.formclase.clase37,document.formclase.vclas,this.form);checkplan(document.formclase.clase37,document.formclase.planilla37,document.formclase.b37)'>";
       echo "<input type='button' name='b37' value='37' align='middle' border='0' onclick='ayudaclas(document.formclase.b37);' title='Servicios de construcción; servicios de reparación; servicios de instalación.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla37' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
              
       echo "<input type='checkbox' name='clase38' onclick='validar(document.formclase.clase38,document.formclase.vclas,this.form);checkplan(document.formclase.clase38,document.formclase.planilla38,document.formclase.b38)'>";
       echo "<input type='button' name='b38' value='38' align='middle' border='0' onclick='ayudaclas(document.formclase.b38);' title='Telecomunicaciones.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla38' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase39' onclick='validar(document.formclase.clase39,document.formclase.vclas,this.form);checkplan(document.formclase.clase39,document.formclase.planilla39,document.formclase.b39)'>";
       echo "<input type='button' name='b39' value='39' align='middle' border='0' onclick='ayudaclas(document.formclase.b39);' title='Transporte; embalaje y almacenamiento de mercancías; organización de viajes.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla39' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase40' onclick='validar(document.formclase.clase40,document.formclase.vclas,this.form);checkplan(document.formclase.clase40,document.formclase.planilla40,document.formclase.b40)'>";
       echo "<input type='button' name='b40' value='40' align='middle' border='0' onclick='ayudaclas(document.formclase.b40);' title='Tratamiento de materiales.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla40' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase41' onclick='validar(document.formclase.clase41,document.formclase.vclas,this.form);checkplan(document.formclase.clase41,document.formclase.planilla41,document.formclase.b41)'>";
       echo "<input type='button' name='b41' value='41' align='middle' border='0' onclick='ayudaclas(document.formclase.b41);' title='Educación; formación; servicios de entretenimiento; actividades deportivas y culturales.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla41' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase42' onclick='validar(document.formclase.clase42,document.formclase.vclas,this.form);checkplan(document.formclase.clase42,document.formclase.planilla42,document.formclase.b42)'>";
       echo "<input type='button' name='b42' value='42' align='middle' border='0' onclick='ayudaclas(document.formclase.b42);' title='Servicios científicos y tecnológicos, así como servicios de investigación y diseño en estos ámbitos; servicios de análisis e investigación industriales; diseño y desarrollo de equipos informáticos y de software.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla42' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";
       echo "<tr>";
       echo "<td>";
       echo "&nbsp;&nbsp;";

       echo "<input type='checkbox' name='clase43' onclick='validar(document.formclase.clase43,document.formclase.vclas,this.form);checkplan(document.formclase.clase43,document.formclase.planilla43,document.formclase.b43)'>";
       echo "<input type='button' name='b43' value='43' align='middle' border='0' onclick='ayudaclas(document.formclase.b43);' title='Servicios de restauración (alimentación); hospedaje temporal.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla43' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase44' onclick='validar(document.formclase.clase44,document.formclase.vclas,this.form);checkplan(document.formclase.clase44,document.formclase.planilla44,document.formclase.b44)'>";
       echo "<input type='button' name='b44' value='44' align='middle' border='0' onclick='ayudaclas(document.formclase.b44);' title='Servicios médicos; servicios veterinarios; tratamientos de higiene y de belleza para personas o animales; servicios de agricultura, horticultura y silvicultura.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla44' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase45' onclick='validar(document.formclase.clase45,document.formclase.vclas,this.form);checkplan(document.formclase.clase45,document.formclase.planilla45,document.formclase.b45)'>";
       echo "<input type='button' name='b45' value='45' align='middle' border='0' onclick='ayudaclas(document.formclase.b45);' title='Servicios jurídicos; servicios de seguridad para la protección de bienes y personas; servicios personales y sociales prestados por terceros para satisfacer necesidades individuales.' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla45' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       
       echo "<input type='checkbox' name='clase46' onclick='validar(document.formclase.clase46,document.formclase.vclas,this.form);checkplan(document.formclase.clase46,document.formclase.planilla46,document.formclase.b46)'>";
       echo "<input type='button' name='b46' value='NC' align='middle' border='0' onclick='ayudaclas(document.formclase.b46);' title='Nombre Comercial' class='inputbox' />&nbsp;";
       echo "<input type='text' name='planilla46' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";

       if ($vtip=="D") { 
         echo "<input type='checkbox' name='clase47' onclick='validar(document.formclase.clase47,document.formclase.vclas,this.form);checkplan(document.formclase.clase47,document.formclase.planilla47,document.formclase.b47)'>";
         echo "<input type='button' name='b47' value='LC' align='middle' border='0' onclick='ayudaclas(document.formclase.b47);' title='Lema Comercial' class='inputbox' />&nbsp;";
         echo "<input type='text' name='planilla47' size='6' maxlength='7' onkeyup='number_sindec(this)' disabled>&nbsp;&nbsp;";
       }
       echo "<br /></p>";
       if ($nclases < 47) { $modo1="disabled"; } else { $modo1=""; } 
        
       //echo "<input type='button' class='boton_blue' name='todos1' value='Seleccionar todos' onClick='checkAll();valtodos(document.formclase.vclas,this.form);' {$modo1} >&nbsp;&nbsp;&nbsp;&nbsp;";
       echo "<input type='button' class='boton_blue' name='todos2' value='Deseleccionar todos' onClick='uncheckAll();RecorrerForm();'><br>";
       echo "</td>";
       echo "</tr>";
       echo "<tr><td>&nbsp;</td></tr>";

       echo "</tr>";
       echo "</table>";   
       echo "</div>";

       echo "<p align='center'><input type='submit' class='boton_blue' name='incluir' value='GRABAR'>&nbsp;&nbsp;&nbsp;";
       echo "<input type='button' class='boton_blue' name='salir' value='SALIR' onclick='window.close()'></p>";

       echo "</form>";
       
echo " </td>";

echo " </tr>";
echo "</table>";
        
       exit;
   }
  }
?>

 <?php
 if ($vmod=='Buscar/Eliminar' || $vmod=='Eliminar') {
   echo "<table width='79%' align='center' border='0' cellpadding='0' cellspacing='1' bgcolor='#800000'>";
   echo "  <tr>";
   echo "    <td>";
   echo "     <div align='center'>";
   echo "     <font class='titulo1' size='1'><b>Solicitud de B&uacute;squeda Fonetica y/o Gr&aacute;fica</b></font><br />";
   echo "     </div>";
   echo "    </td>";
   echo "  </tr>";
   echo "</table>";

   $ruta = "../imagentemp/";
   //$ruta = $imagen_temp."/";
   $resultado=pg_exec("SELECT * FROM stmtmpbus WHERE nro_factura='$vfac'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);

   echo "<div align='center'>";
   echo "<table width='784' border='0' cellpadding='0' cellspacing='1' bgcolor='#FFFFFF'>";
   echo "<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>";
   echo "<tr>";
   echo "<td>";
   echo "<fieldset>";
   echo "<h5>";
   echo "<legend align='left' class='Estilo4'><strong><span>  Seleccione el Item que desea eliminar: </span><br /></strong></legend>";
   echo "</h5>";
   ?>
   <form action="../marcas/m_gbclases1.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vfac' value='$vfac'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vder' value='$vder'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";

   //echo "<p align='center'><b>Seleccione el Item que desea eliminar:</b></p>";
   echo "<div align='center'>";
   echo "<table border='1' cellpadding='0' cellspacing='0'>";
   echo "<tr><strong>";
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>Sel</font></strong></td>";   
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>No. Referencia</font></strong></td>";
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>Nombre</font></strong></td>";
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>Clase</font></strong></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='center'><font color='#0000FF'><input type='text' size='13' readonly value='$reg[nro_planilla]' style='text-align: right'></font></td>";
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='left'><font color='#0000FF'>";
     $vtipo=$reg[tipo_bus];
     if ($vtipo=="F") { 
       echo " <input type='text' size='60' readonly value='$reg[denominacion]' style='text-align: left'></font></td>"; }
     if ($vtipo=="G") {
       $vden=$reg[denominacion];
       $nameimagen = $ruta.$vden;
       echo "<a href='$nameimagen' target='_blank'><img border='1' src='$nameimagen' width='80' height='80'></a>";
       echo "  Archivo=$vden  "; 
       echo "</font></td>";}
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='left'><font color='#0000FF'><input type='text' size='10' readonly value='$reg[clase]' style='text-align: left'></font></td>";
     echo "<input type='hidden' name='num$cont' value='$reg[nro_planilla]'>";
     echo "<input type='hidden' name='den$cont' value='$reg[denominacion]'>";
     echo "<input type='hidden' name='cla$cont' value='$reg[clase]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>ERROR: NINGUN ITEM ASOCIADO</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()' class='botones'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";

      echo "<input type='submit' value='Eliminar' name='eliminar' class='botones' >
            <input type='button' value='Salir' name='aceptar' onclick='cerrarwindows2()' class='botones'></font></p>";
   }
   echo "</form>";

   echo "</tr>";
   echo "</table>";   
   echo "</div>";

  }

//}

function encabezado_niza() {
  echo "<table width='784%' align='center' border='0' cellpadding='0' cellspacing='1'>"; 
  echo "<tr>"; 
  echo "  <td>";
  echo "    <div align='center'>";
  echo "    <strong>";
  echo "    <img src='../imagenes/logo_comercio.jpg' width='784' height='55'>"; 
  echo "    <img src='../imagenes/header2.png' width='784' height='130'>";
  echo "    </strong>";
  echo "    </div>";
  echo "  </td>";
  echo "</tr>";
  echo "</table>";   
}

?>

</body>
</html>
