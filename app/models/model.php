<?php 
class model{
    private $db;
    private $data;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_tpe;charset=utf8','root','');
    }

    function getAllData(){
        $query = $this->db->prepare('SELECT id, nombre, elemento, velocidad, habilidad FROM invocacion');
        $query->execute();
        $valores = $query->fetchAll(PDO::FETCH_OBJ);
        return $valores;
        }
        public function getById($id){
            $query = $this->db->prepare('SELECT id, nombre, elemento, velocidad, habilidad FROM invocacion WHERE id = ?');
            $query->execute([$id]);
            $valores = $query->fetchAll(PDO::FETCH_OBJ);
            return $valores;
        }
        public function getByOrder($column, $order){
            $query = $this->db->prepare("SELECT id, nombre, elemento, velocidad, habilidad FROM invocacion order by $column $order");
            $query->execute();
            $valores = $query->fetchAll(PDO::FETCH_OBJ);
            return $valores;
        }
        public function getByOrderAndLimits($column,$order, $offset , $limit){
            $query = $this->db->prepare("SELECT id, nombre, elemento, velocidad, habilidad FROM invocacion order by $column $order LIMIT $offset, $limit");
            $query->execute();
            $valores = $query->fetchAll(PDO::FETCH_OBJ);
            return $valores;
        }
        public function deleteInv($id){
            $query = $this->db->prepare('DELETE FROM invocacion WHERE id = ?');
            $query->execute([$id]);
        }
        public function addInv($nombre, $elemento, $velocidad, $habilidad, $categoria){
            $query = $this->db->prepare("INSERT INTO invocacion (nombre, elemento, velocidad, habilidad, id_puntos) VALUES (?, ?, ?, ?, ?)");
            $query->execute([$nombre, $elemento, $velocidad, $habilidad, $categoria]);
            return $this->db->lastInsertId();
        }
        public function update($nombre, $elemento, $velocidad, $habilidad, $categoria,$id){
            try{
                $query = $this->db->prepare('UPDATE invocacion SET  nombre = ?, elemento=?, velocidad= ?, habilidad =?, id_puntos = ? WHERE id= ?;');
                $query->execute([$nombre, $elemento, $velocidad, $habilidad, $categoria , $id]);
                $mensaje = "Se completo la modificacion de la invocacion ID = $id";
                return $mensaje;
            }catch(Exception $e){
                $mensaje = "Hubo un error en la modificacion de la invocacion ID = $id";
                return $mensaje;
            }
        }
}