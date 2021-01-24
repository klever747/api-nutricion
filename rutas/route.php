<?php 


	$routesArray = explode("/",$_SERVER['REQUEST_URI']);

	$routesArray = array_filter($routesArray);
	/*=============================================
	= Cuando no se hace ninguna peticion a la API =
	=============================================*/
	
	if(count($routesArray) == 0){

		$json = array(
		'status' => 404,
		"results" => "Not Found"
		);

		echo json_encode($json, http_response_code($json["status"]));
		return;

	}else{
		/*=============================================
		= Peticiones GET =
		=============================================*/
		
		if(count($routesArray) == 1 && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET"){


			
			/*=============================================
			= Peticiones GET con filtro=
			=============================================*/
			if (isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && 
				!isset($_GET["rel"]) && !isset($_GET["type"]) ) {

				/*=============================================
				 preguntamos si vienen variables para ordenar 
				=============================================*/
				if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
					
					$orderBy = $_GET["orderBy"];
					$orderMode = $_GET["orderMode"];
				}else{
					$orderBy = null;
					$orderMode = null;
				}

				/*=============================================
				 preguntamos si vienen variables de limite 
				=============================================*/
				if (isset($_GET["startAt"]) && isset($_GET["endAt"])) {
					
					$startAt = $_GET["startAt"];
					$endAt = $_GET["endAt"];
				}else{
					$startAt= null;
					$endAt = null;
				}

				$response = new GetController();
				$response -> getFilterData(explode("?", $routesArray[1])[0], $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode, $startAt, $endAt,$_GET["tabla_estado"],$_GET["select"]);
			
			/*=============================================
			= Peticiones GET entre tablas relacionadas sin filtro
			=============================================*/
			}else if (isset($_GET["rel"]) && isset($_GET["type"]) && explode("?", $routesArray[1])[0] == "relations" && !isset($_GET["linkTo"]) && !isset($_GET["equalTo"])) {

				/*=============================================
				 preguntamos si vienen variables para ordenar 
				=============================================*/
				if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
					
					$orderBy = $_GET["orderBy"];
					$orderMode = $_GET["orderMode"];
				}else{
					$orderBy = null;
					$orderMode = null;
				}

				/*=============================================
				 preguntamos si vienen variables de limite 
				=============================================*/
				if (isset($_GET["startAt"]) && isset($_GET["endAt"])) {
					
					$startAt = $_GET["startAt"];
					$endAt = $_GET["endAt"];
				}else{
					$startAt= null;
					$endAt = null;
				}
				$response = new GetController();
				$response -> getRelData($_GET["rel"], $_GET["type"],$orderBy, $orderMode, $startAt, $endAt,$_GET["tabla_estado"], $_GET["select"]);

			
			/*=============================================
			= Peticiones GET entre tablas relacionadas con filtro para buscar entre 2 fechas
			=============================================*/
			}else if (isset($_GET["rel"]) && isset($_GET["type"]) && explode("?", $routesArray[1])[0] == "relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && isset($_GET["fecha_ini"]) && isset($_GET["fecha_fin"])) {
				
				/*=============================================
				 preguntamos si vienen variables para ordenar y fecha
				=============================================*/
				if (isset($_GET["orderBy"]) && isset($_GET["orderMode"]) && isset($_GET["fecha_ini"]) && isset($_GET["fecha_fin"]) ) {
					
					$orderBy = $_GET["orderBy"];
					$orderMode = $_GET["orderMode"];
					$fecha_ini = $_GET["fecha_ini"];
					$fecha_fin = $_GET["fecha_fin"];
				}else{
					$orderBy = null;
					$orderMode = null;
				}

				/*=============================================
				 preguntamos si vienen variables de limite 
				=============================================*/
				if (isset($_GET["startAt"]) && isset($_GET["endAt"]) && isset($_GET["fecha_ini"]) && isset($_GET["fecha_fin"])) {
					
					$startAt = $_GET["startAt"];
					$endAt = $_GET["endAt"];
					$fecha_ini = $_GET["fecha_ini"];
					$fecha_fin = $_GET["fecha_fin"];
				}else{
					$startAt= null;
					$endAt = null;
				}

				$response = new GetController();
				$response -> getRelFilterDataDate($_GET["rel"], $_GET["type"],$_GET["linkTo"], $_GET["equalTo"],$orderBy, $orderMode, $startAt, $endAt, $_GET["tabla_estado"], $_GET["select"],$fecha_ini,$fecha_fin);
			/*=============================================
			= Peticiones GET entre tablas relacionadas con filtro
			=============================================*/
			}else if (isset($_GET["rel"]) && isset($_GET["type"]) && explode("?", $routesArray[1])[0] == "relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
				
				/*=============================================
				 preguntamos si vienen variables para ordenar 
				=============================================*/
				if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
					
					$orderBy = $_GET["orderBy"];
					$orderMode = $_GET["orderMode"];
				}else{
					$orderBy = null;
					$orderMode = null;
				}

				/*=============================================
				 preguntamos si vienen variables de limite 
				=============================================*/
				if (isset($_GET["startAt"]) && isset($_GET["endAt"])) {
					
					$startAt = $_GET["startAt"];
					$endAt = $_GET["endAt"];
				}else{
					$startAt= null;
					$endAt = null;
				}

				$response = new GetController();
				$response -> getRelFilterData($_GET["rel"], $_GET["type"],$_GET["linkTo"], $_GET["equalTo"],$orderBy, $orderMode, $startAt, $endAt, $_GET["tabla_estado"], $_GET["select"]);

		
			/*=============================================
				Peticiones GET para el buscador
			=============================================*/

			}else if(isset($_GET["linkTo"]) && isset($_GET["search"])){


				/*=============================================
				 preguntamos si vienen variables para ordenar 
				=============================================*/
				if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
					
					$orderBy = $_GET["orderBy"];
					$orderMode = $_GET["orderMode"];
				}else{
					$orderBy = null;
					$orderMode = null;
				}
				/*=============================================
				 preguntamos si vienen variables de limite 
				=============================================*/
				if (isset($_GET["startAt"]) && isset($_GET["endAt"])) {
					
					$startAt = $_GET["startAt"];
					$endAt = $_GET["endAt"];
				}else{
					$startAt= null;
					$endAt = null;
				}

				if(explode("?", $routesArray[1])[0] == "relations" && isset($_GET["rel"]) && isset($_GET["type"])){
					
					$response = new GetController();
					$response -> getSearchRelData($_GET["rel"], $_GET["type"], $_GET["linkTo"], $_GET["search"],$orderBy, $orderMode,$startAt,$endAt,$_GET['tabla_estado'],$_GET["select"]);
 

				}else{

					$response = new GetController();
					$response -> getSearchData(explode("?", $routesArray[1])[0], $_GET["linkTo"], $_GET["search"],$orderBy, $orderMode,$startAt,$endAt,$_GET["select"]);	
				}
				

			/*=============================================
			= Peticiones GET sin filtro =
			=============================================*/
			}else{
				/*=============================================
				 preguntamos si vienen variables para ordenar 
				=============================================*/
				if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
					
					$orderBy = $_GET["orderBy"];
					$orderMode = $_GET["orderMode"];
				}else{
					$orderBy = null;
					$orderMode = null;
				}
				/*=============================================
				 preguntamos si vienen variables de limite 
				=============================================*/
				if (isset($_GET["startAt"]) && isset($_GET["endAt"])) {
					
					$startAt = $_GET["startAt"];
					$endAt = $_GET["endAt"];
				}else{
					$startAt= null;
					$endAt = null;
				}


				$response = new GetController();
				$response -> getData(explode("?",$routesArray[1])[0], $orderBy, $orderMode,$startAt,$endAt,$_GET['tabla_estado'],$_GET['select']);

			}

		}

		/*=============================================
		= Peticiones POST =
		=============================================*/

		if(count($routesArray) == 1 && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
			/*=============================================
			=Traemos el listado de columnas de la tabla a cambiar=
			=============================================*/

			$columns = array();
			$columns_procedure = array();

			$database = RoutesController::db();

			$response = PostController::getColumnsData(explode("?",$routesArray[1])[0],$database);
			
			$response_proced = PostController::getColumnsDataProced(explode("?",$routesArray[1])[0],$database);
			
			
			
			foreach ($response as $key => $value) {
				
				array_push($columns, $value->item);
			}

			foreach ($response_proced as $key => $value) {
				array_push($columns_procedure, $value->item);

			}

			/*=============================================
			=Quitamos el primer y ultimo indice del array=
			=============================================*/

			array_shift($columns);
			array_pop($columns);
			array_pop($columns);
			
			/*=============================================
			=Recibimos los valores POST=
			=============================================*/
			if(isset($_POST)){

				/*=============================================
						Validamos que las variables de los campos POST coincidan con los nombres de las columnas de la base de datos
				=============================================*/
					$count = 0;
					$count_proc = 0;
					foreach (array_keys($_POST) as $key => $value) {
						$count = array_search($value, $columns);

					}
					
					foreach (array_keys($_POST) as $key => $value) {
					 	$count_proc = array_search($value, $columns_procedure);
					 }


				if(isset($_GET["token"]) && isset($_GET["procedure"]) && $_GET["procedure"] == true && $count == 0 && $count_proc > 0){

						/*=============================================
						  Traemos al usuario de acuerdo al token
						=============================================*/
						$user = GetModel::getFilterData("users", "token", $_GET["token"], null, null, null, null,$_GET['tabla_estado'],$_GET["select"]);
						
						//$paciente = GetModel::getFilterData("paciente", "token", $_GET["token"], null, null, null, null,$_GET['tabla_estado'],$_GET["select"]);				
						
						if (!empty($user)) {
							/*=============================================
						 	 Validamos que el token no haya expirado
							=============================================*/
							$time = time();

							if($user[0]->token_exp > $time ){
								/*=============================================
								=Solicitamos respuesta del controlador para crear datos de cualquier tabla=
								=============================================*/
								$response = new PostController();
								$response -> postDataProcedure(explode("?",$routesArray[1])[0],$_POST);

							}else{

								$json = array(
								'status' => 404,
								"result" => "Error: Token of nutricionista has expired "
								);

								echo json_encode($json, http_response_code($json["status"]));
								return;
							}
						}

				}else if (isset($_GET["register_paciente"]) && $_GET["register_paciente"] == true){
					
						$response = new PostController();
						$response -> postRegisterPaciente(explode("?", $routesArray[1])[0], $_POST);

				}else if($count > 0){

					/*=============================================
						Preguntamos si vienen variables de registro
					=============================================*/ 
					if (isset($_GET["register"]) && $_GET["register"] == true) {

						
						$response = new PostController();
						$response -> postRegister(explode("?", $routesArray[1])[0], $_POST);

					}else if(isset($_GET["login"]) && $_GET["login"] == true){

						$response = new PostController();
						$response -> postLogin(explode("?", $routesArray[1])[0], $_POST,$_GET['tabla_estado'],$_GET["select"]);

						
					}else  if(isset($_GET["token"])){

						/*=============================================
						  Traemos al usuario de acuerdo al token
						=============================================*/
						$user = GetModel::getFilterData("users", "token", $_GET["token"], null, null, null, null,$_GET['tabla_estado'],$_GET["select"]);
						
						//$paciente = GetModel::getFilterData("paciente", "token", $_GET["token"], null, null, null, null,$_GET['tabla_estado'],$_GET["select"]);				
						
						if (!empty($user)) {
							/*=============================================
						 	 Validamos que el token no haya expirado
							=============================================*/
							$time = time();

							if($user[0]->token_exp > $time ){
								/*=============================================
								=Solicitamos respuesta del controlador para crear datos de cualquier tabla=
								=============================================*/
								$response = new PostController();
								$response -> postData(explode("?",$routesArray[1])[0],$_POST);

							}else{

								$json = array(
								'status' => 303,
								"result" => "Error: Token of nutricionista has expired "
								);

								echo json_encode($json, http_response_code($json["status"]));
								return;
							}
							
						}else{

							$json = array(
							'status' => 404,
							"results" => "Error: The nutricionista is not authorized"
							);

							echo json_encode($json, http_response_code($json["status"]));
							return;
						}
						
					
					}else{
						$json = array(
						'status' => 404,
						"results" => "Error: Authorization require"
						);

						echo json_encode($json, http_response_code($json["status"]));
						return;
					}
					
				}else{

						$json = array(
						'status' => 404,
						"results" => "Error: Fields in the form do not match the database"
						);

						echo json_encode($json, http_response_code($json["status"]));
						return;
				}

			}
			
		}


		/*=============================================
		= Peticiones PUT =
		=============================================*/

		if(count($routesArray) == 1 && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT"){

			/*=============================================
				= Validamos que exista el ID =
			=============================================*/	
			if(isset($_GET["id"]) && isset($_GET["nameId"])){
				
				$table = explode("?", $routesArray[1])[0];
				$linkTo = $_GET["nameId"];
				$equalTo = $_GET["id"];
				$orderBy = null;
				$orderMode = null;
				$startAt = null;
				$endAt = null;
				$response = PutController::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt,$_GET["tabla_estado"],$_GET["select"]);	
				
				if ($response) {

					/*=============================================
						 Capturamos datos del formulario
					=============================================*/	
					$data = array();

					parse_str(file_get_contents('php://input'), $data);

					/*=============================================
						Traemos el listado de columnas
					=============================================*/	
					$columns = array();

					$database = RoutesController::db();

					$response = PostController::getColumnsData(explode("?",$routesArray[1])[0],$database);

					foreach ($response as $key => $value) {
				
						array_push($columns, $value->item);
					}

					/*=============================================
					=Quitamos el primer y ultimo indice del array=
					=============================================*/

					array_shift($columns);
					array_pop($columns);
					array_pop($columns);
					/*=============================================
						Validamos que las variables de los campos PUT coincidan con los nombres de las columnas de la base de datos
					=============================================*/
					$count = 0;

					foreach (array_keys($data) as $key => $value) {

						$count = array_search($value, $columns);

					}

					if ($count > 0) {

						/*=============================================
						Validamos el token de autenticaicon.
						=============================================*/
					 if(isset($_GET["token"])){


					 	/*=============================================
						Agregamos excepción para actualizar sin autorización
						=============================================*/	

						if($_GET["token"] == "no"){

							if(isset($_GET["except"])){

								$num = 0;

								foreach ($columns as $key => $value) {

									$num++;
									
									/*=============================================
									Buscamos coincidencia con la excepción
									=============================================*/

									if($value == $_GET["except"]){

										/*=============================================
										Solicitamos respuesta del controlador para editar cualquier tabla
										=============================================*/

										$response = new PutController();
										$response -> putData(explode("?", $routesArray[1])[0], $data, $_GET["id"], $_GET["nameId"]);

										return;
									}	
								}

								/*=============================================
								Cuando no encuentra coincidencia
								=============================================*/

								if($num == count($columns)){

									$json = array(
									 	'status' => 400,
									 	'results' => "The exception does not match the database"
									);

									echo json_encode($json, http_response_code($json["status"]));

									return;

								}		

							}else{

								/*=============================================
								Cuando no envian excepción
								=============================================*/		

								$json = array(
								 	'status' => 400,
								 	'results' => "There is no exception"
								);

								echo json_encode($json, http_response_code($json["status"]));

								return;

							}

						}else{
							/*=============================================
							  Traemos al usuario de acuerdo al token
							=============================================*/
							$user = GetModel::getFilterData("users", "token", $_GET["token"], null, null, null, null,"users",$_GET["select"]);
							$paciente = GetModel::getFilterData("paciente", "token", $_GET["token"], null, null, null, null,"paciente",$_GET["select"]);
							
							if (!empty($user)) {

								/*=============================================
							 	 Validamos que el token no haya expirado
								=============================================*/
								$time = time();

								if($user[0]->token_exp > $time ){

								/*=============================================
								= Solicitamos respuesta del controlador para editar cualquier tabla =
								=============================================*/		
									$response = new PutController();
									$response -> putData(explode("?", $routesArray[1])[0], $data, $_GET["id"], $_GET["nameId"]);
								}else{

									$json = array(
									'status' => 303,
									"results" => "Error: Token of nutricionista has expired "
									);

									echo json_encode($json, http_response_code($json["status"]));
									return;
								}

								
							}else if(!empty($paciente)){

								/*=============================================
							 	 Validamos que el token no haya expirado
								=============================================*/
								$time = time();

								if($paciente[0]->token_exp > $time ){

								/*=============================================
								= Solicitamos respuesta del controlador para editar cualquier tabla =
								=============================================*/		
									$response = new PutController();
									$response -> putData(explode("?", $routesArray[1])[0], $data, $_GET["id"], $_GET["nameId"]);
								}else{

									$json = array(
									'status' => 303,
									"results" => "Error: Token of paciente has expired "
									);

									echo json_encode($json, http_response_code($json["status"]));
									return;
								}

							}else{

								$json = array(
								'status' => 404,
								"results" => "Error: The user is not authorized"
								);

								echo json_encode($json, http_response_code($json["status"]));
								return;
							}
						}

					}else{
						$json = array(
						'status' => 404,
						"results" => "Error: Authorization require"
						);

						echo json_encode($json, http_response_code($json["status"]));
						return;
					}
						
					}else{

						$json = array(
						'status' => 404,
						"results" => "Error: Fields in the form do not match the database"
						);

						echo json_encode($json, http_response_code($json["status"]));
						return;

					}
					
				}else{
					$json = array(
					'status' => 404,
					"results" => "Error: the ID not found in the database"
					);

					echo json_encode($json, http_response_code($json["status"]));
					return;
				}
				
	

			}
			

		}

		/*=============================================
		= Peticiones DELETE =
		=============================================*/

		if(count($routesArray) == 1 && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE"){
			/*=============================================
				= Validamos que exista el ID =
			=============================================*/	
			if(isset($_GET["id"]) && isset($_GET["nameId"])){

				$table = explode("?", $routesArray[1])[0];
				$linkTo = $_GET["nameId"];
				$equalTo = $_GET["id"];
				$orderBy = null;
				$orderMode = null;
				$startAt = null;
				$endAt = null;
				$response = PutController::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt,$_GET['tabla_estado'],$_GET["select"]);	
				if ($response) {
					/*=============================================
						Validamos el token de autenticaicon.
						=============================================*/
					 if(isset($_GET["token"])){
					 	
						/*=============================================
						  Traemos al usuario de acuerdo al token
						=============================================*/
						$user = GetModel::getFilterData("nutricionista", "token", $_GET["token"], null, null, null, null,$_GET['tabla_estado'],$_GET["select"]);
						$paciente = GetModel::getFilterData("paciente", "token", $_GET["token"], null, null, null, null,$_GET['tabla_estado'],$_GET["select"]);


						if (!empty($user)) {
							/*=============================================
						 	 Validamos que el token no haya expirado
							=============================================*/
							$time = time();

							if($user[0]->token_exp > $time ){

								/*=============================================
								Solicitamos respuesta del controlador
								=============================================*/	
								$response = new DeleteController();
								$response -> deleteData(explode("?", $routesArray[1])[0], $_GET["id"], $_GET["nameId"]);
							}else{

								$json = array(
								'status' => 303,
								"results" => "Error: Token of nutricionista has expired "
								);

								echo json_encode($json, http_response_code($json["status"]));
								return;
							}
						
						}else if(!empty($paciente)){

							/*=============================================
						 	 Validamos que el token no haya expirado
							=============================================*/
							$time = time();

							if($paciente[0]->token_exp > $time ){

								/*=============================================
								Solicitamos respuesta del controlador
								=============================================*/	
								$response = new DeleteController();
								$response -> deleteData(explode("?", $routesArray[1])[0], $_GET["id"], $_GET["nameId"]);
							}else{

								$json = array(
								'status' => 303,
								"results" => "Error: Token of paciente has expired "
								);

								echo json_encode($json, http_response_code($json["status"]));
								return;
							}
						}else{

							$json = array(
							'status' => 404,
							"results" => "Error: The user is not authorized"
							);

							echo json_encode($json, http_response_code($json["status"]));
							return;
						}
						

					}else{
						$json = array(
						'status' => 404,
						"results" => "Error: Authorization require"
						);

						echo json_encode($json, http_response_code($json["status"]));
						return;
					}
					

				}else{
					$json = array(
					'status' => 404,
					"results" => "Error: the ID not found in the database"
					);

					echo json_encode($json, http_response_code($json["status"]));
					return;
				}
				
		}
	}

}

 