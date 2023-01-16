<?php
require_once APPPATH.'controllers/Base.php';
class Inicio extends Base {
  
    public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->library('session'); //libreria para las sessiones
        $this->load->library('encryption');//libreria para el uso de encriptacion
        $this->load->library('form_validation');
        $this->load->model('Inicio_model');
     }
    
    //metodos para inicio de sesion
    public function index(){
        $this->load->view('dashboard/header');
        $this->load->view('login');
    }

    function login(){
        $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        $this->form_validation->set_rules('email', 'Usuario', 'required');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');

        if ($this->form_validation->run() != FALSE) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $fila = $this->Inicio_model->get_user($email,$password);
            if($fila != null){
                if($fila[0]->rol == 1){
                    $rol = 'Administrador';
                }else if($fila[0]->rol == 2){
                    $rol = 'Usuario';
                }
                $data   =array(
                    'id_usuario'    => $fila[0]->id_usuario,
                    'nombre'        => $fila[0]->nombre." ".$fila[0]->apellido,
                    'rol'           => $rol,
                    'rol_tipo'      => $fila[0]->rol,
                    'usuario'       => $fila[0]->email,
                );
                $this->session->set_userdata('login', $data); 
                if($fila[0]->rol == 1){
                    redirect(base_url()."index.php/Inicio/home");
                }else if($fila[0]->rol == 2){
                    redirect(base_url()."index.php/Inicio/home_usuario");
                }
            }else{
                $dato = array('mensaje' => 'Usuario o contraseña invalido');
                $this->load->view('dashboard/header');
                $this->load->view('login',$dato);
            }
            
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('login');
        }

    }

    public function logout(){
        unset($_SESSION['login']);
        $this->load->view('dashboard/header');
        $this->load->view('login'); 
    }

    function home(){
        $this->verificar_acceso();
        $data['home'] = 'active';
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menu',$data);
        $this->load->view('Usuario/inicio');
    }

    function home_usuario(){
        $this->verificar_acceso();
        $data['home'] = 'active';
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menu',$data);
        $this->load->view('Usuario/inicio_usuario');
    }

    //mantenimiento de los usuarios de sistema
    function get_usuarios(){
        $data['user'] = 'active';
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menu',$data);
        $this->load->view('Usuario/usuarios');
    }

    function usuarios_prueba(){
        $data = $this->Inicio_model->get_usuario();

        echo json_encode($data);
    }

    function insertar_user(){
        $nombre=$this->input->post('nombre');
        $apellido=$this->input->post('apellido');
        $correo=$this->input->post('correo');
        $rol=$this->input->post('rol');

        $validacion=true;
        $data['validacion'] = '';

        if ($nombre == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el nombre del usuario <br>";
        }else if(!(preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+/", $nombre))){
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar solamente letras en el nombre <br>";
        }

        if ($apellido == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el apellido del usuario <br>";
        }else if(!(preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+/", $apellido))){
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar solamente letras en el apellido <br>";
        }

        if ($correo == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el correo del usuario <br>";
        }else if(!(preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $correo))){
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar correctamente el correo <br>";
        }

        if ($rol == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el rol del usuario <br>";
        }

        if($validacion){
            $resultado = substr($nombre, 0, 1);//primera letra del nombre
            $resultado2 = substr($apellido, 0, 1);//primera letra del apellido
            $usuario=strtoupper(substr($correo, 0, 1)); //primera letra del correo
            $numero=rand(10000, 99999);//numero aleatorio entre 10000 y 99999

            $contrasena=$resultado.$resultado2.$usuario.$numero;//concatenamos las variables
            $contra= $this->encryption->encrypt($contrasena);//encriptacion de contraseña

            $user = array(
                'nombre'    => $nombre,
                'apellido'  => $apellido,
                'email'     => $correo,
                'password'  => $contra,
                'rol'       => $rol,
                'estado'    => 1,
            );
            $this->Inicio_model->insertar_usuario($user);

            $data['contra'] = 'El usuario es: '.$correo.'<br>';
            $data['contra'] .= 'La contraseña del usuario es: '.$contrasena;
        }
        echo json_encode($data);
    }

    function get_user(){
        $id_usuario=$this->input->post('id_usuario');
        $data = $this->Inicio_model->get_usuario($id_usuario);

        echo json_encode($data);
    }

    function editar_user(){
        $id_usuario=$this->input->post('id_usuario');
        $nombre=$this->input->post('nombre_edit');
        $apellido=$this->input->post('apellido_edit');
        $correo=$this->input->post('correo_edit');
        $rol=$this->input->post('rol_edit');

        $validacion=true;
        $data['validacion'] = '';

        if ($nombre == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el nombre del usuario <br>";
        }else if(!(preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+/", $nombre))){
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar solamente letras en el nombre <br>";
        }

        if ($apellido == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el apellido del usuario <br>";
        }else if(!(preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+/", $apellido))){
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar solamente letras en el apellido <br>";
        }

        if ($correo == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el correo del usuario <br>";
        }else if(!(preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $correo))){
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar correctamente el correo <br>";
        }

        if ($rol == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar el rol del usuario <br>";
        }

        if($validacion){
            $user = array(
                'nombre'    => $nombre,
                'apellido'  => $apellido,
                'email'     => $correo,
                'rol'       => $rol,
            );
            $this->Inicio_model->edit_usuario($user,$id_usuario);
        }
        echo json_encode($data);
    }

    function delete_user(){
        $id_usuario=$this->input->post('id_usuario');
        $user = array(
            'estado'    => 0,
        );
        $this->Inicio_model->edit_usuario($user,$id_usuario);
        echo json_encode(null);
    }

    function cambiar_contra(){
        $id_usuario=$this->input->post('id_usuario');
        $user = $this->Inicio_model->get_usuario($id_usuario);

        $resultado = substr($user[0]->nombre, 0, 1);//primera letra del nombre
        $resultado2 = substr($user[0]->apellido, 0, 1);//primera letra del apellido
        $usuario=strtoupper(substr($user[0]->email, 0, 1)); //primera letra del correo
        $numero=rand(10000, 99999);//numero aleatorio entre 10000 y 99999

        $contrasena=$resultado.$resultado2.$usuario.$numero;//concatenamos las variables
        $contra= $this->encryption->encrypt($contrasena);//encriptacion de contraseña

        $users = array(
            'password'  => $contra,
        );
        $this->Inicio_model->edit_usuario($users,$id_usuario);

        $data = 'El usuario es: '.$user[0]->email.'<br>';
        $data .= 'La nueva contraseña del usuario es: '.$contrasena;

        echo json_encode($data);
    }
   
}