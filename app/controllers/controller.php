<?php
require_once 'app/models/model.php';
require_once 'app/view/view.php';
class controller{
    private $model;
    private $view;
    private $data;
    public function __construct(){
        $this->model= new model();
        $this->view=new view();
        $this->data = file_get_contents("php://input");
    }
   
/*----------------------------------invocacion GET --------------------------------------------------- */

    public function getAll($params = null){
            $data = $this->model-> getAllData();
            $this->view-> response($data, 200);
               
    }
    public function getInvById($params = null){
        $valid = $params[':ID'];
        if(!empty($valid)){
            if(empty($_GET['orderby'])){
                $id = $params[':ID'];
                $data = $this->model-> getById($id);
                if(!empty($data)){
                    $this->view->response($data);
                }else{
                    $this->view->response("La invocacion con el ID = $id no existe", 404);
                }
            }else{
            $id = $params[':ID'];
            $order =$_GET['orderby'];
            if(!empty($order) && !empty($id)){
                switch($order){
                    case 'ASC':
                        $data = $this->model->getByOrder($id,$order);
                        $this->view-> response($data, 200);
                        break;
                    case 'DESC':
                        $data = $this->model->getByOrder($id,$order);
                        $this->view-> response($data, 200);
                        break;
                    default:
                        $this->view->response("Ingrese un orden: 2 casos posibles ASC y DESC", 400);
                        break;  
                    }
            }
              
            }
        }
}

/*-------------------------------- invocacion DELETE - POST - PUT ------------------------------------ */
    public function delete($params = null){
        if(empty($params)){
            $this->view->response("coloque un ID valido", 400);
        }else{
            $id = $params[':ID'];
            $verif = $this->model->getById($id);
            if(!empty($verif)){
                $this->model-> deleteInv($id);
                $this->view->response("Se elimino con exito la invocacion ID = $id", 200);
            }else{
                $this->view->response("La invocacion que desea eliminar no existe o fue eliminada anteriormente", 404);
            }
        }
    }

    public function getData(){
        return json_decode($this->data);
    }
    public function addInv(){
       $data = $this->getData();
       if (!empty($data->nombre) && !empty($data->elemento) && !empty($data->velocidad) && !empty($data->habilidad) && !empty($data->categoria)) {
            $id = $this->model-> addInv($data->nombre, $data->elemento, $data->velocidad, $data->habilidad, $data->categoria);
            $this->view->response("La invocacion se añadio con exito, ID = $id", 201);
        } 
        else{
        $this->view->response('Hace falta completar datos!', 400);
    }
    }

    public function updateInv($params = null){
        if(!empty($params)){
            $data = $this->getData();
            if (!empty($data->nombre) || !empty($data->elemento) || !empty($data->velocidad) || !empty($data->habilidad || !empty($data->categoria))) {
                $id = $params[':ID'];
                $this->model-> update($data->nombre,$data->elemento, $data->velocidad,$data->habilidad,$data->categoria,$id);
                $this->view->response("Se modifico con exito la invocacion ID = $id",200);
            }
        }else{
            $this->view->response("complete los datos", 400);
        }
    }
    
}