<?php 

require_once "conection.php";

class GetModel{
	/*=============================================
	=Peticiones GET sin filtro =
	=============================================*/
	
	static public  function getData($table, $orderBy, $orderMode, $startAt,$endAt,$tabla_estado, $select){

		if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){

			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $tabla_estado ORDER BY $orderBy $orderMode");

		}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){

			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $tabla_estado.estado = 1 ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");

		}else{

			$stmt = Connection::connect()->prepare("SELECT $select FROM $table ");
		}

		$stmt -> execute();
		return $stmt -> fetchAll(PDO::FETCH_CLASS);
	}

	/*=============================================
	=Peticiones GET con filtro =
	=============================================*/
	
	static public  function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado, $select){

		if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){

			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $linkTo = :$linkTo AND  $tabla_estado.estado = 1 ORDER BY $orderBy $orderMode");

		}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){

			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $linkTo = :$linkTo AND $tabla_estado.estado = 1 ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");

		}else{


			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $linkTo = :$linkTo /*and $tabla_estado.estado =1 */");
			
		}

		$stmt -> bindParam(":".$linkTo,$equalTo, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetchAll(PDO::FETCH_CLASS);
	}

	/*=============================================
	=Peticiones GET tablas relacionadas sin filtro =
	=============================================*/

	static public function getRelData($rel, $type, $orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select){

		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);
		$tabla_estado = explode(",", $tabla_estado);

		/*=============================================
			=Condicion para que se relacionen 2 tablas=
		=============================================*/
		if (count($relArray) == 2 && count($typeArray) == 2) {

			$on1 = $relArray[0].".id_".$typeArray[1];  

			$on2 = $relArray[1].".id_".$typeArray[1];

			if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1 ORDER BY $orderBy $orderMode");

			}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1 ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");

			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1");
				
			}
		}



		/*=============================================
			=Condicion para que se relacionen 3 tablas=
		=============================================*/
		if (count($relArray) == 3 && count($typeArray) == 3) {

			$on1a = $relArray[0].".id_".$typeArray[0];  
			$on1b = $relArray[1].".id_".$typeArray[0];

			$on2a = $relArray[1].".id_".$typeArray[2];
			$on2b = $relArray[2].".id_".$typeArray[2];

			

			if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 ORDER BY $orderBy $orderMode");

			}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");

			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1");
			}
		}

		/*=============================================
			=Condicion para que se relacionen 4 tablas=
		=============================================*/
		if (count($relArray) == 4 && count($typeArray) == 4) {

			$cond1 ='';
			if(count($tabla_estado) == 1){
				$cond1 = $tabla_estado[0].".estado=1";
			}else if(count($tabla_estado) == 2){
				$cond1 = $tabla_estado[0].".estado=1 AND ".$tabla_estado[1].".estado=1";
			}
			$on1a = $relArray[0].".id_".$typeArray[0];  
			$on1b = $relArray[1].".id_".$typeArray[0];

			$on2a = $relArray[1].".id_".$typeArray[2];
			$on2b = $relArray[2].".id_".$typeArray[2];

			$on3a = $relArray[2].".id_".$typeArray[3];
			$on3b = $relArray[3].".id_".$typeArray[3];

			if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null ){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b WHERE $cond1   ORDER BY $orderBy $orderMode");

			}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null ){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b WHERE $tabla_estado.estado=1  ORDER BY $orderBy $orderMode LIMIT $starAt,$endAt");

			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b WHERE $tabla_estado.estado = 1");

			}
		}

		

		$stmt -> execute();
		return $stmt-> fetchAll(PDO::FETCH_CLASS);

	}
	

	/*=============================================
	=Peticiones GET tablas relacionadas con filtro =
	=============================================*/

	static public function getRelFilterData($rel, $type, $linkTo, $equalTo,$orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select){

		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);

		/*=============================================
			=Condicion para que se relacionen 2 tablas=
		=============================================*/
		if (count($relArray) == 2 && count($typeArray) == 2) {

			$on1 = $relArray[0].".id_".$typeArray[1];  

			$on2 = $relArray[1].".id_".$typeArray[1];

			if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null &&  $relArray[0] == 'monitoreo' && $relArray[1]=='paciente'){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado_paciente = 'estable' AND $relArray[1].$linkTo = :$linkTo ORDER BY $orderBy $orderMode");
				
			}else if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1 AND $relArray[0].$linkTo = :$linkTo ORDER BY $orderBy $orderMode");
								
			}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $linkTo = :$linkTo AND $tabla_estado.estado=1 ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");

			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1 AND $linkTo = :$linkTo");
				
				
			}


		}



		/*=============================================
			=Condicion para que se relacionen 3 tablas=
		=============================================*/
		if (count($relArray) == 3 && count($typeArray) == 3) {

			$on1a = $relArray[0].".id_".$typeArray[0];  
			$on1b = $relArray[1].".id_".$typeArray[0];

			$on2a = $relArray[1].".id_".$typeArray[2];
			$on2b = $relArray[2].".id_".$typeArray[2];

			$opcion1a = $relArray[1].".id_".$typeArray[1];
			$opcion1b = $relArray[2].".id_".$typeArray[1];

			

			//parte opcional para relacionar 3 tablas nutricionsita,paciente y users
			if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null &&  $relArray[0] == 'nutricionista' && $relArray[1]=='paciente' && $relArray[2]=='users'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 AND $relArray[0].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
				
				
			//parte opcional para relacionar 3 tablas users,nutricionista y paciente
			}else if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null &&  $relArray[0] == 'users' && $relArray[1]=='nutricionista' && $relArray[2]=='paciente'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[1] INNER JOIN $relArray[2] ON $relArray[1].id_nutricionista = $relArray[2].id_nutricionista INNER JOIN $relArray[0] ON $relArray[2].id_user = $relArray[0].id_user WHERE $tabla_estado.estado = 1 AND $relArray[2].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
					
			}else if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 AND $relArray[2].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
				
				
			}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 AND $relArray[2].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode LIMIT $starAt,$endAt");


			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 AND $relArray[2].$linkTo = :$linkTo");
				
			}
		}

		/*=============================================
			=Condicion para que se relacionen 4 tablas=
		=============================================*/

		if (count($relArray) == 4 && count($typeArray) == 4) {


			$on1a = $relArray[0].".id_".$typeArray[0];  
			$on1b = $relArray[1].".id_".$typeArray[0];

			$on2a = $relArray[1].".id_".$typeArray[1];
			$on2b = $relArray[2].".id_".$typeArray[1];

			$on3a = $relArray[2].".id_".$typeArray[3];
			$on3b = $relArray[3].".id_".$typeArray[3];

			//condiciones para los datos antropometricos
			$on1aE = $relArray[0].".id_encuesta";  
			$on1bE = $relArray[1].".id_encuesta";

			$on2aE = $relArray[1].".id_".$typeArray[2];
			$on2bE = $relArray[2].".id_".$typeArray[2];

			$on3aE = $relArray[2].".id_".$typeArray[3];
			$on3bE = $relArray[3].".id_".$typeArray[3];
			
			//parte opcional para relacionar 4 tablas users,nutricionsita,paciente y diagnostico
			if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null &&  $relArray[0] == 'users' && $relArray[1]=='nutricionista' && $relArray[2]=='paciente' && $relArray[3] == 'diagnostico'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[2] ON $on1a = $relArray[2].id_user INNER JOIN $relArray[1] ON $on2a  = $on2b INNER JOIN $relArray[3] ON $relArray[2].id_paciente = $relArray[3].id_paciente WHERE $tabla_estado.estado = 1 AND $relArray[1].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
			
			//metodo para traer un monitoreo especifico de un nutricionista 
			}else if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null &&  $relArray[0] == 'users' && $relArray[1]=='nutricionista' && $relArray[2]=='paciente' && $relArray[3] == 'monitoreo'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[2] ON $on1a = $relArray[2].id_user INNER JOIN $relArray[1] ON $on2a  = $on2b INNER JOIN $relArray[3] ON $relArray[2].id_paciente = $relArray[3].id_paciente WHERE $tabla_estado.estado = 1 AND $relArray[1].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");

			//metodo para traer un diagnostico especifico de un nutricionista 
			}else if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null &&  $relArray[0] == 'diagnostico' && $relArray[1] == 'paciente' && $relArray[2] =='nutricionista' && $relArray[3] == 'users'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $relArray[0].id_paciente = $relArray[1].id_paciente INNER JOIN $relArray[2] ON $relArray[1].id_nutricionista  = $relArray[2].id_nutricionista INNER JOIN $relArray[3] ON $relArray[1].id_user = $relArray[3].id_user WHERE $tabla_estado.estado = 1 AND $relArray[0].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
				
		//metodo para traer las encuestas de un nutricionista dado
			}else if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null &&  $relArray[0] == 'monitoreo' && $relArray[1] == 'paciente' && $relArray[2] =='nutricionista' && $relArray[3] == 'users'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $relArray[0].id_paciente = $relArray[1].id_paciente INNER JOIN $relArray[2] ON $relArray[1].id_nutricionista  = $relArray[2].id_nutricionista INNER JOIN $relArray[3] ON $relArray[1].id_user = $relArray[3].id_user WHERE $tabla_estado.estado = 1 AND $relArray[0].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
				
		//metodo para traer las encuestas de un nutricionista dado
			}else if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null &&  $relArray[0] == 'encuesta_abcd' && $relArray[1] == 'paciente' && $relArray[2] =='nutricionista' && $relArray[3] == 'users'){


				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[2] INNER JOIN $relArray[1] ON $relArray[2].id_nutricionista = $relArray[1].id_nutricionista INNER JOIN $relArray[3] ON $relArray[1].id_user  = $relArray[3].id_user INNER JOIN $relArray[0] ON $relArray[1].id_paciente = $relArray[0].id_paciente WHERE $tabla_estado.estado = 1 AND $relArray[2].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
			

			}else if($orderBy == null && $orderMode == null && $startAt == null && $endAt == null &&  $relArray[0] == 'antropometrico_paciente' && $relArray[1]=='encuesta_abcd' && $relArray[2]=='paciente' && $relArray[3]=='users'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1aE = $on1bE INNER JOIN $relArray[2] ON $on2aE = $on2bE INNER JOIN $relArray[3] ON $on3aE=$on3bE WHERE $tabla_estado.estado_encuesta = 'atendido' AND $relArray[0].$linkTo = :$linkTo ");
				

			}else if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null &&  $relArray[0] == 'menu_comida' && $relArray[1]=='nutri_paciente_menu' && $relArray[2]=='nutricionista' && $relArray[3]=='paciente'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $relArray[1].id_nutricionista = $relArray[2].id_nutricionista INNER JOIN $relArray[3] ON $relArray[1].id_paciente = $relArray[3].id_paciente WHERE $tabla_estado.estado = 1 AND $relArray[2].$linkTo = :$linkTo ");


			}else if($orderBy != null && $orderMode!= null){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b WHERE $tabla_estado.estado = 1 AND $linkTo = :$linkTo ORDER BY $orderBy $orderMode");
				
			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b WHERE $tabla_estado.estado = 1 AND $linkTo = :$linkTo");

			}
		}

		/*=============================================
			=Condicion para que se relacionen 5 tablas=
		=============================================*/
		if (count($relArray) == 5 && count($typeArray) == 5) {
			/*para poder utilizar la relaicon de 5 tablas es necesario especificar
			las tablas de estado para poder validar el estado de cada tabla que no este en 0
			y ademas colocar en el indice 0 el nombre de la tabla en la cual estemos relacionando el ID y queramos ordenar*/

			$tabla_estado = explode(",", $tabla_estado);


			if(count($tabla_estado) == 1){
				$cond1 = $tabla_estado[0].".estado=1";
			}else if(count($tabla_estado) == 2){
				$cond1 = $tabla_estado[0].".estado=1 AND ".$tabla_estado[1].".estado=1";
			}else if(count($tabla_estado) == 3){
				$cond1 = $tabla_estado[0].".estado=1 AND ".$tabla_estado[1].".estado=1 AND ".$tabla_estado[2].".estado=1";
			}if(count($tabla_estado) == 4){
				$cond1 = $tabla_estado[0].".estado=1 AND ".$tabla_estado[1].".estado=1 AND ".$tabla_estado[2].".estado=1 AND ".$tabla_estado[3].".estado=1";
			}
			$on1a = $relArray[0].".id_".$typeArray[1];  
			$on1b = $relArray[1].".id_".$typeArray[1];

			$on2a = $relArray[1].".id_".$typeArray[1];
			$on2b = $relArray[2].".id_".$typeArray[1];

			$on3a = $relArray[2].".id_".$typeArray[3];
			$on3b = $relArray[3].".id_".$typeArray[3];

			$on4a = $relArray[3].".id_".$typeArray[4];
			$on4b = $relArray[4].".id_".$typeArray[4];

			if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null &&  $relArray[0] == 'encuesta_abcd' && $relArray[1] == 'paciente' && $relArray[2] =='nutricionista' && $relArray[3] == 'users' /*&& $relArray[4] == 'antropometrico_paciente'*/){


				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[2] INNER JOIN $relArray[1] ON $relArray[2].id_nutricionista = $relArray[1].id_nutricionista INNER JOIN $relArray[3] ON $relArray[1].id_user  = $relArray[3].id_user INNER JOIN $relArray[0] ON $relArray[1].id_paciente = $relArray[0].id_paciente INNER JOIN $relArray[4] ON $relArray[4].id_encuesta = $relArray[0].id_encuesta WHERE  $relArray[0].$linkTo = :$linkTo  ORDER BY $orderBy $orderMode");
				


			}else if($orderBy != null && $orderMode!= null){
				
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b INNER JOIN $relArray[4] ON $on4a = $on4b WHERE $cond1 AND $relArray[3].$linkTo = :$linkTo ORDER BY $relArray[3].$orderBy $orderMode");
				/*
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $relArray[0].id_menu_comida = $relArray[1].id_menu_comida INNER JOIN $relArray[2] ON $relArray[2].id_menu_comida = $relArray[1].id_menu_comida INNER JOIN $relArray[3] ON $relArray[2].id_paciente = $relArray[3].id_paciente INNER JOIN $relArray[4] ON $relArray[2].id_nutricionista = $relArray[4].id_nutricionista WHERE $cond1 AND $relArray[3].$linkTo = :$linkTo ORDER BY $relArray[3].$orderBy $orderMode");
				*/
				
			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b INNER JOIN $relArray[4] ON $on4a = $on4b WHERE $cond1 AND $linkTo = :$linkTo");
			}
		}

		
		$stmt -> bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt-> fetchAll(PDO::FETCH_CLASS);

	}
	/*=============================================
	=Peticiones GET tablas relacionadas con filtro =
	=============================================*/

	static public function getRelFilterDataDate($rel, $type, $linkTo, $equalTo,$orderBy, $orderMode, $startAt, $endAt,$tabla_estado,$select,$fecha_ini,$fecha_fin){

		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);

		//parte opcional para relacionar 3 tablas somatotipo,antropometrico_paciente,encuesta_abcd
		if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null &&  $relArray[0] == 'somatotipo' && $relArray[1]=='antropometrico_paciente' && $relArray[2]=='encuesta_abcd'){
				
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $relArray[0].id_antropometrico = $relArray[1].id_antropometrico INNER JOIN $relArray[2] ON $relArray[1].id_encuesta = $relArray[2].id_encuesta WHERE $tabla_estado.estado_encuesta = 'atendido' AND $relArray[2].$linkTo = :$linkTo AND $relArray[2].date_create BETWEEN '$fecha_ini' AND '$fecha_fin' ORDER BY $orderBy $orderMode");
				
		}else if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null &&  $relArray[0] == 'bioquimico_paciente' && $relArray[1]=='encuesta_abcd'){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $relArray[0].id_encuesta = $relArray[1].id_encuesta  WHERE $tabla_estado.estado_encuesta = 'atendido' AND $relArray[1].$linkTo = :$linkTo AND $relArray[1].date_create BETWEEN '$fecha_ini' AND '$fecha_fin' ORDER BY $orderBy $orderMode");
				
		}


		
		$stmt -> bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt-> fetchAll(PDO::FETCH_CLASS);

	}

	/*=============================================
		peticiones GET para el buscador
	=============================================*/
	static public function getSearchData($table, $linkTo, $search,$orderBy, $orderMode,$startAt, $endAt,$tabla_estado,$select){

		if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){

			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%'");

		}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){
		
			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");
		}else{
			$stmt = Connection::connect()->prepare("SELECT $select FROM $table WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode ");
		}
		$stmt -> execute();
		
		return $stmt -> fetchAll(PDO::FETCH_CLASS);
	}

	/*=============================================
	 Peticiones GET para el buscador entre tablas relacionadas
	=============================================*/

	static public function getSearchRelData($rel, $type, $linkTo, $search, $orderBy, $orderMode,$startAt, $endAt,$tabla_estado,$select){

		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);

		
		/*=============================================
			=Condicion para que se relacionen 2 tablas=
		=============================================*/
		if (count($relArray) == 2 && count($typeArray) == 2) {

			$on1 = $relArray[0].".id_".$typeArray[1];  

			$on2 = $relArray[1].".id_".$typeArray[1];
			if($orderBy != null && $orderMode!= null && $startAt == null && $endAt == null){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode");
			}else if($orderBy != null && $orderMode!= null && $startAt != null && $endAt != null){

				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode LIMIT $startAt,$endAt");
			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2 WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%'");
			}

			

		}



		/*=============================================
			=Condicion para que se relacionen 3 tablas=
		=============================================*/
		if (count($relArray) == 3 && count($typeArray) == 3) {

			$on1a = $relArray[0].".id_".$typeArray[0];  
			$on1b = $relArray[1].".id_".$typeArray[0];

			$on2a = $relArray[1].".id_".$typeArray[2];
			$on2b = $relArray[2].".id_".$typeArray[2];


			if($orderBy != null && $orderMode!= null){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode");

				
			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%'");

			}
		}

		/*=============================================
			=Condicion para que se relacionen 4 tablas=
		=============================================*/
		if (count($relArray) == 4 && count($typeArray) == 4) {


			$on1a = $relArray[0].".id_".$typeArray[0];  
			$on1b = $relArray[1].".id_".$typeArray[0];

			$on2a = $relArray[1].".id_".$typeArray[1];
			$on2b = $relArray[2].".id_".$typeArray[1];

			$on3a = $relArray[2].".id_".$typeArray[3];
			$on3b = $relArray[3].".id_".$typeArray[3];

			

			if($orderBy != null && $orderMode!= null){
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b WHERE $tabla_estado.estado = 1 AND $linkTo LIKE '%$search%' ORDER BY $orderBy $orderMode");
			}else{
				$stmt = Connection::connect()->prepare("SELECT $select FROM $relArray[0] INNER JOIN $relArray[1] ON $on1a = $on1b INNER JOIN $relArray[2] ON $on2a = $on2b INNER JOIN $relArray[3] ON $on3a = $on3b WHERE $tabla_estado.estado = 1 AND LIKE '%$search%'");
			}
		}

		
		$stmt -> bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt-> fetchAll(PDO::FETCH_CLASS);

	}
}

