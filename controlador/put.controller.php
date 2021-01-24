<?php 

class PutController{
	/*=============================================
			=Peticiones GET con Filtro =
	=============================================*/
	public function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select){

		$response = GetModel::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select);
		return $response;
	}
	/*=============================================
		=Peticion put para editar datos=
	=============================================*/

	public function putData($table, $data, $id, $nameId){

		if(isset($data["password"]) && $data["password"] != null ){

			$crypt = crypt($data["password"], '$2a$07$azbxcags23425sdg23sdfhsd$');
			$data["password"] = $crypt;

			$response = PutModel::putData($table, $data, $id, $nameId);
			$return = new PutController();
			$return -> fncResponse($response, "putData");
		}else{
			$response = PutModel::putData($table, $data, $id, $nameId);
			$return = new PutController();
			$return -> fncResponse($response, "putData");
		}
		
		
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