
<html> 
<head> 
<title> Expandir Pagina Pantalla Completa </title>
<!--Inicio del script, Creado Por (¯`·._¦¤ÅMãNt£¤¦_.·´¯) -->
<script language="JavaScript"> 

function abreSinNavegacion(){ 
open('http://localhost/novaquim/index.php', 'principal', 'location=no,menubar=no,status=no,toolbar=no'); 
cerrar(); 
} 

function cerrar() { 
var ventana = window.self; 
ventana.opener = window.self; 
ventana.close(); 
} 

</script> 
</head> 
<body onload="abreSinNavegacion()"> 
</body> 
</html>
