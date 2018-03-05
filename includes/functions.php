<?php
	// PROJECT RELATED FUNCTIONS
class PHP_fun 
{
	function getConfig()
	{
	$this->SITE_URL = '';
	$this->DB_SERVER = 'localhost';
	$this->DB_USER = 'root';
	$this->DB_PASS = 'novaquim';
	$this->DB_NAME = 'novaquim';
	
	}

	function __construct()
	{
		$this->getConfig();
		$Conn=mysqli_connect("localhost", "root", "novaquim", "novaquim"); 
		if (mysqli_connect_errno()) {
	  printf("Conexión fallida: %s\n", mysqli_connect_error());
	  exit();}
	  /*
		if (!$Conn)
			die("Error: ".mysql_errno($Conn).":- ".mysql_error($Conn));
		$DB_select = mysql_select_db($this->DB_NAME, $Conn);
		if (!$DB_select)
			die("Error: ".mysql_errno($Conn).":- ".mysql_error($Conn));*/
	}

	function select_row($sql)
	{
		$Conn=mysqli_connect("localhost", "root", "novaquim", "novaquim"); 
	$data=NULL;
	//echo $sql . "<br />";
	if ($sql!="")
	{
	  $result = mysqli_query($Conn, $sql);
	  //mysql_query($sql) or die("Error: ".mysql_errno().":- ".mysql_error());
	  
	  if ($result)
	  {
		$num_rows= mysqli_num_rows($result);
		while($row =mysqli_fetch_array($result, MYSQLI_BOTH))
		  $data[] = $row;
	  }
	  return $data;
	}
	}

	function recordCount($sql)
	{
	  if ($sql!="")
	  {
	 $Conn=mysqli_connect("localhost", "root", "novaquim", "novaquim"); 
		  $result = mysqli_query($Conn, $sql);
		  if ($result)
		  {
			  $cnt = mysqli_num_rows($result);
			  return $cnt;
		  }
	  }
	}

	function createProductUrl($url)
	{
		$url = trim($url);
		if ($url != "")
		{
			$url = trim(str_replace(" ","-",$url));
			//return $url.".html";
			return $url;
		}
	}
	
	function getChild($id, $perfil)
	{
		$this->getConfig();
		$menu = "";
		$str = "";
		$s = "select id,title,parentid,link from menu where cod_user LIKE '%$perfil%' and parentid = '$id' ";
		$res = $this->select_row($s);
		$menu .= '<div id="'.$id.'" style="display:none; position:absolute;" onmouseover="javascript: return showId('.$id.');" onmouseout="javascript: return hideId('.$id.');">';
		$menu .= '<table border="0" cellspacing="0" cellpadding="0" style="border: 0px solid #ffffff;  ">';
		for ($i=0;$i<count($res);$i++)
		{
			$cnt_of_child = $this->recordCount("select id from menu where cod_user LIKE '%$perfil%' and parentid = '".$res[$i]['id']."' ");
			if ($cnt_of_child > 0)
				$str = '&nbsp;&nbsp;<img src="'.$this->SITE_URL.'images/arrow_white.gif">';
			else
				$str = " ";
				
			
			$menu .= '<tr height="21"><td align="left"  class="aerial12" onmouseover="this.className=\'aerial12over\';return showId('.$res[$i]['id'].');" onmouseout="this.className=\'aerial12\';return hideId('.$res[$i]['id'].');" style="cursor:pointer;">';
			//$menu .= '<div style="padding-left:10px;padding-right:5px; width:125px;"  onclick="javascript: return redirect(\''.$res[$i][link].'\');">';
			$menu .= '<div style="padding-left:0px; padding-right:0px; width:150px;"  onclick="javascript: window.location=\''.$res[$i]['link'].'\'">';
			$menu .= utf8_encode($res[$i]['title']).$str;	
			$menu .= '</div>';
			$menu .= '</td><td align="left" valign="top">';					
			$menu .= $this->getChild($res[$i]['id'], $perfil);
			$menu .= '</td><tr>';					
		}
		$menu .= '</table>';
		$menu .= '</div>';		
		return $menu;
	}
	
	function getMenu($parentid, $perfil)
	{
		$this->getConfig();
		$menu = "";
		$s = "select id,title,parentid,link from menu where cod_user LIKE '%$perfil%' and parentid = '$parentid'  ";
		$res = $this->select_row($s);
		ob_start();
		?>
<!-- <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css" />-->

		<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
			<tr height="25">
				
	<?php
		for ($i=0;$i<count($res);$i++)
		{ ?>
				<td align="center" valign="middle" width="11%" bgcolor="#000066">
				<div align="center" onmouseover="javascript: return showId('<?=$res[$i]['id']?>');" onmouseout="javascript: return hideId('<?=$res[$i]['id']?>');" onclick="javascript: window.location='<?=$res[$i]['link']?>';" class="aerial12" style="height:15px; vertical-align:middle; padding-top:6px;padding-bottom: 6px;cursor:pointer;"><?=utf8_encode($res[$i]['title'])?></div><?=$this->getChild($res[$i]['id'], $perfil)?>

			  </td>
			  <?php if ((count($res) - 1) > $i) {?>
				<td align="left" valign="middle" bgcolor="#000066" class="separador">|</td> <?php } ?>
		<?php } ?>
				</table>
		<?php
		$menu = ob_get_contents();
		ob_end_clean();
		return ($menu);
	}
}//class PHP_fun()
?>	