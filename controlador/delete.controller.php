<?php 

class DeleteController{
	/*=============================================
		Peticion para borrar datos
	=============================================*/	

	public function deleteData($table, $id, $nameId){
		$response = deleteModel::deleteData($table, $id, $nameId);
		$return = new DeleteController();
		$return -> fncResponse($response,"deleteData"); 
	}
	/*=============================================
	=Respuesta del controlador=
	=============================================*/
	public function fncResponse($response, $method){

		if(!empty($response)){

			$json = array(
			'status' => 200,
			
			"results" => $response
			);
			echo json_encode($json);
			return;
		}else{

			$json = array(
				'status' => 404,
				"results" => "Not Found",
				'method' =>$method

			);
		}

		echo json_encode($json,http_response_code($json["status"]));
		return;
	}
}