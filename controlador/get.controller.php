<?php 

class GetController{
	/*=============================================
	=Peticiones GET sin Filtro =
	=============================================*/
	public function getData($table, $orderBy, $orderMode, $startAt,$endAt,$tabla_estado, $select){

			$response = GetModel::getData($table, $orderBy, $orderMode, $startAt,$endAt,$tabla_estado,$select);
			$return = new GetController();
			$return->fncResponse($response, "getData");
	}

	/*=============================================
			=Peticiones GET con Filtro =
	=============================================*/
	public function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select){

		$response = GetModel::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select);
		$return = new GetController();
		$return->fncResponse($response, "getFilterData");
	}
	/*=============================================
			=Peticiones GET con Filtro para las fechas=
	=============================================*/
	public function getRelFilterDataDate($rel, $type, $linkTo, $equalTo,$orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select,$fecha_ini,$fecha_fin){

		$response = GetModel::getRelFilterDataDate($rel, $type, $linkTo, $equalTo,$orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select,$fecha_ini,$fecha_fin);
		$return = new GetController();
		$return->fncResponse($response, "getRelFilterDataDate");
	}
	/*=============================================
	=Peticiones GET entre tablas relacionadas sin filtro =
	=============================================*/
	public function getRelData($rel, $type, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select){

		$response = GetModel::getRelData($rel, $type, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select);
		$return = new GetController();
		$return->fncResponse($response, "getRelData");
	}

	/*=============================================
	=Peticiones GET entre tablas relacionadas con filtro =
	=============================================*/
	public function getRelFilterData($rel, $type, $linkTo, $equalTo,$orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select){

		$response = GetModel::getRelFilterData($rel, $type, $linkTo, $equalTo,$orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select);
		$return = new GetController();
		$return->fncResponse($response, "getRelFilterData");
	}
	/*=============================================
		peticiones GET para el buscador
	=============================================*/
	public function getSearchData($table, $linkTo, $search,$orderBy, $orderMode,$startAt, $endAt,$tabla_estado,$select){

		$response = GetModel::getSearchData($table, $linkTo,$search,$orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select);
		$return = new GetController();
		$return->fncResponse($response, "getSearchData");
	}

	/*=============================================
		peticiones GET para el buscador entre tablas relacionadas
	=============================================*/
	public function getSearchRelData($rel, $type, $linkTo, $search, $orderBy, $orderMode,$startAt, $endAt,$tabla_estado,$select){

		$response = GetModel::getSearchRelData($rel, $type, $linkTo, $search, $orderBy, $orderMode,$startAt, $endAt,$tabla_estado,$select);		
		$return = new GetController();
		$return->fncResponse($response, "getSearchRelData");
	}
	/*=============================================
	=Respuesta del controlador=
	=============================================*/
	public function fncResponse($response, $method){

		if(!empty($response)){

			$json = array(
			'status' => 200,
			'total' => count($response),
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
 ?>
