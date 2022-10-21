// *************************************************************************************
// Programa: r_funciones.js 
// Realizado por el Analista de Sistema Ing. Maryury Bonilla
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Fecha: 09/03/2010 
// maryurybonilla20@gmail.com
// *************************************************************************************
// *************************************************************************************
function VisiblePlantillas(estado,elemento1,elemento2){
	elemento1=document.getElementById(elemento1);
	elemento2=document.getElementById(elemento2);	
	if(estado==1){
		elemento1.style.display='block';	
		elemento1.style.visibility='visible';
		elemento2.style.display='none';
	  	elemento2.style.visibility='hidden';
	}else{
		if (estado==2) {
			elemento2.style.display='block';	
			elemento2.style.visibility='visible';
	  		elemento1.style.display='none';
	  		elemento1.style.visibility='hidden';				
		} else {
	  		elemento1.style.display='none';
	  		elemento1.style.visibility='hidden';
	  		elemento2.style.display='none';
	  		elemento2.style.visibility='hidden';	  		
		}
	}
}
// *************************************************************************************
//Para añadir solicitudes a una resolución
numitem=0;
function crear(obj) { 
// maxitem es el número máximo de item permitidos para una resolución
maxitem=5;

  if(numitem < maxitem){ 
  numitem=numitem+1;
  fi = document.getElementById('solicitud'); // 1
  contenedor1 = document.createElement('div'); // 2
  contenedor1.id = 'div'+numitem; // 3
  fi.appendChild(contenedor1); // 4

  // Esto es para crear el campo año de la solicitud
  ano = document.createElement('input'); // 5
  ano.type = 'ano'; // 6
  ano.name = 'ano'+numitem; // 6
  ano.size = '4';
  ano.maxLength = '4';
  ano.setAttribute("class","required validate-integer");
  ano.setAttribute("onchange","Rellena(document.form.ano"+numitem+",4)");
  contenedor1.appendChild(ano); // 7
  // Esto es para crear el campo numitemero de la solicitud
  sol = document.createElement('input'); // 5
  sol.type = 'sol'; // 6
  sol.name = 'sol'+numitem; // 6
  sol.size = '6';
  sol.maxLength = '6';
  sol.setAttribute("class","required validate-integer");
  sol.setAttribute("onchange","Rellena(document.form.sol"+numitem+",6)");
  contenedor1.appendChild(sol); // 7
  // Esto es para crear el campo num solicitudes
  num = document.createElement('input'); // 5
  num.type = 'hidden'; // 6
  num.name = 'num'; // 6
  num.size = '4';
  num.value=numitem;
  num.maxLength = '2';
  num.setAttribute("class","required validate-integer");
  contenedor1.appendChild(num); // 7
  
  // Esto es para crear el boton borrar item
  sol = document.createElement('input'); // 5
  sol.type = 'button'; // 6
  sol.value = 'Borrar'; // 8
  sol.name = 'div'+numitem; // 8
  sol.onclick = function () {borrar(this.name); numitem=numitem-1;} // 9
  contenedor1.appendChild(sol); // 7

  }

}

// *************************************************************************************
//Para eliminar solicitudes a una resolución
function borrar(obj) {
  fi = document.getElementById('solicitud'); // 1 
  fi.removeChild(document.getElementById(obj)); // 10
}
//***************************************************************************************
//Para el motiva de texto del texarea
	function Inicializar()
	{
	motiva.document.designMode = 'On';
	oposicion.document.designMode = 'On';
	contestacion.document.designMode = 'On';
	}
	function Negrita()
	{
	motiva.document.execCommand('bold', false, null);
	
	}
	function Italica()
	{
	motiva.document.execCommand('italic',false, null);
	}
	function Subrayado()
	{
	motiva.document.execCommand('underline',false, null);
	}	
	function izquierdo()
	{
	motiva.document.execCommand('justifyleft', false, null);
	}
	function centrado()
	{
	motiva.document.execCommand('justifycenter', false, null);
	}
	function derecho()
	{
	motiva.document.execCommand('justifyright', false, null);
	}	
	function justificado()
	{
	motiva.document.execCommand('justifyfull', false, null);
	}

	function vineta1()
	{
	motiva.document.execCommand('insertorderedlist', false, null);
	}
	function vineta2()
	{
	motiva.document.execCommand('insertunorderedlist', false, null);
	}	
	function lineahorizontal()
	{
	motiva.document.execCommand('inserthorizontalrule', false, null);
	}	
//*****oposiciones
	function Negrita1()
	{
	oposicion.document.execCommand('bold', false, null);
	}
	function Italica1()
	{
	oposicion.document.execCommand('italic',false, null);
	}
	function Subrayado1()
	{
	oposicion.document.execCommand('underline',false, null);
	}	
	function izquierdo()
	{
	oposicion.document.execCommand('justifyleft', false, null);
	}
	function centrado1()
	{
	oposicion.document.execCommand('justifycenter', false, null);
	}
	function derecho1()
	{
	oposicion.document.execCommand('justifyright', false, null);
	}	
	function justificado1()
	{
	oposicion.document.execCommand('justifyfull', false, null);
	}

	function vineta11()
	{
	oposicion.document.execCommand('insertorderedlist', false, null);
	}
	function vineta21()
	{
	oposicion.document.execCommand('insertunorderedlist', false, null);
	}	
	function lineahorizontal1()
	{
	oposicion.document.execCommand('inserthorizontalrule', false, null);
	}
//*******/
	function Negrita2()
	{
	contestacion.document.execCommand('bold', false, null);
	}
	function Italica2()
	{
	contestacion.document.execCommand('italic',false, null);
	}
	function Subrayado2()
	{
	contestacion.document.execCommand('underline',false, null);
	}	
	function izquierdo2()
	{
	contestacion.document.execCommand('justifyleft', false, null);
	}
	function centrado2()
	{
	contestacion.document.execCommand('justifycenter', false, null);
	}
	function derecho2()
	{
	contestacion.document.execCommand('justifyright', false, null);
	}	
	function justificado2()
	{
	contestacion.document.execCommand('justifyfull', false, null);
	}
	function vineta12()
	{
	contestacion.document.execCommand('insertorderedlist', false, null);
	}
	function vineta22()
	{
	contestacion.document.execCommand('insertunorderedlist', false, null);
	}	
	function lineahorizontal2()
	{
	contestacion.document.execCommand('inserthorizontalrule', false, null);
	}
//************************************************************************************


