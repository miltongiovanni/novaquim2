
<?php
//include "conect.php";
class MenuItem{

  private  $_id,
		   $_title,
		   $_link,
		   $_parentId,
		   $_codUser;


  public function __construct(array $datos)
  {
    $this->hydrate($datos);
  }
  
  
  public function hydrate(array $datos)
  {
    foreach ($datos as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }
  
  // GETTERS //
  

  public function id()
  {
    return $this->_id;
  }
   public function title()
  {
    return $this->_title;
  }
  public function link()
  {
    return $this->_link;
  }
    public function parentId()
  {
    return $this->_parentId;
  }
  public function codUser()
  {
    return $this->_codUser;
  }
  


  // Liste des setters

  public function setId($id)
  {
    
    $this->_id = $id;
  }
  public function setTitle($title)
  {
    
    $this->_title = $title;
  }
 public function setLink($link)
  {
    
    $this->_link = $link;
  }
  public function setParentId($parentId)
  {
    
    $this->_parentId = $parentId;
  }
  public function setCodUser($codUser)
  {
    
    $this->_codUser = $codUser;
  }
  
  
}



?>
