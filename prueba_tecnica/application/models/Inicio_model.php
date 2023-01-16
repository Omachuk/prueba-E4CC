
<?php
class Inicio_model extends CI_Model{

  function get_usuario($id_user=null){
    $this->db->select('*');
    $this->db->from('usuario');
    if($id_user != null){
      $this->db->where('id_usuario', $id_user);
    }
        
    $query = $this->db->get();
    return $query->result();
  }

  function insertar_usuario($user){
    $this->db->insert('usuario', $user);
    return $this->db->insert_id();
  }

  public function edit_usuario($data,$id){
      $this->db->where('id_usuario', $id);
      $this->db->update('usuario', $data); 

      return true;
  }

  function get_user($user,$password){
    $this -> db -> select('*');
    $this -> db -> from('usuario'); 
    $this -> db -> where('email', $user);
    $this -> db -> where('estado', 1);
    $this -> db -> limit(1);
    $result = $this -> db -> get();

    if($result->num_rows()>0){
      $usuario = $result->row();
      $pass = $usuario->password; 
      $contra=  $this->encryption->decrypt($pass); //la descencriptamos 
      if (strcmp($password, $contra) == 0) {
        return $result->result();
      }else{
        return false;
      }
    }else{
      return null;
    }
  }

  function usuario_activos(){
    $this->db->select('id_usuario, concat(nombre," ",apellido) as nombre');
    $this->db->from('usuario');
    $this->db->where('estado', 1);
        
    $query = $this->db->get();
    return $query->result();
  }

  function insertar_clase($clase){
    $this->db->insert('clases', $clase);
    return $this->db->insert_id();
  }

  function clases($id_clase=null){
    $this->db->select('concat(usuario.nombre," ",usuario.apellido) as profe, clases.profesor, clases.id_clase, clases.tipo_clase, clases.cantidad, clases.pagar_hora, (clases.cantidad*clases.pagar_hora) as total, clases.fecha_pagar, clases.comentario, clases.pagada');
    $this->db->from('clases');
    $this->db->join('usuario', 'usuario.id_usuario=clases.profesor');
    $this->db->where('clases.estado', 1);
    if($id_clase != null){
      $this->db->where('clases.id_clase', $id_clase);
    }
        
    $query = $this->db->get();
    return $query->result();
  }

  public function editar_clase($data,$id){
      $this->db->where('id_clase', $id);
      $this->db->update('clases', $data); 

      return true;
  }

  public function clases_user($id_usuario=null){
    $this->db->select('concat(usuario.nombre," ",usuario.apellido) as profe, clases.profesor, clases.id_clase, clases.tipo_clase, clases.cantidad, clases.pagar_hora, (clases.cantidad*clases.pagar_hora) as total, clases.fecha_pagar, clases.comentario, clases.pagada');
    $this->db->from('clases');
    $this->db->join('usuario', 'usuario.id_usuario=clases.profesor');
    $this->db->where('clases.estado', 1);
    if($id_usuario != null){
      $this->db->where('clases.profesor', $id_usuario);
    }
        
    $query = $this->db->get();
    return $query->result();
  }

}