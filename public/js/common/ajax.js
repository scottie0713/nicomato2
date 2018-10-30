		function ajaxFunction() {
			var xmlHttp;
			try{
				// Firefox, Opera 8.0+, Safari
				xmlHttp=new XMLHttpRequest();
				return xmlHttp;
			} catch (e) {
			 // Internet Explorer
				try {
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				return xmlHttp;
				} catch (e) {
					try {
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
					return xmlHttp;
					} catch (e) {
						alert("Tu navegador no soporta AJAX!");
						return false;
					}}}
		}
		function Enviar(_pagina,capa) {
			var
			ajax;
			ajax = ajaxFunction();
			
			ajax.open("POST", _pagina, true);
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			
			ajax.onreadystatechange = function()
			{
				if (ajax.readyState == 4){
				document.getElementById(capa).innerHTML =
				ajax.responseText;			
				}
			}			
			ajax.send(null);
		}
		function Enviar2(_pagina,capa) {
			var
			ajax;
			ajax = ajaxFunction();
			
			ajax.open("GET", _pagina, true);
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			
			ajax.onreadystatechange = function()
			{
				if (ajax.readyState == 4){
				document.getElementById(capa).innerHTML =
				ajax.responseText;			
				}
			}			
			ajax.send(null);
		}
	function desplegarContraer(cual,desde) {          
		  var elElemento=document.getElementById(cual);
      
		   if(elElemento.className == 'elementoVisible') {
             elElemento.className = 'elementoOculto';
             desde.className = 'linkContraido';
           }else{
             elElemento.className = 'elementoVisible';
             desde.className = 'linkExpandido';
            }
    }
    function maximaLongitud(texto,maxlong){
			var tecla, int_value, out_value;

				if (texto.value.length > maxlong){
					/*con estas 3 sentencias se consigue que el texto se reduzca
					al tamaño maximo permitido, sustituyendo lo que se haya
					introducido, por los primeros caracteres hasta dicho limite*/
					in_value = texto.value;
					out_value = in_value.substring(0,maxlong);
					texto.value = out_value;
					alert("La longitud m\xE1xima es de " + maxlong + " caract\xE9res");
						return false;
        }
        
 				return true;
		}
    function guardarSubmit(){
     document.Prefs.submit();
    }
	function guardarSubmitActualiza(){
     document.Actualiza.submit();
    }
	function eliminarDato(num_serie,es_admin){
	   //donde se mostrará el resultado de la eliminacion
	   divResultado = document.getElementById('resultado');
   
	   //usaremos un cuadro de confirmacion 
	   var eliminar = confirm("Desea eliminar este dato?")

		   if( ( eliminar==true )&&( es_admin==1 ) ){
			   //instanciamos el objetoAjax
			   ajax=ajaxFunction();
			   //uso del medotod GET
			   //indicamos el archivo que realizará el proceso de eliminación
			   //junto con un valor que representa el id del empleado
		       alert("El administrador recibe una copia de esta acci\xF3n ,un mensaje se enviar\xE1 \na la bandeja de  alertas confirmando el cambio.");
			   Enviar2('/invcence/web/modulos/Inventario/Eliminacion.accion.php?serie='+num_serie,'contenido')
		   }else{		   					

		   }
   }
   function MuestraFicha(){
		if(document.getElementById("seEsconde").style.visibility == "hidden"){
		 document.getElementById("seEsconde").style.visibility = "visible";
		}else{
		 document.getElementById("seEsconde").style.visibility = "hidden"; 	
		}
   }
   function MuestraFiltrosActualizacion(){
     if(document.getElementById("filtroActualizacion").style.visibility == "hidden"){
		 document.getElementById("filtroActualizacion").style.visibility = "visible";
		}else{
		 document.getElementById("filtroActualizacion").style.visibility = "hidden"; 	
	 }
   }
   function MuestraFiltrosInventario(){
     if(document.getElementById("filtros").style.visibility == "hidden"){
		 document.getElementById("filtros").style.visibility = "visible";
		}else{
		 document.getElementById("filtros").style.visibility = "hidden"; 	
	 }	   
   }
   function MuestraAlertBueno(){
	  document.getElementById("alerta2").style.visibility = "visible";
   }
   function MuestraAlertMalo(){
	  document.getElementById("alerta").style.visibility = "visible";
   }
   function validar() {
		if( (document.Actualiza.serie_p.value.length>0)&&(document.Actualiza.serie_p.value.length<=8) ){
			document.getElementById("mensaForm").style.visibility = "hidden";  
		}else{
			document.getElementById("mensaForm").style.visibility = "visible";  
		}
   }
   function validarRegistro() {
		if( (document.Prefs.serie_p.value.length>0)&&(document.Prefs.serie_p.value.length<=8) ){
			document.getElementById("mensaForm").style.visibility = "hidden";  
		}else{
			document.getElementById("mensaForm").style.visibility = "visible";  
		}
   }
   function serieDisponible(){

     if(sesion == "1"){
	  MuestraAlertBueno(); 
	 }else{
	  MuestraAlertMalo(); 
	 }
	 
   }
   function enviafiltros(e,filtro,valor){
	 tecla = (document.all) ? e.keyCode : e.which;

     if(tecla==13){
	  switch(filtro){
		case 1: Enviar2('/INVCENCE/web/nucleo/Datos/Filtros.class.php?filtro='+filtro+'&valor='+valor,'contenido');	 
	            break;
		case 2: Enviar2('/INVCENCE/web/nucleo/Datos/Filtros.class.php?filtro='+filtro+'&valor='+valor,'contenido');
		        break;				
		case 3: Enviar2('/INVCENCE/web/nucleo/Datos/Filtros.class.php?filtro='+filtro+'&valor='+valor,'contenido');	
		        break;
		default:break;
	  }	 
     }
   }
   
   function FiltroUsuario(seleccionado){
    var user = document.getElementById(seleccionado).value;
    Enviar2('/INVCENCE/web/modulos/Alertas/filtro.php?userFiltro='+user,'contenido');
   }
   function Resalta(nombreElemento){
    document.getElementById(nombreElemento).style.color = "#000";
   }
   function Apaga(nombreElemento){
    document.getElementById(nombreElemento).style.color = "#CCC";
   }
   
   function Encendido(nombreElemento){
    document.getElementById(nombreElemento).style.background = "#DDF4F7";
   }
   function Apagado(nombreElemento){
    document.getElementById(nombreElemento).style.background = "#FFF";
   }
   function FiltroActualizacion(e,filtro){
	 tecla = (document.all) ? e.keyCode : e.which;

     if(tecla==13){
       Enviar2('/INVCENCE/web/modulos/Inventario/Actualizacion.filtro.php?filtro2='+filtro,'contenido');	  		 
	 }
	 
   }
   MuestraFiltrosActualizacion
  /* function valida_envia(){
    //valido el nombre
    if (document.fvalida.nombre.value.length==0){
       alert("Tiene que escribir su nombre")
       document.fvalida.nombre.focus()
       return 0;
    }

    //valido la edad. tiene que ser entero mayor que 18
    edad = document.fvalida.edad.value
    edad = validarEntero(edad)
    document.fvalida.edad.value=edad
    if (edad==""){
       alert("Tiene que introducir un número entero en su edad.")
       document.fvalida.edad.focus()
       return 0;
    }else{
       if (edad<18){
          alert("Debe ser mayor de 18 años.")
          document.fvalida.edad.focus()
          return 0;
       }
    }

    //valido el interés
    if (document.fvalida.interes.selectedIndex==0){
       alert("Debe seleccionar un motivo de su contacto.")
       document.fvalida.interes.focus()
       return 0;
    }

    //el formulario se envia
    alert("Muchas gracias por enviar el formulario");
    document.fvalida.submit();
} */