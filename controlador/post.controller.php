<?php 
use Firebase\JWT\JWT;
class PostController{
	/*=============================================
		=Peticion para tomar el nombre de columnas=
	=============================================*/

	static public function getColumnsData($table, $database){
		$response = PostModel::getColumnsData($table, $database);
		return $response;
	}
	/*=============================================
	Peticion para tomar el nombre de columnas del procedimiento almacenado
	=============================================*/
	static public function getColumnsDataProced($procedure, $database){
		$response = PostModel::getColumnsDataProced($procedure, $database);
		return $response;
	}
	/*=============================================
			=Peticion POST para crear Datos=
	=============================================*/
	public function postData($table, $data){

		$response = PostModel::postData($table, $data);

		$return = new PostController();
		$return ->fncResponse($response,"postData", null);
	}

	/*=============================================
	Peticion POST para registrar nutricionistas y pacientes
	=============================================*/
	public function postRegister($table, $data){
		if(isset($data["password_user"]) && $data["password_user"] != null ){

			$crypt = crypt($data["password_user"], '$2a$07$azbxcags23425sdg23sdfhsd$');
			$data["password_user"] = $crypt;

			$response = PostModel::postData($table, $data);

			$return = new PostController();
			$return ->fncResponse($response,"postData", null);
		}else{

			
			$response = PostModel::postData($table, $data);

			if($response == "The process was successful"){

				$user = GetModel::getFilterData($table, "email_user", $data["email_user"], null, null, null, null,"users","*");

				if (!empty($user)) {

					/*=============================================
						Creacion del JWT
					=============================================*/
					$time = time();
					$key = "asdvascggqs14fvkl7q48";
					$token = array(
						"iat" => $time, //tiempo que inicio el token
						"exp" => $time + (60*60*24), //tiempo que expirara el token
						'data' => [
							"id" =>$user[0]->id_user,
							"email" =>$user[0]->email_user
						]
					);

					$jwt = JWT::encode($token, $key);

					/*=============================================
						Actualizamos la BD con el token del usuario
					=============================================*/
					$data = array(
						"token" => $jwt,
						"token_exp" => $token["exp"]
					);

					$update = PutModel::putData($table, $data, $user[0]->id_user, "id_user");

					if($update == "The process was successfull"){

						$return = new PostController();
						$return ->fncResponse($response,"postData", null);
					}
				}
			}
			
		}
	}
	/*=============================================
	Peticion POST para registrar nutricionistas y pacientes
	=============================================*/
	public function postRegisterPaciente($table, $data){
		if(isset($data["password_user"]) && $data["password_user"] != null ){

			$crypt = crypt($data["password_user"], '$2a$07$azbxcags23425sdg23sdfhsd$');
			$data["password_user"] = $crypt;

			$response = PostModel::postDataPaciente($table, $data);

			$return = new PostController();
			$return ->fncResponse($response,"postData", null);
		}
	}
	/*=============================================
	Peticion POST para crear el Login
	=============================================*/
	public function postLogin($table, $data,$tabla_estado,$select){
		$response = GetModel::getFilterData($table, "email_user", $data["email_user"], null, null, null, null,$tabla_estado,$select);

		
		if (!empty($response)) {
			/*=============================================
				Encriptamos la contraseña
			=============================================*/

			$crypt = crypt($data["password_user"], '$2a$07$azbxcags23425sdg23sdfhsd$');
			
			if ($response[0]->password_user == $crypt) {

			/*=============================================
				Creacion del JWT
			=============================================*/
			$time = time();
			$key = "asdvascggqs14fvkl7q48";
			$token = array(
				"iat" => $time, //tiempo que inicio el token
				"exp" => $time + (60*60*24), //tiempo que expirara el token
				'data' => [
					"id" =>$response[0]->ci_user,
					"email" =>$response[0]->email_user
				]
			);

			$jwt = JWT::encode($token, $key);
			/*=============================================
				Actualizamos la BD con el token del usuario
			=============================================*/
			$data = array(
				"token" => $jwt,
				"token_exp" => $token["exp"]
			);
			$update = PutModel::putData($table, $data, $response[0]->id_user, "id_user");

			if($update == "The process was successfull"){
				$response[0]->token  = $jwt;
				$response[0]->token_exp  = $token["exp"]; 

				$return = new PostController();
				$return -> fncResponse($response, "postLogin", null);

			}
				

			}else{
				$response = null;
				$return = new PostController();
				$return -> fncResponse($response, "postLogin", "Wrong password");
			}
		}else{

			$response = null;
			$return = new PostController();
			$return -> fncResponse($response, "postLogin", "Wrong email");
		}
	}

	/*=============================================
	 Peticion POST para registrar el menu del paciente
	=============================================*/
	public function postDataProcedure($procedure, $data){

		$response = PostModel::postDataProcedure($procedure, $data);
	
		$return = new PostController();
		$return ->fncResponse($response,"postDataProcedure", null);
	}
	/*=============================================
	=Respuesta del controlador=
	=============================================*/
	public function fncResponse($response, $method, $error){

		if(!empty($response)){
			if (isset($response[0]->password)) {
				unset($response[0]->password); 
			}
			$json = array(
			'status' => 200,
			"results" => $response
			);

		}else{

			if ($error != null) {
				
				$json = array(
					'status' => 400,
					"results" => $error
				);
			}else{
				$json = array(
					'status' => 404,
					"results" => "Not Found",
					'method' =>$method

				);
			}
		}

		echo json_encode($json,http_response_code($json["status"]));
		return;
	}
}