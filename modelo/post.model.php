<?php 
require_once "conection.php";


class PostModel{
/*=============================================
=Peticiones para tomar los nombres de las columnas=
=============================================*/

static public function getColumnsData($table, $database){

	return Connection::connect()->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema ='$database' AND table_name = '$table'")->fetchAll(PDO::FETCH_OBJ);

}
/*=============================================
=Peticiones para tomar los nombres de las columnas=
=============================================*/

static public function getColumnsDataProced($procedure, $database){

	return Connection::connect()->query("SELECT parameter_name AS item FROM information_schema.parameters WHERE SPECIFIC_NAME = '$procedure'")->fetchAll(PDO::FETCH_OBJ);

}
/*=============================================
=Peticiones POST para crear datos=
=============================================*/
static public function postData($table, $data){

		$columns = "(";
		$params  = "(";

		foreach ($data as $key => $value) {
			$columns .= $key.",";
			$params  .= ":".$key.",";
		}
		
		$columns =substr($columns, 0, -1);
		$params =substr($params, 0, -1);

		$columns .= ")"; 
		$params  .= ")";

		$stmt = Connection::connect() ->prepare("INSERT INTO $table $columns VALUES $params");

		foreach ($data as $key => $value) {
			$stmt -> bindParam(":".$key, $data[$key],PDO::PARAM_STR);

		}

		
		if($stmt ->execute()){

			return "The process was successful";
		}else{

			return Connection::connect()->errorInfo();
		}

}
/*=============================================
=Peticiones POST para crear datos del paciente=
=============================================*/
static public function postDataPaciente($table, $data){

		
		$count = 1; 
		   

		$stmt = Connection::connect() ->prepare("CALL insertar_paciente (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");

		foreach ($data as $key => $value) {
			$stmt -> bindParam("$count", $data[$key],PDO::PARAM_STR);
			$count ++;
			
		}


		if($stmt ->execute()){
			
			return "The process was successful";
		}else{

			return Connection::connect()->errorInfo();
		}

}
/*=============================================
 Peticiones POST para llamar procedimiento almacenado
=============================================*/
	public static function postDataProcedure($procedure, $data){
		$columns = "(";
		foreach ($data as $key => $value) {
			$columns .= "?,";
			//$params  .= ":".$key.",";
		}

		$columns =substr($columns, 0, -1);
		$columns .= ")"; 
		$count = 1; 
		$stmt = Connection::connect()->prepare("CALL $procedure $columns ; ");

		foreach ($data as $key => $value) {
			$stmt -> bindParam("$count", $data[$key],PDO::PARAM_STR);

			$count ++;
		}
		
	
		if($stmt->execute()){
			
			return "The process was successful";
		}else{

			return Connection::connect()->errorInfo();
		}
	}
}

