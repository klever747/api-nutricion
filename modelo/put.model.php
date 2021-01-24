<?php 
require_once "conection.php";

class PutModel{

	/*=============================================
		=Peticion PUT para editar datos=
	=============================================*/

	static public function putData($table, $data, $id, $nameId){
		
		$set = "";
		foreach ($data as $key => $value) {
			$set .= $key." = :".$key.",";
		}

		$set = substr($set, 0, -1); 
	
		$stmt = Connection::connect()->prepare("UPDATE $table SET $set
			WHERE $nameId = :$nameId ");

		foreach ($data as $key => $value) {
			$stmt -> bindParam(":".$key, $data[$key],PDO::PARAM_STR);

		}

		$stmt->bindParam(":".$nameId, $id, PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "The process was successfull";
		}else{
			return Connection::connect()->errorInfo();
		}
	}
}