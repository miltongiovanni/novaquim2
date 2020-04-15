<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
  <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
  <title>Ingreso de Empleados</title>
  <meta charset="utf-8">
  <script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>INGRESO DE EMPLEADOS</strong></div> 
<form name="form2" method="POST" action="makeEmpleado.php">
<table border="0" align="center" summary="">
  <tr><td><div align="right"><strong>&nbsp;</strong></div></td></tr>
  <tr> 
    <td><div align="right"><strong>Cédula:</strong></div></td>
    <td colspan="2" ><input type="text" name="cedula" size=30 onKeyPress="return aceptaNum(event)" maxlength="10"></td>
  </tr>
  <tr> 
    <td width="182"><div align="right"><b>Primer Nombre:</b></div></td>
    <td  colspan="2"><input type="text" name="nombre1" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30"></td>
  </tr>
  <tr> 
    <td width="182"><div align="right"><b>Segundo Nombre:</b></div></td>
    <td  colspan="2"><input type="text" name="nombre2" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30" value=" "></td>
  </tr>
  <tr> 
    <td width="182"><div align="right"><b>Primer Apellido:</b></div></td>
    <td  colspan="2"><input type="text" name="apellido1" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30"></td>
  </tr>
  <tr> 
    <td width="182"><div align="right"><b>Segundo Apellido:</b></div></td>
    <td  colspan="2"><input type="text" name="apellido2" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30"></td>
  </tr>
  <tr> 
    <td><div align="right"><strong>ARL</strong></div></td>
    <td colspan="2" >
    <select name="arl_emp">
	<?php
        $link=conectarServidor();
        $qry="select Id_arl, nom_arl from arl;";	
        $result=mysqli_query($link,$qry);
        echo '<option value="9" selected>Seguros Colpatria</option>';
        while($row=mysqli_fetch_array($result))
        {
            if ($row['Id_arl']!=9)
                echo '<option value="'.$row['Id_arl'].'">'.$row['nom_arl'].'</option>';
        }
		mysqli_free_result($result);
        mysqli_close($link);
    ?>
    </select> 
  </tr>
  <tr> 
    <td><div align="right"><strong>Lugar de trabajo</strong></div></td>
    <td colspan="2" >
    <select name="cat_arl_emp">
      <option value="1">Oficina</option>
      <option value="3">Planta</option>
    </select> 
  </tr>
  <tr> 
    <td><div align="right"><strong>EPS</strong></div></td>
    <td colspan="2" >
    <select name="emps_emp">
        <?php
            $link=conectarServidor();
            $qry="select Id_eps, Nom_eps from eps order by Nom_eps;";	
            $result=mysqli_query($link,$qry);
            echo '<option value="" selected>-------------------------</option>';
            while($row=mysqli_fetch_array($result))
            {
                    echo '<option value="'.$row['Id_eps'].'">'.$row['Nom_eps'].'</option>';
            }
            mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </select> 
  </tr>
  <tr> 
    <td><div align="right"><strong>AFP</strong></div></td>
    <td colspan="2" >
    <select name="afp_emp">
        <?php
            $link=conectarServidor();
            $qry="select Id_f_pension, nom_f_pension from f_pension order by nom_f_pension;";	
            $result=mysqli_query($link,$qry);
            echo '<option value="" selected>-------------------------</option>';
            while($row=mysqli_fetch_array($result))
            {
                echo '<option value="'.$row['Id_f_pension'].'">'.$row['nom_f_pension'].'</option>';
            }
            mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </select> 
  </tr>
  <tr> 
    <td><div align="right"><strong>Caja de Compensaci&oacute;n</strong></div></td>
    <td colspan="2" >
    <select name="caja_emp">
        <?php
            $link=conectarServidor();
            $qry="select Id_caja, nom_caja from caja_comp;";	
            $result=mysqli_query($link,$qry);
            echo '<option value="1" selected>Colsubsidio</option>';
            while($row=mysqli_fetch_array($result))
            {
                if ($row['Id_caja']!=1)
                    echo '<option value="'.$row['Id_caja'].'">'.$row['nom_caja'].'</option>';
            }
            mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </select> 
  </tr>
  <tr> 
    <td><div align="right"><strong>Cesant&iacute;as</strong></div></td>
    <td colspan="2" >
    <select name="ces_emp">
        <?php
            $link=conectarServidor();
            $qry="select Id_f_cesant, nom_f_cesant from f_cesantias order by nom_f_cesant";	
            $result=mysqli_query($link,$qry);
            echo '<option value="" selected>-------------------------</option>';
            while($row=mysqli_fetch_array($result))
            {
                echo '<option value="'.$row['Id_f_cesant'].'">'.$row['nom_f_cesant'].'</option>';
            }
            mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </select> 
  </tr>
  <tr>
  <td align="right"><strong>Fecha de Ingreso</strong></td>
  <td colspan="2"><input type="text" name="FchIng" id="sel1" readonly size=20><input type="reset" value=" ... "
    onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
  </tr>
  <tr> 
    <td colspan="1"><div align="right"><strong>Salario B&aacute;sico</strong></div></td>
    <td colspan="2" ><input type="text" name="sal_emp" size=30 onKeyPress="return aceptaNum(event)" maxlength="10"></td>
  </tr>
  <tr> 
    <td><div align="right"><strong>Estado</strong></div></td>
    <td colspan="2" >
    <select name="estado">
        <?php
            $link=conectarServidor();
            $qry="select IdEstado, Descripcion from estados_pers;";	
            $result=mysqli_query($link,$qry);
            echo '<option value="1" selected>Activo</option>';
            while($row=mysqli_fetch_array($result))
            {
                if ($row['IdEstado']!=1)
                    echo '<option value="'.$row['IdEstado'].'">'.$row['Descripcion'].'</option>';
            }
            mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </select> 
  </tr>
  <tr> 
    <td><div align="right"><strong>&Aacute;rea</strong></div></td>
    <td colspan="2" >
    <select name="area">
        <?php
            $link=conectarServidor();
            $qry="select Id_area, area from areas_personal;";	
            $result=mysqli_query($link,$qry);
            echo '<option value="" selected>----------------------------</option>';
            while($row=mysqli_fetch_array($result))
            {
                    echo '<option value="'.$row['Id_area'].'">'.$row['area'].'</option>';
            }
            mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </select> 
  </tr>
  <tr> 
    <td><div align="right"><strong>Cargo</strong></div></td>
    <td colspan="2" >
    <select name="cargo">
        <?php
            $link=conectarServidor();
            $qry="select Id_cargo, cargo from cargos_personal;";	
            $result=mysqli_query($link,$qry);
            echo '<option value="" selected>------------------------------------</option>';
            while($row=mysqli_fetch_array($result))
            {
                    echo '<option value="'.$row['Id_cargo'].'">'.$row['cargo'].'</option>';
            }
            mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </select> 
  </tr>
  <tr> 
    <td>   </td>
    <td width="111" align="center"><input type="button" value="    Enviar    " onClick="return Enviar(this.form);"></td>
    <td width="117" align="center"><input type="reset" value="Restablecer"></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center">&nbsp;</div></td>
  </tr>
  <tr> 
    <td colspan="3">
    <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="VOLVER"></div>
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>

