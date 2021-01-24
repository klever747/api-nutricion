<?php 

class RoutesController{
	/*=============================================
			=Ruta Principal=
	=============================================*/

	public function index(){
		include "rutas/route.php";
	}
	/*=============================================
			=Nombre de la base de datos=
	=============================================*/
	static public function db(){

		return "nutrition";
	}
}
?>
