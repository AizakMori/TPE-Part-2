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
        if(!empty($_GET['ordermode']) && !empty($_GET['orderby'])){

            if(!empty($_GET['ordermode']) && !empty($_GET['orderby']) && isset($_GET['limit']) && isset($_GET['offset'])){
                $column = $_GET['orderby'] ?? "id";
                $order = $_GET['ordermode'] ?? "asc";

                $limit = intval($_GET['limit']) ?? 5;
                $offset = intval($_GET['offset']) ?? 0;

                $data = $this->model->getByOrderAndLimits($column,$order, $offset , $limit);
                $this->view->response($data, 200);
            }else{
                $column = $_GET['orderby'] ?? "id";
                $order = $_GET['ordermode'] ?? "asc";
                $data = $this->model->getByOrder($column,$order);
                $this->view->response($data, 200);
            }
        }
            else{
            $data = $this->model-> getAllData();
            $this->view-> response($data, 200);
        }
    }

    
    public function getInvById($params = null){
        if($params != null){
            $id = $params[':ID'];
            $data = $this->model-> getById($id);
            if(!empty($data)){
                $this->view->response($data,200);
            }else{
                $this->view->response("La invocacion con el ID = $id no existe", 404);
            }
        }
    }

/*-------------------------------- invocacion DELETE - POST - PUT ------------------------------------ */
    public function delete($params = null){
        if($params != null){
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
       if (!empty($data->nombre) && !empty($data->elemento) && !empty($data->velocidad) && !empty($data->habilidad)) {
            $categoria = 1;
            $id = $this->model-> addInv($data->nombre, $data->elemento, $data->velocidad, $data->habilidad, $categoria);
            $this->view->response("La invocacion se creo con exito, ID = $id", 201);
        } 
        else{
        $this->view->response('Hace falta completar datos!', 400);
    }
    }

    public function updateInv($params = null){
        if($params!=null){
            $id = $params[':ID'];
            $verif = $this->model-> getById($id);
            if(!empty($verif)){
                $data = $this->getData();
                if (!empty($data->nombre) || !empty($data->elemento) || !empty($data->velocidad) || !empty($data->habilidad)) {
                        $categoria = 3;
                        $this->model-> update($data->nombre,$data->elemento, $data->velocidad,$data->habilidad,$categoria, $id);
                        $this->view->response("Se modifico con exito la invocacion ID = $id",200);
                    }
            }else{
                $this->view->response("No existe invocacion seleccionada ID = $id",404);
            }
        }
    }
    
}