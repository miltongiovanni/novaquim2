<?php 
// On enregistre notre autoload.

function chargerClasse($classname) {
  require 'includes/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');
$menum=new menusManager();
$menuItems=$menum->getMenuItems(9);
//print_r($menuItems);
echo count($menuItems);
//var_dump($menuItems);

function getMenuSons($parent, $menuItems) {
 
  echo "<ul>"; //echo "son ".$parent;
  for ($row=0; $row < count($menuItems);  $row++) {
    if ($menuItems[$row][3]==$parent) {
      echo '<li><a href="'.$menuItems[$row][2].'">'.$menuItems[$row][1].'</a>';
      $son=$menuItems[$row][0];
      //echo "son ".$son;
      getMenuSons($son, $menuItems);
      //getMenuGrandSons($son, $menuItems);
      echo '</li>';
    }
  }
  echo "</ul>";

  
}
function getMenuGrandSons($son, $menuItems) {
  if ($parent<1000){

  echo "<ul>";
  for ($row=0; $row < count($menuItems);  $row++) {
    if ($menuItems[$row][3]==$son) {
      echo '<li><a href="'.$menuItems[$row][2].'">'.$menuItems[$row][1].'</a>';
      $grandSon=$menuItems[$row][0];
      //getMenuSons($parent, $menuItems);
      echo '</li>';
    }
  }
  echo "</ul>";
}
}

getMenuSons(0, $menuItems);