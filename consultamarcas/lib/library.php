<html>
<head>
<meta http-equiv="Content-Language" content="es">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="generator" content="Bluefish 1.0.7">
<meta name="ProgId" content="FrontPage.Editor.Document">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head>
<body>

<script language="javascript">
   // Chequea la longitud de valor a medida que se va introduciendo
   function checkLength(evt,oTxt,vlen,oTxtsig){
    var key = nav4plus ? evt.which : evt.keyCode;
    if (oTxt.value.length==0) {
      oTxt.focus();    
    } else {   
      if (oTxt.value.length>=vlen || key==13){
       oTxtsig.focus(); } 
      }
   }

   function Rellena(vtxt,vlen){
     var i = vtxt.value.length;
     if (i<vlen || i=="")
     { for(i=0; i <= vlen; i++){
        vtxt.value = "0".concat(vtxt.value);
        var i = vtxt.value.length; 
       }
     }
   }

   function Only_num(){ 
    var key=window.event.keyCode;//codigo de tecla. 
    if (key < 48 || key > 57){//si no es numero 
     window.event.keyCode=0;//anula la entrada de texto. 
    //if (key==13){oTxtsig.focus();}
   }} 
   
   function esDigito(sChr){ 
    var sCod = sChr.charCodeAt(0); 
    return ((sCod > 47) && (sCod < 58)); 
   } 

   function valSep(oTxt){ 
    var bOk = false; 
    var sep1 = oTxt.value.charAt(2); 
    var sep2 = oTxt.value.charAt(5); 
    bOk = bOk || ((sep1 == "-") && (sep2 == "-")); 
    bOk = bOk || ((sep1 == "/") && (sep2 == "/")); 
    return bOk; 
   } 

   function finMes(oTxt){ 
    var nMes = parseInt(oTxt.value.substr(3, 2), 10); 
    var nAno = parseInt(oTxt.value.substr(6), 10); 
    var nRes = 0; 
    switch (nMes){ 
     case 1: nRes = 31; break; 
     case 2: nRes = 28; break; 
     case 3: nRes = 31; break; 
     case 4: nRes = 30; break; 
     case 5: nRes = 31; break; 
     case 6: nRes = 30; break; 
     case 7: nRes = 31; break; 
     case 8: nRes = 31; break; 
     case 9: nRes = 30; break; 
     case 10: nRes = 31; break; 
     case 11: nRes = 30; break; 
     case 12: nRes = 31; break; 
    } 
    return nRes + (((nMes == 2) && (nAno % 4) == 0)? 1: 0); 
   } 

   function valDia(oTxt){ 
    var bOk = false; 
    var nDia = parseInt(oTxt.value.substr(0, 2), 10); 
    bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt))); 
    return bOk; 
   } 

   function valMes(oTxt){ 
    var bOk = false; 
    var nMes = parseInt(oTxt.value.substr(3, 2), 10); 
    bOk = bOk || ((nMes >= 1) && (nMes <= 12)); 
    return bOk; 
   } 

   function valAno(oTxt){ 
    var bOk = true; 
    var nAno = oTxt.value.substr(6); 
    bOk = bOk && ((nAno.length == 2) || (nAno.length == 4)); 
    if (bOk){ 
     for (var i = 0; i < nAno.length; i++){ 
      bOk = bOk && esDigito(nAno.charAt(i)); 
     } 
    } 
    return bOk; 
   } 

   function valFecha(oTxt,oTxtsig){ 
    var bOk = true; 
    if (oTxt.value != "" && oTxt.value.length==10){ 
     bOk = bOk && (valAno(oTxt)); 
     bOk = bOk && (valMes(oTxt)); 
     bOk = bOk && (valDia(oTxt)); 
     bOk = bOk && (valSep(oTxt)); 
     if (!bOk){ 
      alert("Fecha inv�ida"); 
      oTxt.value = "";
      oTxt.focus(); 
     } else oTxtsig.focus(); 
    } 
   } 

  function codigoteclaNE(oTxtsig,oTxt)
  {
    x=window.event.keyCode;
    if (x==13 && oTxt.value!="") {oTxtsig.focus();}
     //alert("el codigo de la tecla pulsada es: "+x);
  }

  function codigotecla(oTxtsig)
  {
    x=window.event.keyCode;
    if (x==13) {oTxtsig.focus();}
  }

  function Avanzafocus(oTxtsig) 
  {
    oTxtsig.focus();
  }

  function centrarwindows() { 
    resizeTo(screen.width/1.5, screen.height/1.5); 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
  }

  function disparaPopUp(var1,var2,var3,var4) {
    open("act_titular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

  function controla_salida(){ 
    event.returnValue = false;}
 
  function cerrarwindows(){ 
    close();}

  function conectarse() {
    pg_connect("dbname=sapi host=localhost user=ngonzalez password=ngonzalez");}

  function validarcampos(v1,v2,v3,v4,v5){ 
    var bOk = true; 
    if (v2.value == "" || v3.value == "" || v4.value == "" || v5.value == "") { 
       alert("Campo Vacio!"); 
       v2.focus();
    } 
    else  
    {
       alert("Guardado Correctamente"); 
       close();
    } 
  } 

function valclase(etip,ecni,ecla,oTxtsig){ 
    x=window.event.keyCode;
    var bOk = false; 
    if (ecni.value == "N"){
        if (etip.value == "M" && ecla.value>0 && ecla.value<50){
           var bOk = true;}
        if (etip.value != "M" && ecla.value==50){
           var bOk = true;}
    }
    if (ecni.value == "I"){
        if (etip.value == "M" && ecla.value>0 && ecla.value<35){
           var bOk = true;}
        if (etip.value == "S" && ecla.value>34 && ecla.value<46){
           var bOk = true;}
        if (etip.value == "N" && ecla.value==46){
           var bOk = true;}
        if (etip.value == "L" && ecla.value==47){
           var bOk = true;} 
        if (etip.value == "D" && ecla.value==48){
           var bOk = true;} 
        if (etip.value == "C" && ecla.value<49){
           var bOk = true;} 
    }  
    if (ecla.value.length>0 && x==13){
       if (!bOk){ 
          alert("Clase inv�ida"); 
          ecla.value = "";
          ecla.focus(); 
       }  
       else 
       { oTxtsig.focus(); 
       }
    } 
} 

function valtipo(etip,ecni,ecla){ 
    if (ecni.value == "N"){
        if (etip.value == "M"){
           ecla.value = "";}
        if (etip.value != "M"){
           ecla.value = 50;}
    }
    if (ecni.value == "I"){
        if (etip.value == "M" && ecla.value>34){
           ecla.value = "";}
        if (etip.value == "S" && ecla.value<35){
           ecla.value = "";}
        if (etip.value == "S" && ecla.value>45){
           ecla.value = "";}
        if (etip.value == "N"){
           ecla.value = 46;}
        if (etip.value == "L"){
           ecla.value = 47;}
        if (etip.value == "D"){
           ecla.value = 48;}  
    }  
} 

function valagente(v1,v2){ 
    if (v1!=""){
       v2.value=v1.value;
    }
}

function grabarsol(var1,var2,var3,var4,var5,var6,var7,var8,var9,var10,var11,var12,var13,var14) {
close();
open("ingresol.php?vsol="+var1.value+"-"+var2.value+"&vfec="+var3.value+"&vtip="+var4.value+"&vnom="+var5.value+"&vicl="+var6.value+"&vcla="+var7.value+"&vmod="+var8.value+"&vpai="+var9.value+"&vpod="+var10.value+"-"+var11.value+"&vage="+var12.value+"&vtra="+var13.value+"&vdis="+var14.value,"Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); 
open("input_marcas.php");}

</script>

<script language="JavaScript">
var mask_string = new Array()

function property_mask(msk, msg){

this.msk = msk
this.msg = msg

}

function populate_array(){
mask_string[0] =new property_mask( /[^\d]/i, "Puede intruducir cualquier caracter menos los nmeros.")
mask_string[1] =new property_mask(/[\d\s]/, "Solo se puede intruducir nmeros y espacios.")
mask_string[2] =new property_mask( /\d/, "Solo se pueden introducir nmeros.")
mask_string[3] =new property_mask(/[A-Z�d]/i,"Solo se puede introducir letras y nmeros,\n no se permiten espacios.")
mask_string[5] =new property_mask(/[A-Z�/i,"Solo se puede introducir las letras A-Z.")
mask_string[6] =new property_mask(/[ACDFLMNPS]/i,"Solo se puede introducir las letras ACDFLMNPS.")
}

populate_array()
var nav4plus = window.Event ? true : false;

function acceptChar(evt,nba,obj){
var key = nav4plus ? evt.which : evt.keyCode;
if(key==13 || key==8) { return true}
if(mask_string[nba].msk.test(String.fromCharCode(key))){ return true}
else{ obj.focus(); if (key!=0) { alert(mask_string[nba].msg)}; return false}
}

</script>

</body>
</html>

