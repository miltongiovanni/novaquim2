
<?php
//include "conect.php";
class user{

  private  $_idUsuario,
		   $_nombre,
		   $_apellido,
		   $_usuario,
		   $_clave,
		   $_estadoUsuario,
		   $_idPerfil,
		   $_fecCambio,
		   $_fecCrea,
		   $_intentos;



  
  const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
  const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
  const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.
  
  
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
  

  public function idUsuario()
  {
    return $this->_idUsuario;
  }
   public function nombre()
  {
    return $this->_nombre;
  }
  public function apellido()
  {
    return $this->_apellido;
  }
    public function usuario()
  {
    return $this->_usuario;
  }
  public function clave()
  {
    return $this->_clave;
  }
  public function estadoUsuario()
  {
    return $this->_estadoUsuario;
  }
    public function idPerfil()
  {
    return $this->_idPerfil;
  }
   public function fecCambio()
  {
    return $this->_fecCambio;
  }
  public function fecCrea()
  {
    return $this->_fecCrea;
  }
    public function intentos()
  {
    return $this->_intentos;
  }


  // Liste des setters

  public function setIdUsuario($idUsuario)
  {
    
    $this->_idUsuario = $idUsuario;
  }
  public function setNombre($nombre)
  {
    
    $this->_nombre = $nombre;
  }
 public function setApellido($apellido)
  {
    
    $this->_apellido = $apellido;
  }
  public function setUsuario($usuario)
  {
    
    $this->_usuario = $usuario;
  }
  public function setClave($clave)
  {
    
    $this->_clave = $clave;
  }
  public function setEstadoUsuario($estadoUsuario)
  {
    
    $this->_estadoUsuario = $estadoUsuario;
  }
 public function setIdPerfil($idPerfil)
  {
    
    $this->_idPerfil = $idPerfil;
  }
  public function setFecCambio($fecCambio)
  {
    
    $this->_fecCambio = $fecCambio;
  }
public function setFecCrea($fecCrea)
  {
    
    $this->_fecCrea = $fecCrea;
  }
 public function setIntentos($intentos)
  {
    
    $this->_intentos = $intentos;
  }


  
}





?>
