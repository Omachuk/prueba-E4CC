<?php
require_once APPPATH.'controllers/Base.php';
class Clases extends Base {
  
    public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->library('session'); //libreria para las sessiones
        $this->load->library('encryption');//libreria para el uso de encriptacion
        $this->load->library('form_validation');
        $this->load->model('Inicio_model');
    }
    
    function index(){
        $this->verificar_acceso();
        $data['clase_menu'] = 'active';
        $data['usuario'] = $this->Inicio_model->usuario_activos();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menu',$data);
        $this->load->view('Clases/index');
    }

    //apartado para las clases
    function get_clases(){
        $data = $this->Inicio_model->clases();
        echo json_encode($data);
    }

    function insert_clases(){
        $profesor=$this->input->post('profesor');
        $tipo_clase=$this->input->post('tipo_clase');
        $cantidad_hora=$this->input->post('cantidad_hora');
        $cantidad_pagar=$this->input->post('cantidad_pagar');
        $fecha_pagar=$this->input->post('fecha_pagar');
        $comentario=$this->input->post('comentario');
        $pagado=$this->input->post('pagado');

        $validacion=true;
        $data['validacion'] = '';

        if ($profesor == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar un profesor <br>";
        }
        if ($tipo_clase == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar el tipo de clases <br>";
        }
        if ($cantidad_hora == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar la cantidad de horas de clases <br>";
        }else if($cantidad_hora <= 0){
            $validacion=false;
            $data['validacion'] .= "La cantidad de horas debe de ser mayor a cero <br>";
        }
        if ($cantidad_pagar == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar la cantidad del costo de la hora clase <br>";
        }else if($cantidad_pagar <= 0){
            $validacion=false;
            $data['validacion'] .= "La ccantidad del costo de la hora debe de ser mayor a cero <br>";
        }
        if ($fecha_pagar == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar la fecha a pagar <br>";
        }
        if ($comentario == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar el comentario <br>";
        }
        if ($pagado == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de indicar si esta o no pagada la clase <br>";
        }

        if($validacion){
            $clase = array(
                'tipo_clase'        => $tipo_clase,
                'cantidad'          => $cantidad_hora,
                'pagar_hora'        => $cantidad_pagar,
                'fecha_pagar'       => $fecha_pagar,
                'comentario'        => $comentario,
                'pagada'            => $pagado,
                'profesor'          => $profesor,
                'estado'            => 1,
                
            );
            $this->Inicio_model->insertar_clase($clase);
        }
        echo json_encode($data);
    }//fin function insert_clases

    function get_class(){
        $id_clase=$this->input->post('id_clase');
        $data = $this->Inicio_model->clases($id_clase);

        echo json_encode($data);
    }

    function editar_class(){
        $id_clase=$this->input->post('id_clase');
        $profesor=$this->input->post('profesor');
        $tipo_clase=$this->input->post('tipo_clase');
        $cantidad_hora=$this->input->post('cantidad_hora');
        $cantidad_pagar=$this->input->post('cantidad_pagar');
        $fecha_pagar=$this->input->post('fecha_pagar');
        $comentario=$this->input->post('comentario');
        $pagado=$this->input->post('pagado');

        $validacion=true;
        $data['validacion'] = '';

        if ($profesor == null) {
            $validacion=false;
            $data['validacion'] .= "Debe ingeresar un profesor <br>";
        }
        if ($tipo_clase == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar el tipo de clases <br>";
        }
        if ($cantidad_hora == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar la cantidad de horas de clases <br>";
        }else if($cantidad_hora <= 0){
            $validacion=false;
            $data['validacion'] .= "La cantidad de horas debe de ser mayor a cero <br>";
        }
        if ($cantidad_pagar == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar la cantidad del costo de la hora clase <br>";
        }else if($cantidad_pagar <= 0){
            $validacion=false;
            $data['validacion'] .= "La ccantidad del costo de la hora debe de ser mayor a cero <br>";
        }
        if ($fecha_pagar == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar la fecha a pagar <br>";
        }
        if ($comentario == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de ingresar el comentario <br>";
        }
        if ($pagado == null) {
            $validacion=false;
            $data['validacion'] .= "Debe de indicar si esta o no pagada la clase <br>";
        }

        if($validacion){
            $clase = array(
                'tipo_clase'        => $tipo_clase,
                'cantidad'          => $cantidad_hora,
                'pagar_hora'        => $cantidad_pagar,
                'fecha_pagar'       => $fecha_pagar,
                'comentario'        => $comentario,
                'pagada'            => $pagado,
                'profesor'          => $profesor,
                'estado'            => 1,
                
            );
            $this->Inicio_model->editar_clase($clase,$id_clase);
        }
        echo json_encode($data);
    }

    function clases_usuario(){
        $data = $this->Inicio_model->clases_user($_SESSION['login']['id_usuario']);

        echo json_encode($data);
    }
}