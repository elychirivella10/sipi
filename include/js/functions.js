//intervalo tiempo cambio img slide, 5 segundos, se llama a la funci?n "avanzaSlide()"
setInterval('avanzaSlide()',5000);
 
//array con las clases para las diferentes imagenes
var arrayImagenes = new Array(".img1",".img2",".img3",".img4",".img5",".img6");
 
//variable que nos permitir? saber qu? imagen se est? mostrando
var contador = 0;
 
//hace un efecto fadeIn para mostrar una imagen
function mostrar(img){
	$(img).ready(function(){				
  		$(arrayImagenes[contador]).fadeIn(1500);		
	});
}
 
//hace un efecto fadeOut para ocultar una imagen
function ocultar(img){
	$(img).ready(function(){				
  		$(arrayImagenes[contador]).fadeOut(1500);		
	});
}
 
//funci?n principal
function avanzaSlide(){
        //se oculta la imagen actual
	ocultar(arrayImagenes[contador]);
        //aumentamos el contador en una unidad
	contador = (contador + 1) % 6;
        //mostramos la nueva imagen
	mostrar(arrayImagenes[contador]);
}
