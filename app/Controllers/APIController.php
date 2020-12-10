<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController
{
    protected $modelName = 'App\Models\ModeloAnimales';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

   public function insertar(){


    $nombre=$this->request->getPost("nombre");
		$edad=$this->request->getPost("edad");
		$tipo=$this->request->getPost("tipo");
		$descripcion=$this->request->getPost("descripcion");
		$comida=$this->request->getPost("comida");
		$foto=$this->request->getPost("foto");

        $datosEnvio=array(
			"nombre"=>$nombre,
			"edad"=>$edad,
			"tipo"=>$tipo,
			"descripcion"=>$descripcion,
			"comida"=>$comida,
			"foto"=>$foto
        );
        
        if($this->validate('animalPOST')){

           $id=$this->model->insert($datosEnvio);
            return $this->respond($this->model->find($id));

        }else{
            $validation= \Config\Services::validation();

            return $this->respond($validation->getErrors());

        }


   }

   public function eliminar ($id){

    $consulta=$this->model->where('id',$id)->delete();
    $filasAfectadas=$consulta->connID->affected_rows;

    if($filasAfectadas==1){

        $mensaje=array("mensaje"=>"Registro eliminado");
        return $this->respond(json_encode($mensaje));
        //return $this->respond(json_encode($mensaje));

    }else{
        $mensaje=array("mensaje"=>"Revisar el id a eliminar");
        return $this->respond(json_encode($mensaje));

    }

   
    

   }

   public function editar($id){

    $datosAEditar=$this->request->getRawInput();

        $nombre=$datosAEditar["nombre"];
        $edad=$datosAEditar["edad"];
        
        
        $datosEnvio=array(
			"nombre"=>$nombre,
			"edad"=>$edad
        );	
            if($this->validate('animalPUT')){

                try {
                    $this->model->update($id,$datosEnvio);
                    return $this->respond($this->model->find($id));

                } catch (\Exception $error) {
                        echo($error->getErrors());
                }

              
     
             }else{
                 $validation= \Config\Services::validation();
     
                 return $this->respond($validation->getErrors());
     
             }

   }
}
